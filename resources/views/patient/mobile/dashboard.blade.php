@extends('layouts.patient-mobile')

@section('title', 'Dashboard - Lakeshore Clinic')
@section('page-title', 'Home')

@section('content')
<div class="space-y-4">
    <div class="bg-gradient-to-r from-[#0d9488] to-[#14b8a6] rounded-2xl p-5 text-white">
        <h2 class="text-lg font-semibold mb-1">Welcome back!</h2>
        <p class="text-teal-100 text-sm">Manage your health appointments</p>
        <a href="{{ route('patient.book-appointment') }}" class="inline-flex items-center gap-2 mt-4 px-4 py-2 bg-white text-[#0d9488] rounded-xl text-sm font-medium">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Book Appointment
        </a>
    </div>

    <div class="grid grid-cols-2 gap-3">
        <a href="{{ route('patient.my-appointments') }}" class="mobile-card bg-white rounded-xl p-4 shadow-sm border border-surface-border">
            <div class="w-10 h-10 rounded-xl bg-primary-50 flex items-center justify-center mb-2">
                <svg class="w-5 h-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <p class="text-sm font-medium text-text-primary">My Appointments</p>
            <p class="text-xs text-text-muted">View & manage</p>
        </a>
        <a href="{{ route('patient.medical-records') }}" class="mobile-card bg-white rounded-xl p-4 shadow-sm border border-surface-border">
            <div class="w-10 h-10 rounded-xl bg-health-50 flex items-center justify-center mb-2">
                <svg class="w-5 h-5 text-health-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <p class="text-sm font-medium text-text-primary">Medical Records</p>
            <p class="text-xs text-text-muted">View documents</p>
        </a>
        <a href="{{ route('patient.telemedicine') }}" class="mobile-card bg-white rounded-xl p-4 shadow-sm border border-surface-border">
            <div class="w-10 h-10 rounded-xl bg-[#1e3a5f]/10 flex items-center justify-center mb-2">
                <svg class="w-5 h-5 text-[#1e3a5f]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
            </div>
            <p class="text-sm font-medium text-text-primary">Telemedicine</p>
            <p class="text-xs text-text-muted">Virtual visits</p>
        </a>
        <a href="{{ route('patient.payments') }}" class="mobile-card bg-white rounded-xl p-4 shadow-sm border border-surface-border">
            <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center mb-2">
                <svg class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
            </div>
            <p class="text-sm font-medium text-text-primary">Payments</p>
            <p class="text-xs text-text-muted">View history</p>
        </a>
    </div>

    @if(isset($upcomingAppointments) && $upcomingAppointments->count() > 0)
    <div>
        <div class="flex items-center justify-between mb-3">
            <h3 class="text-base font-semibold text-text-primary">Upcoming Appointments</h3>
            <a href="{{ route('patient.my-appointments') }}" class="text-sm text-[#0d9488]">View All</a>
        </div>
        @foreach($upcomingAppointments as $appointment)
        <div class="mobile-card bg-white rounded-xl p-4 shadow-sm border border-surface-border mb-3">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-xl bg-primary-50 flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-text-primary">{{ $appointment->doctor?->name ?? 'TBD' }}</p>
                    <p class="text-xs text-text-muted">{{ $appointment->appointment_date->format('M d') }} at {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}</p>
                </div>
                <span class="px-2 py-1 text-xs font-medium bg-amber-100 text-amber-700 rounded-full">{{ ucfirst($appointment->status) }}</span>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection
