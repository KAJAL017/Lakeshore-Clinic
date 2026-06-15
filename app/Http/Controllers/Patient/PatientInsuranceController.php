<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\InsuranceRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PatientInsuranceController extends Controller
{
    public function index()
    {
        $insuranceRequests = InsuranceRequest::with(['appointment'])
            ->where('patient_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('patient.insurance.index', compact('insuranceRequests'));
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'appointment_id' => ['required', 'exists:appointments,id'],
            'insurance_number' => ['required', 'string', 'max:100'],
            'insurance_provider' => ['nullable', 'string', 'max:255'],
        ]);

        $existing = InsuranceRequest::where('appointment_id', $request->appointment_id)
            ->where('patient_id', auth()->id())
            ->where('status', 'pending')
            ->exists();

        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'You already have a pending insurance request for this appointment.',
            ], 422);
        }

        $insuranceRequest = InsuranceRequest::create([
            'patient_id' => auth()->id(),
            'appointment_id' => $request->appointment_id,
            'insurance_number' => $request->insurance_number,
            'insurance_provider' => $request->insurance_provider,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Insurance request submitted successfully.',
            'insuranceRequest' => $insuranceRequest,
        ]);
    }

    public function show(InsuranceRequest $insuranceRequest): JsonResponse
    {
        if ($insuranceRequest->patient_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
        }

        return response()->json([
            'success' => true,
            'insuranceRequest' => $insuranceRequest->load(['appointment']),
        ]);
    }
}
