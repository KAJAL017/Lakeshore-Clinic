<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index(Request $request)
    {
        $query = Doctor::query();

        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('license_number', 'like', "%{$search}%");
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->approval_status) {
            $query->where('approval_status', $request->approval_status);
        }

        $doctors = $query->latest()->paginate(10)->withQueryString();

        return view('admin.doctors.index', compact('doctors'));
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:doctors,email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'photo' => ['nullable', 'image', 'max:2048'],
            'license_number' => ['nullable', 'string', 'max:100'],
            'qualification' => ['nullable', 'string', 'max:255'],
            'years_of_experience' => ['nullable', 'integer', 'min:0'],
            'gender' => ['nullable', 'in:male,female,other'],
            'date_of_birth' => ['nullable', 'date'],
            'address' => ['nullable', 'string', 'max:500'],
            'biography' => ['nullable', 'string'],
        ]);

        $data = $request->except('photo');

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = 'doctor_'.time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/doctors'), $filename);
            $data['photo'] = $filename;
        }

        $data['status'] = 'pending';
        $data['approval_status'] = 'pending';

        $doctor = Doctor::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Doctor added successfully.',
            'doctor' => $doctor,
        ]);
    }

    public function show(Doctor $doctor): JsonResponse
    {
        return response()->json([
            'success' => true,
            'doctor' => $doctor,
        ]);
    }

    public function update(Request $request, Doctor $doctor): JsonResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:doctors,email,'.$doctor->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'photo' => ['nullable', 'image', 'max:2048'],
            'license_number' => ['nullable', 'string', 'max:100'],
            'qualification' => ['nullable', 'string', 'max:255'],
            'years_of_experience' => ['nullable', 'integer', 'min:0'],
            'gender' => ['nullable', 'in:male,female,other'],
            'date_of_birth' => ['nullable', 'date'],
            'address' => ['nullable', 'string', 'max:500'],
            'biography' => ['nullable', 'string'],
        ]);

        $data = $request->except('photo');

        if ($request->hasFile('photo')) {
            if ($doctor->photo && file_exists(public_path('uploads/doctors/'.$doctor->photo))) {
                unlink(public_path('uploads/doctors/'.$doctor->photo));
            }

            $file = $request->file('photo');
            $filename = 'doctor_'.time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/doctors'), $filename);
            $data['photo'] = $filename;
        }

        $doctor->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Doctor updated successfully.',
            'doctor' => $doctor,
        ]);
    }

    public function destroy(Doctor $doctor): JsonResponse
    {
        if ($doctor->photo && file_exists(public_path('uploads/doctors/'.$doctor->photo))) {
            unlink(public_path('uploads/doctors/'.$doctor->photo));
        }

        $doctor->delete();

        return response()->json([
            'success' => true,
            'message' => 'Doctor deleted successfully.',
        ]);
    }

    public function updateStatus(Request $request, Doctor $doctor): JsonResponse
    {
        $request->validate([
            'status' => ['required', 'in:active,inactive'],
        ]);

        $doctor->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Doctor status updated successfully.',
            'doctor' => $doctor,
        ]);
    }

    public function updateApproval(Request $request, Doctor $doctor): JsonResponse
    {
        $request->validate([
            'approval_status' => ['required', 'in:approved,rejected'],
        ]);

        $doctor->update(['approval_status' => $request->approval_status]);

        return response()->json([
            'success' => true,
            'message' => 'Doctor approval updated successfully.',
            'doctor' => $doctor,
        ]);
    }

    public function updatePhoto(Request $request, Doctor $doctor): JsonResponse
    {
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
            'message' => 'Doctor photo updated successfully.',
            'photo_url' => asset('uploads/doctors/'.$filename),
        ]);
    }

    public function removePhoto(Doctor $doctor): JsonResponse
    {
        if ($doctor->photo && file_exists(public_path('uploads/doctors/'.$doctor->photo))) {
            unlink(public_path('uploads/doctors/'.$doctor->photo));
        }

        $doctor->update(['photo' => null]);

        return response()->json([
            'success' => true,
            'message' => 'Doctor photo removed successfully.',
        ]);
    }
}
