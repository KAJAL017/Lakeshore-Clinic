<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PatientPaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['appointment'])
            ->where('patient_id', auth()->id())
            ->latest()
            ->paginate(10);

        $isMobile = preg_match('/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i', request()->userAgent());

        return view($isMobile ? 'patient.mobile.payments' : 'patient.payments.index', compact('payments'));
    }

    public function show(Payment $payment): JsonResponse
    {
        if ($payment->patient_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
        }

        return response()->json([
            'success' => true,
            'payment' => $payment->load(['appointment']),
        ]);
    }

    public function processPayment(Request $request): JsonResponse
    {
        $request->validate([
            'appointment_id' => ['required', 'exists:appointments,id'],
            'amount' => ['required', 'numeric', 'min:0'],
        ]);

        $transactionId = 'txn_'.strtoupper(uniqid());

        $payment = Payment::create([
            'appointment_id' => $request->appointment_id,
            'patient_id' => auth()->id(),
            'amount' => $request->amount,
            'currency' => 'USD',
            'transaction_id' => $transactionId,
            'payment_method' => 'stripe',
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Payment processed successfully.',
            'payment' => $payment,
        ]);
    }
}
