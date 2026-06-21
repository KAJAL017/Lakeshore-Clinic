<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta-description', 'Lakeshore Clinic - Premium Healthcare & Medical Center')">
    <title>@yield('title', config('app.name', 'Lakeshore Clinic'))</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet">
    <link href="https://fonts.bunny.net/css?family=playfair+display:400,500,600,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('website/css/app.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="h-full font-sans bg-white text-slate-800 antialiased">
    <div id="public-toast-container" class="fixed top-24 right-4 z-[100] flex flex-col gap-2"></div>

    @include('website.partials.header')

    <main>
        @yield('content')
    </main>

    @include('website.partials.footer')

    <script src="{{ asset('website/js/app.js') }}"></script>
    <script src="{{ asset('website/js/navigation.js') }}"></script>
    <script src="{{ asset('website/js/hero.js') }}"></script>
    <script src="{{ asset('website/js/animations.js') }}"></script>
    <script src="{{ asset('website/js/forms.js') }}"></script>
    @stack('scripts')
</body>
</html>
