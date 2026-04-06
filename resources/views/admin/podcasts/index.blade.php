@extends('admin.layouts.app')
@section('title', 'البودكاست')

@section('content')
    <div x-data="podcastModal()" class="max-w-7xl mx-auto pb-20">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
            <div>
                <h1 class="text-3xl font-black text-gray-900 tracking-tight flex items-center gap-3">
                    <div class="p-2.5 bg-purple-50 text-purple-600 rounded-xl">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path></svg>
                    </div>
                    إدارة البودكاست
                </h1>
                <p class="text-gray-500 font-bold mt-2 text-sm">عرض وتوثيق حلقات البودكاست الخاصة بك.</p>
            </div>

            <button @click="openAdd()" type="button"
                    class="cursor-pointer group flex items-center gap-2 px-6 py-3.5 bg-primary text-white rounded-2xl font-black text-sm shadow-xl shadow-primary/30 hover:-translate-y-1 transition-all duration-300">
                <svg class="w-5 h-5 transition-transform group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                </svg>
                إضافة حلقة جديدة
            </button>
        </div>

        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-50 overflow-hidden relative">
            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-right border-collapse table-fixed min-w-[900px]">
                    <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-6 py-5 text-xs font-black text-gray-500 uppercase tracking-wider text-center w-16">#</th>
                        <th class="px-6 py-5 text-xs font-black text-gray-500 uppercase tracking-wider text-center w-20">الصورة</th>
                        <th class="px-6 py-5 text-xs font-black text-gray-500 uppercase tracking-wider w-1/3">العنوان</th>
                        <th class="px-6 py-5 text-xs font-black text-gray-500 uppercase tracking-wider text-center">المنصة</th>
                        <th class="px-6 py-5 text-xs font-black text-gray-500 uppercase tracking-wider text-center">رابط الفيديو</th>
                        <th class="px-6 py-5 text-xs font-black text-gray-500 uppercase tracking-wider text-center w-32">الإجراءات</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                    @forelse($podcasts as $item)
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-6 py-5 text-center font-bold text-gray-500 align-middle">
                                {{ ($podcasts->currentPage() - 1) * $podcasts->perPage() + $loop->iteration }}
                            </td>

                            <td class="px-6 py-5 align-middle text-center">
                                @if($item->image)
                                    <img src="{{ asset($item->image) }}" class="w-12 h-12 rounded-xl object-cover shadow-sm border border-gray-100 mx-auto">
                                @else
                                    <div class="w-12 h-12 rounded-xl bg-gray-50 border border-gray-100 flex items-center justify-center text-gray-400 mx-auto">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                @endif
                            </td>

                            <td class="px-6 py-5 align-middle">
                                <p class="font-black text-gray-800 text-sm">{{ $item->title['ar'] ?? '' }}</p>
                                <p class="font-bold text-gray-400 text-xs mt-1" dir="ltr">{{ $item->title['en'] ?? '' }}</p>
                            </td>

                            <td class="px-6 py-5 text-center align-middle">
                                <span class="px-4 py-1.5 rounded-xl text-xs font-black uppercase inline-flex items-center gap-2
                                    {{ $item->platform == 'youtube' ? 'bg-red-50 text-red-600' : '' }}
                                    {{ $item->platform == 'facebook' ? 'bg-blue-50 text-blue-600' : '' }}
                                    {{ $item->platform == 'instagram' ? 'bg-pink-50 text-pink-600' : '' }}
                                    {{ $item->platform == 'tiktok' ? 'bg-gray-100 text-gray-900' : '' }}
                                    {{ $item->platform == 'other' ? 'bg-gray-50 text-gray-500' : '' }}
                                ">
                                    <span class="w-2 h-2 rounded-full bg-current opacity-50"></span>
                                    {{ $item->platform }}
                                </span>
                            </td>

                            <td class="px-6 py-5 text-center align-middle">
                                <a href="{{ $item->video_url }}" target="_blank"
                                   class="text-blue-500 font-bold text-xs hover:underline flex items-center justify-center gap-1">
                                    مشاهدة الحلقة
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                </a>
                            </td>

                            <td class="px-6 py-5 align-middle">
                                <div class="flex items-center justify-center gap-2">
                                    <button
                                        @click="openEdit({{ $item->id }}, '{{ addslashes($item->title['ar']) }}', '{{ addslashes($item->title['en']) }}', '{{ addslashes($item->description['ar'] ?? '') }}', '{{ addslashes($item->description['en'] ?? '') }}', '{{ $item->platform }}', '{{ $item->video_url }}', '{{ $item->image ? asset($item->image) : '' }}')"
                                        class="p-2.5 bg-blue-50 text-blue-500 hover:bg-blue-500 hover:text-white rounded-xl transition-colors cursor-pointer"
                                        title="تعديل">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </button>
                                    <form action="{{ route('admin.podcasts.destroy', $item->id) }}" method="POST" class="delete-form m-0">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2.5 bg-red-50 text-red-500 hover:bg-red-500 hover:text-white rounded-xl transition-colors cursor-pointer">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-20 text-center">
                                <div class="opacity-40 flex flex-col items-center">
                                    <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path></svg>
                                    <p class="font-black text-gray-500 text-lg">لا توجد حلقات بودكاست مسجلة حتى الآن</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            @if($podcasts->hasPages())
                <div class="p-6 border-t border-gray-50 bg-gray-50/30">{{ $podcasts->links() }}</div>
            @endif
        </div>

        <template x-teleport="body">
            <div x-show="isOpen" class="relative z-[99999]" style="display: none;">
                <div x-show="isOpen" x-transition.opacity class="fixed inset-0 bg-gray-900/70 backdrop-blur-sm"></div>
                <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                    <div class="flex min-h-full items-center justify-center p-4">
                        <div x-show="isOpen" @click.away="closeModal()" x-transition.scale
                             class="relative transform overflow-hidden rounded-[2.5rem] bg-white text-right shadow-2xl transition-all w-full max-w-2xl border border-gray-100">

                            <div class="px-8 py-6 border-b border-gray-50 flex items-center justify-between bg-gray-50/50">
                                <h3 class="text-xl font-black text-gray-900" x-text="isEdit ? 'تعديل بيانات البودكاست' : 'إضافة حلقة جديدة'"></h3>
                                <button @click="closeModal()" type="button" class="p-2 text-gray-400 hover:text-red-500 bg-white hover:bg-red-50 rounded-xl transition-colors cursor-pointer border border-gray-100">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>

                            <form :action="formAction" method="POST" enctype="multipart/form-data" class="p-8" @submit="isSubmitting = true">
                                @csrf
                                <template x-if="isEdit">
                                    <input type="hidden" name="_method" value="PUT">
                                </template>

                                <div class="space-y-6">
                                    <div class="space-y-2 p-4 bg-gray-50 rounded-2xl border border-gray-100">
                                        <label class="block text-sm font-black text-gray-800 mb-2">🖼️ صورة البودكاست (اختياري)</label>
                                        <template x-if="isEdit && formData.imageUrl">
                                            <div class="mb-3">
                                                <img :src="formData.imageUrl" class="w-16 h-16 rounded-xl object-cover shadow-sm border border-gray-200">
                                            </div>
                                        </template>
                                        <input type="file" name="image" accept="image/*" class="w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-black file:bg-gray-800 file:text-white cursor-pointer hover:file:bg-black transition-colors">
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="space-y-2 relative">
                                            <span class="absolute left-4 top-10 text-[10px] font-black text-primary bg-primary/10 px-2 py-1 rounded">AR</span>
                                            <label class="block text-sm font-black text-gray-700">العنوان بالعربية <span class="text-red-500">*</span></label>
                                            <input type="text" name="title[ar]" x-model="formData.ar" required class="w-full pl-14 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl focus:bg-white focus:border-primary/50 focus:ring-4 focus:ring-primary/10 transition-all font-bold">
                                        </div>

                                        <div class="space-y-2 relative" dir="ltr">
                                            <span class="absolute right-4 top-10 text-[10px] font-black text-gray-500 bg-gray-200 px-2 py-1 rounded">EN</span>
                                            <label class="block text-sm font-black text-gray-700 text-right">Title in English <span class="text-red-500">*</span></label>
                                            <input type="text" name="title[en]" x-model="formData.en" required class="w-full pr-14 pl-4 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl focus:bg-white focus:border-primary/50 focus:ring-4 focus:ring-primary/10 transition-all font-bold text-left">
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="space-y-2 relative">
                                            <span class="absolute left-4 top-10 text-[10px] font-black text-primary bg-primary/10 px-2 py-1 rounded">AR</span>
                                            <label class="block text-sm font-black text-gray-700">الوصف بالعربية <span class="text-red-500">*</span></label>
                                            <textarea name="description[ar]" x-model="formData.descAr" rows="3" required class="w-full pl-14 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl focus:bg-white focus:border-primary/50 transition-all font-bold resize-none"></textarea>
                                        </div>

                                        <div class="space-y-2 relative" dir="ltr">
                                            <span class="absolute right-4 top-10 text-[10px] font-black text-gray-500 bg-gray-200 px-2 py-1 rounded">EN</span>
                                            <label class="block text-sm font-black text-gray-700 text-right">Description in English <span class="text-red-500">*</span></label>
                                            <textarea name="description[en]" x-model="formData.descEn" rows="3" required class="w-full pr-14 pl-4 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl focus:bg-white focus:border-primary/50 transition-all font-bold resize-none text-left"></textarea>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="space-y-2 relative">
                                            <label class="block text-sm font-black text-gray-700">المنصة <span class="text-red-500">*</span></label>
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-gray-400">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                                                </div>
                                                <select name="platform" x-model="formData.platform" required class="appearance-none w-full pr-4 pl-12 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl focus:bg-white focus:border-primary/50 focus:ring-4 focus:ring-primary/10 transition-all font-black text-sm cursor-pointer">
                                                    <option value="youtube">يوتيوب</option>
                                                    <option value="facebook">فيسبوك</option>
                                                    <option value="instagram">إنستجرام</option>
                                                    <option value="tiktok">تيك توك</option>
                                                    <option value="other">أخرى</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="space-y-2" dir="ltr">
                                            <label class="block text-sm font-black text-gray-700 text-right">رابط الفيديو (URL) <span class="text-red-500">*</span></label>
                                            <input type="url" name="video_url" x-model="formData.videoUrl" required placeholder="https://..." class="w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl focus:bg-white focus:ring-4 focus:ring-primary/10 transition-all font-bold text-left">
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-8 flex items-center justify-end gap-3 pt-6 border-t border-gray-50">
                                    <button type="button" @click="closeModal()" class="px-6 py-3 text-gray-600 font-bold text-sm bg-gray-100 rounded-xl transition-colors cursor-pointer">إلغاء</button>
                                    <button type="submit" :disabled="isSubmitting" class="cursor-pointer flex items-center justify-center gap-2 px-8 py-3 bg-primary text-white rounded-xl font-black text-sm shadow-lg shadow-primary/30 transition-all disabled:opacity-70">
                                        <span x-show="!isSubmitting" x-text="isEdit ? 'حفظ التعديلات' : 'حفظ البيانات'"></span>
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
        function podcastModal() {
            return {
                isOpen: false,
                isEdit: false,
                isSubmitting: false,
                formAction: '{{ route("admin.podcasts.store") }}',
                baseUrl: '{{ url("admin/podcasts") }}',
                formData: {
                    ar: '',
                    en: '',
                    descAr: '',
                    descEn: '',
                    platform: 'youtube',
                    videoUrl: '',
                    imageUrl: ''
                },

                openAdd() {
                    this.isEdit = false;
                    this.isSubmitting = false;
                    this.formAction = '{{ route("admin.podcasts.store") }}';
                    this.formData = {ar: '', en: '', descAr: '', descEn: '', platform: 'youtube', videoUrl: '', imageUrl: ''};
                    this.isOpen = true;
                },

                openEdit(id, titleAr, titleEn, descAr, descEn, platform, videoUrl, imageUrl) {
                    this.isEdit = true;
                    this.isSubmitting = false;
                    this.formAction = this.baseUrl + '/' + id;
                    this.formData = {ar: titleAr, en: titleEn, descAr: descAr, descEn: descEn, platform: platform, videoUrl: videoUrl, imageUrl: imageUrl};
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
