<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class DoctorProfileController extends Controller
{
    public function index()
    {
        $doctor = Doctor::where('user_id', auth()->id())->first();

        $isMobile = preg_match('/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i', request()->userAgent());

        return view($isMobile ? 'doctor.mobile.profile' : 'doctor.profile.index', compact('doctor'));
    }

    public function update(Request $request): JsonResponse
    {
        $doctor = Doctor::where('user_id', auth()->id())->first();

        $request->validate([
            'phone' => ['nullable', 'string', 'max:20'],
            'qualification' => ['nullable', 'string', 'max:255'],
            'years_of_experience' => ['nullable', 'integer', 'min:0'],
            'address' => ['nullable', 'string', 'max:500'],
            'biography' => ['nullable', 'string'],
        ]);

        $doctor->update($request->only('phone', 'qualification', 'years_of_experience', 'address', 'biography'));

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully.',
            'doctor' => $doctor,
        ]);
    }

    public function updatePhoto(Request $request): JsonResponse
    {
        $doctor = Doctor::where('user_id', auth()->id())->first();

        $request->validate([
            'photo' => ['required', 'image', 'max:2048'],
        ]);

        if ($doctor->photo && file_exists(public_path('uploads/doctors/'.$doctor->photo))) {
            unlink(public_path('uploads/doctors/'.$doctor->photo));
        }

        $file = $request->file('photo');
        $filename = 'doctor_'.time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
        $file->move(public_path('uploads/doctors'), $filename);

        $doctor->update(['photo' => $filename]);

        return response()->json([
            'success' => true,
            'message' => 'Photo updated successfully.',
            'photo_url' => asset('uploads/doctors/'.$filename),
        ]);
    }

    public function changePassword(Request $request): JsonResponse
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(8)->numbers()->mixedCase()],
        ]);

        $user = auth()->user();
        $user->update(['password' => Hash::make($request->password)]);

        return response()->json([
            'success' => true,
            'message' => 'Password changed successfully.',
        ]);
    }
}
