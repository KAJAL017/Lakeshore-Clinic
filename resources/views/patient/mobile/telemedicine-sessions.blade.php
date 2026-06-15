@extends('layouts.patient-mobile')

@section('title', 'Telemedicine Sessions - Lakeshore Clinic')
@section('page-title', 'Telemedicine')

@section('content')
<div class="space-y-4">
    @forelse($meetings as $meeting)
        @php
            $appointment = $meeting->appointment;
            $statusConfig = match($meeting->status ?? 'pending') {
                'created' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'dot' => 'bg-emerald-400', 'label' => 'Ready'],
                'pending' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'dot' => 'bg-amber-400', 'label' => 'Pending'],
                'active' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-700', 'dot' => 'bg-blue-400', 'label' => 'Active'],
                'completed' => ['bg' => 'bg-health-50', 'text' => 'text-health-700', 'dot' => 'bg-health-400', 'label' => 'Completed'],
                'cancelled' => ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'dot' => 'bg-red-400', 'label' => 'Cancelled'],
                default => ['bg' => 'bg-gray-50', 'text' => 'text-gray-700', 'dot' => 'bg-gray-400', 'label' => ucfirst($meeting->status ?? 'pending')],
            };
        @endphp
        <div class="mobile-card bg-white rounded-xl p-4 shadow-sm border border-surface-border">
            <div class="flex items-start justify-between mb-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-[#1e3a5f]/10 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-[#1e3a5f]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-text-primary">{{ $appointment->doctor?->name ?? 'Doctor TBD' }}</p>
                        <p class="text-xs text-text-muted">{{ $appointment->specialization?->name ?? '-' }}</p>
                    </div>
                </div>
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }} flex-shrink-0">
                    <span class="w-1.5 h-1.5 rounded-full {{ $statusConfig['dot'] }}"></span>
                    {{ $statusConfig['label'] }}
                </span>
            </div>
            <div class="flex items-center gap-4 text-sm text-text-secondary">
                <div class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span class="font-medium">{{ $appointment->appointment_date->format('M d, Y') }}</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span class="font-medium">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}</span>
                </div>
            </div>
            @if($meeting->meeting_url)
                <div class="mt-3 pt-3 border-t border-surface-border">
                    <a href="{{ $meeting->meeting_url }}" target="_blank" class="flex items-center justify-center gap-2 w-full py-2.5 text-sm font-semibold text-white bg-[#1e3a5f] rounded-xl active:bg-[#2d5a87] transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Join Meeting
                    </a>
                </div>
            @endif
        </div>
    @empty
        <div class="text-center py-16 px-4">
            <div class="w-24 h-24 mx-auto rounded-3xl bg-gradient-to-br from-[#1e3a5f]/10 to-[#1e3a5f]/5 flex items-center justify-center mb-5">
                <svg class="w-12 h-12 text-[#1e3a5f]/60" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
            </div>
            <h3 class="text-lg font-bold text-text-primary mb-2">No Sessions Yet</h3>
            <p class="text-sm text-text-muted mb-6 max-w-[240px] mx-auto">Your telemedicine sessions will appear here</p>
            <a href="{{ route('patient.telemedicine') }}" class="inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-[#0d9488] text-white rounded-2xl font-semibold shadow-lg shadow-[#0d9488]/25 active:scale-95 transition-all">
                Book Session
            </a>
        </div>
    @endforelse
</div>
@endsection
