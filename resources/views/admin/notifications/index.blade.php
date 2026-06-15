@extends('layouts.app')

@section('title', 'Notifications - Lakeshore Clinic')
@section('page-title', 'Notification Management')

@section('content')
<div class="space-y-6">
    <x-page-header title="Notification Management">
        <x-slot name="subtitle">Manage all notifications</x-slot>
    </x-page-header>

    <x-card variant="default" class="p-4">
        <form method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <x-search-box name="search" placeholder="Search notifications..." value="{{ request('search') }}" />
            </div>
            <div class="flex gap-2">
                <select name="status" class="px-3 py-2 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                    <option value="">All Status</option>
                    <option value="unread" {{ request('status') === 'unread' ? 'selected' : '' }}>Unread</option>
                    <option value="read" {{ request('status') === 'read' ? 'selected' : '' }}>Read</option>
                    <option value="archived" {{ request('status') === 'archived' ? 'selected' : '' }}>Archived</option>
                </select>
                <select name="type" class="px-3 py-2 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                    <option value="">All Types</option>
                    <option value="system" {{ request('type') === 'system' ? 'selected' : '' }}>System</option>
                    <option value="appointment" {{ request('type') === 'appointment' ? 'selected' : '' }}>Appointment</option>
                    <option value="payment" {{ request('type') === 'payment' ? 'selected' : '' }}>Payment</option>
                    <option value="insurance" {{ request('type') === 'insurance' ? 'selected' : '' }}>Insurance</option>
                    <option value="prescription" {{ request('type') === 'prescription' ? 'selected' : '' }}>Prescription</option>
                    <option value="telemedicine" {{ request('type') === 'telemedicine' ? 'selected' : '' }}>Telemedicine</option>
                    <option value="general" {{ request('type') === 'general' ? 'selected' : '' }}>General</option>
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
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Title</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Type</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-muted uppercase">Date</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-text-muted uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-border">
                    @forelse($notifications as $notification)
                        <tr class="hover:bg-surface transition-colors">
                            <td class="px-4 py-3">
                                <p class="text-sm font-medium text-text-primary">{{ $notification->user?->name ?? '-' }}</p>
                            </td>
                            <td class="px-4 py-3 text-sm text-text-primary">{{ $notification->title }}</td>
                            <td class="px-4 py-3">
                                <x-badge variant="primary">{{ $notification->type_label }}</x-badge>
                            </td>
                            <td class="px-4 py-3">
                                @php
                                    $statusVariant = match($notification->status) {
                                        'unread' => 'warning', 'read' => 'success', 'archived' => 'default', default => 'default',
                                    };
                                @endphp
                                <x-status-badge :variant="$statusVariant" :label="$notification->status_label" />
                            </td>
                            <td class="px-4 py-3 text-sm text-text-muted">{{ $notification->created_at->format('M d, Y') }}</td>
                            <td class="px-4 py-3 text-right">
                                <button onclick="deleteNotification({{ $notification->id }})" class="w-8 h-8 rounded-lg hover:bg-red-50 flex items-center justify-center transition-colors" title="Delete">
                                    <svg class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center">
                                <x-empty-state message="No notifications found." />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($notifications->hasPages())
            <div class="px-4 py-3 border-t border-surface-border">
                {{ $notifications->links() }}
            </div>
        @endif
    </x-card>
</div>

@push('scripts')
<script>
async function deleteNotification(id) {
    confirmAction('Are you sure you want to delete this notification?', async () => {
        try {
            const response = await fetch(`/admin/notifications/${id}`, {
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
