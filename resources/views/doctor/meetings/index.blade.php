@extends('layouts.doctor')

@section('title', 'My Meetings - Lakeshore Clinic')
@section('page-title', 'My Meetings')

@section('content')
<div class="space-y-6">
    <x-page-header title="My Meetings">
        <x-slot name="subtitle">Your telemedicine meeting links</x-slot>
    </x-page-header>

    <x-card variant="default">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-surface-border">
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Meeting ID</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Patient</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Date & Time</th>
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
                                <p class="text-xs text-text-muted">{{ $meeting->appointment->specialization?->name ?? '-' }}</p>
                            </td>
                            <td class="px-4 py-3">
                                <p class="text-sm text-text-primary">{{ $meeting->appointment->appointment_date->format('M d, Y') }}</p>
                                <p class="text-xs text-text-muted">{{ \Carbon\Carbon::parse($meeting->appointment->appointment_time)->format('h:i A') }}</p>
                            </td>
                            <td class="px-4 py-3">
                                @php
                                    $statusVariant = match($meeting->status) {
                                        'pending' => 'warning', 'created' => 'info', 'active' => 'success',
                                        'completed' => 'success', 'cancelled' => 'danger', default => 'default',
                                    };
                                @endphp
                                <x-status-badge :variant="$statusVariant" :label="$meeting->status_label" />
                            </td>
                            <td class="px-4 py-3 text-right">
                                <button onclick="viewMeeting({{ $meeting->id }})" class="w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center justify-center transition-colors" title="View">
                                    <svg class="w-4 h-4 text-text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-12 text-center">
                                <x-empty-state message="No meetings assigned yet." />
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

@push('scripts')
<script>
async function viewMeeting(id) {
    try {
        const response = await fetch(`/doctor/meetings/${id}`, {
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
                    <div><p class="text-text-muted mb-1">Date & Time</p><p class="text-text-primary">${a?.appointment_date ? new Date(a.appointment_date).toLocaleDateString() : '-'} ${a?.appointment_time || ''}</p></div>
                    ${m.meeting_url ? `<div class="col-span-2"><a href="${m.meeting_url}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-1M14 4h6m0 0v6m0-6L10 14"/></svg> Join Meeting</a></div>` : ''}
                </div>
            `;
            openModal('modal-view-meeting');
        }
    } catch (error) {
        showToast('Failed to load meeting details.', 'error');
    }
}
</script>
@endpush
@endsection
