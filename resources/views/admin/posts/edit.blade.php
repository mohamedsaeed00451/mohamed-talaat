@extends('admin.layouts.app')
@section('title', 'تعديل المقال')

@section('content')
    <div class="max-w-6xl mx-auto pb-20">

        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('admin.posts.index') }}" class="p-2.5 bg-white text-gray-500 hover:text-primary rounded-xl shadow-sm border border-gray-100 transition-colors"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"></path></svg></a>
            <h1 class="text-2xl font-black text-gray-900">تعديل: {{ $post->title['ar'] ?? '' }}</h1>
        </div>

        <form action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-[2rem] shadow-sm border border-gray-50 p-8 md:p-10 space-y-8" x-data="{ isSubmitting: false }" @submit="isSubmitting = true">
            @csrf @method('PUT')

            <div class="space-y-6">
                <h3 class="text-lg font-black text-primary border-b border-gray-100 pb-2">البيانات الأساسية</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-black text-gray-700">التصنيف الأساسي <span class="text-red-500">*</span></label>
                        <select name="post_category_id" required class="w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl font-black text-sm">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $post->post_category_id == $category->id ? 'selected' : '' }}>{{ $category->name['ar'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="flex justify-between items-end text-sm font-black text-gray-700">
                            <span>صورة المقال</span>
                            @if($post->image) <a href="{{ asset($post->image) }}" target="_blank" class="text-[10px] bg-blue-50 text-blue-600 px-2 py-1 rounded font-bold">صورة حالية 🖼️</a> @endif
                        </label>
                        <input type="file" name="image" accept="image/*" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl font-bold text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-gray-900 file:text-white cursor-pointer">
                    </div>

                    <div class="space-y-2 relative">
                        <span class="absolute left-4 top-10 text-[10px] font-black text-primary bg-primary/10 px-2 py-1 rounded">AR</span>
                        <label class="block text-sm font-black text-gray-700">العنوان بالعربية <span class="text-red-500">*</span></label>
                        <input type="text" name="title[ar]" value="{{ old('title.ar', $post->title['ar'] ?? '') }}" required class="w-full pl-14 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl font-bold">
                    </div>

                    <div class="space-y-2 relative" dir="ltr">
                        <span class="absolute right-4 top-10 text-[10px] font-black text-gray-500 bg-gray-200 px-2 py-1 rounded">EN</span>
                        <label class="block text-sm font-black text-gray-700 text-right">Title (English) <span class="text-red-500">*</span></label>
                        <input type="text" name="title[en]" value="{{ old('title.en', $post->title['en'] ?? '') }}" required class="w-full pr-14 pl-4 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl font-bold text-left">
                    </div>

                    <div class="space-y-2 md:col-span-2">
                        <label class="block text-sm font-black text-gray-700">الرابط الخارجي للمقال (اختياري)</label>
                        <input type="url" name="url" value="{{ old('url', $post->url) }}" placeholder="https://example.com/article" dir="ltr" class="w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl font-bold text-left text-blue-600">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4">
                    <div class="space-y-2">
                        <label class="block text-sm font-black text-gray-700">الوصف / المحتوى بالعربية <span class="text-red-500">*</span></label>
                        <textarea name="description[ar]" rows="4" required class="w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl font-bold resize-none">{{ old('description.ar', $post->description['ar'] ?? '') }}</textarea>
                    </div>
                    <div class="space-y-2" dir="ltr">
                        <label class="block text-sm font-black text-gray-700 text-right">Description / Content (English) <span class="text-red-500">*</span></label>
                        <textarea name="description[en]" rows="4" required class="w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl font-bold resize-none text-left">{{ old('description.en', $post->description['en'] ?? '') }}</textarea>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-gray-50">
                    <div class="space-y-2">
                        <label class="block text-sm font-black text-gray-700">الإيجاز الاستراتيجي (بالعربية)</label>
                        <textarea name="strategic_brief[ar]" rows="3" class="w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl font-bold resize-none">{{ old('strategic_brief.ar', $post->strategic_brief['ar'] ?? '') }}</textarea>
                    </div>
                    <div class="space-y-2" dir="ltr">
                        <label class="block text-sm font-black text-gray-700 text-right">Strategic Brief (English)</label>
                        <textarea name="strategic_brief[en]" rows="3" class="w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl font-bold resize-none text-left">{{ old('strategic_brief.en', $post->strategic_brief['en'] ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="space-y-6 pt-6 mt-6 border-t border-gray-100">
                <h3 class="text-lg font-black text-primary border-b border-gray-100 pb-2">الملف المرفق (اختياري)</h3>
                <div class="space-y-2 p-4 bg-gray-50 rounded-2xl border border-gray-100 w-full md:w-1/2 relative">
                    <label class="block text-sm font-black text-gray-800 mb-2">📄 المرفق</label>
                    @if($post->attachment_file) <a href="{{ asset($post->attachment_file) }}" target="_blank" class="absolute top-4 left-4 text-[10px] font-bold bg-green-100 text-green-700 px-2 py-1 rounded-lg">ملف موجود ✔️</a> @endif
                    <input type="file" name="attachment_file" accept=".pdf,.doc,.docx" class="w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-primary file:text-white cursor-pointer mt-2">
                </div>
            </div>

            <div class="space-y-6 pt-6 mt-6 border-t border-gray-100">
                <div class="flex items-center gap-2 border-b border-gray-100 pb-2">
                    <h3 class="text-lg font-black text-primary">تحسين محركات البحث (SEO)</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2"><label class="block text-sm font-black text-gray-700">Meta Title (بالعربية)</label><input type="text" name="meta_title[ar]" value="{{ old('meta_title.ar', $post->meta_title['ar'] ?? '') }}" class="w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl font-bold"></div>
                    <div class="space-y-2" dir="ltr"><label class="block text-sm font-black text-gray-700 text-right">Meta Title (English)</label><input type="text" name="meta_title[en]" value="{{ old('meta_title.en', $post->meta_title['en'] ?? '') }}" class="w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl font-bold text-left"></div>
                    <div class="space-y-2"><label class="block text-sm font-black text-gray-700">Meta Description (بالعربية)</label><textarea name="meta_description[ar]" rows="2" class="w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl font-bold resize-none">{{ old('meta_description.ar', $post->meta_description['ar'] ?? '') }}</textarea></div>
                    <div class="space-y-2" dir="ltr"><label class="block text-sm font-black text-gray-700 text-right">Meta Description (English)</label><textarea name="meta_description[en]" rows="2" class="w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl font-bold resize-none text-left">{{ old('meta_description.en', $post->meta_description['en'] ?? '') }}</textarea></div>
                </div>
                <div class="space-y-2 p-4 bg-gray-50 rounded-2xl border border-gray-100 w-full md:w-1/2 relative">
                    <label class="block text-sm font-black text-gray-800 mb-2">🖼️ Meta Image</label>
                    @if($post->meta_image) <a href="{{ asset($post->meta_image) }}" target="_blank" class="absolute top-4 left-4 text-[10px] font-bold bg-green-100 text-green-700 px-2 py-1 rounded-lg">صورة حالية ✔️</a> @endif
                    <input type="file" name="meta_image" accept="image/*" class="w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-gray-800 file:text-white cursor-pointer mt-2">
                </div>
            </div>

            <div class="pt-6 border-t border-gray-50 flex justify-end">
                <button type="submit" :disabled="isSubmitting" class="flex items-center gap-2 px-10 py-4 bg-primary text-white rounded-xl font-black shadow-lg shadow-primary/30 disabled:opacity-70">
                    <span x-show="!isSubmitting">حفظ التعديلات</span>
                    <span x-show="isSubmitting" style="display:none;">جاري الحفظ والرفع...</span>
                </button>
            </div>
        </form>
    </div>
@endsection
