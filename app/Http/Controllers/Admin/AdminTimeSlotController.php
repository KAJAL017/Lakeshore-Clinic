<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\TimeSlot;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminTimeSlotController extends Controller
{
    public function index(Request $request)
    {
        $query = TimeSlot::with('doctor');

        if ($request->search) {
            $search = $request->search;
            $query->whereHas('doctor', fn ($q) => $q->where('name', 'like', "%{$search}%"));
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->day) {
            $query->where('day', $request->day);
        }

        if ($request->doctor_id) {
            $query->where('doctor_id', $request->doctor_id);
        }

        $timeSlots = $query->latest()->paginate(10)->withQueryString();
        $doctors = Doctor::where('status', 'active')->get();

        return view('admin.time-slots.index', compact('timeSlots', 'doctors'));
    }

    public function show(TimeSlot $timeSlot): JsonResponse
    {
        return response()->json([
            'success' => true,
            'timeSlot' => $timeSlot->load('doctor'),
        ]);
    }

    public function updateStatus(Request $request, TimeSlot $timeSlot): JsonResponse
    {
        $request->validate([
            'status' => ['required', 'in:active,inactive'],
        ]);

        $timeSlot->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Time slot status updated successfully.',
            'timeSlot' => $timeSlot,
        ]);
    }

    public function toggleAvailability(TimeSlot $timeSlot): JsonResponse
    {
        $timeSlot->update(['is_available' => ! $timeSlot->is_available]);

        return response()->json([
            'success' => true,
            'message' => 'Time slot availability toggled successfully.',
            'timeSlot' => $timeSlot,
        ]);
    }

    public function destroy(TimeSlot $timeSlot): JsonResponse
    {
        $timeSlot->delete();

        return response()->json([
            'success' => true,
            'message' => 'Time slot deleted successfully.',
        ]);
    }
}
