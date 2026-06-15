@extends('layouts.doctor')

@section('title', 'My Profile - Lakeshore Clinic')
@section('page-title', 'My Profile')

@section('content')
<div class="space-y-6">
    <p class="text-sm text-gray-400">Manage your professional information and account settings</p>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Profile Card --}}
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
            <div class="h-24" style="background: linear-gradient(135deg, #1e3a5f, #2563eb);"></div>
            <div class="px-6 pb-6">
                <div class="relative -mt-12 mb-4 inline-block">
                    <div id="photo-preview" class="w-24 h-24 rounded-2xl bg-white border-4 border-white shadow-lg flex items-center justify-center overflow-hidden">
                        @if($doctor && $doctor->photo)
                            <img src="{{ asset('uploads/doctors/' . $doctor->photo) }}" alt="Profile" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center" style="background: linear-gradient(135deg, #3b82f6, #8b5cf6);">
                                <span class="text-2xl font-bold text-white">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</span>
                            </div>
                        @endif
                    </div>
                    <button id="change-photo-btn" class="absolute -bottom-1 -right-1 w-8 h-8 bg-blue-600 rounded-xl flex items-center justify-center text-white hover:bg-blue-700 transition-colors shadow-lg">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </button>
                    <input type="file" id="photo-input" accept="image/*" class="hidden">
                </div>
                <h3 class="text-lg font-bold text-gray-900">{{ auth()->user()->name }}</h3>
                <p class="text-sm text-gray-400">{{ auth()->user()->email }}</p>

                @if($doctor)
                    <div class="mt-4 pt-4 border-t border-gray-100 space-y-3">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-400">License</span>
                            <span class="text-gray-900 font-medium">{{ $doctor->license_number ?? '-' }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-400">Status</span>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-xs font-medium {{ $doctor->status === 'active' ? 'bg-green-50 text-green-700' : 'bg-amber-50 text-amber-700' }}">{{ ucfirst($doctor->status) }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-400">Approval</span>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-xs font-medium {{ $doctor->approval_status === 'approved' ? 'bg-green-50 text-green-700' : 'bg-amber-50 text-amber-700' }}">{{ ucfirst($doctor->approval_status) }}</span>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="lg:col-span-2 space-y-6">
            {{-- Professional Information --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <h3 class="text-sm font-bold text-gray-900 mb-5">Professional Information</h3>
                <form id="profile-form" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div><label class="block text-sm font-medium text-gray-700 mb-1.5">Phone</label><input type="text" name="phone" value="{{ $doctor->phone ?? '' }}" placeholder="+1 (555) 000-0000" class="w-full px-3 py-2.5 text-sm bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500"></div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1.5">Qualification</label><input type="text" name="qualification" value="{{ $doctor->qualification ?? '' }}" class="w-full px-3 py-2.5 text-sm bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500"></div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div><label class="block text-sm font-medium text-gray-700 mb-1.5">Years of Experience</label><input type="number" name="years_of_experience" value="{{ $doctor->years_of_experience ?? 0 }}" min="0" class="w-full px-3 py-2.5 text-sm bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500"></div>
                    </div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1.5">Address</label><textarea name="address" rows="2" class="w-full px-3 py-2.5 text-sm bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 resize-none">{{ $doctor->address ?? '' }}</textarea></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1.5">Biography</label><textarea name="biography" rows="3" class="w-full px-3 py-2.5 text-sm bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 resize-none">{{ $doctor->biography ?? '' }}</textarea></div>
                    <div class="flex justify-end">
                        <button type="submit" id="save-profile-btn" class="px-5 py-2.5 text-sm font-semibold text-white rounded-xl" style="background: linear-gradient(135deg, #2563eb, #1d4ed8);">
                            <span id="save-profile-text">Save Changes</span>
                            <svg id="save-profile-spinner" class="hidden animate-spin w-4 h-4 ml-1.5 inline-block" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        </button>
                    </div>
                </form>
            </div>

            {{-- Change Password --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <h3 class="text-sm font-bold text-gray-900 mb-5">Change Password</h3>
                <form id="password-form" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div><label class="block text-sm font-medium text-gray-700 mb-1.5">Current Password</label><input type="password" name="current_password" required class="w-full px-3 py-2.5 text-sm bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500"></div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div><label class="block text-sm font-medium text-gray-700 mb-1.5">New Password</label><input type="password" name="password" required class="w-full px-3 py-2.5 text-sm bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500"></div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1.5">Confirm New Password</label><input type="password" name="password_confirmation" required class="w-full px-3 py-2.5 text-sm bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500"></div>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" id="save-password-btn" class="px-5 py-2.5 text-sm font-semibold text-white rounded-xl" style="background: linear-gradient(135deg, #2563eb, #1d4ed8);">
                            <span id="save-password-text">Update Password</span>
                            <svg id="save-password-spinner" class="hidden animate-spin w-4 h-4 ml-1.5 inline-block" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const changePhotoBtn = document.getElementById('change-photo-btn');
    const photoInput = document.getElementById('photo-input');

    changePhotoBtn.addEventListener('click', () => photoInput.click());

    photoInput.addEventListener('change', async function(e) {
        const file = e.target.files[0];
        if (!file) return;
        const formData = new FormData();
        formData.append('photo', file);
        try {
            const response = await fetch('{{ route("doctor.profile.photo") }}', { method: 'POST', body: formData, headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } });
            const data = await response.json();
            if (response.ok && data.success) { showToast(data.message, 'success'); document.getElementById('photo-preview').innerHTML = `<img src="${data.photo_url}" alt="Profile" class="w-full h-full object-cover">`; } else { showToast(data.message || 'Failed to upload photo.', 'error'); }
        } catch (error) { showToast('An error occurred. Please try again.', 'error'); }
    });

    document.getElementById('profile-form').addEventListener('submit', async function(e) {
        e.preventDefault();
        const btn = document.getElementById('save-profile-btn');
        const btnText = document.getElementById('save-profile-text');
        const btnSpinner = document.getElementById('save-profile-spinner');
        btn.disabled = true; btnText.textContent = 'Saving...'; btnSpinner.classList.remove('hidden');
        try {
            const formData = new FormData(this);
            const response = await fetch('{{ route("doctor.profile.update") }}', { method: 'POST', body: formData, headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } });
            const data = await response.json();
            if (response.ok && data.success) { showToast(data.message, 'success'); } else { showToast(data.message || 'Failed to update profile.', 'error'); }
        } catch (error) { showToast('An error occurred. Please try again.', 'error'); } finally { btn.disabled = false; btnText.textContent = 'Save Changes'; btnSpinner.classList.add('hidden'); }
    });

    document.getElementById('password-form').addEventListener('submit', async function(e) {
        e.preventDefault();
        const btn = document.getElementById('save-password-btn');
        const btnText = document.getElementById('save-password-text');
        const btnSpinner = document.getElementById('save-password-spinner');
        btn.disabled = true; btnText.textContent = 'Updating...'; btnSpinner.classList.remove('hidden');
        try {
            const formData = new FormData(this);
            const response = await fetch('{{ route("doctor.profile.password") }}', { method: 'POST', body: formData, headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } });
            const data = await response.json();
            if (response.ok && data.success) { showToast(data.message, 'success'); this.reset(); } else { showToast(data.message || 'Failed to update password.', 'error'); }
        } catch (error) { showToast('An error occurred. Please try again.', 'error'); } finally { btn.disabled = false; btnText.textContent = 'Update Password'; btnSpinner.classList.add('hidden'); }
    });
});
</script>
@endpush
@endsection
