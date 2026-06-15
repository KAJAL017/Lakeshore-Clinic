<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\AppointmentStatusHistory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DoctorAppointmentLifecycleController extends Controller
{
    public function show(Appointment $appointment): JsonResponse
    {
        $history = AppointmentStatusHistory::with('updater')
            ->where('appointment_id', $appointment->id)
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'appointment' => $appointment->load(['patient', 'specialization']),
            'history' => $history,
        ]);
    }

    public function updateStatus(Request $request, Appointment $appointment): JsonResponse
    {
        $request->validate([
            'status' => ['required', 'in:in_consultation,completed,no_show'],
        ]);

        $previousStatus = $appointment->status;
        $appointment->update(['status' => $request->status]);

        AppointmentStatusHistory::create([
            'appointment_id' => $appointment->id,
            'previous_status' => $previousStatus,
            'new_status' => $request->status,
            'updated_by' => auth()->id(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Appointment status updated successfully.',
            'appointment' => $appointment,
        ]);
    }
}
