<header class="h-24 px-10 flex items-center justify-between relative z-20">
    <div class="flex items-center gap-6 mr-auto">
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button title="تسـجيـل الخــروج" type="submit" class="cursor-pointer w-12 h-12 flex items-center justify-center rounded-2xl bg-red-50 text-red-500 hover:bg-red-500 hover:text-white hover:shadow-[0_10px_20px_rgba(239,68,68,0.3)] transition-all duration-300">
                <svg class="w-6 h-6 transform rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
            </button>
        </form>
    </div>
</header>
