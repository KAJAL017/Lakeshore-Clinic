<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\Doctor;
use App\Models\MedicalDocument;
use App\Models\Patient;
use App\Models\Prescription;
use Illuminate\Http\JsonResponse;

class DoctorPatientRecordController extends Controller
{
    public function index()
    {
        $doctor = Doctor::where('user_id', auth()->id())->first();

        $patients = Patient::whereHas('appointments', fn ($q) => $q->where('doctor_id', $doctor?->id))
            ->withCount('appointments')
            ->latest()
            ->paginate(10);

        return view('doctor.records.index', compact('patients'));
    }

    public function show(Patient $patient): JsonResponse
    {
        $consultations = Consultation::with(['appointment'])
            ->where('patient_id', $patient->id)
            ->latest()
            ->get();

        $prescriptions = Prescription::with(['doctor', 'medicines'])
            ->where('patient_id', $patient->id)
            ->latest()
            ->get();

        $documents = MedicalDocument::where('patient_id', $patient->id)
            ->latest()
            ->get();

        $appointments = $patient->appointments()->with(['doctor', 'specialization'])->latest()->get();

        return response()->json([
            'success' => true,
            'patient' => $patient,
            'consultations' => $consultations,
            'prescriptions' => $prescriptions,
            'documents' => $documents,
            'appointments' => $appointments,
        ]);
    }
}
