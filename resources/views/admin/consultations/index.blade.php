@extends('layouts.app')

@section('title', 'Consultations - Lakeshore Clinic')
@section('page-title', 'Consultation Management')

@section('content')
<div class="space-y-6">
    <x-page-header title="Consultation Management">
        <x-slot name="subtitle">View patient consultations</x-slot>
    </x-page-header>

    <x-card variant="default" class="p-4">
        <form method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <x-search-box name="search" placeholder="Search by patient, doctor..." value="{{ request('search') }}" />
            </div>
            <div class="flex gap-2">
                <select name="status" class="px-3 py-2 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="in_consultation" {{ request('status') === 'in_consultation' ? 'selected' : '' }}>In Consultation</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
                <x-button variant="primary" size="sm" type="submit">Filter</x-button>
            </div>
        </form>
    </x-card>

    <x-card variant="default">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-surface-border">
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Patient</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Doctor</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Type</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Date</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Status</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-text-muted uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-border">
                    @forelse($consultations as $consultation)
                        <tr class="hover:bg-surface transition-colors">
                            <td class="px-4 py-3">
                                <p class="text-sm font-medium text-text-primary">{{ $consultation->appointment->patient_name ?? ($consultation->appointment->patient?->first_name . ' ' . $consultation->appointment->patient?->last_name ?? '-') }}</p>
                            </td>
                            <td class="px-4 py-3">
                                <p class="text-sm font-medium text-text-primary">{{ $consultation->appointment->doctor?->name ?? '-' }}</p>
                            </td>
                            <td class="px-4 py-3">
                                <x-badge variant="{{ $consultation->appointment->type === 'clinic' ? 'primary' : 'info' }}">{{ $consultation->appointment->type_label }}</x-badge>
                            </td>
                            <td class="px-4 py-3 text-sm text-text-primary">{{ $consultation->appointment->appointment_date->format('M d, Y') }}</td>
                            <td class="px-4 py-3">
                                @php
                                    $statusVariant = match($consultation->status) {
                                        'pending' => 'warning', 'in_consultation' => 'info', 'completed' => 'success', default => 'default',
                                    };
                                @endphp
                                <x-status-badge :variant="$statusVariant" :label="$consultation->status_label" />
                            </td>
                            <td class="px-4 py-3 text-right">
                                <button onclick="viewConsultation({{ $consultation->id }})" class="w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center justify-center transition-colors" title="View">
                                    <svg class="w-4 h-4 text-text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center">
                                <x-empty-state message="No consultations found." />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($consultations->hasPages())
            <div class="px-4 py-3 border-t border-surface-border">
                {{ $consultations->links() }}
            </div>
        @endif
    </x-card>
</div>

<x-modal id="view-consultation" title="Consultation Details" size="lg">
    <div id="consultation-content" class="space-y-4"></div>
</x-modal>

@push('scripts')
<script>
async function viewConsultation(id) {
    try {
        const response = await fetch(`/admin/consultations/${id}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
        });
        const data = await response.json();

        if (data.success) {
            const c = data.consultation;
            const a = c.appointment;
            const statusColors = {
                pending: 'bg-amber-100 text-amber-800', in_consultation: 'bg-blue-100 text-blue-800',
                completed: 'bg-health-100 text-health-800',
            };

            document.getElementById('consultation-content').innerHTML = `
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div class="col-span-2"><span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium ${statusColors[c.status] || 'bg-gray-100 text-gray-800'}">${c.status_label}</span></div>
                    <div><p class="text-text-muted mb-1">Patient</p><p class="text-text-primary font-medium">${a?.patient_name || (a?.patient ? a.patient.first_name + ' ' + a.patient.last_name : '-')}</p></div>
                    <div><p class="text-text-muted mb-1">Doctor</p><p class="text-text-primary">${a?.doctor?.name || '-'}</p></div>
                    <div><p class="text-text-muted mb-1">Type</p><p class="text-text-primary">${a?.type_label || '-'}</p></div>
                    <div><p class="text-text-muted mb-1">Date</p><p class="text-text-primary">${a?.appointment_date ? new Date(a.appointment_date).toLocaleDateString() : '-'}</p></div>
                    ${c.chief_complaint ? `<div class="col-span-2"><p class="text-text-muted mb-1">Chief Complaint</p><p class="text-text-primary">${c.chief_complaint}</p></div>` : ''}
                    ${c.symptoms ? `<div class="col-span-2"><p class="text-text-muted mb-1">Symptoms</p><p class="text-text-primary">${c.symptoms}</p></div>` : ''}
                    ${c.clinical_findings ? `<div class="col-span-2"><p class="text-text-muted mb-1">Clinical Findings</p><p class="text-text-primary">${c.clinical_findings}</p></div>` : ''}
                    ${c.diagnosis ? `<div class="col-span-2"><p class="text-text-muted mb-1">Diagnosis</p><p class="text-text-primary">${c.diagnosis}</p></div>` : ''}
                    ${c.doctor_notes ? `<div class="col-span-2"><p class="text-text-muted mb-1">Doctor Notes</p><p class="text-text-primary whitespace-pre-line">${c.doctor_notes}</p></div>` : ''}
                    ${c.recommendations ? `<div class="col-span-2"><p class="text-text-muted mb-1">Recommendations</p><p class="text-text-primary">${c.recommendations}</p></div>` : ''}
                </div>
            `;
            openModal('modal-view-consultation');
        }
    } catch (error) {
        showToast('Failed to load consultation.', 'error');
    }
}
</script>
@endpush
@endsection
