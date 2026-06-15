<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeliveryLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminDeliveryController extends Controller
{
    public function index(Request $request)
    {
        $query = DeliveryLog::with('user');

        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('recipient', 'like', "%{$search}%")
                    ->orWhere('event', 'like', "%{$search}%")
                    ->orWhereHas('user', fn ($q) => $q->where('name', 'like', "%{$search}%"));
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->channel) {
            $query->where('channel', $request->channel);
        }

        if ($request->event) {
            $query->where('event', $request->event);
        }

        $deliveryLogs = $query->latest()->paginate(10)->withQueryString();

        return view('admin.deliveries.index', compact('deliveryLogs'));
    }

    public function show(DeliveryLog $deliveryLog): JsonResponse
    {
        return response()->json([
            'success' => true,
            'deliveryLog' => $deliveryLog->load('user'),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'channel' => ['required', 'in:email,sms,push,whatsapp'],
            'event' => ['required', 'string', 'max:100'],
            'recipient' => ['required', 'string', 'max:255'],
            'message' => ['nullable', 'string', 'max:1000'],
        ]);

        $deliveryLog = DeliveryLog::create([
            'user_id' => $request->user_id,
            'channel' => $request->channel,
            'event' => $request->event,
            'status' => 'sent',
            'recipient' => $request->recipient,
            'message' => $request->message,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Delivery log created successfully.',
            'deliveryLog' => $deliveryLog,
        ]);
    }

    public function destroy(DeliveryLog $deliveryLog): JsonResponse
    {
        $deliveryLog->delete();

        return response()->json([
            'success' => true,
            'message' => 'Delivery log deleted successfully.',
        ]);
    }
}
