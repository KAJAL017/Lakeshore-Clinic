@extends('layouts.doctor-mobile')

@section('title', 'Notifications - Lakeshore Clinic')
@section('page-title', 'Notifications')

@section('content')
<div class="space-y-4" x-data="notificationManager()">

    {{-- Page Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-text-primary">Notifications</h2>
            <p class="text-sm text-text-muted mt-0.5">{{ $notifications->total() }} notification{{ $notifications->total() !== 1 ? 's' : '' }}</p>
        </div>
        @if($unreadCount > 0)
        <button onclick="markAllRead()" id="mark-all-btn" class="flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-[#1e3a5f]/10 text-[#1e3a5f] text-sm font-semibold active:bg-[#1e3a5f]/20 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            Read All
        </button>
        @endif
    </div>

    {{-- Unread Count Banner --}}
    @if($unreadCount > 0)
    <div id="unread-banner" class="flex items-center gap-3 p-3.5 rounded-2xl bg-gradient-to-r from-[#1e3a5f] to-[#2d5a87] text-white shadow-lg">
        <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
        </div>
        <div class="flex-1 min-w-0">
            <p class="text-sm font-semibold">You have unread notifications</p>
            <p class="text-xs text-white/70 mt-0.5">{{ $unreadCount }} unread message{{ $unreadCount !== 1 ? 's' : '' }}</p>
        </div>
    </div>
    @endif

    {{-- Filter Chips --}}
    <div class="relative -mx-4 px-4">
        <div class="flex gap-2 overflow-x-auto pb-2 scrollbar-hide" id="filter-scroll">
            <button onclick="filterNotifications('all')" class="filter-btn active px-4 py-2.5 rounded-xl text-sm font-semibold whitespace-nowrap transition-all duration-200" data-filter="all">
                All
            </button>
            <button onclick="filterNotifications('unread')" class="filter-btn px-4 py-2.5 rounded-xl text-sm font-semibold whitespace-nowrap transition-all duration-200" data-filter="unread">
                <span class="flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                    Unread
                </span>
            </button>
            <button onclick="filterNotifications('read')" class="filter-btn px-4 py-2.5 rounded-xl text-sm font-semibold whitespace-nowrap transition-all duration-200" data-filter="read">
                Read
            </button>
            <button onclick="filterNotifications('archived')" class="filter-btn px-4 py-2.5 rounded-xl text-sm font-semibold whitespace-nowrap transition-all duration-200" data-filter="archived">
                Archived
            </button>
        </div>
    </div>

    {{-- Notifications List --}}
    <div id="notifications-list" class="space-y-3">
        @forelse($notifications as $notification)
            @php
                $isUnread = $notification->status === 'unread';
                $typeConfig = match($notification->type) {
                    'system' => ['bg' => 'bg-slate-100', 'text' => 'text-slate-600', 'icon' => 'cog'],
                    'appointment' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-600', 'icon' => 'calendar'],
                    'payment' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-600', 'icon' => 'currency'],
                    'insurance' => ['bg' => 'bg-purple-50', 'text' => 'text-purple-600', 'icon' => 'shield'],
                    'prescription' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-600', 'icon' => 'document'],
                    'telemedicine' => ['bg' => 'bg-[#1e3a5f]/10', 'text' => 'text-[#1e3a5f]', 'icon' => 'video'],
                    'general' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-600', 'icon' => 'info'],
                    default => ['bg' => 'bg-gray-100', 'text' => 'text-gray-600', 'icon' => 'bell'],
                };
            @endphp

            <div class="notification-card mobile-card bg-white rounded-2xl shadow-sm border border-surface-border overflow-hidden {{ $isUnread ? 'border-l-4 border-l-blue-500' : '' }} transition-all duration-200"
                 data-status="{{ $notification->status }}"
                 data-type="{{ $notification->type }}"
                 data-id="{{ $notification->id }}">

                <div class="p-4 pb-3">
                    <div class="flex items-start gap-3">
                        {{-- Notification Icon --}}
                        <div class="relative flex-shrink-0">
                            <div class="w-11 h-11 rounded-2xl {{ $isUnread ? $typeConfig['bg'] : 'bg-surface' }} flex items-center justify-center">
                                @if($typeConfig['icon'] === 'calendar')
                                    <svg class="w-5 h-5 {{ $isUnread ? $typeConfig['text'] : 'text-text-muted' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                @elseif($typeConfig['icon'] === 'currency')
                                    <svg class="w-5 h-5 {{ $isUnread ? $typeConfig['text'] : 'text-text-muted' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                @elseif($typeConfig['icon'] === 'shield')
                                    <svg class="w-5 h-5 {{ $isUnread ? $typeConfig['text'] : 'text-text-muted' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                @elseif($typeConfig['icon'] === 'document')
                                    <svg class="w-5 h-5 {{ $isUnread ? $typeConfig['text'] : 'text-text-muted' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                @elseif($typeConfig['icon'] === 'video')
                                    <svg class="w-5 h-5 {{ $isUnread ? $typeConfig['text'] : 'text-text-muted' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                @elseif($typeConfig['icon'] === 'cog')
                                    <svg class="w-5 h-5 {{ $isUnread ? $typeConfig['text'] : 'text-text-muted' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                @else
                                    <svg class="w-5 h-5 {{ $isUnread ? $typeConfig['text'] : 'text-text-muted' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                                @endif
                            </div>
                            {{-- Unread Dot --}}
                            @if($isUnread)
                            <span class="absolute -top-0.5 -right-0.5 w-3 h-3 rounded-full bg-blue-500 border-2 border-white"></span>
                            @endif
                        </div>

                        {{-- Notification Content --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-2">
                                <div class="min-w-0">
                                    <p class="text-[15px] {{ $isUnread ? 'font-bold' : 'font-semibold' }} text-text-primary leading-snug">{{ $notification->title }}</p>
                                    <p class="text-sm text-text-muted mt-1 leading-relaxed line-clamp-2">{{ $notification->message }}</p>
                                </div>
                            </div>

                            {{-- Meta Row --}}
                            <div class="flex items-center gap-2.5 mt-2.5">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-semibold {{ $typeConfig['bg'] }} {{ $typeConfig['text'] }}">
                                    {{ $notification->type_label }}
                                </span>
                                <span class="text-xs text-text-muted">{{ $notification->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card Actions --}}
                @if($notification->status !== 'archived')
                <div class="px-4 py-3 bg-gray-50/50 border-t border-surface-border flex gap-2">
                    @if($isUnread)
                    <button onclick="markRead({{ $notification->id }})" class="flex-1 flex items-center justify-center gap-1.5 py-2.5 text-sm font-semibold text-[#1e3a5f] bg-[#1e3a5f]/10 rounded-xl active:bg-[#1e3a5f]/20 transition-colors" data-action="mark-read">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Mark Read
                    </button>
                    @endif
                    <button onclick="archiveNotification({{ $notification->id }})" class="{{ $isUnread ? 'flex-1' : 'w-full' }} flex items-center justify-center gap-1.5 py-2.5 text-sm font-semibold text-gray-600 bg-gray-100 rounded-xl active:bg-gray-200 transition-colors" data-action="archive">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                        Archive
                    </button>
                </div>
                @endif
            </div>
        @empty
            {{-- Empty State --}}
            <div class="text-center py-16 px-4" id="empty-state">
                <div class="w-24 h-24 mx-auto rounded-3xl bg-gradient-to-br from-[#1e3a5f]/10 to-[#2d5a87]/5 flex items-center justify-center mb-5">
                    <svg class="w-12 h-12 text-[#1e3a5f]/60" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                </div>
                <h3 class="text-lg font-bold text-text-primary mb-2">All Caught Up</h3>
                <p class="text-sm text-text-muted mb-6 max-w-[240px] mx-auto">No notifications right now. We'll let you know when something needs your attention.</p>
            </div>
        @endforelse

        {{-- Filter Empty State (hidden by default) --}}
        <div class="text-center py-16 px-4 hidden" id="filter-empty-state">
            <div class="w-20 h-20 mx-auto rounded-2xl bg-surface flex items-center justify-center mb-4">
                <svg class="w-10 h-10 text-text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <h3 class="text-base font-semibold text-text-primary mb-1">No notifications found</h3>
            <p class="text-sm text-text-muted">Try a different filter</p>
        </div>
    </div>

    {{-- Pagination --}}
    @if($notifications->hasPages())
    <div class="pt-2">
        {{ $notifications->links('vendor.pagination.mobile-simple') }}
    </div>
    @endif
</div>

@push('styles')
<style>
    .scrollbar-hide::-webkit-scrollbar { display: none; }
    .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }

    .filter-btn {
        background: white;
        color: #475569;
        border: 1.5px solid #e2e8f0;
    }
    .filter-btn.active {
        background: #1e3a5f;
        color: white;
        border-color: #1e3a5f;
        box-shadow: 0 2px 8px rgba(30, 58, 95, 0.3);
    }

    .notification-card {
        will-change: transform;
    }
    .notification-card:active {
        transform: scale(0.98);
    }

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    @keyframes fadeOut {
        from { opacity: 1; transform: translateY(0); }
        to { opacity: 0; transform: translateY(-10px); height: 0; padding: 0; margin: 0; overflow: hidden; }
    }
    .notification-card.removing {
        animation: fadeOut 0.3s ease-out forwards;
    }

    @keyframes pulse-dot {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
    .unread-dot {
        animation: pulse-dot 2s ease-in-out infinite;
    }
</style>
@endpush

@push('scripts')
<script>
let currentFilter = 'all';

function filterNotifications(filter) {
    currentFilter = filter;

    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    const activeBtn = document.querySelector(`.filter-btn[data-filter="${filter}"]`);
    if (activeBtn) activeBtn.classList.add('active');

    const cards = document.querySelectorAll('.notification-card');
    let visibleCount = 0;

    cards.forEach(card => {
        const status = card.dataset.status;
        let show = false;

        if (filter === 'all') {
            show = true;
        } else {
            show = status === filter;
        }

        card.style.display = show ? 'block' : 'none';
        if (show) visibleCount++;
    });

    const filterEmpty = document.getElementById('filter-empty-state');
    const mainEmpty = document.getElementById('empty-state');

    if (filterEmpty) {
        filterEmpty.classList.toggle('hidden', visibleCount > 0);
    }
    if (mainEmpty) {
        mainEmpty.classList.add('hidden');
    }
}

async function markRead(id) {
    const card = document.querySelector(`.notification-card[data-id="${id}"]`);
    if (!card) return;

    const btn = card.querySelector('[data-action="mark-read"]');
    if (btn) {
        btn.innerHTML = '<div class="w-4 h-4 border-2 border-[#1e3a5f] border-t-transparent rounded-full animate-spin"></div>';
        btn.disabled = true;
    }

    try {
        const response = await fetch(`/doctor/notifications/${id}/read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
        });
        const data = await response.json();

        if (data.success) {
            card.classList.remove('border-l-4', 'border-l-blue-500');
            card.dataset.status = 'read';

            const dot = card.querySelector('.unread-dot, span.absolute');
            if (dot) dot.remove();

            const titleEl = card.querySelector('.text-\\[15px\\]');
            if (titleEl) {
                titleEl.classList.remove('font-bold');
                titleEl.classList.add('font-semibold');
            }

            const actionsRow = card.querySelector('.px-4.py-3.flex');
            if (actionsRow) {
                const markReadBtn = actionsRow.querySelector('[data-action="mark-read"]');
                if (markReadBtn) markReadBtn.remove();
            }

            updateUnreadCount(-1);
            showToast('Notification marked as read', 'success');
        } else {
            showToast(data.message || 'Failed to mark notification', 'error');
            if (btn) {
                btn.innerHTML = '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Mark Read';
                btn.disabled = false;
            }
        }
    } catch (error) {
        showToast('An error occurred. Please try again.', 'error');
        if (btn) {
            btn.innerHTML = '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Mark Read';
            btn.disabled = false;
        }
    }
}

async function archiveNotification(id) {
    const card = document.querySelector(`.notification-card[data-id="${id}"]`);
    if (!card) return;

    const btn = card.querySelector('[data-action="archive"]');
    if (btn) {
        btn.innerHTML = '<div class="w-4 h-4 border-2 border-gray-400 border-t-transparent rounded-full animate-spin"></div>';
        btn.disabled = true;
    }

    try {
        const response = await fetch(`/doctor/notifications/${id}/archive`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
        });
        const data = await response.json();

        if (data.success) {
            card.classList.add('removing');
            const wasUnread = card.dataset.status === 'unread';

            setTimeout(() => {
                card.remove();
                updateUnreadCount(wasUnread ? -1 : 0);
                checkEmpty();
            }, 300);

            showToast('Notification archived', 'success');
        } else {
            showToast(data.message || 'Failed to archive notification', 'error');
            if (btn) {
                btn.innerHTML = '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg> Archive';
                btn.disabled = false;
            }
        }
    } catch (error) {
        showToast('An error occurred. Please try again.', 'error');
        if (btn) {
            btn.innerHTML = '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg> Archive';
            btn.disabled = false;
        }
    }
}

async function markAllRead() {
    const btn = document.getElementById('mark-all-btn');
    if (btn) {
        btn.disabled = true;
        btn.innerHTML = '<div class="w-4 h-4 border-2 border-[#1e3a5f] border-t-transparent rounded-full animate-spin"></div> Loading...';
    }

    try {
        const response = await fetch('/doctor/notifications/mark-all-read', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
        });
        const data = await response.json();

        if (data.success) {
            document.querySelectorAll('.notification-card[data-status="unread"]').forEach(card => {
                card.classList.remove('border-l-4', 'border-l-blue-500');
                card.dataset.status = 'read';

                const dot = card.querySelector('.unread-dot, span.absolute');
                if (dot) dot.remove();

                const titleEl = card.querySelector('.text-\\[15px\\]');
                if (titleEl) {
                    titleEl.classList.remove('font-bold');
                    titleEl.classList.add('font-semibold');
                }

                const actionsRow = card.querySelector('.px-4.py-3.flex');
                if (actionsRow) {
                    const markReadBtn = actionsRow.querySelector('[data-action="mark-read"]');
                    if (markReadBtn) markReadBtn.remove();
                }
            });

            const banner = document.getElementById('unread-banner');
            if (banner) banner.remove();

            if (btn) btn.remove();

            updateUnreadCount(0, true);
            showToast('All notifications marked as read', 'success');
        } else {
            showToast(data.message || 'Failed to mark all as read', 'error');
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Read All';
            }
        }
    } catch (error) {
        showToast('An error occurred. Please try again.', 'error');
        if (btn) {
            btn.disabled = false;
            btn.innerHTML = '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Read All';
        }
    }
}

function updateUnreadCount(change, reset = false) {
    const countEl = document.querySelector('p.text-sm.text-text-muted.mt-0\\.5');
    if (!countEl) return;

    if (reset) {
        const total = document.querySelectorAll('.notification-card').length;
        countEl.textContent = `${total} notification${total !== 1 ? 's' : ''}`;
    } else {
        const currentText = countEl.textContent;
        const currentTotal = parseInt(currentText) || 0;
        const newTotal = currentTotal + change;
        countEl.textContent = `${newTotal} notification${newTotal !== 1 ? 's' : ''}`;
    }
}

function checkEmpty() {
    const visibleCards = document.querySelectorAll('.notification-card:not([style*="display: none"])');
    if (visibleCards.length === 0) {
        const emptyState = document.getElementById('empty-state');
        if (emptyState) {
            emptyState.classList.remove('hidden');
        }
    }
}

function showToast(message, type = 'info') {
    const container = document.getElementById('toast-container');
    if (!container) return;

    const colors = {
        success: 'bg-emerald-500',
        error: 'bg-red-500',
        warning: 'bg-amber-500',
        info: 'bg-blue-500',
    };
    const icons = {
        success: '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>',
        error: '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>',
        warning: '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>',
        info: '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
    };

    const toast = document.createElement('div');
    toast.className = `flex items-center gap-3 px-4 py-3 rounded-xl shadow-lg text-white text-sm font-medium ${colors[type] || colors.info} transform transition-all duration-300 translate-y-[-20px] opacity-0`;
    toast.innerHTML = `
        ${icons[type] || icons.info}
        <span class="flex-1">${message}</span>
        <button onclick="this.parentElement.remove()" class="ml-2 opacity-70 hover:opacity-100">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    `;
    container.appendChild(toast);

    requestAnimationFrame(() => {
        toast.classList.remove('translate-y-[-20px]', 'opacity-0');
        toast.classList.add('translate-y-0', 'opacity-100');
    });

    setTimeout(() => {
        toast.classList.add('translate-y-[-20px]', 'opacity-0');
        setTimeout(() => toast.remove(), 300);
    }, 4000);
}

function notificationManager() {
    return {};
}
</script>
@endpush
@endsection
