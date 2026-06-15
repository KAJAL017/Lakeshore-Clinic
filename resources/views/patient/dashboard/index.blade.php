@extends('layouts.patient')

@section('title', 'Patient Dashboard - Lakeshore Clinic')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <x-page-header title="Welcome back, {{ auth()->user()->name }}">
        <x-slot name="subtitle">Manage your health appointments</x-slot>
        <x-slot name="actions">
            <x-button variant="primary" size="sm" href="{{ route('patient.booking') }}">
                <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Book Appointment
            </x-button>
        </x-slot>
    </x-page-header>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
        @foreach($stats as $stat)
            <x-stat-card
                :label="$stat['label']"
                :value="$stat['value']"
                :trend="$stat['trend']"
                :trend-direction="$stat['trendDirection']"
                :color="$stat['color']"
            />
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 lg:gap-6">
        <x-card variant="default" class="lg:col-span-2">
            <div class="p-6">
                <x-page-header title="Upcoming Appointments">
                    <x-slot name="actions">
                        <a href="{{ route('patient.appointments') }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium">View All</a>
                    </x-slot>
                </x-page-header>
                @forelse($upcomingAppointments as $appointment)
                    <div class="flex items-center gap-4 p-3 border border-surface-border rounded-lg mb-3 last:mb-0 hover:shadow-card transition-shadow">
                        <div class="w-12 h-12 rounded-xl bg-primary-500/10 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-text-primary">{{ $appointment->doctor?->name ?? 'TBD' }}</p>
                            <p class="text-xs text-text-muted">{{ $appointment->specialization?->name ?? '-' }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-medium text-text-primary">{{ $appointment->appointment_date->format('M d, Y') }}</p>
                            <p class="text-xs text-text-muted">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</p>
                        </div>
                        <div>
                            @php
                                $statusVariant = match($appointment->status) {
                                    'pending' => 'warning',
                                    'approved' => 'success',
                                    'scheduled' => 'info',
                                    default => 'default',
                                };
                            @endphp
                            <x-badge :variant="$statusVariant">{{ ucfirst($appointment->status) }}</x-badge>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-text-muted mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-sm text-text-muted mb-3">No upcoming appointments</p>
                        <a href="{{ route('patient.booking') }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium">Book an appointment</a>
                    </div>
                @endforelse
            </div>
        </x-card>

        <x-card variant="default">
            <div class="p-6">
                <x-page-header title="Quick Actions" />
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('patient.booking') }}" class="flex flex-col items-center gap-2 p-4 rounded-xl border border-surface-border hover:border-primary-300 hover:bg-primary-50/50 transition-all group">
                        <div class="w-10 h-10 rounded-xl bg-primary-500/10 flex items-center justify-center text-primary-600 group-hover:bg-primary-500 group-hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        </div>
                        <span class="text-xs font-medium text-text-secondary group-hover:text-primary-600 transition-colors">Book</span>
                    </a>
                    <a href="{{ route('patient.appointments') }}" class="flex flex-col items-center gap-2 p-4 rounded-xl border border-surface-border hover:border-primary-300 hover:bg-primary-50/50 transition-all group">
                        <div class="w-10 h-10 rounded-xl bg-primary-500/10 flex items-center justify-center text-primary-600 group-hover:bg-primary-500 group-hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <span class="text-xs font-medium text-text-secondary group-hover:text-primary-600 transition-colors">History</span>
                    </a>
                    <a href="{{ route('patient.records') }}" class="flex flex-col items-center gap-2 p-4 rounded-xl border border-surface-border hover:border-primary-300 hover:bg-primary-50/50 transition-all group">
                        <div class="w-10 h-10 rounded-xl bg-primary-500/10 flex items-center justify-center text-primary-600 group-hover:bg-primary-500 group-hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <span class="text-xs font-medium text-text-secondary group-hover:text-primary-600 transition-colors">Records</span>
                    </a>
                    <a href="{{ route('patient.profile') }}" class="flex flex-col items-center gap-2 p-4 rounded-xl border border-surface-border hover:border-primary-300 hover:bg-primary-50/50 transition-all group">
                        <div class="w-10 h-10 rounded-xl bg-primary-500/10 flex items-center justify-center text-primary-600 group-hover:bg-primary-500 group-hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <span class="text-xs font-medium text-text-secondary group-hover:text-primary-600 transition-colors">Profile</span>
                    </a>
                </div>
            </div>
        </x-card>
    </div>
</div>
@endsection
