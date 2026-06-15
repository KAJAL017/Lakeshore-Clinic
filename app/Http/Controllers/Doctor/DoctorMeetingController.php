<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Meeting;
use Illuminate\Http\JsonResponse;

class DoctorMeetingController extends Controller
{
    public function index()
    {
        $doctor = Doctor::where('user_id', auth()->id())->first();

        $meetings = Meeting::with(['appointment.patient', 'appointment.specialization'])
            ->whereHas('appointment', fn ($q) => $q->where('doctor_id', $doctor?->id))
            ->latest()
            ->paginate(10);

        return view('doctor.meetings.index', compact('meetings'));
    }

    public function show(Meeting $meeting): JsonResponse
    {
        return response()->json([
            'success' => true,
            'meeting' => $meeting->load(['appointment.patient', 'appointment.specialization']),
        ]);
    }
}
