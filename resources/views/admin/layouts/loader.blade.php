<div id="global-loader" class="fixed inset-0 z-[10000] flex items-center justify-center bg-[#0B1120] transition-opacity duration-700">
    <div class="relative flex flex-col items-center">
        <div class="relative w-20 h-20 mb-6">
            <div class="absolute inset-0 border-4 border-white/5 rounded-full"></div>
            <div class="absolute inset-0 border-4 border-t-primary rounded-full animate-spin"></div>
            <div class="absolute inset-4 bg-primary/10 backdrop-blur-md rounded-xl flex items-center justify-center border border-white/10">
                <svg class="w-8 h-8 text-primary animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
            </div>
        </div>

        <div class="text-center">
            <span class="text-white text-sm font-black uppercase tracking-[0.3em] ml-[0.3em] block mb-3">جــاري التحميــل</span>
            <div class="w-32 h-1 bg-white/5 rounded-full overflow-hidden relative">
                <div class="absolute inset-0 bg-primary animate-loader-progress"></div>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes loader-progress {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }
    .animate-loader-progress {
        animation: loader-progress 1.5s infinite ease-in-out;
    }
</style>
<script>
    window.addEventListener('load', function() {
        const loader = document.getElementById('global-loader');
        if (loader) {
            loader.style.opacity = '0';
            setTimeout(() => {
                loader.style.display = 'none';
                document.body.classList.remove('loading');
            }, 1000);
        }
    });
</script>
