@extends('layouts.patient')

@section('title', 'Book Telemedicine - Lakeshore Clinic')
@section('page-title', 'Book Telemedicine Consultation')

@section('content')
<div class="space-y-6">
    <x-page-header title="Book Telemedicine Consultation">
        <x-slot name="subtitle">Schedule a virtual consultation with a doctor</x-slot>
    </x-page-header>

    <x-card variant="default" class="p-6">
        <form id="telemedicine-form" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="type" value="telemedicine">

            <div class="space-y-6">
                <div>
                    <h3 class="text-lg font-semibold text-text-primary mb-4">1. Select Specialization</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach($specializations as $spec)
                            <label class="flex items-center gap-3 p-4 border border-surface-border rounded-lg cursor-pointer hover:border-primary-300 hover:bg-primary-50/50 transition-all">
                                <input type="radio" name="specialization_id" value="{{ $spec->id }}" class="w-4 h-4 text-primary-600 focus:ring-primary-500" required>
                                <div>
                                    <p class="text-sm font-medium text-text-primary">{{ $spec->name }}</p>
                                    <p class="text-xs text-text-muted">{{ $spec->description ?? 'Medical specialization' }}</p>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-text-primary mb-4">2. Select Doctor</h3>
                    <div id="doctors-list" class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <p class="text-sm text-text-muted">Select a specialization first</p>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-text-primary mb-4">3. Select Date & Time</h3>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-text-primary mb-2">Available Dates</label>
                        <div id="dates-list" class="grid grid-cols-3 sm:grid-cols-5 gap-2">
                            <p class="text-sm text-text-muted">Select a doctor first</p>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-text-primary mb-2">Available Time Slots</label>
                        <div id="slots-list" class="grid grid-cols-3 sm:grid-cols-4 gap-2">
                            <p class="text-sm text-text-muted">Select a date first</p>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-text-primary mb-4">4. Patient Information</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <x-input label="Full Name" name="patient_name" :value="auth()->user()->name" required />
                        <x-input label="Email" name="patient_email" type="email" :value="auth()->user()->email" required />
                    </div>
                    <x-input label="Phone Number" name="patient_phone" class="mt-4" />
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-text-primary mb-4">5. Consultation Details</h3>
                    <div class="space-y-4">
                        <x-textarea label="Reason for Consultation" name="reason" rows="2" required placeholder="e.g., Follow-up consultation, new symptoms..." />
                        <x-textarea label="Symptoms" name="symptoms" rows="2" placeholder="Describe any symptoms you're experiencing..." />
                        <x-textarea label="Existing Conditions" name="existing_conditions" rows="2" placeholder="Any existing medical conditions..." />
                        <x-textarea label="Current Medications" name="current_medications" rows="2" placeholder="Any medications you're currently taking..." />
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-text-primary mb-4">6. Medical Documents (Optional)</h3>
                    <div class="border-2 border-dashed border-surface-border rounded-xl p-6 text-center hover:border-primary-400 transition-colors">
                        <input type="file" id="documents-input" name="documents[]" multiple accept=".pdf,.jpg,.jpeg,.png" class="hidden">
                        <div class="w-12 h-12 mx-auto rounded-full bg-surface flex items-center justify-center mb-3 cursor-pointer" onclick="document.getElementById('documents-input').click()">
                            <svg class="w-6 h-6 text-text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                        </div>
                        <p class="text-sm text-text-secondary mb-1">Click to upload or drag and drop</p>
                        <p class="text-xs text-text-muted">PDF, JPG, PNG up to 2MB each</p>
                    </div>
                    <div id="files-list" class="mt-3 space-y-2"></div>
                </div>

                <div class="p-4 bg-surface rounded-lg">
                    <h3 class="text-sm font-semibold text-text-primary mb-2">Booking Summary</h3>
                    <div class="grid grid-cols-2 gap-2 text-sm">
                        <div><span class="text-text-muted">Type:</span> <span class="text-text-primary font-medium">Telemedicine</span></div>
                        <div><span class="text-text-muted">Specialization:</span> <span id="summary-spec" class="text-text-primary">-</span></div>
                        <div><span class="text-text-muted">Doctor:</span> <span id="summary-doctor" class="text-text-primary">-</span></div>
                        <div><span class="text-text-muted">Date:</span> <span id="summary-date" class="text-text-primary">-</span></div>
                        <div><span class="text-text-muted">Time:</span> <span id="summary-time" class="text-text-primary">-</span></div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" id="submit-btn" class="px-6 py-2.5 text-sm font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-700 transition-colors">
                        <span id="submit-text">Book Consultation</span>
                        <svg id="submit-spinner" class="hidden animate-spin w-4 h-4 ml-1.5 inline" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </form>
    </x-card>

    <div id="booking-success" class="hidden text-center py-12">
        <x-card variant="default" class="p-12">
            <div class="w-20 h-20 mx-auto rounded-full bg-health-100 flex items-center justify-center mb-6">
                <svg class="w-10 h-10 text-health-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-text-primary mb-2">Consultation Booked!</h2>
            <p class="text-text-secondary mb-6">Your telemedicine consultation has been submitted for review. You will receive a confirmation shortly.</p>
            <a href="{{ route('patient.dashboard') }}" class="px-6 py-2.5 text-sm font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-700 transition-colors">
                Go to Dashboard
            </a>
        </x-card>
    </div>
</div>

@push('scripts')
<script>
let selectedSpecialization = null;
let selectedDoctor = null;
let selectedDate = null;
let selectedTime = null;

const specializations = @json($specializations);

document.querySelector('input[name="specialization_id"]').addEventListener('change', loadDoctors);
document.getElementById('telemedicine-form').addEventListener('submit', submitBooking);
document.getElementById('documents-input').addEventListener('change', handleFiles);

async function loadDoctors() {
    const specId = document.querySelector('input[name="specialization_id"]:checked').value;
    selectedSpecialization = specializations.find(s => s.id == specId);

    try {
        const response = await fetch(`/patient/booking/doctors?specialization_id=${specId}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
        });
        const data = await response.json();

        if (data.success) {
            const container = document.getElementById('doctors-list');
            if (data.doctors.length === 0) {
                container.innerHTML = '<p class="text-sm text-text-muted col-span-2">No doctors available.</p>';
            } else {
                container.innerHTML = data.doctors.map(doc => `
                    <label class="flex items-center gap-3 p-4 border border-surface-border rounded-lg cursor-pointer hover:border-primary-300 hover:bg-primary-50/50 transition-all">
                        <input type="radio" name="doctor_id" value="${doc.id}" onchange="selectDoctor(${doc.id}, '${doc.name}')" class="w-4 h-4 text-primary-600 focus:ring-primary-500">
                        <div>
                            <p class="text-sm font-medium text-text-primary">${doc.name}</p>
                        </div>
                    </label>
                `).join('');
            }
        }
    } catch (error) {
        showToast('Failed to load doctors.', 'error');
    }
}

function selectDoctor(id, name) {
    selectedDoctor = { id, name };
    selectedDate = null;
    selectedTime = null;
    loadDates();
}

async function loadDates() {
    try {
        const response = await fetch(`/patient/booking/dates?doctor_id=${selectedDoctor.id}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
        });
        const data = await response.json();

        if (data.success) {
            const container = document.getElementById('dates-list');
            if (data.dates.length === 0) {
                container.innerHTML = '<p class="text-sm text-text-muted col-span-5">No available dates.</p>';
            } else {
                container.innerHTML = data.dates.map(d => `
                    <button type="button" onclick="selectDate('${d.date}', '${d.formatted}')" class="p-3 border border-surface-border rounded-lg text-center hover:border-primary-300 hover:bg-primary-50/50 transition-all date-btn">
                        <p class="text-xs text-text-muted">${d.day}</p>
                        <p class="text-sm font-medium text-text-primary">${d.formatted.split(',')[0]}</p>
                    </button>
                `).join('');
            }
        }
    } catch (error) {
        showToast('Failed to load dates.', 'error');
    }
}

async function selectDate(date, formatted) {
    selectedDate = { date, formatted };
    selectedTime = null;

    document.querySelectorAll('.date-btn').forEach(btn => btn.classList.remove('border-primary-500', 'bg-primary-50'));
    event.currentTarget.classList.add('border-primary-500', 'bg-primary-50');

    try {
        const response = await fetch(`/patient/booking/slots?doctor_id=${selectedDoctor.id}&date=${date}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
        });
        const data = await response.json();

        if (data.success) {
            const container = document.getElementById('slots-list');
            if (data.slots.length === 0) {
                container.innerHTML = '<p class="text-sm text-text-muted col-span-4">No available slots.</p>';
            } else {
                container.innerHTML = data.slots.map(slot => `
                    <button type="button" onclick="selectTime('${slot.start_time}', '${formatTime(slot.start_time)}')" class="p-3 border border-surface-border rounded-lg text-center hover:border-primary-300 hover:bg-primary-50/50 transition-all slot-btn">
                        <p class="text-sm font-medium text-text-primary">${formatTime(slot.start_time)}</p>
                    </button>
                `).join('');
            }
        }
    } catch (error) {
        showToast('Failed to load time slots.', 'error');
    }
}

function selectTime(time, formatted) {
    selectedTime = { time, formatted };
    document.querySelectorAll('.slot-btn').forEach(btn => btn.classList.remove('border-primary-500', 'bg-primary-50'));
    event.currentTarget.classList.add('border-primary-500', 'bg-primary-50');

    document.getElementById('summary-spec').textContent = selectedSpecialization?.name || '-';
    document.getElementById('summary-doctor').textContent = selectedDoctor?.name || '-';
    document.getElementById('summary-date').textContent = selectedDate?.formatted || '-';
    document.getElementById('summary-time').textContent = selectedTime?.formatted || '-';
}

function formatTime(time) {
    const [hours, minutes] = time.split(':');
    const h = parseInt(hours);
    const ampm = h >= 12 ? 'PM' : 'AM';
    const h12 = h % 12 || 12;
    return `${h12}:${minutes} ${ampm}`;
}

function handleFiles(e) {
    const files = Array.from(e.target.files);
    const container = document.getElementById('files-list');
    container.innerHTML = files.map(f => `
        <div class="flex items-center gap-3 p-3 bg-surface rounded-lg">
            <svg class="w-5 h-5 text-text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <span class="text-sm text-text-primary flex-1">${f.name}</span>
            <span class="text-xs text-text-muted">${(f.size / 1024).toFixed(1)} KB</span>
        </div>
    `).join('');
}

async function submitBooking(e) {
    e.preventDefault();

    if (!selectedDoctor || !selectedDate || !selectedTime) {
        showToast('Please complete all selections.', 'error');
        return;
    }

    const btn = document.getElementById('submit-btn');
    const btnText = document.getElementById('submit-text');
    const btnSpinner = document.getElementById('submit-spinner');

    btn.disabled = true;
    btnText.textContent = 'Booking...';
    btnSpinner.classList.remove('hidden');

    const form = document.getElementById('telemedicine-form');
    const formData = new FormData(form);
    formData.append('specialization_id', selectedSpecialization.id);
    formData.append('doctor_id', selectedDoctor.id);
    formData.append('appointment_date', selectedDate.date);
    formData.append('appointment_time', selectedTime.time);

    try {
        const response = await fetch('{{ route("patient.telemedicine.store") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
        });

        const data = await response.json();

        if (response.ok && data.success) {
            document.getElementById('telemedicine-form').parentElement.classList.add('hidden');
            document.getElementById('booking-success').classList.remove('hidden');
            showToast(data.message, 'success');
        } else {
            showToast(data.message || 'Failed to book consultation.', 'error');
        }
    } catch (error) {
        showToast('An error occurred. Please try again.', 'error');
    } finally {
        btn.disabled = false;
        btnText.textContent = 'Book Consultation';
        btnSpinner.classList.add('hidden');
    }
}
</script>
@endpush
@endsection
