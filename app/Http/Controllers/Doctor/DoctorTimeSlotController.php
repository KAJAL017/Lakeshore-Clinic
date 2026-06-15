<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\TimeSlot;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DoctorTimeSlotController extends Controller
{
    public function index()
    {
        $doctor = Doctor::where('user_id', auth()->id())->first();
        $timeSlots = TimeSlot::where('doctor_id', $doctor?->id)->latest()->get();

        return view('doctor.time-slots.index', compact('timeSlots', 'doctor'));
    }

    public function store(Request $request): JsonResponse
    {
        $doctor = Doctor::where('user_id', auth()->id())->first();

        if (! $doctor) {
            return response()->json(['success' => false, 'message' => 'Doctor profile not found.'], 404);
        }

        $request->validate([
            'day' => ['required', 'in:monday,tuesday,wednesday,thursday,friday,saturday,sunday'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'duration' => ['required', 'in:15,20,30,45,60'],
        ]);

        $existing = TimeSlot::where('doctor_id', $doctor->id)
            ->where('day', $request->day)
            ->where('start_time', $request->start_time)
            ->first();

        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'This time slot already exists.',
            ], 422);
        }

        $timeSlot = TimeSlot::create([
            'doctor_id' => $doctor->id,
            'day' => $request->day,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'duration' => $request->duration,
            'is_available' => true,
            'status' => 'active',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Time slot created successfully.',
            'timeSlot' => $timeSlot,
        ]);
    }

    public function update(Request $request, TimeSlot $timeSlot): JsonResponse
    {
        $doctor = Doctor::where('user_id', auth()->id())->first();

        if ($timeSlot->doctor_id !== $doctor->id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
        }

        $request->validate([
            'day' => ['required', 'in:monday,tuesday,wednesday,thursday,friday,saturday,sunday'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'duration' => ['required', 'in:15,20,30,45,60'],
        ]);

        $timeSlot->update([
            'day' => $request->day,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'duration' => $request->duration,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Time slot updated successfully.',
            'timeSlot' => $timeSlot,
        ]);
    }

    public function destroy(TimeSlot $timeSlot): JsonResponse
    {
        $doctor = Doctor::where('user_id', auth()->id())->first();

        if ($timeSlot->doctor_id !== $doctor->id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
        }

        $timeSlot->delete();

        return response()->json([
            'success' => true,
            'message' => 'Time slot deleted successfully.',
        ]);
    }

    public function toggleAvailability(TimeSlot $timeSlot): JsonResponse
    {
        $doctor = Doctor::where('user_id', auth()->id())->first();

        if ($timeSlot->doctor_id !== $doctor->id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
        }

        $timeSlot->update(['is_available' => ! $timeSlot->is_available]);

        return response()->json([
            'success' => true,
            'message' => 'Time slot availability toggled successfully.',
            'timeSlot' => $timeSlot,
        ]);
    }
}
