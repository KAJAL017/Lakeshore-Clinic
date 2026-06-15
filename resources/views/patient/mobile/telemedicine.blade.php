@extends('layouts.patient-mobile')

@section('title', 'Telemedicine - Lakeshore Clinic')
@section('page-title', 'Telemedicine')

@section('content')
<div class="space-y-4">
    <a href="{{ route('patient.book-appointment') }}" class="inline-flex items-center gap-2 text-sm text-[#0d9488] font-medium">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Back
    </a>

    <div>
        <h2 class="text-lg font-bold text-text-primary">Book Telemedicine</h2>
        <p class="text-sm text-text-muted mt-0.5">Virtual consultation with a doctor</p>
    </div>

    <form id="telemedicine-form" class="space-y-4">
        <input type="hidden" name="patient_name" value="{{ auth()->user()->name ?? '' }}">
        <input type="hidden" name="patient_email" value="{{ auth()->user()->email ?? '' }}">

        <div>
            <label class="block text-sm font-medium text-text-primary mb-1.5">Specialization</label>
            <select name="specialization_id" id="specialization" class="w-full px-4 py-3 bg-white border border-surface-border rounded-xl text-sm text-text-primary focus:outline-none focus:ring-2 focus:ring-[#0d9488]/30 focus:border-[#0d9488]">
                <option value="">Select specialization</option>
                @foreach($specializations as $spec)
                    <option value="{{ $spec->id }}">{{ $spec->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-text-primary mb-1.5">Doctor</label>
            <select name="doctor_id" id="doctor" class="w-full px-4 py-3 bg-white border border-surface-border rounded-xl text-sm text-text-primary focus:outline-none focus:ring-2 focus:ring-[#0d9488]/30 focus:border-[#0d9488]" disabled>
                <option value="">Select doctor</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-text-primary mb-1.5">Date</label>
            <select name="appointment_date" id="date" class="w-full px-4 py-3 bg-white border border-surface-border rounded-xl text-sm text-text-primary focus:outline-none focus:ring-2 focus:ring-[#0d9488]/30 focus:border-[#0d9488]" disabled>
                <option value="">Select date</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-text-primary mb-1.5">Time Slot</label>
            <select name="appointment_time" id="time" class="w-full px-4 py-3 bg-white border border-surface-border rounded-xl text-sm text-text-primary focus:outline-none focus:ring-2 focus:ring-[#0d9488]/30 focus:border-[#0d9488]" disabled>
                <option value="">Select time</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-text-primary mb-1.5">Reason for Consultation</label>
            <textarea name="reason" rows="3" class="w-full px-4 py-3 bg-white border border-surface-border rounded-xl text-sm text-text-primary focus:outline-none focus:ring-2 focus:ring-[#0d9488]/30 focus:border-[#0d9488] resize-none" placeholder="Describe your reason..."></textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-text-primary mb-1.5">Symptoms</label>
            <textarea name="symptoms" rows="2" class="w-full px-4 py-3 bg-white border border-surface-border rounded-xl text-sm text-text-primary focus:outline-none focus:ring-2 focus:ring-[#0d9488]/30 focus:border-[#0d9488] resize-none" placeholder="List your symptoms..."></textarea>
        </div>

        <button type="submit" id="submit-btn" class="w-full py-3.5 bg-[#0d9488] text-white rounded-xl font-semibold shadow-lg shadow-[#0d9488]/25 active:scale-[0.98] transition-all disabled:opacity-50 disabled:cursor-not-allowed">
            Book Appointment
        </button>
    </form>
</div>

@push('scripts')
<script>
const specializationEl = document.getElementById('specialization');
const doctorEl = document.getElementById('doctor');
const dateEl = document.getElementById('date');
const timeEl = document.getElementById('time');
const form = document.getElementById('telemedicine-form');
const submitBtn = document.getElementById('submit-btn');

specializationEl.addEventListener('change', async function() {
    const specId = this.value;
    doctorEl.innerHTML = '<option value="">Loading...</option>';
    doctorEl.disabled = true;
    dateEl.innerHTML = '<option value="">Select date</option>';
    dateEl.disabled = true;
    timeEl.innerHTML = '<option value="">Select time</option>';
    timeEl.disabled = true;

    if (!specId) { doctorEl.innerHTML = '<option value="">Select doctor</option>'; return; }

    try {
        const res = await fetch(`/patient/booking/doctors?specialization_id=${specId}`, { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } });
        const data = await res.json();
        doctorEl.innerHTML = '<option value="">Select doctor</option>';
        data.doctors.forEach(d => { doctorEl.innerHTML += `<option value="${d.id}">${d.name}</option>`; });
        doctorEl.disabled = false;
    } catch(e) { doctorEl.innerHTML = '<option value="">Error loading doctors</option>'; }
});

doctorEl.addEventListener('change', async function() {
    const doctorId = this.value;
    dateEl.innerHTML = '<option value="">Loading...</option>';
    dateEl.disabled = true;
    timeEl.innerHTML = '<option value="">Select time</option>';
    timeEl.disabled = true;

    if (!doctorId) { dateEl.innerHTML = '<option value="">Select date</option>'; return; }

    try {
        const res = await fetch(`/patient/booking/dates?doctor_id=${doctorId}`, { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } });
        const data = await res.json();
        dateEl.innerHTML = '<option value="">Select date</option>';
        data.dates.forEach(d => { dateEl.innerHTML += `<option value="${d.date}">${d.formatted}</option>`; });
        dateEl.disabled = false;
    } catch(e) { dateEl.innerHTML = '<option value="">Error loading dates</option>'; }
});

dateEl.addEventListener('change', async function() {
    const doctorId = doctorEl.value;
    const date = this.value;
    timeEl.innerHTML = '<option value="">Loading...</option>';
    timeEl.disabled = true;

    if (!date) { timeEl.innerHTML = '<option value="">Select time</option>'; return; }

    try {
        const res = await fetch(`/patient/booking/slots?doctor_id=${doctorId}&date=${date}`, { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } });
        const data = await res.json();
        timeEl.innerHTML = '<option value="">Select time</option>';
        data.slots.forEach(s => {
            const h = s.start_time.split(':')[0];
            const m = s.start_time.split(':')[1];
            const ampm = h >= 12 ? 'PM' : 'AM';
            const h12 = h % 12 || 12;
            timeEl.innerHTML += `<option value="${s.start_time}">${h12}:${m} ${ampm}</option>`;
        });
        timeEl.disabled = false;
    } catch(e) { timeEl.innerHTML = '<option value="">Error loading times</option>'; }
});

form.addEventListener('submit', async function(e) {
    e.preventDefault();
    submitBtn.disabled = true;
    submitBtn.textContent = 'Booking...';

    const formData = new FormData(form);
    formData.append('patient_name', '{{ auth()->user()->name ?? "" }}');
    formData.append('patient_email', '{{ auth()->user()->email ?? "" }}');

    try {
        const res = await fetch('/patient/telemedicine', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
            body: formData,
        });
        const data = await res.json();
        if (data.success) {
            showToast(data.message, 'success');
            setTimeout(() => { window.location.href = '/patient/my-appointments'; }, 1500);
        } else {
            showToast(data.message || 'Booking failed.', 'error');
            submitBtn.disabled = false;
            submitBtn.textContent = 'Book Appointment';
        }
    } catch(err) {
        showToast('An error occurred. Please try again.', 'error');
        submitBtn.disabled = false;
        submitBtn.textContent = 'Book Appointment';
    }
});
</script>
@endpush
@endsection
