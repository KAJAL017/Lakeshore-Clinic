@extends('layouts.patient-mobile')

@section('title', 'Medical Records - Lakeshore Clinic')
@section('page-title', 'Medical Records')

@section('content')
<div class="space-y-4">
    <div class="space-y-3">
        <a href="{{ route('patient.medical-records.documents') }}" class="mobile-card flex items-center gap-4 bg-white rounded-xl p-4 shadow-sm border border-surface-border">
            <div class="w-12 h-12 rounded-xl bg-primary-50 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <div class="flex-1">
                <p class="text-sm font-semibold text-text-primary">Medical Documents</p>
                <p class="text-xs text-text-muted">View and download documents</p>
            </div>
            <svg class="w-5 h-5 text-text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>

        <a href="{{ route('patient.medical-records.consultations') }}" class="mobile-card flex items-center gap-4 bg-white rounded-xl p-4 shadow-sm border border-surface-border">
            <div class="w-12 h-12 rounded-xl bg-health-50 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-health-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <div class="flex-1">
                <p class="text-sm font-semibold text-text-primary">Consultation History</p>
                <p class="text-xs text-text-muted">Past consultation records</p>
            </div>
            <svg class="w-5 h-5 text-text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>

        <a href="{{ route('patient.medical-records.prescriptions') }}" class="mobile-card flex items-center gap-4 bg-white rounded-xl p-4 shadow-sm border border-surface-border">
            <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <div class="flex-1">
                <p class="text-sm font-semibold text-text-primary">Prescriptions</p>
                <p class="text-xs text-text-muted">View medications</p>
            </div>
            <svg class="w-5 h-5 text-text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
    </div>
</div>
@endsection
