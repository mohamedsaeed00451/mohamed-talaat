@extends('admin.layouts.app')

@section('title', 'إنشاء صفحة جديدة')

@section('content')
    <div class="max-w-6xl mx-auto pb-20">

        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('admin.pages.index') }}" class="p-2.5 bg-white text-gray-500 hover:text-primary rounded-xl shadow-sm border border-gray-100 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
            <h1 class="text-2xl font-black text-gray-900">إنشاء صفحة جديدة</h1>
        </div>

        <form action="{{ route('admin.pages.store') }}" method="POST" x-data="{ isSubmitting: false }" @submit="isSubmitting = true" class="bg-white rounded-[2rem] shadow-sm border border-gray-50 p-8 md:p-10 space-y-8">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2 relative">
                    <span class="absolute left-4 top-10 text-[10px] font-black text-primary bg-primary/10 px-2 py-1 rounded">AR</span>
                    <label class="block text-sm font-black text-gray-700">عنوان الصفحة (بالعربية) <span class="text-red-500">*</span></label>
                    <input type="text" name="title[ar]" value="{{ old('title.ar') }}" required placeholder="مثال: سياسة الخصوصية" class="w-full pl-14 pr-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:bg-white focus:border-primary/50 focus:ring-4 focus:ring-primary/10 transition-all font-bold text-gray-800">
                </div>

                <div class="space-y-2 relative" dir="ltr">
                    <span class="absolute right-4 top-10 text-[10px] font-black text-gray-500 bg-gray-200 px-2 py-1 rounded">EN</span>
                    <label class="block text-sm font-black text-gray-700 text-right">Page Title (English) <span class="text-red-500">*</span></label>
                    <input type="text" name="title[en]" value="{{ old('title.en') }}" required placeholder="e.g: Privacy Policy" class="w-full pr-14 pl-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:bg-white focus:border-primary/50 focus:ring-4 focus:ring-primary/10 transition-all font-bold text-gray-800 text-left">
                </div>

                <div class="space-y-2 md:col-span-2 relative" dir="ltr">
                    <label class="block text-sm font-black text-gray-700 text-right">URL Slug <span class="text-red-500">*</span></label>
                    <div class="flex">
                        <span class="inline-flex items-center px-4 rounded-l-xl border border-r-0 border-gray-200 bg-gray-100 text-gray-500 font-bold text-sm">
                            {{ url('/') }}/
                        </span>
                        <input type="text" name="slug" value="{{ old('slug') }}" required placeholder="privacy-policy" class="flex-1 w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-r-xl focus:bg-white focus:border-primary/50 focus:ring-4 focus:ring-primary/10 transition-all font-bold text-blue-600 text-left">
                    </div>
                </div>
            </div>

            <div class="space-y-8 pt-8 border-t border-gray-50">
                <div class="space-y-2">
                    <label class="flex items-center justify-between text-sm font-black text-gray-700">
                        <span>المحتوى (بالعربية) <span class="text-red-500">*</span></span>
                        <span class="text-[10px] font-black text-primary bg-primary/10 px-2 py-1 rounded">AR</span>
                    </label>
                    <textarea name="content[ar]" rows="8" required class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:bg-white focus:border-primary/50 focus:ring-4 focus:ring-primary/10 transition-all font-semibold text-gray-800 leading-loose">{{ old('content.ar') }}</textarea>
                </div>

                <div class="space-y-2" dir="ltr">
                    <label class="flex items-center justify-between text-sm font-black text-gray-700">
                        <span>Content (English) <span class="text-red-500">*</span></span>
                        <span class="text-[10px] font-black text-gray-500 bg-gray-200 px-2 py-1 rounded">EN</span>
                    </label>
                    <textarea name="content[en]" rows="8" required class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:bg-white focus:border-primary/50 focus:ring-4 focus:ring-primary/10 transition-all font-semibold text-gray-800 leading-loose text-left">{{ old('content.en') }}</textarea>
                </div>
            </div>

            <div class="pt-6 border-t border-gray-50 flex justify-end">
                <button type="submit" :disabled="isSubmitting" class="flex items-center justify-center gap-2 px-10 py-4 bg-primary text-white rounded-xl font-black text-base shadow-lg shadow-primary/30 transition-all disabled:opacity-70 disabled:cursor-not-allowed hover:-translate-y-0.5">
                    <span x-show="!isSubmitting">حفظ الصفحة</span>
                    <span x-show="isSubmitting" style="display: none;">جاري الحفظ...</span>
                    <svg x-show="isSubmitting" style="display: none;" class="w-5 h-5 animate-spin text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                </button>
            </div>
        </form>
    </div>
@endsection
