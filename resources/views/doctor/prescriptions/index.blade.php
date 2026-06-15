@extends('layouts.doctor')

@section('title', 'My Prescriptions - Lakeshore Clinic')
@section('page-title', 'My Prescriptions')

@section('content')
<div class="space-y-6">
    <x-page-header title="My Prescriptions">
        <x-slot name="subtitle">Manage patient prescriptions</x-slot>
        <x-slot name="actions">
            <x-button variant="primary" size="sm" data-modal-open="modal-create-prescription">
                <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                New Prescription
            </x-button>
        </x-slot>
    </x-page-header>

    <x-card variant="default">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-surface-border">
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Patient</th>
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
                                <p class="text-xs text-text-muted">{{ $prescription->patient?->email ?? '-' }}</p>
                            </td>
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
                                <div class="flex items-center justify-end gap-1">
                                    <button onclick="viewPrescription({{ $prescription->id }})" class="w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center justify-center transition-colors" title="View">
                                        <svg class="w-4 h-4 text-text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </button>
                                    @if($prescription->status === 'draft')
                                        <button onclick="editPrescription({{ $prescription->id }})" class="w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center justify-center transition-colors" title="Edit">
                                            <svg class="w-4 h-4 text-text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </button>
                                        <button onclick="markReady({{ $prescription->id }})" class="w-8 h-8 rounded-lg hover:bg-health-50 flex items-center justify-center transition-colors" title="Mark Ready">
                                            <svg class="w-4 h-4 text-health-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-12 text-center">
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

<x-modal id="create-prescription" title="New Prescription" size="lg">
    <form id="create-prescription-form" class="space-y-4" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-text-primary mb-1.5">Patient ID <span class="text-red-500">*</span></label>
                <input type="number" name="patient_id" required class="w-full px-3 py-2 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-text-primary mb-1.5">Prescription Date <span class="text-red-500">*</span></label>
                <input type="date" name="prescription_date" value="{{ date('Y-m-d') }}" required class="w-full px-3 py-2 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-text-primary mb-1.5">Diagnosis</label>
            <textarea name="diagnosis" rows="2" class="w-full px-3 py-2 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 resize-none"></textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-text-primary mb-2">Medicines</label>
            <div id="medicines-container" class="space-y-3">
                <div class="medicine-row grid grid-cols-2 md:grid-cols-5 gap-3 p-3 bg-surface rounded-lg">
                    <input type="text" name="medicines[0][medicine_name]" placeholder="Medicine name" required class="px-3 py-2 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                    <input type="text" name="medicines[0][dosage]" placeholder="Dosage (e.g., 500mg)" class="px-3 py-2 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                    <input type="text" name="medicines[0][frequency]" placeholder="Frequency" class="px-3 py-2 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                    <input type="text" name="medicines[0][duration]" placeholder="Duration" class="px-3 py-2 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                    <input type="text" name="medicines[0][instructions]" placeholder="Instructions" class="px-3 py-2 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                </div>
            </div>
            <button type="button" onclick="addMedicine()" class="mt-2 text-sm text-primary-600 hover:text-primary-700 font-medium">+ Add Medicine</button>
        </div>

        <div>
            <label class="block text-sm font-medium text-text-primary mb-1.5">General Advice</label>
            <textarea name="general_advice" rows="2" class="w-full px-3 py-2 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 resize-none"></textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-text-primary mb-1.5">Upload PDF (Optional)</label>
            <input type="file" name="pdf" accept=".pdf" class="w-full px-3 py-2 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
        </div>
    </form>

    <x-slot name="footer">
        <x-button variant="outline" size="sm" data-modal-close>Cancel</x-button>
        <x-button variant="primary" size="sm" id="create-prescription-btn" onclick="submitCreatePrescription()">
            <span id="create-prescription-text">Create</span>
            <svg id="create-prescription-spinner" class="hidden animate-spin w-4 h-4 ml-1.5" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </x-button>
    </x-slot>
</x-modal>

<x-modal id="view-prescription" title="Prescription Details" size="lg">
    <div id="prescription-content" class="space-y-4"></div>
</x-modal>

@push('scripts')
<script>
let medicineCount = 1;

function addMedicine() {
    const container = document.getElementById('medicines-container');
    const row = document.createElement('div');
    row.className = 'medicine-row grid grid-cols-2 md:grid-cols-5 gap-3 p-3 bg-surface rounded-lg';
    row.innerHTML = `
        <input type="text" name="medicines[${medicineCount}][medicine_name]" placeholder="Medicine name" required class="px-3 py-2 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
        <input type="text" name="medicines[${medicineCount}][dosage]" placeholder="Dosage" class="px-3 py-2 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
        <input type="text" name="medicines[${medicineCount}][frequency]" placeholder="Frequency" class="px-3 py-2 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
        <input type="text" name="medicines[${medicineCount}][duration]" placeholder="Duration" class="px-3 py-2 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
        <input type="text" name="medicines[${medicineCount}][instructions]" placeholder="Instructions" class="px-3 py-2 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
    `;
    container.appendChild(row);
    medicineCount++;
}

async function submitCreatePrescription() {
    const form = document.getElementById('create-prescription-form');
    const btn = document.getElementById('create-prescription-btn');
    const btnText = document.getElementById('create-prescription-text');
    const btnSpinner = document.getElementById('create-prescription-spinner');

    btn.disabled = true;
    btnText.textContent = 'Creating...';
    btnSpinner.classList.remove('hidden');

    try {
        const formData = new FormData(form);
        const response = await fetch('{{ route("doctor.prescriptions.store") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
        });

        const data = await response.json();

        if (response.ok && data.success) {
            showToast(data.message, 'success');
            setTimeout(() => location.reload(), 1000);
        } else {
            showToast(data.message || 'Failed to create prescription.', 'error');
        }
    } catch (error) {
        showToast('An error occurred. Please try again.', 'error');
    } finally {
        btn.disabled = false;
        btnText.textContent = 'Create';
        btnSpinner.classList.add('hidden');
    }
}

async function viewPrescription(id) {
    try {
        const response = await fetch(`/doctor/prescriptions/${id}`, {
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

async function markReady(id) {
    try {
        const response = await fetch(`/doctor/prescriptions/${id}/ready`, {
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
        });
        const data = await response.json();
        if (data.success) {
            showToast(data.message, 'success');
            setTimeout(() => location.reload(), 1000);
        }
    } catch (error) {
        showToast('An error occurred.', 'error');
    }
}
</script>
@endpush
@endsection
