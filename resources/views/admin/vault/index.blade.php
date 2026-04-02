@extends('admin.layouts.app')

@section('meta_description', 'إدارة الخزنة البحثية والملفات المحمية.')

@section('title', 'الخزنة البحثية')

@section('content')
    <div x-data="vaultModal()" class="max-w-7xl mx-auto pb-20">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
            <div>
                <h1 class="text-3xl font-black text-gray-900 tracking-tight flex items-center gap-3">
                    <div class="p-2.5 bg-yellow-50 text-yellow-600 rounded-xl">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    الخزنة البحثية
                </h1>
                <p class="text-gray-500 font-bold mt-2 text-sm">إدارة الملفات المحمية برقم سري والتي تظهر في تطبيق المستخدم.</p>
            </div>

            <button @click="openAdd()" type="button" class="cursor-pointer group flex items-center gap-2 px-6 py-3.5 bg-gray-900 text-white rounded-2xl font-black text-sm shadow-xl shadow-gray-900/30 hover:-translate-y-1 transition-all duration-300">
                <svg class="w-5 h-5 transition-transform group-hover:-translate-y-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                رفع ملف جديد
            </button>
        </div>

        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-50 overflow-hidden relative">
            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-right border-collapse table-fixed min-w-[800px]">
                    <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-6 py-5 text-xs font-black text-gray-500 uppercase tracking-wider text-center w-16">#</th>
                        <th class="px-6 py-5 text-xs font-black text-gray-500 uppercase tracking-wider w-1/3">اسم الملف</th>
                        <th class="px-6 py-5 text-xs font-black text-gray-500 uppercase tracking-wider text-center">النوع والحجم</th>
                        <th class="px-6 py-5 text-xs font-black text-gray-500 uppercase tracking-wider text-center">تاريخ الرفع</th>
                        <th class="px-6 py-5 text-xs font-black text-gray-500 uppercase tracking-wider text-center w-32">الإجراءات</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                    @forelse($files as $file)
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-6 py-5 text-center font-bold text-gray-500 align-middle">
                                {{ ($files->currentPage() - 1) * $files->perPage() + $loop->iteration }}
                            </td>

                            <td class="px-6 py-5 align-middle">
                                <p class="font-black text-gray-800 text-sm">{{ $file->title['ar'] ?? '' }}</p>
                                <p class="font-bold text-gray-400 text-xs mt-1" dir="ltr">{{ $file->title['en'] ?? '' }}</p>
                            </td>

                            <td class="px-6 py-5 text-center align-middle">
                                <span class="px-3 py-1 bg-yellow-50 text-yellow-700 rounded-lg text-xs font-black uppercase inline-block mb-1">{{ $file->file_type }}</span>
                                <span class="block text-xs font-bold text-gray-400" dir="ltr">{{ $file->file_size }}</span>
                            </td>

                            <td class="px-6 py-5 text-center font-bold text-gray-500 text-sm align-middle">
                                {{ $file->created_at->format('Y-m-d') }}
                            </td>

                            <td class="px-6 py-5 align-middle">
                                <div class="flex items-center justify-center gap-2 opacity-80 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ asset($file->file_path) }}" target="_blank" class="p-2.5 bg-blue-50 text-blue-500 hover:bg-blue-500 hover:text-white rounded-xl transition-colors" title="تحميل">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    </a>

                                    <form action="{{ route('admin.vault.destroy', $file->id) }}" method="POST" class="delete-form m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2.5 bg-red-50 text-red-500 hover:bg-red-500 hover:text-white rounded-xl transition-colors cursor-pointer" title="حذف الملف">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center opacity-50">
                                    <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                    <span class="text-lg font-black text-gray-500">الخزنة فارغة حالياً</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if($files->hasPages())
                <div class="p-6 border-t border-gray-50 bg-gray-50/30">
                    {{ $files->links() }}
                </div>
            @endif
        </div>

        <template x-teleport="body">
            <div x-show="isOpen" class="relative z-[99999]" aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display: none;">
                <div x-show="isOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-900/70 backdrop-blur-sm transition-opacity"></div>

                <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                        <div x-show="isOpen" @click.away="closeModal()" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="relative transform overflow-hidden rounded-[2.5rem] bg-white text-right shadow-2xl transition-all sm:my-8 w-full max-w-lg border border-gray-100 flex flex-col">

                            <div class="px-8 py-6 border-b border-gray-50 flex items-center justify-between bg-gray-50/50">
                                <h3 class="text-xl font-black text-gray-900">رفع ملف للخزنة</h3>
                                <button @click="closeModal()" type="button" class="p-2 text-gray-400 hover:text-red-500 bg-white hover:bg-red-50 rounded-xl shadow-sm transition-colors cursor-pointer border border-gray-100">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>

                            <form action="{{ route('admin.vault.store') }}" method="POST" enctype="multipart/form-data" class="p-8" @submit="isSubmitting = true">
                                @csrf

                                <div class="space-y-6">
                                    <div class="space-y-2 relative">
                                        <span class="absolute left-4 top-10 text-[10px] font-black text-primary bg-primary/10 px-2 py-1 rounded z-10">AR</span>
                                        <label class="block text-sm font-black text-gray-700">عنوان الملف (بالعربية) <span class="text-red-500">*</span></label>
                                        <input type="text" name="title[ar]" required placeholder="مثال: بحث الدكتوراة لعام 2024" class="w-full pl-14 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-primary/50 focus:ring-4 focus:ring-primary/10 transition-all font-bold text-gray-800">
                                    </div>

                                    <div class="space-y-2 relative" dir="ltr">
                                        <span class="absolute right-4 top-10 text-[10px] font-black text-gray-500 bg-gray-200 px-2 py-1 rounded z-10">EN</span>
                                        <label class="block text-sm font-black text-gray-700 text-right">File Title (English) <span class="text-red-500">*</span></label>
                                        <input type="text" name="title[en]" required placeholder="e.g: PhD Research 2024" class="w-full pr-14 pl-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-primary/50 focus:ring-4 focus:ring-primary/10 transition-all font-bold text-gray-800 text-left">
                                    </div>

                                    <div class="space-y-2">
                                        <label class="block text-sm font-black text-gray-700">الملف <span class="text-red-500">*</span></label>
                                        <input type="file" name="file" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-primary/50 transition-all font-bold text-gray-600 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-black file:bg-gray-900 file:text-white hover:file:bg-black cursor-pointer">
                                        <p class="text-xs font-bold text-gray-400 mt-2">مسموح بـ PDF, Word, Excel, PowerPoint, ZIP بحد أقصى 20 ميجا.</p>
                                    </div>
                                </div>

                                <div class="mt-8 flex items-center justify-end gap-3 pt-6 border-t border-gray-50">
                                    <button type="button" @click="closeModal()" class="px-6 py-3 text-gray-600 font-bold text-sm bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors cursor-pointer">إلغاء</button>

                                    <button type="submit" :disabled="isSubmitting" class="cursor-pointer flex items-center justify-center gap-2 px-8 py-3 bg-gray-900 text-white rounded-xl font-black text-sm shadow-lg shadow-gray-900/30 transition-all disabled:opacity-70 disabled:cursor-not-allowed hover:-translate-y-0.5">
                                        <span x-show="!isSubmitting">رفع الملف</span>
                                        <span x-show="isSubmitting" style="display: none;">جاري الرفع...</span>
                                        <svg x-show="isSubmitting" style="display: none;" class="w-4 h-4 animate-spin text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
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
        function vaultModal() {
            return {
                isOpen: false,
                isSubmitting: false,
                openAdd() {
                    this.isSubmitting = false;
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
