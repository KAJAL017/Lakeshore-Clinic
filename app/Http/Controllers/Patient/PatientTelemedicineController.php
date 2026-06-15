<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Specialization;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PatientTelemedicineController extends Controller
{
    public function index()
    {
        $specializations = Specialization::where('status', 'active')->get();

        return view('patient.telemedicine.index', compact('specializations'));
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'specialization_id' => ['required', 'exists:specializations,id'],
            'doctor_id' => ['required', 'exists:doctors,id'],
            'appointment_date' => ['required', 'date', 'after_or_equal:today'],
            'appointment_time' => ['required', 'date_format:H:i'],
            'reason' => ['required', 'string', 'max:500'],
            'symptoms' => ['nullable', 'string', 'max:1000'],
            'existing_conditions' => ['nullable', 'string', 'max:1000'],
            'current_medications' => ['nullable', 'string', 'max:1000'],
            'documents.*' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
            'patient_name' => ['required', 'string', 'max:255'],
            'patient_email' => ['required', 'email', 'max:255'],
            'patient_phone' => ['nullable', 'string', 'max:20'],
        ]);

        return \DB::transaction(function () use ($request) {
            $existing = Appointment::where('doctor_id', $request->doctor_id)
                ->where('appointment_date', $request->appointment_date)
                ->where('appointment_time', $request->appointment_time)
                ->whereNotIn('status', ['cancelled', 'rejected'])
                ->lockForUpdate()
                ->exists();

            if ($existing) {
                return response()->json([
                    'success' => false,
                    'message' => 'This time slot is already booked. Please select another time.',
                ], 422);
            }

            $appointment = Appointment::create([
                'patient_id' => auth()->check() ? auth()->id() : null,
                'doctor_id' => $request->doctor_id,
                'specialization_id' => $request->specialization_id,
                'type' => 'telemedicine',
                'appointment_date' => $request->appointment_date,
                'appointment_time' => $request->appointment_time,
                'status' => 'pending',
                'reason' => $request->reason,
                'symptoms' => $request->symptoms,
                'notes' => $request->existing_conditions ? 'Existing conditions: '.$request->existing_conditions."\nCurrent medications: ".$request->current_medications : null,
                'patient_name' => $request->patient_name,
                'patient_email' => $request->patient_email,
                'patient_phone' => $request->patient_phone,
            ]);

            if ($request->hasFile('documents')) {
                foreach ($request->file('documents') as $file) {
                    $filename = 'telemedicine_'.time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
                    $file->move(public_path('uploads/telemedicine'), $filename);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Telemedicine appointment booked successfully! Your appointment is pending review.',
                'appointment' => $appointment,
            ]);
        });
    }
}
