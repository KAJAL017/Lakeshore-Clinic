@extends('layouts.auth')

@section('title', 'Admin Login - Lakeshore Clinic')

@section('content')
<div class="text-center mb-8">
    <div class="w-14 h-14 rounded-2xl bg-primary-500 flex items-center justify-center mx-auto mb-4">
        <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
        </svg>
    </div>
    <h2 class="text-2xl font-bold text-text-primary mb-2">Admin Portal</h2>
    <p class="text-text-secondary">Sign in to access the admin panel</p>
</div>

@if(session('error'))
    <div class="mb-6">
        <x-alert variant="danger" :title="session('error')" dismissible />
    </div>
@endif

<form id="admin-login-form" class="space-y-5">
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
                class="w-full pl-10 pr-4 py-2.5 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-colors"
                placeholder="admin@lakeshoreclinic.com"
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
                class="w-full pl-10 pr-10 py-2.5 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-colors"
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
            <input type="checkbox" name="remember" class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500 transition-colors">
            <span class="text-sm text-text-secondary">Remember me</span>
        </label>
    </div>

    <button
        type="submit"
        id="login-btn"
        class="w-full flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
    >
        <span id="login-btn-text">Sign in to Admin</span>
        <svg id="login-btn-spinner" class="hidden animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    </button>
</form>

<div class="mt-6 pt-6 border-t border-surface-border text-center">
    <p class="text-sm text-text-secondary mb-3">Other login options:</p>
    <div class="flex items-center justify-center gap-3">
        <a href="{{ route('doctor.login') }}" class="text-sm font-medium text-primary-600 hover:text-primary-700 transition-colors">
            Doctor Login
        </a>
        <span class="text-text-muted">|</span>
        <a href="{{ route('patient.login') }}" class="text-sm font-medium text-primary-600 hover:text-primary-700 transition-colors">
            Patient Login
        </a>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('admin-login-form');
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
            const response = await fetch('{{ route("admin.login.post") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
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
        btnText.textContent = loading ? 'Signing in...' : 'Sign in to Admin';
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
@endpush
@endsection
