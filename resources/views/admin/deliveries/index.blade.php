@extends('layouts.app')

@section('title', 'Delivery Logs - Lakeshore Clinic')
@section('page-title', 'Delivery Management')

@section('content')
<div class="space-y-6">
    <x-page-header title="Delivery Management">
        <x-slot name="subtitle">View email, SMS, and reminder delivery logs</x-slot>
    </x-page-header>

    <x-card variant="default" class="p-4">
        <form method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <x-search-box name="search" placeholder="Search by recipient, event..." value="{{ request('search') }}" />
            </div>
            <div class="flex gap-2 flex-wrap">
                <select name="channel" class="px-3 py-2 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                    <option value="">All Channels</option>
                    <option value="email" {{ request('channel') === 'email' ? 'selected' : '' }}>Email</option>
                    <option value="sms" {{ request('channel') === 'sms' ? 'selected' : '' }}>SMS</option>
                    <option value="push" {{ request('channel') === 'push' ? 'selected' : '' }}>Push</option>
                </select>
                <select name="status" class="px-3 py-2 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="queued" {{ request('status') === 'queued' ? 'selected' : '' }}>Queued</option>
                    <option value="sent" {{ request('status') === 'sent' ? 'selected' : '' }}>Sent</option>
                    <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed</option>
                </select>
                <select name="event" class="px-3 py-2 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                    <option value="">All Events</option>
                    <option value="appointment_submission" {{ request('event') === 'appointment_submission' ? 'selected' : '' }}>Appointment Submission</option>
                    <option value="appointment_approval" {{ request('event') === 'appointment_approval' ? 'selected' : '' }}>Appointment Approval</option>
                    <option value="payment_confirmation" {{ request('event') === 'payment_confirmation' ? 'selected' : '' }}>Payment Confirmation</option>
                    <option value="prescription_ready" {{ request('event') === 'prescription_ready' ? 'selected' : '' }}>Prescription Ready</option>
                    <option value="reminder_24h" {{ request('event') === 'reminder_24h' ? 'selected' : '' }}>24 Hour Reminder</option>
                    <option value="reminder_1h" {{ request('event') === 'reminder_1h' ? 'selected' : '' }}>1 Hour Reminder</option>
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
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Recipient</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Channel</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Event</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Date</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-text-muted uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-border">
                    @forelse($deliveryLogs as $log)
                        <tr class="hover:bg-surface transition-colors">
                            <td class="px-4 py-3">
                                <p class="text-sm font-medium text-text-primary">{{ $log->recipient }}</p>
                                <p class="text-xs text-text-muted">{{ $log->user?->name ?? '-' }}</p>
                            </td>
                            <td class="px-4 py-3">
                                @php
                                    $channelVariant = match($log->channel) {
                                        'email' => 'primary', 'sms' => 'success', 'push' => 'info', default => 'default',
                                    };
                                @endphp
                                <x-badge :variant="$channelVariant">{{ $log->channel_label }}</x-badge>
                            </td>
                            <td class="px-4 py-3 text-sm text-text-muted">{{ $log->event_label }}</td>
                            <td class="px-4 py-3">
                                @php
                                    $statusVariant = match($log->status) {
                                        'pending' => 'warning', 'queued' => 'warning', 'sent' => 'info',
                                        'delivered' => 'success', 'failed' => 'danger', 'cancelled' => 'danger',
                                        default => 'default',
                                    };
                                @endphp
                                <x-status-badge :variant="$statusVariant" :label="$log->status_label" />
                            </td>
                            <td class="px-4 py-3 text-sm text-text-muted">{{ $log->created_at->format('M d, Y H:i') }}</td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <button onclick="viewDelivery({{ $log->id }})" class="w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center justify-center transition-colors" title="View">
                                        <svg class="w-4 h-4 text-text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </button>
                                    <button onclick="deleteDelivery({{ $log->id }})" class="w-8 h-8 rounded-lg hover:bg-red-50 flex items-center justify-center transition-colors" title="Delete">
                                        <svg class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center">
                                <x-empty-state message="No delivery logs found." />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($deliveryLogs->hasPages())
            <div class="px-4 py-3 border-t border-surface-border">
                {{ $deliveryLogs->links() }}
            </div>
        @endif
    </x-card>
</div>

<x-modal id="view-delivery" title="Delivery Details">
    <div id="delivery-content" class="space-y-4"></div>
</x-modal>

@push('scripts')
<script>
async function viewDelivery(id) {
    try {
        const response = await fetch(`/admin/deliveries/${id}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
        });
        const data = await response.json();

        if (data.success) {
            const d = data.deliveryLog;
            const statusColors = {
                pending: 'bg-amber-100 text-amber-800', queued: 'bg-amber-100 text-amber-800',
                sent: 'bg-blue-100 text-blue-800', delivered: 'bg-health-100 text-health-800',
                failed: 'bg-red-100 text-red-800', cancelled: 'bg-red-100 text-red-800',
            };

            document.getElementById('delivery-content').innerHTML = `
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div class="col-span-2"><span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium ${statusColors[d.status] || 'bg-gray-100 text-gray-800'}">${d.status_label}</span></div>
                    <div><p class="text-text-muted mb-1">Recipient</p><p class="text-text-primary font-medium">${d.recipient}</p></div>
                    <div><p class="text-text-muted mb-1">Channel</p><p class="text-text-primary">${d.channel_label}</p></div>
                    <div><p class="text-text-muted mb-1">Event</p><p class="text-text-primary">${d.event_label}</p></div>
                    <div><p class="text-text-muted mb-1">Date</p><p class="text-text-primary">${new Date(d.created_at).toLocaleString()}</p></div>
                    ${d.message ? `<div class="col-span-2"><p class="text-text-muted mb-1">Message</p><p class="text-text-primary whitespace-pre-line">${d.message}</p></div>` : ''}
                </div>
            `;
            openModal('modal-view-delivery');
        }
    } catch (error) {
        showToast('Failed to load details.', 'error');
    }
}

async function deleteDelivery(id) {
    confirmAction('Are you sure you want to delete this delivery log?', async () => {
        try {
            const response = await fetch(`/admin/deliveries/${id}`, {
                method: 'DELETE',
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
    });
}
</script>
@endpush
@endsection
