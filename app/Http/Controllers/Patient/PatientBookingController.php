<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\DoctorAvailability;
use App\Models\Specialization;
use App\Models\TimeSlot;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PatientBookingController extends Controller
{
    public function index()
    {
        $specializations = Specialization::where('status', 'active')->get();

        return view('patient.booking.index', compact('specializations'));
    }

    public function getDoctors(Request $request): JsonResponse
    {
        $doctors = Doctor::where('status', 'active')
            ->where('approval_status', 'approved')
            ->when($request->specialization_id, fn ($q) => $q->where('specialization_id', $request->specialization_id))
            ->get(['id', 'name', 'specialization_id']);

        return response()->json(['success' => true, 'doctors' => $doctors]);
    }

    public function getAvailableDates(Request $request): JsonResponse
    {
        $request->validate(['doctor_id' => ['required', 'exists:doctors,id']]);

        $availability = DoctorAvailability::where('doctor_id', $request->doctor_id)
            ->where('is_available', true)
            ->where('status', 'active')
            ->pluck('day')
            ->toArray();

        $dates = [];
        $startDate = now();
        for ($i = 0; $i < 30; $i++) {
            $date = $startDate->copy()->addDays($i);
            $dayName = strtolower($date->format('l'));
            if (in_array($dayName, $availability)) {
                $dates[] = [
                    'date' => $date->format('Y-m-d'),
                    'day' => $date->format('l'),
                    'formatted' => $date->format('M d, Y'),
                ];
            }
        }

        return response()->json(['success' => true, 'dates' => $dates]);
    }

    public function getAvailableSlots(Request $request): JsonResponse
    {
        $request->validate([
            'doctor_id' => ['required', 'exists:doctors,id'],
            'date' => ['required', 'date'],
        ]);

        $date = Carbon::parse($request->date);
        $dayName = strtolower($date->format('l'));

        $slots = TimeSlot::where('doctor_id', $request->doctor_id)
            ->where('day', $dayName)
            ->where('is_available', true)
            ->where('status', 'active')
            ->get();

        $bookedSlots = Appointment::where('doctor_id', $request->doctor_id)
            ->where('appointment_date', $request->date)
            ->whereNotIn('status', ['cancelled', 'rejected'])
            ->pluck('appointment_time')
            ->map(fn ($time) => Carbon::parse($time)->format('H:i'))
            ->toArray();

        $availableSlots = $slots->filter(function ($slot) use ($bookedSlots) {
            return ! in_array($slot->start_time, $bookedSlots);
        })->values();

        return response()->json(['success' => true, 'slots' => $availableSlots]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'specialization_id' => ['required', 'exists:specializations,id'],
            'doctor_id' => ['required', 'exists:doctors,id'],
            'appointment_date' => ['required', 'date', 'after_or_equal:today'],
            'appointment_time' => ['required', 'date_format:H:i'],
            'reason' => ['required', 'string', 'max:500'],
            'symptoms' => ['nullable', 'string', 'max:1000'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'patient_name' => ['required', 'string', 'max:255'],
            'patient_email' => ['required', 'email', 'max:255'],
            'patient_phone' => ['nullable', 'string', 'max:20'],
        ]);

        return \DB::transaction(function () use ($request) {
            $existing = Appointment::where('doctor_id', $request->doctor_id)
                ->where('appointment_date', $request->appointment_date)
                ->where('appointment_time', $request->appointment_time)
                ->whereNotIn('status', ['cancelled', 'rejected'])
                ->lockForUpdate()
                ->exists();

            if ($existing) {
                return response()->json([
                    'success' => false,
                    'message' => 'This time slot is already booked. Please select another time.',
                ], 422);
            }

            $appointment = Appointment::create([
                'patient_id' => auth()->check() ? auth()->id() : null,
                'doctor_id' => $request->doctor_id,
                'specialization_id' => $request->specialization_id,
                'type' => 'clinic',
                'appointment_date' => $request->appointment_date,
                'appointment_time' => $request->appointment_time,
                'status' => 'pending',
                'reason' => $request->reason,
                'symptoms' => $request->symptoms,
                'notes' => $request->notes,
                'patient_name' => $request->patient_name,
                'patient_email' => $request->patient_email,
                'patient_phone' => $request->patient_phone,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Appointment booked successfully! Your appointment is pending review.',
                'appointment' => $appointment,
            ]);
        });
    }

    public function myAppointments()
    {
        $appointments = Appointment::with(['doctor', 'specialization'])
            ->where('patient_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('patient.appointments.index', compact('appointments'));
    }

    public function show(Appointment $appointment): JsonResponse
    {
        if ($appointment->patient_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
        }

        return response()->json([
            'success' => true,
            'appointment' => $appointment->load(['doctor', 'specialization']),
        ]);
    }
}
