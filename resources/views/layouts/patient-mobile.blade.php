<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <title>@yield('title', 'Lakeshore Clinic')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .mobile-bottom-nav { position: fixed; bottom: 0; left: 0; right: 0; z-index: 50; background: white; border-top: 1px solid #e2e8f0; padding-bottom: env(safe-area-inset-bottom); }
        .mobile-page { animation: slideIn 0.3s ease; }
        @keyframes slideIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .mobile-card { transition: transform 0.2s ease, box-shadow 0.2s ease; }
        .mobile-card:active { transform: scale(0.98); }
    </style>
    @stack('styles')
</head>
<body class="h-full bg-surface">
    <div id="toast-container" class="fixed top-4 right-4 left-4 z-50 flex flex-col gap-2"></div>

    <div class="min-h-full pb-20">
        <header class="sticky top-0 z-40" style="background: #0d9488;">
            <div class="flex items-center justify-between h-14 px-4">
                <div class="flex items-center gap-3">
                    <a href="{{ route('patient.dashboard') }}">
                        @php $logo = \App\Models\Setting::getValue('clinic_logo'); @endphp
                        @if($logo)
                            <img src="{{ asset('uploads/branding/' . $logo) }}" alt="Logo" class="h-8 w-auto object-contain">
                        @else
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(255,255,255,0.2);">
                                <svg class="w-5 h-5" style="color: #fff;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                            </div>
                        @endif
                    </a>
                </div>
                <h1 class="text-lg font-semibold" style="color: #fff;">@yield('page-title', 'Lakeshore Clinic')</h1>
                <a href="{{ route('patient.profile') }}" class="w-8 h-8 rounded-full flex items-center justify-center" style="background: rgba(255,255,255,0.2); color: #fff;">
                    <span class="text-sm font-medium">{{ strtoupper(substr(auth()->user()->name ?? 'P', 0, 2)) }}</span>
                </a>
            </div>
        </header>

        <main class="mobile-page p-4">
            @yield('content')
        </main>
    </div>

    <nav class="mobile-bottom-nav">
        <div class="flex items-center justify-around h-16">
            @php
                $patientLinks = [
                    ['route' => 'patient.dashboard', 'param' => 'patient.dashboard', 'label' => 'Home', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>'],
                    ['route' => 'patient.book-appointment', 'param' => 'patient.book-appointment*', 'label' => 'Book', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>'],
                    ['route' => 'patient.my-appointments', 'param' => 'patient.my-appointments', 'label' => 'Appointments', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>'],
                    ['route' => 'patient.notifications', 'param' => 'patient.notifications*', 'label' => 'Alerts', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>'],
                    ['route' => 'patient.profile', 'param' => 'patient.profile*', 'label' => 'Profile', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>'],
                ];
            @endphp
            @foreach($patientLinks as $link)
                @php $active = request()->routeIs($link['param']); @endphp
                <a href="{{ route($link['route']) }}" class="flex flex-col items-center gap-1 py-2 px-3" style="color: {{ $active ? '#0d9488' : '#9ca3af' }};">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">{!! $link['icon'] !!}</svg>
                    <span class="text-xs">{{ $link['label'] }}</span>
                </a>
            @endforeach
        </div>
    </nav>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const logoutBtn = document.getElementById('logout-btn');
        if (logoutBtn) {
            logoutBtn.addEventListener('click', async function() {
                try {
                    const response = await fetch('{{ route("logout") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        },
                    });
                    const data = await response.json();
                    if (data.success) { window.location.href = data.redirect; }
                } catch (error) { showToast('An error occurred.', 'error'); }
            });
        }
    });
    </script>
    @stack('scripts')
</body>
</html>
