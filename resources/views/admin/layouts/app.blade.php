<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'الرئيسية') | لوحة تحكم د. محمد طلعت</title>

    <meta name="description" content="@yield('meta_description', 'لوحة التحكم الخاصة بإدارة محتوى ومقالات الدكتور محمد طلعت.')">
    <meta name="keywords" content="د. محمد طلعت, لوحة تحكم, إدارة الموقع, إعلامي, مقالات">
    <meta name="author" content="د. محمد طلعت">

    <meta name="robots" content="noindex, nofollow">

    <meta name="theme-color" content="#000000">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'الرئيسية') | لوحة تحكم د. محمد طلعت">
    <meta property="og:description" content="@yield('meta_description', 'لوحة التحكم الخاصة بإدارة محتوى ومقالات الدكتور محمد طلعت.')">
    <meta property="og:image" content="{{ asset(get_setting('logo') ?? 'login-bg.png') }}">
    <meta property="og:site_name" content="موقع د. محمد طلعت">
    <meta property="og:locale" content="ar_AR">

    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="@yield('title', 'الرئيسية') | لوحة تحكم د. محمد طلعت">
    <meta name="twitter:description" content="@yield('meta_description', 'لوحة التحكم الخاصة بإدارة محتوى ومقالات الدكتور محمد طلعت.')">
    <meta name="twitter:image" content="{{ asset(get_setting('logo') ?? 'login-bg.png') }}">

    @if(get_setting('favicon'))
        <link rel="icon" href="{{ asset(get_setting('favicon')) }}" type="image/x-icon"/>
        <link rel="apple-touch-icon" href="{{ asset(get_setting('favicon')) }}">
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        body.loading {
            overflow: hidden !important;
        }
    </style>

    @include('admin.layouts.style')

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="loading font-sans antialiased text-gray-800 bg-[#fbfcfd] selection:bg-primary selection:text-white overflow-hidden">

<div class="flex h-screen w-full relative z-0">

    @include('admin.layouts.loader')

    @include('admin.layouts.sidebar')

    <div class="flex-1 flex flex-col relative overflow-hidden bg-gradient-to-br from-[#fbfcfd] to-[#f4f7fe]">

        @include('admin.layouts.header')

        <main class="flex-1 overflow-x-hidden overflow-y-auto px-10 pb-10 custom-scrollbar">
            @yield('content')
        </main>

    </div>

</div>

@include('admin.layouts.alerts')

@include('admin.layouts.scripts')

</body>
</html>
</html>
