@extends('admin.layouts.app')

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
                <button class="px-6 py-3 bg-white border border-gray-100 rounded-2xl shadow-sm font-bold text-gray-600 hover:bg-gray-50 hover:text-primary transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    تصدير تقرير
                </button>
                <button class="px-8 py-3 bg-primary text-white rounded-2xl shadow-lg shadow-primary/30 font-black hover:-translate-y-1 transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    تحديث البيانات
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">

            <div class="group relative bg-white rounded-[2rem] p-8 shadow-[0_20px_50px_rgba(0,0,0,0.03)] border border-gray-50 hover:border-primary/20 hover:-translate-y-1 transition-all duration-500 overflow-hidden">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-primary/5 rounded-full blur-2xl group-hover:bg-primary/10 transition-colors"></div>
                <div class="relative z-10 flex flex-col gap-6">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-primary to-blue-600 shadow-lg shadow-primary/30 flex items-center justify-center text-white transform group-hover:rotate-6 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-black text-gray-400 uppercase tracking-widest mb-1">إجمالي المبيعات</p>
                        <h3 class="text-3xl font-black text-gray-900 leading-none">$24,500</h3>
                    </div>
                    <div class="flex items-center gap-2 px-3 py-1.5 bg-green-50 rounded-full w-fit">
                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                        <span class="text-xs font-black text-green-600">+12.5%</span>
                    </div>
                </div>
            </div>

            <div class="group relative bg-white rounded-[2rem] p-8 shadow-[0_20px_50px_rgba(0,0,0,0.03)] border border-gray-50 hover:border-accent-2/20 hover:-translate-y-1 transition-all duration-500 overflow-hidden">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-accent-2/5 rounded-full blur-2xl group-hover:bg-accent-2/10 transition-colors"></div>
                <div class="relative z-10 flex flex-col gap-6">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-accent-1 to-accent-2 shadow-lg shadow-accent-2/30 flex items-center justify-center text-white transform group-hover:rotate-6 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-black text-gray-400 uppercase tracking-widest mb-1">المستخدمين</p>
                        <h3 class="text-3xl font-black text-gray-900 leading-none">1,250</h3>
                    </div>
                    <div class="flex items-center gap-2 px-3 py-1.5 bg-green-50 rounded-full w-fit">
                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                        <span class="text-xs font-black text-green-600">+3.2%</span>
                    </div>
                </div>
            </div>

            <div class="group relative bg-white rounded-[2rem] p-8 shadow-[0_20px_50px_rgba(0,0,0,0.03)] border border-gray-50 hover:border-red-200 hover:-translate-y-1 transition-all duration-500 overflow-hidden">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-red-500/5 rounded-full blur-2xl group-hover:bg-red-500/10 transition-colors"></div>
                <div class="relative z-10 flex flex-col gap-6">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-red-500 to-pink-600 shadow-lg shadow-red-500/30 flex items-center justify-center text-white transform group-hover:-rotate-6 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-black text-gray-400 uppercase tracking-widest mb-1">الطلبات الجديدة</p>
                        <h3 class="text-3xl font-black text-gray-900 leading-none">84</h3>
                    </div>
                    <div class="flex items-center gap-2 px-3 py-1.5 bg-red-50 rounded-full w-fit">
                        <svg class="w-4 h-4 text-red-500 transform rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                        <span class="text-xs font-black text-red-600">-1.5%</span>
                    </div>
                </div>
            </div>

            <div class="group relative bg-white rounded-[2rem] p-8 shadow-[0_20px_50px_rgba(0,0,0,0.03)] border border-gray-50 hover:border-green-200 hover:-translate-y-1 transition-all duration-500 overflow-hidden">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-green-500/5 rounded-full blur-2xl group-hover:bg-green-500/10 transition-colors"></div>
                <div class="relative z-10 flex flex-col gap-6">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-green-500 to-emerald-500 shadow-lg shadow-green-500/30 flex items-center justify-center text-white transform group-hover:rotate-6 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-black text-gray-400 uppercase tracking-widest mb-1">معدل التحويل</p>
                        <h3 class="text-3xl font-black text-gray-900 leading-none">4.6%</h3>
                    </div>
                    <div class="flex items-center gap-2 px-4 py-1.5 bg-gray-50 rounded-full w-fit">
                        <span class="text-xs font-black text-gray-500">ثابت المستوى</span>
                    </div>
                </div>
            </div>

        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2 bg-white rounded-[2.5rem] p-8 md:p-10 shadow-[0_20px_50px_rgba(0,0,0,0.02)] border border-gray-50 relative overflow-hidden">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-2xl font-black text-gray-900 flex items-center gap-3">
                        <div class="p-2 bg-primary/10 text-primary rounded-xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        </div>
                        أحدث العمليات
                    </h3>
                    <button class="text-primary font-black text-sm hover:underline flex items-center gap-1">
                        مشاهدة الكل
                        <svg class="w-4 h-4 transform rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                </div>

                <div class="space-y-4">
                    @for ($i = 0; $i < 4; $i++)
                        <div class="flex items-center justify-between p-5 rounded-2xl bg-gray-50 hover:bg-white hover:shadow-md transition-all border border-transparent hover:border-gray-100 group">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-white border border-gray-100 flex items-center justify-center font-black text-gray-400 group-hover:text-primary group-hover:bg-primary/5 transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                </div>
                                <div>
                                    <p class="font-black text-gray-900">طلب جديد رقم #54{{$i}}</p>
                                    <p class="text-xs text-gray-400 font-bold mt-1">منذ 10 دقائق</p>
                                </div>
                            </div>
                            <span class="px-5 py-2 bg-blue-50 text-primary text-xs font-black rounded-full">جاري المعالجة</span>
                        </div>
                    @endfor
                </div>
            </div>

            <div class="bg-gradient-to-br from-secondary to-black rounded-[2.5rem] p-10 shadow-2xl relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-64 h-64 bg-primary/20 rounded-full blur-[60px] group-hover:bg-primary/30 transition-colors duration-700"></div>
                <div class="absolute bottom-0 left-0 w-32 h-32 bg-accent-1/20 rounded-full blur-[40px]"></div>

                <div class="relative z-10 h-full flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-white/10 text-white flex items-center justify-center backdrop-blur-sm border border-white/10 mb-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <h3 class="text-3xl font-black text-white mb-2">هدف الشهر</h3>
                        <p class="text-gray-400 font-bold leading-relaxed">لقد حققت <span class="text-white font-black">75%</span> من هدفك المالي لهذا الشهر. استمر في العمل الرائع!</p>
                    </div>

                    <div class="py-8">
                        <div class="flex justify-between text-xs font-black text-white mb-3">
                            <span>المحقق: $15,000</span>
                            <span class="text-gray-400">الهدف: $20,000</span>
                        </div>
                        <div class="w-full h-3 bg-white/10 rounded-full overflow-hidden border border-white/5">
                            <div class="w-3/4 h-full bg-gradient-to-r from-primary to-accent-1 shadow-[0_0_15px_rgba(30,64,175,0.8)] relative">
                                <div class="absolute inset-0 bg-white/20 w-full h-full animate-[translateX_2s_infinite]"></div>
                            </div>
                        </div>
                    </div>

                    <button class="w-full py-4 bg-white text-secondary font-black rounded-2xl hover:scale-105 hover:shadow-[0_10px_20px_rgba(255,255,255,0.2)] transition-all duration-300">
                        تفاصيل الخطة
                    </button>
                </div>
            </div>

        </div>
    </div>
@endsection
