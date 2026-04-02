@extends('admin.layouts.app')

@section('meta_description', 'إدارة الاستشهادات وآراء العملاء.')

@section('title', 'الاستشهادات')

@section('content')
    <div x-data="testimonialsModal()" class="max-w-7xl mx-auto pb-20">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
            <div>
                <h1 class="text-3xl font-black text-gray-900 tracking-tight flex items-center gap-3">
                    <div class="p-2.5 bg-emerald-50 text-emerald-500 rounded-xl">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                    الاستشهادات
                </h1>
                <p class="text-gray-500 font-bold mt-2 text-sm">إدارة النصوص والاقتباسات التي تظهر في واجهة الموقع.</p>
            </div>

            <button @click="openAdd()" type="button" class="cursor-pointer group flex items-center gap-2 px-6 py-3.5 bg-primary text-white rounded-2xl font-black text-sm shadow-xl shadow-primary/30 hover:-translate-y-1 transition-all duration-300">
                <svg class="w-5 h-5 transition-transform group-hover:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                </svg>
                إضافة استشهاد جديد
            </button>
        </div>

        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-50 overflow-hidden relative">
            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-right border-collapse">
                    <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-6 py-4 text-xs font-black text-gray-500 uppercase tracking-wider text-center w-16">#</th>
                        <th class="px-6 py-4 text-xs font-black text-gray-500 uppercase tracking-wider">النص (عربي)</th>
                        <th class="px-6 py-4 text-xs font-black text-gray-500 uppercase tracking-wider text-left" dir="ltr">Text (English)</th>
                        <th class="px-6 py-4 text-xs font-black text-gray-500 uppercase tracking-wider text-center w-32">الإجراءات</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                    @forelse($testimonials as $testimonial)
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-6 py-4 text-center font-bold text-gray-500 align-top">
                                {{ ($testimonials->currentPage() - 1) * $testimonials->perPage() + $loop->iteration }}
                            </td>

                            <td class="px-6 py-4 font-bold text-gray-700 text-sm leading-relaxed align-top">
                                {{ Str::limit($testimonial->text['ar'] ?? '', 100) }}
                            </td>

                            <td class="px-6 py-4 font-bold text-gray-600 text-sm leading-relaxed text-left align-top" dir="ltr">
                                {{ Str::limit($testimonial->text['en'] ?? '', 100) }}
                            </td>

                            <td class="px-6 py-4 align-top">
                                <div class="flex items-center justify-center gap-2 opacity-80 group-hover:opacity-100 transition-opacity">
                                    <button @click="openEdit({{ $testimonial->id }}, '{{ addslashes($testimonial->text['ar']) }}', '{{ addslashes($testimonial->text['en']) }}')"
                                            class="p-2.5 bg-blue-50 text-blue-500 hover:bg-blue-500 hover:text-white rounded-xl transition-colors cursor-pointer" title="تعديل">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </button>

                                    <form action="{{ route('admin.testimonials.destroy', $testimonial->id) }}" method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2.5 bg-red-50 text-red-500 hover:bg-red-500 hover:text-white rounded-xl transition-colors cursor-pointer" title="حذف">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center opacity-50">
                                    <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                    </svg>
                                    <span class="text-lg font-black text-gray-500">لا توجد استشهادات حتى الآن</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if($testimonials->hasPages())
                <div class="p-6 border-t border-gray-50 bg-gray-50/30">
                    {{ $testimonials->links() }}
                </div>
            @endif
        </div>

        <template x-teleport="body">
            <div x-show="isOpen" style="display: none;" class="fixed inset-0 z-[99999] overflow-y-auto">
                <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">

                    <div x-show="isOpen" x-transition.opacity.duration.300ms class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" @click="closeModal()"></div>

                    <div x-show="isOpen"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                         class="relative w-full max-w-2xl transform overflow-hidden rounded-[2rem] bg-white text-right align-middle shadow-2xl transition-all sm:my-8 flex flex-col max-h-[90vh]">

                        <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between bg-gray-50/50 shrink-0">
                            <h3 class="text-xl font-black text-gray-900" x-text="isEdit ? 'تعديل الاستشهاد' : 'إضافة استشهاد جديد'"></h3>
                            <button @click="closeModal()" type="button" class="p-2 text-gray-400 hover:text-red-500 bg-white hover:bg-red-50 rounded-xl shadow-sm transition-colors cursor-pointer border border-gray-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>

                        <form :action="formAction" method="POST" class="p-6 md:p-8 overflow-y-auto custom-scrollbar" @submit="isSubmitting = true">
                            @csrf
                            <template x-if="isEdit">
                                <input type="hidden" name="_method" value="PUT">
                            </template>

                            <div class="space-y-6">
                                <div class="space-y-2">
                                    <label class="flex items-center justify-between text-sm font-black text-gray-700">
                                        <span>النص (بالعربية) <span class="text-red-500">*</span></span>
                                        <span class="text-[10px] font-black text-primary bg-primary/10 px-2 py-1 rounded">AR</span>
                                    </label>
                                    <textarea name="text[ar]" x-model="formData.ar" rows="4" required placeholder="اكتب النص هنا..."
                                              class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-primary/50 focus:ring-4 focus:ring-primary/10 transition-all font-bold text-gray-800 resize-none"></textarea>
                                </div>

                                <div class="space-y-2" dir="ltr">
                                    <label class="flex items-center justify-between text-sm font-black text-gray-700 text-left">
                                        <span>Text (English) <span class="text-red-500">*</span></span>
                                        <span class="text-[10px] font-black text-gray-500 bg-gray-200 px-2 py-1 rounded">EN</span>
                                    </label>
                                    <textarea name="text[en]" x-model="formData.en" rows="4" required placeholder="Type the text here..."
                                              class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-primary/50 focus:ring-4 focus:ring-primary/10 transition-all font-bold text-gray-800 resize-none"></textarea>
                                </div>
                            </div>

                            <div class="mt-8 flex items-center justify-end gap-3 pt-6 border-t border-gray-50">
                                <button type="button" @click="closeModal()" class="px-6 py-3 text-gray-600 font-bold text-sm bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors cursor-pointer">
                                    إلغاء
                                </button>

                                <button type="submit" :disabled="isSubmitting"
                                        class="flex items-center justify-center gap-2 px-8 py-3 bg-primary text-white rounded-xl font-black text-sm shadow-lg shadow-primary/30 transition-all disabled:opacity-70 disabled:cursor-not-allowed"
                                        :class="!isSubmitting ? 'hover:-translate-y-0.5' : ''">
                                    <span x-show="!isSubmitting">حفظ البيانات</span>
                                    <span x-show="isSubmitting" style="display: none;">جاري الحفظ...</span>
                                    <svg x-show="isSubmitting" style="display: none;" class="w-4 h-4 animate-spin text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </template>
    </div>
@endsection

@section('scripts')
    <script>
        function testimonialsModal() {
            return {
                isOpen: false,
                isEdit: false,
                isSubmitting: false,
                formAction: '{{ route("admin.testimonials.store") }}',
                baseUrl: '{{ url("admin/testimonials") }}',
                formData: {
                    ar: '',
                    en: ''
                },

                openAdd() {
                    this.isEdit = false;
                    this.isSubmitting = false;
                    this.formAction = '{{ route("admin.testimonials.store") }}';
                    this.formData.ar = '';
                    this.formData.en = '';
                    this.isOpen = true;
                },

                openEdit(id, textAr, textEn) {
                    this.isEdit = true;
                    this.isSubmitting = false;
                    this.formAction = this.baseUrl + '/' + id;
                    this.formData.ar = textAr;
                    this.formData.en = textEn;
                    this.isOpen = true;
                },

                closeModal() {
                    this.isOpen = false;
                    this.isSubmitting = false;
                }
            }
        }
    </script>
@endsection
