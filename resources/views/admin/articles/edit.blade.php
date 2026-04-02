@extends('admin.layouts.app')
@section('title', 'تعديل المقال')

@section('content')
    <div class="max-w-6xl mx-auto pb-20">

        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('admin.articles.index') }}" class="p-2.5 bg-white text-gray-500 hover:text-primary rounded-xl shadow-sm border border-gray-100 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
            <h1 class="text-2xl font-black text-gray-900">تعديل: {{ $article->title['ar'] ?? '' }}</h1>
        </div>

        <form action="{{ route('admin.articles.update', $article->id) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-[2rem] shadow-sm border border-gray-50 p-8 md:p-10 space-y-8" x-data="{ isSubmitting: false }" @submit="isSubmitting = true">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <h3 class="text-lg font-black text-primary border-b border-gray-100 pb-2">البيانات الأساسية</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2 relative">
                        <label class="block text-sm font-black text-gray-700">التصنيف الأساسي <span class="text-red-500">*</span></label>
                        <select name="article_type_id" required class="w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl focus:bg-white focus:ring-4 focus:ring-primary/10 transition-all font-black text-sm">
                            <option value="">-- اختر التصنيف --</option>
                            @foreach($types as $type)
                                <option value="{{ $type->id }}" {{ $article->article_type_id == $type->id ? 'selected' : '' }}>
                                    {{ $type->name['ar'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="flex justify-between items-end text-sm font-black text-gray-700">
                            <span>صورة المقال</span>
                            @if($article->image)
                                <a href="{{ asset($article->image) }}" target="_blank" class="text-[10px] bg-blue-50 text-blue-600 px-2 py-1 rounded font-bold">صورة حالية 🖼️</a>
                            @endif
                        </label>
                        <input type="file" name="image" accept="image/*" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-primary/50 transition-all font-bold text-gray-600 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-black file:bg-gray-900 file:text-white cursor-pointer">
                    </div>

                    <div class="space-y-2 relative">
                        <span class="absolute left-4 top-10 text-[10px] font-black text-primary bg-primary/10 px-2 py-1 rounded">AR</span>
                        <label class="block text-sm font-black text-gray-700">العنوان بالعربية <span class="text-red-500">*</span></label>
                        <input type="text" name="title[ar]" value="{{ old('title.ar', $article->title['ar'] ?? '') }}" required class="w-full pl-14 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl focus:bg-white focus:ring-4 focus:ring-primary/10 font-bold">
                    </div>

                    <div class="space-y-2 relative" dir="ltr">
                        <span class="absolute right-4 top-10 text-[10px] font-black text-gray-500 bg-gray-200 px-2 py-1 rounded">EN</span>
                        <label class="block text-sm font-black text-gray-700 text-right">Title (English) <span class="text-red-500">*</span></label>
                        <input type="text" name="title[en]" value="{{ old('title.en', $article->title['en'] ?? '') }}" required class="w-full pr-14 pl-4 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl focus:bg-white focus:ring-4 focus:ring-primary/10 font-bold text-left">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <span class="text-[10px] font-black text-primary bg-primary/10 px-2 py-1 rounded mb-1 inline-block">AR</span>
                        <label class="block text-sm font-black text-gray-700">الوصف بالعربية <span class="text-red-500">*</span></label>
                        <textarea name="description[ar]" rows="4" required class="w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl focus:bg-white focus:ring-4 focus:ring-primary/10 font-bold resize-none">{{ old('description.ar', $article->description['ar'] ?? '') }}</textarea>
                    </div>
                    <div class="space-y-2" dir="ltr">
                        <span class="text-[10px] font-black text-gray-500 bg-gray-200 px-2 py-1 rounded mb-1 inline-block float-right">EN</span>
                        <div class="clear-both"></div>
                        <label class="block text-sm font-black text-gray-700 text-right">Description (English) <span class="text-red-500">*</span></label>
                        <textarea name="description[en]" rows="4" required class="w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl focus:bg-white focus:ring-4 focus:ring-primary/10 font-bold resize-none text-left">{{ old('description.en', $article->description['en'] ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="space-y-6 pt-6 mt-6 border-t border-gray-100">
                <h3 class="text-lg font-black text-primary border-b border-gray-100 pb-2">الملفات المرفقة (اختياري)</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2 p-4 bg-gray-50 rounded-2xl border border-gray-100 relative">
                        <label class="block text-sm font-black text-gray-800 mb-2">📄 الأوراق البيضاء</label>
                        @if($article->white_papers_file)
                            <a href="{{ asset($article->white_papers_file) }}" target="_blank" class="absolute top-4 left-4 text-[10px] font-bold bg-green-100 text-green-700 px-2 py-1 rounded-lg">ملف موجود ✔️</a>
                        @endif
                        <input type="file" name="white_papers_file" accept=".pdf,.doc,.docx" class="w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-black file:bg-primary file:text-white cursor-pointer mt-2">
                    </div>

                    <div class="space-y-2 p-4 bg-gray-50 rounded-2xl border border-gray-100 relative">
                        <label class="block text-sm font-black text-gray-800 mb-2">📚 الأبحاث المنشورة</label>
                        @if($article->published_researches_file)
                            <a href="{{ asset($article->published_researches_file) }}" target="_blank" class="absolute top-4 left-4 text-[10px] font-bold bg-green-100 text-green-700 px-2 py-1 rounded-lg">ملف موجود ✔️</a>
                        @endif
                        <input type="file" name="published_researches_file" accept=".pdf,.doc,.docx" class="w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-black file:bg-primary file:text-white cursor-pointer mt-2">
                    </div>

                    <div class="space-y-2 p-4 bg-gray-50 rounded-2xl border border-gray-100 relative">
                        <label class="block text-sm font-black text-gray-800 mb-2">💼 الإيجازات التنفيذية</label>
                        @if($article->executive_briefs_file)
                            <a href="{{ asset($article->executive_briefs_file) }}" target="_blank" class="absolute top-4 left-4 text-[10px] font-bold bg-green-100 text-green-700 px-2 py-1 rounded-lg">ملف موجود ✔️</a>
                        @endif
                        <input type="file" name="executive_briefs_file" accept=".pdf,.doc,.docx" class="w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-black file:bg-primary file:text-white cursor-pointer mt-2">
                    </div>

                    <div class="space-y-2 p-4 bg-gray-50 rounded-2xl border border-gray-100 relative">
                        <label class="block text-sm font-black text-gray-800 mb-2">⏳ الأرشيف الزمني</label>
                        @if($article->chronological_archive_file)
                            <a href="{{ asset($article->chronological_archive_file) }}" target="_blank" class="absolute top-4 left-4 text-[10px] font-bold bg-green-100 text-green-700 px-2 py-1 rounded-lg">ملف موجود ✔️</a>
                        @endif
                        <input type="file" name="chronological_archive_file" accept=".pdf,.doc,.docx" class="w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-black file:bg-primary file:text-white cursor-pointer mt-2">
                    </div>
                </div>
            </div>

            <div class="space-y-6 pt-6 mt-6 border-t border-gray-100">
                <div class="flex items-center gap-2 border-b border-gray-100 pb-2">
                    <h3 class="text-lg font-black text-primary">تحسين محركات البحث (SEO)</h3>
                    <span class="px-2 py-1 bg-yellow-50 text-yellow-600 rounded-lg text-[10px] font-black uppercase">اختياري</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2 relative">
                        <span class="absolute left-4 top-10 text-[10px] font-black text-primary bg-primary/10 px-2 py-1 rounded">AR</span>
                        <label class="block text-sm font-black text-gray-700">Meta Title (بالعربية)</label>
                        <input type="text" name="meta_title[ar]" value="{{ old('meta_title.ar', $article->meta_title['ar'] ?? '') }}" class="w-full pl-14 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl focus:bg-white focus:border-primary/50 focus:ring-4 focus:ring-primary/10 transition-all font-bold">
                    </div>

                    <div class="space-y-2 relative" dir="ltr">
                        <span class="absolute right-4 top-10 text-[10px] font-black text-gray-500 bg-gray-200 px-2 py-1 rounded">EN</span>
                        <label class="block text-sm font-black text-gray-700 text-right">Meta Title (English)</label>
                        <input type="text" name="meta_title[en]" value="{{ old('meta_title.en', $article->meta_title['en'] ?? '') }}" class="w-full pr-14 pl-4 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl focus:bg-white focus:border-primary/50 focus:ring-4 focus:ring-primary/10 transition-all font-bold text-left">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-black text-gray-700">Meta Description (بالعربية)</label>
                        <textarea name="meta_description[ar]" rows="3" class="w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl focus:bg-white focus:ring-4 focus:ring-primary/10 font-bold resize-none">{{ old('meta_description.ar', $article->meta_description['ar'] ?? '') }}</textarea>
                    </div>
                    <div class="space-y-2" dir="ltr">
                        <label class="block text-sm font-black text-gray-700 text-right">Meta Description (English)</label>
                        <textarea name="meta_description[en]" rows="3" class="w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl focus:bg-white focus:ring-4 focus:ring-primary/10 font-bold resize-none text-left">{{ old('meta_description.en', $article->meta_description['en'] ?? '') }}</textarea>
                    </div>
                </div>

                <div class="space-y-2 p-4 bg-gray-50 rounded-2xl border border-gray-100 w-full md:w-1/2 relative">
                    <label class="block text-sm font-black text-gray-800 mb-2">🖼️ Meta Image</label>
                    @if($article->meta_image)
                        <a href="{{ asset($article->meta_image) }}" target="_blank" class="absolute top-4 left-4 text-[10px] font-bold bg-green-100 text-green-700 px-2 py-1 rounded-lg">صورة حالية ✔️</a>
                    @endif
                    <input type="file" name="meta_image" accept="image/*" class="w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-black file:bg-gray-800 file:text-white cursor-pointer mt-2">
                </div>
            </div>

            <div class="pt-6 border-t border-gray-50 flex justify-end">
                <button type="submit" :disabled="isSubmitting" class="flex items-center justify-center gap-2 px-10 py-4 bg-primary text-white rounded-xl font-black shadow-lg shadow-primary/30 transition-all disabled:opacity-70">
                    <span x-show="!isSubmitting">حفظ التعديلات</span>
                    <span x-show="isSubmitting" style="display:none;">جاري الحفظ والرفع...</span>
                </button>
            </div>
        </form>
    </div>
@endsection
