<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prescription;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminPrescriptionController extends Controller
{
    public function index(Request $request)
    {
        $query = Prescription::with(['patient', 'doctor', 'medicines']);

        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('patient', fn ($q) => $q->where('first_name', 'like', "%{$search}%")->orWhere('last_name', 'like', "%{$search}%"))
                    ->orWhereHas('doctor', fn ($q) => $q->where('name', 'like', "%{$search}%"));
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $prescriptions = $query->latest()->paginate(10)->withQueryString();

        return view('admin.prescriptions.index', compact('prescriptions'));
    }

    public function show(Prescription $prescription): JsonResponse
    {
        return response()->json([
            'success' => true,
            'prescription' => $prescription->load(['patient', 'doctor', 'appointment', 'medicines']),
        ]);
    }
}
