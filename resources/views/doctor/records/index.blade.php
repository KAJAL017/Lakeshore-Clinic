@extends('layouts.doctor')

@section('title', 'Patient Records - Lakeshore Clinic')
@section('page-title', 'Patient Records')

@section('content')
<div class="space-y-6">
    <x-page-header title="Patient Records">
        <x-slot name="subtitle">View records of your patients</x-slot>
    </x-page-header>

    <x-card variant="default">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-surface-border">
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Patient</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Email</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Appointments</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-text-muted uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-border">
                    @forelse($patients as $patient)
                        <tr class="hover:bg-surface transition-colors">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-primary-500/20 flex items-center justify-center overflow-hidden flex-shrink-0">
                                        @if($patient->photo)
                                            <img src="{{ asset('uploads/patients/' . $patient->photo) }}" alt="" class="w-full h-full object-cover">
                                        @else
                                            <span class="text-sm font-medium text-primary-600">{{ strtoupper(substr($patient->first_name, 0, 1) . substr($patient->last_name, 0, 1)) }}</span>
                                        @endif
                                    </div>
                                    <p class="text-sm font-medium text-text-primary">{{ $patient->first_name }} {{ $patient->last_name }}</p>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-sm text-text-muted">{{ $patient->email }}</td>
                            <td class="px-4 py-3 text-sm text-text-muted">{{ $patient->appointments_count }}</td>
                            <td class="px-4 py-3 text-right">
                                <button onclick="viewPatientRecords({{ $patient->id }})" class="px-3 py-1.5 text-sm font-medium text-primary-600 hover:bg-primary-50 rounded-lg transition-colors">
                                    View Records
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-12 text-center">
                                <x-empty-state message="No patients found." />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($patients->hasPages())
            <div class="px-4 py-3 border-t border-surface-border">
                {{ $patients->links() }}
            </div>
        @endif
    </x-card>
</div>

<x-modal id="patient-records" title="Patient Records" size="lg">
    <div id="records-content" class="space-y-4"></div>
</x-modal>

@push('scripts')
<script>
async function viewPatientRecords(id) {
    try {
        const response = await fetch(`/doctor/records/${id}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
        });
        const data = await response.json();

        if (data.success) {
            const p = data.patient;
            let html = `
                <div class="grid grid-cols-2 gap-4 text-sm mb-4 p-4 bg-surface rounded-lg">
                    <div><p class="text-text-muted">Name:</p><p class="text-text-primary font-medium">${p.first_name} ${p.last_name}</p></div>
                    <div><p class="text-text-muted">Email:</p><p class="text-text-primary">${p.email}</p></div>
                </div>
            `;

            if (data.appointments.length > 0) {
                html += '<h4 class="text-sm font-semibold text-text-primary mt-4 mb-2">Appointments</h4>';
                data.appointments.forEach(a => {
                    html += `<div class="p-3 border border-surface-border rounded-lg mb-2 text-sm"><p class="font-medium">${a.doctor?.name || '-'} - ${new Date(a.appointment_date).toLocaleDateString()}</p></div>`;
                });
            }

            if (data.prescriptions.length > 0) {
                html += '<h4 class="text-sm font-semibold text-text-primary mt-4 mb-2">Prescriptions</h4>';
                data.prescriptions.forEach(p => {
                    html += `<div class="p-3 border border-surface-border rounded-lg mb-2 text-sm"><p class="font-medium">${p.doctor?.name || '-'} - ${new Date(p.prescription_date).toLocaleDateString()}</p></div>`;
                });
            }

            if (data.documents.length > 0) {
                html += '<h4 class="text-sm font-semibold text-text-primary mt-4 mb-2">Documents</h4>';
                data.documents.forEach(d => {
                    html += `<div class="p-3 border border-surface-border rounded-lg mb-2 text-sm"><p class="font-medium">${d.original_name}</p><p class="text-text-muted">${d.document_type_label}</p></div>`;
                });
            }

            document.getElementById('records-content').innerHTML = html;
            openModal('modal-patient-records');
        }
    } catch (error) {
        showToast('Failed to load records.', 'error');
    }
}
</script>
@endpush
@endsection
