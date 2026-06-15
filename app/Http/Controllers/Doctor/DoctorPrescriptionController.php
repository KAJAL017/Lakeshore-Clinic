<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Prescription;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DoctorPrescriptionController extends Controller
{
    public function index()
    {
        $doctor = Doctor::where('user_id', auth()->id())->first();

        $prescriptions = Prescription::with(['patient', 'appointment', 'medicines'])
            ->where('doctor_id', $doctor?->id)
            ->latest()
            ->paginate(10);

        $isMobile = preg_match('/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i', request()->userAgent());

        return view($isMobile ? 'doctor.mobile.prescriptions' : 'doctor.prescriptions.index', compact('prescriptions'));
    }

    public function show(Prescription $prescription): JsonResponse
    {
        return response()->json([
            'success' => true,
            'prescription' => $prescription->load(['patient', 'doctor', 'appointment', 'medicines']),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $doctor = Doctor::where('user_id', auth()->id())->first();

        $request->validate([
            'patient_id' => ['required', 'exists:patients,id'],
            'appointment_id' => ['nullable', 'exists:appointments,id'],
            'consultation_id' => ['nullable', 'exists:consultations,id'],
            'prescription_date' => ['required', 'date'],
            'diagnosis' => ['nullable', 'string', 'max:1000'],
            'medicine_instructions' => ['nullable', 'string', 'max:2000'],
            'general_advice' => ['nullable', 'string', 'max:1000'],
            'medicines' => ['nullable', 'array'],
            'medicines.*.medicine_name' => ['required_with:medicines', 'string', 'max:255'],
            'medicines.*.dosage' => ['nullable', 'string', 'max:100'],
            'medicines.*.frequency' => ['nullable', 'string', 'max:100'],
            'medicines.*.duration' => ['nullable', 'string', 'max:100'],
            'medicines.*.instructions' => ['nullable', 'string', 'max:500'],
            'pdf' => ['nullable', 'file', 'mimes:pdf', 'max:2048'],
        ]);

        $pdfPath = null;
        if ($request->hasFile('pdf')) {
            $file = $request->file('pdf');
            $filename = 'prescription_'.time().'_'.uniqid().'.pdf';
            $file->move(public_path('uploads/prescriptions'), $filename);
            $pdfPath = $filename;
        }

        $prescription = Prescription::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $doctor?->id,
            'appointment_id' => $request->appointment_id,
            'consultation_id' => $request->consultation_id,
            'prescription_date' => $request->prescription_date,
            'diagnosis' => $request->diagnosis,
            'medicine_instructions' => $request->medicine_instructions,
            'general_advice' => $request->general_advice,
            'pdf_path' => $pdfPath,
            'status' => 'draft',
        ]);

        if ($request->has('medicines')) {
            foreach ($request->medicines as $medicine) {
                $prescription->medicines()->create($medicine);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Prescription created successfully.',
            'prescription' => $prescription->load('medicines'),
        ]);
    }

    public function update(Request $request, Prescription $prescription): JsonResponse
    {
        $doctor = Doctor::where('user_id', auth()->id())->first();

        if ($prescription->doctor_id !== $doctor->id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
        }

        $request->validate([
            'prescription_date' => ['required', 'date'],
            'diagnosis' => ['nullable', 'string', 'max:1000'],
            'medicine_instructions' => ['nullable', 'string', 'max:2000'],
            'general_advice' => ['nullable', 'string', 'max:1000'],
            'medicines' => ['nullable', 'array'],
            'medicines.*.medicine_name' => ['required_with:medicines', 'string', 'max:255'],
            'medicines.*.dosage' => ['nullable', 'string', 'max:100'],
            'medicines.*.frequency' => ['nullable', 'string', 'max:100'],
            'medicines.*.duration' => ['nullable', 'string', 'max:100'],
            'medicines.*.instructions' => ['nullable', 'string', 'max:500'],
            'pdf' => ['nullable', 'file', 'mimes:pdf', 'max:2048'],
        ]);

        if ($request->hasFile('pdf')) {
            if ($prescription->pdf_path && file_exists(public_path('uploads/prescriptions/'.$prescription->pdf_path))) {
                unlink(public_path('uploads/prescriptions/'.$prescription->pdf_path));
            }
            $file = $request->file('pdf');
            $filename = 'prescription_'.time().'_'.uniqid().'.pdf';
            $file->move(public_path('uploads/prescriptions'), $filename);
            $prescription->update(['pdf_path' => $filename]);
        }

        $prescription->update($request->only([
            'prescription_date', 'diagnosis', 'medicine_instructions', 'general_advice',
        ]));

        if ($request->has('medicines')) {
            $prescription->medicines()->delete();
            foreach ($request->medicines as $medicine) {
                $prescription->medicines()->create($medicine);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Prescription updated successfully.',
            'prescription' => $prescription->load('medicines'),
        ]);
    }

    public function markReady(Prescription $prescription): JsonResponse
    {
        $doctor = Doctor::where('user_id', auth()->id())->first();

        if ($prescription->doctor_id !== $doctor->id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
        }

        $prescription->update(['status' => 'ready']);

        return response()->json([
            'success' => true,
            'message' => 'Prescription marked as ready.',
            'prescription' => $prescription,
        ]);
    }
}
