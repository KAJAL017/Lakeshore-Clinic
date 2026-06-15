<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InsuranceRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminInsuranceController extends Controller
{
    public function index(Request $request)
    {
        $query = InsuranceRequest::with(['patient', 'appointment']);

        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('insurance_number', 'like', "%{$search}%")
                    ->orWhereHas('patient', fn ($q) => $q->where('first_name', 'like', "%{$search}%")->orWhere('last_name', 'like', "%{$search}%"));
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $insuranceRequests = $query->latest()->paginate(10)->withQueryString();

        return view('admin.insurance.index', compact('insuranceRequests'));
    }

    public function show(InsuranceRequest $insuranceRequest): JsonResponse
    {
        return response()->json([
            'success' => true,
            'insuranceRequest' => $insuranceRequest->load(['patient', 'appointment']),
        ]);
    }

    public function approve(InsuranceRequest $insuranceRequest, Request $request): JsonResponse
    {
        $request->validate([
            'admin_notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $insuranceRequest->update([
            'status' => 'approved',
            'admin_notes' => $request->admin_notes,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Insurance request approved.',
            'insuranceRequest' => $insuranceRequest,
        ]);
    }

    public function reject(InsuranceRequest $insuranceRequest, Request $request): JsonResponse
    {
        $request->validate([
            'admin_notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $insuranceRequest->update([
            'status' => 'rejected',
            'admin_notes' => $request->admin_notes,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Insurance request rejected.',
            'insuranceRequest' => $insuranceRequest,
        ]);
    }
}
