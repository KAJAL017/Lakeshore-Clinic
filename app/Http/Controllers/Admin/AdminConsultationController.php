<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminConsultationController extends Controller
{
    public function index(Request $request)
    {
        $query = Consultation::with(['appointment.patient', 'appointment.doctor', 'appointment.specialization']);

        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('appointment.patient', fn ($q) => $q->where('first_name', 'like', "%{$search}%")->orWhere('last_name', 'like', "%{$search}%"))
                    ->orWhereHas('appointment.doctor', fn ($q) => $q->where('name', 'like', "%{$search}%"));
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $consultations = $query->latest()->paginate(10)->withQueryString();

        return view('admin.consultations.index', compact('consultations'));
    }

    public function show(Consultation $consultation): JsonResponse
    {
        return response()->json([
            'success' => true,
            'consultation' => $consultation->load(['appointment.patient', 'appointment.doctor', 'appointment.specialization']),
        ]);
    }
}
