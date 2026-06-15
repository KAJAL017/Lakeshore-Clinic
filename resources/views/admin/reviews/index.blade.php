@extends('layouts.app')

@section('title', 'Appointment Review - Lakeshore Clinic')
@section('page-title', 'Appointment Review')

@section('content')
<div class="space-y-6">
    <x-page-header title="Appointment Review">
        <x-slot name="subtitle">Review and manage appointments</x-slot>
    </x-page-header>

    <x-card variant="default" class="p-4">
        <form method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <x-search-box name="search" placeholder="Search by patient, doctor..." value="{{ request('search') }}" />
            </div>
            <div class="flex gap-2 flex-wrap">
                <select name="status" class="px-3 py-2 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="scheduled" {{ request('status') === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
                <select name="type" class="px-3 py-2 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                    <option value="">All Types</option>
                    <option value="clinic" {{ request('type') === 'clinic' ? 'selected' : '' }}>Clinic Visit</option>
                    <option value="telemedicine" {{ request('type') === 'telemedicine' ? 'selected' : '' }}>Telemedicine</option>
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
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Date & Time</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Status</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-text-muted uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-border">
                    @forelse($appointments as $appointment)
                        <tr class="hover:bg-surface transition-colors">
                            <td class="px-4 py-3">
                                <p class="text-sm font-medium text-text-primary">{{ $appointment->patient_name ?? ($appointment->patient?->first_name . ' ' . $appointment->patient?->last_name ?? '-') }}</p>
                                <p class="text-xs text-text-muted">{{ $appointment->patient_email ?? $appointment->patient?->email ?? '-' }}</p>
                            </td>
                            <td class="px-4 py-3">
                                <p class="text-sm font-medium text-text-primary">{{ $appointment->doctor?->name ?? 'Unassigned' }}</p>
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
                                        'pending' => 'warning',
                                        'approved' => 'success',
                                        'scheduled' => 'info',
                                        'completed' => 'success',
                                        'cancelled' => 'danger',
                                        'rejected' => 'danger',
                                        default => 'default',
                                    };
                                @endphp
                                <x-status-badge :variant="$statusVariant" :label="ucfirst($appointment->status)" />
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <button onclick="viewAppointment({{ $appointment->id }})" class="w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center justify-center transition-colors" title="View">
                                        <svg class="w-4 h-4 text-text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </button>
                                    @if($appointment->status === 'pending')
                                        <button onclick="approveAppointment({{ $appointment->id }})" class="w-8 h-8 rounded-lg hover:bg-health-50 flex items-center justify-center transition-colors" title="Approve">
                                            <svg class="w-4 h-4 text-health-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        </button>
                                        <button onclick="rejectAppointment({{ $appointment->id }})" class="w-8 h-8 rounded-lg hover:bg-red-50 flex items-center justify-center transition-colors" title="Reject">
                                            <svg class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </button>
                                    @endif
                                    @if(in_array($appointment->status, ['pending', 'approved']))
                                        <button onclick="assignDoctor({{ $appointment->id }})" class="w-8 h-8 rounded-lg hover:bg-primary-50 flex items-center justify-center transition-colors" title="Assign Doctor">
                                            <svg class="w-4 h-4 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center">
                                <x-empty-state message="No appointments found." />
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

<x-modal id="assign-doctor" title="Assign Doctor">
    <form id="assign-form" class="space-y-4">
        @csrf
        @method('PUT')
        <input type="hidden" name="appointment_id" id="assign-appointment-id">
        <div>
            <label class="block text-sm font-medium text-text-primary mb-1.5">Select Doctor</label>
            <select name="doctor_id" id="assign-doctor-select" class="w-full px-3 py-2 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500" required>
                <option value="">Select a doctor</option>
                @foreach($doctors as $doctor)
                    <option value="{{ $doctor->id }}">{{ $doctor->name }} - {{ $doctor->specialization?->name ?? 'General' }}</option>
                @endforeach
            </select>
        </div>
    </form>

    <x-slot name="footer">
        <x-button variant="outline" size="sm" data-modal-close>Cancel</x-button>
        <x-button variant="primary" size="sm" id="assign-btn" onclick="submitAssignDoctor()">
            <span id="assign-btn-text">Assign Doctor</span>
        </x-button>
    </x-slot>
</x-modal>

@push('scripts')
<script>
async function viewAppointment(id) {
    try {
        const response = await fetch(`/admin/appointments/${id}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
        });
        const data = await response.json();

        if (data.success) {
            const a = data.appointment;
            const statusColors = {
                pending: 'bg-amber-100 text-amber-800', approved: 'bg-health-100 text-health-800',
                scheduled: 'bg-blue-100 text-blue-800', completed: 'bg-health-100 text-health-800',
                cancelled: 'bg-red-100 text-red-800', rejected: 'bg-red-100 text-red-800',
            };

            document.getElementById('appointment-content').innerHTML = `
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div class="col-span-2"><span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium ${statusColors[a.status] || 'bg-gray-100 text-gray-800'}">${a.status_label || a.status}</span></div>
                    <div><p class="text-text-muted mb-1">Patient</p><p class="text-text-primary font-medium">${a.patient_name || (a.patient ? a.patient.first_name + ' ' + a.patient.last_name : '-')}</p><p class="text-text-muted text-xs">${a.patient_email || a.patient?.email || '-'}</p></div>
                    <div><p class="text-text-muted mb-1">Doctor</p><p class="text-text-primary font-medium">${a.doctor?.name || 'Unassigned'}</p></div>
                    <div><p class="text-text-muted mb-1">Type</p><p class="text-text-primary">${a.type_label}</p></div>
                    <div><p class="text-text-muted mb-1">Date & Time</p><p class="text-text-primary">${new Date(a.appointment_date).toLocaleDateString()} ${a.appointment_time}</p></div>
                    <div><p class="text-text-muted mb-1">Reason</p><p class="text-text-primary">${a.reason || 'Not specified'}</p></div>
                    ${a.symptoms ? `<div class="col-span-2"><p class="text-text-muted mb-1">Symptoms</p><p class="text-text-primary">${a.symptoms}</p></div>` : ''}
                    ${a.notes ? `<div class="col-span-2"><p class="text-text-muted mb-1">Notes</p><p class="text-text-primary whitespace-pre-line">${a.notes}</p></div>` : ''}
                </div>
            `;
            openModal('modal-view-appointment');
        }
    } catch (error) {
        showToast('Failed to load details.', 'error');
    }
}

async function approveAppointment(id) {
    try {
        const response = await fetch(`/admin/approvals/${id}/approve`, {
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

async function rejectAppointment(id) {
    if (!confirm('Are you sure you want to reject this appointment?')) return;
    try {
        const response = await fetch(`/admin/approvals/${id}/reject`, {
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

function assignDoctor(id) {
    document.getElementById('assign-appointment-id').value = id;
    openModal('modal-assign-doctor');
}

async function submitAssignDoctor() {
    const id = document.getElementById('assign-appointment-id').value;
    const doctorId = document.getElementById('assign-doctor-select').value;

    if (!doctorId) {
        showToast('Please select a doctor.', 'error');
        return;
    }

    try {
        const response = await fetch(`/admin/approvals/${id}/assign`, {
            method: 'PUT',
            body: JSON.stringify({ doctor_id: doctorId }),
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
            setTimeout(() => location.reload(), 1000);
        } else {
            showToast(data.message || 'Failed to assign doctor.', 'error');
        }
    } catch (error) {
        showToast('An error occurred.', 'error');
    }
}
</script>
@endpush
@endsection
