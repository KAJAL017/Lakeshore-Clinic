<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Consultation;
use App\Models\Doctor;
use App\Models\Meeting;
use App\Models\Prescription;

class DoctorDashboardController extends Controller
{
    public function index()
    {
        $doctor = Doctor::where('user_id', auth()->id())->first();

        $stats = [
            ['label' => 'Upcoming Appointments', 'value' => $doctor ? Appointment::where('doctor_id', $doctor->id)->where('appointment_date', '>=', today())->count() : 0, 'trend' => 'Scheduled', 'trendDirection' => 'up', 'color' => 'primary'],
            ['label' => 'Today\'s Consultations', 'value' => $doctor ? Consultation::where('doctor_id', $doctor->id)->whereDate('created_at', today())->count() : 0, 'trend' => 'Today', 'trendDirection' => 'up', 'color' => 'success'],
            ['label' => 'Telemedicine Sessions', 'value' => $doctor ? Meeting::whereHas('appointment', fn ($q) => $q->where('doctor_id', $doctor->id))->count() : 0, 'trend' => 'Total', 'trendDirection' => 'up', 'color' => 'info'],
            ['label' => 'Prescriptions', 'value' => $doctor ? Prescription::where('doctor_id', $doctor->id)->count() : 0, 'trend' => 'Total', 'trendDirection' => 'up', 'color' => 'warning'],
        ];

        $recentActivities = collect();
        if ($doctor) {
            $recentConsultations = Consultation::where('doctor_id', $doctor->id)
                ->with('appointment.patient')
                ->latest()
                ->take(3)
                ->get()
                ->map(fn ($c) => [
                    'content' => 'Consultation completed with ' . ($c->appointment->patient->name ?? 'Patient'),
                    'time' => $c->created_at->diffForHumans(),
                ]);

            $recentPrescriptions = Prescription::where('doctor_id', $doctor->id)
                ->with('patient')
                ->latest()
                ->take(3)
                ->get()
                ->map(fn ($p) => [
                    'content' => 'Prescription issued to ' . ($p->patient->name ?? 'Patient'),
                    'time' => $p->created_at->diffForHumans(),
                ]);

            $recentActivities = $recentConsultations->concat($recentPrescriptions)
                ->sortByDesc(fn ($a) => $a['time'])
                ->take(5)
                ->values();
        }

        $upcomingEvents = collect();
        if ($doctor) {
            $upcomingAppointments = Appointment::where('doctor_id', $doctor->id)
                ->where('appointment_date', '>=', today())
                ->with('patient', 'specialization')
                ->orderBy('appointment_date')
                ->orderBy('appointment_time')
                ->take(5)
                ->get()
                ->map(fn ($a) => [
                    'title' => ($a->patient->name ?? 'Patient') . ' - ' . ($a->specialization->name ?? 'Visit'),
                    'date' => $a->appointment_date,
                    'time' => \Carbon\Carbon::parse($a->appointment_time)->format('g:i A'),
                    'description' => ucfirst($a->appointment_type) . ' appointment',
                ]);

            $upcomingMeetings = Meeting::whereHas('appointment', fn ($q) => $q->where('doctor_id', $doctor->id))
                ->where('status', '!=', 'completed')
                ->with('appointment.patient')
                ->latest()
                ->take(3)
                ->get()
                ->map(fn ($m) => [
                    'title' => 'Telemedicine: ' . ($m->appointment->patient->name ?? 'Patient'),
                    'date' => $m->created_at->toDateString(),
                    'time' => $m->created_at->format('g:i A'),
                    'description' => 'Virtual consultation',
                ]);

            $upcomingEvents = $upcomingAppointments->concat($upcomingMeetings)
                ->sortBy('date')
                ->take(5)
                ->values();
        }

        $isMobile = preg_match('/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i', request()->userAgent());

        return view($isMobile ? 'doctor.mobile.dashboard' : 'doctor.dashboard.index', compact('stats', 'recentActivities', 'upcomingEvents', 'doctor'));
    }
}
