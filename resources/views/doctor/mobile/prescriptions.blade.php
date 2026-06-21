@extends('layouts.doctor-mobile')

@section('title', 'Prescriptions - Lakeshore Clinic')
@section('page-title', 'Prescriptions')

@section('content')
<div class="space-y-4">

    {{-- Page Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-text-primary">Prescriptions</h2>
            <p class="text-sm text-text-muted mt-0.5">{{ $prescriptions->total() }} prescription{{ $prescriptions->total() !== 1 ? 's' : '' }}</p>
        </div>
        <button onclick="openCreateSheet()" class="inline-flex items-center gap-1.5 bg-[#1e3a5f] text-white px-3.5 py-2.5 rounded-xl text-sm font-semibold active:bg-[#2d5a87] transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Create
        </button>
    </div>

    {{-- Filter Chips --}}
    <div class="relative -mx-4 px-4">
        <div class="flex gap-2 overflow-x-auto pb-2 scrollbar-hide" id="filter-scroll">
            <button onclick="filterPrescriptions('all')" class="filter-btn active px-4 py-2.5 rounded-xl text-sm font-semibold whitespace-nowrap transition-all duration-200" data-filter="all">
                All
            </button>
            <button onclick="filterPrescriptions('draft')" class="filter-btn px-4 py-2.5 rounded-xl text-sm font-semibold whitespace-nowrap transition-all duration-200" data-filter="draft">
                <span class="flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                    Draft
                </span>
            </button>
            <button onclick="filterPrescriptions('ready')" class="filter-btn px-4 py-2.5 rounded-xl text-sm font-semibold whitespace-nowrap transition-all duration-200" data-filter="ready">
                <span class="flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-blue-400"></span>
                    Ready
                </span>
            </button>
            <button onclick="filterPrescriptions('issued')" class="filter-btn px-4 py-2.5 rounded-xl text-sm font-semibold whitespace-nowrap transition-all duration-200" data-filter="issued">
                <span class="flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-[#0d9488]"></span>
                    Issued
                </span>
            </button>
        </div>
    </div>

    {{-- Prescriptions List --}}
    <div id="prescriptions-list" class="space-y-3">
        @forelse($prescriptions as $prescription)
            @php
                $patientName = trim(($prescription->patient?->first_name ?? '') . ' ' . ($prescription->patient?->last_name ?? ''));
                if (empty($patientName)) $patientName = 'Patient';
                $nameParts = explode(' ', $patientName);
                $initials = strtoupper(mb_substr($nameParts[0], 0, 1) . (isset($nameParts[1]) ? mb_substr($nameParts[1], 0, 1) : ''));
                $medicineCount = $prescription->medicines->count();
                $statusConfig = match($prescription->status) {
                    'draft' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'dot' => 'bg-amber-400', 'label' => 'Draft', 'accent' => 'border-l-amber-400'],
                    'ready' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-700', 'dot' => 'bg-blue-400', 'label' => 'Ready', 'accent' => 'border-l-blue-400'],
                    'issued' => ['bg' => 'bg-[#e6f7f5]', 'text' => 'text-[#0d7a6e]', 'dot' => 'bg-[#0d9488]', 'label' => 'Issued', 'accent' => 'border-l-[#0d9488]'],
                    default => ['bg' => 'bg-gray-50', 'text' => 'text-gray-700', 'dot' => 'bg-gray-400', 'label' => ucfirst($prescription->status), 'accent' => 'border-l-gray-400'],
                };
            @endphp

            <div class="prescription-card bg-white rounded-2xl shadow-sm border border-surface-border overflow-hidden border-l-4 {{ $statusConfig['accent'] }} transition-all duration-200 active:scale-[0.98]"
                 data-status="{{ $prescription->status }}"
                 data-prescription-id="{{ $prescription->id }}">

                <div class="p-4 pb-3">
                    <div class="flex items-start gap-3">
                        {{-- Patient Avatar --}}
                        <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-[#1e3a5f] to-[#2d5a87] flex items-center justify-center flex-shrink-0 shadow-sm">
                            <span class="text-sm font-bold text-white">{{ $initials }}</span>
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-2">
                                <div class="min-w-0">
                                    <p class="text-[15px] font-semibold text-text-primary truncate">{{ $patientName }}</p>
                                    <p class="text-xs text-text-muted mt-0.5">{{ $prescription->prescription_date->format('M d, Y') }}</p>
                                </div>

                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }} flex-shrink-0">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $statusConfig['dot'] }}"></span>
                                    {{ $statusConfig['label'] }}
                                </span>
                            </div>

                            <div class="flex items-center gap-3 mt-3">
                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-lg text-[11px] font-semibold bg-[#1e3a5f]/10 text-[#1e3a5f]">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                                    {{ $medicineCount }} medicine{{ $medicineCount !== 1 ? 's' : '' }}
                                </span>

                                @if($prescription->diagnosis)
                                    <div class="flex items-center gap-1 text-xs text-text-muted">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        <span class="truncate max-w-[120px]">{{ $prescription->diagnosis }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card Actions --}}
                <div class="px-4 py-3 bg-gray-50/50 border-t border-surface-border">
                    <div class="flex items-center gap-2">
                        <button onclick="viewPrescription({{ $prescription->id }})" class="flex-1 flex items-center justify-center gap-2 py-2.5 text-sm font-semibold text-[#1e3a5f] bg-[#1e3a5f]/10 rounded-xl active:bg-[#1e3a5f]/20 transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            View
                        </button>
                        @if($prescription->status === 'draft')
                            <button onclick="openEditSheet({{ $prescription->id }})" class="flex-1 flex items-center justify-center gap-2 py-2.5 text-sm font-semibold text-amber-700 bg-amber-50 rounded-xl active:bg-amber-100 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                Edit
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-16 px-4" id="empty-state">
                <div class="w-24 h-24 mx-auto rounded-3xl bg-gradient-to-br from-[#1e3a5f]/10 to-[#2d5a87]/5 flex items-center justify-center mb-5">
                    <svg class="w-12 h-12 text-[#1e3a5f]/60" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-text-primary mb-2">No Prescriptions Yet</h3>
                <p class="text-sm text-text-muted mb-6 max-w-[240px] mx-auto">Create prescriptions for your patients from consultation sessions.</p>
                <button onclick="openCreateSheet()" class="inline-flex items-center gap-2 bg-[#1e3a5f] text-white px-5 py-3 rounded-xl text-sm font-semibold active:bg-[#2d5a87] transition-colors shadow-sm">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Create Prescription
                </button>
            </div>
        @endforelse

        <div class="text-center py-16 px-4 hidden" id="filter-empty-state">
            <div class="w-20 h-20 mx-auto rounded-2xl bg-surface flex items-center justify-center mb-4">
                <svg class="w-10 h-10 text-text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <h3 class="text-base font-semibold text-text-primary mb-1">No results found</h3>
            <p class="text-sm text-text-muted">Try a different filter</p>
        </div>
    </div>

    @if($prescriptions->hasPages())
        <div class="pt-2">
            {{ $prescriptions->links('vendor.pagination.mobile-simple') }}
        </div>
    @endif
</div>

{{-- View Prescription Bottom Sheet --}}
<div id="view-sheet" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeViewSheet()"></div>
    <div class="absolute bottom-0 left-0 right-0 bg-white rounded-t-3xl max-h-[85vh] overflow-hidden transform translate-y-full transition-transform duration-300 ease-out" id="view-sheet-content">
        <div class="flex justify-center pt-3 pb-1">
            <div class="w-10 h-1 rounded-full bg-gray-300"></div>
        </div>
        <div class="px-5 pb-3 border-b border-surface-border flex items-center justify-between">
            <h3 class="text-lg font-bold text-text-primary">Prescription Details</h3>
            <button onclick="closeViewSheet()" class="w-8 h-8 rounded-full bg-surface flex items-center justify-center">
                <svg class="w-4 h-4 text-text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="overflow-y-auto max-h-[calc(85vh-120px)] p-5" id="view-detail-content">
            <div class="flex items-center justify-center py-12">
                <div class="w-8 h-8 border-2 border-[#1e3a5f] border-t-transparent rounded-full animate-spin"></div>
            </div>
        </div>
    </div>
</div>

{{-- Create / Edit Bottom Sheet --}}
<div id="form-sheet" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeFormSheet()"></div>
    <div class="absolute bottom-0 left-0 right-0 bg-white rounded-t-3xl max-h-[85vh] overflow-hidden transform translate-y-full transition-transform duration-300 ease-out" id="form-sheet-content">
        <div class="flex justify-center pt-3 pb-1">
            <div class="w-10 h-1 rounded-full bg-gray-300"></div>
        </div>
        <div class="px-5 pb-3 border-b border-surface-border flex items-center justify-between">
            <h3 class="text-lg font-bold text-text-primary" id="form-sheet-title">New Prescription</h3>
            <button onclick="closeFormSheet()" class="w-8 h-8 rounded-full bg-surface flex items-center justify-center">
                <svg class="w-4 h-4 text-text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form id="prescription-form" class="overflow-y-auto max-h-[calc(90vh-120px)] p-5 space-y-4">
            @csrf
            <input type="hidden" id="form-mode" value="create">
            <input type="hidden" id="form-prescription-id" value="">

            {{-- Prescription Date --}}
            <div>
                <label class="block text-sm font-semibold text-text-primary mb-2">Prescription Date</label>
                <input type="date" id="form-date" name="prescription_date" value="{{ date('Y-m-d') }}" required
                       class="w-full px-4 py-3 bg-surface border border-surface-border rounded-xl text-sm text-text-primary focus:ring-2 focus:ring-[#1e3a5f]/20 focus:border-[#1e3a5f] outline-none transition-all">
                <p class="text-xs text-red-500 mt-1 hidden" id="form-date-error"></p>
            </div>

            {{-- Diagnosis --}}
            <div>
                <label class="block text-sm font-semibold text-text-primary mb-2">Diagnosis</label>
                <textarea id="form-diagnosis" name="diagnosis" rows="2" placeholder="Enter diagnosis..."
                          class="w-full px-4 py-3 bg-surface border border-surface-border rounded-xl text-sm text-text-primary focus:ring-2 focus:ring-[#1e3a5f]/20 focus:border-[#1e3a5f] outline-none transition-all resize-none"></textarea>
                <p class="text-xs text-red-500 mt-1 hidden" id="form-diagnosis-error"></p>
            </div>

            {{-- Medicines --}}
            <div>
                <div class="flex items-center justify-between mb-2">
                    <label class="block text-sm font-semibold text-text-primary">Medicines</label>
                    <button type="button" onclick="addFormMedicine()" class="text-sm font-semibold text-[#1e3a5f] active:text-[#2d5a87] transition-colors">
                        + Add
                    </button>
                </div>
                <div id="form-medicines-container" class="space-y-3">
                    <div class="medicine-row space-y-2 p-3 bg-surface rounded-xl relative">
                        <button type="button" onclick="removeFormMedicine(this)" class="absolute top-2 right-2 w-6 h-6 rounded-full bg-red-50 flex items-center justify-center text-red-400 active:bg-red-100 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                        <input type="text" name="medicines[0][medicine_name]" placeholder="Medicine name *" required
                               class="w-full px-3 py-2.5 bg-white border border-surface-border rounded-lg text-sm focus:ring-2 focus:ring-[#1e3a5f]/20 focus:border-[#1e3a5f] outline-none">
                        <div class="grid grid-cols-2 gap-2">
                            <input type="text" name="medicines[0][dosage]" placeholder="Dosage"
                                   class="px-3 py-2.5 bg-white border border-surface-border rounded-lg text-sm focus:ring-2 focus:ring-[#1e3a5f]/20 focus:border-[#1e3a5f] outline-none">
                            <input type="text" name="medicines[0][frequency]" placeholder="Frequency"
                                   class="px-3 py-2.5 bg-white border border-surface-border rounded-lg text-sm focus:ring-2 focus:ring-[#1e3a5f]/20 focus:border-[#1e3a5f] outline-none">
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <input type="text" name="medicines[0][duration]" placeholder="Duration"
                                   class="px-3 py-2.5 bg-white border border-surface-border rounded-lg text-sm focus:ring-2 focus:ring-[#1e3a5f]/20 focus:border-[#1e3a5f] outline-none">
                            <input type="text" name="medicines[0][instructions]" placeholder="Instructions"
                                   class="px-3 py-2.5 bg-white border border-surface-border rounded-lg text-sm focus:ring-2 focus:ring-[#1e3a5f]/20 focus:border-[#1e3a5f] outline-none">
                        </div>
                    </div>
                </div>
                <p class="text-xs text-red-500 mt-1 hidden" id="form-medicines-error"></p>
            </div>

            {{-- General Advice --}}
            <div>
                <label class="block text-sm font-semibold text-text-primary mb-2">General Advice</label>
                <textarea id="form-advice" name="general_advice" rows="2" placeholder="Enter general advice..."
                          class="w-full px-4 py-3 bg-surface border border-surface-border rounded-xl text-sm text-text-primary focus:ring-2 focus:ring-[#1e3a5f]/20 focus:border-[#1e3a5f] outline-none transition-all resize-none"></textarea>
                <p class="text-xs text-red-500 mt-1 hidden" id="form-general_advice-error"></p>
            </div>

            {{-- Submit --}}
            <div class="pt-2 pb-4">
                <button type="submit" id="form-submit-btn"
                        class="w-full py-3.5 bg-[#1e3a5f] text-white rounded-xl font-semibold text-sm active:bg-[#2d5a87] transition-colors flex items-center justify-center gap-2 shadow-sm">
                    <span id="form-submit-text">Create Prescription</span>
                    <svg id="form-submit-spinner" class="hidden animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </button>
            </div>
        </form>
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

    .prescription-card {
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
let viewSheetOpen = false;
let formSheetOpen = false;
let formMedicineCount = 1;

const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

function filterPrescriptions(filter) {
    currentFilter = filter;

    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    const activeBtn = document.querySelector(`.filter-btn[data-filter="${filter}"]`);
    if (activeBtn) activeBtn.classList.add('active');

    const cards = document.querySelectorAll('.prescription-card');
    let visibleCount = 0;

    cards.forEach(card => {
        const status = card.dataset.status;
        const show = filter === 'all' || status === filter;
        card.style.display = show ? 'block' : 'none';
        if (show) visibleCount++;
    });

    const filterEmpty = document.getElementById('filter-empty-state');
    if (filterEmpty) {
        filterEmpty.classList.toggle('hidden', visibleCount > 0);
    }
}

function openSheet(sheetId, contentSelector) {
    const sheet = document.getElementById(sheetId);
    const content = document.querySelector(contentSelector);
    sheet.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    requestAnimationFrame(() => {
        content.classList.add('sheet-open');
    });
}

function closeSheet(sheetId, contentSelector) {
    const sheet = document.getElementById(sheetId);
    const content = document.querySelector(contentSelector);
    content.classList.remove('sheet-open');
    content.style.transform = 'translateY(100%)';
    setTimeout(() => {
        sheet.classList.add('hidden');
        content.style.transform = '';
        document.body.style.overflow = '';
    }, 300);
}

async function viewPrescription(id) {
    const content = document.getElementById('view-detail-content');
    openSheet('view-sheet', '#view-sheet-content');
    viewSheetOpen = true;

    content.innerHTML = '<div class="flex items-center justify-center py-12"><div class="w-8 h-8 border-2 border-[#1e3a5f] border-t-transparent rounded-full animate-spin"></div></div>';

    try {
        const response = await fetch(`/doctor/prescriptions/${id}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
        });
        const data = await response.json();

        if (data.success) {
            const p = data.prescription;
            const statusConfig = {
                draft: { bg: 'bg-amber-50', text: 'text-amber-700', dot: 'bg-amber-400', label: 'Draft' },
                ready: { bg: 'bg-blue-50', text: 'text-blue-700', dot: 'bg-blue-400', label: 'Ready' },
                issued: { bg: 'bg-[#e6f7f5]', text: 'text-[#0d7a6e]', dot: 'bg-[#0d9488]', label: 'Issued' },
            };
            const s = statusConfig[p.status] || { bg: 'bg-gray-50', text: 'text-gray-700', dot: 'bg-gray-400', label: p.status_label || p.status };

            const patientName = p.patient ? `${p.patient.first_name || ''} ${p.patient.last_name || ''}`.trim() || 'Patient' : 'Patient';
            const patientInitials = patientName.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase();
            const dateStr = p.prescription_date ? new Date(p.prescription_date).toLocaleDateString('en-US', { weekday: 'long', month: 'long', day: 'numeric', year: 'numeric' }) : '-';

            let medicinesHtml = '';
            if (p.medicines && p.medicines.length > 0) {
                medicinesHtml = p.medicines.map((m, i) => `
                    <div class="p-3 bg-surface rounded-xl">
                        <div class="flex items-start gap-2">
                            <span class="w-6 h-6 rounded-lg bg-[#1e3a5f]/10 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <span class="text-[10px] font-bold text-[#1e3a5f]">${i + 1}</span>
                            </span>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-semibold text-text-primary">${m.medicine_name}</p>
                                <div class="flex flex-wrap gap-1.5 mt-1">
                                    ${m.dosage ? `<span class="text-[11px] px-2 py-0.5 rounded-md bg-blue-50 text-blue-700 font-medium">${m.dosage}</span>` : ''}
                                    ${m.frequency ? `<span class="text-[11px] px-2 py-0.5 rounded-md bg-purple-50 text-purple-700 font-medium">${m.frequency}</span>` : ''}
                                    ${m.duration ? `<span class="text-[11px] px-2 py-0.5 rounded-md bg-amber-50 text-amber-700 font-medium">${m.duration}</span>` : ''}
                                </div>
                                ${m.instructions ? `<p class="text-xs text-text-muted mt-1.5">${m.instructions}</p>` : ''}
                            </div>
                        </div>
                    </div>
                `).join('');
            }

            content.innerHTML = `
                <div class="space-y-1">
                    <div class="flex items-center justify-center mb-5">
                        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold ${s.bg} ${s.text}">
                            <span class="w-2 h-2 rounded-full ${s.dot}"></span>
                            ${s.label}
                        </span>
                    </div>

                    <div class="detail-row">
                        <div class="detail-icon bg-[#1e3a5f]/10">
                            <span class="text-sm font-bold text-[#1e3a5f]">${patientInitials}</span>
                        </div>
                        <div>
                            <p class="detail-label">Patient</p>
                            <p class="detail-value">${patientName}</p>
                            ${p.patient && p.patient.email ? '<p class="text-xs text-text-muted">' + p.patient.email + '</p>' : ''}
                        </div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-icon bg-amber-50">
                            <svg class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <p class="detail-label">Prescription Date</p>
                            <p class="detail-value">${dateStr}</p>
                        </div>
                    </div>

                    ${p.diagnosis ? `
                    <div class="detail-row">
                        <div class="detail-icon bg-purple-50">
                            <svg class="w-5 h-5 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <div>
                            <p class="detail-label">Diagnosis</p>
                            <p class="detail-value">${p.diagnosis}</p>
                        </div>
                    </div>` : ''}

                    ${medicinesHtml ? `
                    <div class="detail-row">
                        <div class="detail-icon bg-[#1e3a5f]/10">
                            <svg class="w-5 h-5 text-[#1e3a5f]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="detail-label">Medicines (${p.medicines.length})</p>
                            <div class="space-y-2 mt-1">${medicinesHtml}</div>
                        </div>
                    </div>` : ''}

                    ${p.general_advice ? `
                    <div class="detail-row">
                        <div class="detail-icon bg-emerald-50">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="detail-label">General Advice</p>
                            <p class="detail-value">${p.general_advice}</p>
                        </div>
                    </div>` : ''}

                    ${p.pdf_path ? `
                    <div class="pt-2">
                        <a href="/uploads/prescriptions/${p.pdf_path}" target="_blank" class="flex items-center justify-center gap-2 w-full py-3 bg-[#1e3a5f]/10 text-[#1e3a5f] rounded-xl font-semibold text-sm active:bg-[#1e3a5f]/20 transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            Download PDF
                        </a>
                    </div>` : ''}
                </div>
            `;
        } else {
            content.innerHTML = '<div class="text-center py-12"><p class="text-text-muted">Failed to load prescription details.</p></div>';
        }
    } catch (error) {
        content.innerHTML = '<div class="text-center py-12"><p class="text-text-muted">An error occurred. Please try again.</p></div>';
    }
}

function closeViewSheet() {
    closeSheet('view-sheet', '#view-sheet-content');
    viewSheetOpen = false;
}

function openCreateSheet() {
    document.getElementById('form-mode').value = 'create';
    document.getElementById('form-prescription-id').value = '';
    document.getElementById('form-sheet-title').textContent = 'New Prescription';
    document.getElementById('form-submit-text').textContent = 'Create Prescription';
    document.getElementById('form-date').value = '{{ date('Y-m-d') }}';
    document.getElementById('form-diagnosis').value = '';
    document.getElementById('form-advice').value = '';
    clearFormErrors();

    const container = document.getElementById('form-medicines-container');
    container.innerHTML = '';
    formMedicineCount = 1;
    addFormMedicine();

    openSheet('form-sheet', '#form-sheet-content');
    formSheetOpen = true;
}

async function openEditSheet(id) {
    document.getElementById('form-mode').value = 'edit';
    document.getElementById('form-sheet-title').textContent = 'Edit Prescription';
    document.getElementById('form-submit-text').textContent = 'Update Prescription';
    clearFormErrors();

    openSheet('form-sheet', '#form-sheet-content');
    formSheetOpen = true;

    try {
        const response = await fetch(`/doctor/prescriptions/${id}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
        });
        const data = await response.json();

        if (data.success) {
            const p = data.prescription;
            document.getElementById('form-prescription-id').value = p.id;
            document.getElementById('form-date').value = p.prescription_date;
            document.getElementById('form-diagnosis').value = p.diagnosis || '';
            document.getElementById('form-advice').value = p.general_advice || '';

            const container = document.getElementById('form-medicines-container');
            container.innerHTML = '';
            formMedicineCount = 0;

            if (p.medicines && p.medicines.length > 0) {
                p.medicines.forEach(m => addFormMedicine(m));
            } else {
                addFormMedicine();
            }
        }
    } catch (error) {
        showToast('Failed to load prescription data.', 'error');
        closeFormSheet();
    }
}

function closeFormSheet() {
    closeSheet('form-sheet', '#form-sheet-content');
    formSheetOpen = false;
}

function addFormMedicine(medicine = null) {
    const container = document.getElementById('form-medicines-container');
    const row = document.createElement('div');
    row.className = 'medicine-row space-y-2 p-3 bg-surface rounded-xl relative';
    row.innerHTML = `
        <button type="button" onclick="removeFormMedicine(this)" class="absolute top-2 right-2 w-6 h-6 rounded-full bg-red-50 flex items-center justify-center text-red-400 active:bg-red-100 transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
        <input type="text" name="medicines[${formMedicineCount}][medicine_name]" placeholder="Medicine name *" value="${medicine?.medicine_name || ''}" required
               class="w-full px-3 py-2.5 bg-white border border-surface-border rounded-lg text-sm focus:ring-2 focus:ring-[#1e3a5f]/20 focus:border-[#1e3a5f] outline-none">
        <div class="grid grid-cols-2 gap-2">
            <input type="text" name="medicines[${formMedicineCount}][dosage]" placeholder="Dosage" value="${medicine?.dosage || ''}"
                   class="px-3 py-2.5 bg-white border border-surface-border rounded-lg text-sm focus:ring-2 focus:ring-[#1e3a5f]/20 focus:border-[#1e3a5f] outline-none">
            <input type="text" name="medicines[${formMedicineCount}][frequency]" placeholder="Frequency" value="${medicine?.frequency || ''}"
                   class="px-3 py-2.5 bg-white border border-surface-border rounded-lg text-sm focus:ring-2 focus:ring-[#1e3a5f]/20 focus:border-[#1e3a5f] outline-none">
        </div>
        <div class="grid grid-cols-2 gap-2">
            <input type="text" name="medicines[${formMedicineCount}][duration]" placeholder="Duration" value="${medicine?.duration || ''}"
                   class="px-3 py-2.5 bg-white border border-surface-border rounded-lg text-sm focus:ring-2 focus:ring-[#1e3a5f]/20 focus:border-[#1e3a5f] outline-none">
            <input type="text" name="medicines[${formMedicineCount}][instructions]" placeholder="Instructions" value="${medicine?.instructions || ''}"
                   class="px-3 py-2.5 bg-white border border-surface-border rounded-lg text-sm focus:ring-2 focus:ring-[#1e3a5f]/20 focus:border-[#1e3a5f] outline-none">
        </div>
    `;
    container.appendChild(row);
    formMedicineCount++;
}

function removeFormMedicine(btn) {
    const container = document.getElementById('form-medicines-container');
    if (container.querySelectorAll('.medicine-row').length > 1) {
        btn.closest('.medicine-row').remove();
    } else {
        showToast('At least one medicine is required.', 'error');
    }
}

function clearFormErrors() {
    document.querySelectorAll('#form-sheet [id$="-error"]').forEach(el => {
        el.classList.add('hidden');
        el.textContent = '';
    });
}

document.getElementById('prescription-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    clearFormErrors();

    const mode = document.getElementById('form-mode').value;
    const id = document.getElementById('form-prescription-id').value;
    const btn = document.getElementById('form-submit-btn');
    const btnText = document.getElementById('form-submit-text');
    const btnSpinner = document.getElementById('form-submit-spinner');

    btn.disabled = true;
    btnText.textContent = mode === 'edit' ? 'Updating...' : 'Creating...';
    btnSpinner.classList.remove('hidden');

    const formData = new FormData(this);
    if (mode === 'edit') {
        formData.append('_method', 'PUT');
    }

    const url = mode === 'edit' ? `/doctor/prescriptions/${id}` : '{{ route("doctor.prescriptions.store") }}';

    try {
        const response = await fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
        });

        const data = await response.json();

        if (response.ok && data.success) {
            showToast(data.message || 'Prescription saved successfully.', 'success');
            setTimeout(() => location.reload(), 1000);
        } else {
            if (data.errors) {
                Object.keys(data.errors).forEach(key => {
                    const errorEl = document.getElementById(`form-${key}-error`);
                    if (errorEl) {
                        errorEl.textContent = data.errors[key][0];
                        errorEl.classList.remove('hidden');
                    }
                });
            }
            showToast(data.message || 'Please fix the errors below.', 'error');
        }
    } catch (error) {
        showToast('An error occurred. Please try again.', 'error');
    } finally {
        btn.disabled = false;
        btnText.textContent = mode === 'edit' ? 'Update Prescription' : 'Create Prescription';
        btnSpinner.classList.add('hidden');
    }
});

function showToast(message, type = 'info') {
    const container = document.getElementById('toast-container');
    const toast = document.createElement('div');
    const bgColor = type === 'success' ? 'bg-emerald-500' : type === 'error' ? 'bg-red-500' : 'bg-[#1e3a5f]';
    const icon = type === 'success'
        ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>'
        : type === 'error'
        ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>'
        : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>';

    toast.className = `${bgColor} text-white px-4 py-3 rounded-xl shadow-lg flex items-center gap-3 text-sm font-medium transform transition-all duration-300 opacity-0 -translate-y-2`;
    toast.innerHTML = `
        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            ${icon}
        </svg>
        <span class="flex-1">${message}</span>
    `;
    container.appendChild(toast);

    requestAnimationFrame(() => {
        toast.classList.remove('opacity-0', '-translate-y-2');
        toast.classList.add('opacity-100', 'translate-y-0');
    });

    setTimeout(() => {
        toast.classList.remove('opacity-100', 'translate-y-0');
        toast.classList.add('opacity-0', '-translate-y-2');
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        if (formSheetOpen) closeFormSheet();
        else if (viewSheetOpen) closeViewSheet();
    }
});
</script>
@endpush
@endsection