<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Patient Login - Lakeshore Clinic</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-surface">
    <div id="toast-container" class="fixed top-4 right-4 z-50 flex flex-col gap-2"></div>

    <div class="min-h-full flex">
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-[#0d9488] via-[#14b8a6] to-[#0d9488] relative overflow-hidden">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg%20width%3D%2260%22%20height%3D%2260%22%20viewBox%3D%220%200%2060%2060%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Cg%20fill%3D%22none%22%20fill-rule%3D%22evenodd%22%3E%3Cg%20fill%3D%22%23ffffff%22%20fill-opacity%3D%220.05%22%3E%3Cpath%20d%3D%22M36%2034v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6%2034v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6%204V0H4v4H0v2h4v4h2V6h4V4H6z%22%2F%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E')] opacity-50"></div>
            <div class="relative z-10 flex flex-col items-center justify-center w-full p-12">
                <div class="w-16 h-16 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center mb-8">
                    <svg class="w-10 h-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-white mb-4">Patient Portal</h1>
                <p class="text-teal-100 text-center text-lg max-w-md">Access your appointments, medical records, and connect with your healthcare team.</p>

                <div class="mt-12 grid grid-cols-2 gap-6 max-w-md">
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 text-center">
                        <div class="text-2xl font-bold text-white">24/7</div>
                        <div class="text-teal-100 text-sm mt-1">Booking</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 text-center">
                        <div class="text-2xl font-bold text-white">Easy</div>
                        <div class="text-teal-100 text-sm mt-1">Scheduling</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 text-center">
                        <div class="text-2xl font-bold text-white">Secure</div>
                        <div class="text-teal-100 text-sm mt-1">Access</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 text-center">
                        <div class="text-2xl font-bold text-white">Track</div>
                        <div class="text-teal-100 text-sm mt-1">Records</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex-1 flex flex-col">
            <div class="flex items-center justify-between p-6 lg:hidden">
                <div class="flex items-center gap-3">
                    @php
                        $logo = \App\Models\Setting::getValue('clinic_logo');
                    @endphp
                    @if($logo)
                        <img src="{{ asset('uploads/branding/' . $logo) }}" alt="Logo" class="h-10 w-auto object-contain">
                    @else
                        <div class="w-10 h-10 rounded-xl bg-[#0d9488] flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </div>
                    @endif
                    <span class="text-xl font-bold text-text-primary">Patient Portal</span>
                </div>
            </div>

            <div class="flex-1 flex items-center justify-center p-6 sm:p-12">
                <div class="w-full max-w-md">
                    <div class="text-center mb-8">
                        <div class="w-16 h-16 mx-auto rounded-2xl bg-[#0d9488]/10 flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-[#0d9488]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-text-primary mb-2">Patient Login</h2>
                        <p class="text-text-secondary">Sign in to your patient account</p>
                    </div>

                    @if(session('error'))
                        <div class="mb-6">
                            <x-alert variant="danger" :title="session('error')" dismissible />
                        </div>
                    @endif

                    <form id="patient-login-form" class="space-y-5">
                        @csrf
                        <div>
                            <label for="email" class="block text-sm font-medium text-text-primary mb-1.5">Email Address</label>
                            <div class="relative">
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                    autocomplete="email"
                                    autofocus
                                    class="w-full pl-10 pr-4 py-2.5 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0d9488]/20 focus:border-[#0d9488] transition-colors"
                                    placeholder="patient@example.com"
                                >
                                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                </svg>
                            </div>
                            <p id="email-error" class="text-sm text-red-600 mt-1 hidden"></p>
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-text-primary mb-1.5">Password</label>
                            <div class="relative">
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    required
                                    autocomplete="current-password"
                                    class="w-full pl-10 pr-10 py-2.5 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0d9488]/20 focus:border-[#0d9488] transition-colors"
                                    placeholder="Enter your password"
                                >
                                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                <button type="button" id="toggle-password" class="absolute right-3 top-1/2 -translate-y-1/2 text-text-muted hover:text-text-secondary transition-colors">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                            <p id="password-error" class="text-sm text-red-600 mt-1 hidden"></p>
                        </div>

                        <div class="flex items-center justify-between">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="remember" class="w-4 h-4 text-[#0d9488] border-gray-300 rounded focus:ring-[#0d9488] transition-colors">
                                <span class="text-sm text-text-secondary">Remember me</span>
                            </label>
                        </div>

                        <button
                            type="submit"
                            id="login-btn"
                            class="w-full flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-[#0d9488] rounded-lg hover:bg-[#0f766e] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0d9488] transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            <span id="login-btn-text">Sign in</span>
                            <svg id="login-btn-spinner" class="hidden animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </button>
                    </form>

                    <div class="mt-6 text-center">
                        <a href="{{ route('public.booking') }}" class="text-sm text-[#0d9488] hover:text-[#0f766e] font-medium">
                            Book an appointment without account →
                        </a>
                    </div>

                    <div class="mt-4 text-center">
                        <a href="{{ route('login') }}" class="text-sm text-text-secondary hover:text-primary-600 transition-colors">
                            ← Back to main login
                        </a>
                    </div>
                </div>
            </div>

            <div class="p-6 text-center text-sm text-text-muted">
                &copy; {{ date('Y') }} Lakeshore Clinic. All rights reserved.
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('patient-login-form');
        const btn = document.getElementById('login-btn');
        const btnText = document.getElementById('login-btn-text');
        const btnSpinner = document.getElementById('login-btn-spinner');
        const togglePassword = document.getElementById('toggle-password');
        const passwordInput = document.getElementById('password');

        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
        });

        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            clearErrors();
            setLoading(true);

            try {
                const formData = new FormData(form);
                formData.set('_token', document.querySelector('meta[name="csrf-token"]').content);
                const response = await fetch('{{ route("login") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    showToast(data.message, 'success');
                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 1000);
                } else {
                    if (data.errors) {
                        Object.keys(data.errors).forEach(field => {
                            showFieldError(field, data.errors[field][0]);
                        });
                    }
                    showToast(data.message || 'Login failed. Please try again.', 'error');
                }
            } catch (error) {
                showToast('An error occurred. Please try again.', 'error');
            } finally {
                setLoading(false);
            }
        });

        function setLoading(loading) {
            btn.disabled = loading;
            btnText.textContent = loading ? 'Signing in...' : 'Sign in';
            btnSpinner.classList.toggle('hidden', !loading);
        }

        function clearErrors() {
            document.querySelectorAll('[id$="-error"]').forEach(el => {
                el.textContent = '';
                el.classList.add('hidden');
            });
            document.querySelectorAll('input').forEach(el => {
                el.classList.remove('border-red-500');
            });
        }

        function showFieldError(field, message) {
            const errorEl = document.getElementById(field + '-error');
            const inputEl = document.getElementById(field);
            if (errorEl) {
                errorEl.textContent = message;
                errorEl.classList.remove('hidden');
            }
            if (inputEl) {
                inputEl.classList.add('border-red-500');
            }
        }
    });
    </script>
</body>
</html>
