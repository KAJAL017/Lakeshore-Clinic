@extends('layouts.app')

@section('title', 'Meetings - Lakeshore Clinic')
@section('page-title', 'Microsoft Teams Meetings')

@section('content')
<div class="space-y-6">
    <x-page-header title="Microsoft Teams Meetings">
        <x-slot name="subtitle">Manage telemedicine meeting links</x-slot>
    </x-page-header>

    <x-card variant="default" class="p-4">
        <form method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <x-search-box name="search" placeholder="Search by meeting ID, patient, doctor..." value="{{ request('search') }}" />
            </div>
            <div class="flex gap-2 flex-wrap">
                <select name="status" class="px-3 py-2 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="created" {{ request('status') === 'created' ? 'selected' : '' }}>Created</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
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
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Meeting ID</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Patient</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Doctor</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Date</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Status</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-text-muted uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-border">
                    @forelse($meetings as $meeting)
                        <tr class="hover:bg-surface transition-colors">
                            <td class="px-4 py-3">
                                <p class="text-sm font-medium text-text-primary font-mono">{{ $meeting->meeting_id ?? '-' }}</p>
                            </td>
                            <td class="px-4 py-3">
                                <p class="text-sm font-medium text-text-primary">{{ $meeting->appointment->patient_name ?? ($meeting->appointment->patient?->first_name . ' ' . $meeting->appointment->patient?->last_name ?? '-') }}</p>
                            </td>
                            <td class="px-4 py-3">
                                <p class="text-sm font-medium text-text-primary">{{ $meeting->appointment->doctor?->name ?? '-' }}</p>
                            </td>
                            <td class="px-4 py-3">
                                <p class="text-sm text-text-primary">{{ $meeting->appointment->appointment_date->format('M d, Y') }}</p>
                                <p class="text-xs text-text-muted">{{ \Carbon\Carbon::parse($meeting->appointment->appointment_time)->format('h:i A') }}</p>
                            </td>
                            <td class="px-4 py-3">
                                @php
                                    $statusVariant = match($meeting->status) {
                                        'pending' => 'warning',
                                        'created' => 'info',
                                        'active' => 'success',
                                        'completed' => 'success',
                                        'cancelled' => 'danger',
                                        default => 'default',
                                    };
                                @endphp
                                <x-status-badge :variant="$statusVariant" :label="$meeting->status_label" />
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <button onclick="viewMeeting({{ $meeting->id }})" class="w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center justify-center transition-colors" title="View">
                                        <svg class="w-4 h-4 text-text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </button>
                                    <button onclick="updateMeetingStatus({{ $meeting->id }})" class="w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center justify-center transition-colors" title="Update Status">
                                        <svg class="w-4 h-4 text-text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center">
                                <x-empty-state message="No meetings found." />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($meetings->hasPages())
            <div class="px-4 py-3 border-t border-surface-border">
                {{ $meetings->links() }}
            </div>
        @endif
    </x-card>
</div>

<x-modal id="view-meeting" title="Meeting Details" size="lg">
    <div id="meeting-content" class="space-y-4"></div>
</x-modal>

<x-modal id="update-status" title="Update Meeting Status">
    <form id="status-form" class="space-y-4">
        @csrf
        @method('PUT')
        <input type="hidden" name="meeting_id" id="status-meeting-id">
        <x-select label="Status" name="status" id="status-select" :options="[
            'pending' => 'Pending', 'created' => 'Created', 'active' => 'Active',
            'completed' => 'Completed', 'cancelled' => 'Cancelled',
        ]" required />
    </form>
    <x-slot name="footer">
        <x-button variant="outline" size="sm" data-modal-close>Cancel</x-button>
        <x-button variant="primary" size="sm" id="status-btn" onclick="submitStatusUpdate()">
            <span id="status-btn-text">Update</span>
        </x-button>
    </x-slot>
</x-modal>

@push('scripts')
<script>
async function viewMeeting(id) {
    try {
        const response = await fetch(`/admin/meetings/${id}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
        });
        const data = await response.json();

        if (data.success) {
            const m = data.meeting;
            const a = m.appointment;
            const statusColors = {
                pending: 'bg-amber-100 text-amber-800', created: 'bg-blue-100 text-blue-800',
                active: 'bg-health-100 text-health-800', completed: 'bg-gray-100 text-gray-800',
                cancelled: 'bg-red-100 text-red-800',
            };

            document.getElementById('meeting-content').innerHTML = `
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div class="col-span-2"><span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium ${statusColors[m.status] || 'bg-gray-100 text-gray-800'}">${m.status_label}</span></div>
                    <div><p class="text-text-muted mb-1">Meeting ID</p><p class="text-text-primary font-medium font-mono">${m.meeting_id || 'Not generated'}</p></div>
                    <div><p class="text-text-muted mb-1">Meeting URL</p><p class="text-text-primary font-medium break-all">${m.meeting_url || 'Not generated'}</p></div>
                    <div><p class="text-text-muted mb-1">Patient</p><p class="text-text-primary">${a?.patient_name || (a?.patient ? a.patient.first_name + ' ' + a.patient.last_name : '-')}</p></div>
                    <div><p class="text-text-muted mb-1">Doctor</p><p class="text-text-primary">${a?.doctor?.name || '-'}</p></div>
                    <div><p class="text-text-muted mb-1">Date & Time</p><p class="text-text-primary">${a?.appointment_date ? new Date(a.appointment_date).toLocaleDateString() : '-'} ${a?.appointment_time || ''}</p></div>
                    <div><p class="text-text-muted mb-1">Type</p><p class="text-text-primary">${a?.type_label || '-'}</p></div>
                </div>
            `;
            openModal('modal-view-meeting');
        }
    } catch (error) {
        showToast('Failed to load meeting details.', 'error');
    }
}

function updateMeetingStatus(id) {
    document.getElementById('status-meeting-id').value = id;
    openModal('modal-update-status');
}

async function submitStatusUpdate() {
    const id = document.getElementById('status-meeting-id').value;
    const status = document.getElementById('status-select').value;

    try {
        const response = await fetch(`/admin/meetings/${id}/status`, {
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
