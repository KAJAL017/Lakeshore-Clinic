@extends('layouts.app')

@section('title', 'Admin Dashboard - Lakeshore Clinic')
@section('page-title', 'Admin Dashboard')

@section('content')
<div class="space-y-6">
    <x-page-header title="Dashboard">
        <x-slot name="subtitle">Welcome back, {{ auth()->user()->name }}</x-slot>
        <x-slot name="actions">
            <x-button variant="primary" size="sm">
                <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Export Report
            </x-button>
        </x-slot>
    </x-page-header>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
        @foreach($stats as $stat)
            <x-stat-card
                :label="$stat['label']"
                :value="$stat['value']"
                :trend="$stat['trend']"
                :trend-direction="$stat['trendDirection']"
                :color="$stat['color']"
            >
                <x-slot name="icon">
                    @if($stat['label'] === 'Total Patients')
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    @elseif($stat['label'] === 'Total Doctors')
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    @elseif(str_contains($stat['label'], 'Appointment') || str_contains($stat['label'], 'Clinic') || str_contains($stat['label'], 'Telemedicine'))
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    @elseif(str_contains($stat['label'], 'Revenue'))
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    @elseif(str_contains($stat['label'], 'Insurance'))
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    @else
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    @endif
                </x-slot>
            </x-stat-card>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 lg:gap-6">
        <x-card variant="default" class="lg:col-span-2">
            <div class="p-6">
                <x-page-header title="Quick Actions" />
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                    <a href="{{ route('admin.users.index') }}" class="flex flex-col items-center gap-2 p-4 rounded-xl border border-surface-border hover:border-primary-300 hover:bg-primary-50/50 transition-all group">
                        <div class="w-10 h-10 rounded-xl bg-primary-500/10 flex items-center justify-center text-primary-600 group-hover:bg-primary-500 group-hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </div>
                        <span class="text-xs font-medium text-text-secondary group-hover:text-primary-600 transition-colors text-center">Manage Users</span>
                    </a>
                    <a href="{{ route('admin.roles.index') }}" class="flex flex-col items-center gap-2 p-4 rounded-xl border border-surface-border hover:border-primary-300 hover:bg-primary-50/50 transition-all group">
                        <div class="w-10 h-10 rounded-xl bg-primary-500/10 flex items-center justify-center text-primary-600 group-hover:bg-primary-500 group-hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <span class="text-xs font-medium text-text-secondary group-hover:text-primary-600 transition-colors text-center">Manage Roles</span>
                    </a>
                    <a href="{{ route('admin.reviews') }}" class="flex flex-col items-center gap-2 p-4 rounded-xl border border-surface-border hover:border-primary-300 hover:bg-primary-50/50 transition-all group">
                        <div class="w-10 h-10 rounded-xl bg-primary-500/10 flex items-center justify-center text-primary-600 group-hover:bg-primary-500 group-hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        </div>
                        <span class="text-xs font-medium text-text-secondary group-hover:text-primary-600 transition-colors text-center">Review Appointments</span>
                    </a>
                    <a href="{{ route('admin.payments') }}" class="flex flex-col items-center gap-2 p-4 rounded-xl border border-surface-border hover:border-primary-300 hover:bg-primary-50/50 transition-all group">
                        <div class="w-10 h-10 rounded-xl bg-primary-500/10 flex items-center justify-center text-primary-600 group-hover:bg-primary-500 group-hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                        </div>
                        <span class="text-xs font-medium text-text-secondary group-hover:text-primary-600 transition-colors text-center">Payments</span>
                    </a>
                    <a href="{{ route('admin.notifications') }}" class="flex flex-col items-center gap-2 p-4 rounded-xl border border-surface-border hover:border-primary-300 hover:bg-primary-50/50 transition-all group">
                        <div class="w-10 h-10 rounded-xl bg-primary-500/10 flex items-center justify-center text-primary-600 group-hover:bg-primary-500 group-hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        </div>
                        <span class="text-xs font-medium text-text-secondary group-hover:text-primary-600 transition-colors text-center">Notifications</span>
                    </a>
                    <a href="{{ route('admin.settings') }}" class="flex flex-col items-center gap-2 p-4 rounded-xl border border-surface-border hover:border-primary-300 hover:bg-primary-50/50 transition-all group">
                        <div class="w-10 h-10 rounded-xl bg-primary-500/10 flex items-center justify-center text-primary-600 group-hover:bg-primary-500 group-hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <span class="text-xs font-medium text-text-secondary group-hover:text-primary-600 transition-colors text-center">Settings</span>
                    </a>
                </div>
            </div>
        </x-card>

        <x-card variant="default">
            <div class="p-6">
                <x-page-header title="Pending Items" />
                <div class="space-y-3">
                    @forelse($pendingItems as $item)
                        <div class="flex items-center justify-between p-3 bg-surface rounded-lg">
                            <span class="text-sm text-text-primary">{{ $item['title'] }}</span>
                            @if($item['count'] > 0)
                                <x-badge variant="warning">{{ $item['count'] }}</x-badge>
                            @else
                                <x-badge variant="success">0</x-badge>
                            @endif
                        </div>
                    @empty
                        <p class="text-sm text-text-muted">No pending items</p>
                    @endforelse
                </div>
            </div>
        </x-card>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6">
        <x-card variant="default">
            <div class="p-6">
                <x-page-header title="Recent Activity" />
                <div class="space-y-1">
                    @foreach($recentActivities as $activity)
                        <div class="flex items-start gap-3 p-3 rounded-lg hover:bg-surface transition-colors">
                            <div class="w-2 h-2 rounded-full bg-health-500 mt-2 flex-shrink-0"></div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-text-primary">{{ $activity['content'] }}</p>
                                <p class="text-xs text-text-muted mt-0.5">{{ $activity['time'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </x-card>

        <x-card variant="default">
            <div class="p-6">
                <x-page-header title="Upcoming Events">
                    <x-slot name="actions">
                        <x-button variant="ghost" size="sm">View All</x-button>
                    </x-slot>
                </x-page-header>
                <div class="space-y-3">
                    @foreach($upcomingEvents as $event)
                        <x-calendar-card
                            :title="$event['title']"
                            :date="$event['date']"
                            :time="$event['time']"
                            :description="$event['description']"
                        />
                    @endforeach
                </div>
            </div>
        </x-card>
    </div>

    <x-card variant="default">
        <div class="p-6">
            <x-page-header title="Calendar">
                <x-slot name="subtitle">{{ now()->format('F Y') }}</x-slot>
            </x-page-header>
            <div class="grid grid-cols-7 gap-px bg-surface-border rounded-lg overflow-hidden">
                @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                    <div class="bg-surface p-2 text-center text-xs font-semibold text-text-muted">{{ $day }}</div>
                @endforeach
                @for($i = 1; $i <= 35; $i++)
                    @php
                        $dayNum = $i <= 7 ? $i : ($i - 7 <= now()->daysInMonth ? $i - 7 : '');
                        $isToday = $dayNum == now()->day;
                    @endphp
                    <div class="bg-white p-2 min-h-[60px] {{ $isToday ? 'bg-primary-50' : '' }}">
                        @if($dayNum)
                            <span class="text-sm {{ $isToday ? 'font-bold text-primary-600' : 'text-text-secondary' }}">{{ $dayNum }}</span>
                        @endif
                    </div>
                @endfor
            </div>
        </div>
    </x-card>
</div>
@endsection
