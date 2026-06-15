<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\DoctorRegistration;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminDoctorRegistrationController extends Controller
{
    public function index(Request $request)
    {
        $query = DoctorRegistration::with('specialization');

        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('license_number', 'like', "%{$search}%");
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $registrations = $query->latest()->paginate(10)->withQueryString();

        return view('admin.registrations.index', compact('registrations'));
    }

    public function approve(DoctorRegistration $registration): JsonResponse
    {
        if ($registration->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'This registration has already been processed.',
            ], 422);
        }

        $user = User::create([
            'name' => $registration->name,
            'email' => $registration->email,
            'password' => $registration->password,
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        $user->roles()->attach(2);

        Doctor::create([
            'user_id' => $user->id,
            'name' => $registration->name,
            'email' => $registration->email,
            'phone' => $registration->phone,
            'license_number' => $registration->license_number,
            'qualification' => $registration->qualification,
            'years_of_experience' => $registration->years_of_experience,
            'specialization_id' => $registration->specialization_id,
            'status' => 'active',
            'approval_status' => 'approved',
        ]);

        $registration->update([
            'status' => 'approved',
            'admin_notes' => 'Registration approved. Doctor account created.',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Doctor registration approved. Account created.',
            'registration' => $registration,
        ]);
    }

    public function reject(DoctorRegistration $registration, Request $request): JsonResponse
    {
        $request->validate([
            'admin_notes' => ['nullable', 'string', 'max:1000'],
        ]);

        if ($registration->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'This registration has already been processed.',
            ], 422);
        }

        $registration->update([
            'status' => 'rejected',
            'admin_notes' => $request->admin_notes,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Doctor registration rejected.',
            'registration' => $registration,
        ]);
    }
}
