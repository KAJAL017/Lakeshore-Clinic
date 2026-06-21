<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <title>@yield('title', 'Doctor Panel - Lakeshore Clinic')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { -webkit-tap-highlight-color: transparent; }
        .mobile-bottom-nav {
            position: fixed; bottom: 0; left: 0; right: 0; z-index: 50;
            background: rgba(255,255,255,0.95); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
            border-top: 1px solid #e2e8f0;
            padding-bottom: env(safe-area-inset-bottom);
        }
        .mobile-page { animation: slideIn 0.25s ease-out; }
        @keyframes slideIn { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }
        .mobile-card { transition: transform 0.15s ease, box-shadow 0.15s ease; }
        .mobile-card:active { transform: scale(0.97); }
        .nav-item { transition: color 0.15s ease, transform 0.1s ease; }
        .nav-item:active { transform: scale(0.9); }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }

        /* Mobile Drawer */
        .drawer-overlay {
            position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 100;
            opacity: 0; visibility: hidden; transition: opacity 0.3s ease, visibility 0.3s ease;
        }
        .drawer-overlay.active { opacity: 1; visibility: visible; }
        .drawer-panel {
            position: fixed; top: 0; left: 0; bottom: 0; width: 280px; z-index: 101;
            background: #1e3a5f; transform: translateX(-100%); transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex; flex-direction: column; overflow-y: auto;
            padding-top: env(safe-area-inset-top);
        }
        .drawer-panel.active { transform: translateX(0); }
        .drawer-item { transition: background 0.15s ease, transform 0.1s ease; }
        .drawer-item:active { transform: scale(0.97); background: rgba(255,255,255,0.1); }
        .drawer-item.active { background: rgba(255,255,255,0.12); }
    </style>
    @stack('styles')
</head>
<body class="h-full bg-[#f8f9fb]">
    <div id="toast-container" class="fixed top-4 right-4 left-4 z-[110] flex flex-col gap-2"></div>

    {{-- Drawer Overlay --}}
    <div id="drawer-overlay" class="drawer-overlay" onclick="closeDrawer()"></div>

    {{-- Drawer Panel --}}
    <div id="drawer-panel" class="drawer-panel">
        <div class="p-5" style="border-bottom: 1px solid rgba(255,255,255,0.1);">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-full flex items-center justify-center flex-shrink-0" style="background: rgba(255,255,255,0.15);">
                    @php $photo = auth()->user()->doctor?->photo ?? null; @endphp
                    @if($photo)
                        <img src="{{ asset('uploads/doctors/' . $photo) }}" alt="" class="w-full h-full rounded-full object-cover">
                    @else
                        <span class="text-sm font-bold" style="color: #fff;">{{ strtoupper(substr(auth()->user()->name ?? 'D', 0, 2)) }}</span>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold truncate" style="color: #fff;">{{ auth()->user()->name ?? 'Doctor' }}</p>
                    <p class="text-xs truncate" style="color: rgba(255,255,255,0.5);">Doctor</p>
                </div>
            </div>
        </div>

        <nav class="flex-1 py-3 px-3">
            @php
                $drawerLinks = [
                    ['route' => 'doctor.dashboard', 'param' => 'doctor.dashboard', 'label' => 'Dashboard', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>'],
                    ['route' => 'doctor.appointments', 'param' => 'doctor.appointments*', 'label' => 'My Appointments', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>'],
                    ['route' => 'doctor.availability', 'param' => 'doctor.availability*', 'label' => 'My Availability', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>'],
                    ['route' => 'doctor.time-slots', 'param' => 'doctor.time-slots*', 'label' => 'Time Slots', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0zM8 14v.01M12 14v.01M16 14v.01M8 18v.01M12 18v.01M16 18v.01"/>'],
                    ['route' => 'doctor.meetings', 'param' => 'doctor.meetings*', 'label' => 'Telemedicine Sessions', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>'],
                    ['route' => 'doctor.consultations', 'param' => 'doctor.consultations*', 'label' => 'Consultations', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>'],
                    ['route' => 'doctor.prescriptions', 'param' => 'doctor.prescriptions*', 'label' => 'Prescriptions', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>'],
                    ['route' => 'doctor.records', 'param' => 'doctor.records*', 'label' => 'Patient Records', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>'],
                    ['route' => 'doctor.notifications', 'param' => 'doctor.notifications*', 'label' => 'Notifications', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>'],
                    ['route' => 'doctor.profile', 'param' => 'doctor.profile*', 'label' => 'My Profile', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>'],
                ];
            @endphp
            @foreach($drawerLinks as $link)
                @php $active = request()->routeIs($link['param']); @endphp
                <a href="{{ route($link['route']) }}" class="drawer-item flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium" style="color: {{ $active ? '#fff' : 'rgba(255,255,255,0.7)' }};{{ $active ? ' background: rgba(255,255,255,0.12);' : '' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">{!! $link['icon'] !!}</svg>
                    <span>{{ $link['label'] }}</span>
                </a>
            @endforeach
        </nav>

        <div class="p-4" style="border-top: 1px solid rgba(255,255,255,0.1);">
            <button id="drawer-logout-btn" class="drawer-item flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium w-full" style="color: #fca5a5;">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                <span>Logout</span>
            </button>
        </div>
    </div>

    <div class="min-h-full pb-20">
        <header class="sticky top-0 z-40 shadow-lg" style="background: #1e3a5f; box-shadow: 0 4px 12px rgba(30,58,95,0.1);">
            <div class="flex items-center justify-between h-14 px-4" style="padding-top: env(safe-area-inset-top);">
                <button id="menu-btn" class="w-9 h-9 rounded-lg flex items-center justify-center transition-colors" style="color: #fff;">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <h1 class="text-base font-semibold flex-1 text-center" style="color: #fff;">@yield('page-title', 'Doctor Panel')</h1>
                <a href="{{ route('doctor.profile') }}" class="w-8 h-8 rounded-full flex items-center justify-center transition-colors" style="background: rgba(255,255,255,0.15); color: #fff;">
                    <span class="text-xs font-semibold">{{ strtoupper(substr(auth()->user()->name ?? 'D', 0, 2)) }}</span>
                </a>
            </div>
        </header>

        <main class="mobile-page px-4 pt-4 pb-4">
            @yield('content')
        </main>
    </div>

    <nav class="mobile-bottom-nav">
        <div class="flex items-center justify-around h-16 max-w-lg mx-auto">
            @php
                $bottomLinks = [
                    ['route' => 'doctor.dashboard', 'param' => 'doctor.dashboard', 'label' => 'Home', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>'],
                    ['route' => 'doctor.appointments', 'param' => 'doctor.appointments*', 'label' => 'Appts', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>'],
                    ['route' => 'doctor.consultations', 'param' => 'doctor.consultations*', 'label' => 'Notes', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>'],
                    ['route' => 'doctor.notifications', 'param' => 'doctor.notifications*', 'label' => 'Alerts', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>'],
                    ['route' => 'doctor.profile', 'param' => 'doctor.profile*', 'label' => 'Profile', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>'],
                ];
            @endphp
            @foreach($bottomLinks as $link)
                @php $active = request()->routeIs($link['param']); @endphp
                <a href="{{ route($link['route']) }}" class="nav-item flex flex-col items-center gap-0.5 py-2 px-3" style="color: {{ $active ? '#1e3a5f' : '#9ca3af' }};">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">{!! $link['icon'] !!}</svg>
                    <span class="text-[10px] font-semibold">{{ $link['label'] }}</span>
                </a>
            @endforeach
        </div>
    </nav>

    <script>
    function openDrawer() {
        document.getElementById('drawer-overlay').classList.add('active');
        document.getElementById('drawer-panel').classList.add('active');
        document.body.style.overflow = 'hidden';
    }
    function closeDrawer() {
        document.getElementById('drawer-overlay').classList.remove('active');
        document.getElementById('drawer-panel').classList.remove('active');
        document.body.style.overflow = '';
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('menu-btn').addEventListener('click', openDrawer);

        document.getElementById('drawer-panel').addEventListener('click', function(e) {
            e.stopPropagation();
        });

        document.getElementById('drawer-logout-btn').addEventListener('click', async function() {
            closeDrawer();
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

        document.querySelectorAll('.nav-item').forEach(function(item) {
            item.addEventListener('touchstart', function() {}, { passive: true });
        });
    });
    </script>
    @stack('scripts')
</body>
</html>
