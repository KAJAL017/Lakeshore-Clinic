@extends('layouts.app')

@section('title', 'Appointment Lifecycle - Lakeshore Clinic')
@section('page-title', 'Appointment Lifecycle')

@section('content')
<div class="space-y-6">
    <x-page-header title="Appointment Lifecycle">
        <x-slot name="subtitle">Manage appointment status and history</x-slot>
    </x-page-header>

    <x-card variant="default" class="p-4">
        <form method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <x-search-box name="search" placeholder="Search by patient, doctor..." value="{{ request('search') }}" />
            </div>
            <div class="flex gap-2 flex-wrap">
                <select name="status" class="px-3 py-2 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                    <option value="">All Status</option>
                    <option value="pending_review" {{ request('status') === 'pending_review' ? 'selected' : '' }}>Pending Review</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="scheduled" {{ request('status') === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                    <option value="in_consultation" {{ request('status') === 'in_consultation' ? 'selected' : '' }}>In Consultation</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    <option value="no_show" {{ request('status') === 'no_show' ? 'selected' : '' }}>No Show</option>
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
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Date</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Status</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-text-muted uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-border">
                    @forelse($appointments as $appointment)
                        <tr class="hover:bg-surface transition-colors">
                            <td class="px-4 py-3">
                                <p class="text-sm font-medium text-text-primary">{{ $appointment->patient_name ?? ($appointment->patient?->first_name . ' ' . $appointment->patient?->last_name ?? '-') }}</p>
                            </td>
                            <td class="px-4 py-3 text-sm text-text-primary">{{ $appointment->doctor?->name ?? 'Unassigned' }}</td>
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
                                        'pending_review' => 'warning', 'approved' => 'success', 'scheduled' => 'info',
                                        'in_consultation' => 'info', 'completed' => 'success', 'cancelled' => 'danger',
                                        'no_show' => 'danger', 'rejected' => 'danger', default => 'default',
                                    };
                                @endphp
                                <x-status-badge :variant="$statusVariant" :label="str_replace('_', ' ', ucfirst($appointment->status))" />
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <button onclick="viewTimeline({{ $appointment->id }})" class="w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center justify-center transition-colors" title="View Timeline">
                                        <svg class="w-4 h-4 text-text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
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

<x-modal id="view-timeline" title="Appointment Timeline" size="lg">
    <div id="timeline-content" class="space-y-4"></div>
</x-modal>

<x-modal id="update-status" title="Update Status">
    <form id="status-form" class="space-y-4">
        @csrf
        @method('PUT')
        <input type="hidden" name="appointment_id" id="status-appointment-id">
        <x-select label="Status" name="status" id="status-select" :options="[
            'pending_review' => 'Pending Review', 'approved' => 'Approved', 'rejected' => 'Rejected',
            'scheduled' => 'Scheduled', 'cancelled' => 'Cancelled', 'rescheduled' => 'Rescheduled',
            'in_consultation' => 'In Consultation', 'completed' => 'Completed', 'no_show' => 'No Show',
        ]" required />
        <x-textarea label="Notes" name="notes" rows="2" placeholder="Optional notes..." />
    </form>
    <x-slot name="footer">
        <x-button variant="outline" size="sm" data-modal-close>Cancel</x-button>
        <x-button variant="primary" size="sm" id="status-btn" onclick="submitStatusUpdate()">
            <span id="status-btn-text">Update Status</span>
        </x-button>
    </x-slot>
</x-modal>

<x-modal id="reschedule" title="Reschedule Appointment">
    <form id="reschedule-form" class="space-y-4">
        @csrf
        @method('PUT')
        <input type="hidden" name="appointment_id" id="reschedule-appointment-id">
        <x-input label="New Date" name="appointment_date" type="date" required />
        <x-input label="New Time" name="appointment_time" type="time" required />
    </form>
    <x-slot name="footer">
        <x-button variant="outline" size="sm" data-modal-close>Cancel</x-button>
        <x-button variant="primary" size="sm" id="reschedule-btn" onclick="submitReschedule()">
            <span id="reschedule-btn-text">Reschedule</span>
        </x-button>
    </x-slot>
</x-modal>

@push('scripts')
<script>
async function viewTimeline(id) {
    try {
        const response = await fetch(`/admin/lifecycle/${id}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
        });
        const data = await response.json();

        if (data.success) {
            const a = data.appointment;
            const history = data.history;

            let timelineHtml = '';
            if (history.length > 0) {
                timelineHtml = history.map(h => `
                    <div class="flex gap-3 p-3 border-l-2 border-primary-500 ml-4">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-text-primary">${h.previous_status ? h.previous_status.replace('_', ' ') + ' → ' : ''}${h.new_status.replace('_', ' ')}</p>
                            <p class="text-xs text-text-muted">${h.updater?.name || 'System'} - ${new Date(h.created_at).toLocaleString()}</p>
                            ${h.notes ? `<p class="text-xs text-text-muted mt-1">${h.notes}</p>` : ''}
                        </div>
                    </div>
                `).join('');
            } else {
                timelineHtml = '<p class="text-sm text-text-muted text-center py-4">No status history found.</p>';
            }

            document.getElementById('timeline-content').innerHTML = `
                <div class="grid grid-cols-2 gap-4 text-sm mb-4 p-4 bg-surface rounded-lg">
                    <div><span class="text-text-muted">Patient:</span> <span class="text-text-primary">${a.patient_name || (a.patient ? a.patient.first_name + ' ' + a.patient.last_name : '-')}</span></div>
                    <div><span class="text-text-muted">Doctor:</span> <span class="text-text-primary">${a.doctor?.name || 'Unassigned'}</span></div>
                    <div><span class="text-text-muted">Date:</span> <span class="text-text-primary">${new Date(a.appointment_date).toLocaleDateString()}</span></div>
                    <div><span class="text-text-muted">Status:</span> <span class="text-text-primary">${a.status.replace('_', ' ')}</span></div>
                </div>
                <h4 class="text-sm font-semibold text-text-primary mb-3">Status History</h4>
                <div class="space-y-2">${timelineHtml}</div>
            `;
            openModal('modal-view-timeline');
        }
    } catch (error) {
        showToast('Failed to load timeline.', 'error');
    }
}

function updateStatus(id) {
    document.getElementById('status-appointment-id').value = id;
    openModal('modal-update-status');
}

async function submitStatusUpdate() {
    const id = document.getElementById('status-appointment-id').value;
    const status = document.getElementById('status-select').value;
    const notes = document.querySelector('#status-form textarea[name="notes"]').value;

    try {
        const response = await fetch(`/admin/lifecycle/${id}/status`, {
            method: 'PUT',
            body: JSON.stringify({ status, notes }),
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
        }
    } catch (error) {
        showToast('An error occurred.', 'error');
    }
}
</script>
@endpush
@endsection
