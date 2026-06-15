@php
    $isMobile = preg_match('/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i', request()->userAgent());
@endphp

@if($isMobile)
    @extends('layouts.patient-mobile')
@else
    <!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', 'Patient Panel - Lakeshore Clinic')</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('styles')
    </head>
    <body class="h-full bg-surface">
        <div id="toast-container" class="fixed top-4 right-4 z-50 flex flex-col gap-2"></div>

        <div class="flex h-full">
            <aside id="sidebar" class="fixed top-0 left-0 z-40 h-full w-64 bg-[#0d9488] text-white sidebar-transition -translate-x-full lg:translate-x-0">
                <div class="flex items-center justify-center h-20 px-4 border-b border-white/10">
                    <a href="{{ route('patient.dashboard') }}" class="flex items-center justify-center">
                        @php $logo = \App\Models\Setting::getValue('clinic_logo'); @endphp
                        @if($logo)
                            <img src="{{ asset('uploads/branding/' . $logo) }}" alt="Logo" class="h-14 w-auto object-contain">
                        @else
                            <div class="w-14 h-14 rounded-xl bg-white/20 flex items-center justify-center">
                                <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                            </div>
                        @endif
                    </a>
                </div>
                <nav class="flex-1 overflow-y-auto py-4 px-3">
                    <ul class="space-y-1">
                        <li><a href="{{ route('patient.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('patient.dashboard') ? 'bg-white/10 text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white' }} transition-colors"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg><span>Dashboard</span></a></li>
                        <li><a href="{{ route('patient.book-appointment') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('patient.book-appointment*') ? 'bg-white/10 text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white' }} transition-colors"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg><span>Book Appointment</span></a></li>
                        <li><a href="{{ route('patient.my-appointments') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('patient.my-appointments') ? 'bg-white/10 text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white' }} transition-colors"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg><span>My Appointments</span></a></li>
                        <li><a href="{{ route('patient.medical-records') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('patient.medical-records*') ? 'bg-white/10 text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white' }} transition-colors"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg><span>Medical Records</span></a></li>
                        <li><a href="{{ route('patient.telemedicine-sessions') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('patient.telemedicine-sessions') ? 'bg-white/10 text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white' }} transition-colors"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg><span>Telemedicine</span></a></li>
                        <li><a href="{{ route('patient.payments') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('patient.payments*') ? 'bg-white/10 text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white' }} transition-colors"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg><span>Payments</span></a></li>
                        <li><a href="{{ route('patient.insurance') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('patient.insurance*') ? 'bg-white/10 text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white' }} transition-colors"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg><span>Insurance</span></a></li>
                        <li><a href="{{ route('notifications') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('notifications') ? 'bg-white/10 text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white' }} transition-colors"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg><span>Notifications</span></a></li>
                        <li><a href="{{ route('patient.profile') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('patient.profile*') ? 'bg-white/10 text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white' }} transition-colors"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg><span>My Profile</span></a></li>
                    </ul>
                </nav>
                <div class="p-4 border-t border-white/10">
                    @auth
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-white/20 flex items-center justify-center">
                            <span class="text-sm font-medium">{{ strtoupper(substr(auth()->user()->name ?? 'P', 0, 2)) }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name ?? 'Patient' }}</p>
                            <p class="text-xs text-gray-300 truncate">Patient</p>
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
                                <svg class="w-5 h-5 text-text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                            </button>
                            <h1 class="text-lg font-semibold text-text-primary">@yield('page-title', 'Dashboard')</h1>
                        </div>
                        <div class="flex items-center gap-2 lg:gap-4">
                            <button data-dropdown-toggle="profile-dropdown" class="flex items-center gap-3 p-1.5 rounded-lg hover:bg-gray-100 transition-colors">
                                <div class="w-8 h-8 rounded-full bg-health-500/20 flex items-center justify-center">
                                    <span class="text-sm font-medium text-health-600">{{ strtoupper(substr(auth()->user()->name ?? 'P', 0, 2)) }}</span>
                                </div>
                            </button>
                            <div id="profile-dropdown" class="hidden absolute right-4 top-14 mt-2 w-56 bg-white rounded-xl shadow-dropdown border border-surface-border overflow-hidden z-50">
                                <div class="px-4 py-3 border-b border-surface-border">
                                    <p class="text-sm font-semibold text-text-primary">{{ auth()->user()->name ?? 'Patient' }}</p>
                                    <p class="text-xs text-text-muted">{{ auth()->user()->email ?? '' }}</p>
                                </div>
                                <div class="py-1"><a href="{{ route('patient.profile') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-text-secondary hover:bg-surface transition-colors">My Profile</a></div>
                                <div class="py-1 border-t border-surface-border">
                                    <button id="logout-btn" class="flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors w-full">Logout</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>
                <main class="flex-1 p-4 lg:p-6">@yield('content')</main>
                <footer class="bg-white border-t border-surface-border">
                    <div class="px-4 lg:px-6 py-4"><p class="text-sm text-text-muted text-center">&copy; {{ date('Y') }} Lakeshore Clinic. All rights reserved.</p></div>
                </footer>
            </div>
        </div>
        <div id="mobile-overlay" class="hidden fixed inset-0 bg-black/50 z-30 lg:hidden"></div>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuBtn = document.getElementById('mobile-menu-btn');
            const sidebar = document.getElementById('sidebar');
            const mobileOverlay = document.getElementById('mobile-overlay');
            if (mobileMenuBtn) { mobileMenuBtn.addEventListener('click', function() { sidebar.classList.remove('-translate-x-full'); mobileOverlay.classList.remove('hidden'); }); }
            if (mobileOverlay) { mobileOverlay.addEventListener('click', function() { sidebar.classList.add('-translate-x-full'); mobileOverlay.classList.add('hidden'); }); }
            const logoutBtn = document.getElementById('logout-btn');
            if (logoutBtn) {
                logoutBtn.addEventListener('click', async function() {
                    try {
                        const response = await fetch('{{ route("logout") }}', { method: 'POST', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json', } });
                        const data = await response.json();
                        if (data.success) { window.location.href = data.redirect; }
                    } catch (error) { showToast('An error occurred.', 'error'); }
                });
            }
            document.querySelectorAll('.sidebar-menu-item .sidebar-menu-link').forEach(function(link) {
                link.addEventListener('click', function(e) { e.preventDefault(); const submenu = this.nextElementSibling; if (submenu) { submenu.classList.toggle('hidden'); const arrow = this.querySelector('.sidebar-arrow'); if (arrow) arrow.classList.toggle('rotate-90'); } });
            });
        });
        </script>
        @stack('scripts')
    </body>
    </html>
@endif
