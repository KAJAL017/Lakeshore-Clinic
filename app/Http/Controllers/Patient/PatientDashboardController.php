<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Prescription;
use App\Models\UserNotification;

class PatientDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $patient = Patient::where('email', $user->email)->first();

        $upcomingAppointments = Appointment::with(['doctor', 'specialization'])
            ->where('patient_id', $patient?->id)
            ->where('appointment_date', '>=', now())
            ->whereNotIn('status', ['cancelled', 'rejected'])
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->limit(5)
            ->get();

        $stats = [
            ['label' => 'Total Appointments', 'value' => $patient ? Appointment::where('patient_id', $patient->id)->count() : 0, 'trend' => 'All time', 'trendDirection' => 'up', 'color' => 'primary'],
            ['label' => 'Upcoming', 'value' => $upcomingAppointments->count(), 'trend' => 'Scheduled', 'trendDirection' => 'up', 'color' => 'success'],
            ['label' => 'Prescriptions', 'value' => $patient ? Prescription::where('patient_id', $patient->id)->count() : 0, 'trend' => 'Total', 'trendDirection' => 'up', 'color' => 'warning'],
            ['label' => 'Notifications', 'value' => UserNotification::where('user_id', $user->id)->where('status', 'unread')->count(), 'trend' => 'Unread', 'trendDirection' => 'up', 'color' => 'danger'],
        ];

        $isMobile = preg_match('/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i', request()->userAgent());
        $view = $isMobile ? 'patient.mobile.dashboard' : 'patient.dashboard.index';

        return view($view, compact('upcomingAppointments', 'stats', 'patient'));
    }
}
