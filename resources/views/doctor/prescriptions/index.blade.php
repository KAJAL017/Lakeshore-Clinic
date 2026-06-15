@extends('layouts.doctor')

@section('title', 'My Prescriptions - Lakeshore Clinic')
@section('page-title', 'My Prescriptions')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <p class="text-sm text-gray-400">Manage patient prescriptions</p>
        <button onclick="openModal('modal-create-prescription')" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-white rounded-xl transition-colors" style="background: linear-gradient(135deg, #2563eb, #1d4ed8);">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            New Prescription
        </button>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="px-5 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Patient</th>
                        <th class="px-5 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Date</th>
                        <th class="px-5 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Medicines</th>
                        <th class="px-5 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-5 py-4 text-right text-xs font-semibold text-gray-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($prescriptions as $prescription)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full flex-shrink-0 flex items-center justify-center" style="background: linear-gradient(135deg, #fdf4ff, #fae8ff);">
                                        <span class="text-xs font-bold text-purple-600">{{ strtoupper(substr($prescription->patient?->first_name ?? 'P', 0, 1) . substr($prescription->patient?->last_name ?? '', 0, 1)) }}</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">{{ $prescription->patient?->first_name . ' ' . $prescription->patient?->last_name ?? '-' }}</p>
                                        <p class="text-xs text-gray-400">{{ $prescription->patient?->email ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4 text-sm text-gray-600">{{ $prescription->prescription_date->format('M d, Y') }}</td>
                            <td class="px-5 py-4 text-sm text-gray-500">{{ $prescription->medicines->count() }} medicines</td>
                            <td class="px-5 py-4">
                                @php $statusVariant = match($prescription->status) { 'draft' => 'bg-amber-50 text-amber-700', 'ready' => 'bg-blue-50 text-blue-700', 'issued' => 'bg-green-50 text-green-700', default => 'bg-gray-50 text-gray-700' }; @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium {{ $statusVariant }}">{{ $prescription->status_label }}</span>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <button onclick="viewPrescription({{ $prescription->id }})" class="w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center justify-center transition-colors" title="View"><svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg></button>
                                    @if($prescription->status === 'draft')
                                        <button onclick="editPrescription({{ $prescription->id }})" class="w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center justify-center transition-colors" title="Edit"><svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button>
                                        <button onclick="markReady({{ $prescription->id }})" class="w-8 h-8 rounded-lg hover:bg-green-50 flex items-center justify-center transition-colors" title="Mark Ready"><svg class="w-4 h-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7"/></svg></button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-16 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center mb-4"><svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg></div>
                                    <p class="text-sm font-medium text-gray-900">No prescriptions</p>
                                    <p class="text-xs text-gray-400 mt-1">No prescriptions found.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($prescriptions->hasPages())
            <div class="px-5 py-4 border-t border-gray-100">{{ $prescriptions->links() }}</div>
        @endif
    </div>
</div>

<x-modal id="create-prescription" title="New Prescription" size="lg">
    <form id="create-prescription-form" class="space-y-4" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium text-gray-700 mb-1.5">Patient ID <span class="text-red-500">*</span></label><input type="number" name="patient_id" required class="w-full px-3 py-2.5 text-sm bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500"></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1.5">Prescription Date <span class="text-red-500">*</span></label><input type="date" name="prescription_date" value="{{ date('Y-m-d') }}" required class="w-full px-3 py-2.5 text-sm bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500"></div>
        </div>
        <div><label class="block text-sm font-medium text-gray-700 mb-1.5">Diagnosis</label><textarea name="diagnosis" rows="2" class="w-full px-3 py-2.5 text-sm bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 resize-none"></textarea></div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Medicines</label>
            <div id="medicines-container" class="space-y-3">
                <div class="medicine-row grid grid-cols-2 md:grid-cols-5 gap-3 p-3 bg-gray-50 rounded-xl">
                    <input type="text" name="medicines[0][medicine_name]" placeholder="Medicine name" required class="px-3 py-2.5 text-sm bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    <input type="text" name="medicines[0][dosage]" placeholder="Dosage" class="px-3 py-2.5 text-sm bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    <input type="text" name="medicines[0][frequency]" placeholder="Frequency" class="px-3 py-2.5 text-sm bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    <input type="text" name="medicines[0][duration]" placeholder="Duration" class="px-3 py-2.5 text-sm bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    <input type="text" name="medicines[0][instructions]" placeholder="Instructions" class="px-3 py-2.5 text-sm bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                </div>
            </div>
            <button type="button" onclick="addMedicine()" class="mt-2 text-sm text-blue-600 hover:text-blue-700 font-semibold">+ Add Medicine</button>
        </div>
        <div><label class="block text-sm font-medium text-gray-700 mb-1.5">General Advice</label><textarea name="general_advice" rows="2" class="w-full px-3 py-2.5 text-sm bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 resize-none"></textarea></div>
        <div><label class="block text-sm font-medium text-gray-700 mb-1.5">Upload PDF (Optional)</label><input type="file" name="pdf" accept=".pdf" class="w-full px-3 py-2.5 text-sm bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500"></div>
    </form>
    <x-slot name="footer">
        <button onclick="closeModal('modal-create-prescription')" class="px-4 py-2.5 text-sm font-medium text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 transition-colors">Cancel</button>
        <button onclick="submitCreatePrescription()" id="create-prescription-btn" class="px-4 py-2.5 text-sm font-semibold text-white rounded-xl" style="background: linear-gradient(135deg, #2563eb, #1d4ed8);"><span id="create-prescription-text">Create</span><svg id="create-prescription-spinner" class="hidden animate-spin w-4 h-4 ml-1.5 inline-block" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg></button>
    </x-slot>
</x-modal>

<x-modal id="view-prescription" title="Prescription Details" size="lg">
    <div id="prescription-content" class="space-y-4"></div>
</x-modal>

<x-modal id="edit-prescription" title="Edit Prescription" size="lg">
    <form id="edit-prescription-form" class="space-y-4" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="prescription_id" id="edit-prescription-id">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium text-gray-700 mb-1.5">Prescription Date <span class="text-red-500">*</span></label><input type="date" name="prescription_date" id="edit-prescription-date" required class="w-full px-3 py-2.5 text-sm bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500"></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1.5">Status</label><select name="status" id="edit-prescription-status" class="w-full px-3 py-2.5 text-sm bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500"><option value="draft">Draft</option><option value="ready">Ready</option><option value="issued">Issued</option></select></div>
        </div>
        <div><label class="block text-sm font-medium text-gray-700 mb-1.5">Diagnosis</label><textarea name="diagnosis" id="edit-prescription-diagnosis" rows="2" class="w-full px-3 py-2.5 text-sm bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 resize-none"></textarea></div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Medicines</label>
            <div id="edit-medicines-container" class="space-y-3"></div>
            <button type="button" onclick="addEditMedicine()" class="mt-2 text-sm text-blue-600 hover:text-blue-700 font-semibold">+ Add Medicine</button>
        </div>
        <div><label class="block text-sm font-medium text-gray-700 mb-1.5">General Advice</label><textarea name="general_advice" id="edit-prescription-advice" rows="2" class="w-full px-3 py-2.5 text-sm bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 resize-none"></textarea></div>
    </form>
    <x-slot name="footer">
        <button onclick="closeModal('modal-edit-prescription')" class="px-4 py-2.5 text-sm font-medium text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 transition-colors">Cancel</button>
        <button onclick="submitEditPrescription()" id="edit-prescription-btn" class="px-4 py-2.5 text-sm font-semibold text-white rounded-xl" style="background: linear-gradient(135deg, #2563eb, #1d4ed8);"><span id="edit-prescription-text">Update</span><svg id="edit-prescription-spinner" class="hidden animate-spin w-4 h-4 ml-1.5 inline-block" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg></button>
    </x-slot>
</x-modal>

@push('scripts')
<script>
let medicineCount = 1;
let editMedicineCount = 0;
const inputClass = 'px-3 py-2.5 text-sm bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500';

function addMedicine() {
    const container = document.getElementById('medicines-container');
    const row = document.createElement('div');
    row.className = 'medicine-row grid grid-cols-2 md:grid-cols-5 gap-3 p-3 bg-gray-50 rounded-xl';
    row.innerHTML = `
        <input type="text" name="medicines[${medicineCount}][medicine_name]" placeholder="Medicine name" required class="${inputClass}">
        <input type="text" name="medicines[${medicineCount}][dosage]" placeholder="Dosage" class="${inputClass}">
        <input type="text" name="medicines[${medicineCount}][frequency]" placeholder="Frequency" class="${inputClass}">
        <input type="text" name="medicines[${medicineCount}][duration]" placeholder="Duration" class="${inputClass}">
        <input type="text" name="medicines[${medicineCount}][instructions]" placeholder="Instructions" class="${inputClass}">
    `;
    container.appendChild(row);
    medicineCount++;
}

function addEditMedicine(medicine = null) {
    const container = document.getElementById('edit-medicines-container');
    const row = document.createElement('div');
    row.className = 'medicine-row grid grid-cols-2 md:grid-cols-5 gap-3 p-3 bg-gray-50 rounded-xl relative';
    row.innerHTML = `
        <input type="text" name="medicines[${editMedicineCount}][medicine_name]" placeholder="Medicine name" value="${medicine?.medicine_name || ''}" required class="${inputClass}">
        <input type="text" name="medicines[${editMedicineCount}][dosage]" placeholder="Dosage" value="${medicine?.dosage || ''}" class="${inputClass}">
        <input type="text" name="medicines[${editMedicineCount}][frequency]" placeholder="Frequency" value="${medicine?.frequency || ''}" class="${inputClass}">
        <input type="text" name="medicines[${editMedicineCount}][duration]" placeholder="Duration" value="${medicine?.duration || ''}" class="${inputClass}">
        <input type="text" name="medicines[${editMedicineCount}][instructions]" placeholder="Instructions" value="${medicine?.instructions || ''}" class="${inputClass}">
    `;
    container.appendChild(row);
    editMedicineCount++;
}

async function submitCreatePrescription() {
    const form = document.getElementById('create-prescription-form');
    const btn = document.getElementById('create-prescription-btn');
    const btnText = document.getElementById('create-prescription-text');
    const btnSpinner = document.getElementById('create-prescription-spinner');
    btn.disabled = true; btnText.textContent = 'Creating...'; btnSpinner.classList.remove('hidden');
    try {
        const formData = new FormData(form);
        const response = await fetch('{{ route("doctor.prescriptions.store") }}', { method: 'POST', body: formData, headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } });
        const data = await response.json();
        if (response.ok && data.success) { showToast(data.message, 'success'); setTimeout(() => location.reload(), 1000); } else { showToast(data.message || 'Failed to create prescription.', 'error'); }
    } catch (error) { showToast('An error occurred. Please try again.', 'error'); } finally { btn.disabled = false; btnText.textContent = 'Create'; btnSpinner.classList.add('hidden'); }
}

async function viewPrescription(id) {
    try {
        const response = await fetch(`/doctor/prescriptions/${id}`, { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } });
        const data = await response.json();
        if (data.success) {
            const p = data.prescription;
            const statusColors = { draft: 'bg-amber-50 text-amber-700', ready: 'bg-blue-50 text-blue-700', issued: 'bg-green-50 text-green-700' };
            let medicinesHtml = '';
            if (p.medicines && p.medicines.length > 0) {
                medicinesHtml = p.medicines.map(m => `<div class="p-3 bg-gray-50 rounded-xl"><p class="text-sm font-medium text-gray-900">${m.medicine_name}</p><p class="text-xs text-gray-400">${m.dosage || ''} ${m.frequency || ''} ${m.duration || ''}</p>${m.instructions ? `<p class="text-xs text-gray-400 mt-1">${m.instructions}</p>` : ''}</div>`).join('');
            }
            document.getElementById('prescription-content').innerHTML = `
                <div class="space-y-4 text-sm">
                    <div><span class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium ${statusColors[p.status] || 'bg-gray-50 text-gray-700'}">${p.status_label}</span></div>
                    <div class="grid grid-cols-2 gap-4">
                        <div><p class="text-gray-400 mb-1">Patient</p><p class="text-gray-900 font-medium">${p.patient ? p.patient.first_name + ' ' + p.patient.last_name : '-'}</p></div>
                        <div><p class="text-gray-400 mb-1">Doctor</p><p class="text-gray-900">${p.doctor?.name || '-'}</p></div>
                        <div><p class="text-gray-400 mb-1">Date</p><p class="text-gray-900">${new Date(p.prescription_date).toLocaleDateString()}</p></div>
                    </div>
                    ${p.diagnosis ? `<div><p class="text-gray-400 mb-1">Diagnosis</p><p class="text-gray-900">${p.diagnosis}</p></div>` : ''}
                    ${medicinesHtml ? `<div><p class="text-gray-400 mb-2">Medicines</p><div class="space-y-2">${medicinesHtml}</div></div>` : ''}
                    ${p.general_advice ? `<div><p class="text-gray-400 mb-1">General Advice</p><p class="text-gray-900">${p.general_advice}</p></div>` : ''}
                    ${p.pdf_path ? `<div><a href="/uploads/prescriptions/${p.pdf_path}" target="_blank" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg> Download PDF</a></div>` : ''}
                </div>
            `;
            openModal('modal-view-prescription');
        }
    } catch (error) { showToast('Failed to load prescription.', 'error'); }
}

async function markReady(id) {
    try {
        const response = await fetch(`/doctor/prescriptions/${id}/ready`, { method: 'PUT', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } });
        const data = await response.json();
        if (data.success) { showToast(data.message, 'success'); setTimeout(() => location.reload(), 1000); }
    } catch (error) { showToast('An error occurred.', 'error'); }
}

async function editPrescription(id) {
    try {
        const response = await fetch(`/doctor/prescriptions/${id}`, { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } });
        const data = await response.json();
        if (data.success) {
            const p = data.prescription;
            document.getElementById('edit-prescription-id').value = p.id;
            document.getElementById('edit-prescription-date').value = p.prescription_date;
            document.getElementById('edit-prescription-status').value = p.status;
            document.getElementById('edit-prescription-diagnosis').value = p.diagnosis || '';
            document.getElementById('edit-prescription-advice').value = p.general_advice || '';
            const container = document.getElementById('edit-medicines-container');
            container.innerHTML = '';
            editMedicineCount = 0;
            if (p.medicines && p.medicines.length > 0) { p.medicines.forEach(m => addEditMedicine(m)); } else { addEditMedicine(); }
            openModal('modal-edit-prescription');
        }
    } catch (error) { showToast('Failed to load prescription.', 'error'); }
}

async function submitEditPrescription() {
    const id = document.getElementById('edit-prescription-id').value;
    const form = document.getElementById('edit-prescription-form');
    const btn = document.getElementById('edit-prescription-btn');
    const btnText = document.getElementById('edit-prescription-text');
    const btnSpinner = document.getElementById('edit-prescription-spinner');
    btn.disabled = true; btnText.textContent = 'Updating...'; btnSpinner.classList.remove('hidden');
    try {
        const formData = new FormData(form);
        const response = await fetch(`/doctor/prescriptions/${id}`, { method: 'POST', body: formData, headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } });
        const data = await response.json();
        if (response.ok && data.success) { showToast(data.message, 'success'); closeModal('modal-edit-prescription'); setTimeout(() => location.reload(), 1000); } else { showToast(data.message || 'Failed to update prescription.', 'error'); }
    } catch (error) { showToast('An error occurred. Please try again.', 'error'); } finally { btn.disabled = false; btnText.textContent = 'Update'; btnSpinner.classList.add('hidden'); }
}
</script>
@endpush
@endsection
