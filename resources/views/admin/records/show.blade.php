@extends('layouts.app')

@section('title', 'Patient Record - Lakeshore Clinic')
@section('page-title', 'Patient Record')

@section('content')
<div class="space-y-6">
    <x-page-header title="{{ $patient->first_name }} {{ $patient->last_name }}">
        <x-slot name="subtitle">Patient medical record</x-slot>
        <x-slot name="actions">
            <x-button variant="outline" size="sm" href="{{ route('admin.patients') }}">
                <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back
            </x-button>
        </x-slot>
    </x-page-header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <x-card variant="default" class="lg:col-span-1">
            <div class="p-6 text-center">
                <div class="w-20 h-20 rounded-full bg-primary-500/20 flex items-center justify-center mx-auto mb-4">
                    @if($patient->photo)
                        <img src="{{ asset('uploads/patients/' . $patient->photo) }}" alt="" class="w-full h-full object-cover rounded-full">
                    @else
                        <span class="text-2xl font-bold text-primary-600">{{ strtoupper(substr($patient->first_name, 0, 1) . substr($patient->last_name, 0, 1)) }}</span>
                    @endif
                </div>
                <h3 class="text-lg font-semibold text-text-primary">{{ $patient->first_name }} {{ $patient->last_name }}</h3>
                <p class="text-sm text-text-muted">{{ $patient->email }}</p>
                <div class="mt-4 pt-4 border-t border-surface-border space-y-2 text-sm">
                    <div class="flex justify-between"><span class="text-text-muted">Phone</span><span class="text-text-primary">{{ $patient->phone ?? '-' }}</span></div>
                    <div class="flex justify-between"><span class="text-text-muted">Gender</span><span class="text-text-primary capitalize">{{ $patient->gender ?? '-' }}</span></div>
                    <div class="flex justify-between"><span class="text-text-muted">DOB</span><span class="text-text-primary">{{ $patient->date_of_birth?->format('M d, Y') ?? '-' }}</span></div>
                    <div class="flex justify-between"><span class="text-text-muted">Status</span><x-status-badge :variant="$patient->status" :label="ucfirst($patient->status)" /></div>
                </div>
            </div>
        </x-card>

        <div class="lg:col-span-2 space-y-6">
            <x-card variant="default">
                <div class="p-6">
                    <x-page-header title="Appointments" />
                    @forelse($patient->appointments->take(5) as $appointment)
                        <div class="flex items-center gap-3 p-3 border border-surface-border rounded-lg mb-2">
                            <x-badge variant="{{ $appointment->type === 'clinic' ? 'primary' : 'info' }}">{{ $appointment->type_label }}</x-badge>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-text-primary">{{ $appointment->doctor?->name ?? '-' }}</p>
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
                    @forelse($consultations->take(5) as $consultation)
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
                    @forelse($prescriptions->take(5) as $prescription)
                        <div class="flex items-center gap-3 p-3 border border-surface-border rounded-lg mb-2">
                            <x-status-badge :variant="$prescription->status === 'issued' ? 'success' : 'warning'" :label="$prescription->status_label" />
                            <div class="flex-1">
                                <p class="text-sm font-medium text-text-primary">{{ $prescription->doctor?->name ?? '-' }}</p>
                                <p class="text-xs text-text-muted">{{ $prescription->prescription_date->format('M d, Y') }} - {{ $prescription->medicines->count() }} medicines</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-text-muted">No prescriptions found.</p>
                    @endforelse
                </div>
            </x-card>

            <x-card variant="default">
                <div class="p-6">
                    <x-page-header title="Medical Documents" />
                    @forelse($documents->take(5) as $document)
                        <div class="flex items-center gap-3 p-3 border border-surface-border rounded-lg mb-2">
                            <div class="w-10 h-10 rounded-lg bg-primary-500/10 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-text-primary">{{ $document->original_name }}</p>
                                <p class="text-xs text-text-muted">{{ $document->document_type_label }} - {{ $document->created_at->format('M d, Y') }}</p>
                            </div>
                            <a href="{{ route('admin.records.download', $document->id) }}" class="text-primary-600 hover:text-primary-700">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </a>
                        </div>
                    @empty
                        <p class="text-sm text-text-muted">No documents uploaded.</p>
                    @endforelse
                </div>
            </x-card>
        </div>
    </div>
</div>
@endsection
