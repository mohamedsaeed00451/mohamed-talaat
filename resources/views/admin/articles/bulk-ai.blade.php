@extends('admin.layouts.app')
@section('title', 'الرفع المتعدد الذكي للتحليلات')

@section('content')
    <div class="max-w-5xl mx-auto pb-20">

        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('admin.articles.index') }}" class="p-2.5 bg-white text-gray-500 hover:text-primary rounded-xl shadow-sm border border-gray-100 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
            <div>
                <h1 class="text-2xl font-black text-gray-900">الرفع المتعدد بالذكاء الاصطناعي (Bulk Import)</h1>
                <p class="text-sm text-gray-500 font-bold mt-1">ارفع مجموعة من الملفات وسيقوم AI بتحليلها وحفظها كمسودات غير مفعلة.</p>
            </div>
        </div>

        <div class="bg-gradient-to-br from-indigo-900 to-gray-900 rounded-[2rem] shadow-xl p-8 md:p-10 relative overflow-hidden" x-data="bulkUpload()">
            <div class="absolute -right-10 -top-10 w-64 h-64 bg-primary/20 rounded-full blur-[60px] pointer-events-none"></div>

            <div class="relative z-10">

                <div class="space-y-6 mb-8" x-show="!isProcessing">
                    <div class="space-y-2">
                        <label class="block text-sm font-black text-white">اختر التصنيف الأساسي للمقالات <span class="text-red-400">*</span></label>
                        <select x-model="selectedType" class="w-full px-4 py-4 bg-white/10 border border-white/20 rounded-2xl focus:bg-white/20 focus:ring-4 focus:ring-primary/30 text-white font-black text-sm transition-all appearance-none">
                            <option value="" class="text-gray-900">-- حدد تصنيفاً لجميع المقالات المرفوعة --</option>
                            @foreach($types as $type)
                                <option value="{{ $type->id }}" class="text-gray-900">{{ $type->name['ar'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-black text-white">ارفع الملفات (PDF, Word, Images) <span class="text-red-400">*</span></label>
                        <div class="border-2 border-dashed border-white/30 rounded-2xl p-10 text-center bg-white/5 hover:bg-white/10 transition-all">
                            <input type="file" x-ref="fileInput" @change="updateFileList" multiple accept=".pdf,.doc,.docx,.png,.jpg,.jpeg" class="hidden" id="bulk-files">
                            <label for="bulk-files" class="cursor-pointer flex flex-col items-center justify-center space-y-3">
                                <div class="w-16 h-16 bg-white/10 rounded-full flex items-center justify-center text-white">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                </div>
                                <span class="text-white font-black">اضغط لاختيار مجموعة ملفات</span>
                                <span class="text-xs font-bold text-gray-400" x-text="files.length > 0 ? `تم اختيار ${files.length} ملفات` : 'يمكنك تحديد أكثر من ملف معاً'"></span>
                            </label>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4 border-t border-white/10">
                        <button type="button" @click="startProcessing" :disabled="files.length === 0 || !selectedType" class="cursor-pointer flex items-center gap-2 px-10 py-4 bg-primary text-white rounded-xl font-black shadow-lg hover:bg-blue-600 transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                            بدء المعالجة الذكية 🚀
                        </button>
                    </div>
                </div>

                <div x-show="isProcessing" style="display: none;" class="py-8">
                    <div class="text-center mb-8">
                        <div class="w-20 h-20 mx-auto bg-primary/20 rounded-full flex items-center justify-center mb-4">
                            <span class="text-4xl animate-bounce">🤖</span>
                        </div>
                        <h3 class="text-xl font-black text-white mb-2">جاري المعالجة بواسطة Talat AI</h3>
                        <p class="text-sm text-gray-400 font-bold">يرجى عدم إغلاق هذه الصفحة حتى تكتمل المعالجة بالكامل.</p>
                    </div>

                    <div class="bg-white/10 rounded-2xl p-6 mb-6">
                        <div class="flex justify-between text-sm font-black text-white mb-3">
                            <span>التقدم الكلي:</span>
                            <span x-text="`${currentIndex} / ${files.length}`"></span>
                        </div>
                        <div class="w-full bg-white/20 rounded-full h-3 mb-2 overflow-hidden">
                            <div class="bg-primary h-3 rounded-full transition-all duration-500" :style="`width: ${(currentIndex / files.length) * 100}%`"></div>
                        </div>
                    </div>

                    <div class="space-y-3 max-h-64 overflow-y-auto custom-scrollbar pr-2">
                        <template x-for="(log, index) in logs" :key="index">
                            <div class="p-4 rounded-xl border flex items-center gap-3 text-sm font-bold"
                                 :class="log.status === 'success' ? 'bg-green-500/10 border-green-500/30 text-green-400' : (log.status === 'error' ? 'bg-red-500/10 border-red-500/30 text-red-400' : 'bg-blue-500/10 border-blue-500/30 text-blue-400')">
                                <span x-show="log.status === 'loading'">
                                    <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                </span>
                                <span x-show="log.status === 'success'">✔️</span>
                                <span x-show="log.status === 'error'">❌</span>
                                <span x-text="log.message"></span>
                            </div>
                        </template>
                    </div>

                    <div class="mt-8 text-center" x-show="currentIndex === files.length && files.length > 0">
                        <a href="{{ route('admin.articles.index') }}" class="cursor-pointer inline-flex px-8 py-3 bg-white text-gray-900 hover:bg-gray-100 rounded-xl font-black transition-all">
                            العودة لقائمة التحليلات
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function bulkUpload() {
            return {
                selectedType: '',
                files: [],
                isProcessing: false,
                currentIndex: 0,
                logs: [],

                updateFileList() {
                    this.files = Array.from(this.$refs.fileInput.files);
                },

                async startProcessing() {
                    if(this.files.length === 0 || !this.selectedType) return;

                    this.isProcessing = true;
                    this.currentIndex = 0;
                    this.logs = [];

                    for (let i = 0; i < this.files.length; i++) {
                        const file = this.files[i];

                        this.logs.unshift({ status: 'loading', message: `جاري قراءة وتحليل: ${file.name}...` });

                        const formData = new FormData();
                        formData.append('file', file);
                        formData.append('article_type_id', this.selectedType);

                        try {
                            const response = await fetch("{{ route('admin.articles.bulk-process') }}", {
                                method: "POST",
                                headers: {
                                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                                    "Accept": "application/json"
                                },
                                body: formData
                            });

                            const data = await response.json();

                            if(response.ok && data.success) {
                                this.logs[0] = { status: 'success', message: `تم الحفظ بنجاح كمسودة: ${data.title}` };
                            } else {
                                throw new Error(data.error || 'خطأ غير معروف من الذكاء الاصطناعي');
                            }
                        } catch (error) {
                            this.logs[0] = { status: 'error', message: `فشل معالجة (${file.name}): ${error.message}` };
                        }

                        this.currentIndex++;
                    }

                    Swal.fire({
                        icon: 'success',
                        title: 'اكتملت العملية',
                        text: 'تمت معالجة جميع الملفات وحفظها كمسودات غير مفعلة بنجاح.',
                        confirmButtonText: 'حسناً',
                        customClass: {popup: 'rounded-[1.5rem] shadow-xl border border-gray-100 font-["Cairo"]'}
                    });
                }
            }
        }
    </script>
@endsection
