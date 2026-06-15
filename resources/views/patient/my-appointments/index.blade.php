@extends('layouts.patient')

@section('title', 'My Appointments - Lakeshore Clinic')
@section('page-title', 'My Appointments')

@section('content')
<div class="space-y-6">
    <x-page-header title="My Appointments">
        <x-slot name="subtitle">View and manage your appointments</x-slot>
    </x-page-header>

    <x-card variant="default">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-surface-border">
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Doctor</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Type</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Date & Time</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Status</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-text-muted uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-border">
                    @forelse($appointments as $appointment)
                        <tr class="hover:bg-surface transition-colors">
                            <td class="px-4 py-3">
                                <p class="text-sm font-medium text-text-primary">{{ $appointment->doctor?->name ?? 'TBD' }}</p>
                                <p class="text-xs text-text-muted">{{ $appointment->specialization?->name ?? '-' }}</p>
                            </td>
                            <td class="px-4 py-3">
                                <x-badge variant="{{ $appointment->type === 'clinic' ? 'primary' : 'info' }}">{{ $appointment->type_label }}</x-badge>
                            </td>
                            <td class="px-4 py-3">
                                <p class="text-sm text-text-primary">{{ $appointment->appointment_date->format('M d, Y') }}</p>
                                <p class="text-xs text-text-muted">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</p>
                            </td>
                            <td class="px-4 py-3">
                                @php
                                    $statusVariant = match($appointment->status) {
                                        'pending' => 'warning', 'approved' => 'success', 'scheduled' => 'info', 'completed' => 'success', 'cancelled' => 'danger', default => 'default',
                                    };
                                @endphp
                                <x-status-badge :variant="$statusVariant" :label="ucfirst($appointment->status)" />
                            </td>
                            <td class="px-4 py-3 text-right">
                                <button onclick="viewAppointment({{ $appointment->id }})" class="w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center justify-center transition-colors" title="View">
                                    <svg class="w-4 h-4 text-text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-12 text-center">
                                <x-empty-state message="No appointments found.">
                                    <a href="{{ route('patient.book-appointment') }}" class="mt-3 inline-block text-sm text-primary-600 hover:text-primary-700 font-medium">Book an appointment</a>
                                </x-empty-state>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($appointments->hasPages())
            <div class="px-4 py-3 border-t border-surface-border">
                {{ $appointments->links() }}
            </div>
        @endif
    </x-card>
</div>

<x-modal id="view-appointment" title="Appointment Details" size="lg">
    <div id="appointment-content" class="space-y-4"></div>
</x-modal>

@push('scripts')
<script>
async function viewAppointment(id) {
    try {
        const response = await fetch(`/patient/appointments/${id}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
        });
        const data = await response.json();

        if (data.success) {
            const a = data.appointment;
            const statusColors = { pending: 'bg-amber-100 text-amber-800', approved: 'bg-health-100 text-health-800', scheduled: 'bg-blue-100 text-blue-800', completed: 'bg-health-100 text-health-800', cancelled: 'bg-red-100 text-red-800' };

            document.getElementById('appointment-content').innerHTML = `
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div class="col-span-2"><span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium ${statusColors[a.status] || 'bg-gray-100 text-gray-800'}">${a.status}</span></div>
                    <div><p class="text-text-muted mb-1">Doctor</p><p class="text-text-primary font-medium">${a.doctor?.name || 'TBD'}</p><p class="text-text-muted text-xs">${a.specialization?.name || '-'}</p></div>
                    <div><p class="text-text-muted mb-1">Type</p><p class="text-text-primary">${a.type === 'clinic' ? 'Clinic Visit' : 'Telemedicine'}</p></div>
                    <div><p class="text-text-muted mb-1">Date & Time</p><p class="text-text-primary">${new Date(a.appointment_date).toLocaleDateString()} ${a.appointment_time}</p></div>
                    ${a.reason ? `<div class="col-span-2"><p class="text-text-muted mb-1">Reason</p><p class="text-text-primary">${a.reason}</p></div>` : ''}
                    ${a.symptoms ? `<div class="col-span-2"><p class="text-text-muted mb-1">Symptoms</p><p class="text-text-primary">${a.symptoms}</p></div>` : ''}
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
