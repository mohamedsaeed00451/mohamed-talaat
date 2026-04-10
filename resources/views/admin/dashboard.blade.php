@extends('admin.layouts.app')

@section('meta_description', 'لوحة التحكم الخاصة بموقع دكتور محمد طلعت.')

@section('title', 'نـظـرة عـامـة')

@section('content')

    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.6);
        }

        .blob-glow {
            filter: blur(40px);
            opacity: 0.4;
            transition: all 0.5s ease;
        }

        .group:hover .blob-glow {
            opacity: 0.8;
            transform: scale(1.2);
        }

        .text-gradient {
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>

    <div class="max-w-7xl mx-auto pb-20 relative">

        <div
            class="fixed top-0 right-0 -z-10 w-[40rem] h-[40rem] bg-primary/5 rounded-full blur-[100px] pointer-events-none"></div>
        <div
            class="fixed bottom-0 left-0 -z-10 w-[30rem] h-[30rem] bg-indigo-500/5 rounded-full blur-[100px] pointer-events-none"></div>

        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-12">
            <div>
                <h1 class="text-4xl font-black tracking-tight text-transparent bg-clip-text bg-gradient-to-l from-gray-900 to-gray-600 drop-shadow-sm">
                    نظرة عامة ومركز القيادة</h1>
                <p class="text-gray-500 font-bold mt-3 flex items-center gap-2">
                    <span class="relative flex h-3 w-3">
                      <span
                          class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-50"></span>
                      <span
                          class="relative inline-flex rounded-full h-3 w-3 bg-primary shadow-[0_0_10px_rgba(30,64,175,0.8)]"></span>
                    </span>
                    إحصائيات النظام الفورية وأحدث التطورات اليوم.
                </p>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.posts.create') }}"
                   class="group relative px-8 py-3.5 bg-gradient-to-r from-primary to-blue-600 text-white rounded-2xl shadow-[0_10px_25px_-5px_rgba(30,64,175,0.5)] font-black hover:-translate-y-1 hover:shadow-[0_15px_30px_-5px_rgba(30,64,175,0.6)] transition-all duration-300 flex items-center gap-3 overflow-hidden">
                    <div
                        class="absolute inset-0 bg-white/20 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                    <div class="p-1.5 bg-white/20 rounded-lg group-hover:rotate-180 transition-transform duration-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                  d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                    كتابة مقال جديد
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-8 mb-12">
            <a href="{{ route('admin.posts.index') }}"
               class="group glass-card rounded-[2.5rem] p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_20px_40px_rgba(79,70,229,0.1)] hover:border-indigo-200 hover:-translate-y-1.5 transition-all duration-500 overflow-hidden block relative">
                <div
                    class="absolute -right-10 -top-10 w-40 h-40 bg-indigo-500/20 rounded-full blob-glow pointer-events-none"></div>
                <div
                    class="absolute -left-10 -bottom-10 w-40 h-40 bg-purple-500/10 rounded-full blob-glow pointer-events-none"></div>

                <div class="relative z-10 flex flex-col h-full justify-between gap-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-16 h-16 rounded-[1.2rem] bg-gradient-to-br from-indigo-500 to-purple-600 shadow-[0_10px_20px_rgba(99,102,241,0.4)] flex items-center justify-center text-white transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 relative">
                                <div class="absolute inset-0 bg-white/20 rounded-[1.2rem] animate-pulse"></div>
                                <svg class="w-8 h-8 relative z-10" fill="none" stroke="currentColor"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-black text-indigo-500/80 uppercase tracking-widest mb-1">المقالات
                                    والأعمدة</p>
                                <h3 class="text-5xl font-black text-gradient bg-gradient-to-r from-gray-900 to-indigo-800 leading-none">{{ $postsStats['total'] }}</h3>
                            </div>
                        </div>
                        <div class="hidden sm:block">
                            <span
                                class="px-4 py-2 bg-indigo-50 text-indigo-600 rounded-xl text-xs font-black border border-indigo-100/50 group-hover:bg-indigo-600 group-hover:text-white transition-colors">إدارة المقالات →</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-2">
                        <div
                            class="bg-white/60 backdrop-blur-md rounded-2xl p-4 border border-green-100 shadow-sm hover:shadow-md hover:scale-105 transition-all duration-300">
                            <div
                                class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-600 mb-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                          d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <p class="text-[11px] font-black text-gray-500 mb-1">منشور وحي</p>
                            <p class="text-2xl font-black text-green-600 leading-none">{{ $postsStats['published'] }}</p>
                        </div>
                        <div
                            class="bg-white/60 backdrop-blur-md rounded-2xl p-4 border border-orange-100 shadow-sm hover:shadow-md hover:scale-105 transition-all duration-300">
                            <div
                                class="w-8 h-8 rounded-full bg-orange-100 flex items-center justify-center text-orange-500 mb-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <p class="text-[11px] font-black text-gray-500 mb-1">مجدول للنشر</p>
                            <p class="text-2xl font-black text-orange-500 leading-none">{{ $postsStats['scheduled'] }}</p>
                        </div>
                        <div
                            class="bg-white/60 backdrop-blur-md rounded-2xl p-4 border border-yellow-100 shadow-sm hover:shadow-md hover:scale-105 transition-all duration-300">
                            <div
                                class="w-8 h-8 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600 mb-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                          d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                </svg>
                            </div>
                            <p class="text-[11px] font-black text-gray-500 mb-1">مقال مميز</p>
                            <p class="text-2xl font-black text-yellow-500 leading-none">{{ $postsStats['featured'] }}</p>
                        </div>
                        <div
                            class="bg-white/60 backdrop-blur-md rounded-2xl p-4 border border-gray-200 shadow-sm hover:shadow-md hover:scale-105 transition-all duration-300">
                            <div
                                class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 mb-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                          d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                </svg>
                            </div>
                            <p class="text-[11px] font-black text-gray-500 mb-1">أرشيف</p>
                            <p class="text-2xl font-black text-gray-700 leading-none">{{ $postsStats['old'] }}</p>
                        </div>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.articles.index') }}"
               class="group glass-card rounded-[2.5rem] p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_20px_40px_rgba(30,64,175,0.1)] hover:border-primary/30 hover:-translate-y-1.5 transition-all duration-500 overflow-hidden block relative">
                <div
                    class="absolute -right-10 -top-10 w-40 h-40 bg-primary/20 rounded-full blob-glow pointer-events-none"></div>
                <div
                    class="absolute -left-10 -bottom-10 w-40 h-40 bg-blue-500/10 rounded-full blob-glow pointer-events-none"></div>

                <div class="relative z-10 flex flex-col h-full justify-between gap-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-16 h-16 rounded-[1.2rem] bg-gradient-to-br from-primary to-blue-600 shadow-[0_10px_20px_rgba(30,64,175,0.4)] flex items-center justify-center text-white transform group-hover:scale-110 group-hover:-rotate-6 transition-all duration-500 relative">
                                <div class="absolute inset-0 bg-white/20 rounded-[1.2rem] animate-pulse"></div>
                                <svg class="w-8 h-8 relative z-10" fill="none" stroke="currentColor"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-black text-primary/80 uppercase tracking-widest mb-1">التحليلات
                                    المنشورة</p>
                                <h3 class="text-5xl font-black text-gradient bg-gradient-to-r from-gray-900 to-primary leading-none">{{ $articlesStats['total'] }}</h3>
                            </div>
                        </div>
                        <div class="hidden sm:block">
                            <span
                                class="px-4 py-2 bg-blue-50 text-primary rounded-xl text-xs font-black border border-blue-100/50 group-hover:bg-primary group-hover:text-white transition-colors">إدارة التحليلات →</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-2">
                        <div
                            class="bg-white/60 backdrop-blur-md rounded-2xl p-4 border border-green-100 shadow-sm hover:shadow-md hover:scale-105 transition-all duration-300">
                            <div
                                class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-600 mb-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                          d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <p class="text-[11px] font-black text-gray-500 mb-1">مفعل للزوار</p>
                            <p class="text-2xl font-black text-green-600 leading-none">{{ $articlesStats['published'] }}</p>
                        </div>
                        <div
                            class="bg-white/60 backdrop-blur-md rounded-2xl p-4 border border-orange-100 shadow-sm hover:shadow-md hover:scale-105 transition-all duration-300">
                            <div
                                class="w-8 h-8 rounded-full bg-orange-100 flex items-center justify-center text-orange-500 mb-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <p class="text-[11px] font-black text-gray-500 mb-1">مجدول للنشر</p>
                            <p class="text-2xl font-black text-orange-500 leading-none">{{ $articlesStats['scheduled'] }}</p>
                        </div>
                        <div
                            class="bg-white/60 backdrop-blur-md rounded-2xl p-4 border border-yellow-100 shadow-sm hover:shadow-md hover:scale-105 transition-all duration-300">
                            <div
                                class="w-8 h-8 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600 mb-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                          d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                </svg>
                            </div>
                            <p class="text-[11px] font-black text-gray-500 mb-1">تحليل مميز</p>
                            <p class="text-2xl font-black text-yellow-500 leading-none">{{ $articlesStats['featured'] }}</p>
                        </div>
                        <div
                            class="bg-white/60 backdrop-blur-md rounded-2xl p-4 border border-gray-200 shadow-sm hover:shadow-md hover:scale-105 transition-all duration-300">
                            <div
                                class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 mb-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                          d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                </svg>
                            </div>
                            <p class="text-[11px] font-black text-gray-500 mb-1">أرشيف</p>
                            <p class="text-2xl font-black text-gray-700 leading-none">{{ $articlesStats['old'] }}</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="mb-12">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-6 px-2">
                <div class="flex items-center gap-3">
                    <div
                        class="p-2.5 bg-gradient-to-br from-gray-800 to-gray-900 rounded-xl shadow-lg shadow-gray-900/20 text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-black text-gray-900 tracking-tight">التوزيع على منصات التواصل</h2>
                        <p class="text-xs font-bold text-gray-500 mt-1">المقالات والتحليلات التي تم إرسالها آلياً
                            للمنصات المختلفة</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
                <div
                    class="group glass-card rounded-[2rem] p-6 shadow-sm hover:shadow-[0_15px_30px_rgba(24,119,242,0.15)] hover:border-[#1877F2]/40 hover:-translate-y-1.5 transition-all duration-500 overflow-hidden relative">
                    <div
                        class="absolute -right-4 -top-4 w-24 h-24 bg-[#1877F2]/15 rounded-full blob-glow pointer-events-none"></div>
                    <div class="relative z-10 flex items-center justify-between">
                        <div class="flex flex-col gap-1">
                            <p class="text-[11px] font-black text-gray-500 uppercase tracking-wider">فيسبوك</p>
                            <h3 class="text-4xl font-black text-[#1877F2]">{{ $socialStats['facebook'] }}</h3>
                        </div>
                        <div
                            class="w-14 h-14 rounded-[1.2rem] bg-[#1877F2]/10 border border-[#1877F2]/20 flex items-center justify-center text-[#1877F2] transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 shadow-sm">
                            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div
                    class="group glass-card rounded-[2rem] p-6 shadow-sm hover:shadow-[0_15px_30px_rgba(0,0,0,0.15)] hover:border-gray-900/40 hover:-translate-y-1.5 transition-all duration-500 overflow-hidden relative">
                    <div
                        class="absolute -right-4 -top-4 w-24 h-24 bg-gray-500/15 rounded-full blob-glow pointer-events-none"></div>
                    <div class="relative z-10 flex items-center justify-between">
                        <div class="flex flex-col gap-1">
                            <p class="text-[11px] font-black text-gray-500 uppercase tracking-wider">منصة X</p>
                            <h3 class="text-4xl font-black text-gray-900">{{ $socialStats['twitter'] }}</h3>
                        </div>
                        <div
                            class="w-14 h-14 rounded-[1.2rem] bg-gray-100 border border-gray-200 flex items-center justify-center text-gray-900 transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 shadow-sm">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.008 5.922H5.078z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div
                    class="group glass-card rounded-[2rem] p-6 shadow-sm hover:shadow-[0_15px_30px_rgba(10,102,194,0.15)] hover:border-[#0A66C2]/40 hover:-translate-y-1.5 transition-all duration-500 overflow-hidden relative">
                    <div
                        class="absolute -right-4 -top-4 w-24 h-24 bg-[#0A66C2]/15 rounded-full blob-glow pointer-events-none"></div>
                    <div class="relative z-10 flex items-center justify-between">
                        <div class="flex flex-col gap-1">
                            <p class="text-[11px] font-black text-gray-500 uppercase tracking-wider">لينكد إن</p>
                            <h3 class="text-4xl font-black text-[#0A66C2]">{{ $socialStats['linkedin'] }}</h3>
                        </div>
                        <div
                            class="w-14 h-14 rounded-[1.2rem] bg-[#0A66C2]/10 border border-[#0A66C2]/20 flex items-center justify-center text-[#0A66C2] transform group-hover:scale-110 group-hover:-rotate-6 transition-all duration-500 shadow-sm">
                            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div
                    class="group glass-card rounded-[2rem] p-6 shadow-sm hover:shadow-[0_15px_30px_rgba(225,48,108,0.15)] hover:border-[#E1306C]/40 hover:-translate-y-1.5 transition-all duration-500 overflow-hidden relative">
                    <div
                        class="absolute -right-4 -top-4 w-24 h-24 bg-[#E1306C]/15 rounded-full blob-glow pointer-events-none"></div>
                    <div class="relative z-10 flex items-center justify-between">
                        <div class="flex flex-col gap-1">
                            <p class="text-[11px] font-black text-gray-500 uppercase tracking-wider">إنستجرام</p>
                            <h3 class="text-4xl font-black text-transparent bg-clip-text bg-gradient-to-tr from-[#F58529] via-[#DD2A7B] to-[#8134AF]">{{ $socialStats['instagram'] }}</h3>
                        </div>
                        <div
                            class="w-14 h-14 rounded-[1.2rem] bg-gradient-to-tr from-[#F58529] via-[#DD2A7B] to-[#8134AF] flex items-center justify-center text-white transform group-hover:scale-110 group-hover:-rotate-6 transition-all duration-500 shadow-md shadow-[#DD2A7B]/30">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <a href="{{ route('admin.galleries.index') }}"
               class="group glass-card rounded-[2rem] p-6 shadow-sm hover:shadow-[0_15px_30px_rgba(236,72,153,0.1)] hover:border-pink-200 hover:-translate-y-1 transition-all duration-500 overflow-hidden block relative">
                <div
                    class="absolute -right-4 -top-4 w-24 h-24 bg-pink-500/10 rounded-full blob-glow pointer-events-none"></div>
                <div class="relative z-10 flex flex-col gap-4">
                    <div
                        class="w-12 h-12 rounded-[1rem] bg-gradient-to-br from-pink-500 to-rose-500 shadow-lg shadow-pink-500/30 flex items-center justify-center text-white transform group-hover:scale-110 transition-all duration-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-black text-gray-500 mb-1">ألبومات الصور</p>
                        <h3 class="text-3xl font-black text-gray-900">{{ $galleriesCount }}</h3>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.podcasts.index') }}"
               class="group glass-card rounded-[2rem] p-6 shadow-sm hover:shadow-[0_15px_30px_rgba(16,185,129,0.1)] hover:border-emerald-200 hover:-translate-y-1 transition-all duration-500 overflow-hidden block relative">
                <div
                    class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-500/10 rounded-full blob-glow pointer-events-none"></div>
                <div class="relative z-10 flex flex-col gap-4">
                    <div
                        class="w-12 h-12 rounded-[1rem] bg-gradient-to-br from-emerald-400 to-green-600 shadow-lg shadow-emerald-500/30 flex items-center justify-center text-white transform group-hover:scale-110 transition-all duration-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-black text-gray-500 mb-1">حلقات البودكاست</p>
                        <h3 class="text-3xl font-black text-gray-900">{{ $podcastsCount }}</h3>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.conferences.index') }}"
               class="group glass-card rounded-[2rem] p-6 shadow-sm hover:shadow-[0_15px_30px_rgba(6,182,212,0.1)] hover:border-cyan-200 hover:-translate-y-1 transition-all duration-500 overflow-hidden block relative">
                <div
                    class="absolute -right-4 -top-4 w-24 h-24 bg-cyan-500/10 rounded-full blob-glow pointer-events-none"></div>
                <div class="relative z-10 flex flex-col gap-4">
                    <div
                        class="w-12 h-12 rounded-[1rem] bg-gradient-to-br from-cyan-400 to-blue-500 shadow-lg shadow-cyan-500/30 flex items-center justify-center text-white transform group-hover:scale-110 transition-all duration-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-black text-gray-500 mb-1">اللقاءات المرئية</p>
                        <h3 class="text-3xl font-black text-gray-900">{{ $conferencesCount }}</h3>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.vault.index') }}"
               class="group glass-card rounded-[2rem] p-6 shadow-sm hover:shadow-[0_15px_30px_rgba(234,179,8,0.1)] hover:border-yellow-200 hover:-translate-y-1 transition-all duration-500 overflow-hidden block relative">
                <div
                    class="absolute -right-4 -top-4 w-24 h-24 bg-yellow-500/10 rounded-full blob-glow pointer-events-none"></div>
                <div class="relative z-10 flex flex-col gap-4">
                    <div
                        class="w-12 h-12 rounded-[1rem] bg-gradient-to-br from-yellow-400 to-orange-500 shadow-lg shadow-yellow-500/30 flex items-center justify-center text-white transform group-hover:scale-110 transition-all duration-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-black text-gray-500 mb-1">ملفات الخزنة</p>
                        <h3 class="text-3xl font-black text-gray-900">{{ $vaultFilesCount }}</h3>
                    </div>
                </div>
            </a>

        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div
                class="lg:col-span-2 glass-card rounded-[2.5rem] p-8 md:p-10 shadow-[0_8px_30px_rgb(0,0,0,0.04)] relative overflow-hidden">
                <div class="flex items-center justify-between mb-8 pb-4 border-b border-gray-100">
                    <h3 class="text-2xl font-black text-gray-900 flex items-center gap-3">
                        <div
                            class="p-2.5 bg-gradient-to-br from-red-500 to-pink-500 text-white rounded-xl shadow-lg shadow-red-500/20">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                      d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        صندوق الوارد (أحدث {{ $latestContacts->count() }})
                    </h3>
                    <a href="{{ route('admin.contacts.index') }}"
                       class="px-5 py-2.5 bg-gray-50 hover:bg-red-50 text-gray-700 hover:text-red-600 font-black text-sm rounded-xl transition-colors border border-gray-100 flex items-center gap-2">
                        إجمالي: {{ $contactsCount }} رسالة
                        <svg class="w-4 h-4 transform rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>

                <div class="space-y-4">
                    @forelse ($latestContacts as $contact)
                        <div
                            class="flex items-center justify-between p-4 sm:p-5 rounded-2xl bg-white/50 hover:bg-white shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100 hover:border-red-100 group">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-12 h-12 rounded-[1rem] bg-gray-50 border border-gray-100 flex items-center justify-center font-black text-gray-400 group-hover:text-red-500 group-hover:bg-red-50 transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-black text-gray-900 text-sm sm:text-base">{{ $contact->name ?? 'رسالة جديدة' }}</p>
                                    <p class="text-[11px] text-gray-400 font-bold mt-1">{{ $contact->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <span
                                class="px-4 py-1.5 sm:px-5 sm:py-2 bg-red-50 text-red-600 border border-red-100/50 text-[11px] sm:text-xs font-black rounded-full shadow-sm">{{ $contact->type->name['ar'] ?? 'تواصل' }}</span>
                        </div>
                    @empty
                        <div
                            class="p-10 flex flex-col items-center justify-center text-gray-400 border-2 border-dashed border-gray-100 rounded-2xl">
                            <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" stroke="currentColor"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                            </svg>
                            <span class="font-black">صندوق الوارد فارغ</span>
                        </div>
                    @endforelse
                </div>
            </div>

            @php
                $targetSubscribers = 1000;
                $progressPercentage = min(100, round(($subscribersCount / $targetSubscribers) * 100));
            @endphp
            <div
                class="bg-[#0f172a] rounded-[2.5rem] p-10 shadow-[0_20px_50px_rgba(0,0,0,0.3)] border border-white/10 relative overflow-hidden group">
                <div
                    class="absolute -top-20 -right-20 w-72 h-72 bg-accent-1/30 rounded-full blur-[80px] group-hover:bg-accent-1/40 transition-colors duration-700"></div>
                <div
                    class="absolute -bottom-20 -left-20 w-52 h-52 bg-primary/30 rounded-full blur-[60px] group-hover:bg-primary/50 transition-colors duration-700"></div>

                <div class="relative z-10 h-full flex flex-col justify-between">
                    <div>
                        <div
                            class="w-14 h-14 rounded-[1.2rem] bg-white/10 text-white flex items-center justify-center backdrop-blur-md border border-white/20 mb-6 shadow-[0_0_15px_rgba(255,255,255,0.1)]">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-3xl font-black text-white mb-2 tracking-wide">الجمهور المستهدف</h3>
                        <p class="text-gray-400 font-bold leading-relaxed text-sm">تم تحقيق <span
                                class="text-white font-black text-base drop-shadow-[0_0_5px_rgba(255,255,255,0.5)]">{{ $progressPercentage }}%</span>
                            من هدفك للوصول للرقم الذهبي ({{ $targetSubscribers }} مشترك).</p>
                    </div>

                    <div class="py-10">
                        <div class="flex justify-between text-xs font-black text-white mb-3 tracking-widest">
                            <span class="bg-white/10 px-3 py-1 rounded-lg backdrop-blur-sm">{{ $subscribersCount }} حالياً</span>
                            <span
                                class="text-gray-400 bg-black/30 px-3 py-1 rounded-lg backdrop-blur-sm">الهدف {{ $targetSubscribers }}</span>
                        </div>
                        <div class="w-full h-4 bg-black/50 rounded-full overflow-hidden border border-white/10 p-0.5">
                            <div
                                class="h-full bg-gradient-to-r from-primary via-blue-400 to-accent-1 rounded-full shadow-[0_0_20px_rgba(96,165,250,0.8)] relative transition-all duration-1000 ease-out"
                                style="width: {{ $progressPercentage }}%">
                                <div
                                    class="absolute inset-0 bg-white/30 w-full h-full animate-[translateX_2s_infinite] rounded-full"></div>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('admin.subscribers.index') }}"
                       class="block text-center w-full py-4 bg-white/10 hover:bg-white text-white hover:text-gray-900 backdrop-blur-sm border border-white/20 font-black rounded-2xl hover:scale-105 hover:shadow-[0_10px_30px_rgba(255,255,255,0.3)] transition-all duration-500">
                        إدارة المشتركين
                    </a>
                </div>
            </div>

        </div>
    </div>
@endsection
