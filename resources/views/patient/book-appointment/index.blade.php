@extends('layouts.patient')

@section('title', 'Book Appointment - Lakeshore Clinic')
@section('page-title', 'Book Appointment')

@section('content')
<div class="space-y-6">
    <x-page-header title="Book Appointment">
        <x-slot name="subtitle">Schedule your appointment</x-slot>
    </x-page-header>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <a href="{{ route('patient.booking') }}" class="p-6 bg-white border border-surface-border rounded-xl hover:border-primary-300 hover:shadow-card transition-all group">
            <div class="w-12 h-12 rounded-xl bg-primary-500/10 flex items-center justify-center mb-4 group-hover:bg-primary-500 group-hover:text-white transition-colors">
                <svg class="w-6 h-6 text-primary-600 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14m14 0h2m-2 0h-5m-9 0H3a2 2 0 01-2-2v-2a2 2 0 012-2h3.93a2 2 0 01.824.132l2.448 1.224a2 2 0 001.256.268h3.414a2 2 0 012.121 1.293l1.586 1.586a1 1 0 01.293.707V19a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a1 1 0 01.293-.707l1.586-1.586a1 1 0 01.707-.293h3.414a1 1 0 00.707-.293l2.448-1.224a1 1 0 00.495-.268z"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-text-primary mb-2">Clinic Visit</h3>
            <p class="text-sm text-text-secondary">Book an in-person appointment at our clinic</p>
        </a>

        <a href="{{ route('patient.telemedicine') }}" class="p-6 bg-white border border-surface-border rounded-xl hover:border-primary-300 hover:shadow-card transition-all group">
            <div class="w-12 h-12 rounded-xl bg-[#1e3a5f]/10 flex items-center justify-center mb-4 group-hover:bg-[#1e3a5f] group-hover:text-white transition-colors">
                <svg class="w-6 h-6 text-[#1e3a5f] group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-text-primary mb-2">Telemedicine</h3>
            <p class="text-sm text-text-secondary">Book a virtual consultation with a doctor</p>
        </a>
    </div>
</div>
@endsection
