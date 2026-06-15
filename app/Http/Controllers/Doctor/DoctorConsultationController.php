<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\Doctor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DoctorConsultationController extends Controller
{
    public function index()
    {
        $doctor = Doctor::where('user_id', auth()->id())->first();

        $consultations = Consultation::with(['appointment.patient', 'appointment.specialization'])
            ->where('doctor_id', $doctor?->id)
            ->latest()
            ->paginate(10);

        return view('doctor.consultations.index', compact('consultations'));
    }

    public function show(Consultation $consultation): JsonResponse
    {
        return response()->json([
            'success' => true,
            'consultation' => $consultation->load(['appointment.patient', 'appointment.specialization']),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $doctor = Doctor::where('user_id', auth()->id())->first();

        $request->validate([
            'appointment_id' => ['required', 'exists:appointments,id'],
            'chief_complaint' => ['nullable', 'string', 'max:1000'],
            'symptoms' => ['nullable', 'string', 'max:1000'],
            'clinical_findings' => ['nullable', 'string', 'max:1000'],
            'diagnosis' => ['nullable', 'string', 'max:1000'],
            'doctor_notes' => ['nullable', 'string', 'max:2000'],
            'recommendations' => ['nullable', 'string', 'max:1000'],
        ]);

        $consultation = Consultation::create([
            'appointment_id' => $request->appointment_id,
            'doctor_id' => $doctor?->id,
            'patient_id' => $request->patient_id,
            'chief_complaint' => $request->chief_complaint,
            'symptoms' => $request->symptoms,
            'clinical_findings' => $request->clinical_findings,
            'diagnosis' => $request->diagnosis,
            'doctor_notes' => $request->doctor_notes,
            'recommendations' => $request->recommendations,
            'status' => 'in_consultation',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Consultation created successfully.',
            'consultation' => $consultation,
        ]);
    }

    public function update(Request $request, Consultation $consultation): JsonResponse
    {
        $doctor = Doctor::where('user_id', auth()->id())->first();

        if ($consultation->doctor_id !== $doctor->id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
        }

        $request->validate([
            'chief_complaint' => ['nullable', 'string', 'max:1000'],
            'symptoms' => ['nullable', 'string', 'max:1000'],
            'clinical_findings' => ['nullable', 'string', 'max:1000'],
            'diagnosis' => ['nullable', 'string', 'max:1000'],
            'doctor_notes' => ['nullable', 'string', 'max:2000'],
            'recommendations' => ['nullable', 'string', 'max:1000'],
        ]);

        $consultation->update($request->only([
            'chief_complaint', 'symptoms', 'clinical_findings',
            'diagnosis', 'doctor_notes', 'recommendations',
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Consultation updated successfully.',
            'consultation' => $consultation,
        ]);
    }

    public function complete(Consultation $consultation): JsonResponse
    {
        $doctor = Doctor::where('user_id', auth()->id())->first();

        if ($consultation->doctor_id !== $doctor->id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
        }

        $consultation->update(['status' => 'completed']);

        return response()->json([
            'success' => true,
            'message' => 'Consultation marked as completed.',
            'consultation' => $consultation,
        ]);
    }
}
