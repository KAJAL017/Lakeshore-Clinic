@extends('layouts.patient')

@section('title', 'My Records - Lakeshore Clinic')
@section('page-title', 'My Medical Records')

@section('content')
<div class="space-y-6">
    <x-page-header title="My Medical Records">
        <x-slot name="subtitle">View your appointments, consultations, and documents</x-slot>
    </x-page-header>

    @if(!$patient)
        <x-card variant="default" class="p-12">
            <x-empty-state message="No patient record found. Please contact support." />
        </x-card>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <x-card variant="default">
                <div class="p-6">
                    <x-page-header title="Appointments" />
                    @forelse($appointments as $appointment)
                        <div class="flex items-center gap-3 p-3 border border-surface-border rounded-lg mb-2">
                            <x-badge variant="{{ $appointment->type === 'clinic' ? 'primary' : 'info' }}">{{ $appointment->type_label }}</x-badge>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-text-primary">{{ $appointment->doctor?->name ?? 'TBD' }}</p>
                                <p class="text-xs text-text-muted">{{ $appointment->appointment_date->format('M d, Y') }} {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</p>
                            </div>
                            <x-status-badge :variant="ucfirst($appointment->status)" :label="ucfirst($appointment->status)" />
                        </div>
                    @empty
                        <p class="text-sm text-text-muted">No appointments found.</p>
                    @endforelse
                </div>
            </x-card>

            <x-card variant="default">
                <div class="p-6">
                    <x-page-header title="Consultations" />
                    @forelse($consultations as $consultation)
                        <div class="flex items-center gap-3 p-3 border border-surface-border rounded-lg mb-2">
                            <x-status-badge :variant="ucfirst($consultation->status)" :label="$consultation->status_label" />
                            <div class="flex-1">
                                <p class="text-sm font-medium text-text-primary">{{ $consultation->appointment?->doctor?->name ?? '-' }}</p>
                                <p class="text-xs text-text-muted">{{ $consultation->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-text-muted">No consultations found.</p>
                    @endforelse
                </div>
            </x-card>

            <x-card variant="default">
                <div class="p-6">
                    <x-page-header title="Prescriptions" />
                    @forelse($prescriptions as $prescription)
                        <div class="flex items-center gap-3 p-3 border border-surface-border rounded-lg mb-2">
                            <x-status-badge :variant="$prescription->status === 'issued' ? 'success' : 'warning'" :label="$prescription->status_label" />
                            <div class="flex-1">
                                <p class="text-sm font-medium text-text-primary">{{ $prescription->doctor?->name ?? '-' }}</p>
                                <p class="text-xs text-text-muted">{{ $prescription->prescription_date->format('M d, Y') }} - {{ $prescription->medicines->count() }} medicines</p>
                            </div>
                            @if($prescription->pdf_path)
                                <a href="/uploads/prescriptions/{{ $prescription->pdf_path }}" target="_blank" class="text-primary-600 hover:text-primary-700">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </a>
                            @endif
                        </div>
                    @empty
                        <p class="text-sm text-text-muted">No prescriptions found.</p>
                    @endforelse
                </div>
            </x-card>

            <x-card variant="default">
                <div class="p-6">
                    <x-page-header title="Documents" />
                    @forelse($documents as $document)
                        <div class="flex items-center gap-3 p-3 border border-surface-border rounded-lg mb-2">
                            <div class="w-10 h-10 rounded-lg bg-primary-500/10 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-text-primary">{{ $document->original_name }}</p>
                                <p class="text-xs text-text-muted">{{ $document->document_type_label }} - {{ $document->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-text-muted">No documents uploaded.</p>
                    @endforelse
                </div>
            </x-card>
        </div>
    @endif
</div>
@endsection
