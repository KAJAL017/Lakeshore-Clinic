<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\AppointmentStatusHistory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AppointmentLifecycleController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::with(['patient', 'doctor', 'specialization']);

        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('patient', fn ($q) => $q->where('first_name', 'like', "%{$search}%")->orWhere('last_name', 'like', "%{$search}%"))
                    ->orWhereHas('doctor', fn ($q) => $q->where('name', 'like', "%{$search}%"));
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->type) {
            $query->where('type', $request->type);
        }

        $appointments = $query->latest()->paginate(10)->withQueryString();

        return view('admin.lifecycle.index', compact('appointments'));
    }

    public function show(Appointment $appointment): JsonResponse
    {
        $history = AppointmentStatusHistory::with('updater')
            ->where('appointment_id', $appointment->id)
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'appointment' => $appointment->load(['patient', 'doctor', 'specialization']),
            'history' => $history,
        ]);
    }

    public function updateStatus(Request $request, Appointment $appointment): JsonResponse
    {
        $request->validate([
            'status' => ['required', 'in:pending_payment,pending_review,approved,rejected,doctor_assigned,teams_scheduled,scheduled,cancelled,rescheduled,in_consultation,completed,no_show'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $previousStatus = $appointment->status;
        $appointment->update(['status' => $request->status]);

        AppointmentStatusHistory::create([
            'appointment_id' => $appointment->id,
            'previous_status' => $previousStatus,
            'new_status' => $request->status,
            'updated_by' => auth()->id(),
            'notes' => $request->notes,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Appointment status updated successfully.',
            'appointment' => $appointment,
        ]);
    }

    public function cancel(Appointment $appointment): JsonResponse
    {
        $previousStatus = $appointment->status;
        $appointment->update(['status' => 'cancelled']);

        AppointmentStatusHistory::create([
            'appointment_id' => $appointment->id,
            'previous_status' => $previousStatus,
            'new_status' => 'cancelled',
            'updated_by' => auth()->id(),
            'notes' => 'Appointment cancelled by admin.',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Appointment cancelled.',
        ]);
    }

    public function reschedule(Request $request, Appointment $appointment): JsonResponse
    {
        $request->validate([
            'appointment_date' => ['required', 'date'],
            'appointment_time' => ['required', 'date_format:H:i'],
        ]);

        $previousStatus = $appointment->status;

        $appointment->update([
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'status' => 'rescheduled',
        ]);

        AppointmentStatusHistory::create([
            'appointment_id' => $appointment->id,
            'previous_status' => $previousStatus,
            'new_status' => 'rescheduled',
            'updated_by' => auth()->id(),
            'notes' => "Rescheduled to {$request->appointment_date} at {$request->appointment_time}",
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Appointment rescheduled successfully.',
            'appointment' => $appointment,
        ]);
    }

    public function markNoShow(Appointment $appointment): JsonResponse
    {
        $previousStatus = $appointment->status;
        $appointment->update(['status' => 'no_show']);

        AppointmentStatusHistory::create([
            'appointment_id' => $appointment->id,
            'previous_status' => $previousStatus,
            'new_status' => 'no_show',
            'updated_by' => auth()->id(),
            'notes' => 'Patient did not show up.',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Appointment marked as no show.',
        ]);
    }
}
