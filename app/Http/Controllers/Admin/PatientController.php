<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $query = Patient::query();

        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $patients = $query->latest()->paginate(10)->withQueryString();

        return view('admin.patients.index', compact('patients'));
    }

    public function show(Patient $patient): JsonResponse
    {
        return response()->json([
            'success' => true,
            'patient' => $patient,
        ]);
    }

    public function update(Request $request, Patient $patient): JsonResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:patients,email,'.$patient->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'photo' => ['nullable', 'image', 'max:2048'],
            'gender' => ['nullable', 'in:male,female,other'],
            'date_of_birth' => ['nullable', 'date'],
            'address' => ['nullable', 'string', 'max:500'],
            'emergency_contact_name' => ['nullable', 'string', 'max:255'],
            'emergency_contact_phone' => ['nullable', 'string', 'max:20'],
        ]);

        $data = $request->except('photo');

        if ($request->hasFile('photo')) {
            if ($patient->photo && file_exists(public_path('uploads/patients/'.$patient->photo))) {
                unlink(public_path('uploads/patients/'.$patient->photo));
            }

            $file = $request->file('photo');
            $filename = 'patient_'.time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/patients'), $filename);
            $data['photo'] = $filename;
        }

        $patient->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Patient updated successfully.',
            'patient' => $patient,
        ]);
    }

    public function destroy(Patient $patient): JsonResponse
    {
        if ($patient->photo && file_exists(public_path('uploads/patients/'.$patient->photo))) {
            unlink(public_path('uploads/patients/'.$patient->photo));
        }

        $patient->delete();

        return response()->json([
            'success' => true,
            'message' => 'Patient deleted successfully.',
        ]);
    }

    public function updateStatus(Request $request, Patient $patient): JsonResponse
    {
        $request->validate([
            'status' => ['required', 'in:active,inactive,blocked'],
        ]);

        $patient->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Patient status updated successfully.',
            'patient' => $patient,
        ]);
    }

    public function updatePhoto(Request $request, Patient $patient): JsonResponse
    {
        $request->validate([
            'photo' => ['required', 'image', 'max:2048'],
        ]);

        if ($patient->photo && file_exists(public_path('uploads/patients/'.$patient->photo))) {
            unlink(public_path('uploads/patients/'.$patient->photo));
        }

        $file = $request->file('photo');
        $filename = 'patient_'.time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
        $file->move(public_path('uploads/patients'), $filename);

        $patient->update(['photo' => $filename]);

        return response()->json([
            'success' => true,
            'message' => 'Patient photo updated successfully.',
            'photo_url' => asset('uploads/patients/'.$filename),
        ]);
    }

    public function removePhoto(Patient $patient): JsonResponse
    {
        if ($patient->photo && file_exists(public_path('uploads/patients/'.$patient->photo))) {
            unlink(public_path('uploads/patients/'.$patient->photo));
        }

        $patient->update(['photo' => null]);

        return response()->json([
            'success' => true,
            'message' => 'Patient photo removed successfully.',
        ]);
    }
}
