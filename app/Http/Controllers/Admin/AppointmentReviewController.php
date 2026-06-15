<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AppointmentReviewController extends Controller
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

        if ($request->date_from) {
            $query->where('appointment_date', '>=', $request->date_from);
        }

        if ($request->date_to) {
            $query->where('appointment_date', '<=', $request->date_to);
        }

        $appointments = $query->latest()->paginate(10)->withQueryString();
        $doctors = Doctor::where('status', 'active')->where('approval_status', 'approved')->get();

        return view('admin.reviews.index', compact('appointments', 'doctors'));
    }

    public function show(Appointment $appointment): JsonResponse
    {
        return response()->json([
            'success' => true,
            'appointment' => $appointment->load(['patient', 'doctor', 'specialization']),
        ]);
    }

    public function approve(Appointment $appointment): JsonResponse
    {
        $appointment->update(['status' => 'approved']);

        return response()->json([
            'success' => true,
            'message' => 'Appointment approved successfully.',
            'appointment' => $appointment,
        ]);
    }

    public function reject(Appointment $appointment): JsonResponse
    {
        $appointment->update(['status' => 'rejected']);

        return response()->json([
            'success' => true,
            'message' => 'Appointment rejected.',
            'appointment' => $appointment,
        ]);
    }

    public function assignDoctor(Request $request, Appointment $appointment): JsonResponse
    {
        $request->validate([
            'doctor_id' => ['required', 'exists:doctors,id'],
        ]);

        $doctor = Doctor::find($request->doctor_id);

        if (! $doctor || $doctor->status !== 'active' || $doctor->approval_status !== 'approved') {
            return response()->json([
                'success' => false,
                'message' => 'Selected doctor is not available.',
            ], 422);
        }

        $appointment->update([
            'doctor_id' => $request->doctor_id,
            'status' => 'scheduled',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Doctor assigned successfully.',
            'appointment' => $appointment->load('doctor'),
        ]);
    }

    public function cancel(Appointment $appointment): JsonResponse
    {
        $appointment->update(['status' => 'cancelled']);

        return response()->json([
            'success' => true,
            'message' => 'Appointment cancelled.',
            'appointment' => $appointment,
        ]);
    }
}
