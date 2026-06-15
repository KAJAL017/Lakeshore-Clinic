<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\DoctorRegistration;
use App\Models\Specialization;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DoctorRegistrationController extends Controller
{
    public function showRegistrationForm()
    {
        $specializations = Specialization::where('status', 'active')->get();

        return view('auth.doctor-register', compact('specializations'));
    }

    public function register(Request $request): JsonResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:doctor_registrations,email'],
            'password' => ['required', 'confirmed', 'min:8'],
            'phone' => ['nullable', 'string', 'max:20'],
            'license_number' => ['nullable', 'string', 'max:100'],
            'qualification' => ['nullable', 'string', 'max:255'],
            'years_of_experience' => ['nullable', 'integer', 'min:0'],
            'specialization_id' => ['nullable', 'exists:specializations,id'],
        ]);

        $registration = DoctorRegistration::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'phone' => $request->phone,
            'license_number' => $request->license_number,
            'qualification' => $request->qualification,
            'years_of_experience' => $request->years_of_experience,
            'specialization_id' => $request->specialization_id,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Registration submitted successfully! Please wait for admin approval.',
            'registration' => $registration,
        ]);
    }
}
