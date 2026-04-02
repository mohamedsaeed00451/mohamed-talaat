@extends('admin.layouts.app')

@section('title', 'أنواع المقالات والأبحاث')

@section('content')
    <div x-data="articleTypeModal()" class="max-w-7xl mx-auto pb-20">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
            <div>
                <h1 class="text-3xl font-black text-gray-900 tracking-tight flex items-center gap-3">
                    <div class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    تصنيفات المقالات
                </h1>
                <p class="text-gray-500 font-bold mt-2 text-sm">إدارة الأقسام (الأوراق البيضاء، الأبحاث، الإيجازات، إلخ).</p>
            </div>

            <button @click="openAdd()" type="button" class="cursor-pointer group flex items-center gap-2 px-6 py-3.5 bg-primary text-white rounded-2xl font-black text-sm shadow-xl shadow-primary/30 hover:-translate-y-1 transition-all duration-300">
                <svg class="w-5 h-5 transition-transform group-hover:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                إضافة تصنيف جديد
            </button>
        </div>

        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-50 overflow-hidden relative">
            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-right border-collapse table-fixed min-w-[600px]">
                    <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-6 py-5 text-xs font-black text-gray-500 uppercase tracking-wider text-center w-16">#</th>
                        <th class="px-6 py-5 text-xs font-black text-gray-500 uppercase tracking-wider w-1/2">الاسم (عربي)</th>
                        <th class="px-6 py-5 text-xs font-black text-gray-500 uppercase tracking-wider text-left" dir="ltr">Name (English)</th>
                        <th class="px-6 py-5 text-xs font-black text-gray-500 uppercase tracking-wider text-center w-32">الإجراءات</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                    @forelse($types as $type)
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-6 py-5 text-center font-bold text-gray-500 align-middle">
                                {{ ($types->currentPage() - 1) * $types->perPage() + $loop->iteration }}
                            </td>

                            <td class="px-6 py-5 font-black text-gray-800 text-sm align-middle">
                                {{ $type->name['ar'] ?? '' }}
                            </td>

                            <td class="px-6 py-5 font-bold text-gray-600 text-sm text-left align-middle" dir="ltr">
                                {{ $type->name['en'] ?? '' }}
                            </td>

                            <td class="px-6 py-5 align-middle">
                                <div class="flex items-center justify-center gap-2 opacity-80 group-hover:opacity-100 transition-opacity">
                                    <button @click="openEdit({{ $type->id }}, '{{ addslashes($type->name['ar']) }}', '{{ addslashes($type->name['en']) }}')"
                                            class="p-2.5 bg-blue-50 text-blue-500 hover:bg-blue-500 hover:text-white rounded-xl transition-colors cursor-pointer" title="تعديل">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </button>

                                    <form action="{{ route('admin.article-types.destroy', $type->id) }}" method="POST" class="delete-form m-0">
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
                                <div class="opacity-40 flex flex-col items-center">
                                    <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                    <p class="font-black text-gray-500 text-lg">لا توجد تصنيفات حتى الآن</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            @if($types->hasPages())
                <div class="p-6 border-t border-gray-50 bg-gray-50/30">{{ $types->links() }}</div>
            @endif
        </div>

        <template x-teleport="body">
            <div x-show="isOpen" class="relative z-[99999]" style="display: none;">
                <div x-show="isOpen" x-transition.opacity class="fixed inset-0 bg-gray-900/70 backdrop-blur-sm"></div>
                <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                        <div x-show="isOpen" @click.away="closeModal()" x-transition.scale class="relative transform overflow-hidden rounded-[2.5rem] bg-white text-right shadow-2xl transition-all w-full max-w-lg border border-gray-100 flex flex-col">

                            <div class="px-8 py-6 border-b border-gray-50 flex items-center justify-between bg-gray-50/50">
                                <h3 class="text-xl font-black text-gray-900" x-text="isEdit ? 'تعديل التصنيف' : 'إضافة تصنيف جديد'"></h3>
                                <button @click="closeModal()" type="button" class="p-2 text-gray-400 hover:text-red-500 bg-white hover:bg-red-50 rounded-xl transition-colors cursor-pointer border border-gray-100">
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
                                        <span class="absolute left-4 top-10 text-[10px] font-black text-primary bg-primary/10 px-2 py-1 rounded">AR</span>
                                        <label class="block text-sm font-black text-gray-700">اسم التصنيف (بالعربية) <span class="text-red-500">*</span></label>
                                        <input type="text" name="name[ar]" x-model="formData.ar" required placeholder="مثال: الجيوسياسية" class="w-full pl-14 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl focus:bg-white focus:border-primary/50 focus:ring-4 focus:ring-primary/10 transition-all font-bold">
                                    </div>

                                    <div class="space-y-2 relative" dir="ltr">
                                        <span class="absolute right-4 top-10 text-[10px] font-black text-gray-500 bg-gray-200 px-2 py-1 rounded">EN</span>
                                        <label class="block text-sm font-black text-gray-700 text-right">Category Name (English) <span class="text-red-500">*</span></label>
                                        <input type="text" name="name[en]" x-model="formData.en" required placeholder="e.g: Geopolitical" class="w-full pr-14 pl-4 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl focus:bg-white focus:border-primary/50 focus:ring-4 focus:ring-primary/10 transition-all font-bold text-left">
                                    </div>
                                </div>

                                <div class="mt-8 flex items-center justify-end gap-3 pt-6 border-t border-gray-50">
                                    <button type="button" @click="closeModal()" class="px-6 py-3 text-gray-600 font-bold text-sm bg-gray-100 rounded-xl transition-colors cursor-pointer">إلغاء</button>
                                    <button type="submit" :disabled="isSubmitting" class="cursor-pointer flex items-center justify-center gap-2 px-8 py-3 bg-primary text-white rounded-xl font-black text-sm shadow-lg shadow-primary/30 transition-all disabled:opacity-70">
                                        <span x-show="!isSubmitting" x-text="isEdit ? 'حفظ التعديلات' : 'إضافة التصنيف'"></span>
                                        <span x-show="isSubmitting" style="display: none;">جاري الحفظ...</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>
@endsection

@section('scripts')
    <script>
        function articleTypeModal() {
            return {
                isOpen: false,
                isEdit: false,
                isSubmitting: false,
                formAction: '{{ route("admin.article-types.store") }}',
                baseUrl: '{{ url("admin/article-types") }}',
                formData: { ar: '', en: '' },

                openAdd() {
                    this.isEdit = false;
                    this.isSubmitting = false;
                    this.formAction = '{{ route("admin.article-types.store") }}';
                    this.formData = { ar: '', en: '' };
                    this.isOpen = true;
                },

                openEdit(id, nameAr, nameEn) {
                    this.isEdit = true;
                    this.isSubmitting = false;
                    this.formAction = this.baseUrl + '/' + id;
                    this.formData = { ar: nameAr, en: nameEn };
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
