@extends('layouts.doctor')

@section('title', 'My Consultations - Lakeshore Clinic')
@section('page-title', 'My Consultations')

@section('content')
<div class="space-y-6">
    <p class="text-sm text-gray-400">Manage your patient consultations and clinical notes</p>

    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="px-5 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Patient</th>
                        <th class="px-5 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Type</th>
                        <th class="px-5 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Date</th>
                        <th class="px-5 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-5 py-4 text-right text-xs font-semibold text-gray-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($consultations as $consultation)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full flex-shrink-0 flex items-center justify-center" style="background: linear-gradient(135deg, #f0fdf4, #dcfce7);">
                                        <span class="text-xs font-bold text-green-600">{{ strtoupper(substr($consultation->appointment->patient?->first_name ?? 'P', 0, 1) . substr($consultation->appointment->patient?->last_name ?? '', 0, 1)) }}</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">{{ $consultation->appointment->patient_name ?? ($consultation->appointment->patient?->first_name . ' ' . $consultation->appointment->patient?->last_name ?? '-') }}</p>
                                        <p class="text-xs text-gray-400">{{ $consultation->appointment->specialization?->name ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium {{ $consultation->appointment->type === 'clinic' ? 'bg-blue-50 text-blue-700' : 'bg-purple-50 text-purple-700' }}">
                                    {{ $consultation->appointment->type === 'clinic' ? 'Clinic Visit' : 'Telemedicine' }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-sm text-gray-600">{{ $consultation->appointment->appointment_date->format('M d, Y') }}</td>
                            <td class="px-5 py-4">
                                @php $statusVariant = match($consultation->status) { 'pending' => 'bg-amber-50 text-amber-700', 'in_consultation' => 'bg-blue-50 text-blue-700', 'completed' => 'bg-green-50 text-green-700', default => 'bg-gray-50 text-gray-700' }; @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium {{ $statusVariant }}">{{ $consultation->status_label }}</span>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <button onclick="openConsultation({{ $consultation->id }})" class="px-3 py-1.5 text-sm font-medium text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                    {{ $consultation->status === 'completed' ? 'View' : 'Open' }}
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-16 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center mb-4"><svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></div>
                                    <p class="text-sm font-medium text-gray-900">No consultations</p>
                                    <p class="text-xs text-gray-400 mt-1">No consultations found.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($consultations->hasPages())
            <div class="px-5 py-4 border-t border-gray-100">{{ $consultations->links() }}</div>
        @endif
    </div>
</div>

<x-modal id="consultation" title="Consultation Notes" size="lg">
    <div id="consultation-content" class="space-y-4"></div>
    <x-slot name="footer">
        <button onclick="closeModal('modal-consultation')" class="px-4 py-2.5 text-sm font-medium text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 transition-colors">Close</button>
        <button onclick="saveConsultationNotes()" id="save-notes-btn" class="px-4 py-2.5 text-sm font-semibold text-white rounded-xl" style="background: linear-gradient(135deg, #2563eb, #1d4ed8);">
            <span id="save-notes-text">Save Notes</span>
            <svg id="save-notes-spinner" class="hidden animate-spin w-4 h-4 ml-1.5 inline-block" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
        </button>
        <button onclick="completeConsultation()" id="complete-btn" class="px-4 py-2.5 text-sm font-semibold text-white bg-green-600 rounded-xl hover:bg-green-700 transition-colors">Mark Complete</button>
    </x-slot>
</x-modal>

@push('scripts')
<script>
let currentConsultationId = null;

async function openConsultation(id) {
    currentConsultationId = id;
    try {
        const response = await fetch(`/doctor/consultations/${id}`, { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } });
        const data = await response.json();
        if (data.success) {
            const c = data.consultation;
            const a = c.appointment;
            const inputClass = 'w-full px-3 py-2.5 text-sm bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 resize-none';
            document.getElementById('consultation-content').innerHTML = `
                <div class="grid grid-cols-2 gap-4 text-sm mb-4 p-4 bg-gray-50 rounded-2xl">
                    <div><span class="text-gray-400">Patient:</span> <span class="text-gray-900 font-medium">${a?.patient_name || (a?.patient ? a.patient.first_name + ' ' + a.patient.last_name : '-')}</span></div>
                    <div><span class="text-gray-400">Date:</span> <span class="text-gray-900">${a?.appointment_date ? new Date(a.appointment_date).toLocaleDateString() : '-'}</span></div>
                    <div><span class="text-gray-400">Type:</span> <span class="text-gray-900">${a?.type_label || '-'}</span></div>
                    <div><span class="text-gray-400">Status:</span> <span class="text-gray-900">${c.status_label}</span></div>
                </div>
                <div class="space-y-4">
                    <div><label class="block text-sm font-medium text-gray-700 mb-1.5">Chief Complaint</label><textarea id="consult-chief" rows="2" class="${inputClass}">${c.chief_complaint || ''}</textarea></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1.5">Symptoms</label><textarea id="consult-symptoms" rows="2" class="${inputClass}">${c.symptoms || ''}</textarea></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1.5">Clinical Findings</label><textarea id="consult-findings" rows="2" class="${inputClass}">${c.clinical_findings || ''}</textarea></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1.5">Diagnosis</label><textarea id="consult-diagnosis" rows="2" class="${inputClass}">${c.diagnosis || ''}</textarea></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1.5">Doctor Notes</label><textarea id="consult-notes" rows="3" class="${inputClass}">${c.doctor_notes || ''}</textarea></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1.5">Recommendations</label><textarea id="consult-recommendations" rows="2" class="${inputClass}">${c.recommendations || ''}</textarea></div>
                </div>
            `;
            document.getElementById('complete-btn').style.display = c.status === 'completed' ? 'none' : '';
            openModal('modal-consultation');
        }
    } catch (error) { showToast('Failed to load consultation.', 'error'); }
}

async function saveConsultationNotes() {
    const btn = document.getElementById('save-notes-btn');
    const btnText = document.getElementById('save-notes-text');
    const btnSpinner = document.getElementById('save-notes-spinner');
    btn.disabled = true; btnText.textContent = 'Saving...'; btnSpinner.classList.remove('hidden');
    try {
        const response = await fetch(`/doctor/consultations/${currentConsultationId}`, {
            method: 'PUT',
            body: JSON.stringify({ chief_complaint: document.getElementById('consult-chief').value, symptoms: document.getElementById('consult-symptoms').value, clinical_findings: document.getElementById('consult-findings').value, diagnosis: document.getElementById('consult-diagnosis').value, doctor_notes: document.getElementById('consult-notes').value, recommendations: document.getElementById('consult-recommendations').value }),
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json', 'Content-Type': 'application/json' },
        });
        const data = await response.json();
        if (data.success) { showToast(data.message, 'success'); } else { showToast(data.message || 'Failed to save notes.', 'error'); }
    } catch (error) { showToast('An error occurred.', 'error'); } finally { btn.disabled = false; btnText.textContent = 'Save Notes'; btnSpinner.classList.add('hidden'); }
}

async function completeConsultation() {
    try {
        const response = await fetch(`/doctor/consultations/${currentConsultationId}/complete`, { method: 'PUT', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } });
        const data = await response.json();
        if (data.success) { showToast(data.message, 'success'); setTimeout(() => location.reload(), 1000); } else { showToast(data.message || 'Failed to complete consultation.', 'error'); }
    } catch (error) { showToast('An error occurred.', 'error'); }
}
</script>
@endpush
@endsection
