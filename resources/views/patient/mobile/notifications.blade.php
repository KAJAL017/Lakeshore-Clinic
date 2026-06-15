@extends('layouts.patient-mobile')

@section('title', 'Notifications - Lakeshore Clinic')
@section('page-title', 'Notifications')

@section('content')
<div class="space-y-4">
    @forelse($notifications as $notification)
    <div class="mobile-card bg-white rounded-xl p-4 shadow-sm border border-surface-border {{ $notification->status === 'unread' ? 'border-l-4 border-l-[#0d9488]' : '' }}">
        <div class="flex items-start gap-3">
            <div class="w-10 h-10 rounded-full {{ $notification->status === 'unread' ? 'bg-[#0d9488]/10' : 'bg-surface' }} flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 {{ $notification->status === 'unread' ? 'text-[#0d9488]' : 'text-text-muted' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-text-primary">{{ $notification->title }}</p>
                <p class="text-xs text-text-muted mt-0.5 line-clamp-2">{{ $notification->message }}</p>
                <p class="text-xs text-text-muted mt-1">{{ $notification->created_at->diffForHumans() }}</p>
            </div>
        </div>
    </div>
    @empty
    <div class="text-center py-12">
        <svg class="w-16 h-16 text-text-muted mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
        <p class="text-text-muted">No notifications</p>
    </div>
    @endforelse
</div>
@endsection
