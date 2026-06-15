<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Meeting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    public function index(Request $request)
    {
        $query = Meeting::with(['appointment.patient', 'appointment.doctor', 'appointment.specialization']);

        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('meeting_id', 'like', "%{$search}%")
                    ->orWhereHas('appointment.patient', fn ($q) => $q->where('first_name', 'like', "%{$search}%")->orWhere('last_name', 'like', "%{$search}%"))
                    ->orWhereHas('appointment.doctor', fn ($q) => $q->where('name', 'like', "%{$search}%"));
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->date_from) {
            $query->whereHas('appointment', fn ($q) => $q->where('appointment_date', '>=', $request->date_from));
        }

        if ($request->date_to) {
            $query->whereHas('appointment', fn ($q) => $q->where('appointment_date', '<=', $request->date_to));
        }

        $meetings = $query->latest()->paginate(10)->withQueryString();

        return view('admin.meetings.index', compact('meetings'));
    }

    public function show(Meeting $meeting): JsonResponse
    {
        return response()->json([
            'success' => true,
            'meeting' => $meeting->load(['appointment.patient', 'appointment.doctor', 'appointment.specialization']),
        ]);
    }

    public function generateMeeting(Request $request): JsonResponse
    {
        $request->validate([
            'appointment_id' => ['required', 'exists:appointments,id'],
        ]);

        $appointment = Appointment::find($request->appointment_id);

        if ($appointment->type !== 'telemedicine') {
            return response()->json([
                'success' => false,
                'message' => 'Meetings can only be created for telemedicine appointments.',
            ], 422);
        }

        $existing = Meeting::where('appointment_id', $appointment->id)->first();
        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'A meeting already exists for this appointment.',
            ], 422);
        }

        $meetingId = 'MTS-'.strtoupper(uniqid());
        $meetingUrl = 'https://teams.microsoft.com/l/meetup-join/'.$meetingId;

        $meeting = Meeting::create([
            'appointment_id' => $appointment->id,
            'meeting_id' => $meetingId,
            'meeting_url' => $meetingUrl,
            'status' => 'created',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Meeting created successfully.',
            'meeting' => $meeting,
        ]);
    }

    public function updateStatus(Request $request, Meeting $meeting): JsonResponse
    {
        $request->validate([
            'status' => ['required', 'in:pending,created,active,completed,cancelled'],
        ]);

        $meeting->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Meeting status updated successfully.',
            'meeting' => $meeting,
        ]);
    }
}
