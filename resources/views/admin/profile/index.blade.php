@extends('layouts.app')

@section('title', 'My Profile - Lakeshore Clinic')
@section('page-title', 'My Profile')

@section('content')
<div class="space-y-6">
    <x-page-header title="My Profile">
        <x-slot name="subtitle">Manage your account settings</x-slot>
    </x-page-header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <x-card variant="default" class="lg:col-span-1">
            <div class="p-6 text-center">
                <div class="relative inline-block mb-4">
                    <div id="photo-preview" class="w-24 h-24 rounded-full bg-primary-500/20 flex items-center justify-center overflow-hidden mx-auto">
                        @if($user->photo)
                            <img src="{{ asset('uploads/profile/' . $user->photo) }}" alt="Profile" class="w-full h-full object-cover">
                        @else
                            <span class="text-2xl font-bold text-primary-600">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                        @endif
                    </div>
                    <button id="change-photo-btn" class="absolute bottom-0 right-0 w-8 h-8 bg-primary-600 rounded-full flex items-center justify-center text-white hover:bg-primary-700 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </button>
                    <input type="file" id="photo-input" accept="image/*" class="hidden">
                </div>

                <h3 class="text-lg font-semibold text-text-primary">{{ $user->name }}</h3>
                <p class="text-sm text-text-muted">{{ $user->email }}</p>

                <div class="mt-4 pt-4 border-t border-surface-border space-y-2">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-text-muted">Role</span>
                        <x-badge variant="primary">{{ ucfirst($user->role ?? 'user') }}</x-badge>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-text-muted">Status</span>
                        <x-status-badge :variant="$user->status" :label="$user->status_label" />
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-text-muted">Joined</span>
                        <span class="text-text-primary">{{ $user->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-text-muted">Last Login</span>
                        <span class="text-text-primary">Just now</span>
                    </div>
                </div>
            </div>
        </x-card>

        <div class="lg:col-span-2 space-y-6">
            <x-card variant="default">
                <div class="p-6">
                    <x-page-header title="Profile Information" />
                    <form id="profile-form" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <x-input label="Full Name" name="name" :value="$user->name" required />
                            <x-input label="Email Address" name="email" type="email" :value="$user->email" required />
                        </div>
                        <x-input label="Phone Number" name="phone" :value="$user->phone ?? ''" placeholder="+1 (555) 000-0000" />
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
                            <x-input label="New Password" name="password" type="password" required hint="Min 8 chars, uppercase, lowercase, numbers" />
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

<x-modal id="crop-photo" title="Update Profile Photo">
    <div class="space-y-4">
        <div id="photo-crop-preview" class="w-48 h-48 mx-auto rounded-full overflow-hidden bg-surface border border-surface-border">
            <img id="photo-crop-img" src="" alt="Preview" class="w-full h-full object-cover">
        </div>
    </div>

    <x-slot name="footer">
        <x-button variant="outline" size="sm" data-modal-close>Cancel</x-button>
        <x-button variant="primary" size="sm" id="upload-photo-btn">
            <span id="upload-photo-text">Upload Photo</span>
            <svg id="upload-photo-spinner" class="hidden animate-spin w-4 h-4 ml-1.5" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </x-button>
    </x-slot>
</x-modal>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const changePhotoBtn = document.getElementById('change-photo-btn');
    const photoInput = document.getElementById('photo-input');
    const uploadPhotoBtn = document.getElementById('upload-photo-btn');

    changePhotoBtn.addEventListener('click', () => photoInput.click());

    photoInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(ev) {
                document.getElementById('photo-crop-img').src = ev.target.result;
                openModal('modal-crop-photo');
            };
            reader.readAsDataURL(file);
        }
    });

    uploadPhotoBtn.addEventListener('click', async function() {
        const file = photoInput.files[0];
        if (!file) return;

        const btn = this;
        const btnText = document.getElementById('upload-photo-text');
        const btnSpinner = document.getElementById('upload-photo-spinner');

        btn.disabled = true;
        btnText.textContent = 'Uploading...';
        btnSpinner.classList.remove('hidden');

        const formData = new FormData();
        formData.append('photo', file);

        try {
            const response = await fetch('{{ route("admin.profile.photo") }}', {
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
                document.getElementById('photo-preview').innerHTML = `<img src="${data.photo_url}" alt="Profile" class="w-full h-full object-cover">`;
                closeModal('modal-crop-photo');
            } else {
                showToast(data.message || 'Failed to upload photo.', 'error');
            }
        } catch (error) {
            showToast('An error occurred. Please try again.', 'error');
        } finally {
            btn.disabled = false;
            btnText.textContent = 'Upload Photo';
            btnSpinner.classList.add('hidden');
        }
    });

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
            const response = await fetch('{{ route("admin.profile.update") }}', {
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
            const response = await fetch('{{ route("admin.profile.password") }}', {
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
