<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\DoctorAvailability;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DoctorAvailabilityController extends Controller
{
    public function index()
    {
        $doctor = Doctor::where('user_id', auth()->id())->first();
        $availabilities = DoctorAvailability::where('doctor_id', $doctor?->id)->latest()->get();

        $isMobile = preg_match('/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i', request()->userAgent());

        return view($isMobile ? 'doctor.mobile.availability' : 'doctor.availability.index', compact('availabilities', 'doctor'));
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
        ]);

        $existing = DoctorAvailability::where('doctor_id', $doctor->id)
            ->where('day', $request->day)
            ->first();

        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'You already have availability set for this day.',
            ], 422);
        }

        $availability = DoctorAvailability::create([
            'doctor_id' => $doctor->id,
            'day' => $request->day,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'is_available' => true,
            'status' => 'active',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Availability created successfully.',
            'availability' => $availability,
        ]);
    }

    public function update(Request $request, DoctorAvailability $availability): JsonResponse
    {
        $doctor = Doctor::where('user_id', auth()->id())->first();

        if ($availability->doctor_id !== $doctor->id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
        }

        $request->validate([
            'day' => ['required', 'in:monday,tuesday,wednesday,thursday,friday,saturday,sunday'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
        ]);

        $availability->update([
            'day' => $request->day,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Availability updated successfully.',
            'availability' => $availability,
        ]);
    }

    public function destroy(DoctorAvailability $availability): JsonResponse
    {
        $doctor = Doctor::where('user_id', auth()->id())->first();

        if ($availability->doctor_id !== $doctor->id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
        }

        $availability->delete();

        return response()->json([
            'success' => true,
            'message' => 'Availability deleted successfully.',
        ]);
    }

    public function toggleAvailability(DoctorAvailability $availability): JsonResponse
    {
        $doctor = Doctor::where('user_id', auth()->id())->first();

        if ($availability->doctor_id !== $doctor->id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
        }

        $availability->update(['is_available' => ! $availability->is_available]);

        return response()->json([
            'success' => true,
            'message' => 'Availability toggled successfully.',
            'availability' => $availability,
        ]);
    }
}
