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

                        <div class="pt-5 mt-5 border-t border-gray-200">
                            <label class="flex flex-col mb-4">
                                <span class="text-sm font-black text-gray-800">النشر التلقائي المتعدد (Social Media)</span>
                                <span class="text-[10px] text-gray-500 font-bold mt-1">اختر المنصات التي تود نشر المقال عليها عند حلول وقت النشر.</span>
                            </label>

                            <div class="grid grid-cols-2 gap-3">
                                <label class="cursor-pointer relative group">
                                    <input type="checkbox" name="social_platforms[]" value="facebook" {{ in_array('facebook', old('social_platforms', $post->social_platforms ?? [])) ? 'checked' : '' }} class="peer sr-only">
                                    <div class="flex items-center gap-3 p-3 rounded-xl border-2 border-gray-100 bg-white peer-checked:border-[#1877F2] peer-checked:bg-[#1877F2]/5 transition-all duration-300 hover:shadow-md">
                                        <div class="w-8 h-8 rounded-lg bg-[#1877F2]/10 flex items-center justify-center text-[#1877F2] group-hover:scale-110 transition-transform">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                        </div>
                                        <span class="font-black text-sm text-gray-700 peer-checked:text-[#1877F2]">فيسبوك</span>
                                    </div>
                                </label>

                                <label class="cursor-pointer relative group">
                                    <input type="checkbox" name="social_platforms[]" value="twitter" {{ in_array('twitter', old('social_platforms', $post->social_platforms ?? [])) ? 'checked' : '' }} class="peer sr-only">
                                    <div class="flex items-center gap-3 p-3 rounded-xl border-2 border-gray-100 bg-white peer-checked:border-gray-900 peer-checked:bg-gray-50 transition-all duration-300 hover:shadow-md">
                                        <div class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-gray-900 group-hover:scale-110 transition-transform">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.008 5.922H5.078z"/></svg>
                                        </div>
                                        <span class="font-black text-sm text-gray-700 peer-checked:text-gray-900">منصة X</span>
                                    </div>
                                </label>

                                <label class="cursor-pointer relative group">
                                    <input type="checkbox" name="social_platforms[]" value="linkedin" {{ in_array('linkedin', old('social_platforms', $post->social_platforms ?? [])) ? 'checked' : '' }} class="peer sr-only">
                                    <div class="flex items-center gap-3 p-3 rounded-xl border-2 border-gray-100 bg-white peer-checked:border-[#0A66C2] peer-checked:bg-[#0A66C2]/5 transition-all duration-300 hover:shadow-md">
                                        <div class="w-8 h-8 rounded-lg bg-[#0A66C2]/10 flex items-center justify-center text-[#0A66C2] group-hover:scale-110 transition-transform">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                                        </div>
                                        <span class="font-black text-sm text-gray-700 peer-checked:text-[#0A66C2]">لينكد إن</span>
                                    </div>
                                </label>

                                <label class="cursor-pointer relative group">
                                    <input type="checkbox" name="social_platforms[]" value="instagram" {{ in_array('instagram', old('social_platforms', $post->social_platforms ?? [])) ? 'checked' : '' }} class="peer sr-only">
                                    <div class="flex items-center gap-3 p-3 rounded-xl border-2 border-gray-100 bg-white peer-checked:border-[#E1306C] peer-checked:bg-[#E1306C]/5 transition-all duration-300 hover:shadow-md">
                                        <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-[#F58529] via-[#DD2A7B] to-[#8134AF] flex items-center justify-center text-white group-hover:scale-110 transition-transform shadow-sm">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                                        </div>
                                        <span class="font-black text-sm text-gray-700 peer-checked:text-[#E1306C]">إنستجرام</span>
                                    </div>
                                </label>
                            </div>
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
                <button type="submit" :disabled="isSubmitting" class="cursor-pointer flex items-center gap-2 px-10 py-4 bg-primary text-white rounded-xl font-black shadow-lg shadow-primary/30 disabled:opacity-70">
                    <span x-show="!isSubmitting">حفظ المقال</span>
                    <span x-show="isSubmitting" style="display:none;">جاري الحفظ والرفع...</span>
                </button>
            </div>
        </form>
    </div>
@endsection
