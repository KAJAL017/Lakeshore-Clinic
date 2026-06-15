@extends('layouts.patient')

@section('title', 'Notifications - Lakeshore Clinic')
@section('page-title', 'Notifications')

@section('content')
<div class="space-y-6">
    <x-page-header title="Notifications">
        <x-slot name="subtitle">You have {{ $unreadCount }} unread notifications</x-slot>
        <x-slot name="actions">
            @if($unreadCount > 0)
                <form method="POST" action="{{ route('notifications.mark-all-read') }}">
                    @csrf
                    <x-button variant="outline" size="sm" type="submit">Mark All as Read</x-button>
                </form>
            @endif
        </x-slot>
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
                <x-button variant="primary" size="sm" type="submit">Filter</x-button>
            </div>
        </form>
    </x-card>

    <x-card variant="default">
        <div class="divide-y divide-surface-border">
            @forelse($notifications as $notification)
                <div class="p-4 hover:bg-surface transition-colors cursor-pointer {{ $notification->status === 'unread' ? 'bg-primary-50/50' : '' }}" onclick="viewNotification({{ $notification->id }})">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-full {{ $notification->status === 'unread' ? 'bg-primary-500/20' : 'bg-surface' }} flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 {{ $notification->status === 'unread' ? 'text-primary-600' : 'text-text-muted' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2">
                                <p class="text-sm font-medium text-text-primary {{ $notification->status === 'unread' ? 'font-semibold' : '' }}">{{ $notification->title }}</p>
                                @if($notification->status === 'unread')
                                    <span class="w-2 h-2 rounded-full bg-primary-500"></span>
                                @endif
                            </div>
                            <p class="text-sm text-text-muted mt-0.5 line-clamp-2">{{ $notification->message }}</p>
                            <div class="flex items-center gap-3 mt-1">
                                <span class="text-xs text-text-muted">{{ $notification->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-1">
                            @if($notification->status === 'unread')
                                <button onclick="event.stopPropagation(); markRead({{ $notification->id }})" class="w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center justify-center transition-colors" title="Mark as Read">
                                    <svg class="w-4 h-4 text-text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center">
                    <x-empty-state message="No notifications found." />
                </div>
            @endforelse
        </div>
        @if($notifications->hasPages())
            <div class="px-4 py-3 border-t border-surface-border">
                {{ $notifications->links() }}
            </div>
        @endif
    </x-card>
</div>

<x-modal id="view-notification" title="Notification Details">
    <div id="notification-content" class="space-y-4"></div>
</x-modal>

@push('scripts')
<script>
async function viewNotification(id) {
    try {
        const response = await fetch(`/patient/notifications/${id}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
        });
        const data = await response.json();

        if (data.success) {
            const n = data.notification;
            document.getElementById('notification-content').innerHTML = `
                <div class="space-y-3">
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${n.status === 'unread' ? 'bg-primary-100 text-primary-800' : 'bg-gray-100 text-gray-800'}">${n.type_label}</span>
                        <span class="text-xs text-text-muted">${new Date(n.created_at).toLocaleString()}</span>
                    </div>
                    <h3 class="text-lg font-semibold text-text-primary">${n.title}</h3>
                    <p class="text-sm text-text-secondary">${n.message}</p>
                </div>
            `;
            openModal('modal-view-notification');
        }
    } catch (error) {
        showToast('Failed to load notification.', 'error');
    }
}

async function markRead(id) {
    try {
        const response = await fetch(`/patient/notifications/${id}/read`, {
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
            setTimeout(() => location.reload(), 500);
        }
    } catch (error) {
        showToast('An error occurred.', 'error');
    }
}
</script>
@endpush
@endsection
