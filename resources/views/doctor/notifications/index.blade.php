@extends('layouts.doctor')

@section('title', 'Notifications - Lakeshore Clinic')
@section('page-title', 'Notifications')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <p class="text-sm text-gray-400">Stay updated with your latest activities</p>
        <button onclick="markAllRead()" class="px-4 py-2.5 text-sm font-medium text-blue-600 hover:bg-blue-50 rounded-xl transition-colors">Mark All Read</button>
    </div>

    {{-- Filters --}}
    <div class="flex items-center gap-3">
        <div class="flex-1">
            <input type="text" id="search-input" placeholder="Search notifications..."
                class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-colors bg-white"
                value="{{ request('search') }}" onkeyup="filterNotifications()">
        </div>
        <select id="status-filter" onchange="filterNotifications()" class="px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-colors bg-white">
            <option value="">All Status</option>
            <option value="unread" {{ request('status') === 'unread' ? 'selected' : '' }}>Unread</option>
            <option value="read" {{ request('status') === 'read' ? 'selected' : '' }}>Read</option>
            <option value="archived" {{ request('status') === 'archived' ? 'selected' : '' }}>Archived</option>
        </select>
    </div>

    @if($unreadCount > 0)
        <div class="bg-blue-50 border border-blue-100 rounded-2xl px-5 py-4 flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: linear-gradient(135deg, #dbeafe, #bfdbfe);">
                <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
            </div>
            <span class="text-sm text-blue-700">You have <strong>{{ $unreadCount }}</strong> unread notification{{ $unreadCount > 1 ? 's' : '' }}</span>
        </div>
    @endif

    {{-- Notifications List --}}
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <div class="divide-y divide-gray-50">
            @forelse($notifications as $notification)
                <div id="notification-{{ $notification->id }}" class="px-5 py-4 hover:bg-gray-50/50 transition-colors {{ $notification->status === 'unread' ? 'bg-blue-50/30' : '' }}">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 mt-1.5">
                            @if($notification->status === 'unread')
                                <div class="w-2.5 h-2.5 rounded-full" style="background: linear-gradient(135deg, #3b82f6, #2563eb);"></div>
                            @else
                                <div class="w-2.5 h-2.5 rounded-full bg-gray-200"></div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900 {{ $notification->status === 'unread' ? '' : 'font-normal' }}">{{ $notification->title }}</p>
                            <p class="text-sm text-gray-500 mt-1">{{ $notification->message }}</p>
                            <div class="flex items-center gap-3 mt-2">
                                <span class="text-xs text-gray-400">{{ $notification->created_at->diffForHumans() }}</span>
                                @if($notification->type)
                                    <span class="px-2 py-0.5 text-xs font-medium rounded-lg bg-gray-100 text-gray-500">{{ ucfirst(str_replace('_', ' ', $notification->type)) }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="flex-shrink-0 flex items-center gap-1">
                            @if($notification->status === 'unread')
                                <button onclick="markRead({{ $notification->id }})" class="px-2.5 py-1 text-xs font-medium text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">Mark Read</button>
                            @endif
                            @if($notification->status !== 'archived')
                                <button onclick="archiveNotification({{ $notification->id }})" class="px-2.5 py-1 text-xs font-medium text-gray-400 hover:bg-gray-100 rounded-lg transition-colors">Archive</button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="px-5 py-16 text-center">
                    <div class="flex flex-col items-center">
                        <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center mb-4"><svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg></div>
                        <p class="text-sm font-medium text-gray-900">No notifications</p>
                        <p class="text-xs text-gray-400 mt-1">No notifications found.</p>
                    </div>
                </div>
            @endforelse
        </div>
        @if($notifications->hasPages())
            <div class="px-5 py-4 border-t border-gray-100">{{ $notifications->links() }}</div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function filterNotifications() {
    const search = document.getElementById('search-input').value;
    const status = document.getElementById('status-filter').value;
    const params = new URLSearchParams();
    if (search) params.set('search', search);
    if (status) params.set('status', status);
    window.location.href = '{{ route("doctor.notifications") }}?' + params.toString();
}

async function markRead(id) {
    try {
        const response = await fetch(`/doctor/notifications/${id}/read`, { method: 'PUT', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } });
        const data = await response.json();
        if (data.success) { const el = document.getElementById(`notification-${id}`); if (el) el.classList.remove('bg-blue-50/30'); showToast('Notification marked as read.', 'success'); }
    } catch (error) { showToast('Failed to update notification.', 'error'); }
}

async function archiveNotification(id) {
    try {
        const response = await fetch(`/doctor/notifications/${id}/archive`, { method: 'PUT', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } });
        const data = await response.json();
        if (data.success) { const el = document.getElementById(`notification-${id}`); if (el) el.style.opacity = '0.5'; showToast('Notification archived.', 'success'); }
    } catch (error) { showToast('Failed to archive notification.', 'error'); }
}

async function markAllRead() {
    try {
        const response = await fetch('/doctor/notifications/mark-all-read', { method: 'POST', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } });
        const data = await response.json();
        if (data.success) { showToast('All notifications marked as read.', 'success'); setTimeout(() => location.reload(), 1000); }
    } catch (error) { showToast('Failed to mark all as read.', 'error'); }
}
</script>
@endpush
@endsection
