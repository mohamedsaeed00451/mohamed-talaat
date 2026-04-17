@extends('admin.layouts.app')
@section('title', 'التحليلات')

@section('content')
    <div class="max-w-7xl mx-auto pb-20">

        <!-- Header & Top Buttons -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
            <div>
                <h1 class="text-3xl font-black text-gray-900 tracking-tight flex items-center gap-3">
                    <div class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                        </svg>
                    </div>
                    إدارة التحليلات
                </h1>
            </div>

            <div class="flex flex-wrap items-center gap-3">

                <a href="{{ route('admin.articles.bulk-ai') }}"
                   class="cursor-pointer group flex items-center gap-2 px-6 py-3.5 bg-gradient-to-r from-indigo-900 to-gray-800 text-white rounded-2xl font-black text-sm shadow-xl shadow-indigo-900/20 hover:-translate-y-1 hover:shadow-indigo-900/40 border border-indigo-700/50 transition-all duration-300">
                    <span class="text-xl group-hover:animate-bounce">🤖</span>
                    رفع متعدد بالـ AI
                </a>

                <a href="{{ route('admin.articles.create') }}"
                   class="cursor-pointer group flex items-center gap-2 px-6 py-3.5 bg-primary text-white rounded-2xl font-black text-sm shadow-xl shadow-primary/30 hover:-translate-y-1 hover:shadow-primary/40 transition-all duration-300">
                    <svg class="w-5 h-5 transition-transform group-hover:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                    </svg>
                    إضافة تحليل جديد
                </a>
            </div>
        </div>

        <!-- Articles Table -->
        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-50 overflow-hidden relative">
            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-right border-collapse table-fixed min-w-[1000px]">
                    <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-6 py-5 text-xs font-black text-gray-500 uppercase w-16 text-center">#</th>
                        <th class="px-6 py-5 text-xs font-black text-gray-500 uppercase w-20 text-center">الصورة</th>
                        <th class="px-6 py-5 text-xs font-black text-gray-500 uppercase w-1/4">العنوان</th>
                        <th class="px-6 py-5 text-xs font-black text-gray-500 uppercase text-center w-32">التصنيف</th>
                        <th class="px-6 py-5 text-xs font-black text-gray-500 uppercase text-center w-48">الحالة والإعدادات</th>
                        <th class="px-6 py-5 text-xs font-black text-gray-500 uppercase text-center w-44 sticky left-0 bg-gray-50 z-20 shadow-[-10px_0_15px_-3px_rgba(0,0,0,0.05)] border-r border-gray-100">
                            الإجراءات
                        </th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                    @forelse($articles as $article)
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-6 py-5 text-center font-bold text-gray-500 align-middle">{{ $loop->iteration }}</td>

                            <td class="px-6 py-5 align-middle text-center">
                                @if($article->image)
                                    <img src="{{ asset($article->image) }}" class="w-12 h-12 rounded-xl object-cover shadow-sm border border-gray-100 mx-auto">
                                @else
                                    <div class="w-12 h-12 rounded-xl bg-gray-50 border border-gray-100 flex items-center justify-center text-gray-400 mx-auto">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </td>

                            <td class="px-6 py-5 align-middle">
                                <p class="font-black text-gray-800 text-sm truncate">{{ $article->title['ar'] ?? '' }}</p>
                                <p class="font-bold text-gray-400 text-[10px] mt-2 flex items-center gap-1">
                                    @if(!$article->is_active)
                                        <span class="px-2 py-0.5 bg-gray-100 text-gray-600 rounded border border-gray-200 font-black">مسودة (غير مفعل) 📝</span>
                                    @elseif($article->published_at && \Carbon\Carbon::parse($article->published_at)->isFuture())
                                        <span class="px-2 py-0.5 bg-orange-50 text-orange-500 rounded border border-orange-100 font-black">مجدول: {{ \Carbon\Carbon::parse($article->published_at)->format('Y-m-d H:i') }} 📅</span>
                                    @else
                                        <span class="px-2 py-0.5 bg-green-50 text-green-500 rounded border border-green-100 font-black">منشور بالكامل 🚀</span>
                                    @endif
                                </p>
                            </td>

                            <td class="px-6 py-5 text-center align-middle">
                                <span class="px-3 py-1 bg-indigo-50 text-indigo-700 border border-indigo-100 rounded-lg text-[11px] font-black">{{ $article->type->name['ar'] ?? 'غير محدد' }}</span>
                            </td>

                            <td class="px-6 py-5 align-middle">
                                <div class="flex flex-col gap-2" x-data="articleStatus({{ $article->id }}, {{ $article->is_active ? 'true' : 'false' }}, {{ $article->is_featured ? 'true' : 'false' }}, {{ $article->is_old ? 'true' : 'false' }})">
                                    <label class="flex items-center justify-between cursor-pointer">
                                        <span class="text-[11px] font-black text-gray-600">مفعل</span>
                                        <div class="relative">
                                            <input type="checkbox" x-model="isActive" @change="toggle('is_active', isActive)" class="sr-only peer">
                                            <div class="w-8 h-4 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-3 after:w-3 after:transition-all peer-checked:bg-green-500"></div>
                                        </div>
                                    </label>

                                    <label class="flex items-center justify-between cursor-pointer">
                                        <span class="text-[11px] font-black text-gray-600">مميز</span>
                                        <div class="relative">
                                            <input type="checkbox" x-model="isFeatured" @change="toggle('is_featured', isFeatured)" class="sr-only peer">
                                            <div class="w-8 h-4 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-3 after:w-3 after:transition-all peer-checked:bg-yellow-500"></div>
                                        </div>
                                    </label>

                                    <label class="flex items-center justify-between cursor-pointer">
                                        <span class="text-[11px] font-black text-gray-600">أرشيف/قديم</span>
                                        <div class="relative">
                                            <input type="checkbox" x-model="isOld" @change="toggle('is_old', isOld)" class="sr-only peer">
                                            <div class="w-8 h-4 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-3 after:w-3 after:transition-all peer-checked:bg-gray-700"></div>
                                        </div>
                                    </label>
                                </div>
                            </td>

                            <td class="px-6 py-5 align-middle sticky left-0 bg-white group-hover:bg-gray-50 z-10 shadow-[-10px_0_15px_-3px_rgba(0,0,0,0.03)] border-r border-gray-50 transition-colors">

                                <div class="flex items-center justify-center gap-2" x-data>

                                    <button type="button"
                                            data-id="{{ $article->id }}"
                                            data-title="{{ $article->title['ar'] ?? 'هذا المقال' }}"
                                            @click="$dispatch('open-article-chat', { id: $el.dataset.id, title: $el.dataset.title })"
                                            title="اسأل AI عن المقال"
                                            class="cursor-pointer p-2.5 bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white rounded-xl transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                                        <span class="text-sm">🤖</span>
                                    </button>

                                    <a href="{{ route('admin.articles.edit', $article->id) }}"
                                       title="تعديل المقال"
                                       class="cursor-pointer p-2.5 bg-blue-50 text-blue-500 hover:bg-blue-500 hover:text-white rounded-xl transition-all duration-300 hover:shadow-lg hover:shadow-blue-500/30 hover:-translate-y-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>

                                    <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST" class="delete-form m-0">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                title="حذف المقال"
                                                class="cursor-pointer p-2.5 bg-red-50 text-red-500 hover:bg-red-500 hover:text-white rounded-xl transition-all duration-300 hover:shadow-lg hover:shadow-red-500/30 hover:-translate-y-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-20 text-center text-gray-400 font-bold text-lg">لا توجد تحليلات مسجلة</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            @if($articles->hasPages())
                <div class="p-6 border-t border-gray-50 bg-gray-50/30">{{ $articles->links() }}</div>
            @endif
        </div>


        <div x-data="articleChatModal()" @open-article-chat.window="openChat($event)">
            <div x-show="isOpen" style="display: none;" class="fixed inset-0 z-[9999] flex items-center justify-center px-4 font-['Cairo']">
                <div x-show="isOpen" x-transition.opacity @click="isOpen = false" class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm cursor-pointer"></div>

                <div x-show="isOpen" x-transition.scale.origin.bottom class="relative z-10 w-full max-w-lg bg-white rounded-[2rem] shadow-2xl flex flex-col overflow-hidden border border-gray-100 h-[600px] max-h-[85vh]">

                    <div class="bg-gradient-to-r from-indigo-900 to-blue-900 px-6 py-5 flex items-center justify-between shadow-md">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-white/10 rounded-full flex items-center justify-center text-2xl border border-white/20 shadow-inner">
                                🤖
                            </div>
                            <div>
                                <h3 class="text-white font-black text-lg">Talat AI</h3>
                                <p class="text-blue-200 text-xs font-bold truncate max-w-[200px]" x-text="`حول: ${articleTitle}`"></p>
                            </div>
                        </div>
                        <button @click="isOpen = false" class="text-white/70 hover:text-white bg-white/10 hover:bg-red-500 rounded-full p-2 transition-colors cursor-pointer">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <div class="flex-1 p-5 overflow-y-auto bg-gray-50 flex flex-col gap-4 custom-scrollbar" id="article-chat-messages">
                        <template x-for="(msg, index) in messages" :key="index">
                            <div :class="msg.role === 'user' ? 'flex justify-end' : 'flex justify-start'">
                                <div :class="msg.role === 'user' ? 'bg-indigo-600 text-white rounded-tl-none shadow-md' : 'bg-white text-gray-800 rounded-tr-none shadow-sm border border-gray-100'"
                                     class="px-5 py-3.5 rounded-2xl max-w-[85%] text-sm font-bold leading-relaxed"
                                     x-html="formatMessage(msg.content)">
                                </div>
                            </div>
                        </template>

                        <div x-show="isTyping" class="flex justify-start">
                            <div class="bg-white px-5 py-4 rounded-2xl rounded-tr-none shadow-sm border border-gray-100 flex items-center gap-1.5">
                                <span class="w-2.5 h-2.5 bg-indigo-400 rounded-full animate-bounce"></span>
                                <span class="w-2.5 h-2.5 bg-indigo-400 rounded-full animate-bounce" style="animation-delay: 0.15s"></span>
                                <span class="w-2.5 h-2.5 bg-indigo-400 rounded-full animate-bounce" style="animation-delay: 0.3s"></span>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 bg-white border-t border-gray-100">
                        <form @submit.prevent="sendMessage" class="flex items-center gap-2 relative">
                            <input type="text" x-model="newMessage" placeholder="اسأل عن أي شيء في المقال..."
                                   class="flex-1 bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block w-full p-4 pr-14 font-bold transition-all shadow-inner">
                            <button type="submit" :disabled="!newMessage.trim() || isTyping"
                                    class="absolute left-2 top-1/2 -translate-y-1/2 p-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed shadow-md cursor-pointer">
                                <svg class="w-5 h-5 transform -rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script>
        function articleChatModal() {
            return {
                isOpen: false,
                articleId: null,
                articleTitle: '',
                newMessage: '',
                messages: [],
                isTyping: false,

                openChat(e) {
                    this.articleId = e.detail.id;
                    this.articleTitle = e.detail.title;
                    this.messages = [
                        {role: 'assistant', content: `يا هلا بك! آنه قريت مقال "<span class="text-indigo-600">${this.articleTitle}</span>" ومستعد أجاوب على أي سؤال يخطر في بالك عنه طال عمرك. تفضل اسأل؟`}
                    ];
                    this.isOpen = true;
                    this.scrollToBottom();
                },

                async sendMessage() {
                    if (!this.newMessage.trim() || !this.articleId) return;

                    const userText = this.newMessage;
                    this.messages.push({role: 'user', content: userText});
                    this.newMessage = '';
                    this.isTyping = true;
                    this.scrollToBottom();

                    try {
                        const response = await fetch(`/api/articles/${this.articleId}/ask-ai`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                message: userText,
                                history: this.messages.slice(1, -1)
                            })
                        });

                        const data = await response.json();

                        if (data.status) {
                            this.messages.push({role: 'assistant', content: data.data.reply});
                        } else {
                            this.messages.push({role: 'assistant', content: data.message || 'عذراً، حدث خطأ. يرجى المحاولة مرة أخرى.'});
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
                        const container = document.getElementById('article-chat-messages');
                        if(container) container.scrollTop = container.scrollHeight;
                    }, 50);
                },

                formatMessage(text) {
                    return text.replace(/\n/g, '<br>');
                }
            }
        }

        function articleStatus(articleId, initialActive, initialFeatured, initialOld) {
            return {
                isActive: initialActive,
                isFeatured: initialFeatured,
                isOld: initialOld,

                toggle(field, state) {
                    let url = '{{ route("admin.articles.toggle", ":id") }}'.replace(':id', articleId);

                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.onmouseenter = Swal.stopTimer;
                            toast.onmouseleave = Swal.resumeTimer;
                        }
                    });

                    fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            field: field,
                            state: state
                        })
                    })
                        .then(response => {
                            if (!response.ok) {
                                this[field === 'is_active' ? 'isActive' : (field === 'is_featured' ? 'isFeatured' : 'isOld')] = !state;
                                Toast.fire({
                                    icon: 'error',
                                    title: 'حدث خطأ أثناء التحديث.',
                                    customClass: {popup: 'rounded-[1.5rem] shadow-xl border border-gray-100 font-["Cairo"]'}
                                });
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            Toast.fire({
                                icon: 'success',
                                title: data.message || 'تم التحديث بنجاح',
                                customClass: {popup: 'rounded-[1.5rem] shadow-xl border border-gray-100 font-["Cairo"]'}
                            });
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                }
            }
        }
    </script>
@endsection
