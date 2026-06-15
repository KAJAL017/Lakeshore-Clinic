@extends('layouts.doctor')

@section('title', 'My Consultations - Lakeshore Clinic')
@section('page-title', 'My Consultations')

@section('content')
<div class="space-y-6">
    <x-page-header title="My Consultations">
        <x-slot name="subtitle">Manage your patient consultations</x-slot>
    </x-page-header>

    <x-card variant="default">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-surface-border">
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Patient</th>
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
                                <p class="text-xs text-text-muted">{{ $consultation->appointment->specialization?->name ?? '-' }}</p>
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
                                <button onclick="openConsultation({{ $consultation->id }})" class="px-3 py-1.5 text-sm font-medium text-primary-600 hover:bg-primary-50 rounded-lg transition-colors">
                                    {{ $consultation->status === 'completed' ? 'View' : 'Open' }}
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-12 text-center">
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

<x-modal id="consultation" title="Consultation Notes" size="lg">
    <div id="consultation-content" class="space-y-4"></div>
    <x-slot name="footer">
        <x-button variant="outline" size="sm" data-modal-close>Close</x-button>
        <x-button variant="primary" size="sm" id="save-notes-btn" onclick="saveConsultationNotes()">
            <span id="save-notes-text">Save Notes</span>
            <svg id="save-notes-spinner" class="hidden animate-spin w-4 h-4 ml-1.5" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </x-button>
        <x-button variant="success" size="sm" id="complete-btn" onclick="completeConsultation()">
            Mark Complete
        </x-button>
    </x-slot>
</x-modal>

@push('scripts')
<script>
let currentConsultationId = null;

async function openConsultation(id) {
    currentConsultationId = id;
    try {
        const response = await fetch(`/doctor/consultations/${id}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
        });
        const data = await response.json();

        if (data.success) {
            const c = data.consultation;
            const a = c.appointment;

            document.getElementById('consultation-content').innerHTML = `
                <div class="grid grid-cols-2 gap-4 text-sm mb-4 p-4 bg-surface rounded-lg">
                    <div><span class="text-text-muted">Patient:</span> <span class="text-text-primary font-medium">${a?.patient_name || (a?.patient ? a.patient.first_name + ' ' + a.patient.last_name : '-')}</span></div>
                    <div><span class="text-text-muted">Date:</span> <span class="text-text-primary">${a?.appointment_date ? new Date(a.appointment_date).toLocaleDateString() : '-'}</span></div>
                    <div><span class="text-text-muted">Type:</span> <span class="text-text-primary">${a?.type_label || '-'}</span></div>
                    <div><span class="text-text-muted">Status:</span> <span class="text-text-primary">${c.status_label}</span></div>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-text-primary mb-1">Chief Complaint</label>
                        <textarea id="consult-chief" rows="2" class="w-full px-3 py-2 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 resize-none">${c.chief_complaint || ''}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-text-primary mb-1">Symptoms</label>
                        <textarea id="consult-symptoms" rows="2" class="w-full px-3 py-2 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 resize-none">${c.symptoms || ''}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-text-primary mb-1">Clinical Findings</label>
                        <textarea id="consult-findings" rows="2" class="w-full px-3 py-2 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 resize-none">${c.clinical_findings || ''}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-text-primary mb-1">Diagnosis</label>
                        <textarea id="consult-diagnosis" rows="2" class="w-full px-3 py-2 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 resize-none">${c.diagnosis || ''}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-text-primary mb-1">Doctor Notes</label>
                        <textarea id="consult-notes" rows="3" class="w-full px-3 py-2 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 resize-none">${c.doctor_notes || ''}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-text-primary mb-1">Recommendations</label>
                        <textarea id="consult-recommendations" rows="2" class="w-full px-3 py-2 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 resize-none">${c.recommendations || ''}</textarea>
                    </div>
                </div>
            `;

            document.getElementById('complete-btn').style.display = c.status === 'completed' ? 'none' : '';
            openModal('modal-consultation');
        }
    } catch (error) {
        showToast('Failed to load consultation.', 'error');
    }
}

async function saveConsultationNotes() {
    const btn = document.getElementById('save-notes-btn');
    const btnText = document.getElementById('save-notes-text');
    const btnSpinner = document.getElementById('save-notes-spinner');

    btn.disabled = true;
    btnText.textContent = 'Saving...';
    btnSpinner.classList.remove('hidden');

    try {
        const response = await fetch(`/doctor/consultations/${currentConsultationId}`, {
            method: 'PUT',
            body: JSON.stringify({
                chief_complaint: document.getElementById('consult-chief').value,
                symptoms: document.getElementById('consult-symptoms').value,
                clinical_findings: document.getElementById('consult-findings').value,
                diagnosis: document.getElementById('consult-diagnosis').value,
                doctor_notes: document.getElementById('consult-notes').value,
                recommendations: document.getElementById('consult-recommendations').value,
            }),
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
        });

        const data = await response.json();

        if (data.success) {
            showToast(data.message, 'success');
        } else {
            showToast(data.message || 'Failed to save notes.', 'error');
        }
    } catch (error) {
        showToast('An error occurred.', 'error');
    } finally {
        btn.disabled = false;
        btnText.textContent = 'Save Notes';
        btnSpinner.classList.add('hidden');
    }
}

async function completeConsultation() {
    try {
        const response = await fetch(`/doctor/consultations/${currentConsultationId}/complete`, {
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
        } else {
            showToast(data.message || 'Failed to complete consultation.', 'error');
        }
    } catch (error) {
        showToast('An error occurred.', 'error');
    }
}
</script>
@endpush
@endsection
