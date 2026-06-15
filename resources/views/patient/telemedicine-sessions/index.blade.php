@extends('layouts.patient')

@section('title', 'My Appointments - Lakeshore Clinic')
@section('page-title', 'Telemedicine Sessions')

@section('content')
<div class="space-y-6">
    <x-page-header title="Telemedicine Sessions">
        <x-slot name="subtitle">View your virtual consultation sessions</x-slot>
        <x-slot name="actions">
            <a href="{{ route('patient.telemedicine') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-[#1e3a5f] rounded-lg hover:bg-[#2d5a87] transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                </svg>
                Book Session
            </a>
        </x-slot>
    </x-page-header>

    <x-card variant="default">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-surface-border">
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Doctor</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Date & Time</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Meeting</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-border">
                    @forelse($meetings as $meeting)
                        <tr class="hover:bg-surface transition-colors">
                            <td class="px-4 py-3">
                                <p class="text-sm font-medium text-text-primary">{{ $meeting->appointment->doctor?->name ?? '-' }}</p>
                                <p class="text-xs text-text-muted">{{ $meeting->appointment->specialization?->name ?? '-' }}</p>
                            </td>
                            <td class="px-4 py-3">
                                <p class="text-sm text-text-primary">{{ $meeting->appointment->appointment_date->format('M d, Y') }}</p>
                                <p class="text-xs text-text-muted">{{ \Carbon\Carbon::parse($meeting->appointment->appointment_time)->format('h:i A') }}</p>
                            </td>
                            <td class="px-4 py-3">
                                @php
                                    $statusVariant = match($meeting->status) {
                                        'pending' => 'warning', 'created' => 'info', 'active' => 'success', 'completed' => 'success', 'cancelled' => 'danger', default => 'default',
                                    };
                                @endphp
                                <x-status-badge :variant="$statusVariant" :label="ucfirst($meeting->status)" />
                            </td>
                            <td class="px-4 py-3">
                                @if($meeting->meeting_url)
                                    <a href="{{ $meeting->meeting_url }}" target="_blank" class="inline-flex items-center gap-1 px-3 py-1.5 text-sm font-medium text-[#1e3a5f] bg-[#1e3a5f]/10 rounded-lg hover:bg-[#1e3a5f]/20 transition-colors">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-1M14 4h6m0 0v6m0-6L10 14"/></svg>
                                        Join
                                    </a>
                                @else
                                    <span class="text-xs text-text-muted">Not available</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-12 text-center">
                                <x-empty-state message="No telemedicine sessions found.">
                                    <a href="{{ route('patient.telemedicine') }}" class="mt-3 inline-block text-sm text-primary-600 hover:text-primary-700 font-medium">Book a session</a>
                                </x-empty-state>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-card>
</div>
@endsection
