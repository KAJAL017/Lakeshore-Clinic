<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $role = $user->role ?? 'user';

        $stats = match ($role) {
            'admin' => [
                ['label' => 'Total Users', 'value' => User::count(), 'trend' => '+12.5%', 'trendDirection' => 'up', 'color' => 'primary'],
                ['label' => 'Active Doctors', 'value' => User::where('status', 'active')->whereHas('roles', fn ($q) => $q->where('slug', 'doctor'))->count(), 'trend' => '+2', 'trendDirection' => 'up', 'color' => 'success'],
                ['label' => 'Total Patients', 'value' => User::whereHas('roles', fn ($q) => $q->where('slug', 'patient'))->count(), 'trend' => '+5.2%', 'trendDirection' => 'up', 'color' => 'warning'],
                ['label' => 'System Health', 'value' => '99.9%', 'trend' => 'Stable', 'trendDirection' => 'up', 'color' => 'primary'],
            ],
            'doctor' => [
                ['label' => 'My Patients', 'value' => '45', 'trend' => '+5', 'trendDirection' => 'up', 'color' => 'primary'],
                ['label' => 'Today\'s Appointments', 'value' => '8', 'trend' => '+2', 'trendDirection' => 'up', 'color' => 'success'],
                ['label' => 'Completed', 'value' => '156', 'trend' => '+12', 'trendDirection' => 'up', 'color' => 'warning'],
                ['label' => 'Revenue', 'value' => '$8,400', 'trend' => '+8.3%', 'trendDirection' => 'up', 'color' => 'danger'],
            ],
            default => [
                ['label' => 'Upcoming Appointments', 'value' => '3', 'trend' => 'This week', 'trendDirection' => 'up', 'color' => 'primary'],
                ['label' => 'Active Prescriptions', 'value' => '2', 'trend' => 'Current', 'trendDirection' => 'up', 'color' => 'success'],
                ['label' => 'Past Visits', 'value' => '12', 'trend' => 'Total', 'trendDirection' => 'up', 'color' => 'warning'],
                ['label' => 'Health Score', 'value' => 'Good', 'trend' => 'Excellent', 'trendDirection' => 'up', 'color' => 'primary'],
            ],
        };

        $recentActivities = match ($role) {
            'admin' => [
                ['content' => 'New user registered', 'time' => '5 minutes ago'],
                ['content' => 'Role permissions updated', 'time' => '15 minutes ago'],
                ['content' => 'System backup completed', 'time' => '1 hour ago'],
                ['content' => 'New doctor account approved', 'time' => '2 hours ago'],
                ['content' => 'Security audit passed', 'time' => '3 hours ago'],
            ],
            'doctor' => [
                ['content' => 'Patient consultation completed', 'time' => '5 minutes ago'],
                ['content' => 'Prescription sent to pharmacy', 'time' => '15 minutes ago'],
                ['content' => 'Lab results reviewed', 'time' => '1 hour ago'],
                ['content' => 'Appointment confirmed', 'time' => '2 hours ago'],
                ['content' => 'Patient follow-up scheduled', 'time' => '3 hours ago'],
            ],
            default => [
                ['content' => 'Appointment confirmed', 'time' => '5 minutes ago'],
                ['content' => 'Prescription refill requested', 'time' => '15 minutes ago'],
                ['content' => 'Lab results available', 'time' => '1 hour ago'],
                ['content' => 'Payment processed', 'time' => '2 hours ago'],
                ['content' => 'Next appointment reminder', 'time' => '3 hours ago'],
            ],
        };

        $upcomingEvents = [
            ['title' => 'Team Meeting', 'date' => now()->addDays(1)->toDateString(), 'time' => '10:00 AM', 'description' => 'Weekly staff meeting'],
            ['title' => 'Patient Consultation', 'date' => now()->addDays(1)->toDateString(), 'time' => '2:00 PM', 'description' => 'Follow-up with patient'],
            ['title' => 'Lunch Break', 'date' => now()->addDays(2)->toDateString(), 'time' => '12:00 PM', 'description' => 'Team lunch'],
        ];

        $notifications = [
            ['title' => 'New appointment request', 'time' => '2 min ago'],
            ['title' => 'Patient registration completed', 'time' => '1 hour ago'],
            ['title' => 'System update available', 'time' => '3 hours ago'],
        ];

        $quickActions = match ($role) {
            'admin' => [
                ['label' => 'Manage Users', 'url' => route('admin.users.index'), 'icon' => '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>'],
                ['label' => 'Manage Roles', 'url' => route('admin.roles.index'), 'icon' => '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>'],
                ['label' => 'Permissions', 'url' => route('admin.permissions.index'), 'icon' => '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>'],
                ['label' => 'View Reports', 'url' => '#', 'icon' => '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>'],
            ],
            'doctor' => [
                ['label' => 'New Appointment', 'url' => '#', 'icon' => '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>'],
                ['label' => 'View Patients', 'url' => '#', 'icon' => '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>'],
                ['label' => 'Start Consultation', 'url' => '#', 'icon' => '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>'],
                ['label' => 'Prescriptions', 'url' => '#', 'icon' => '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>'],
            ],
            default => [
                ['label' => 'Book Appointment', 'url' => '#', 'icon' => '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>'],
                ['label' => 'My Prescriptions', 'url' => '#', 'icon' => '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>'],
                ['label' => 'Medical Records', 'url' => '#', 'icon' => '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>'],
                ['label' => 'Chat Doctor', 'url' => '#', 'icon' => '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>'],
            ],
        };

        return view('dashboard.index', compact('stats', 'recentActivities', 'upcomingEvents', 'notifications', 'quickActions', 'role'));
    }
}
