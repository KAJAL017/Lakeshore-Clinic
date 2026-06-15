<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Http\JsonResponse;

class DoctorTelemedicineController extends Controller
{
    public function index()
    {
        $doctor = Doctor::where('user_id', auth()->id())->first();

        $appointments = Appointment::with(['patient', 'specialization'])
            ->where('doctor_id', $doctor?->id)
            ->where('type', 'telemedicine')
            ->latest()
            ->paginate(10);

        $isMobile = preg_match('/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i', request()->userAgent());

        return view($isMobile ? 'doctor.mobile.appointments' : 'doctor.telemedicine.index', compact('appointments'));
    }

    public function show(Appointment $appointment): JsonResponse
    {
        return response()->json([
            'success' => true,
            'appointment' => $appointment->load(['patient', 'specialization']),
        ]);
    }
}
