<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | لوحة التحكم</title>

    <style>body.loading { overflow: hidden !important; }</style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="loading font-sans antialiased text-gray-800 bg-[#fbfcfd] flex h-screen selection:bg-primary selection:text-white">

@include('admin.layouts.loader')

@include('admin.layouts.sidebar')

<div class="flex-1 flex flex-col relative overflow-hidden bg-gradient-to-br from-[#fbfcfd] to-[#f4f7fe]">
    @include('admin.layouts.header')

    <main class="flex-1 overflow-x-hidden overflow-y-auto px-10 pb-10 custom-scrollbar">
        @yield('content')
    </main>
</div>

</body>
</html>
