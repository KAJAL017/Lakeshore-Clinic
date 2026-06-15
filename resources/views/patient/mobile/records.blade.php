@extends('layouts.patient-mobile')

@section('title', 'Medical Records - Lakeshore Clinic')
@section('page-title', 'Records')

@section('content')
<div class="space-y-4">
    {{-- Tab Navigation --}}
    <div class="flex gap-2 overflow-x-auto pb-2 scrollbar-hide" id="record-tabs">
        <button onclick="switchTab('appointments')" class="record-tab active px-4 py-2.5 rounded-xl text-sm font-semibold whitespace-nowrap transition-all duration-200" data-tab="appointments">Appointments</button>
        <button onclick="switchTab('consultations')" class="record-tab px-4 py-2.5 rounded-xl text-sm font-semibold whitespace-nowrap transition-all duration-200" data-tab="consultations">Consultations</button>
        <button onclick="switchTab('prescriptions')" class="record-tab px-4 py-2.5 rounded-xl text-sm font-semibold whitespace-nowrap transition-all duration-200" data-tab="prescriptions">Prescriptions</button>
        <button onclick="switchTab('documents')" class="record-tab px-4 py-2.5 rounded-xl text-sm font-semibold whitespace-nowrap transition-all duration-200" data-tab="documents">Documents</button>
    </div>

    {{-- Appointments --}}
    <div id="tab-appointments" class="tab-content space-y-3">
        @forelse($appointments as $appointment)
            <div class="mobile-card bg-white rounded-xl p-4 shadow-sm border border-surface-border">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-primary-50 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-text-primary">{{ $appointment->doctor?->name ?? '-' }}</p>
                        <p class="text-xs text-text-muted">{{ $appointment->appointment_date->format('M d, Y') }} - {{ ucfirst($appointment->status) }}</p>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-12">
                <p class="text-text-muted">No appointments yet</p>
            </div>
        @endforelse
    </div>

    {{-- Consultations --}}
    <div id="tab-consultations" class="tab-content space-y-3 hidden">
        @forelse($consultations as $consultation)
            <div class="mobile-card bg-white rounded-xl p-4 shadow-sm border border-surface-border">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-health-50 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-health-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-text-primary">{{ $consultation->appointment?->doctor?->name ?? '-' }}</p>
                        <p class="text-xs text-text-muted">{{ $consultation->created_at->format('M d, Y') }} - {{ ucfirst($consultation->status ?? 'completed') }}</p>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-12">
                <p class="text-text-muted">No consultations yet</p>
            </div>
        @endforelse
    </div>

    {{-- Prescriptions --}}
    <div id="tab-prescriptions" class="tab-content space-y-3 hidden">
        @forelse($prescriptions as $prescription)
            <div class="mobile-card bg-white rounded-xl p-4 shadow-sm border border-surface-border">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-text-primary">{{ $prescription->doctor?->name ?? '-' }}</p>
                        <p class="text-xs text-text-muted">{{ $prescription->created_at->format('M d, Y') }} - {{ ucfirst($prescription->status ?? 'ready') }}</p>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-12">
                <p class="text-text-muted">No prescriptions yet</p>
            </div>
        @endforelse
    </div>

    {{-- Documents --}}
    <div id="tab-documents" class="tab-content space-y-3 hidden">
        @forelse($documents as $document)
            <div class="mobile-card bg-white rounded-xl p-4 shadow-sm border border-surface-border">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-text-primary truncate">{{ $document->file_name ?? 'Document' }}</p>
                        <p class="text-xs text-text-muted">{{ $document->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-12">
                <p class="text-text-muted">No documents yet</p>
            </div>
        @endforelse
    </div>
</div>

@push('styles')
<style>
    .scrollbar-hide::-webkit-scrollbar { display: none; }
    .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    .record-tab { background: white; color: #475569; border: 1.5px solid #e2e8f0; }
    .record-tab.active { background: #0d9488; color: white; border-color: #0d9488; box-shadow: 0 2px 8px rgba(13, 148, 136, 0.3); }
</style>
@endpush

@push('scripts')
<script>
function switchTab(tab) {
    document.querySelectorAll('.record-tab').forEach(t => t.classList.remove('active'));
    document.querySelector(`.record-tab[data-tab="${tab}"]`).classList.add('active');

    document.querySelectorAll('.tab-content').forEach(c => c.classList.add('hidden'));
    document.getElementById(`tab-${tab}`).classList.remove('hidden');
}
</script>
@endpush
@endsection
