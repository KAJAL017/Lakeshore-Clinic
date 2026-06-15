<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Book Appointment - Lakeshore Clinic</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .booking-step { transition: opacity 0.3s ease, transform 0.3s ease; }
        .booking-step.hidden { opacity: 0; transform: translateX(20px); pointer-events: none; }
        .booking-step:not(.hidden) { opacity: 1; transform: translateX(0); }
    </style>
</head>
<body class="h-full bg-surface">
    <div id="toast-container" class="fixed top-4 right-4 z-50 flex flex-col gap-2"></div>

    <div class="min-h-full flex flex-col">
        <header class="bg-white border-b border-surface-border">
            <div class="max-w-4xl mx-auto px-4 py-4 flex items-center justify-between">
                <a href="/" class="flex items-center gap-3">
                    @php
                        $logo = \App\Models\Setting::getValue('clinic_logo');
                    @endphp
                    @if($logo)
                        <img src="{{ asset('uploads/branding/' . $logo) }}" alt="Logo" class="h-8 w-auto object-contain">
                    @else
                        <div class="w-8 h-8 rounded-lg bg-primary-500 flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </div>
                    @endif
                    <span class="text-lg font-semibold text-text-primary">Lakeshore Clinic</span>
                </a>
                <a href="{{ route('login') }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium">Sign In</a>
            </div>
        </header>

        <main class="flex-1 py-8">
            <div class="max-w-3xl mx-auto px-4">
                <div class="text-center mb-8">
                    <h1 class="text-2xl font-bold text-text-primary mb-2">Book an Appointment</h1>
                    <p class="text-text-secondary">Schedule your clinic visit in a few simple steps</p>
                </div>

                <div class="flex items-center justify-center mb-8">
                    <div class="flex items-center gap-2" id="steps-indicator">
                        <div class="flex items-center gap-2 step active" data-step="1">
                            <div class="w-8 h-8 rounded-full bg-primary-600 text-white flex items-center justify-center text-sm font-medium">1</div>
                            <span class="text-sm font-medium text-primary-600 hidden sm:block">Specialization</span>
                        </div>
                        <div class="w-8 h-px bg-surface-border step-line" data-line="1"></div>
                        <div class="flex items-center gap-2 step" data-step="2">
                            <div class="w-8 h-8 rounded-full bg-surface-border text-text-muted flex items-center justify-center text-sm font-medium">2</div>
                            <span class="text-sm font-medium text-text-muted hidden sm:block">Doctor</span>
                        </div>
                        <div class="w-8 h-px bg-surface-border step-line" data-line="2"></div>
                        <div class="flex items-center gap-2 step" data-step="3">
                            <div class="w-8 h-8 rounded-full bg-surface-border text-text-muted flex items-center justify-center text-sm font-medium">3</div>
                            <span class="text-sm font-medium text-text-muted hidden sm:block">Date & Time</span>
                        </div>
                        <div class="w-8 h-px bg-surface-border step-line" data-line="3"></div>
                        <div class="flex items-center gap-2 step" data-step="4">
                            <div class="w-8 h-8 rounded-full bg-surface-border text-text-muted flex items-center justify-center text-sm font-medium">4</div>
                            <span class="text-sm font-medium text-text-muted hidden sm:block">Details</span>
                        </div>
                    </div>
                </div>

                <x-card variant="default" class="p-6">
                    <form id="booking-form">
                        @csrf

                        <div id="step-1" class="booking-step">
                            <h2 class="text-lg font-semibold text-text-primary mb-4">Select Specialization</h2>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach($specializations as $spec)
                                    <label class="flex items-center gap-3 p-4 border border-surface-border rounded-lg cursor-pointer hover:border-primary-300 hover:bg-primary-50/50 transition-all">
                                        <input type="radio" name="specialization_id" value="{{ $spec->id }}" class="w-4 h-4 text-primary-600 focus:ring-primary-500">
                                        <div>
                                            <p class="text-sm font-medium text-text-primary">{{ $spec->name }}</p>
                                            <p class="text-xs text-text-muted">{{ $spec->description ?? 'Medical specialization' }}</p>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div id="step-2" class="booking-step hidden">
                            <h2 class="text-lg font-semibold text-text-primary mb-4">Select Doctor</h2>
                            <div id="doctors-list" class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <p class="text-sm text-text-muted col-span-2">Loading doctors...</p>
                            </div>
                        </div>

                        <div id="step-3" class="booking-step hidden">
                            <h2 class="text-lg font-semibold text-text-primary mb-4">Select Date & Time</h2>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-text-primary mb-2">Available Dates</label>
                                <div id="dates-list" class="grid grid-cols-3 sm:grid-cols-5 gap-2">
                                    <p class="text-sm text-text-muted col-span-5">Loading dates...</p>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-text-primary mb-2">Available Time Slots</label>
                                <div id="slots-list" class="grid grid-cols-3 sm:grid-cols-4 gap-2">
                                    <p class="text-sm text-text-muted col-span-4">Select a date first</p>
                                </div>
                            </div>
                        </div>

                        <div id="step-4" class="booking-step hidden">
                            <h2 class="text-lg font-semibold text-text-primary mb-4">Appointment Details</h2>
                            <div class="space-y-4">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-text-primary mb-1.5">Full Name <span class="text-red-500">*</span></label>
                                        <input type="text" name="patient_name" class="w-full px-3 py-2 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-text-primary mb-1.5">Email <span class="text-red-500">*</span></label>
                                        <input type="email" name="patient_email" class="w-full px-3 py-2 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500" required>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-text-primary mb-1.5">Phone Number</label>
                                    <input type="text" name="patient_phone" class="w-full px-3 py-2 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-text-primary mb-1.5">Reason for Visit <span class="text-red-500">*</span></label>
                                    <textarea name="reason" rows="2" class="w-full px-3 py-2 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 resize-none" required placeholder="e.g., Annual checkup, follow-up visit..."></textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-text-primary mb-1.5">Symptoms</label>
                                    <textarea name="symptoms" rows="2" class="w-full px-3 py-2 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 resize-none" placeholder="Describe any symptoms you're experiencing..."></textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-text-primary mb-1.5">Additional Notes</label>
                                    <textarea name="notes" rows="2" class="w-full px-3 py-2 text-sm bg-white border border-surface-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 resize-none" placeholder="Any additional information..."></textarea>
                                </div>
                            </div>

                            <div class="mt-6 p-4 bg-surface rounded-lg">
                                <h3 class="text-sm font-semibold text-text-primary mb-2">Booking Summary</h3>
                                <div class="grid grid-cols-2 gap-2 text-sm">
                                    <div><span class="text-text-muted">Specialization:</span> <span id="summary-spec" class="text-text-primary">-</span></div>
                                    <div><span class="text-text-muted">Doctor:</span> <span id="summary-doctor" class="text-text-primary">-</span></div>
                                    <div><span class="text-text-muted">Date:</span> <span id="summary-date" class="text-text-primary">-</span></div>
                                    <div><span class="text-text-muted">Time:</span> <span id="summary-time" class="text-text-primary">-</span></div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-between mt-6 pt-4 border-t border-surface-border">
                            <button type="button" id="prev-btn" class="px-4 py-2 text-sm font-medium text-text-secondary bg-surface border border-surface-border rounded-lg hover:bg-gray-100 transition-colors hidden">
                                Previous
                            </button>
                            <button type="button" id="next-btn" class="px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-700 transition-colors ml-auto">
                                Next
                            </button>
                            <button type="submit" id="submit-btn" class="px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-700 transition-colors hidden">
                                <span id="submit-text">Book Appointment</span>
                                <svg id="submit-spinner" class="hidden animate-spin w-4 h-4 ml-1.5 inline" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </button>
                        </div>
                    </form>
                </x-card>

                <div id="booking-success" class="hidden text-center py-12">
                    <div class="w-20 h-20 mx-auto rounded-full bg-health-100 flex items-center justify-center mb-6">
                        <svg class="w-10 h-10 text-health-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-text-primary mb-2">Appointment Booked!</h2>
                    <p class="text-text-secondary mb-6">Your appointment has been submitted for review. You will receive a confirmation shortly.</p>
                    <a href="{{ route('login') }}" class="px-6 py-2.5 text-sm font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-700 transition-colors">
                        Sign In to View Appointments
                    </a>
                </div>
            </div>
        </main>

        <footer class="bg-white border-t border-surface-border py-4">
            <div class="max-w-4xl mx-auto px-4 text-center text-sm text-text-muted">
                &copy; {{ date('Y') }} Lakeshore Clinic. All rights reserved.
            </div>
        </footer>
    </div>

    <script>
    let currentStep = 1;
    let selectedSpecialization = null;
    let selectedDoctor = null;
    let selectedDate = null;
    let selectedTime = null;

    const specializations = @json($specializations);

    document.getElementById('next-btn').addEventListener('click', nextStep);
    document.getElementById('prev-btn').addEventListener('click', prevStep);
    document.getElementById('booking-form').addEventListener('submit', submitBooking);

    function nextStep() {
        if (currentStep === 1 && !document.querySelector('input[name="specialization_id"]:checked')) {
            showToast('Please select a specialization.', 'error');
            return;
        }
        if (currentStep === 2 && !selectedDoctor) {
            showToast('Please select a doctor.', 'error');
            return;
        }
        if (currentStep === 3 && (!selectedDate || !selectedTime)) {
            showToast('Please select a date and time.', 'error');
            return;
        }

        currentStep++;
        updateSteps();

        if (currentStep === 2) loadDoctors();
        if (currentStep === 3) loadDates();
        if (currentStep === 4) updateSummary();
    }

    function prevStep() {
        currentStep--;
        updateSteps();
    }

    function updateSteps() {
        document.querySelectorAll('.booking-step').forEach(s => s.classList.add('hidden'));
        document.getElementById(`step-${currentStep}`).classList.remove('hidden');

        document.querySelectorAll('.step').forEach(step => {
            const stepNum = parseInt(step.dataset.step);
            const circle = step.querySelector('div');
            const label = step.querySelector('span');
            if (stepNum < currentStep) {
                circle.className = 'w-8 h-8 rounded-full bg-health-500 text-white flex items-center justify-center text-sm font-medium';
                circle.innerHTML = '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>';
                label.className = 'text-sm font-medium text-health-600 hidden sm:block';
            } else if (stepNum === currentStep) {
                circle.className = 'w-8 h-8 rounded-full bg-primary-600 text-white flex items-center justify-center text-sm font-medium';
                circle.textContent = stepNum;
                label.className = 'text-sm font-medium text-primary-600 hidden sm:block';
            } else {
                circle.className = 'w-8 h-8 rounded-full bg-surface-border text-text-muted flex items-center justify-center text-sm font-medium';
                circle.textContent = stepNum;
                label.className = 'text-sm font-medium text-text-muted hidden sm:block';
            }
        });

        document.querySelectorAll('.step-line').forEach(line => {
            const lineNum = parseInt(line.dataset.line);
            line.className = `w-8 h-px ${lineNum < currentStep ? 'bg-health-500' : 'bg-surface-border'} step-line`;
        });

        document.getElementById('prev-btn').classList.toggle('hidden', currentStep === 1);
        document.getElementById('next-btn').classList.toggle('hidden', currentStep === 4);
        document.getElementById('submit-btn').classList.toggle('hidden', currentStep !== 4);
    }

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
                    container.innerHTML = '<p class="text-sm text-text-muted col-span-2">No doctors available for this specialization.</p>';
                } else {
                    container.innerHTML = data.doctors.map(doc => `
                        <label class="flex items-center gap-3 p-4 border border-surface-border rounded-lg cursor-pointer hover:border-primary-300 hover:bg-primary-50/50 transition-all">
                            <input type="radio" name="doctor_id" value="${doc.id}" onchange="selectDoctor(${doc.id}, '${doc.name}')" class="w-4 h-4 text-primary-600 focus:ring-primary-500">
                            <div>
                                <p class="text-sm font-medium text-text-primary">${doc.name}</p>
                                <p class="text-xs text-text-muted">ID: ${doc.id}</p>
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
                    container.innerHTML = '<p class="text-sm text-text-muted col-span-5">No available dates found.</p>';
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
                    container.innerHTML = '<p class="text-sm text-text-muted col-span-4">No available slots for this date.</p>';
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
    }

    function formatTime(time) {
        const [hours, minutes] = time.split(':');
        const h = parseInt(hours);
        const ampm = h >= 12 ? 'PM' : 'AM';
        const h12 = h % 12 || 12;
        return `${h12}:${minutes} ${ampm}`;
    }

    function updateSummary() {
        document.getElementById('summary-spec').textContent = selectedSpecialization?.name || '-';
        document.getElementById('summary-doctor').textContent = selectedDoctor?.name || '-';
        document.getElementById('summary-date').textContent = selectedDate?.formatted || '-';
        document.getElementById('summary-time').textContent = selectedTime?.formatted || '-';
    }

    async function submitBooking(e) {
        e.preventDefault();

        const btn = document.getElementById('submit-btn');
        const btnText = document.getElementById('submit-text');
        const btnSpinner = document.getElementById('submit-spinner');

        btn.disabled = true;
        btnText.textContent = 'Booking...';
        btnSpinner.classList.remove('hidden');

        const form = document.getElementById('booking-form');
        const formData = new FormData(form);
        formData.append('specialization_id', selectedSpecialization.id);
        formData.append('doctor_id', selectedDoctor.id);
        formData.append('appointment_date', selectedDate.date);
        formData.append('appointment_time', selectedTime.time);

        try {
            const response = await fetch('{{ route("patient.booking.store") }}', {
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
                document.getElementById('booking-form').parentElement.classList.add('hidden');
                document.getElementById('booking-success').classList.remove('hidden');
                showToast(data.message, 'success');
            } else {
                showToast(data.message || 'Failed to book appointment.', 'error');
            }
        } catch (error) {
            showToast('An error occurred. Please try again.', 'error');
        } finally {
            btn.disabled = false;
            btnText.textContent = 'Book Appointment';
            btnSpinner.classList.add('hidden');
        }
    }
    </script>
</body>
</html>
