<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\InsuranceRequest;
use App\Models\Patient;
use App\Models\Payment;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            ['label' => 'Total Patients', 'value' => Patient::count(), 'trend' => '+12.5%', 'trendDirection' => 'up', 'color' => 'primary'],
            ['label' => 'Total Doctors', 'value' => Doctor::where('status', 'active')->count(), 'trend' => '+3', 'trendDirection' => 'up', 'color' => 'success'],
            ['label' => "Today's Appointments", 'value' => Appointment::where('appointment_date', today())->count(), 'trend' => 'Scheduled', 'trendDirection' => 'up', 'color' => 'warning'],
            ['label' => 'Pending Reviews', 'value' => Appointment::where('status', 'pending')->count(), 'trend' => 'Awaiting', 'trendDirection' => 'up', 'color' => 'danger'],
            ['label' => 'Clinic Visits', 'value' => Appointment::where('type', 'clinic')->whereMonth('appointment_date', now()->month)->count(), 'trend' => 'This month', 'trendDirection' => 'up', 'color' => 'primary'],
            ['label' => 'Telemedicine', 'value' => Appointment::where('type', 'telemedicine')->whereMonth('appointment_date', now()->month)->count(), 'trend' => 'This month', 'trendDirection' => 'up', 'color' => 'info'],
            ['label' => 'Revenue', 'value' => '$'.number_format(Payment::where('status', 'paid')->sum('amount'), 2), 'trend' => 'Total', 'trendDirection' => 'up', 'color' => 'success'],
            ['label' => 'Insurance Cases', 'value' => InsuranceRequest::count(), 'trend' => 'Total', 'trendDirection' => 'up', 'color' => 'warning'],
        ];

        $recentActivities = [
            ['content' => 'New patient registered', 'time' => '5 minutes ago', 'type' => 'patient'],
            ['content' => 'Appointment confirmed', 'time' => '15 minutes ago', 'type' => 'appointment'],
            ['content' => 'Payment received', 'time' => '1 hour ago', 'type' => 'payment'],
            ['content' => 'Insurance claim submitted', 'time' => '2 hours ago', 'type' => 'insurance'],
            ['content' => 'Doctor account approved', 'time' => '3 hours ago', 'type' => 'doctor'],
        ];

        $pendingItems = [
            ['title' => Appointment::where('status', 'pending')->count().' appointments pending', 'count' => Appointment::where('status', 'pending')->count()],
            ['title' => InsuranceRequest::where('status', 'pending')->count().' insurance claims', 'count' => InsuranceRequest::where('status', 'pending')->count()],
        ];

        $upcomingEvents = [
            ['title' => 'Team Meeting', 'date' => now()->addDays(1)->toDateString(), 'time' => '10:00 AM', 'description' => 'Weekly staff meeting'],
            ['title' => 'System Maintenance', 'date' => now()->addDays(3)->toDateString(), 'time' => '2:00 AM', 'description' => 'Scheduled downtime'],
        ];

        return view('admin.dashboard', compact('stats', 'recentActivities', 'pendingItems', 'upcomingEvents'));
    }
}
