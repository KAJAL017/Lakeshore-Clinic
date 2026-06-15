@extends('layouts.doctor-mobile')

@section('title', 'Consultations - Lakeshore Clinic')
@section('page-title', 'Consultations')

@section('content')
<div class="space-y-4">

    {{-- Page Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-text-primary">Consultations</h2>
            <p class="text-sm text-text-muted mt-0.5">{{ $consultations->total() }} consultation{{ $consultations->total() !== 1 ? 's' : '' }}</p>
        </div>
    </div>

    {{-- Filter Chips --}}
    <div class="relative -mx-4 px-4">
        <div class="flex gap-2 overflow-x-auto pb-2 scrollbar-hide" id="filter-scroll">
            <button onclick="filterConsultations('all')" class="filter-btn active px-4 py-2.5 rounded-xl text-sm font-semibold whitespace-nowrap transition-all duration-200" data-filter="all">
                All
            </button>
            <button onclick="filterConsultations('pending')" class="filter-btn px-4 py-2.5 rounded-xl text-sm font-semibold whitespace-nowrap transition-all duration-200" data-filter="pending">
                Pending
            </button>
            <button onclick="filterConsultations('in_consultation')" class="filter-btn px-4 py-2.5 rounded-xl text-sm font-semibold whitespace-nowrap transition-all duration-200" data-filter="in_consultation">
                In Progress
            </button>
            <button onclick="filterConsultations('completed')" class="filter-btn px-4 py-2.5 rounded-xl text-sm font-semibold whitespace-nowrap transition-all duration-200" data-filter="completed">
                Completed
            </button>
        </div>
    </div>

    {{-- Consultations List --}}
    <div id="consultations-list" class="space-y-3">
        @forelse($consultations as $consultation)
            @php
                $appointment = $consultation->appointment;
                $patient = $appointment?->patient;
                $patientName = trim(($patient?->first_name ?? '') . ' ' . ($patient?->last_name ?? ''));
                if (empty($patientName)) $patientName = 'Patient';
                $initials = strtoupper(substr($patient?->first_name ?? 'P', 0, 1) . substr($patient?->last_name ?? '', 0, 1));
                if (empty($initials)) $initials = strtoupper(substr($patientName, 0, 1));
                $isTelemedicine = $appointment?->type === 'telemedicine';
                $statusConfig = match($consultation->status) {
                    'pending' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'dot' => 'bg-amber-400', 'label' => 'Pending', 'accent' => 'border-l-amber-400'],
                    'in_consultation' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-700', 'dot' => 'bg-blue-400', 'label' => 'In Consultation', 'accent' => 'border-l-blue-400'],
                    'completed' => ['bg' => 'bg-health-50', 'text' => 'text-health-700', 'dot' => 'bg-health-500', 'label' => 'Completed', 'accent' => 'border-l-health-500'],
                    default => ['bg' => 'bg-gray-50', 'text' => 'text-gray-700', 'dot' => 'bg-gray-400', 'label' => ucfirst($consultation->status), 'accent' => 'border-l-gray-400'],
                };
            @endphp

            <div class="consultation-card bg-white rounded-2xl shadow-sm border border-surface-border overflow-hidden border-l-4 {{ $statusConfig['accent'] }} transition-all duration-200 active:scale-[0.98]"
                 data-status="{{ $consultation->status }}"
                 data-consultation-id="{{ $consultation->id }}">

                {{-- Card Body --}}
                <div class="p-4 pb-3">
                    <div class="flex items-start gap-3">
                        {{-- Patient Avatar --}}
                        <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-[#1e3a5f] to-[#2d5a87] flex items-center justify-center flex-shrink-0 shadow-sm">
                            <span class="text-sm font-bold text-white">{{ $initials }}</span>
                        </div>

                        {{-- Consultation Info --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-2">
                                <div class="min-w-0">
                                    <p class="text-[15px] font-semibold text-text-primary truncate">{{ $patientName }}</p>
                                    <p class="text-xs text-text-muted truncate mt-0.5">{{ $appointment->specialization?->name ?? '-' }}</p>
                                </div>

                                {{-- Status Badge --}}
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }} flex-shrink-0">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $statusConfig['dot'] }}"></span>
                                    {{ $statusConfig['label'] }}
                                </span>
                            </div>

                            {{-- Consultation Details Row --}}
                            <div class="flex items-center gap-3 mt-3">
                                {{-- Type Badge --}}
                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-lg text-[11px] font-semibold {{ $isTelemedicine ? 'bg-[#1e3a5f]/10 text-[#1e3a5f]' : 'bg-primary-50 text-primary-700' }}">
                                    @if($isTelemedicine)
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                    @else
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                    @endif
                                    {{ $isTelemedicine ? 'Telemedicine' : 'Clinic Visit' }}
                                </span>

                                {{-- Date --}}
                                <div class="flex items-center gap-1 text-xs text-text-secondary">
                                    <svg class="w-3.5 h-3.5 text-text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <span class="font-medium">{{ $appointment?->appointment_date?->format('M d, Y') ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card Actions --}}
                <div class="px-4 py-3 bg-gray-50/50 border-t border-surface-border">
                    <button onclick="viewConsultation({{ $consultation->id }})" class="w-full flex items-center justify-center gap-2 py-2.5 text-sm font-semibold text-[#1e3a5f] bg-[#1e3a5f]/10 rounded-xl active:bg-[#1e3a5f]/20 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        View Notes
                    </button>
                </div>
            </div>
        @empty
            {{-- Empty State --}}
            <div class="text-center py-16 px-4" id="empty-state">
                <div class="w-24 h-24 mx-auto rounded-3xl bg-gradient-to-br from-[#1e3a5f]/10 to-[#2d5a87]/5 flex items-center justify-center mb-5">
                    <svg class="w-12 h-12 text-[#1e3a5f]/60" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-text-primary mb-2">No Consultations Yet</h3>
                <p class="text-sm text-text-muted mb-6 max-w-[240px] mx-auto">Your patient consultations will appear here once appointments are completed.</p>
            </div>
        @endforelse

        {{-- Filter Empty State (hidden by default) --}}
        <div class="text-center py-16 px-4 hidden" id="filter-empty-state">
            <div class="w-20 h-20 mx-auto rounded-2xl bg-surface flex items-center justify-center mb-4">
                <svg class="w-10 h-10 text-text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <h3 class="text-base font-semibold text-text-primary mb-1">No results found</h3>
            <p class="text-sm text-text-muted">Try a different filter</p>
        </div>
    </div>

    {{-- Pagination --}}
    @if($consultations->hasPages())
    <div class="pt-2">
        {{ $consultations->links('vendor.pagination.mobile-simple') }}
    </div>
    @endif
</div>

{{-- Consultation Detail Bottom Sheet --}}
<div id="consultation-detail-sheet" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeConsultationSheet()"></div>
    <div class="absolute bottom-0 left-0 right-0 bg-white rounded-t-3xl max-h-[85vh] overflow-hidden transform translate-y-full transition-transform duration-300 ease-out" id="sheet-content">
        {{-- Sheet Handle --}}
        <div class="flex justify-center pt-3 pb-1">
            <div class="w-10 h-1 rounded-full bg-gray-300"></div>
        </div>

        {{-- Sheet Header --}}
        <div class="px-5 pb-3 border-b border-surface-border flex items-center justify-between">
            <h3 class="text-lg font-bold text-text-primary">Consultation Notes</h3>
            <button onclick="closeConsultationSheet()" class="w-8 h-8 rounded-full bg-surface flex items-center justify-center">
                <svg class="w-4 h-4 text-text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Sheet Body --}}
        <div class="overflow-y-auto max-h-[calc(85vh-120px)] p-5" id="consultation-detail-content">
            <div class="flex items-center justify-center py-12">
                <div class="w-8 h-8 border-2 border-[#1e3a5f] border-t-transparent rounded-full animate-spin"></div>
            </div>
        </div>
    </div>
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

    @keyframes sheetUp {
        from { transform: translateY(100%); }
        to { transform: translateY(0); }
    }
    .sheet-open {
        animation: sheetUp 0.3s ease-out forwards;
    }

    .consultation-card {
        will-change: transform;
    }

    .detail-row {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        padding: 0.75rem 0;
        border-bottom: 1px solid #f1f5f9;
    }
    .detail-row:last-child {
        border-bottom: none;
    }
    .detail-icon {
        width: 2.25rem;
        height: 2.25rem;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .detail-label {
        font-size: 0.7rem;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.025em;
        margin-bottom: 0.125rem;
    }
    .detail-value {
        font-size: 0.875rem;
        font-weight: 500;
        color: #0f172a;
    }
</style>
@endpush

@push('scripts')
<script>
let currentFilter = 'all';
let detailSheetOpen = false;

function filterConsultations(filter) {
    currentFilter = filter;

    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    const activeBtn = document.querySelector(`.filter-btn[data-filter="${filter}"]`);
    if (activeBtn) activeBtn.classList.add('active');

    const cards = document.querySelectorAll('.consultation-card');
    let visibleCount = 0;

    cards.forEach(card => {
        const status = card.dataset.status;
        const show = filter === 'all' || status === filter;

        card.style.display = show ? 'block' : 'none';
        if (show) visibleCount++;
    });

    const filterEmpty = document.getElementById('filter-empty-state');
    const mainEmpty = document.getElementById('empty-state');
    if (filterEmpty) {
        filterEmpty.classList.toggle('hidden', visibleCount > 0);
    }
    if (mainEmpty) {
        mainEmpty.classList.toggle('hidden', visibleCount > 0 || cards.length > 0);
    }
}

async function viewConsultation(id) {
    const sheet = document.getElementById('consultation-detail-sheet');
    const sheetContent = document.getElementById('sheet-content');
    const content = document.getElementById('consultation-detail-content');

    sheet.classList.remove('hidden');
    document.body.style.overflow = 'hidden';

    content.innerHTML = '<div class="flex items-center justify-center py-12"><div class="w-8 h-8 border-2 border-[#1e3a5f] border-t-transparent rounded-full animate-spin"></div></div>';

    requestAnimationFrame(() => {
        sheetContent.classList.add('sheet-open');
    });

    detailSheetOpen = true;

    try {
        const response = await fetch(`/doctor/consultations/${id}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
        });
        const data = await response.json();

        if (data.success) {
            const c = data.consultation;
            const a = c.appointment;
            const patient = a?.patient;
            const patientName = patient
                ? `${patient.first_name || ''} ${patient.last_name || ''}`.trim() || 'Patient'
                : 'Patient';
            const patientInitial = patient
                ? (patient.first_name?.charAt(0) || 'P').toUpperCase() + (patient.last_name?.charAt(0) || '').toUpperCase()
                : patientName.charAt(0).toUpperCase();
            const specName = a?.specialization?.name || '-';
            const dateStr = a?.appointment_date
                ? new Date(a.appointment_date).toLocaleDateString('en-US', { weekday: 'long', month: 'long', day: 'numeric', year: 'numeric' })
                : '-';
            const timeStr = a?.appointment_time || '-';
            const typeLabel = a?.type === 'telemedicine' ? 'Telemedicine' : 'Clinic Visit';
            const statusConfig = {
                pending: { bg: 'bg-amber-50', text: 'text-amber-700', dot: 'bg-amber-400', label: 'Pending' },
                in_consultation: { bg: 'bg-blue-50', text: 'text-blue-700', dot: 'bg-blue-400', label: 'In Consultation' },
                completed: { bg: 'bg-health-50', text: 'text-health-700', dot: 'bg-health-500', label: 'Completed' },
            };
            const s = statusConfig[c.status] || { bg: 'bg-gray-50', text: 'text-gray-700', dot: 'bg-gray-400', label: c.status_label || c.status };

            let detailsHtml = `
                <div class="space-y-1">
                    {{-- Status --}}
                    <div class="flex items-center justify-center mb-5">
                        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold ${s.bg} ${s.text}">
                            <span class="w-2 h-2 rounded-full ${s.dot}"></span>
                            ${s.label}
                        </span>
                    </div>

                    {{-- Patient --}}
                    <div class="detail-row">
                        <div class="detail-icon bg-[#1e3a5f]/10">
                            <span class="text-sm font-bold text-[#1e3a5f]">${patientInitial}</span>
                        </div>
                        <div>
                            <p class="detail-label">Patient</p>
                            <p class="detail-value">${patientName}</p>
                            ${patient?.email ? '<p class="text-xs text-text-muted">' + patient.email + '</p>' : ''}
                        </div>
                    </div>

                    {{-- Type --}}
                    <div class="detail-row">
                        <div class="detail-icon ${a?.type === 'telemedicine' ? 'bg-[#1e3a5f]/10' : 'bg-primary-50'}">
                            ${a?.type === 'telemedicine'
                                ? '<svg class="w-5 h-5 text-[#1e3a5f]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>'
                                : '<svg class="w-5 h-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>'
                            }
                        </div>
                        <div>
                            <p class="detail-label">Type</p>
                            <p class="detail-value">${typeLabel}</p>
                        </div>
                    </div>

                    {{-- Specialization --}}
                    <div class="detail-row">
                        <div class="detail-icon bg-purple-50">
                            <svg class="w-5 h-5 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                        </div>
                        <div>
                            <p class="detail-label">Specialization</p>
                            <p class="detail-value">${specName}</p>
                        </div>
                    </div>

                    {{-- Date & Time --}}
                    <div class="detail-row">
                        <div class="detail-icon bg-amber-50">
                            <svg class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <p class="detail-label">Date & Time</p>
                            <p class="detail-value">${dateStr}</p>
                            <p class="text-xs text-text-muted">${timeStr}</p>
                        </div>
                    </div>

                    {{-- Chief Complaint --}}
                    ${c.chief_complaint ? `
                    <div class="detail-row">
                        <div class="detail-icon bg-red-50">
                            <svg class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                        </div>
                        <div>
                            <p class="detail-label">Chief Complaint</p>
                            <p class="detail-value">${c.chief_complaint}</p>
                        </div>
                    </div>
                    ` : ''}

                    {{-- Symptoms --}}
                    ${c.symptoms ? `
                    <div class="detail-row">
                        <div class="detail-icon bg-orange-50">
                            <svg class="w-5 h-5 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        </div>
                        <div>
                            <p class="detail-label">Symptoms</p>
                            <p class="detail-value">${c.symptoms}</p>
                        </div>
                    </div>
                    ` : ''}

                    {{-- Clinical Findings --}}
                    ${c.clinical_findings ? `
                    <div class="detail-row">
                        <div class="detail-icon bg-blue-50">
                            <svg class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <div>
                            <p class="detail-label">Clinical Findings</p>
                            <p class="detail-value">${c.clinical_findings}</p>
                        </div>
                    </div>
                    ` : ''}

                    {{-- Diagnosis --}}
                    ${c.diagnosis ? `
                    <div class="detail-row">
                        <div class="detail-icon bg-indigo-50">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="detail-label">Diagnosis</p>
                            <p class="detail-value">${c.diagnosis}</p>
                        </div>
                    </div>
                    ` : ''}

                    {{-- Doctor Notes --}}
                    ${c.doctor_notes ? `
                    <div class="detail-row">
                        <div class="detail-icon bg-gray-100">
                            <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </div>
                        <div>
                            <p class="detail-label">Doctor Notes</p>
                            <p class="detail-value">${c.doctor_notes}</p>
                        </div>
                    </div>
                    ` : ''}

                    {{-- Recommendations --}}
                    ${c.recommendations ? `
                    <div class="detail-row">
                        <div class="detail-icon bg-emerald-50">
                            <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="detail-label">Recommendations</p>
                            <p class="detail-value">${c.recommendations}</p>
                        </div>
                    </div>
                    ` : ''}

                    {{-- No Notes Placeholder --}}
                    ${!c.chief_complaint && !c.symptoms && !c.clinical_findings && !c.diagnosis && !c.doctor_notes && !c.recommendations ? `
                    <div class="flex flex-col items-center justify-center py-8">
                        <div class="w-16 h-16 rounded-2xl bg-surface flex items-center justify-center mb-3">
                            <svg class="w-8 h-8 text-text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <p class="text-sm text-text-muted">No consultation notes recorded</p>
                    </div>
                    ` : ''}
                </div>
            `;

            content.innerHTML = detailsHtml;
        } else {
            content.innerHTML = '<div class="text-center py-12"><p class="text-text-muted">Failed to load consultation details.</p></div>';
        }
    } catch (error) {
        content.innerHTML = '<div class="text-center py-12"><p class="text-text-muted">An error occurred. Please try again.</p></div>';
    }
}

function closeConsultationSheet() {
    const sheetContent = document.getElementById('sheet-content');
    const sheet = document.getElementById('consultation-detail-sheet');

    sheetContent.classList.remove('sheet-open');
    sheetContent.style.transform = 'translateY(100%)';

    setTimeout(() => {
        sheet.classList.add('hidden');
        sheetContent.style.transform = '';
        document.body.style.overflow = '';
        detailSheetOpen = false;
    }, 300);
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && detailSheetOpen) {
        closeConsultationSheet();
    }
});
</script>
@endpush
@endsection
