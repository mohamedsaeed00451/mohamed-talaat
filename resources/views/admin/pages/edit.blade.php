@extends('admin.layouts.app')

@section('title', 'تعديل صفحة')

@section('content')
    <div class="max-w-6xl mx-auto pb-20">

        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('admin.pages.index') }}" class="p-2.5 bg-white text-gray-500 hover:text-primary rounded-xl shadow-sm border border-gray-100 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
            <h1 class="text-2xl font-black text-gray-900">تعديل: {{ $page->title['ar'] ?? '' }}</h1>
        </div>

        <form action="{{ route('admin.pages.update', $page->id) }}" method="POST" enctype="multipart/form-data" x-data="{ isSubmitting: false }" @submit="isSubmitting = true" class="bg-white rounded-[2rem] shadow-sm border border-gray-50 p-8 md:p-10 space-y-8">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2 relative">
                    <span class="absolute left-4 top-10 text-[10px] font-black text-primary bg-primary/10 px-2 py-1 rounded">AR</span>
                    <label class="block text-sm font-black text-gray-700">عنوان الصفحة (بالعربية) <span class="text-red-500">*</span></label>
                    <input type="text" name="title[ar]" value="{{ old('title.ar', $page->title['ar'] ?? '') }}" required class="w-full pl-14 pr-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:bg-white focus:border-primary/50 focus:ring-4 focus:ring-primary/10 transition-all font-bold text-gray-800">
                </div>

                <div class="space-y-2 relative" dir="ltr">
                    <span class="absolute right-4 top-10 text-[10px] font-black text-gray-500 bg-gray-200 px-2 py-1 rounded">EN</span>
                    <label class="block text-sm font-black text-gray-700 text-right">Page Title (English) <span class="text-red-500">*</span></label>
                    <input type="text" name="title[en]" value="{{ old('title.en', $page->title['en'] ?? '') }}" required class="w-full pr-14 pl-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:bg-white focus:border-primary/50 focus:ring-4 focus:ring-primary/10 transition-all font-bold text-gray-800 text-left">
                </div>

                <div class="space-y-2 md:col-span-2 relative" dir="ltr">
                    <label class="block text-sm font-black text-gray-700 text-right">URL Slug <span class="text-red-500">*</span></label>
                    <div class="flex">
                        <span class="inline-flex items-center px-4 rounded-l-xl border border-r-0 border-gray-200 bg-gray-100 text-gray-500 font-bold text-sm">{{ url('/') }}/</span>
                        <input type="text" name="slug" value="{{ old('slug', $page->slug) }}" required class="flex-1 w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-r-xl focus:bg-white focus:border-primary/50 focus:ring-4 focus:ring-primary/10 transition-all font-bold text-blue-600 text-left">
                    </div>
                </div>
            </div>

            <div class="space-y-8 pt-8 border-t border-gray-50">
                <div class="space-y-2">
                    <label class="flex items-center justify-between text-sm font-black text-gray-700">
                        <span>المحتوى (بالعربية) <span class="text-red-500">*</span></span>
                        <span class="text-[10px] font-black text-primary bg-primary/10 px-2 py-1 rounded">AR</span>
                    </label>
                    <textarea name="content[ar]" rows="8" required class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:bg-white focus:border-primary/50 focus:ring-4 focus:ring-primary/10 transition-all font-semibold text-gray-800 leading-loose">{{ old('content.ar', $page->content['ar'] ?? '') }}</textarea>
                </div>

                <div class="space-y-2" dir="ltr">
                    <label class="flex items-center justify-between text-sm font-black text-gray-700">
                        <span>Content (English) <span class="text-red-500">*</span></span>
                        <span class="text-[10px] font-black text-gray-500 bg-gray-200 px-2 py-1 rounded">EN</span>
                    </label>
                    <textarea name="content[en]" rows="8" required class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:bg-white focus:border-primary/50 focus:ring-4 focus:ring-primary/10 transition-all font-semibold text-gray-800 leading-loose text-left">{{ old('content.en', $page->content['en'] ?? '') }}</textarea>
                </div>
            </div>

            <div class="space-y-6 pt-8 border-t border-gray-50">
                <h3 class="text-lg font-black text-primary">المرفقات (اختياري)</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2 p-4 bg-gray-50 rounded-2xl border border-gray-100 relative">
                        <label class="block text-sm font-black text-gray-800 mb-2">📄 ملف PDF مرفق</label>
                        @if($page->pdf_file)
                            <a href="{{ asset($page->pdf_file) }}" target="_blank" class="absolute top-4 left-4 text-[10px] font-bold bg-green-100 text-green-700 px-2 py-1 rounded-lg hover:bg-green-200 transition-colors">ملف موجود ✔️</a>
                        @endif
                        <input type="file" name="pdf_file" accept=".pdf" class="w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-black file:bg-primary file:text-white cursor-pointer mt-2">
                    </div>

                    <div class="space-y-2 p-4 bg-gray-50 rounded-2xl border border-gray-100">
                        <label class="block text-sm font-black text-gray-800 mb-2">🖼️ إضافة صور جديدة للصفحة (Gallery)</label>
                        <input type="file" name="images[]" accept="image/*" multiple class="w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-black file:bg-gray-800 file:text-white cursor-pointer hover:file:bg-black transition-colors mt-2">
                        <p class="text-[10px] text-gray-400 font-bold mt-2">يمكنك تحديد أكثر من صورة، وستتم إضافتها للصور الحالية.</p>
                    </div>
                </div>
            </div>

            @if($page->images && count($page->images) > 0)
                <div class="mt-6 border-t border-gray-100 pt-6">
                    <label class="block text-sm font-black text-gray-800 mb-4">الصور الحالية المرفوعة للصفحة:</label>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                        @foreach($page->images as $index => $imagePath)
                            <div class="relative group rounded-xl overflow-hidden shadow-sm border border-gray-100 aspect-square">
                                <img src="{{ asset($imagePath) }}" class="w-full h-full object-cover">
                                <button type="button"
                                        onclick="
                                            Swal.mixin({
                                                customClass: {
                                                    popup: 'rounded-[2rem] shadow-2xl border border-gray-100 p-6 font-[\'Cairo\']',
                                                    title: 'text-2xl font-black text-gray-800',
                                                    htmlContainer: 'text-gray-500 font-bold',
                                                    actions: 'flex gap-4 w-full justify-center mt-8',
                                                    confirmButton: 'cursor-pointer flex items-center justify-center gap-2 rounded-xl px-8 py-3.5 font-black bg-red-500 text-white shadow-lg shadow-red-500/30 hover:-translate-y-1 transition-all',
                                                    cancelButton: 'cursor-pointer rounded-xl px-8 py-3.5 font-bold border border-gray-200 bg-gray-50 text-gray-700 shadow-sm hover:bg-gray-200 transition-all'
                                                },
                                                buttonsStyling: false
                                            }).fire({
                                                title: 'هل أنت متأكد؟',
                                                text: 'لن تتمكن من استرجاع الصورة بعد حذفها!',
                                                icon: 'warning',
                                                showCancelButton: true,
                                                confirmButtonText: 'نعم، احذفها!',
                                                cancelButtonText: 'إلغاء',
                                                reverseButtons: true
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    document.getElementById('delete-img-{{ $index }}').submit();
                                                }
                                            });
                                        "
                                        class="absolute top-2 right-2 m-0 opacity-0 group-hover:opacity-100 transition-opacity p-1.5 bg-red-500 text-white rounded-lg hover:bg-red-600 shadow-md cursor-pointer z-10">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="pt-6 border-t border-gray-50 flex justify-end">
                <button type="submit" :disabled="isSubmitting" class="cursor-pointer flex items-center justify-center gap-2 px-10 py-4 bg-primary text-white rounded-xl font-black text-base shadow-lg shadow-primary/30 transition-all disabled:opacity-70 disabled:cursor-not-allowed hover:-translate-y-0.5">
                    <span x-show="!isSubmitting">حفظ التعديلات</span>
                    <span x-show="isSubmitting" style="display: none;">جاري الحفظ والرفع...</span>
                    <svg x-show="isSubmitting" style="display: none;" class="w-5 h-5 animate-spin text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                </button>
            </div>
        </form>

        @if($page->images && count($page->images) > 0)
            @foreach($page->images as $index => $imagePath)
                <form id="delete-img-{{ $index }}" action="{{ route('admin.pages.deleteImage', $page->id) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="image_path" value="{{ $imagePath }}">
                </form>
            @endforeach
        @endif

    </div>
@endsection
