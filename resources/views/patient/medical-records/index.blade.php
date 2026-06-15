@extends('layouts.patient')

@section('title', 'Medical Records - Lakeshore Clinic')
@section('page-title', 'Medical Records')

@section('content')
<div class="space-y-6">
    <x-page-header title="Medical Records">
        <x-slot name="subtitle">Access your medical documents and history</x-slot>
    </x-page-header>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <a href="{{ route('patient.medical-records.documents') }}" class="p-6 bg-white border border-surface-border rounded-xl hover:border-primary-300 hover:shadow-card transition-all group">
            <div class="w-12 h-12 rounded-xl bg-primary-500/10 flex items-center justify-center mb-4 group-hover:bg-primary-500 group-hover:text-white transition-colors">
                <svg class="w-6 h-6 text-primary-600 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-text-primary mb-2">Medical Documents</h3>
            <p class="text-sm text-text-secondary">View and download your medical documents</p>
        </a>

        <a href="{{ route('patient.medical-records.consultations') }}" class="p-6 bg-white border border-surface-border rounded-xl hover:border-primary-300 hover:shadow-card transition-all group">
            <div class="w-12 h-12 rounded-xl bg-health-500/10 flex items-center justify-center mb-4 group-hover:bg-health-500 group-hover:text-white transition-colors">
                <svg class="w-6 h-6 text-health-600 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-3-8h3m-3 4h3"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-text-primary mb-2">Consultation History</h3>
            <p class="text-sm text-text-secondary">View your past consultation records</p>
        </a>

        <a href="{{ route('patient.medical-records.prescriptions') }}" class="p-6 bg-white border border-surface-border rounded-xl hover:border-primary-300 hover:shadow-card transition-all group">
            <div class="w-12 h-12 rounded-xl bg-amber-500/10 flex items-center justify-center mb-4 group-hover:bg-amber-500 group-hover:text-white transition-colors">
                <svg class="w-6 h-6 text-amber-600 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-text-primary mb-2">Prescriptions</h3>
            <p class="text-sm text-text-secondary">View your prescriptions and medications</p>
        </a>
    </div>
</div>
@endsection
