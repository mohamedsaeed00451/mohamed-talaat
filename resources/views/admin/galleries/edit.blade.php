@extends('admin.layouts.app')
@section('title', 'تعديل الألبوم')

@section('content')
    <div class="max-w-6xl mx-auto pb-20">
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('admin.galleries.index') }}"
               class="p-2.5 bg-white text-gray-500 hover:text-primary rounded-xl shadow-sm border border-gray-100 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
            <h1 class="text-2xl font-black text-gray-900">تعديل: {{ $gallery->title['ar'] ?? '' }}</h1>
        </div>

        <form action="{{ route('admin.galleries.update', $gallery->id) }}" method="POST" enctype="multipart/form-data"
              x-data="{ isSubmitting: false }" @submit="isSubmitting = true"
              class="bg-white rounded-[2rem] shadow-sm border border-gray-50 p-8 md:p-10 space-y-8">
            @csrf @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2 relative">
                    <span
                        class="absolute left-4 top-10 text-[10px] font-black text-primary bg-primary/10 px-2 py-1 rounded">AR</span>
                    <label class="block text-sm font-black text-gray-700">عنوان الألبوم (بالعربية) <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="title[ar]" value="{{ $gallery->title['ar'] }}" required
                           class="w-full pl-14 pr-4 py-3 bg-gray-50 border border-gray-100 rounded-xl font-bold">
                </div>
                <div class="space-y-2 relative" dir="ltr">
                    <span
                        class="absolute right-4 top-10 text-[10px] font-black text-gray-500 bg-gray-200 px-2 py-1 rounded">EN</span>
                    <label class="block text-sm font-black text-gray-700 text-right">Gallery Title <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="title[en]" value="{{ $gallery->title['en'] }}" required
                           class="w-full pr-14 pl-4 py-3 bg-gray-50 border border-gray-100 rounded-xl font-bold text-left">
                </div>
            </div>

            <div class="space-y-2 p-6 bg-gray-50 rounded-2xl border border-gray-100">
                <label class="block text-sm font-black text-gray-800 mb-2">🖼️ إضافة صور جديدة للألبوم</label>
                <input type="file" name="images[]" accept="image/*" multiple
                       class="w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-black file:bg-gray-800 file:text-white cursor-pointer hover:file:bg-black mt-2">
            </div>

            @if($gallery->images && count($gallery->images) > 0)
                <div class="mt-6 border-t border-gray-100 pt-6">
                    <label class="block text-sm font-black text-gray-800 mb-4">الصور الحالية
                        ({{ count($gallery->images) }}):</label>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                        @foreach($gallery->images as $index => $imagePath)
                            <div
                                class="relative group rounded-xl overflow-hidden shadow-sm border border-gray-100 aspect-square">
                                <img src="{{ asset($imagePath) }}" class="w-full h-full object-cover">
                                <button type="button"
                                        onclick="
            Swal.mixin({
                customClass: {
                    popup: 'rounded-[2rem] shadow-2xl p-6 font-[\'Cairo\']',
                    actions: 'flex gap-4 w-full justify-center mt-6',
                    confirmButton: 'rounded-xl px-8 py-3 bg-red-500 text-white font-black cursor-pointer hover:bg-red-600 transition-colors',
                    cancelButton: 'rounded-xl px-8 py-3 bg-gray-100 text-gray-700 font-bold cursor-pointer hover:bg-gray-200 transition-colors'
                },
                buttonsStyling: false
                            }).fire({
                                title: 'هل أنت متأكد؟',
                                text: 'سيتم حذف الصورة نهائياً!',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'احذفها',
                                cancelButtonText: 'إلغاء',
                                reverseButtons: true
                            })
                            .then((r) => { if (r.isConfirmed) document.getElementById('delete-img-{{ $index }}').submit(); });
                        "
                                        class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity p-1.5 bg-red-500 text-white rounded-lg hover:bg-red-600 shadow-md cursor-pointer z-10">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="pt-6 border-t border-gray-50 flex justify-end">
                <button type="submit" :disabled="isSubmitting"
                        class="flex items-center gap-2 px-10 py-4 bg-primary text-white rounded-xl font-black shadow-lg shadow-primary/30 disabled:opacity-70">
                    <span x-show="!isSubmitting">حفظ التعديلات</span>
                    <span x-show="isSubmitting" style="display:none;">جاري الرفع...</span>
                </button>
            </div>
        </form>

        @if($gallery->images)
            @foreach($gallery->images as $index => $imagePath)
                <form id="delete-img-{{ $index }}" action="{{ route('admin.galleries.deleteImage', $gallery->id) }}"
                      method="POST" style="display: none;">
                    @csrf @method('DELETE') <input type="hidden" name="image_path" value="{{ $imagePath }}">
                </form>
            @endforeach
        @endif
    </div>
@endsection
