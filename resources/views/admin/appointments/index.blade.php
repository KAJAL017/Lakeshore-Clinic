@extends('layouts.app')

@section('title', 'Appointments - Lakeshore Clinic')
@section('page-title', 'Appointment Management')

@section('content')
<div class="space-y-6">
    <x-page-header title="Appointment Management">
        <x-slot name="subtitle">Manage patient appointments</x-slot>
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
                </select>
                <select name="type" class="px-3 py-2 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                    <option value="">All Types</option>
                    <option value="clinic" {{ request('type') === 'clinic' ? 'selected' : '' }}>Clinic Visit</option>
                    <option value="telemedicine" {{ request('type') === 'telemedicine' ? 'selected' : '' }}>Telemedicine</option>
                </select>
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="px-3 py-2 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="px-3 py-2 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
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
                                <div>
                                    <p class="text-sm font-medium text-text-primary">{{ $appointment->patient ? $appointment->patient->first_name . ' ' . $appointment->patient->last_name : '-' }}</p>
                                    <p class="text-xs text-text-muted">{{ $appointment->patient?->email ?? '-' }}</p>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <p class="text-sm font-medium text-text-primary">{{ $appointment->doctor?->name ?? '-' }}</p>
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
                                <x-status-badge :variant="$statusVariant" :label="$appointment->status_label" />
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <button onclick="viewAppointment({{ $appointment->id }})" class="w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center justify-center transition-colors" title="View">
                                        <svg class="w-4 h-4 text-text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </button>
                                    <button onclick="updateStatus({{ $appointment->id }})" class="w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center justify-center transition-colors" title="Update Status">
                                        <svg class="w-4 h-4 text-text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                    </button>
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
    <div id="appointment-content" class="space-y-4">
    </div>
</x-modal>

<x-modal id="update-status" title="Update Appointment Status">
    <form id="status-form" class="space-y-4">
        @csrf
        @method('PUT')
        <input type="hidden" name="appointment_id" id="status-appointment-id">
        <x-select label="Status" name="status" id="status-select" :options="[
            'pending' => 'Pending',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
            'scheduled' => 'Scheduled',
            'cancelled' => 'Cancelled',
            'rescheduled' => 'Rescheduled',
            'completed' => 'Completed',
            'no_show' => 'No Show',
        ]" required />
    </form>

    <x-slot name="footer">
        <x-button variant="outline" size="sm" data-modal-close>Cancel</x-button>
        <x-button variant="primary" size="sm" id="status-btn" onclick="submitStatusUpdate()">
            <span id="status-btn-text">Update Status</span>
            <svg id="status-btn-spinner" class="hidden animate-spin w-4 h-4 ml-1.5" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
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
                pending: 'bg-amber-100 text-amber-800',
                approved: 'bg-health-100 text-health-800',
                scheduled: 'bg-blue-100 text-blue-800',
                completed: 'bg-health-100 text-health-800',
                cancelled: 'bg-red-100 text-red-800',
                rejected: 'bg-red-100 text-red-800',
                no_show: 'bg-gray-100 text-gray-800',
                rescheduled: 'bg-purple-100 text-purple-800',
            };

            const content = `
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div class="col-span-2">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium ${statusColors[a.status] || 'bg-gray-100 text-gray-800'}">${a.status_label}</span>
                    </div>
                    <div>
                        <p class="text-text-muted mb-1">Patient</p>
                        <p class="text-text-primary font-medium">${a.patient ? a.patient.first_name + ' ' + a.patient.last_name : '-'}</p>
                        <p class="text-text-muted text-xs">${a.patient ? a.patient.email : '-'}</p>
                    </div>
                    <div>
                        <p class="text-text-muted mb-1">Doctor</p>
                        <p class="text-text-primary font-medium">${a.doctor ? a.doctor.name : '-'}</p>
                        <p class="text-text-muted text-xs">${a.specialization ? a.specialization.name : '-'}</p>
                    </div>
                    <div>
                        <p class="text-text-muted mb-1">Type</p>
                        <p class="text-text-primary">${a.type_label}</p>
                    </div>
                    <div>
                        <p class="text-text-muted mb-1">Date & Time</p>
                        <p class="text-text-primary">${new Date(a.appointment_date).toLocaleDateString()}</p>
                        <p class="text-text-muted text-xs">${a.appointment_time}</p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-text-muted mb-1">Notes</p>
                        <p class="text-text-primary">${a.notes || 'No notes'}</p>
                    </div>
                </div>
            `;
            document.getElementById('appointment-content').innerHTML = content;
            openModal('modal-view-appointment');
        }
    } catch (error) {
        showToast('Failed to load appointment details.', 'error');
    }
}

function updateStatus(id) {
    document.getElementById('status-appointment-id').value = id;
    openModal('modal-update-status');
}

async function submitStatusUpdate() {
    const id = document.getElementById('status-appointment-id').value;
    const status = document.getElementById('status-select').value;
    const btn = document.getElementById('status-btn');
    const btnText = document.getElementById('status-btn-text');
    const btnSpinner = document.getElementById('status-btn-spinner');

    btn.disabled = true;
    btnText.textContent = 'Updating...';
    btnSpinner.classList.remove('hidden');

    try {
        const response = await fetch(`/admin/appointments/${id}/status`, {
            method: 'PUT',
            body: JSON.stringify({ status }),
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
        });

        const data = await response.json();

        if (response.ok && data.success) {
            showToast(data.message, 'success');
            setTimeout(() => location.reload(), 1000);
        } else {
            showToast(data.message || 'Failed to update status.', 'error');
        }
    } catch (error) {
        showToast('An error occurred. Please try again.', 'error');
    } finally {
        btn.disabled = false;
        btnText.textContent = 'Update Status';
        btnSpinner.classList.add('hidden');
    }
}
</script>
@endpush
@endsection
