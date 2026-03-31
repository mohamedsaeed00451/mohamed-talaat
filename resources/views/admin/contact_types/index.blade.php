@extends('admin.layouts.app')

@section('meta_description', 'إدارة أنواع الرسائل لصفحة تواصل معنا.')

@section('title', 'أنواع الرسائل')

@section('style')
@endsection

@section('content')
    <div x-data="contactTypesModal()" class="max-w-7xl mx-auto pb-20">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
            <div>
                <h1 class="text-3xl font-black text-gray-900 tracking-tight flex items-center gap-3">
                    <div class="p-2.5 bg-blue-50 text-blue-500 rounded-xl">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                        </svg>
                    </div>
                    أنواع الرسائل
                </h1>
                <p class="text-gray-500 font-bold mt-2 text-sm">إدارة الأقسام والأنواع التي يختارها الزائر عند إرسال رسالة.</p>
            </div>

            <button @click="openAdd()" type="button" class="cursor-pointer group flex items-center gap-2 px-6 py-3.5 bg-primary text-white rounded-2xl font-black text-sm shadow-xl shadow-primary/30 hover:-translate-y-1 transition-all duration-300">
                <svg class="w-5 h-5 transition-transform group-hover:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                </svg>
                إضافة نوع جديد
            </button>
        </div>

        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-50 overflow-hidden relative">
            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-right border-collapse">
                    <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="px-6 py-5 text-xs font-black text-gray-400 uppercase tracking-wider w-20 text-center">#</th>
                        <th class="px-6 py-5 text-xs font-black text-gray-400 uppercase tracking-wider">الاسم (عربي)</th>
                        <th class="px-6 py-5 text-xs font-black text-gray-400 uppercase tracking-wider text-left" dir="ltr">Name (English)</th>
                        <th class="px-6 py-5 text-xs font-black text-gray-400 uppercase tracking-wider text-center w-40">الإجراءات</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                    @forelse($types as $type)
                        <tr class="hover:bg-gray-50/30 transition-colors group">
                            <td class="px-6 py-4 text-center font-bold text-gray-500">
                                {{ ($types->currentPage() - 1) * $types->perPage() + $loop->iteration }}
                            </td>
                            <td class="px-6 py-4 font-black text-gray-800">{{ $type->name['ar'] ?? '-' }}</td>
                            <td class="px-6 py-4 font-black text-gray-600 text-left" dir="ltr">{{ $type->name['en'] ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-3 opacity-80 group-hover:opacity-100 transition-opacity">
                                    <button @click="openEdit({{ $type->id }}, '{{ addslashes($type->name['ar']) }}', '{{ addslashes($type->name['en']) }}')"
                                            class="p-2.5 bg-blue-50 text-blue-500 hover:bg-blue-500 hover:text-white rounded-xl transition-colors cursor-pointer" title="تعديل">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>

                                    <form action="{{ route('admin.contact-types.destroy', $type->id) }}" method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2.5 bg-red-50 text-red-500 hover:bg-red-500 hover:text-white rounded-xl transition-colors cursor-pointer" title="حذف">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center opacity-50">
                                    <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                    </svg>
                                    <span class="text-lg font-black text-gray-500">لا يوجد أنواع مسجلة حالياً</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            @if($types->hasPages())
                <div class="p-6 border-t border-gray-50 bg-gray-50/30">
                    {{ $types->links() }}
                </div>
            @endif
        </div>

        <div x-show="isOpen" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center">
            <div x-show="isOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="absolute inset-0 bg-secondary/60 backdrop-blur-sm" @click="closeModal()"></div>

            <div x-show="isOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-8 scale-95" x-transition:enter-end="opacity-100 translate-y-0 scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 scale-100" x-transition:leave-end="opacity-0 translate-y-8 scale-95" class="relative w-full max-w-lg bg-white rounded-[2.5rem] shadow-2xl overflow-hidden m-4">

                <div class="px-8 py-6 border-b border-gray-50 flex items-center justify-between bg-gray-50/50">
                    <h3 class="text-xl font-black text-gray-900" x-text="isEdit ? 'تعديل نوع الرسالة' : 'إضافة نوع جديد'"></h3>
                    <button @click="closeModal()" type="button" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-xl transition-colors cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <form :action="formAction" method="POST" class="p-8" @submit="isSubmitting = true">
                    @csrf
                    <template x-if="isEdit">
                        <input type="hidden" name="_method" value="PUT">
                    </template>

                    <div class="space-y-6">
                        <div class="space-y-2 relative">
                            <span class="absolute left-4 top-10 text-[10px] font-black text-primary bg-primary/10 px-2 py-1 rounded z-10">AR</span>
                            <label class="block text-sm font-black text-gray-500">الاسم (بالعربية) <span class="text-red-500">*</span></label>
                            <input type="text" name="name[ar]" x-model="formData.ar" required placeholder="مثال: استفسار عام"
                                   class="w-full pl-14 pr-4 py-3 bg-gray-50 border-none rounded-xl focus:ring-4 focus:ring-primary/10 transition-all font-bold text-gray-800 shadow-inner">
                        </div>

                        <div class="space-y-2 relative" dir="ltr">
                            <span class="absolute right-4 top-10 text-[10px] font-black text-gray-400 bg-gray-200 px-2 py-1 rounded z-10">EN</span>
                            <label class="block text-sm font-black text-gray-500 text-right">Name (English) <span class="text-red-500">*</span></label>
                            <input type="text" name="name[en]" x-model="formData.en" required placeholder="e.g: General Inquiry"
                                   class="w-full pr-14 pl-4 py-3 bg-gray-50 border-none rounded-xl focus:ring-4 focus:ring-primary/10 transition-all font-bold text-gray-800 shadow-inner">
                        </div>
                    </div>

                    <div class="mt-8 flex items-center justify-end gap-3 pt-6 border-t border-gray-50">
                        <button type="button" @click="closeModal()" class="px-6 py-3 text-gray-500 font-bold text-sm hover:bg-gray-100 rounded-xl transition-colors cursor-pointer">
                            إلغاء
                        </button>
                        <button type="submit" :disabled="isSubmitting"
                                class="flex items-center justify-center gap-2 px-8 py-3 bg-primary text-white rounded-xl font-black text-sm shadow-lg shadow-primary/30 transition-all cursor-pointer disabled:opacity-70 disabled:cursor-not-allowed"
                                :class="!isSubmitting ? 'hover:-translate-y-0.5' : ''">

                            <span x-show="!isSubmitting">حفظ البيانات</span>

                            <span x-show="isSubmitting" style="display: none;">جاري الحفظ...</span>

                            <svg x-show="isSubmitting" style="display: none;" class="w-4 h-4 animate-spin text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script>
        function contactTypesModal() {
            return {
                isOpen: false,
                isEdit: false,
                isSubmitting: false,
                formAction: '{{ route("admin.contact-types.store") }}',
                baseUrl: '{{ url("admin/contact-types") }}',
                formData: {
                    ar: '',
                    en: ''
                },

                openAdd() {
                    this.isEdit = false;
                    this.isSubmitting = false;
                    this.formAction = '{{ route("admin.contact-types.store") }}';
                    this.formData.ar = '';
                    this.formData.en = '';
                    this.isOpen = true;
                },

                openEdit(id, nameAr, nameEn) {
                    this.isEdit = true;
                    this.isSubmitting = false;
                    this.formAction = this.baseUrl + '/' + id;
                    this.formData.ar = nameAr;
                    this.formData.en = nameEn;
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
