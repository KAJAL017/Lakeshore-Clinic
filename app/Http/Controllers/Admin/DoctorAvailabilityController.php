<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DoctorAvailability;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DoctorAvailabilityController extends Controller
{
    public function index(Request $request)
    {
        $query = DoctorAvailability::with('doctor');

        if ($request->search) {
            $search = $request->search;
            $query->whereHas('doctor', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->day) {
            $query->where('day', $request->day);
        }

        $availabilities = $query->latest()->paginate(10)->withQueryString();

        return view('admin.availability.index', compact('availabilities'));
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'doctor_id' => ['required', 'exists:doctors,id'],
            'day' => ['required', 'in:monday,tuesday,wednesday,thursday,friday,saturday,sunday'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
        ]);

        $existing = DoctorAvailability::where('doctor_id', $request->doctor_id)
            ->where('day', $request->day)
            ->first();

        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'Availability already exists for this doctor on this day.',
            ], 422);
        }

        $availability = DoctorAvailability::create([
            'doctor_id' => $request->doctor_id,
            'day' => $request->day,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'is_available' => true,
            'status' => 'active',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Availability created successfully.',
            'availability' => $availability->load('doctor'),
        ]);
    }

    public function show(DoctorAvailability $availability): JsonResponse
    {
        return response()->json([
            'success' => true,
            'availability' => $availability->load('doctor'),
        ]);
    }

    public function update(Request $request, DoctorAvailability $availability): JsonResponse
    {
        $request->validate([
            'day' => ['required', 'in:monday,tuesday,wednesday,thursday,friday,saturday,sunday'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
        ]);

        $duplicate = DoctorAvailability::where('doctor_id', $availability->doctor_id)
            ->where('day', $request->day)
            ->where('id', '!=', $availability->id)
            ->first();

        if ($duplicate) {
            return response()->json([
                'success' => false,
                'message' => 'Availability already exists for this doctor on this day.',
            ], 422);
        }

        $availability->update([
            'day' => $request->day,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Availability updated successfully.',
            'availability' => $availability->load('doctor'),
        ]);
    }

    public function destroy(DoctorAvailability $availability): JsonResponse
    {
        $availability->delete();

        return response()->json([
            'success' => true,
            'message' => 'Availability deleted successfully.',
        ]);
    }

    public function updateStatus(Request $request, DoctorAvailability $availability): JsonResponse
    {
        $request->validate([
            'status' => ['required', 'in:active,inactive'],
        ]);

        $availability->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Availability status updated successfully.',
            'availability' => $availability,
        ]);
    }

    public function toggleAvailability(DoctorAvailability $availability): JsonResponse
    {
        $availability->update(['is_available' => ! $availability->is_available]);

        return response()->json([
            'success' => true,
            'message' => 'Availability toggled successfully.',
            'availability' => $availability,
        ]);
    }
}
