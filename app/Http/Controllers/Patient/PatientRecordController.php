<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\MedicalDocument;
use App\Models\Patient;
use App\Models\Prescription;

class PatientRecordController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $patient = Patient::where('email', $user->email)->first();

        $appointments = $patient ? $patient->appointments()->with(['doctor', 'specialization'])->latest()->get() : collect();
        $consultations = $patient ? Consultation::with(['appointment'])->where('patient_id', $patient->id)->latest()->get() : collect();
        $prescriptions = $patient ? Prescription::with(['doctor', 'medicines'])->where('patient_id', $patient->id)->latest()->get() : collect();
        $documents = $patient ? MedicalDocument::where('patient_id', $patient->id)->latest()->get() : collect();

        return view('patient.records.index', compact('patient', 'appointments', 'consultations', 'prescriptions', 'documents'));
    }
}
