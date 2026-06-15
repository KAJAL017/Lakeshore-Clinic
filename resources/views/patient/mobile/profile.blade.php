@extends('layouts.patient-mobile')

@section('title', 'My Profile - Lakeshore Clinic')
@section('page-title', 'Profile')

@section('content')
<div class="space-y-4">
    <div class="bg-white rounded-xl p-6 shadow-sm border border-surface-border text-center">
        <div class="w-20 h-20 rounded-full bg-[#0d9488]/20 flex items-center justify-center mx-auto mb-4">
            <span class="text-2xl font-bold text-[#0d9488]">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</span>
        </div>
        <h3 class="text-lg font-semibold text-text-primary">{{ auth()->user()->name }}</h3>
        <p class="text-sm text-text-muted">{{ auth()->user()->email }}</p>
    </div>

    <div class="space-y-2">
        <a href="{{ route('patient.profile') }}" class="mobile-card flex items-center gap-3 bg-white rounded-xl p-4 shadow-sm border border-surface-border">
            <div class="w-10 h-10 rounded-xl bg-primary-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            </div>
            <div class="flex-1">
                <p class="text-sm font-medium text-text-primary">Edit Profile</p>
                <p class="text-xs text-text-muted">Update your information</p>
            </div>
            <svg class="w-5 h-5 text-text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>

        <a href="{{ route('notifications') }}" class="mobile-card flex items-center gap-3 bg-white rounded-xl p-4 shadow-sm border border-surface-border">
            <div class="w-10 h-10 rounded-xl bg-[#0d9488]/10 flex items-center justify-center">
                <svg class="w-5 h-5 text-[#0d9488]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
            </div>
            <div class="flex-1">
                <p class="text-sm font-medium text-text-primary">Notifications</p>
                <p class="text-xs text-text-muted">View alerts</p>
            </div>
            <svg class="w-5 h-5 text-text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>

        <button onclick="document.getElementById('logout-btn').click()" class="w-full mobile-card flex items-center gap-3 bg-white rounded-xl p-4 shadow-sm border border-surface-border">
            <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
            </div>
            <div class="flex-1">
                <p class="text-sm font-medium text-red-600">Logout</p>
            </div>
        </button>
        <button id="logout-btn" class="hidden"></button>
    </div>
</div>

<script>
document.getElementById('logout-btn').addEventListener('click', async function() {
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
</script>
@endsection
