@extends('layouts.doctor')

@section('title', 'Doctor Dashboard - Lakeshore Clinic')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-6">
    {{-- Welcome Banner --}}
    <div class="relative overflow-hidden rounded-2xl p-6 lg:p-8" style="background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 50%, #3b82f6 100%);">
        <div class="absolute top-0 right-0 w-64 h-64 opacity-10" style="background: radial-gradient(circle, white 0%, transparent 70%); transform: translate(30%, -30%);"></div>
        <div class="relative z-10">
            <h2 class="text-2xl font-bold text-white">Welcome back, {{ auth()->user()->name }}</h2>
            <p class="text-blue-100 mt-1 text-sm">Here's what's happening with your practice today.</p>
        </div>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach($stats as $stat)
            <div class="bg-white rounded-2xl p-5 border border-gray-100 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, {{ $stat['color'] === 'primary' ? '#eff6ff, #dbeafe' : ($stat['color'] === 'success' ? '#f0fdf4, #dcfce7' : ($stat['color'] === 'warning' ? '#fffbeb, #fef3c7' : '#f0f9ff, #e0f2fe')) }});">
                        @if($stat['label'] === 'Today\'s Appointments')
                            <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        @elseif($stat['label'] === 'Completed')
                            <svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        @elseif($stat['label'] === 'Pending')
                            <svg class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        @else
                            <svg class="w-5 h-5 text-sky-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        @endif
                    </div>
                    @if(isset($stat['trend']))
                        <span class="text-xs font-medium px-2 py-0.5 rounded-full {{ $stat['trendDirection'] === 'up' ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' }}">
                            {{ $stat['trendDirection'] === 'up' ? '+' : '' }}{{ $stat['trend'] }}
                        </span>
                    @endif
                </div>
                <p class="text-2xl font-bold text-gray-900">{{ $stat['value'] }}</p>
                <p class="text-xs text-gray-400 mt-1">{{ $stat['label'] }}</p>
            </div>
        @endforeach
    </div>

    {{-- Quick Actions + Recent Activity --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-sm font-bold text-gray-900">Quick Actions</h3>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                <a href="{{ route('doctor.availability') }}" class="group flex flex-col items-center gap-2.5 p-4 rounded-2xl border border-gray-100 hover:border-blue-200 hover:bg-blue-50/50 transition-all">
                    <div class="w-11 h-11 rounded-2xl flex items-center justify-center" style="background: linear-gradient(135deg, #eff6ff, #dbeafe);">
                        <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <span class="text-xs font-semibold text-gray-600 group-hover:text-blue-600 transition-colors">Manage Schedule</span>
                </a>
                <a href="{{ route('doctor.appointments') }}" class="group flex flex-col items-center gap-2.5 p-4 rounded-2xl border border-gray-100 hover:border-blue-200 hover:bg-blue-50/50 transition-all">
                    <div class="w-11 h-11 rounded-2xl flex items-center justify-center" style="background: linear-gradient(135deg, #f0fdf4, #dcfce7);">
                        <svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                    <span class="text-xs font-semibold text-gray-600 group-hover:text-blue-600 transition-colors">Appointments</span>
                </a>
                <a href="{{ route('doctor.consultations') }}" class="group flex flex-col items-center gap-2.5 p-4 rounded-2xl border border-gray-100 hover:border-blue-200 hover:bg-blue-50/50 transition-all">
                    <div class="w-11 h-11 rounded-2xl flex items-center justify-center" style="background: linear-gradient(135deg, #fffbeb, #fef3c7);">
                        <svg class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <span class="text-xs font-semibold text-gray-600 group-hover:text-blue-600 transition-colors">Consultations</span>
                </a>
                <a href="{{ route('doctor.prescriptions') }}" class="group flex flex-col items-center gap-2.5 p-4 rounded-2xl border border-gray-100 hover:border-blue-200 hover:bg-blue-50/50 transition-all">
                    <div class="w-11 h-11 rounded-2xl flex items-center justify-center" style="background: linear-gradient(135deg, #fdf4ff, #fae8ff);">
                        <svg class="w-5 h-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                    </div>
                    <span class="text-xs font-semibold text-gray-600 group-hover:text-blue-600 transition-colors">Prescriptions</span>
                </a>
                <a href="{{ route('doctor.meetings') }}" class="group flex flex-col items-center gap-2.5 p-4 rounded-2xl border border-gray-100 hover:border-blue-200 hover:bg-blue-50/50 transition-all">
                    <div class="w-11 h-11 rounded-2xl flex items-center justify-center" style="background: linear-gradient(135deg, #ecfdf5, #d1fae5);">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                    </div>
                    <span class="text-xs font-semibold text-gray-600 group-hover:text-blue-600 transition-colors">Meetings</span>
                </a>
                <a href="{{ route('doctor.profile') }}" class="group flex flex-col items-center gap-2.5 p-4 rounded-2xl border border-gray-100 hover:border-blue-200 hover:bg-blue-50/50 transition-all">
                    <div class="w-11 h-11 rounded-2xl flex items-center justify-center" style="background: linear-gradient(135deg, #f8fafc, #f1f5f9);">
                        <svg class="w-5 h-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <span class="text-xs font-semibold text-gray-600 group-hover:text-blue-600 transition-colors">My Profile</span>
                </a>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 p-6">
            <h3 class="text-sm font-bold text-gray-900 mb-4">Recent Activity</h3>
            <div class="space-y-0.5">
                @forelse($recentActivities as $activity)
                    <div class="flex items-start gap-3 p-3 rounded-xl hover:bg-gray-50 transition-colors">
                        <div class="w-2 h-2 rounded-full bg-blue-400 mt-2 flex-shrink-0"></div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-gray-700">{{ $activity['content'] }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">{{ $activity['time'] }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-400 text-center py-4">No recent activity</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Upcoming Events --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-5">
            <h3 class="text-sm font-bold text-gray-900">Upcoming Events</h3>
        </div>
        <div class="space-y-3">
            @forelse($upcomingEvents as $event)
                <div class="flex items-center gap-4 p-4 rounded-2xl border border-gray-100 hover:border-blue-100 hover:bg-blue-50/30 transition-all">
                    <div class="w-12 h-12 rounded-2xl flex flex-col items-center justify-center flex-shrink-0" style="background: linear-gradient(135deg, #eff6ff, #dbeafe);">
                        <span class="text-[10px] font-bold text-blue-600 leading-none">{{ \Carbon\Carbon::parse($event['date'])->format('M') }}</span>
                        <span class="text-lg font-bold text-blue-700 leading-none">{{ \Carbon\Carbon::parse($event['date'])->format('d') }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-900">{{ $event['title'] }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $event['time'] }} @if($event['description']) - {{ $event['description'] }} @endif</p>
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-400 text-center py-4">No upcoming events</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
