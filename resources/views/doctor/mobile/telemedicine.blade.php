@extends('layouts.doctor-mobile')

@section('title', 'Telemedicine Sessions - Lakeshore Clinic')
@section('page-title', 'Telemedicine')

@section('content')
<div class="space-y-4">
    @forelse($meetings as $meeting)
        @php
            $appointment = $meeting->appointment;
            $patient = $appointment?->patient;
            $patientName = $patient ? trim($patient->first_name . ' ' . $patient->last_name) : ($appointment->patient_name ?? 'Patient');
            $initials = strtoupper(substr($patient->first_name ?? 'P', 0, 1) . substr($patient->last_name ?? '', 0, 1));
            $statusConfig = match($meeting->status ?? 'pending') {
                'created' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'dot' => 'bg-emerald-400', 'label' => 'Ready'],
                'pending' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'dot' => 'bg-amber-400', 'label' => 'Pending'],
                'active' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-700', 'dot' => 'bg-blue-400', 'label' => 'Active'],
                'completed' => ['bg' => 'bg-health-50', 'text' => 'text-health-700', 'dot' => 'bg-health-400', 'label' => 'Completed'],
                'cancelled' => ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'dot' => 'bg-red-400', 'label' => 'Cancelled'],
                default => ['bg' => 'bg-gray-50', 'text' => 'text-gray-700', 'dot' => 'bg-gray-400', 'label' => ucfirst($meeting->status ?? 'pending')],
            };
        @endphp
        <div class="mobile-card bg-white rounded-2xl p-4 shadow-sm border border-surface-border" data-meeting-id="{{ $meeting->id }}">
            <div class="flex items-start justify-between mb-3">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-full bg-gradient-to-br from-[#1e3a5f] to-[#2d5a87] flex items-center justify-center flex-shrink-0 shadow-sm">
                        <span class="text-sm font-bold text-white">{{ $initials }}</span>
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-text-primary truncate">{{ $patientName }}</p>
                        <p class="text-xs text-text-muted">{{ $appointment->specialization?->name ?? '-' }}</p>
                    </div>
                </div>
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }} flex-shrink-0">
                    <span class="w-1.5 h-1.5 rounded-full {{ $statusConfig['dot'] }}"></span>
                    {{ $statusConfig['label'] }}
                </span>
            </div>

            <div class="grid grid-cols-2 gap-2 mb-3">
                <div class="flex items-center gap-1.5 text-sm text-text-secondary">
                    <svg class="w-4 h-4 text-text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span class="font-medium">{{ $appointment->appointment_date->format('M d, Y') }}</span>
                </div>
                <div class="flex items-center gap-1.5 text-sm text-text-secondary">
                    <svg class="w-4 h-4 text-text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span class="font-medium">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}</span>
                </div>
            </div>

            @if($meeting->meeting_id)
                <div class="flex items-center gap-1.5 text-xs text-text-muted mb-3 bg-gray-50 rounded-lg px-3 py-2">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                    <span class="font-mono truncate">ID: {{ $meeting->meeting_id }}</span>
                </div>
            @endif

            <div class="flex items-center gap-2">
                @if($meeting->meeting_url)
                    <a href="{{ $meeting->meeting_url }}" target="_blank" class="flex-1 flex items-center justify-center gap-2 py-2.5 text-sm font-semibold text-white bg-[#1e3a5f] rounded-xl active:bg-[#2d5a87] transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Join Meeting
                    </a>
                @else
                    <button disabled class="flex-1 flex items-center justify-center gap-2 py-2.5 text-sm font-semibold text-gray-400 bg-gray-100 rounded-xl cursor-not-allowed">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Pending
                    </button>
                @endif
                <button onclick="openMeetingDetail({{ $meeting->id }})" class="w-11 h-11 flex items-center justify-center rounded-xl border border-surface-border text-text-muted hover:bg-gray-50 active:bg-gray-100 transition-colors flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </button>
            </div>
        </div>
    @empty
        <div class="text-center py-16 px-4">
            <div class="w-24 h-24 mx-auto rounded-3xl bg-gradient-to-br from-[#1e3a5f]/10 to-[#1e3a5f]/5 flex items-center justify-center mb-5">
                <svg class="w-12 h-12 text-[#1e3a5f]/60" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
            </div>
            <h3 class="text-lg font-bold text-text-primary mb-2">No Sessions Yet</h3>
            <p class="text-sm text-text-muted mb-6 max-w-[240px] mx-auto">Your telemedicine sessions will appear here</p>
        </div>
    @endforelse

    @if($meetings->hasPages())
        <div class="py-4">
            {{ $meetings->links() }}
        </div>
    @endif
</div>

<div id="bottom-sheet-overlay" class="fixed inset-0 bg-black/50 z-50 hidden" onclick="closeBottomSheet()"></div>
<div id="bottom-sheet" class="fixed bottom-0 left-0 right-0 z-50 bg-white rounded-t-3xl shadow-2xl transform translate-y-full transition-transform duration-300 ease-out" style="max-height: 85vh;">
    <div class="flex justify-center pt-3 pb-2">
        <div class="w-10 h-1 rounded-full bg-gray-300"></div>
    </div>
    <div id="bottom-sheet-handle" class="cursor-grab active:cursor-grabbing px-4 pb-2 border-b border-surface-border">
        <h3 id="sheet-title" class="text-lg font-bold text-text-primary"></h3>
    </div>
    <div id="bottom-sheet-content" class="p-4 overflow-y-auto" style="max-height: calc(85vh - 80px);"></div>
</div>

@push('styles')
<style>
    #bottom-sheet.open { transform: translateY(0); }
    #bottom-sheet-overlay.show { display: block; }
</style>
@endpush

@push('scripts')
<script>
const overlay = document.getElementById('bottom-sheet-overlay');
const sheet = document.getElementById('bottom-sheet');
const sheetContent = document.getElementById('bottom-sheet-content');
const sheetTitle = document.getElementById('sheet-title');
let startY = 0, currentY = 0, isDragging = false;

document.getElementById('bottom-sheet-handle').addEventListener('touchstart', function(e) {
    isDragging = true;
    startY = e.touches[0].clientY;
    sheet.style.transition = 'none';
});
document.addEventListener('touchmove', function(e) {
    if (!isDragging) return;
    currentY = e.touches[0].clientY - startY;
    if (currentY > 0) sheet.style.transform = `translateY(${currentY}px)`;
});
document.addEventListener('touchend', function() {
    if (!isDragging) return;
    isDragging = false;
    sheet.style.transition = '';
    if (currentY > 100) closeBottomSheet();
    else sheet.style.transform = 'translateY(0)';
    currentY = 0;
});

function openBottomSheet(title, html) {
    sheetTitle.textContent = title;
    sheetContent.innerHTML = html;
    overlay.classList.remove('hidden');
    requestAnimationFrame(() => {
        overlay.classList.add('show');
        sheet.classList.add('open');
    });
}

function closeBottomSheet() {
    sheet.classList.remove('open');
    overlay.classList.remove('show');
    setTimeout(() => overlay.classList.add('hidden'), 300);
}

async function openMeetingDetail(id) {
    sheetContent.innerHTML = `
        <div class="space-y-4">
            <div class="flex items-center gap-3 animate-pulse">
                <div class="w-12 h-12 rounded-full bg-gray-200"></div>
                <div class="flex-1"><div class="h-4 bg-gray-200 rounded w-1/2 mb-2"></div><div class="h-3 bg-gray-200 rounded w-1/3"></div></div>
            </div>
            <div class="space-y-3"><div class="h-20 bg-gray-100 rounded-xl"></div><div class="h-20 bg-gray-100 rounded-xl"></div></div>
        </div>`;
    openBottomSheet('Session Details', sheetContent.innerHTML);

    try {
        const response = await fetch(`/doctor/telemedicine/${id}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
        });
        const data = await response.json();

        if (data.success) {
            const m = data.meeting || data.appointment;
            const a = m.appointment || m;
            const meetingId = m.meeting_id || '-';
            const meetingUrl = m.meeting_url || '';
            const meetingStatus = m.status || 'pending';
            const statusColors = {
                pending: 'bg-amber-50 text-amber-700', created: 'bg-emerald-50 text-emerald-700',
                active: 'bg-blue-50 text-blue-700', completed: 'bg-health-50 text-health-700',
                cancelled: 'bg-red-50 text-red-700',
            };
            const dotColors = {
                pending: 'bg-amber-400', created: 'bg-emerald-400',
                active: 'bg-blue-400', completed: 'bg-health-400',
                cancelled: 'bg-red-400',
            };
            const statusLabel = m.status_label || meetingStatus.charAt(0).toUpperCase() + meetingStatus.slice(1);
            const patientName = a.patient_name || (a.patient ? a.patient.first_name + ' ' + a.patient.last_name : '-');
            const patientEmail = a.patient_email || a.patient?.email || '-';
            const specName = a.specialization?.name || '-';
            const dateStr = a.appointment_date ? new Date(a.appointment_date).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }) : '-';
            const timeStr = a.appointment_time || '-';
            const reason = a.reason || '-';
            const symptoms = a.symptoms || '';
            const notes = a.notes || '';

            sheetContent.innerHTML = `
                <div class="space-y-4">
                    <div class="flex items-start gap-3">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-[#1e3a5f] to-[#2d5a87] flex items-center justify-center flex-shrink-0 shadow-sm">
                            <span class="text-sm font-bold text-white">${patientName.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase()}</span>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-base font-semibold text-text-primary">${patientName}</p>
                            <p class="text-xs text-text-muted">${patientEmail}</p>
                        </div>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold ${statusColors[meetingStatus] || 'bg-gray-50 text-gray-700'} flex-shrink-0">
                            <span class="w-1.5 h-1.5 rounded-full ${dotColors[meetingStatus] || 'bg-gray-400'}"></span>
                            ${statusLabel}
                        </span>
                    </div>

                    <div class="bg-surface rounded-xl p-4 space-y-3">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-[#1e3a5f]/10 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-[#1e3a5f]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            </div>
                            <div>
                                <p class="text-xs text-text-muted">Specialization</p>
                                <p class="text-sm font-medium text-text-primary">${specName}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <p class="text-xs text-text-muted">Date & Time</p>
                                <p class="text-sm font-medium text-text-primary">${dateStr} at ${timeStr}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <p class="text-xs text-text-muted">Meeting ID</p>
                                <p class="text-sm font-medium text-text-primary font-mono">${meetingId}</p>
                            </div>
                        </div>
                    </div>

                    ${reason !== '-' ? `
                    <div class="bg-surface rounded-xl p-4">
                        <p class="text-xs text-text-muted mb-1">Reason</p>
                        <p class="text-sm text-text-primary">${reason}</p>
                    </div>` : ''}

                    ${symptoms ? `
                    <div class="bg-surface rounded-xl p-4">
                        <p class="text-xs text-text-muted mb-1">Symptoms</p>
                        <p class="text-sm text-text-primary">${symptoms}</p>
                    </div>` : ''}

                    ${notes ? `
                    <div class="bg-surface rounded-xl p-4">
                        <p class="text-xs text-text-muted mb-1">Notes</p>
                        <p class="text-sm text-text-primary whitespace-pre-line">${notes}</p>
                    </div>` : ''}

                    ${meetingUrl ? `
                    <a href="${meetingUrl}" target="_blank" class="flex items-center justify-center gap-2 w-full py-3 bg-[#1e3a5f] text-white rounded-xl font-semibold shadow-lg shadow-[#1e3a5f]/20 active:bg-[#2d5a87] transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Join Meeting
                    </a>` : `
                    <div class="flex items-center justify-center gap-2 w-full py-3 bg-gray-100 text-gray-400 rounded-xl font-semibold cursor-not-allowed">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Meeting Pending
                    </div>`}
                </div>`;
        }
    } catch (error) {
        sheetContent.innerHTML = `
            <div class="text-center py-8">
                <div class="w-14 h-14 mx-auto rounded-2xl bg-red-50 flex items-center justify-center mb-3">
                    <svg class="w-7 h-7 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                </div>
                <p class="text-sm text-text-muted">Failed to load session details</p>
                <button onclick="openMeetingDetail(${id})" class="mt-3 text-sm font-semibold text-[#1e3a5f]">Retry</button>
            </div>`;
    }
}

document.addEventListener('keydown', function(e) { if (e.key === 'Escape') closeBottomSheet(); });
</script>
@endpush
@endsection
