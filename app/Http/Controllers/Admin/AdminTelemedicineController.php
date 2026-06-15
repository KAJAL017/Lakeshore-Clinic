<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminTelemedicineController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::with(['patient', 'doctor', 'specialization'])
            ->where('type', 'telemedicine');

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

        if ($request->date_from) {
            $query->where('appointment_date', '>=', $request->date_from);
        }

        if ($request->date_to) {
            $query->where('appointment_date', '<=', $request->date_to);
        }

        $appointments = $query->latest()->paginate(10)->withQueryString();

        return view('admin.telemedicine.index', compact('appointments'));
    }

    public function show(Appointment $appointment): JsonResponse
    {
        return response()->json([
            'success' => true,
            'appointment' => $appointment->load(['patient', 'doctor', 'specialization']),
        ]);
    }

    public function updateStatus(Request $request, Appointment $appointment): JsonResponse
    {
        $request->validate([
            'status' => ['required', 'in:pending,approved,rejected,scheduled,cancelled,completed'],
        ]);

        $appointment->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Appointment status updated successfully.',
            'appointment' => $appointment,
        ]);
    }
}
