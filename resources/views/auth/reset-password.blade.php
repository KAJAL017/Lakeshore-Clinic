@extends('layouts.auth')

@section('content')
<div class="text-center mb-8">
    <div class="w-16 h-16 mx-auto rounded-2xl bg-health-50 flex items-center justify-center mb-6">
        <svg class="w-8 h-8 text-health-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
        </svg>
    </div>
    <h2 class="text-2xl font-bold text-text-primary mb-2">Reset password</h2>
    <p class="text-text-secondary">Enter your new password below</p>
</div>

<form id="reset-password-form" class="space-y-5">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <input type="hidden" name="email" value="{{ $email }}">

    <div>
        <label for="password" class="block text-sm font-medium text-text-primary mb-1.5">New Password</label>
        <div class="relative">
            <input
                type="password"
                id="password"
                name="password"
                required
                autocomplete="new-password"
                class="w-full pl-10 pr-10 py-2.5 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-colors"
                placeholder="Enter new password"
            >
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
        </div>
        <p id="password-error" class="text-sm text-red-600 mt-1 hidden"></p>
        <p class="text-xs text-text-muted mt-1">Must contain uppercase, lowercase, and numbers. Minimum 8 characters.</p>
    </div>

    <div>
        <label for="password_confirmation" class="block text-sm font-medium text-text-primary mb-1.5">Confirm Password</label>
        <div class="relative">
            <input
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                required
                autocomplete="new-password"
                class="w-full pl-10 pr-4 py-2.5 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-colors"
                placeholder="Confirm new password"
            >
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
        </div>
        <p id="password_confirmation-error" class="text-sm text-red-600 mt-1 hidden"></p>
    </div>

    <button
        type="submit"
        id="reset-btn"
        class="w-full flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-health-600 rounded-lg hover:bg-health-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-health-500 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
    >
        <span id="reset-btn-text">Reset password</span>
        <svg id="reset-btn-spinner" class="hidden animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    </button>

    <div class="text-center">
        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-sm font-medium text-text-secondary hover:text-primary-600 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to login
        </a>
    </div>
</form>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('reset-password-form');
    const btn = document.getElementById('reset-btn');
    const btnText = document.getElementById('reset-btn-text');
    const btnSpinner = document.getElementById('reset-btn-spinner');

    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        clearErrors();
        setLoading(true);

        try {
            const formData = new FormData(form);
            const response = await fetch('{{ route("password.update") }}', {
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
                }, 1500);
            } else {
                if (data.errors) {
                    Object.keys(data.errors).forEach(field => {
                        showFieldError(field, data.errors[field][0]);
                    });
                }
                showToast(data.message || 'Failed to reset password.', 'error');
            }
        } catch (error) {
            showToast('An error occurred. Please try again.', 'error');
        } finally {
            setLoading(false);
        }
    });

    function setLoading(loading) {
        btn.disabled = loading;
        btnText.textContent = loading ? 'Resetting...' : 'Reset password';
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
