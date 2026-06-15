@extends('layouts.patient')

@section('title', 'My Profile - Lakeshore Clinic')
@section('page-title', 'My Profile')

@section('content')
<div class="space-y-6">
    <x-page-header title="My Profile">
        <x-slot name="subtitle">Manage your account information</x-slot>
    </x-page-header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <x-card variant="default" class="lg:col-span-1">
            <div class="p-6 text-center">
                <div class="w-24 h-24 rounded-full bg-health-500/20 flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-health-600">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</span>
                </div>
                <h3 class="text-lg font-semibold text-text-primary">{{ auth()->user()->name }}</h3>
                <p class="text-sm text-text-muted">{{ auth()->user()->email }}</p>
                <div class="mt-4 pt-4 border-t border-surface-border">
                    <p class="text-sm text-text-muted">Patient since {{ auth()->user()->created_at->format('M d, Y') }}</p>
                </div>
            </div>
        </x-card>

        <div class="lg:col-span-2 space-y-6">
            <x-card variant="default">
                <div class="p-6">
                    <x-page-header title="Personal Information" />
                    <form id="profile-form" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <x-input label="Full Name" name="name" :value="auth()->user()->name" required />
                            <x-input label="Email" name="email" type="email" :value="auth()->user()->email" required />
                        </div>
                        <x-input label="Phone" name="phone" :value="auth()->user()->phone ?? ''" placeholder="+1 (555) 000-0000" />
                        <div class="flex justify-end">
                            <x-button variant="primary" size="sm" id="save-profile-btn" type="submit">
                                <span id="save-profile-text">Save Changes</span>
                                <svg id="save-profile-spinner" class="hidden animate-spin w-4 h-4 ml-1.5" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </x-button>
                        </div>
                    </form>
                </div>
            </x-card>

            <x-card variant="default">
                <div class="p-6">
                    <x-page-header title="Change Password" />
                    <form id="password-form" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <x-input label="Current Password" name="current_password" type="password" required />
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <x-input label="New Password" name="password" type="password" required />
                            <x-input label="Confirm New Password" name="password_confirmation" type="password" required />
                        </div>
                        <div class="flex justify-end">
                            <x-button variant="primary" size="sm" id="save-password-btn" type="submit">
                                <span id="save-password-text">Update Password</span>
                                <svg id="save-password-spinner" class="hidden animate-spin w-4 h-4 ml-1.5" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </x-button>
                        </div>
                    </form>
                </div>
            </x-card>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('profile-form').addEventListener('submit', async function(e) {
        e.preventDefault();
        const btn = document.getElementById('save-profile-btn');
        const btnText = document.getElementById('save-profile-text');
        const btnSpinner = document.getElementById('save-profile-spinner');

        btn.disabled = true;
        btnText.textContent = 'Saving...';
        btnSpinner.classList.remove('hidden');

        try {
            const formData = new FormData(this);
            const response = await fetch('{{ route("patient.profile.update") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
            });

            const data = await response.json();

            if (response.ok && data.success) {
                showToast(data.message, 'success');
            } else {
                showToast(data.message || 'Failed to update profile.', 'error');
            }
        } catch (error) {
            showToast('An error occurred. Please try again.', 'error');
        } finally {
            btn.disabled = false;
            btnText.textContent = 'Save Changes';
            btnSpinner.classList.add('hidden');
        }
    });

    document.getElementById('password-form').addEventListener('submit', async function(e) {
        e.preventDefault();
        const btn = document.getElementById('save-password-btn');
        const btnText = document.getElementById('save-password-text');
        const btnSpinner = document.getElementById('save-password-spinner');

        btn.disabled = true;
        btnText.textContent = 'Updating...';
        btnSpinner.classList.remove('hidden');

        try {
            const formData = new FormData(this);
            const response = await fetch('{{ route("patient.profile.password") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
            });

            const data = await response.json();

            if (response.ok && data.success) {
                showToast(data.message, 'success');
                this.reset();
            } else {
                showToast(data.message || 'Failed to update password.', 'error');
            }
        } catch (error) {
            showToast('An error occurred. Please try again.', 'error');
        } finally {
            btn.disabled = false;
            btnText.textContent = 'Update Password';
            btnSpinner.classList.add('hidden');
        }
    });
});
</script>
@endpush
@endsection
