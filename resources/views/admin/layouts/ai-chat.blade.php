<div x-data="talaatChatbot()" class="cursor-pointer fixed bottom-6 left-6 z-[9999] font-['Cairo']">

    <button @click="toggleChat()" x-show="!isOpen" x-transition.scale.origin.bottom.left
            class="cursor-pointer w-16 h-16 bg-blue-900 text-white rounded-full shadow-2xl flex items-center justify-center hover:bg-blue-800 transition-colors focus:outline-none">
        <svg class="cursor-pointer w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
        </svg>
    </button>

    <div x-show="isOpen" x-transition.scale.origin.bottom.left style="display: none;"
         class="w-[350px] sm:w-[400px] h-[500px] bg-white rounded-2xl shadow-2xl flex flex-col overflow-hidden border border-gray-100">

        <div class="bg-blue-900 px-5 py-4 flex items-center justify-between shadow-md z-10">
            <div class="flex items-center gap-3">
                <div class="relative">
                    <div
                        class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-blue-900 font-black text-xl">
                        ط
                    </div>
                    <span
                        class="absolute bottom-0 left-0 w-3 h-3 bg-green-500 border-2 border-blue-900 rounded-full"></span>
                </div>
                <div>
                    <h3 class="text-white font-black text-lg leading-tight">طلعت AI</h3>
                    <p class="text-blue-200 text-xs font-bold">المساعد الذكي</p>
                </div>
            </div>
            <button @click="toggleChat()" class="cursor-pointer text-blue-200 hover:text-white transition-colors focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <div class="flex-1 p-4 overflow-y-auto bg-gray-50 flex flex-col gap-4" id="chat-messages">
            <div class="flex justify-start">
                <div
                    class="bg-white text-gray-800 px-4 py-3 rounded-2xl rounded-tr-none shadow-sm border border-gray-100 max-w-[85%] text-sm font-semibold leading-relaxed">
                    حياك الله طال عمرك! آنه «طلعت» المساعد الذكي، بشنو أقدر أساعدك اليوم؟
                </div>
            </div>

            <template x-for="(msg, index) in messages" :key="index">
                <div :class="msg.role === 'user' ? 'flex justify-end' : 'flex justify-start'">
                    <div
                        :class="msg.role === 'user' ? 'bg-blue-600 text-white rounded-tl-none' : 'bg-white text-gray-800 rounded-tr-none border border-gray-100'"
                        class="px-4 py-3 rounded-2xl shadow-sm max-w-[85%] text-sm font-semibold leading-relaxed"
                        x-html="formatMessage(msg.content)">
                    </div>
                </div>
            </template>

            <div x-show="isTyping" class="flex justify-start" style="display: none;">
                <div
                    class="bg-white px-4 py-3 rounded-2xl rounded-tr-none shadow-sm border border-gray-100 flex items-center gap-1">
                    <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"></span>
                    <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></span>
                    <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.4s"></span>
                </div>
            </div>
        </div>

        <div class="p-4 bg-white border-t border-gray-100">
            <form @submit.prevent="sendMessage" class="flex items-center gap-2 relative">
                <input type="text" x-model="newMessage" placeholder="اكتب رسالتك هنا..."
                       class="flex-1 bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 pr-12 font-semibold transition-all">
                <button type="submit" :disabled="!newMessage.trim() || isTyping"
                        class="cursor-pointer absolute left-2 top-1/2 -translate-y-1/2 p-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                    <svg class="cursor-pointer w-4 h-4 transform -rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</div>
<script>
    function talaatChatbot() {
        return {
            isOpen: false,
            newMessage: '',
            messages: [],
            isTyping: false,

            toggleChat() {
                this.isOpen = !this.isOpen;
            },

            async sendMessage() {
                if (!this.newMessage.trim()) return;

                const userText = this.newMessage;
                this.messages.push({role: 'user', content: userText});
                this.newMessage = '';
                this.isTyping = true;
                this.scrollToBottom();

                try {
                    const response = await fetch('/api/chat', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            message: userText,
                            history: this.messages.slice(0, -1)
                        })
                    });

                    const data = await response.json();

                    if (data.status) {
                        this.messages.push({role: 'assistant', content: data.data.reply});
                    } else {
                        let errorMsg = data.message || 'عذراً، حدث خطأ. يرجى المحاولة مرة أخرى.';
                        this.messages.push({role: 'assistant', content: errorMsg});
                    }
                } catch (error) {
                    this.messages.push({role: 'assistant', content: 'عذراً، لا يمكنني الاتصال بالخادم الآن.'});
                } finally {
                    this.isTyping = false;
                    this.scrollToBottom();
                }
            },

            scrollToBottom() {
                setTimeout(() => {
                    const container = document.getElementById('chat-messages');
                    container.scrollTop = container.scrollHeight;
                }, 100);
            },

            formatMessage(text) {
                return text.replace(/\n/g, '<br>');
            }
        }
    }
</script>
