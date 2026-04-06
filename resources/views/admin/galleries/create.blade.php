@extends('admin.layouts.app')
@section('title', 'إنشاء ألبوم جديد')

@section('content')
    <div class="max-w-6xl mx-auto pb-20">
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('admin.galleries.index') }}" class="p-2.5 bg-white text-gray-500 hover:text-primary rounded-xl shadow-sm border border-gray-100 transition-colors"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"></path></svg></a>
            <h1 class="text-2xl font-black text-gray-900">إنشاء ألبوم جديد</h1>
        </div>

        <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data" x-data="{ isSubmitting: false }" @submit="isSubmitting = true" class="bg-white rounded-[2rem] shadow-sm border border-gray-50 p-8 md:p-10 space-y-8">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2 relative">
                    <span class="absolute left-4 top-10 text-[10px] font-black text-primary bg-primary/10 px-2 py-1 rounded">AR</span>
                    <label class="block text-sm font-black text-gray-700">عنوان الألبوم (بالعربية) <span class="text-red-500">*</span></label>
                    <input type="text" name="title[ar]" required class="w-full pl-14 pr-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:bg-white focus:ring-4 focus:ring-primary/10 font-bold">
                </div>
                <div class="space-y-2 relative" dir="ltr">
                    <span class="absolute right-4 top-10 text-[10px] font-black text-gray-500 bg-gray-200 px-2 py-1 rounded">EN</span>
                    <label class="block text-sm font-black text-gray-700 text-right">Gallery Title (English) <span class="text-red-500">*</span></label>
                    <input type="text" name="title[en]" required class="w-full pr-14 pl-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:bg-white focus:ring-4 focus:ring-primary/10 font-bold text-left">
                </div>
            </div>

            <div class="space-y-2 p-6 bg-gray-50 rounded-2xl border border-gray-100">
                <label class="block text-sm font-black text-gray-800 mb-2">🖼️ صور الألبوم <span class="text-red-500">*</span></label>
                <input type="file" name="images[]" accept="image/*" multiple required class="w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-black file:bg-gray-800 file:text-white cursor-pointer hover:file:bg-black mt-2">
                <p class="text-xs text-gray-400 font-bold mt-2">يمكنك تحديد أكثر من صورة في نفس الوقت (أقصى حجم 4 ميجا للصورة).</p>
            </div>

            <div class="pt-6 border-t border-gray-50 flex justify-end">
                <button type="submit" :disabled="isSubmitting" class="flex items-center gap-2 px-10 py-4 bg-primary text-white rounded-xl font-black shadow-lg shadow-primary/30 disabled:opacity-70">
                    <span x-show="!isSubmitting">حفظ الألبوم</span>
                    <span x-show="isSubmitting" style="display:none;">جاري الرفع...</span>
                </button>
            </div>
        </form>
    </div>
@endsection
