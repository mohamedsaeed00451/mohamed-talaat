<aside
    class="w-72 bg-secondary text-white flex flex-col transition-all duration-500 relative z-30 shadow-[-10px_0_60px_rgba(0,0,0,0.4)] border-l border-white/[0.05] overflow-hidden">

    <div class="h-28 flex items-center px-8 relative overflow-hidden border-b border-white/[0.02]">
        <div class="absolute -top-10 -right-10 w-32 h-32 bg-accent-1/20 rounded-full blur-[40px] animate-pulse"></div>
        <div class="absolute bottom-0 -left-10 w-24 h-24 bg-primary/20 rounded-full blur-[30px]"></div>

        <div class="flex items-center gap-4 group cursor-pointer relative z-10 w-full">
            <div
                class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-primary via-accent-1 to-accent-2 flex items-center justify-center shadow-[0_10px_30px_rgba(30,64,175,0.4)] group-hover:scale-105 group-hover:rotate-3 transition-all duration-500 relative overflow-hidden border border-white/10">
                <div class="absolute inset-0 bg-white/20 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                <svg class="w-8 h-8 text-white drop-shadow-[0_0_10px_rgba(255,255,255,0.6)] animate-float relative z-10" fill="none"
                     stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                          d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
            </div>
            <div class="flex flex-col w-44">
                <h2 class="text-xl font-black tracking-tight uppercase leading-none truncate text-transparent bg-clip-text bg-gradient-to-l from-white to-gray-300">
                    {{ Auth::user()->name ?? 'Admin' }}
                </h2>
                <div class="flex items-center gap-2 mt-1.5">
                    <span class="relative flex h-2 w-2">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500 shadow-[0_0_5px_#22c55e]"></span>
                    </span>
                    <span class="text-[9px] text-gray-400 font-bold uppercase tracking-widest">متصــل الـآن</span>
                </div>
            </div>
        </div>
    </div>

    <nav class="flex-1 overflow-y-auto py-8 px-5 space-y-2 custom-scrollbar relative z-10">
        <p class="text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] px-3 mb-6 opacity-70">القــائــمة الـرئيســية</p>

        @php $isActive = request()->routeIs('admin.dashboard'); @endphp
        <div class="relative group">
            <div
                class="absolute right-[-20px] top-1/2 -translate-y-1/2 w-1.5 h-8 bg-primary shadow-[0_0_15px_var(--color-primary)] rounded-l-full transition-all duration-500 {{ $isActive ? 'opacity-100 scale-100' : 'opacity-0 scale-y-0' }}"></div>

            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all duration-300 relative overflow-hidden {{ $isActive ? 'bg-white/10 border border-white/10 shadow-[0_8px_30px_rgba(0,0,0,0.12)]' : 'hover:bg-white/[0.03] border border-transparent hover:border-white/5 hover:-translate-x-1' }}">
                <div class="relative">
                    <div
                        class="absolute inset-0 bg-primary blur-xl transition-opacity duration-500 {{ $isActive ? 'opacity-50' : 'opacity-0 group-hover:opacity-30' }}"></div>
                    <div
                        class="w-10 h-10 rounded-xl flex items-center justify-center relative z-10 transition-all duration-500 {{ $isActive ? 'bg-primary shadow-[0_0_20px_rgba(30,64,175,0.4)]' : 'bg-white/5 group-hover:bg-white/10' }}">
                        <svg
                            class="w-5 h-5 {{ $isActive ? 'text-white drop-shadow-md' : 'text-gray-400 group-hover:text-white' }} transition-colors duration-300"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                    </div>
                </div>
                <span
                    class="{{ $isActive ? 'font-black text-white' : 'font-bold text-gray-400 group-hover:text-white' }} text-sm tracking-wide transition-colors">نظــرة عــامـة</span>
            </a>
        </div>

        <div class="h-px w-full bg-gradient-to-r from-transparent via-white/10 to-transparent my-6"></div>
        <p class="text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] px-3 mb-6 opacity-70">إدارة المحتوى</p>

        @php $isActive = request()->routeIs('products.*'); @endphp
        <div class="relative group">
            <div
                class="absolute right-[-20px] top-1/2 -translate-y-1/2 w-1.5 h-8 bg-accent-1 shadow-[0_0_15px_var(--color-accent-1)] rounded-l-full transition-all duration-500 {{ $isActive ? 'opacity-100 scale-100' : 'opacity-0 scale-y-0' }}"></div>

            <a href="#"
               class="flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all duration-300 relative overflow-hidden {{ $isActive ? 'bg-white/10 border border-white/10 shadow-[0_8px_30px_rgba(0,0,0,0.12)]' : 'hover:bg-white/[0.03] border border-transparent hover:border-white/5 hover:-translate-x-1' }}">
                <div class="relative">
                    <div
                        class="absolute inset-0 bg-accent-1 blur-xl transition-opacity duration-500 {{ $isActive ? 'opacity-50' : 'opacity-0 group-hover:opacity-30' }}"></div>
                    <div
                        class="w-10 h-10 rounded-xl flex items-center justify-center relative z-10 transition-all duration-500 {{ $isActive ? 'bg-accent-1 shadow-[0_0_20px_rgba(30,64,175,0.4)]' : 'bg-white/5 group-hover:bg-white/10' }}">
                        <svg
                            class="w-5 h-5 {{ $isActive ? 'text-white drop-shadow-md' : 'text-gray-400 group-hover:text-white' }} transition-colors duration-300"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                </div>
                <span
                    class="{{ $isActive ? 'font-black text-white' : 'font-bold text-gray-400 group-hover:text-white' }} text-sm tracking-wide transition-colors">المنتجات</span>
            </a>
        </div>

        @php $isActive = request()->routeIs('users.*'); @endphp
        <div class="relative group mt-1">
            <div
                class="absolute right-[-20px] top-1/2 -translate-y-1/2 w-1.5 h-8 bg-accent-2 shadow-[0_0_15px_var(--color-accent-2)] rounded-l-full transition-all duration-500 {{ $isActive ? 'opacity-100 scale-100' : 'opacity-0 scale-y-0' }}"></div>

            <a href="#"
               class="flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all duration-300 relative overflow-hidden {{ $isActive ? 'bg-white/10 border border-white/10 shadow-[0_8px_30px_rgba(0,0,0,0.12)]' : 'hover:bg-white/[0.03] border border-transparent hover:border-white/5 hover:-translate-x-1' }}">
                <div class="relative">
                    <div
                        class="absolute inset-0 bg-accent-2 blur-xl transition-opacity duration-500 {{ $isActive ? 'opacity-50' : 'opacity-0 group-hover:opacity-30' }}"></div>
                    <div
                        class="w-10 h-10 rounded-xl flex items-center justify-center relative z-10 transition-all duration-500 {{ $isActive ? 'bg-accent-2 shadow-[0_0_20px_rgba(30,64,175,0.4)]' : 'bg-white/5 group-hover:bg-white/10' }}">
                        <svg
                            class="w-5 h-5 {{ $isActive ? 'text-white drop-shadow-md' : 'text-gray-400 group-hover:text-white' }} transition-colors duration-300"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                </div>
                <span
                    class="{{ $isActive ? 'font-black text-white' : 'font-bold text-gray-400 group-hover:text-white' }} text-sm tracking-wide transition-colors">العملاء</span>
            </a>
        </div>

        <div class="h-px w-full bg-gradient-to-r from-transparent via-white/10 to-transparent my-6"></div>

        @php $isActive = request()->routeIs('admin.settings.*'); @endphp
        <div class="relative group">
            <div
                class="absolute right-[-20px] top-1/2 -translate-y-1/2 w-1.5 h-8 bg-primary shadow-[0_0_15px_var(--color-primary)] rounded-l-full transition-all duration-500 {{ $isActive ? 'opacity-100 scale-100' : 'opacity-0 scale-y-0' }}"></div>

            <a href="{{ route('admin.settings.index') }}"
               class="flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all duration-300 relative overflow-hidden {{ $isActive ? 'bg-white/10 border border-white/10 shadow-[0_8px_30px_rgba(0,0,0,0.12)]' : 'hover:bg-white/[0.03] border border-transparent hover:border-white/5 hover:-translate-x-1' }}">
                <div class="relative">
                    <div
                        class="absolute inset-0 bg-primary blur-xl transition-opacity duration-500 {{ $isActive ? 'opacity-50' : 'opacity-0 group-hover:opacity-30' }}"></div>
                    <div
                        class="w-10 h-10 rounded-xl flex items-center justify-center relative z-10 transition-all duration-500 {{ $isActive ? 'bg-primary shadow-[0_0_20px_rgba(30,64,175,0.4)]' : 'bg-white/5 group-hover:bg-white/10' }}">
                        <svg
                            class="w-5 h-5 {{ $isActive ? 'text-white drop-shadow-md' : 'text-gray-400 group-hover:text-white group-hover:rotate-90' }} transition-all duration-500"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        </svg>
                    </div>
                </div>
                <span
                    class="{{ $isActive ? 'font-black text-white' : 'font-bold text-gray-400 group-hover:text-white' }} text-sm tracking-wide transition-colors">إعــدادات النظــام</span>
            </a>
        </div>
    </nav>

    <div class="p-5 relative z-10">
        <div
            class="bg-white/5 rounded-3xl p-4 border border-white/10 backdrop-blur-2xl relative overflow-hidden group shadow-xl hover:shadow-[0_10px_40px_rgba(0,0,0,0.5)] hover:bg-white/10 transition-all duration-500 cursor-pointer">
            <div
                class="absolute -bottom-10 -left-10 w-32 h-32 bg-primary opacity-20 blur-3xl group-hover:opacity-40 group-hover:scale-125 transition-all duration-700"></div>

            <div class="flex items-center gap-3 relative z-10">
                <div class="relative flex-shrink-0">
                    <div
                        class="absolute inset-0 bg-primary blur-md opacity-40 rounded-full group-hover:scale-110 transition-transform duration-500"></div>
                    <div class="w-12 h-12 rounded-full bg-gradient-to-tr from-white to-gray-300 p-[2px] relative z-10">
                        <div
                            class="w-full h-full rounded-full bg-secondary flex items-center justify-center text-white font-black text-xl shadow-inner">
                            {{ mb_substr(Auth::user()->name ?? 'A', 0, 1) }}
                        </div>
                    </div>
                </div>
                <div class="flex flex-col flex-1 min-w-0">
                    <h4 class="text-sm font-black text-white leading-tight mb-0.5 truncate">{{ Auth::user()->name ?? 'المدير العام' }}</h4>
                    <span
                        class="text-[10px] text-gray-400 font-bold uppercase tracking-wider group-hover:text-primary-light transition-colors">مـديـر الـنظام</span>
                </div>
                <div class="w-8 h-8 rounded-full flex items-center justify-center bg-white/5 text-gray-400 group-hover:bg-primary group-hover:text-white transition-all duration-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </div>
            </div>
        </div>
    </div>
</aside>
