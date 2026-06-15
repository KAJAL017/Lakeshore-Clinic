@extends('layouts.doctor-mobile')

@section('title', 'Dashboard - Lakeshore Clinic')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-5">

    {{-- Greeting Header --}}
    <div class="bg-gradient-to-br from-[#1e3a5f] to-[#2d5a87] rounded-2xl p-5 text-white shadow-lg shadow-[#1e3a5f]/20">
        <div class="flex items-center justify-between">
            <div class="flex-1 min-w-0">
                <p class="text-white/70 text-sm font-medium">
                    Good {{ now()->format('H') < 12 ? 'Morning' : (now()->format('H') < 17 ? 'Afternoon' : 'Evening') }},
                </p>
                <h1 class="text-xl font-bold mt-0.5 truncate">Dr. {{ auth()->user()->name }}</h1>
                <p class="text-white/60 text-xs mt-1">Here's your practice overview</p>
            </div>
            <div class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0 ring-2 ring-white/30">
                @php $photo = $doctor->photo ?? null; @endphp
                @if($photo)
                    <img src="{{ asset('uploads/doctors/' . $photo) }}" alt="" class="w-full h-full rounded-full object-cover">
                @else
                    <span class="text-lg font-bold">{{ strtoupper(substr(auth()->user()->name ?? 'D', 0, 2)) }}</span>
                @endif
            </div>
        </div>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-2 gap-3">
        @foreach($stats as $stat)
            <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 active:scale-[0.97] transition-transform">
                <div class="flex items-center gap-2 mb-2">
                    @php
                        $iconColor = match($stat['color'] ?? 'primary') {
                            'primary' => 'bg-blue-50 text-blue-600',
                            'success' => 'bg-emerald-50 text-emerald-600',
                            'info' => 'bg-violet-50 text-violet-600',
                            'warning' => 'bg-amber-50 text-amber-600',
                            default => 'bg-gray-50 text-gray-600',
                        };
                    @endphp
                    <div class="w-8 h-8 rounded-lg {{ $iconColor }} flex items-center justify-center">
                        @if(($stat['color'] ?? '') === 'primary')
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        @elseif(($stat['color'] ?? '') === 'success')
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        @elseif(($stat['color'] ?? '') === 'info')
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        @else
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                        @endif
                    </div>
                </div>
                <p class="text-2xl font-bold text-gray-900">{{ $stat['value'] }}</p>
                <p class="text-xs text-gray-500 font-medium mt-0.5 leading-tight">{{ $stat['label'] }}</p>
            </div>
        @endforeach
    </div>

    {{-- Quick Actions --}}
    <div>
        <h2 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3 px-1">Quick Actions</h2>
        <div class="grid grid-cols-3 gap-3">
            <a href="{{ route('doctor.availability') }}" class="quick-action flex flex-col items-center gap-2.5 bg-white rounded-2xl py-4 shadow-sm border border-gray-100">
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center" style="background: linear-gradient(135deg, #3b82f6, #2563eb); box-shadow: 0 4px 14px rgba(59,130,246,0.3);">
                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <span class="text-xs font-semibold text-gray-700">Schedule</span>
            </a>
            <a href="{{ route('doctor.appointments') }}" class="quick-action flex flex-col items-center gap-2.5 bg-white rounded-2xl py-4 shadow-sm border border-gray-100">
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center" style="background: linear-gradient(135deg, #10b981, #059669); box-shadow: 0 4px 14px rgba(16,185,129,0.3);">
                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <span class="text-xs font-semibold text-gray-700">Appointments</span>
            </a>
            <a href="{{ route('doctor.consultations') }}" class="quick-action flex flex-col items-center gap-2.5 bg-white rounded-2xl py-4 shadow-sm border border-gray-100">
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed); box-shadow: 0 4px 14px rgba(139,92,246,0.3);">
                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <span class="text-xs font-semibold text-gray-700">Consults</span>
            </a>
            <a href="{{ route('doctor.prescriptions') }}" class="quick-action flex flex-col items-center gap-2.5 bg-white rounded-2xl py-4 shadow-sm border border-gray-100">
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center" style="background: linear-gradient(135deg, #f59e0b, #d97706); box-shadow: 0 4px 14px rgba(245,158,11,0.3);">
                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                </div>
                <span class="text-xs font-semibold text-gray-700">Prescriptions</span>
            </a>
            <a href="{{ route('doctor.meetings') }}" class="quick-action flex flex-col items-center gap-2.5 bg-white rounded-2xl py-4 shadow-sm border border-gray-100">
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center" style="background: linear-gradient(135deg, #06b6d4, #0891b2); box-shadow: 0 4px 14px rgba(6,182,212,0.3);">
                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                </div>
                <span class="text-xs font-semibold text-gray-700">Meetings</span>
            </a>
            <a href="{{ route('doctor.time-slots') }}" class="quick-action flex flex-col items-center gap-2.5 bg-white rounded-2xl py-4 shadow-sm border border-gray-100">
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center" style="background: linear-gradient(135deg, #f43f5e, #e11d48); box-shadow: 0 4px 14px rgba(244,63,94,0.3);">
                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0zM8 14v.01M12 14v.01M16 14v.01M8 18v.01M12 18v.01M16 18v.01"/></svg>
                </div>
                <span class="text-xs font-semibold text-gray-700">Time Slots</span>
            </a>
        </div>
    </div>

    {{-- Recent Activity --}}
    <div>
        <div class="flex items-center justify-between mb-3 px-1">
            <h2 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Recent Activity</h2>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            @forelse($recentActivities as $activity)
                <div class="flex items-start gap-3 px-4 py-3.5 {{ !$loop->last ? 'border-b border-gray-50' : '' }}">
                    <div class="w-2 h-2 rounded-full {{ $loop->first ? 'bg-[#1e3a5f]' : 'bg-gray-300' }} mt-1.5 flex-shrink-0"></div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm text-gray-800 font-medium leading-snug">{{ $activity['content'] }}</p>
                        <p class="text-[11px] text-gray-400 mt-0.5">{{ $activity['time'] }}</p>
                    </div>
                </div>
            @empty
                <div class="px-4 py-8 text-center">
                    <svg class="w-10 h-10 text-gray-200 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="text-xs text-gray-400">No recent activity</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Upcoming Events --}}
    <div>
        <div class="flex items-center justify-between mb-3 px-1">
            <h2 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Upcoming Events</h2>
        </div>
        <div class="space-y-2.5">
            @forelse($upcomingEvents as $event)
                <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex items-center gap-3 active:bg-gray-50 transition-colors">
                    <div class="w-12 h-12 rounded-xl bg-[#1e3a5f]/5 flex flex-col items-center justify-center flex-shrink-0">
                        <span class="text-[10px] font-bold text-[#1e3a5f]/60 uppercase leading-none">{{ \Carbon\Carbon::parse($event['date'])->format('M') }}</span>
                        <span class="text-lg font-bold text-[#1e3a5f] leading-none mt-0.5">{{ \Carbon\Carbon::parse($event['date'])->format('d') }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-900 truncate">{{ $event['title'] }}</p>
                        <div class="flex items-center gap-1.5 mt-0.5">
                            <svg class="w-3 h-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span class="text-[11px] text-gray-500">{{ $event['time'] }}</span>
                        </div>
                        @if(!empty($event['description']))
                            <p class="text-[11px] text-gray-400 mt-0.5 truncate">{{ $event['description'] }}</p>
                        @endif
                    </div>
                    <svg class="w-4 h-4 text-gray-300 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </div>
            @empty
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 text-center">
                    <svg class="w-10 h-10 text-gray-200 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <p class="text-xs text-gray-400">No upcoming events</p>
                </div>
            @endforelse
        </div>
    </div>

</div>

<style>
.scrollbar-hide::-webkit-scrollbar { display: none; }
.scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
.quick-action { transition: transform 0.15s ease, box-shadow 0.15s ease; }
.quick-action:active { transform: scale(0.93); box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
</style>
@endsection
