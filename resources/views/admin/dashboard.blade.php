@extends('admin.layouts.app')

@section('meta_description', 'لوحة التحكم الخاصة بموقع دكتور محمد طلعت.')

@section('title', 'نـظـرة عـامـة')

@section('content')
    <div class="max-w-7xl mx-auto pb-20">

        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-12">
            <div>
                <h1 class="text-4xl font-black text-gray-900 tracking-tight">نظرة عامة</h1>
                <p class="text-gray-500 font-bold mt-2 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                    إحصائيات النظام وأحدث التطورات اليوم.
                </p>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.posts.create') }}" class="px-8 py-3 bg-primary text-white rounded-2xl shadow-lg shadow-primary/30 font-black hover:-translate-y-1 transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    كتابة مقال جديد
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">

            <a href="{{ route('admin.articles.index') }}" class="group relative bg-white rounded-[2rem] p-8 shadow-[0_20px_50px_rgba(0,0,0,0.03)] border border-gray-50 hover:border-primary/20 hover:-translate-y-1 transition-all duration-500 overflow-hidden block">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-primary/5 rounded-full blur-2xl group-hover:bg-primary/10 transition-colors"></div>
                <div class="relative z-10 flex flex-col gap-6">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-primary to-blue-600 shadow-lg shadow-primary/30 flex items-center justify-center text-white transform group-hover:rotate-6 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-black text-gray-400 uppercase tracking-widest mb-1">التحليلات</p>
                        <h3 class="text-3xl font-black text-gray-900 leading-none">{{ $articlesCount }}</h3>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.posts.index') }}" class="group relative bg-white rounded-[2rem] p-8 shadow-[0_20px_50px_rgba(0,0,0,0.03)] border border-gray-50 hover:border-indigo-200 hover:-translate-y-1 transition-all duration-500 overflow-hidden block">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-indigo-500/5 rounded-full blur-2xl group-hover:bg-indigo-500/10 transition-colors"></div>
                <div class="relative z-10 flex flex-col gap-6">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 shadow-lg shadow-indigo-500/30 flex items-center justify-center text-white transform group-hover:rotate-6 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-black text-gray-400 uppercase tracking-widest mb-1">المقالات والأعمدة</p>
                        <h3 class="text-3xl font-black text-gray-900 leading-none">{{ $postsCount }}</h3>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.galleries.index') }}" class="group relative bg-white rounded-[2rem] p-8 shadow-[0_20px_50px_rgba(0,0,0,0.03)] border border-gray-50 hover:border-pink-200 hover:-translate-y-1 transition-all duration-500 overflow-hidden block">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-pink-500/5 rounded-full blur-2xl group-hover:bg-pink-500/10 transition-colors"></div>
                <div class="relative z-10 flex flex-col gap-6">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-pink-500 to-rose-500 shadow-lg shadow-pink-500/30 flex items-center justify-center text-white transform group-hover:rotate-6 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-black text-gray-400 uppercase tracking-widest mb-1">ألبومات الصور</p>
                        <h3 class="text-3xl font-black text-gray-900 leading-none">{{ $galleriesCount }}</h3>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.podcasts.index') }}" class="group relative bg-white rounded-[2rem] p-8 shadow-[0_20px_50px_rgba(0,0,0,0.03)] border border-gray-50 hover:border-emerald-200 hover:-translate-y-1 transition-all duration-500 overflow-hidden block">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-500/5 rounded-full blur-2xl group-hover:bg-emerald-500/10 transition-colors"></div>
                <div class="relative z-10 flex flex-col gap-6">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-400 to-green-600 shadow-lg shadow-emerald-500/30 flex items-center justify-center text-white transform group-hover:rotate-6 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-black text-gray-400 uppercase tracking-widest mb-1">البودكاست</p>
                        <h3 class="text-3xl font-black text-gray-900 leading-none">{{ $podcastsCount }}</h3>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.conferences.index') }}" class="group relative bg-white rounded-[2rem] p-8 shadow-[0_20px_50px_rgba(0,0,0,0.03)] border border-gray-50 hover:border-cyan-200 hover:-translate-y-1 transition-all duration-500 overflow-hidden block">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-cyan-500/5 rounded-full blur-2xl group-hover:bg-cyan-500/10 transition-colors"></div>
                <div class="relative z-10 flex flex-col gap-6">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-cyan-400 to-blue-500 shadow-lg shadow-cyan-500/30 flex items-center justify-center text-white transform group-hover:rotate-6 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-black text-gray-400 uppercase tracking-widest mb-1">اللقاءات المرئية</p>
                        <h3 class="text-3xl font-black text-gray-900 leading-none">{{ $conferencesCount }}</h3>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.vault.index') }}" class="group relative bg-white rounded-[2rem] p-8 shadow-[0_20px_50px_rgba(0,0,0,0.03)] border border-gray-50 hover:border-yellow-200 hover:-translate-y-1 transition-all duration-500 overflow-hidden block">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-yellow-500/5 rounded-full blur-2xl group-hover:bg-yellow-500/10 transition-colors"></div>
                <div class="relative z-10 flex flex-col gap-6">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-yellow-400 to-orange-500 shadow-lg shadow-yellow-500/30 flex items-center justify-center text-white transform group-hover:rotate-6 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-black text-gray-400 uppercase tracking-widest mb-1">ملفات الخزنة</p>
                        <h3 class="text-3xl font-black text-gray-900 leading-none">{{ $vaultFilesCount }}</h3>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.contacts.index') }}" class="group relative bg-white rounded-[2rem] p-8 shadow-[0_20px_50px_rgba(0,0,0,0.03)] border border-gray-50 hover:border-red-200 hover:-translate-y-1 transition-all duration-500 overflow-hidden block">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-red-500/5 rounded-full blur-2xl group-hover:bg-red-500/10 transition-colors"></div>
                <div class="relative z-10 flex flex-col gap-6">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-red-500 to-pink-600 shadow-lg shadow-red-500/30 flex items-center justify-center text-white transform group-hover:-rotate-6 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-black text-gray-400 uppercase tracking-widest mb-1">إجمالي الرسائل</p>
                        <h3 class="text-3xl font-black text-gray-900 leading-none">{{ $contactsCount }}</h3>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.subscribers.index') }}" class="group relative bg-white rounded-[2rem] p-8 shadow-[0_20px_50px_rgba(0,0,0,0.03)] border border-gray-50 hover:border-accent-2/20 hover:-translate-y-1 transition-all duration-500 overflow-hidden block">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-accent-2/5 rounded-full blur-2xl group-hover:bg-accent-2/10 transition-colors"></div>
                <div class="relative z-10 flex flex-col gap-6">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-accent-1 to-accent-2 shadow-lg shadow-accent-2/30 flex items-center justify-center text-white transform group-hover:rotate-6 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-black text-gray-400 uppercase tracking-widest mb-1">القائمة البريدية</p>
                        <h3 class="text-3xl font-black text-gray-900 leading-none">{{ $subscribersCount }}</h3>
                    </div>
                </div>
            </a>

        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2 bg-white rounded-[2.5rem] p-8 md:p-10 shadow-[0_20px_50px_rgba(0,0,0,0.02)] border border-gray-50 relative overflow-hidden">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-2xl font-black text-gray-900 flex items-center gap-3">
                        <div class="p-2 bg-primary/10 text-primary rounded-xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                        </div>
                        أحدث رسائل التواصل
                    </h3>
                    <a href="{{ route('admin.contacts.index') }}" class="text-primary font-black text-sm hover:underline flex items-center gap-1">
                        كل الرسائل
                        <svg class="w-4 h-4 transform rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>

                <div class="space-y-4">
                    @forelse ($latestContacts as $contact)
                        <div class="flex items-center justify-between p-5 rounded-2xl bg-gray-50 hover:bg-white hover:shadow-md transition-all border border-transparent hover:border-gray-100 group">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-white border border-gray-100 flex items-center justify-center font-black text-gray-400 group-hover:text-primary group-hover:bg-primary/5 transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                <div>
                                    <p class="font-black text-gray-900">{{ $contact->name ?? 'رسالة جديدة' }}</p>
                                    <p class="text-xs text-gray-400 font-bold mt-1">{{ $contact->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <span class="px-5 py-2 bg-blue-50 text-primary text-xs font-black rounded-full">{{ $contact->type->name['ar'] ?? 'تواصل' }}</span>
                        </div>
                    @empty
                        <div class="p-8 text-center text-gray-400 font-bold">
                            لا توجد رسائل تواصل حتى الآن.
                        </div>
                    @endforelse
                </div>
            </div>

            @php
                $targetSubscribers = 1000;
                $progressPercentage = min(100, round(($subscribersCount / $targetSubscribers) * 100));
            @endphp
            <div class="bg-gradient-to-br from-secondary to-black rounded-[2.5rem] p-10 shadow-2xl relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-64 h-64 bg-primary/20 rounded-full blur-[60px] group-hover:bg-primary/30 transition-colors duration-700"></div>
                <div class="absolute bottom-0 left-0 w-32 h-32 bg-accent-1/20 rounded-full blur-[40px]"></div>

                <div class="relative z-10 h-full flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-white/10 text-white flex items-center justify-center backdrop-blur-sm border border-white/10 mb-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <h3 class="text-3xl font-black text-white mb-2">توسيع الجمهور</h3>
                        <p class="text-gray-400 font-bold leading-relaxed">لقد حققت <span class="text-white font-black">{{ $progressPercentage }}%</span> من هدفك للوصول إلى 1000 مشترك في القائمة البريدية.</p>
                    </div>

                    <div class="py-8">
                        <div class="flex justify-between text-xs font-black text-white mb-3">
                            <span>المشتركين: {{ $subscribersCount }}</span>
                            <span class="text-gray-400">الهدف: {{ $targetSubscribers }}</span>
                        </div>
                        <div class="w-full h-3 bg-white/10 rounded-full overflow-hidden border border-white/5">
                            <div class="h-full bg-gradient-to-r from-primary to-accent-1 shadow-[0_0_15px_rgba(30,64,175,0.8)] relative transition-all duration-1000" style="width: {{ $progressPercentage }}%">
                                <div class="absolute inset-0 bg-white/20 w-full h-full animate-[translateX_2s_infinite]"></div>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('admin.subscribers.index') }}" class="block text-center w-full py-4 bg-white text-secondary font-black rounded-2xl hover:scale-105 hover:shadow-[0_10px_20px_rgba(255,255,255,0.2)] transition-all duration-300">
                        إدارة المشتركين
                    </a>
                </div>
            </div>

        </div>
    </div>
@endsection
