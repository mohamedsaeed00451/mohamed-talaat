<header class="h-24 px-10 flex items-center justify-between relative z-20">
    <div class="relative group hidden lg:block">
        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-primary transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>
        <input type="text" placeholder="ابحث عن أي شيء..."
               class="w-96 pr-12 pl-6 py-3 bg-white border-none rounded-2xl shadow-[0_10px_30px_rgba(0,0,0,0.02)] focus:ring-4 focus:ring-primary/10 transition-all font-semibold text-sm">
    </div>

    <div class="flex items-center gap-6 mr-auto">

        <div class="flex items-center gap-4 bg-white p-2 pr-6 rounded-2xl shadow-sm border border-gray-50 hover:shadow-md transition-all cursor-pointer group">
            <div class="text-left hidden sm:block">
                <p class="text-sm font-black text-gray-800 leading-none mb-1 group-hover:text-primary transition-colors">{{ Auth::user()->name }}</p>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">مـديـر النـظـام</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-primary-light to-blue-100 flex items-center justify-center text-primary font-black text-xl shadow-inner border border-white">
                {{ mb_substr(Auth::user()->name, 0, 1) }}
            </div>
        </div>

        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="cursor-pointer w-12 h-12 flex items-center justify-center rounded-2xl bg-red-50 text-red-500 hover:bg-red-500 hover:text-white hover:shadow-[0_10px_20px_rgba(239,68,68,0.3)] transition-all duration-300">
                <svg class="w-6 h-6 transform rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
            </button>
        </form>
    </div>
</header>
