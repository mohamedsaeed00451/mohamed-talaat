<div id="global-loader" class="fixed inset-0 z-[10000] flex items-center justify-center bg-[#0B1120] transition-opacity duration-700">
    <div class="relative flex flex-col items-center">
        <div class="relative w-40 h-40 mb-6">
            <div class="absolute inset-0 border-4 border-white/5 rounded-full"></div>
            <div class="absolute inset-0 border-4 border-t-primary rounded-full animate-spin"></div>
            <div class="absolute inset-4 flex items-center justify-center">
                <img src="{{ asset(get_setting('favicon')) }}"
                     alt="Favicon"
                     class="w-32 h-32 object-contain animate-float relative z-10">
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
