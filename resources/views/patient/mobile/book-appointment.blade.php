@extends('layouts.patient-mobile')

@section('title', 'Book Appointment - Lakeshore Clinic')
@section('page-title', 'Book Appointment')

@section('content')
<div class="space-y-4">
    <a href="{{ route('patient.dashboard') }}" class="inline-flex items-center gap-2 text-sm text-[#0d9488] font-medium">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Back
    </a>

    <div class="space-y-3">
        <a href="{{ route('patient.booking') }}" class="mobile-card flex items-center gap-4 bg-white rounded-xl p-4 shadow-sm border border-surface-border">
            <div class="w-12 h-12 rounded-xl bg-primary-50 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14m14 0h2m-2 0h-5m-9 0H3a2 2 0 01-2-2v-2a2 2 0 012-2h3.93a2 2 0 01.824.132l2.448 1.224a2 2 0 001.256.268h3.414a2 2 0 012.121 1.293l1.586 1.586a1 1 0 01.293.707V19a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a1 1 0 01.293-.707l1.586-1.586a1 1 0 01.707-.293h3.414a1 1 0 00.707-.293l2.448-1.224a1 1 0 00.495-.268z"/></svg>
            </div>
            <div class="flex-1">
                <p class="text-sm font-semibold text-text-primary">Clinic Visit</p>
                <p class="text-xs text-text-muted">Book an in-person appointment</p>
            </div>
            <svg class="w-5 h-5 text-text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>

        <a href="{{ route('patient.telemedicine') }}" class="mobile-card flex items-center gap-4 bg-white rounded-xl p-4 shadow-sm border border-surface-border">
            <div class="w-12 h-12 rounded-xl bg-[#1e3a5f]/10 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-[#1e3a5f]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
            </div>
            <div class="flex-1">
                <p class="text-sm font-semibold text-text-primary">Telemedicine</p>
                <p class="text-xs text-text-muted">Virtual consultation</p>
            </div>
            <svg class="w-5 h-5 text-text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
    </div>
</div>
@endsection
