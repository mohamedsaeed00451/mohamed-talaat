@extends('admin.layouts.app')
@section('title', 'إضافة مقال جديد')

@section('content')
    <div class="max-w-6xl mx-auto pb-20">

        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('admin.posts.index') }}" class="p-2.5 bg-white text-gray-500 hover:text-primary rounded-xl shadow-sm border border-gray-100 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"></path></svg>
            </a>
            <h1 class="text-2xl font-black text-gray-900">إضافة مقال جديد</h1>
        </div>

        <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-[2rem] shadow-sm border border-gray-50 p-8 md:p-10 space-y-8" x-data="{ isSubmitting: false }" @submit="isSubmitting = true">
            @csrf

            <div class="space-y-6">
                <h3 class="text-lg font-black text-primary border-b border-gray-100 pb-2">البيانات الأساسية</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-black text-gray-700">التصنيف الأساسي <span class="text-red-500">*</span></label>
                        <select name="post_category_id" required class="w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl focus:bg-white focus:ring-4 focus:ring-primary/10 font-black text-sm">
                            <option value="">-- اختر التصنيف --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name['ar'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-black text-gray-700">صورة المقال (اختياري)</label>
                        <input type="file" name="image" accept="image/*" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-primary/50 font-bold text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-gray-900 file:text-white cursor-pointer">
                    </div>

                    <div class="space-y-2 relative">
                        <span class="absolute left-4 top-10 text-[10px] font-black text-primary bg-primary/10 px-2 py-1 rounded">AR</span>
                        <label class="block text-sm font-black text-gray-700">العنوان بالعربية <span class="text-red-500">*</span></label>
                        <input type="text" name="title[ar]" required class="w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl font-bold">
                    </div>

                    <div class="space-y-2 relative" dir="ltr">
                        <span class="absolute right-4 top-10 text-[10px] font-black text-gray-500 bg-gray-200 px-2 py-1 rounded">EN</span>
                        <label class="block text-sm font-black text-gray-700 text-right">Title (English) <span class="text-red-500">*</span></label>
                        <input type="text" name="title[en]" required class="w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl font-bold text-left">
                    </div>

                    <div class="space-y-2 md:col-span-2">
                        <label class="block text-sm font-black text-gray-700">الرابط الخارجي للمقال (اختياري)</label>
                        <input type="url" name="url" placeholder="https://example.com/article" dir="ltr" class="w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl font-bold text-left text-blue-600">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4">
                    <div class="space-y-2">
                        <label class="block text-sm font-black text-gray-700">الوصف / المحتوى بالعربية <span class="text-red-500">*</span></label>
                        <textarea name="description[ar]" rows="4" required class="w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl font-bold resize-none"></textarea>
                    </div>
                    <div class="space-y-2" dir="ltr">
                        <label class="block text-sm font-black text-gray-700 text-right">Description / Content (English) <span class="text-red-500">*</span></label>
                        <textarea name="description[en]" rows="4" required class="w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl font-bold resize-none text-left"></textarea>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-gray-50">
                    <div class="space-y-2">
                        <label class="block text-sm font-black text-gray-700">الإيجاز الاستراتيجي (بالعربية) - اختياري</label>
                        <textarea name="strategic_brief[ar]" rows="3" placeholder="مخلص للمقال..." class="w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl font-bold resize-none"></textarea>
                    </div>
                    <div class="space-y-2" dir="ltr">
                        <label class="block text-sm font-black text-gray-700 text-right">Strategic Brief (English) - Optional</label>
                        <textarea name="strategic_brief[en]" rows="3" placeholder="Summary of the article..." class="w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl font-bold resize-none text-left"></textarea>
                    </div>
                </div>
            </div>

            <div class="space-y-6 pt-6 mt-6 border-t border-gray-100">
                <h3 class="text-lg font-black text-primary border-b border-gray-100 pb-2">الملف المرفق (اختياري)</h3>
                <div class="space-y-2 p-4 bg-gray-50 rounded-2xl border border-gray-100 w-full md:w-1/2">
                    <label class="block text-sm font-black text-gray-800 mb-2">📄 المرفق (PDF/DOC)</label>
                    <input type="file" name="attachment_file" accept=".pdf,.doc,.docx" class="w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-black file:bg-primary file:text-white cursor-pointer">
                </div>
            </div>

            <div class="space-y-6 pt-6 mt-6 border-t border-gray-100" x-data="{ publishType: 'now', autoPublish: false }">
                <div class="flex items-center gap-2 border-b border-gray-100 pb-2 mb-6">
                    <h3 class="text-lg font-black text-primary">إعدادات النشر والحالة</h3>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="space-y-4 p-5 bg-gray-50 rounded-2xl border border-gray-100">

                        <label class="flex items-center justify-between cursor-pointer group">
                            <span class="text-sm font-black text-gray-800 group-hover:text-primary transition-colors">مقال مفعل (يظهر للزوار)</span>
                            <div class="relative">
                                <input type="checkbox" name="is_active" value="1" checked class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-500"></div>
                            </div>
                        </label>

                        <label class="flex items-center justify-between cursor-pointer group">
                            <span class="text-sm font-black text-gray-800 group-hover:text-primary transition-colors">مقال مميز (Featured)</span>
                            <div class="relative">
                                <input type="checkbox" name="is_featured" value="1" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-yellow-500"></div>
                            </div>
                        </label>

                        <label class="flex items-center justify-between cursor-pointer group">
                            <span class="text-sm font-black text-gray-800 group-hover:text-primary transition-colors">مقال أرشيفي / قديم</span>
                            <div class="relative">
                                <input type="checkbox" name="is_old" value="1" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-gray-700"></div>
                            </div>
                        </label>

                        <div class="pt-4 mt-4 border-t border-gray-200">
                            <label class="flex items-center justify-between cursor-pointer group">
                                <div class="flex flex-col">
                                    <span class="text-sm font-black text-gray-800 group-hover:text-blue-600 transition-colors">نشر تلقائي على السوشيال ميديا</span>
                                    <span class="text-[10px] text-gray-500 font-bold">سيتم الإرسال إلى (فيسبوك، لينكدإن، الخ)</span>
                                </div>
                                <div class="relative">
                                    <input type="checkbox" name="auto_publish" value="1" x-model="autoPublish" class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600 shadow-[0_0_10px_rgba(37,99,235,0.3)]"></div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="space-y-4 p-5 bg-blue-50/50 rounded-2xl border border-blue-100">
                        <label class="block text-sm font-black text-blue-900 mb-3">وقت النشر والظهور في الموقع:</label>

                        <div class="flex items-center gap-4">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="publish_type" value="now" x-model="publishType" class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                <span class="text-sm font-black text-gray-700">نشر فوراً ⚡</span>
                            </label>

                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="publish_type" value="schedule" x-model="publishType" class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                <span class="text-sm font-black text-gray-700">جدولة لوقت لاحق 📅</span>
                            </label>
                        </div>

                        <div x-show="publishType === 'schedule'" x-transition x-cloak class="mt-4" style="display: none;">
                            <label class="block text-xs font-black text-gray-500 mb-2">اختر التاريخ والوقت:</label>
                            <input type="datetime-local" name="published_at" class="w-full px-4 py-3 bg-white border border-blue-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-blue-500/20 font-bold text-gray-700">
                            <p class="text-[10px] text-gray-400 mt-2 font-bold">لن يظهر المقال في الموقع ولن يتم نشره على السوشيال ميديا إلا بعد هذا الوقت.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6 pt-6 mt-6 border-t border-gray-100">
                <div class="flex items-center gap-2 border-b border-gray-100 pb-2">
                    <h3 class="text-lg font-black text-primary">تحسين محركات البحث (SEO)</h3>
                    <span class="px-2 py-1 bg-yellow-50 text-yellow-600 rounded-lg text-[10px] font-black uppercase">اختياري</span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2"><label class="block text-sm font-black text-gray-700">Meta Title (بالعربية)</label><input type="text" name="meta_title[ar]" class="w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl font-bold"></div>
                    <div class="space-y-2" dir="ltr"><label class="block text-sm font-black text-gray-700 text-right">Meta Title (English)</label><input type="text" name="meta_title[en]" class="w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl font-bold text-left"></div>
                    <div class="space-y-2"><label class="block text-sm font-black text-gray-700">Meta Description (بالعربية)</label><textarea name="meta_description[ar]" rows="2" class="w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl font-bold resize-none"></textarea></div>
                    <div class="space-y-2" dir="ltr"><label class="block text-sm font-black text-gray-700 text-right">Meta Description (English)</label><textarea name="meta_description[en]" rows="2" class="w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl font-bold resize-none text-left"></textarea></div>
                </div>
                <div class="space-y-2 p-4 bg-gray-50 rounded-2xl border border-gray-100 w-full md:w-1/2">
                    <label class="block text-sm font-black text-gray-800 mb-2">🖼️ Meta Image (صورة المشاركة)</label>
                    <input type="file" name="meta_image" accept="image/*" class="w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-gray-800 file:text-white cursor-pointer">
                </div>
            </div>

            <div class="pt-6 border-t border-gray-50 flex justify-end">
                <button type="submit" :disabled="isSubmitting" class="flex items-center gap-2 px-10 py-4 bg-primary text-white rounded-xl font-black shadow-lg shadow-primary/30 disabled:opacity-70">
                    <span x-show="!isSubmitting">حفظ المقال</span>
                    <span x-show="isSubmitting" style="display:none;">جاري الحفظ والرفع...</span>
                </button>
            </div>
        </form>
    </div>
@endsection
