<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\MedicalDocument;
use App\Models\Patient;
use App\Models\Prescription;
use Illuminate\Http\Request;

class AdminPatientRecordController extends Controller
{
    public function index(Request $request)
    {
        $query = MedicalDocument::with(['patient', 'appointment', 'consultation']);

        if ($request->search) {
            $search = $request->search;
            $query->whereHas('patient', fn ($q) => $q->where('first_name', 'like', "%{$search}%")->orWhere('last_name', 'like', "%{$search}%"));
        }

        if ($request->document_type) {
            $query->where('document_type', $request->document_type);
        }

        $documents = $query->latest()->paginate(10)->withQueryString();

        return view('admin.records.index', compact('documents'));
    }

    public function showPatient(Patient $patient)
    {
        $patient->load([
            'appointments.doctor',
            'appointments.specialization',
        ]);

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

        return view('admin.records.show', compact('patient', 'consultations', 'prescriptions', 'documents'));
    }

    public function downloadDocument(MedicalDocument $document)
    {
        $filePath = public_path('uploads/'.$document->file_path);

        if (! file_exists($filePath)) {
            abort(404);
        }

        return response()->download($filePath, $document->original_name);
    }
}
