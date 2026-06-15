@extends('layouts.app')

@section('title', 'Prescriptions - Lakeshore Clinic')
@section('page-title', 'Prescription Management')

@section('content')
<div class="space-y-6">
    <x-page-header title="Prescription Management">
        <x-slot name="subtitle">View patient prescriptions</x-slot>
    </x-page-header>

    <x-card variant="default" class="p-4">
        <form method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <x-search-box name="search" placeholder="Search by patient, doctor..." value="{{ request('search') }}" />
            </div>
            <div class="flex gap-2">
                <select name="status" class="px-3 py-2 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                    <option value="">All Status</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="ready" {{ request('status') === 'ready' ? 'selected' : '' }}>Ready</option>
                    <option value="issued" {{ request('status') === 'issued' ? 'selected' : '' }}>Issued</option>
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
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Date</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Medicines</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Status</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-text-muted uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-border">
                    @forelse($prescriptions as $prescription)
                        <tr class="hover:bg-surface transition-colors">
                            <td class="px-4 py-3">
                                <p class="text-sm font-medium text-text-primary">{{ $prescription->patient?->first_name . ' ' . $prescription->patient?->last_name ?? '-' }}</p>
                            </td>
                            <td class="px-4 py-3 text-sm text-text-primary">{{ $prescription->doctor?->name ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm text-text-primary">{{ $prescription->prescription_date->format('M d, Y') }}</td>
                            <td class="px-4 py-3 text-sm text-text-muted">{{ $prescription->medicines->count() }} medicines</td>
                            <td class="px-4 py-3">
                                @php
                                    $statusVariant = match($prescription->status) {
                                        'draft' => 'warning', 'ready' => 'info', 'issued' => 'success', default => 'default',
                                    };
                                @endphp
                                <x-status-badge :variant="$statusVariant" :label="$prescription->status_label" />
                            </td>
                            <td class="px-4 py-3 text-right">
                                <button onclick="viewPrescription({{ $prescription->id }})" class="w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center justify-center transition-colors" title="View">
                                    <svg class="w-4 h-4 text-text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center">
                                <x-empty-state message="No prescriptions found." />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($prescriptions->hasPages())
            <div class="px-4 py-3 border-t border-surface-border">
                {{ $prescriptions->links() }}
            </div>
        @endif
    </x-card>
</div>

<x-modal id="view-prescription" title="Prescription Details" size="lg">
    <div id="prescription-content" class="space-y-4"></div>
</x-modal>

@push('scripts')
<script>
async function viewPrescription(id) {
    try {
        const response = await fetch(`/admin/prescriptions/${id}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
        });
        const data = await response.json();

        if (data.success) {
            const p = data.prescription;
            const statusColors = { draft: 'bg-amber-100 text-amber-800', ready: 'bg-blue-100 text-blue-800', issued: 'bg-health-100 text-health-800' };

            let medicinesHtml = '';
            if (p.medicines && p.medicines.length > 0) {
                medicinesHtml = p.medicines.map(m => `
                    <div class="p-3 bg-surface rounded-lg">
                        <p class="text-sm font-medium text-text-primary">${m.medicine_name}</p>
                        <p class="text-xs text-text-muted">${m.dosage || ''} ${m.frequency || ''} ${m.duration || ''}</p>
                        ${m.instructions ? `<p class="text-xs text-text-muted mt-1">${m.instructions}</p>` : ''}
                    </div>
                `).join('');
            }

            document.getElementById('prescription-content').innerHTML = `
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div class="col-span-2"><span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium ${statusColors[p.status] || 'bg-gray-100 text-gray-800'}">${p.status_label}</span></div>
                    <div><p class="text-text-muted mb-1">Patient</p><p class="text-text-primary font-medium">${p.patient ? p.patient.first_name + ' ' + p.patient.last_name : '-'}</p></div>
                    <div><p class="text-text-muted mb-1">Doctor</p><p class="text-text-primary">${p.doctor?.name || '-'}</p></div>
                    <div><p class="text-text-muted mb-1">Date</p><p class="text-text-primary">${new Date(p.prescription_date).toLocaleDateString()}</p></div>
                    ${p.diagnosis ? `<div class="col-span-2"><p class="text-text-muted mb-1">Diagnosis</p><p class="text-text-primary">${p.diagnosis}</p></div>` : ''}
                    ${medicinesHtml ? `<div class="col-span-2"><p class="text-text-muted mb-2">Medicines</p><div class="space-y-2">${medicinesHtml}</div></div>` : ''}
                    ${p.general_advice ? `<div class="col-span-2"><p class="text-text-muted mb-1">General Advice</p><p class="text-text-primary">${p.general_advice}</p></div>` : ''}
                    ${p.pdf_path ? `<div class="col-span-2"><a href="/uploads/prescriptions/${p.pdf_path}" target="_blank" class="inline-flex items-center gap-2 text-primary-600 hover:text-primary-700"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg> Download PDF</a></div>` : ''}
                </div>
            `;
            openModal('modal-view-prescription');
        }
    } catch (error) {
        showToast('Failed to load prescription.', 'error');
    }
}
</script>
@endpush
@endsection
