<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Doctor Panel - Lakeshore Clinic')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .sidebar { background-color: #1e293b; }
        .sidebar-link { transition: all 0.2s ease; color: #94a3b8; }
        .sidebar-link:hover { background: rgba(255,255,255,0.08); color: #fff; }
        .sidebar-link.active { background: rgba(255,255,255,0.12); color: #fff; box-shadow: inset 3px 0 0 0 #60a5fa; }
        .sidebar-link svg { color: inherit; }
        .header-glass { backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); }
        .page-enter { animation: pageEnter 0.3s ease-out; }
        @keyframes pageEnter { from { opacity: 0; transform: translateY(6px); } to { opacity: 1; transform: translateY(0); } }
        .sidebar-section-label { font-size: 0.65rem; font-weight: 600; letter-spacing: 0.08em; text-transform: uppercase; color: rgba(255,255,255,0.3); padding: 0 12px; margin-top: 20px; margin-bottom: 6px; }
        .sidebar-section-label:first-child { margin-top: 0; }
        .sidebar-border { border-color: rgba(255,255,255,0.05); }
        .sidebar-user-bg { background: rgba(255,255,255,0.05); }
        .sidebar-user-sub { color: #94a3b8; }
        .bg-page { background-color: #f0f2f5; }
    </style>
    @stack('styles')
</head>
<body class="h-full bg-page">
    <div id="toast-container" class="fixed top-4 right-4 z-50 flex flex-col gap-2"></div>

    <div id="confirmation-dialog" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40" style="backdrop-filter: blur(4px);">
        <div class="bg-white rounded-2xl shadow-2xl p-6 max-w-sm w-full mx-4 transform transition-all">
            <div class="flex items-center gap-3 mb-4">
                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-amber-50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Confirm Action</h3>
                </div>
            </div>
            <p class="confirm-message text-gray-500 text-sm mb-6"></p>
            <div class="flex justify-end gap-3">
                <button class="cancel-btn px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 transition-colors">
                    Cancel
                </button>
                <button class="confirm-btn px-4 py-2 text-sm font-medium text-white bg-red-500 rounded-xl hover:bg-red-600 transition-colors">
                    Confirm
                </button>
            </div>
        </div>
    </div>

    <div class="flex h-full">
        <aside id="sidebar" class="sidebar fixed top-0 left-0 z-40 h-full w-[260px] text-white -translate-x-full lg:translate-x-0 transition-transform duration-300" style="transition-property: transform;">
            <div class="flex items-center gap-3 h-16 px-5" style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                @php $logo = \App\Models\Setting::getValue('clinic_logo'); @endphp
                <a href="{{ route('doctor.dashboard') }}" class="flex items-center gap-3">                    @if($logo)
                        <img src="{{ asset('uploads/branding/' . $logo) }}" alt="Logo" class="h-9 w-auto object-contain">
                    @else
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #3b82f6, #1d4ed8);">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        </div>
                    @endif
                    <span class="text-sm font-bold tracking-tight hidden xl:block">Lakeshore Clinic</span>
                </a>
            </div>

            <nav class="flex-1 overflow-y-auto py-4 px-3 scrollbar-hide">
                <p class="sidebar-section-label">Main</p>
                <ul class="space-y-0.5">
                    <li>
                        <a href="{{ route('doctor.dashboard') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('doctor.dashboard') ? 'active' : '' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('doctor.appointments') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('doctor.appointments*') ? 'active' : '' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span>Appointments</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('doctor.consultations') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('doctor.consultations*') ? 'active' : '' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <span>Consultations</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('doctor.prescriptions') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('doctor.prescriptions*') ? 'active' : '' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                            <span>Prescriptions</span>
                        </a>
                    </li>
                </ul>

                <p class="sidebar-section-label">Schedule</p>
                <ul class="space-y-0.5">
                    <li>
                        <a href="{{ route('doctor.availability') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('doctor.availability*') ? 'active' : '' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Availability</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('doctor.time-slots') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('doctor.time-slots*') ? 'active' : '' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0zM8 14v.01M12 14v.01M16 14v.01M8 18v.01M12 18v.01M16 18v.01"/></svg>
                            <span>Time Slots</span>
                        </a>
                    </li>
                </ul>

                <p class="sidebar-section-label">Telehealth</p>
                <ul class="space-y-0.5">
                    <li>
                        <a href="{{ route('doctor.meetings') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('doctor.meetings*') ? 'active' : '' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                            <span>Meetings</span>
                        </a>
                    </li>
                </ul>

                <p class="sidebar-section-label">Patients</p>
                <ul class="space-y-0.5">
                    <li>
                        <a href="{{ route('doctor.records') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('doctor.records*') ? 'active' : '' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <span>Patient Records</span>
                        </a>
                    </li>
                </ul>

                <p class="sidebar-section-label">Account</p>
                <ul class="space-y-0.5">
                    <li>
                        <a href="{{ route('doctor.notifications') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('doctor.notifications*') ? 'active' : '' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                            <span>Notifications</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('doctor.profile') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('doctor.profile*') ? 'active' : '' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            <span>My Profile</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="p-3" style="border-top: 1px solid rgba(255,255,255,0.05);">
                @auth
                <div class="flex items-center gap-3 px-3 py-2.5 rounded-xl sidebar-user-bg">
                    <div class="w-9 h-9 rounded-full flex-shrink-0 flex items-center justify-center overflow-hidden" style="background: linear-gradient(135deg, #3b82f6, #8b5cf6);">
                        @php $photo = auth()->user()->doctor?->photo ?? null; @endphp
                        @if($photo)
                            <img src="{{ asset('uploads/doctors/' . $photo) }}" alt="" class="w-full h-full object-cover">
                        @else
                            <span class="text-xs font-bold text-white">{{ strtoupper(substr(auth()->user()->name ?? 'D', 0, 2)) }}</span>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0 hidden xl:block">
                        <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name ?? 'Doctor' }}</p>
                        <p class="text-xs sidebar-user-sub truncate">Doctor</p>
                    </div>
                </div>
                @endauth
            </div>
        </aside>

        <div class="flex-1 flex flex-col min-h-full lg:ml-[260px]" id="main-content">
            <header class="sticky top-0 z-30 bg-white/80 header-glass" style="border-bottom: 1px solid rgba(229,231,235,0.6);">
                <div class="flex items-center justify-between h-16 px-4 lg:px-6">
                    <div class="flex items-center gap-3">
                        <button id="mobile-menu-btn" class="lg:hidden flex items-center justify-center w-10 h-10 rounded-xl hover:bg-gray-100 transition-colors">
                            <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        </button>
                        <div>
                            <h1 class="text-lg font-bold text-gray-900 tracking-tight">@yield('page-title', 'Dashboard')</h1>
                            @hasSection('subtitle')
                                <p class="text-xs text-gray-400 mt-0.5">@yield('subtitle')</p>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <button id="header-notification-btn" class="relative w-10 h-10 rounded-xl flex items-center justify-center hover:bg-gray-100 transition-colors text-gray-500">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                            <span id="notification-dot" class="hidden absolute top-2 right-2 w-2 h-2 rounded-full bg-red-500"></span>
                        </button>

                        <div class="relative">
                            <button id="profile-dropdown-btn" class="flex items-center gap-3 p-1.5 rounded-xl hover:bg-gray-100 transition-colors">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center overflow-hidden" style="background: linear-gradient(135deg, #3b82f6, #8b5cf6);">
                                    <span class="text-xs font-bold text-white">{{ strtoupper(substr(auth()->user()->name ?? 'D', 0, 2)) }}</span>
                                </div>
                                <svg class="w-4 h-4 text-gray-400 hidden sm:block" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div id="profile-dropdown" class="hidden absolute right-0 top-12 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden z-50">
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->name ?? 'Doctor' }}</p>
                                    <p class="text-xs text-gray-400">{{ auth()->user()->email ?? '' }}</p>
                                </div>
                                <div class="py-1">
                                    <a href="{{ route('doctor.profile') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-600 hover:bg-gray-50 transition-colors">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                        My Profile
                                    </a>
                                </div>
                                <div class="py-1 border-t border-gray-100">
                                    <button id="logout-btn" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-red-500 hover:bg-red-50 transition-colors w-full">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                        Logout
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 p-4 lg:p-6 page-enter">
                @yield('content')
            </main>

            <footer class="bg-white" style="border-top: 1px solid rgba(229,231,235,0.6);">
                <div class="px-4 lg:px-6 py-4">
                    <p class="text-xs text-gray-400 text-center">&copy; {{ date('Y') }} Lakeshore Clinic. All rights reserved.</p>
                </div>
            </footer>
        </div>
    </div>

    <div id="mobile-overlay" class="hidden fixed inset-0 bg-black/40 z-30 lg:hidden" style="backdrop-filter: blur(2px);"></div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const sidebar = document.getElementById('sidebar');
        const mobileOverlay = document.getElementById('mobile-overlay');

        if (mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', function() {
                sidebar.classList.remove('-translate-x-full');
                mobileOverlay.classList.remove('hidden');
            });
        }

        if (mobileOverlay) {
            mobileOverlay.addEventListener('click', function() {
                sidebar.classList.add('-translate-x-full');
                mobileOverlay.classList.add('hidden');
            });
        }

        const profileBtn = document.getElementById('profile-dropdown-btn');
        const profileDropdown = document.getElementById('profile-dropdown');
        if (profileBtn && profileDropdown) {
            profileBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                profileDropdown.classList.toggle('hidden');
            });
            document.addEventListener('click', function() {
                profileDropdown.classList.add('hidden');
            });
        }

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
