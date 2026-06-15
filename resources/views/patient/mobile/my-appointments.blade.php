@extends('layouts.patient-mobile')

@section('title', 'My Appointments - Lakeshore Clinic')
@section('page-title', 'Appointments')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-text-primary">My Appointments</h2>
            <p class="text-sm text-text-muted">{{ $appointments->count() }} appointment{{ $appointments->count() !== 1 ? 's' : '' }}</p>
        </div>
        <a href="{{ route('patient.book-appointment') }}" class="w-10 h-10 rounded-full bg-[#0d9488] flex items-center justify-center text-white shadow-lg">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        </a>
    </div>

    <div class="flex gap-2 overflow-x-auto pb-2 -mx-4 px-4">
        <button onclick="filterAppointments('all')" class="filter-btn px-4 py-2 rounded-full text-sm font-medium bg-[#0d9488] text-white whitespace-nowrap">All</button>
        <button onclick="filterAppointments('upcoming')" class="filter-btn px-4 py-2 rounded-full text-sm font-medium bg-white text-text-secondary border border-surface-border whitespace-nowrap">Upcoming</button>
        <button onclick="filterAppointments('completed')" class="filter-btn px-4 py-2 rounded-full text-sm font-medium bg-white text-text-secondary border border-surface-border whitespace-nowrap">Completed</button>
        <button onclick="filterAppointments('cancelled')" class="filter-btn px-4 py-2 rounded-full text-sm font-medium bg-white text-text-secondary border border-surface-border whitespace-nowrap">Cancelled</button>
        <button onclick="filterAppointments('telemedicine')" class="filter-btn px-4 py-2 rounded-full text-sm font-medium bg-white text-text-secondary border border-surface-border whitespace-nowrap">Telemedicine</button>
        <button onclick="filterAppointments('clinic')" class="filter-btn px-4 py-2 rounded-full text-sm font-medium bg-white text-text-secondary border border-surface-border whitespace-nowrap">Clinic</button>
    </div>

    <div id="appointments-list" class="space-y-3">
        @forelse($appointments as $appointment)
            <div class="appointment-card bg-white rounded-2xl p-4 shadow-sm border border-surface-border" data-status="{{ $appointment->status }}" data-type="{{ $appointment->type }}">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex items-center gap-2">
                        @if($appointment->type === 'clinic')
                            <span class="px-2 py-0.5 text-xs font-medium bg-primary-100 text-primary-700 rounded-full">Clinic</span>
                        @else
                            <span class="px-2 py-0.5 text-xs font-medium bg-[#1e3a5f]/10 text-[#1e3a5f] rounded-full">Telemedicine</span>
                        @endif
                    </div>
                    <span class="px-2 py-0.5 text-xs font-medium {{ $appointment->status === 'approved' ? 'bg-health-100 text-health-700' : ($appointment->status === 'pending' ? 'bg-amber-100 text-amber-700' : ($appointment->status === 'completed' ? 'bg-primary-100 text-primary-700' : 'bg-gray-100 text-gray-700')) }} rounded-full">{{ ucfirst($appointment->status) }}</span>
                </div>

                <div class="mb-3">
                    <p class="text-base font-semibold text-text-primary">{{ $appointment->doctor?->name ?? 'TBD' }}</p>
                    <p class="text-sm text-text-muted">{{ $appointment->specialization?->name ?? '-' }}</p>
                </div>

                <div class="flex items-center gap-4 text-sm text-text-muted mb-3">
                    <div class="flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span>{{ $appointment->appointment_date->format('M d, Y') }}</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}</span>
                    </div>
                </div>

                <div class="flex gap-2 pt-3 border-t border-surface-border">
                    <button onclick="viewAppointment({{ $appointment->id }})" class="flex-1 py-2.5 text-sm font-medium text-[#0d9488] bg-[#0d9488]/10 rounded-xl hover:bg-[#0d9488]/20 transition-colors text-center">
                        View Details
                    </button>
                    @if($appointment->status === 'scheduled' && $appointment->type === 'telemedicine')
                        <a href="#" class="flex-1 py-2.5 text-sm font-medium text-white bg-[#1e3a5f] rounded-xl hover:bg-[#2d5a87] transition-colors text-center">
                            Join Meeting
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center py-16">
                <div class="w-20 h-20 mx-auto rounded-full bg-surface flex items-center justify-center mb-4">
                    <svg class="w-10 h-10 text-text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <h3 class="text-lg font-semibold text-text-primary mb-2">No appointments yet</h3>
                <p class="text-sm text-text-muted mb-4">Book your first appointment</p>
                <a href="{{ route('patient.book-appointment') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-[#0d9488] text-white rounded-xl font-medium">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Book Now
                </a>
            </div>
        @endforelse
    </div>
</div>

@push('scripts')
<script>
let currentFilter = 'all';

function filterAppointments(filter) {
    currentFilter = filter;

    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.classList.remove('bg-[#0d9488]', 'text-white');
        btn.classList.add('bg-white', 'text-text-secondary');
    });
    event.currentTarget.classList.add('bg-[#0d9488]', 'text-white');
    event.currentTarget.classList.remove('bg-white', 'text-text-secondary');

    const cards = document.querySelectorAll('.appointment-card');
    cards.forEach(card => {
        const status = card.dataset.status;
        const type = card.dataset.type;

        let show = false;
        if (filter === 'all') show = true;
        else if (filter === 'upcoming') show = ['pending', 'approved', 'scheduled'].includes(status);
        else if (filter === 'completed') show = status === 'completed';
        else if (filter === 'cancelled') show = ['cancelled', 'rejected'].includes(status);
        else if (filter === 'telemedicine') show = type === 'telemedicine';
        else if (filter === 'clinic') show = type === 'clinic';

        card.style.display = show ? 'block' : 'none';
    });
}

function viewAppointment(id) {
    window.location.href = `/patient/appointments/${id}`;
}
</script>
@endpush
@endsection
