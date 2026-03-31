@extends('admin.layouts.app')

@section('meta_description', 'صفحة إعدادات الموقع الخاص بالدكتور محمد طلعت.')

@section('title', 'إعدادات النظام')

@section('style')

@endsection

@section('content')
    <div x-data="{ tab: 'general' }" class="max-w-6xl mx-auto pb-20">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-8 mb-12">
            <div>
                <h1 class="text-4xl font-black text-gray-900 tracking-tight">إعدادات النظام <span
                        class="text-primary/30 mx-2"></span></h1>
                <p class="text-gray-500 font-bold mt-2 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-primary animate-ping"></span>
                    إدارة شاملة لهوية الموقع، أرقام التواصل، السلايدر، والروابط الأساسية.
                </p>
            </div>

            <div
                class="inline-flex p-2 bg-white rounded-[2.5rem] shadow-xl shadow-black/[0.03] border border-gray-100 flex-wrap justify-center gap-2">
                <button type="button" @click="tab = 'general'"
                        :class="tab === 'general' ? 'bg-primary text-white shadow-lg shadow-primary/30' : 'text-gray-400 hover:bg-gray-50'"
                        class="cursor-pointer px-8 py-3 rounded-[2rem] font-black text-sm transition-all duration-500">العامة
                </button>
                <button type="button" @click="tab = 'slider'"
                        :class="tab === 'slider' ? 'bg-primary text-white shadow-lg shadow-primary/30' : 'text-gray-400 hover:bg-gray-50'"
                        class="cursor-pointer px-8 py-3 rounded-[2rem] font-black text-sm transition-all duration-500">السلايدر
                </button>
                <button type="button" @click="tab = 'social'"
                        :class="tab === 'social' ? 'bg-primary text-white shadow-lg shadow-primary/30' : 'text-gray-400 hover:bg-gray-50'"
                        class="cursor-pointer px-8 py-3 rounded-[2rem] font-black text-sm transition-all duration-500">التواصل
                </button>
                <button type="button" @click="tab = 'appearance'"
                        :class="tab === 'appearance' ? 'bg-primary text-white shadow-lg shadow-primary/30' : 'text-gray-400 hover:bg-gray-50'"
                        class="cursor-pointer px-8 py-3 rounded-[2rem] font-black text-sm transition-all duration-500">الهوية
                </button>
            </div>
        </div>

        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div x-show="tab === 'general'" x-transition:enter="transition duration-500 ease-out">
                <div
                    class="bg-white rounded-[3rem] p-10 md:p-16 shadow-sm border border-gray-50 relative overflow-hidden">
                    <div
                        class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-primary via-accent-1 to-accent-2"></div>

                    <div class="grid grid-cols-1 gap-12">
                        <div class="space-y-6">
                            <label class="flex items-center gap-3 text-xl font-black text-gray-800">
                                <span class="w-2 h-8 bg-primary rounded-full"></span>
                                اسم الموقع
                            </label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="space-y-2 relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/4 text-[10px] font-black text-primary bg-primary/10 px-2 py-1 rounded z-10">AR</span>
                                    <label class="block text-sm font-black text-gray-500">اسم الموقع (بالعربية)</label>
                                    <input type="text" name="site_name[ar]" value="{{ $settings['site_name']['ar'] ?? '' }}"
                                           placeholder="الاسم بالعربية..."
                                           class="w-full pl-14 pr-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-4 focus:ring-primary/10 transition-all font-bold text-gray-800 shadow-inner">
                                </div>
                                <div class="space-y-2 relative" dir="ltr">
                                    <span class="absolute right-4 top-1/2 -translate-y-1/4 text-[10px] font-black text-gray-400 bg-gray-200 px-2 py-1 rounded z-10">EN</span>
                                    <label class="block text-sm font-black text-gray-500 text-right">Site Name (English)</label>
                                    <input type="text" name="site_name[en]" value="{{ $settings['site_name']['en'] ?? '' }}"
                                           placeholder="Site name in English..."
                                           class="w-full pr-14 pl-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-4 focus:ring-primary/10 transition-all font-bold text-gray-800 shadow-inner">
                                </div>
                            </div>
                        </div>

                        <div class="space-y-6 pt-6 border-t border-gray-50">
                            <label class="flex items-center gap-3 text-xl font-black text-gray-800">
                                <span class="w-2 h-8 bg-accent-1 rounded-full"></span>
                                العنوان الفعلي
                            </label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="space-y-2 relative">
                                    <span class="absolute left-4 top-[52px] text-[10px] font-black text-accent-1 bg-accent-1/10 px-2 py-1 rounded z-10">AR</span>
                                    <label class="block text-sm font-black text-gray-500">العنوان بالتفصيل (بالعربية)</label>
                                    <textarea name="address[ar]" rows="3" placeholder="اكتب العنوان بالتفصيل هنا..."
                                              class="w-full pl-14 pr-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-4 focus:ring-accent-1/10 transition-all font-bold text-gray-800 shadow-inner resize-none">{{ $settings['address']['ar'] ?? '' }}</textarea>
                                </div>
                                <div class="space-y-2 relative" dir="ltr">
                                    <span class="absolute right-4 top-[52px] text-[10px] font-black text-gray-400 bg-gray-200 px-2 py-1 rounded z-10">EN</span>
                                    <label class="block text-sm font-black text-gray-500 text-right">Address Details (English)</label>
                                    <textarea name="address[en]" rows="3" placeholder="Type detailed address here..."
                                              class="w-full pr-14 pl-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-4 focus:ring-accent-1/10 transition-all font-bold text-gray-800 shadow-inner resize-none">{{ $settings['address']['en'] ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-6 pt-6 border-t border-gray-50">
                            <label class="flex items-center gap-3 text-xl font-black text-gray-800">
                                <span class="w-2 h-8 bg-accent-2 rounded-full"></span>
                                نص حقوق الفوتر
                            </label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="space-y-2 relative">
                                    <span class="absolute left-4 top-[52px] text-[10px] font-black text-accent-2 bg-accent-2/10 px-2 py-1 rounded z-10">AR</span>
                                    <label class="block text-sm font-black text-gray-500">حقوق النشر (بالعربية)</label>
                                    <textarea name="footer_text[ar]" rows="3" placeholder="جميع الحقوق محفوظة..."
                                              class="w-full pl-14 pr-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-4 focus:ring-accent-2/10 transition-all font-bold text-gray-800 shadow-inner resize-none">{{ $settings['footer_text']['ar'] ?? '' }}</textarea>
                                </div>
                                <div class="space-y-2 relative" dir="ltr">
                                    <span class="absolute right-4 top-[52px] text-[10px] font-black text-gray-400 bg-gray-200 px-2 py-1 rounded z-10">EN</span>
                                    <label class="block text-sm font-black text-gray-500 text-right">Copyrights (English)</label>
                                    <textarea name="footer_text[en]" rows="3" placeholder="All rights reserved..."
                                              class="w-full pr-14 pl-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-4 focus:ring-accent-2/10 transition-all font-bold text-gray-800 shadow-inner resize-none">{{ $settings['footer_text']['en'] ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div x-show="tab === 'slider'" x-transition:enter="transition duration-500 ease-out" style="display: none;"
                 class="space-y-10">
                @for($i = 1; $i <= 3; $i++)
                    <div
                        x-data="{ previewBanner: '{{ isset($settings['slider_'.$i.'_banner']) ? asset($settings['slider_'.$i.'_banner']) : '' }}' }"
                        class="bg-white rounded-[3rem] p-10 shadow-sm border border-gray-50 relative overflow-hidden group">
                        <div
                            class="absolute right-0 top-0 w-2 h-full bg-gray-100 group-hover:bg-primary transition-colors"></div>

                        <div class="flex items-center justify-between mb-8 border-b border-gray-50 pb-4">
                            <h3 class="text-2xl font-black text-gray-800 flex items-center gap-3">
                                <span
                                    class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center">{{ $i }}</span>
                                الشريحة (Slide {{ $i }})
                            </h3>
                            <div class="flex items-center gap-3">
                                <label class="text-sm font-black text-gray-500 uppercase">الترتيب (Order)</label>
                                <input type="number" name="slider_{{ $i }}_order"
                                       value="{{ $settings['slider_'.$i.'_order'] ?? $i }}"
                                       class="w-20 px-4 py-2 bg-gray-50 border-none rounded-xl focus:ring-4 focus:ring-primary/10 font-bold text-center text-gray-800 shadow-inner">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                            <div class="space-y-4">
                                <label class="block text-sm font-black text-gray-800">صورة البانر (Banner)</label>
                                <div
                                    class="w-full h-48 bg-slate-50 rounded-[2rem] border-2 border-dashed border-gray-200 flex items-center justify-center relative shadow-inner overflow-hidden group/image">
                                    <template x-if="previewBanner">
                                        <img :src="previewBanner"
                                             class="w-full h-full object-cover transform group-hover/image:scale-105 transition-transform duration-500">
                                    </template>
                                    <template x-if="!previewBanner">
                                        <div class="text-center text-gray-400">
                                            <svg class="w-10 h-10 mx-auto mb-2" fill="none" stroke="currentColor"
                                                 viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <span class="text-[10px] font-black uppercase">Upload Image</span>
                                        </div>
                                    </template>
                                </div>
                                <label
                                    class="w-full block py-3 bg-gray-100 text-gray-700 rounded-xl font-black text-xs hover:bg-primary hover:text-white transition-all cursor-pointer text-center">
                                    اختيار البانر
                                    <input type="file" name="slider_{{ $i }}_banner" class="hidden"
                                           @change="previewBanner = URL.createObjectURL($event.target.files[0])">
                                </label>
                            </div>

                            <div class="lg:col-span-2 space-y-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="space-y-2 relative">
                                        <span
                                            class="absolute left-4 top-10 text-[10px] font-black text-primary bg-primary/10 px-2 py-1 rounded">AR</span>
                                        <label class="block text-sm font-black text-gray-800">العنوان (Title)</label>
                                        <input type="text" name="slider_{{ $i }}_title[ar]"
                                               value="{{ $settings['slider_'.$i.'_title']['ar'] ?? '' }}"
                                               placeholder="عنوان الشريحة بالعربية"
                                               class="w-full pl-14 pr-4 py-3 bg-gray-50 border-none rounded-xl focus:ring-4 focus:ring-primary/10 font-bold text-gray-800 shadow-inner">
                                    </div>
                                    <div class="space-y-2 relative" dir="ltr">
                                        <span
                                            class="absolute right-4 top-10 text-[10px] font-black text-gray-400 bg-gray-200 px-2 py-1 rounded">EN</span>
                                        <label class="block text-sm font-black text-gray-800 text-right">العنوان (Title)</label>
                                        <input type="text" name="slider_{{ $i }}_title[en]"
                                               value="{{ $settings['slider_'.$i.'_title']['en'] ?? '' }}"
                                               placeholder="Slide title in English"
                                               class="w-full pr-14 pl-4 py-3 bg-gray-50 border-none rounded-xl focus:ring-4 focus:ring-primary/10 font-bold text-gray-800 shadow-inner">
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="space-y-2 relative">
                                        <span
                                            class="absolute left-4 top-10 text-[10px] font-black text-primary bg-primary/10 px-2 py-1 rounded">AR</span>
                                        <label class="block text-sm font-black text-gray-800">الوصف (Description)</label>
                                        <textarea name="slider_{{ $i }}_desc[ar]" rows="3" placeholder="وصف الشريحة..."
                                                  class="w-full pl-14 pr-4 py-3 bg-gray-50 border-none rounded-xl focus:ring-4 focus:ring-primary/10 font-bold text-gray-800 shadow-inner resize-none">{{ $settings['slider_'.$i.'_desc']['ar'] ?? '' }}</textarea>
                                    </div>
                                    <div class="space-y-2 relative" dir="ltr">
                                        <span
                                            class="absolute right-4 top-10 text-[10px] font-black text-gray-400 bg-gray-200 px-2 py-1 rounded">EN</span>
                                        <label class="block text-sm font-black text-gray-800 text-right">الوصف (Description)</label>
                                        <textarea name="slider_{{ $i }}_desc[en]" rows="3"
                                                  placeholder="Slide description..."
                                                  class="w-full pr-14 pl-4 py-3 bg-gray-50 border-none rounded-xl focus:ring-4 focus:ring-primary/10 font-bold text-gray-800 shadow-inner resize-none">{{ $settings['slider_'.$i.'_desc']['en'] ?? '' }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>

            <div x-show="tab === 'social'" x-transition:enter="transition duration-500" style="display: none;"
                 class="space-y-8">
                <div
                    class="bg-white rounded-[3rem] p-10 md:p-12 shadow-sm border border-gray-50 relative overflow-hidden group">
                    <div
                        class="absolute -right-20 -top-20 w-48 h-48 bg-green-500/5 rounded-full blur-3xl group-hover:bg-green-500/10 transition-colors"></div>
                    <h3 class="text-2xl font-black text-gray-900 mb-8 flex items-center gap-3 relative z-10">
                        <div class="p-2 bg-green-50 text-green-500 rounded-xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        الاتصال المباشر
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 relative z-10">
                        <div class="space-y-3 group/input">
                            <label
                                class="text-[12px] font-black text-gray-500 uppercase tracking-widest flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-[#25D366] shadow-[0_0_8px_#25D366]"></span>
                                رقم الواتساب (WhatsApp)
                            </label>
                            <div class="relative">
                                <div
                                    class="absolute inset-y-0 right-0 pr-5 flex items-center pointer-events-none transition-transform group-focus-within/input:scale-110">
                                    <svg class="w-6 h-6 text-[#25D366]" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M17.472 14.382c-.297-.149-1.758-.867-2.021-.967-.263-.099-.454-.148-.644.148-.191.297-.765.966-.938 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.305-.885-.653-1.482-1.459-1.656-1.756-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.644-1.551-.882-2.124-.231-.562-.466-.486-.644-.495-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.371-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.714.248-1.326.173-1.456-.074-.131-.272-.206-.569-.355zm-5.472 6.208h-.001c-1.49 0-2.946-.4-4.223-1.156l-.303-.179-3.138.822.84-3.06-.197-.313c-.831-1.317-1.27-2.844-1.27-4.425 0-4.636 3.773-8.41 8.414-8.41 2.247 0 4.36.876 5.949 2.466 1.588 1.589 2.463 3.704 2.463 5.952 0 4.634-3.774 8.408-8.415 8.408zm8.415-16.828c-2.248-2.25-5.236-3.489-8.417-3.489-6.559 0-11.89 5.334-11.89 11.893 0 2.096.546 4.142 1.588 5.945L.16 23.84l5.86-1.535c1.736.942 3.682 1.44 5.688 1.44h.004c6.557 0 11.89-5.335 11.89-11.895 0-3.18-.124-6.172-2.368-8.421z"/>
                                    </svg>
                                </div>
                                <input type="text" name="whatsapp" value="{{ $settings['whatsapp'] ?? '' }}"
                                       placeholder="مثال: +201000000000" dir="ltr"
                                       class="w-full pr-14 pl-6 py-5 bg-gray-50 border-none rounded-2xl focus:ring-4 focus:ring-[#25D366]/20 transition-all font-black text-gray-800 text-lg shadow-inner">
                            </div>
                        </div>
                        <div class="space-y-3 group/input">
                            <label
                                class="text-[12px] font-black text-gray-500 uppercase tracking-widest flex items-center gap-2">
                                <span
                                    class="w-2 h-2 rounded-full bg-primary shadow-[0_0_8px_rgba(30,64,175,0.5)]"></span>
                                رقم الهاتف (Phone)
                            </label>
                            <div class="relative">
                                <div
                                    class="absolute inset-y-0 right-0 pr-5 flex items-center pointer-events-none transition-transform group-focus-within/input:scale-110">
                                    <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                </div>
                                <input type="text" name="phone" value="{{ $settings['phone'] ?? '' }}"
                                       placeholder="مثال: +201000000000" dir="ltr"
                                       class="w-full pr-14 pl-6 py-5 bg-gray-50 border-none rounded-2xl focus:ring-4 focus:ring-primary/20 transition-all font-black text-gray-800 text-lg shadow-inner">
                            </div>
                        </div>
                    </div>
                    <div class="space-y-4 mt-8 pt-8 border-t border-gray-100"
                         x-data="{
                                emails: {{ isset($settings['emails']) && is_array($settings['emails']) ? json_encode($settings['emails']) : "['']" }}
                             }">
                        <div class="flex items-center justify-between mb-4">
                            <label class="text-[12px] font-black text-gray-500 uppercase tracking-widest flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-blue-500 shadow-[0_0_8px_rgba(59,130,246,0.5)]"></span>
                                البريد الإلكتروني (Emails)
                            </label>

                            <button type="button" @click="emails.push('')"
                                    class="flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-xl font-bold text-xs transition-colors cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                إضافة إيميل
                            </button>
                        </div>

                        <template x-for="(email, index) in emails" :key="index">
                            <div class="flex items-center gap-3 group/input animate-fade-in">
                                <div class="relative flex-1">
                                    <div class="absolute inset-y-0 right-0 pr-5 flex items-center pointer-events-none transition-transform group-focus-within/input:scale-110">
                                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <input type="email" name="emails[]" x-model="emails[index]"
                                           placeholder="example@domain.com" dir="ltr" required
                                           class="w-full pr-14 pl-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/20 transition-all font-bold text-gray-800 text-sm shadow-inner">
                                </div>

                                <button type="button" x-show="emails.length > 1" @click="emails.splice(index, 1)"
                                        class="p-4 bg-red-50 text-red-500 hover:bg-red-500 hover:text-white rounded-2xl transition-all cursor-pointer shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </template>
                    </div>
                </div>

                <div class="bg-white rounded-[3rem] p-10 md:p-12 shadow-sm border border-gray-50">
                    <h3 class="text-xl font-black text-gray-900 mb-8 flex items-center gap-3">
                        <div class="p-2 bg-blue-50 text-blue-500 rounded-xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                            </svg>
                        </div>
                        شبكات التواصل
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-10">
                        @php
                            $socials = [
                                'facebook' => ['color' => '#1877F2', 'icon' => 'M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z'],
                                'twitter' => ['color' => '#1DA1F2', 'icon' => 'M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.84 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z'],
                                'instagram' => ['color' => '#E4405F', 'icon' => 'M12 0C8.74 0 8.333.015 7.053.072 3.908.214 2.152 1.944 2.01 5.088.953 6.368.016 6.776.016 12s.014 5.632.072 6.912c.142 3.144 1.884 4.874 5.03 5.017C6.368 23.986 6.776 24 12 24s5.632-.014 6.912-.072c3.144-.142 4.874-1.884 5.017-5.03.058-1.28.072-1.688.072-6.912s-.014-5.632-.072-6.912C23.858 1.958 22.116.228 18.97.085 17.69.028 17.282 0 12 0zm0 2.16c3.203 0 3.58.016 4.85.074 2.353.108 3.535 1.282 3.642 3.64.058 1.27.074 1.647.074 4.85s-.016 3.58-.074 4.85c-.107 2.358-1.284 3.54-3.642 3.642-1.27.058-1.647.074-4.85.074s-3.58-.016-4.85-.074c-2.36-.102-3.54-1.284-3.642-3.642-.058-1.27-.074-1.647-.074-4.85s.016-3.58.074-4.85c.108-2.353 1.282-3.54 3.64-3.642 1.27-.058 1.647-.074 4.85-.074zm0 3.678c-3.413 0-6.182 2.769-6.182 6.182S8.587 18.2 12 18.2s6.182-2.769 6.182-6.182S15.413 5.838 12 5.838zm0 10.204c-2.22 0-4.022-1.802-4.022-4.022s1.802-4.022 4.022-4.022 4.022 1.802 4.022 4.022-1.802 4.022-4.022 4.022zm6.437-11.23a1.44 1.44 0 100 2.88 1.44 1.44 0 000-2.88z'],
                                'linkedin' => ['color' => '#0077B5', 'icon' => 'M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0z'],
                                'youtube' => ['color' => '#FF0000', 'icon' => 'M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z'],
                            ];
                        @endphp
                        @foreach($socials as $key => $info)
                            <div class="space-y-2 group/input">
                                <label
                                    class="text-[12px] font-black text-gray-500 uppercase tracking-widest px-2 flex items-center gap-2">
                                    <span style="background-color: {{ $info['color'] }}"
                                          class="w-1.5 h-1.5 rounded-full shadow-[0_0_5px_{{ $info['color'] }}]"></span> {{ $key }}
                                </label>
                                <div class="relative">
                                    <div
                                        class="absolute inset-y-0 right-0 pr-5 flex items-center pointer-events-none transition-transform group-focus-within/input:scale-110">
                                        <svg class="w-6 h-6" style="color: {{ $info['color'] }}" fill="currentColor"
                                             viewBox="0 0 24 24">
                                            <path d="{{ $info['icon'] }}"/>
                                        </svg>
                                    </div>
                                    <input type="url" name="social_links[{{ $key }}]"
                                           value="{{ $settings['social_links'][$key] ?? '' }}"
                                           placeholder="https://{{ $key }}.com/..." dir="ltr"
                                           class="w-full pr-14 pl-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-4 transition-all font-bold text-gray-800 text-sm shadow-inner"
                                           style="--tw-ring-color: {{ $info['color'] }}30;">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div x-show="tab === 'appearance'" x-transition:enter="transition duration-500" style="display: none;">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                    <div x-data="{ previewLogo: '{{ isset($settings['logo']) ? asset($settings['logo']) : '' }}' }"
                         class="bg-white rounded-[3rem] p-10 border border-gray-50 shadow-sm relative overflow-hidden group">
                        <div class="flex flex-col items-center text-center space-y-6">
                            <h3 class="text-xl font-black text-gray-900">شعار الموقع الرئيسي <span
                                    class="block text-xs text-gray-400 font-bold uppercase mt-1">Main Site Logo</span>
                            </h3>
                            <div
                                class="w-full h-56 bg-slate-50 rounded-[2.5rem] border-2 border-dashed border-gray-200 flex items-center justify-center p-8 relative shadow-inner group-hover:border-primary/40 transition-all">
                                <template x-if="previewLogo">
                                    <img :src="previewLogo"
                                         class="max-h-full drop-shadow-2xl transform group-hover:scale-105 transition-transform duration-500">
                                </template>
                                <template x-if="!previewLogo">
                                    <svg class="w-16 h-16 text-gray-200" fill="none" stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </template>
                            </div>
                            <label
                                class="w-full py-4 bg-primary text-white rounded-2xl font-black text-sm shadow-xl shadow-primary/30 hover:-translate-y-1 transition-all cursor-pointer text-center">
                                اختيار صورة الشعار
                                <input type="file" name="logo" class="hidden"
                                       @change="previewLogo = URL.createObjectURL($event.target.files[0])">
                            </label>
                        </div>
                    </div>

                    <div
                        x-data="{ previewFooter: '{{ isset($settings['footer_logo']) ? asset($settings['footer_logo']) : '' }}' }"
                        class="bg-white rounded-[3rem] p-10 border border-gray-50 shadow-sm relative overflow-hidden group">
                        <div class="flex flex-col items-center text-center space-y-6">
                            <h3 class="text-xl font-black text-gray-900">شعار الفوتر <span
                                    class="block text-xs text-gray-400 font-bold uppercase mt-1">Footer Logo</span></h3>
                            <div
                                class="w-full h-56 bg-slate-50 rounded-[2.5rem] border-2 border-dashed border-gray-200 flex items-center justify-center p-8 relative shadow-inner group-hover:border-secondary/40 transition-all bg-gray-900/5">
                                <template x-if="previewFooter">
                                    <img :src="previewFooter"
                                         class="max-h-full opacity-70 grayscale group-hover:grayscale-0 transition-all">
                                </template>
                                <template x-if="!previewFooter">
                                    <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </template>
                            </div>
                            <label
                                class="w-full py-4 bg-secondary text-white rounded-2xl font-black text-sm shadow-xl hover:-translate-y-1 transition-all cursor-pointer text-center">
                                اختيار شعار الفوتر
                                <input type="file" name="footer_logo" class="hidden"
                                       @change="previewFooter = URL.createObjectURL($event.target.files[0])">
                            </label>
                        </div>
                    </div>

                    <div
                        x-data="{ previewFavicon: '{{ isset($settings['favicon']) ? asset($settings['favicon']) : '' }}' }"
                        class="lg:col-span-2 bg-white rounded-[3rem] p-8 border border-gray-50 shadow-sm flex flex-col md:flex-row items-center justify-between gap-8">
                        <div class="flex items-center gap-6">
                            <div
                                class="w-20 h-20 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200 flex items-center justify-center shadow-inner">
                                <template x-if="previewFavicon">
                                    <img :src="previewFavicon" class="w-10 h-10">
                                </template>
                                <template x-if="!previewFavicon">
                                    <div class="w-10 h-10 bg-gray-200 rounded-full"></div>
                                </template>
                            </div>
                            <div>
                                <h3 class="text-lg font-black text-gray-900">أيقونة المتصفح</h3>
                                <p class="text-xs text-gray-400 font-bold uppercase tracking-widest">Favicon 32x32</p>
                            </div>
                        </div>
                        <label
                            class="cursor-pointer px-10 py-4 bg-gray-100 text-gray-600 rounded-2xl font-black text-xs hover:bg-gray-200 transition-all text-center">
                            تحديث الأيقونة
                            <input type="file" name="favicon" class="hidden"
                                   @change="previewFavicon = URL.createObjectURL($event.target.files[0])">
                        </label>
                    </div>
                </div>
            </div>

            <div
                class="mt-16 p-10 bg-secondary rounded-[3rem] shadow-2xl shadow-secondary/40 flex flex-col md:flex-row items-center justify-between gap-6 relative overflow-hidden group">
                <div
                    class="absolute right-0 top-0 w-64 h-full bg-primary/20 skew-x-12 transform origin-right group-hover:scale-110 transition-transform duration-700"></div>
                <div class="relative z-10 text-white">
                    <h4 class="text-2xl font-black">هل انتهيت من التعديلات؟</h4>
                    <p class="text-gray-400 text-sm mt-1">سيتم حفظ كافة البيانات وتحديثها في الموقع فوراً.</p>
                </div>
                <button type="submit" id="save-submit-btn"
                        class="cursor-pointer flex items-center justify-center gap-3 relative z-10 w-full md:w-auto px-20 py-5 bg-white text-secondary rounded-[1.5rem] shadow-2xl font-black text-xl hover:scale-105 transition-all duration-500 disabled:opacity-70 disabled:cursor-not-allowed">

                    <span id="save-btn-text">حفـظ التـعديــلات الان</span>

                    <svg id="save-btn-loader" class="hidden w-6 h-6 animate-spin text-secondary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </button>
            </div>
        </form>
    </div>
@endsection
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const saveBtn = document.getElementById('save-submit-btn');
            const btnText = document.getElementById('save-btn-text');
            const btnLoader = document.getElementById('save-btn-loader');
            const form = saveBtn.closest('form');

            if (form) {
                form.addEventListener('submit', function () {
                    saveBtn.disabled = true;
                    btnText.innerText = "جاري الحفظ...";
                    btnLoader.classList.remove('hidden');
                    saveBtn.classList.remove('hover:scale-105');
                });
            }
        });
    </script>
@endsection
