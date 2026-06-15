@extends('layouts.doctor-mobile')

@section('title', 'Patient Records - Lakeshore Clinic')
@section('page-title', 'Patient Records')

@section('content')
<div class="space-y-4">

    {{-- Page Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-text-primary">Patient Records</h2>
            <p class="text-sm text-text-muted mt-0.5">{{ $patients->total() }} patient{{ $patients->total() !== 1 ? 's' : '' }}</p>
        </div>
    </div>

    {{-- Patients List --}}
    <div id="patients-list" class="space-y-3">
        @forelse($patients as $patient)
            @php
                $patientName = trim(($patient->first_name ?? '') . ' ' . ($patient->last_name ?? ''));
                if (empty($patientName)) $patientName = 'Patient';
                $initials = strtoupper(substr($patient->first_name ?? '', 0, 1) . substr($patient->last_name ?? '', 0, 1));
                $appointmentsCount = $patient->appointments_count ?? 0;
                $statusConfig = match($patient->status ?? 'active') {
                    'active' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'dot' => 'bg-emerald-400', 'label' => 'Active'],
                    'inactive' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-600', 'dot' => 'bg-gray-400', 'label' => 'Inactive'],
                    'blocked' => ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'dot' => 'bg-red-400', 'label' => 'Blocked'],
                    default => ['bg' => 'bg-gray-50', 'text' => 'text-gray-700', 'dot' => 'bg-gray-400', 'label' => ucfirst($patient->status ?? 'active')],
                };
            @endphp

            <div class="patient-card bg-white rounded-2xl shadow-sm border border-surface-border overflow-hidden transition-all duration-200 active:scale-[0.98]"
                 data-patient-id="{{ $patient->id }}">

                {{-- Card Body --}}
                <div class="p-4 pb-3">
                    <div class="flex items-start gap-3">
                        {{-- Patient Avatar --}}
                        @if($patient->photo)
                            <div class="w-12 h-12 rounded-2xl overflow-hidden flex-shrink-0 shadow-sm">
                                <img src="{{ asset('uploads/patients/' . $patient->photo) }}" alt="{{ $patientName }}" class="w-full h-full object-cover">
                            </div>
                        @else
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center flex-shrink-0 shadow-sm">
                                <span class="text-sm font-bold text-white">{{ $initials }}</span>
                            </div>
                        @endif

                        {{-- Patient Info --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-2">
                                <div class="min-w-0">
                                    <p class="text-[15px] font-semibold text-text-primary truncate">{{ $patientName }}</p>
                                    <p class="text-xs text-text-muted truncate mt-0.5">{{ $patient->email ?? '-' }}</p>
                                </div>

                                {{-- Status Badge --}}
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }} flex-shrink-0">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $statusConfig['dot'] }}"></span>
                                    {{ $statusConfig['label'] }}
                                </span>
                            </div>

                            {{-- Appointment Count --}}
                            <div class="flex items-center gap-1.5 mt-3">
                                <div class="inline-flex items-center gap-1 px-2 py-1 rounded-lg bg-[#1e3a5f]/10 text-[#1e3a5f] text-[11px] font-semibold">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    {{ $appointmentsCount }} {{ Str::plural('Appointment', $appointmentsCount) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card Actions --}}
                <div class="px-4 py-3 bg-gray-50/50 border-t border-surface-border">
                    <button onclick="viewPatientRecords({{ $patient->id }})" class="w-full flex items-center justify-center gap-2 py-2.5 text-sm font-semibold text-[#1e3a5f] bg-[#1e3a5f]/10 rounded-xl active:bg-[#1e3a5f]/20 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        View Records
                    </button>
                </div>
            </div>
        @empty
            {{-- Empty State --}}
            <div class="text-center py-16 px-4" id="empty-state">
                <div class="w-24 h-24 mx-auto rounded-3xl bg-gradient-to-br from-[#1e3a5f]/10 to-[#2d5a87]/5 flex items-center justify-center mb-5">
                    <svg class="w-12 h-12 text-[#1e3a5f]/60" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-text-primary mb-2">No Patient Records</h3>
                <p class="text-sm text-text-muted mb-6 max-w-[240px] mx-auto">No patient records are available yet. Patient records will appear here once you have consultations.</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($patients->hasPages())
    <div class="pt-2">
        {{ $patients->links('vendor.pagination.mobile-simple') }}
    </div>
    @endif
</div>

{{-- Patient Records Bottom Sheet --}}
<div id="records-sheet" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeRecordsSheet()"></div>
    <div class="absolute bottom-0 left-0 right-0 bg-white rounded-t-3xl max-h-[90vh] overflow-hidden transform translate-y-full transition-transform duration-300 ease-out" id="records-sheet-content">
        {{-- Sheet Handle --}}
        <div class="flex justify-center pt-3 pb-1">
            <div class="w-10 h-1 rounded-full bg-gray-300"></div>
        </div>

        {{-- Sheet Header --}}
        <div class="px-5 pb-3 border-b border-surface-border flex items-center justify-between">
            <h3 class="text-lg font-bold text-text-primary" id="records-sheet-title">Patient Records</h3>
            <button onclick="closeRecordsSheet()" class="w-8 h-8 rounded-full bg-surface flex items-center justify-center">
                <svg class="w-4 h-4 text-text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Sheet Body --}}
        <div class="overflow-y-auto max-h-[calc(90vh-120px)]" id="records-detail-content">
            <div class="flex items-center justify-center py-12">
                <div class="w-8 h-8 border-2 border-[#1e3a5f] border-t-transparent rounded-full animate-spin"></div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
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

    .patient-card {
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
    .record-section {
        border-bottom: 1px solid #f1f5f9;
        padding: 1rem 1.25rem;
    }
    .record-section:last-child {
        border-bottom: none;
    }
    .record-section-title {
        font-size: 0.7rem;
        font-weight: 600;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.75rem;
    }
    .record-item {
        background: #f8fafc;
        border-radius: 0.75rem;
        padding: 0.75rem;
        margin-bottom: 0.5rem;
        border: 1px solid #f1f5f9;
    }
    .record-item:last-child {
        margin-bottom: 0;
    }
</style>
@endpush

@push('scripts')
<script>
let recordsSheetOpen = false;

async function viewPatientRecords(id) {
    const sheet = document.getElementById('records-sheet');
    const sheetContent = document.getElementById('records-sheet-content');
    const content = document.getElementById('records-detail-content');
    const title = document.getElementById('records-sheet-title');

    sheet.classList.remove('hidden');
    document.body.style.overflow = 'hidden';

    content.innerHTML = '<div class="flex items-center justify-center py-12"><div class="w-8 h-8 border-2 border-[#1e3a5f] border-t-transparent rounded-full animate-spin"></div></div>';

    requestAnimationFrame(() => {
        sheetContent.classList.add('sheet-open');
    });

    recordsSheetOpen = true;

    try {
        const response = await fetch(`/doctor/records/${id}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
        });
        const data = await response.json();

        if (data.success) {
            const p = data.patient;
            const patientName = `${p.first_name || ''} ${p.last_name || ''}`.trim() || 'Patient';
            const patientInitial = `${(p.first_name || '').charAt(0)}${(p.last_name || '').charAt(0)}`.toUpperCase();

            title.textContent = patientName;

            let html = '';

            {{-- Patient Info Header --}}
            html += `
                <div class="p-5 bg-gradient-to-br from-[#1e3a5f] to-[#2d5a87] text-white">
                    <div class="flex items-center gap-4">
                        ${p.photo
                            ? '<div class="w-16 h-16 rounded-2xl overflow-hidden ring-2 ring-white/30 flex-shrink-0"><img src="{{ asset('uploads/patients') }}/' + p.photo + '" alt="" class="w-full h-full object-cover"></div>'
                            : '<div class="w-16 h-16 rounded-2xl bg-white/20 flex items-center justify-center ring-2 ring-white/30 flex-shrink-0"><span class="text-xl font-bold">${patientInitial}</span></div>'
                        }
                        <div class="min-w-0">
                            <p class="text-lg font-bold truncate">${patientName}</p>
                            <p class="text-sm text-white/70 truncate">${p.email || '-'}</p>
                            ${p.phone ? '<p class="text-sm text-white/70 mt-0.5">' + p.phone + '</p>' : ''}
                        </div>
                    </div>
                    <div class="flex items-center gap-3 mt-4">
                        <div class="flex items-center gap-1.5 px-3 py-1.5 bg-white/20 rounded-lg text-sm font-medium">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            ${data.appointments.length} ${data.appointments.length === 1 ? 'Appointment' : 'Appointments'}
                        </div>
                        <div class="flex items-center gap-1.5 px-3 py-1.5 bg-white/20 rounded-lg text-sm font-medium">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            ${data.documents.length} Documents
                        </div>
                    </div>
                </div>
            `;

            {{-- Tab Navigation --}}
            html += `
                <div class="flex border-b border-surface-border bg-white sticky top-0 z-10">
                    <button onclick="switchTab('appointments')" class="record-tab flex-1 py-3 text-sm font-semibold text-center transition-colors border-b-2 border-[#1e3a5f] text-[#1e3a5f]" data-tab="appointments">
                        Appointments
                    </button>
                    <button onclick="switchTab('prescriptions')" class="record-tab flex-1 py-3 text-sm font-semibold text-center transition-colors border-b-2 border-transparent text-text-muted" data-tab="prescriptions">
                        Prescriptions
                    </button>
                    <button onclick="switchTab('documents')" class="record-tab flex-1 py-3 text-sm font-semibold text-center transition-colors border-b-2 border-transparent text-text-muted" data-tab="documents">
                        Documents
                    </button>
                </div>
            `;

            {{-- Content Panels --}}
            html += '<div id="tab-content">';

            {{-- Appointments Panel --}}
            html += `<div id="panel-appointments" class="record-panel">`;
            if (data.appointments.length > 0) {
                data.appointments.forEach(a => {
                    const apptDate = new Date(a.appointment_date).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                    const apptTime = a.appointment_time ? new Date('2000-01-01T' + a.appointment_time).toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit' }) : '';
                    const typeLabel = a.type === 'telemedicine' ? 'Telemedicine' : 'Clinic Visit';
                    const typeIcon = a.type === 'telemedicine'
                        ? '<svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>'
                        : '<svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>';
                    const statusColor = matchStatus(a.status);

                    html += `
                        <div class="record-item">
                            <div class="flex items-start justify-between gap-2">
                                <div class="min-w-0">
                                    <div class="flex items-center gap-1.5 mb-1">
                                        <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded text-[10px] font-semibold ${a.type === 'telemedicine' ? 'bg-[#1e3a5f]/10 text-[#1e3a5f]' : 'bg-primary-50 text-primary-700'}">
                                            ${typeIcon} ${typeLabel}
                                        </span>
                                    </div>
                                    <p class="text-sm font-medium text-text-primary">${apptDate} ${apptTime ? 'at ' + apptTime : ''}</p>
                                    ${a.specialization ? '<p class="text-xs text-text-muted mt-0.5">' + a.specialization.name + '</p>' : ''}
                                </div>
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-semibold ${statusColor.bg} ${statusColor.text}">
                                    <span class="w-1 h-1 rounded-full ${statusColor.dot}"></span>
                                    ${statusColor.label}
                                </span>
                            </div>
                        </div>
                    `;
                });
            } else {
                html += `
                    <div class="text-center py-12 px-4">
                        <div class="w-16 h-16 mx-auto rounded-2xl bg-surface flex items-center justify-center mb-3">
                            <svg class="w-8 h-8 text-text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <p class="text-sm text-text-muted">No appointments yet</p>
                    </div>
                `;
            }
            html += `</div>`;

            {{-- Prescriptions Panel --}}
            html += `<div id="panel-prescriptions" class="record-panel hidden">`;
            if (data.prescriptions.length > 0) {
                data.prescriptions.forEach(rx => {
                    const rxDate = new Date(rx.prescription_date || rx.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                    const doctorName = rx.doctor ? `${rx.doctor.first_name || ''} ${rx.doctor.last_name || ''}`.trim() : '-';

                    html += `
                        <div class="record-item">
                            <div class="flex items-start justify-between gap-2">
                                <div class="min-w-0">
                                    <p class="text-sm font-medium text-text-primary">Dr. ${doctorName}</p>
                                    <p class="text-xs text-text-muted mt-0.5">${rxDate}</p>
                                    ${rx.diagnosis ? '<p class="text-xs text-text-secondary mt-1 line-clamp-2">' + rx.diagnosis + '</p>' : ''}
                                </div>
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-semibold bg-primary-50 text-primary-700">
                                    ${rx.medicines ? rx.medicines.length + ' meds' : 'Prescription'}
                                </span>
                            </div>
                        </div>
                    `;
                });
            } else {
                html += `
                    <div class="text-center py-12 px-4">
                        <div class="w-16 h-16 mx-auto rounded-2xl bg-surface flex items-center justify-center mb-3">
                            <svg class="w-8 h-8 text-text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                        </div>
                        <p class="text-sm text-text-muted">No prescriptions yet</p>
                    </div>
                `;
            }
            html += `</div>`;

            {{-- Documents Panel --}}
            html += `<div id="panel-documents" class="record-panel hidden">`;
            if (data.documents.length > 0) {
                data.documents.forEach(doc => {
                    const docDate = new Date(doc.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                    const fileExt = doc.original_name ? doc.original_name.split('.').pop().toUpperCase() : 'FILE';
                    const extColor = fileExt === 'PDF' ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700';

                    html += `
                        <div class="record-item">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 rounded-lg ${extColor} flex items-center justify-center flex-shrink-0">
                                    <span class="text-xs font-bold">${fileExt}</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-text-primary truncate">${doc.original_name || 'Document'}</p>
                                    <p class="text-xs text-text-muted mt-0.5">${docDate}</p>
                                    ${doc.document_type_label ? '<p class="text-xs text-text-secondary mt-0.5">' + doc.document_type_label + '</p>' : ''}
                                </div>
                            </div>
                        </div>
                    `;
                });
            } else {
                html += `
                    <div class="text-center py-12 px-4">
                        <div class="w-16 h-16 mx-auto rounded-2xl bg-surface flex items-center justify-center mb-3">
                            <svg class="w-8 h-8 text-text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <p class="text-sm text-text-muted">No documents yet</p>
                    </div>
                `;
            }
            html += `</div>`;

            html += '</div>';

            content.innerHTML = html;
        } else {
            content.innerHTML = '<div class="text-center py-12"><p class="text-text-muted">Failed to load patient records.</p></div>';
        }
    } catch (error) {
        content.innerHTML = '<div class="text-center py-12"><p class="text-text-muted">An error occurred. Please try again.</p></div>';
    }
}

function switchTab(tab) {
    document.querySelectorAll('.record-tab').forEach(t => {
        t.classList.remove('border-[#1e3a5f]', 'text-[#1e3a5f]');
        t.classList.add('border-transparent', 'text-text-muted');
    });
    document.querySelectorAll('.record-panel').forEach(p => p.classList.add('hidden'));

    const activeTab = document.querySelector(`.record-tab[data-tab="${tab}"]`);
    const activePanel = document.getElementById(`panel-${tab}`);

    if (activeTab) {
        activeTab.classList.add('border-[#1e3a5f]', 'text-[#1e3a5f]');
        activeTab.classList.remove('border-transparent', 'text-text-muted');
    }
    if (activePanel) {
        activePanel.classList.remove('hidden');
    }
}

function matchStatus(status) {
    const map = {
        pending: { bg: 'bg-amber-50', text: 'text-amber-700', dot: 'bg-amber-400', label: 'Pending' },
        approved: { bg: 'bg-emerald-50', text: 'text-emerald-700', dot: 'bg-emerald-400', label: 'Approved' },
        scheduled: { bg: 'bg-blue-50', text: 'text-blue-700', dot: 'bg-blue-400', label: 'Scheduled' },
        doctor_assigned: { bg: 'bg-indigo-50', text: 'text-indigo-700', dot: 'bg-indigo-400', label: 'Assigned' },
        completed: { bg: 'bg-[#e6f7f5]', text: 'text-[#0d7a6e]', dot: 'bg-[#0d9488]', label: 'Completed' },
        cancelled: { bg: 'bg-red-50', text: 'text-red-700', dot: 'bg-red-400', label: 'Cancelled' },
        rejected: { bg: 'bg-red-50', text: 'text-red-700', dot: 'bg-red-400', label: 'Rejected' },
        no_show: { bg: 'bg-gray-100', text: 'text-gray-600', dot: 'bg-gray-400', label: 'No Show' },
    };
    return map[status] || { bg: 'bg-gray-50', text: 'text-gray-700', dot: 'bg-gray-400', label: status };
}

function closeRecordsSheet() {
    const sheetContent = document.getElementById('records-sheet-content');
    const sheet = document.getElementById('records-sheet');

    sheetContent.classList.remove('sheet-open');
    sheetContent.style.transform = 'translateY(100%)';

    setTimeout(() => {
        sheet.classList.add('hidden');
        sheetContent.style.transform = '';
        document.body.style.overflow = '';
        recordsSheetOpen = false;
    }, 300);
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && recordsSheetOpen) {
        closeRecordsSheet();
    }
});
</script>
@endpush
@endsection
