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
    @stack('styles')
</head>
<body class="h-full bg-surface">
    <div id="toast-container" class="fixed top-4 right-4 z-50 flex flex-col gap-2"></div>

    <div class="flex h-full">
        <aside id="sidebar" class="fixed top-0 left-0 z-40 h-full w-64 bg-[#1e3a5f] text-white sidebar-transition -translate-x-full lg:translate-x-0">
            <div class="flex items-center justify-center h-20 px-4 border-b border-white/10">
                <a href="{{ route('doctor.dashboard') }}" class="flex items-center justify-center">
                    @php
                        $logo = \App\Models\Setting::getValue('clinic_logo');
                    @endphp
                    @if($logo)
                        <img src="{{ asset('uploads/branding/' . $logo) }}" alt="Logo" class="h-14 w-auto object-contain">
                    @else
                        <div class="w-14 h-14 rounded-xl bg-white/20 flex items-center justify-center">
                            <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </div>
                    @endif
                </a>
            </div>

            <nav class="flex-1 overflow-y-auto py-4 px-3">
                <ul class="space-y-1">
                    <li class="sidebar-menu-item">
                        <a href="{{ route('doctor.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('doctor.dashboard') ? 'bg-white/10 text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white' }} transition-colors">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li class="sidebar-menu-item">
                        <a href="{{ route('doctor.availability') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('doctor.availability*') ? 'bg-white/10 text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white' }} transition-colors">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>My Availability</span>
                        </a>
                    </li>

                    <li class="sidebar-menu-item">
                        <a href="{{ route('doctor.profile') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('doctor.profile*') ? 'bg-white/10 text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white' }} transition-colors">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span>My Profile</span>
                        </a>
                    </li>

                    <li class="sidebar-menu-item">
                        <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-300 hover:bg-white/5 hover:text-white transition-colors">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span>Appointments</span>
                            <span class="ml-auto text-xs bg-white/20 px-2 py-0.5 rounded-full">Soon</span>
                        </a>
                    </li>

                    <li class="sidebar-menu-item">
                        <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-300 hover:bg-white/5 hover:text-white transition-colors">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span>My Patients</span>
                            <span class="ml-auto text-xs bg-white/20 px-2 py-0.5 rounded-full">Soon</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="p-4 border-t border-white/10">
                @auth
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-white/20 flex items-center justify-center">
                        <span class="text-sm font-medium">{{ strtoupper(substr(auth()->user()->name ?? 'D', 0, 2)) }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name ?? 'Doctor' }}</p>
                        <p class="text-xs text-gray-300 truncate">Doctor</p>
                    </div>
                </div>
                @endauth
            </div>
        </aside>

        <div class="flex-1 flex flex-col min-h-full lg:ml-64 sidebar-transition" id="main-content">
            <header class="sticky top-0 z-20 bg-white border-b border-surface-border">
                <div class="flex items-center justify-between h-16 px-4 lg:px-6">
                    <div class="flex items-center gap-4">
                        <button id="mobile-menu-btn" class="lg:hidden flex items-center justify-center w-10 h-10 rounded-lg hover:bg-gray-100 transition-colors">
                            <svg class="w-5 h-5 text-text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                        <h1 class="text-lg font-semibold text-text-primary">@yield('page-title', 'Dashboard')</h1>
                    </div>

                    <div class="flex items-center gap-2 lg:gap-4">
                        <button data-dropdown-toggle="profile-dropdown" class="flex items-center gap-3 p-1.5 rounded-lg hover:bg-gray-100 transition-colors">
                            <div class="w-8 h-8 rounded-full bg-primary-500/20 flex items-center justify-center">
                                <span class="text-sm font-medium text-primary-600">{{ strtoupper(substr(auth()->user()->name ?? 'D', 0, 2)) }}</span>
                            </div>
                        </button>
                        <div id="profile-dropdown" class="hidden absolute right-4 top-14 mt-2 w-56 bg-white rounded-xl shadow-dropdown border border-surface-border overflow-hidden z-50">
                            <div class="px-4 py-3 border-b border-surface-border">
                                <p class="text-sm font-semibold text-text-primary">{{ auth()->user()->name ?? 'Doctor' }}</p>
                                <p class="text-xs text-text-muted">{{ auth()->user()->email ?? '' }}</p>
                            </div>
                            <div class="py-1">
                                <a href="{{ route('doctor.profile') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-text-secondary hover:bg-surface transition-colors">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    My Profile
                                </a>
                            </div>
                            <div class="py-1 border-t border-surface-border">
                                <button id="logout-btn" class="flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors w-full">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    Logout
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 p-4 lg:p-6">
                @yield('content')
            </main>

            <footer class="bg-white border-t border-surface-border">
                <div class="px-4 lg:px-6 py-4">
                    <p class="text-sm text-text-muted text-center">&copy; {{ date('Y') }} Lakeshore Clinic. All rights reserved.</p>
                </div>
            </footer>
        </div>
    </div>

    <div id="mobile-overlay" class="hidden fixed inset-0 bg-black/50 z-30 lg:hidden"></div>

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
                    if (data.success) {
                        window.location.href = data.redirect;
                    }
                } catch (error) {
                    showToast('An error occurred.', 'error');
                }
            });
        }
    });
    </script>

    @stack('scripts')
</body>
</html>
