@extends('layouts.doctor')

@section('title', 'Patient Records - Lakeshore Clinic')
@section('page-title', 'Patient Records')

@section('content')
<div class="space-y-6">
    <p class="text-sm text-gray-400">View records of your patients</p>

    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="px-5 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Patient</th>
                        <th class="px-5 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Email</th>
                        <th class="px-5 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Appointments</th>
                        <th class="px-5 py-4 text-right text-xs font-semibold text-gray-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($patients as $patient)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full flex-shrink-0 flex items-center justify-center overflow-hidden" style="background: linear-gradient(135deg, #eff6ff, #dbeafe);">
                                        @if($patient->photo)
                                            <img src="{{ asset('uploads/patients/' . $patient->photo) }}" alt="" class="w-full h-full object-cover">
                                        @else
                                            <span class="text-xs font-bold text-blue-600">{{ strtoupper(substr($patient->first_name, 0, 1) . substr($patient->last_name, 0, 1)) }}</span>
                                        @endif
                                    </div>
                                    <p class="text-sm font-semibold text-gray-900">{{ $patient->first_name }} {{ $patient->last_name }}</p>
                                </div>
                            </td>
                            <td class="px-5 py-4 text-sm text-gray-500">{{ $patient->email }}</td>
                            <td class="px-5 py-4 text-sm text-gray-500">{{ $patient->appointments_count }}</td>
                            <td class="px-5 py-4 text-right">
                                <button onclick="viewPatientRecords({{ $patient->id }})" class="px-3 py-1.5 text-sm font-medium text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">View Records</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-16 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center mb-4"><svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></div>
                                    <p class="text-sm font-medium text-gray-900">No patients</p>
                                    <p class="text-xs text-gray-400 mt-1">No patients found.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($patients->hasPages())
            <div class="px-5 py-4 border-t border-gray-100">{{ $patients->links() }}</div>
        @endif
    </div>
</div>

<x-modal id="patient-records" title="Patient Records" size="lg">
    <div id="records-content" class="space-y-4"></div>
</x-modal>

@push('scripts')
<script>
async function viewPatientRecords(id) {
    try {
        const response = await fetch(`/doctor/records/${id}`, { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } });
        const data = await response.json();
        if (data.success) {
            const p = data.patient;
            let html = `<div class="grid grid-cols-2 gap-4 text-sm mb-4 p-4 bg-gray-50 rounded-2xl"><div><p class="text-gray-400">Name:</p><p class="text-gray-900 font-medium">${p.first_name} ${p.last_name}</p></div><div><p class="text-gray-400">Email:</p><p class="text-gray-900">${p.email}</p></div></div>`;
            if (data.appointments.length > 0) { html += '<h4 class="text-sm font-bold text-gray-900 mt-4 mb-2">Appointments</h4>'; data.appointments.forEach(a => { html += `<div class="p-3 border border-gray-100 rounded-xl mb-2 text-sm"><p class="font-medium text-gray-900">${a.doctor?.name || '-'} - ${new Date(a.appointment_date).toLocaleDateString()}</p></div>`; }); }
            if (data.prescriptions.length > 0) { html += '<h4 class="text-sm font-bold text-gray-900 mt-4 mb-2">Prescriptions</h4>'; data.prescriptions.forEach(p => { html += `<div class="p-3 border border-gray-100 rounded-xl mb-2 text-sm"><p class="font-medium text-gray-900">${p.doctor?.name || '-'} - ${new Date(p.prescription_date).toLocaleDateString()}</p></div>`; }); }
            if (data.documents.length > 0) { html += '<h4 class="text-sm font-bold text-gray-900 mt-4 mb-2">Documents</h4>'; data.documents.forEach(d => { html += `<div class="p-3 border border-gray-100 rounded-xl mb-2 text-sm"><p class="font-medium text-gray-900">${d.original_name}</p><p class="text-gray-400">${d.document_type_label}</p></div>`; }); }
            document.getElementById('records-content').innerHTML = html;
            openModal('modal-patient-records');
        }
    } catch (error) { showToast('Failed to load records.', 'error'); }
}
</script>
@endpush
@endsection
