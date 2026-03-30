<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - لوحة التحكم</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @keyframes gradient-x {
            0%, 100% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
        }

        .animate-gradient-x {
            background-size: 200% 200%;
            animation: gradient-x 4s ease infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-12px);
            }
            100% {
                transform: translateY(0px);
            }
        }

        .animate-float {
            animation: float 4s ease-in-out infinite;
        }
    </style>
</head>
<body
    class="font-sans antialiased text-gray-800 bg-slate-50 min-h-screen flex selection:bg-primary selection:text-white overflow-x-hidden relative">

@include('admin.layouts.loader')

<div class="absolute inset-0 lg:hidden overflow-hidden pointer-events-none z-0">
    <div
        class="absolute -top-20 -right-20 w-72 h-72 bg-primary-light rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-float"></div>
    <div
        class="absolute -bottom-20 -left-20 w-72 h-72 bg-accent-1 opacity-20 rounded-full mix-blend-multiply filter blur-3xl animate-float"
        style="animation-delay: 2s;"></div>
</div>

<div class="w-full lg:w-1/2 flex items-center justify-center p-4 sm:p-8 lg:p-24 relative z-10 min-h-screen lg:min-h-0">

    <div class="w-full max-w-md relative z-10 transform transition-all duration-700 translate-y-0 opacity-100">

        <div class="mb-8 lg:mb-12 text-center lg:text-right">
            <div class="flex flex-col lg:flex-row items-center justify-center lg:justify-start gap-4 mb-4">
                <div
                    class="relative flex items-center justify-center w-14 h-14 rounded-2xl bg-primary-light text-primary shadow-[0_0_20px_rgba(30,64,175,0.15)] border border-primary-light animate-float hidden lg:flex">
                    <div class="absolute inset-0 rounded-2xl bg-primary opacity-20 animate-ping"
                         style="animation-duration: 2s;"></div>
                    <svg class="w-7 h-7 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                              d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl lg:text-4xl font-black text-transparent bg-clip-text bg-gradient-to-l from-primary via-accent-1 to-accent-2 animate-gradient-x tracking-tight pb-2">
                    مــرحبــاً بعـودتــك!
                </h1>
            </div>
            <p class="text-gray-500 text-base lg:text-lg font-semibold px-4 lg:px-0">أدخــل بيــانــات الاعتمــاد للـوصــول للــوحــة
                التحكم.</p>
        </div>

        @if ($errors->any())
            @if ($errors->has('throttle_seconds'))
                <div id="throttle-message"
                     class="bg-red-50 border-r-4 border-red-500 text-red-700 px-4 py-3 rounded-xl mb-6 shadow-md animate-pulse">
                    <p class="font-bold mb-1 text-sm">تـنبيـه الـأمــن!</p>
                    <p class="text-sm font-semibold">
                        لقـد تجــاوزت المحــاولات. يــرجــى الانتظــار <span id="countdown-timer"
                                                                  class="font-black text-lg tracking-widest">{{ $errors->first('throttle_seconds') }}</span>
                        ثــانيـة.
                    </p>
                </div>
            @else
                <div
                    class="bg-red-50 border-r-4 border-red-500 text-red-700 px-4 py-3 rounded-xl mb-6 shadow-md animate-bounce">
                    <p class="font-bold mb-1 text-sm">تـنبيـه!</p>
                    <p class="text-sm font-semibold">{{ $errors->first() }}</p>
                </div>
            @endif
        @endif

        <form method="POST" action="{{ route('admin.login') }}"
              class="space-y-5 lg:space-y-6 bg-white/90 backdrop-blur-xl lg:bg-white p-6 sm:p-8 rounded-3xl shadow-[0_10px_50px_rgba(0,0,0,0.08)] lg:shadow-[0_10px_50px_rgba(0,0,0,0.05)] border border-white/50 lg:border-gray-100 relative">
            @csrf

            <div class="relative group">
                <label for="email"
                       class="block text-sm font-bold text-gray-700 mb-1.5 lg:mb-2 group-focus-within:text-primary transition-colors">الـبريـد
                    الإلكــترونـي</label>
                <div class="relative">
                    <div
                        class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-primary transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                  d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                        </svg>
                    </div>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full pr-11 pl-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-4 focus:ring-primary/20 focus:border-primary transition-all duration-300 shadow-sm text-left text-sm lg:text-base"
                           dir="ltr" placeholder="admin@example.com">
                </div>
            </div>

            <div class="relative group">
                <div class="flex items-center justify-between mb-1.5 lg:mb-2">
                    <label for="password"
                           class="block text-sm font-bold text-gray-700 group-focus-within:text-primary transition-colors">كـلمـة
                        الـمـرور</label>
                </div>
                <div class="relative">
                    <div
                        class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-primary transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                  d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                        </svg>
                    </div>
                    <input type="password" id="password" name="password" required
                           class="w-full pr-11 pl-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:ring-4 focus:ring-primary/20 focus:border-primary transition-all duration-300 shadow-sm text-left tracking-widest text-sm lg:text-base"
                           dir="ltr" placeholder="••••••••">
                </div>
            </div>

            <div class="flex items-center pt-1 lg:pt-2">
                <input type="checkbox" id="remember" name="remember"
                       class="w-4 h-4 lg:w-5 lg:h-5 text-primary bg-gray-100 border-gray-300 rounded focus:ring-primary focus:ring-4 focus:ring-opacity-20 cursor-pointer transition-all">
                <label for="remember"
                       class="mr-3 text-xs lg:text-sm font-bold text-gray-600 cursor-pointer select-none">تــذكـر بيـانـات
                    الـدخـول</label>
            </div>

            <button type="submit" id="login-submit-btn"
                    class="cursor-pointer group w-full bg-gradient-to-r from-primary via-accent-1 to-accent-2 animate-gradient-x text-white font-bold py-3.5 lg:py-4 px-6 rounded-xl hover:shadow-[0_15px_30px_-10px_rgba(30,64,175,0.6)] hover:-translate-y-1 focus:outline-none focus:ring-4 focus:ring-primary-light transition-all duration-300 flex items-center justify-between overflow-hidden relative mt-2">

                <span id="btn-text" class="relative z-10 text-lg lg:text-xl tracking-wide">تسـجيـل الـدخـول</span>

                <div class="relative z-10 flex items-center justify-center p-1.5 lg:p-2 bg-white/20 rounded-lg transform transition-all duration-300">
                    <svg id="arrow-icon" class="w-5 h-5 lg:w-6 lg:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>

                    <svg id="loader-icon" class="hidden w-5 h-5 lg:w-6 lg:h-6 animate-spin text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
            </button>
        </form>
    </div>
</div>

<div class="hidden lg:flex lg:w-1/2 relative overflow-hidden bg-secondary items-center justify-center">
    <div class="absolute inset-0 bg-gradient-to-br from-primary/95 to-secondary/95 z-10"></div>

    <div
        class="absolute top-10 right-10 w-96 h-96 rounded-full bg-accent-1 opacity-30 blur-3xl mix-blend-screen animate-pulse"
        style="animation-duration: 4s;"></div>
    <div
        class="absolute bottom-10 left-10 w-96 h-96 rounded-full bg-accent-2 opacity-40 blur-3xl mix-blend-screen animate-float"
        style="animation-duration: 6s;"></div>

    <div class="relative z-20 text-center px-12 animate-float" style="animation-duration: 5s;">
        <div
            class="inline-block p-6 rounded-3xl bg-white/10 backdrop-blur-lg border border-white/30 shadow-[0_20px_50px_rgba(0,0,0,0.2)] mb-10 transform hover:scale-105 transition-transform duration-500 cursor-default">
            <svg class="w-20 h-20 text-white drop-shadow-md" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
            </svg>
        </div>
        <h2 class="text-5xl font-black text-white mb-6 leading-tight drop-shadow-lg">إدارة النظام<br>باحترافية وسهولة
        </h2>
        <p class="text-xl text-primary-light max-w-md mx-auto leading-relaxed font-semibold">
            منصة متكاملة تمنحك التحكم الكامل في كل أجزاء مشروعك مع أداء استثنائي وتجربة مستخدم لا مثيل لها.
        </p>
    </div>
</div>
<script>

    document.addEventListener('DOMContentLoaded', function () {
        const timerDisplay = document.getElementById('countdown-timer');
        const loginBtn = document.getElementById('login-submit-btn');
        const btnText = document.getElementById('btn-text');
        const throttleMessage = document.getElementById('throttle-message');

        let seconds = parseInt("{{ $errors->first('throttle_seconds') ?? 0 }}");

        if (seconds > 0) {

            loginBtn.disabled = true;
            loginBtn.style.pointerEvents = 'none';
            loginBtn.classList.add('opacity-60', 'grayscale');
            loginBtn.classList.remove('cursor-pointer', 'hover:-translate-y-1');

            if(btnText) btnText.innerText = "الدخول محظور مؤقتاً";

            const interval = setInterval(function () {
                seconds--;
                if(timerDisplay) timerDisplay.innerText = seconds;

                if (seconds <= 0) {
                    clearInterval(interval);
                    loginBtn.disabled = false;
                    loginBtn.style.pointerEvents = 'auto';
                    loginBtn.classList.remove('opacity-60', 'grayscale');
                    loginBtn.classList.add('cursor-pointer', 'hover:-translate-y-1');

                    if(btnText) btnText.innerText = "تسـجيـل الـدخـول";

                    if(throttleMessage) {
                        throttleMessage.style.transition = "opacity 0.5s";
                        throttleMessage.style.opacity = "0";
                        setTimeout(() => throttleMessage.remove(), 500);
                    }
                }
            }, 1000);
        }
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const loginForm = document.querySelector('form');
        const loginBtn = document.getElementById('login-submit-btn');
        const btnText = document.getElementById('btn-text');
        const arrowIcon = document.getElementById('arrow-icon');
        const loaderIcon = document.getElementById('loader-icon');
        const timerDisplay = document.getElementById('countdown-timer');
        const throttleMessage = document.getElementById('throttle-message');

        loginForm.addEventListener('submit', function() {
            loginBtn.disabled = true;
            loginBtn.classList.add('opacity-80', 'cursor-not-allowed');
            loginBtn.style.pointerEvents = 'none';

            arrowIcon.classList.add('hidden');
            loaderIcon.classList.remove('hidden');

            btnText.innerText = "جاري التحقق...";
        });

        let seconds = parseInt("{{ $errors->first('throttle_seconds') ?? 0 }}");

        if (seconds > 0) {
            loginBtn.disabled = true;
            loginBtn.style.pointerEvents = 'none';
            loginBtn.classList.add('opacity-60', 'grayscale');
            if(btnText) btnText.innerText = "الدخول محظور مؤقتاً";
            arrowIcon.classList.add('hidden');

            const interval = setInterval(function () {
                seconds--;
                if(timerDisplay) timerDisplay.innerText = seconds;

                if (seconds <= 0) {
                    clearInterval(interval);
                    loginBtn.disabled = false;
                    loginBtn.style.pointerEvents = 'auto';
                    loginBtn.classList.remove('opacity-60', 'grayscale');
                    if(btnText) btnText.innerText = "تسجيل الدخول";
                    arrowIcon.classList.remove('hidden');

                    if(throttleMessage) {
                        throttleMessage.style.transition = "opacity 0.5s";
                        throttleMessage.style.opacity = "0";
                        setTimeout(() => throttleMessage.remove(), 500);
                    }
                }
            }, 1000);
        }
    });
</script>
</body>
</html>
