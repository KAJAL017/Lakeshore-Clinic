@extends('layouts.doctor')

@section('title', 'Doctor Dashboard - Lakeshore Clinic')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <x-page-header title="Welcome back, {{ auth()->user()->name }}">
        <x-slot name="subtitle">Here's what's happening with your practice</x-slot>
    </x-page-header>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
        @foreach($stats as $stat)
            <x-stat-card
                :label="$stat['label']"
                :value="$stat['value']"
                :trend="$stat['trend']"
                :trend-direction="$stat['trendDirection']"
                :color="$stat['color']"
            />
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 lg:gap-6">
        <x-card variant="default" class="lg:col-span-2">
            <div class="p-6">
                <x-page-header title="Quick Actions" />
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                    <a href="{{ route('doctor.availability') }}" class="flex flex-col items-center gap-2 p-4 rounded-xl border border-surface-border hover:border-primary-300 hover:bg-primary-50/50 transition-all group">
                        <div class="w-10 h-10 rounded-xl bg-primary-500/10 flex items-center justify-center text-primary-600 group-hover:bg-primary-500 group-hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="text-xs font-medium text-text-secondary group-hover:text-primary-600 transition-colors">Manage Schedule</span>
                    </a>
                    <a href="{{ route('doctor.appointments') }}" class="flex flex-col items-center gap-2 p-4 rounded-xl border border-surface-border hover:border-primary-300 hover:bg-primary-50/50 transition-all group">
                        <div class="w-10 h-10 rounded-xl bg-primary-500/10 flex items-center justify-center text-primary-600 group-hover:bg-primary-500 group-hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <span class="text-xs font-medium text-text-secondary group-hover:text-primary-600 transition-colors">Appointments</span>
                    </a>
                    <a href="{{ route('doctor.consultations') }}" class="flex flex-col items-center gap-2 p-4 rounded-xl border border-surface-border hover:border-primary-300 hover:bg-primary-50/50 transition-all group">
                        <div class="w-10 h-10 rounded-xl bg-primary-500/10 flex items-center justify-center text-primary-600 group-hover:bg-primary-500 group-hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        </div>
                        <span class="text-xs font-medium text-text-secondary group-hover:text-primary-600 transition-colors">Consultations</span>
                    </a>
                    <a href="{{ route('doctor.prescriptions') }}" class="flex flex-col items-center gap-2 p-4 rounded-xl border border-surface-border hover:border-primary-300 hover:bg-primary-50/50 transition-all group">
                        <div class="w-10 h-10 rounded-xl bg-primary-500/10 flex items-center justify-center text-primary-600 group-hover:bg-primary-500 group-hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <span class="text-xs font-medium text-text-secondary group-hover:text-primary-600 transition-colors">Prescriptions</span>
                    </a>
                    <a href="{{ route('doctor.meetings') }}" class="flex flex-col items-center gap-2 p-4 rounded-xl border border-surface-border hover:border-primary-300 hover:bg-primary-50/50 transition-all group">
                        <div class="w-10 h-10 rounded-xl bg-primary-500/10 flex items-center justify-center text-primary-600 group-hover:bg-primary-500 group-hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        </div>
                        <span class="text-xs font-medium text-text-secondary group-hover:text-primary-600 transition-colors">Meetings</span>
                    </a>
                    <a href="{{ route('doctor.profile') }}" class="flex flex-col items-center gap-2 p-4 rounded-xl border border-surface-border hover:border-primary-300 hover:bg-primary-50/50 transition-all group">
                        <div class="w-10 h-10 rounded-xl bg-primary-500/10 flex items-center justify-center text-primary-600 group-hover:bg-primary-500 group-hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <span class="text-xs font-medium text-text-secondary group-hover:text-primary-600 transition-colors">My Profile</span>
                    </a>
                </div>
            </div>
        </x-card>

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
    </div>

    <x-card variant="default">
        <div class="p-6">
            <x-page-header title="Upcoming Events">
                <x-slot name="actions">
                    <x-button variant="ghost" size="sm">View All</x-button>
                </x-slot>
            </x-page-header>
            <div class="space-y-3">
                @forelse($upcomingEvents as $event)
                    <x-calendar-card
                        :title="$event['title']"
                        :date="$event['date']"
                        :time="$event['time']"
                        :description="$event['description']"
                    />
                @empty
                    <p class="text-sm text-text-muted text-center py-4">No upcoming events</p>
                @endforelse
            </div>
        </div>
    </x-card>
</div>
@endsection
