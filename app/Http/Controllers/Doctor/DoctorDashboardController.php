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

        $recentActivities = [
            ['content' => 'Consultation completed', 'time' => '5 minutes ago'],
            ['content' => 'Prescription sent to pharmacy', 'time' => '15 minutes ago'],
            ['content' => 'Lab results reviewed', 'time' => '1 hour ago'],
        ];

        $upcomingEvents = [
            ['title' => 'Team Meeting', 'date' => now()->addDays(1)->toDateString(), 'time' => '10:00 AM', 'description' => 'Weekly staff meeting'],
            ['title' => 'Patient Follow-up', 'date' => now()->addDays(2)->toDateString(), 'time' => '2:00 PM', 'description' => 'Follow-up consultation'],
        ];

        return view('doctor.dashboard', compact('stats', 'recentActivities', 'upcomingEvents', 'doctor'));
    }
}
