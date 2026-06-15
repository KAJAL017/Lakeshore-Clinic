@extends('layouts.doctor')

@section('title', 'My Appointments - Lakeshore Clinic')
@section('page-title', 'My Appointments')

@section('content')
<div class="space-y-6">
    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <p class="text-sm text-gray-400">View and manage your assigned appointments</p>
        </div>
    </div>

    {{-- Appointments Table --}}
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="px-5 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Patient</th>
                        <th class="px-5 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Type</th>
                        <th class="px-5 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Date & Time</th>
                        <th class="px-5 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-5 py-4 text-right text-xs font-semibold text-gray-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($appointments as $appointment)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full flex-shrink-0 flex items-center justify-center" style="background: linear-gradient(135deg, #eff6ff, #dbeafe);">
                                        <span class="text-xs font-bold text-blue-600">{{ strtoupper(substr($appointment->patient?->first_name ?? 'P', 0, 1) . substr($appointment->patient?->last_name ?? '', 0, 1)) }}</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">{{ $appointment->patient_name ?? ($appointment->patient?->first_name . ' ' . $appointment->patient?->last_name ?? '-') }}</p>
                                        <p class="text-xs text-gray-400">{{ $appointment->specialization?->name ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium {{ $appointment->type === 'clinic' ? 'bg-blue-50 text-blue-700' : 'bg-purple-50 text-purple-700' }}">
                                    {{ $appointment->type === 'clinic' ? 'Clinic Visit' : 'Telemedicine' }}
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                <p class="text-sm text-gray-900">{{ $appointment->appointment_date->format('M d, Y') }}</p>
                                <p class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</p>
                            </td>
                            <td class="px-5 py-4">
                                @php
                                    $statusStyles = match($appointment->status) {
                                        'pending' => 'bg-amber-50 text-amber-700',
                                        'approved' => 'bg-green-50 text-green-700',
                                        'scheduled' => 'bg-blue-50 text-blue-700',
                                        'completed' => 'bg-green-50 text-green-700',
                                        'cancelled' => 'bg-red-50 text-red-700',
                                        default => 'bg-gray-50 text-gray-700',
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium {{ $statusStyles }}">{{ ucfirst($appointment->status) }}</span>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <button onclick="viewAppointment({{ $appointment->id }})" class="w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center justify-center transition-colors" title="View">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-16 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                    <p class="text-sm font-medium text-gray-900">No appointments</p>
                                    <p class="text-xs text-gray-400 mt-1">No appointments have been assigned to you yet.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($appointments->hasPages())
            <div class="px-5 py-4 border-t border-gray-100">
                {{ $appointments->links() }}
            </div>
        @endif
    </div>
</div>

<x-modal id="view-appointment" title="Appointment Details" size="lg">
    <div id="appointment-content" class="space-y-4"></div>
</x-modal>

@push('scripts')
<script>
async function viewAppointment(id) {
    try {
        const response = await fetch(`/doctor/appointments/${id}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
        });
        const data = await response.json();

        if (data.success) {
            const a = data.appointment;
            const statusColors = {
                pending: 'bg-amber-50 text-amber-700', approved: 'bg-green-50 text-green-700',
                scheduled: 'bg-blue-50 text-blue-700', completed: 'bg-green-50 text-green-700',
                cancelled: 'bg-red-50 text-red-700',
            };

            document.getElementById('appointment-content').innerHTML = `
                <div class="space-y-4 text-sm">
                    <div><span class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium ${statusColors[a.status] || 'bg-gray-50 text-gray-700'}">${a.status_label || a.status}</span></div>
                    <div class="grid grid-cols-2 gap-4">
                        <div><p class="text-gray-400 mb-1">Patient</p><p class="text-gray-900 font-medium">${a.patient_name || (a.patient ? a.patient.first_name + ' ' + a.patient.last_name : '-')}</p><p class="text-gray-400 text-xs">${a.patient_email || a.patient?.email || '-'}</p></div>
                        <div><p class="text-gray-400 mb-1">Type</p><p class="text-gray-900">${a.type_label}</p></div>
                        <div><p class="text-gray-400 mb-1">Date & Time</p><p class="text-gray-900">${new Date(a.appointment_date).toLocaleDateString()} ${a.appointment_time}</p></div>
                        <div><p class="text-gray-400 mb-1">Reason</p><p class="text-gray-900">${a.reason || 'Not specified'}</p></div>
                    </div>
                    ${a.symptoms ? `<div><p class="text-gray-400 mb-1">Symptoms</p><p class="text-gray-900">${a.symptoms}</p></div>` : ''}
                    ${a.notes ? `<div><p class="text-gray-400 mb-1">Notes</p><p class="text-gray-900 whitespace-pre-line">${a.notes}</p></div>` : ''}
                </div>
            `;
            openModal('modal-view-appointment');
        }
    } catch (error) {
        showToast('Failed to load details.', 'error');
    }
}
</script>
@endpush
@endsection
