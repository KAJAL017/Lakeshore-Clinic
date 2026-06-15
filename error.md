InvalidArgumentException
vendor\laravel\framework\src\Illuminate\View\FileViewFinder.php:138
View [doctor.dashboard] not found.

LARAVEL
12.62.0
PHP
8.2.12
UNHANDLED
CODE 0
500
GET
http://127.0.0.1:8000/doctor/dashboard

Exception trace
4 vendor frames

view(string, array)
app\Http\Controllers\Doctor\DoctorDashboardController.php:36

31        $upcomingEvents = [
32            ['title' => 'Team Meeting', 'date' => now()->addDays(1)->toDateString(), 'time' => '10:00 AM', 'description' => 'Weekly staff meeting'],
33            ['title' => 'Patient Follow-up', 'date' => now()->addDays(2)->toDateString(), 'time' => '2:00 PM', 'description' => 'Follow-up consultation'],
34        ];
35
36        return view('doctor.dashboard', compact('stats', 'recentActivities', 'upcomingEvents', 'doctor'));
37    }
38}
39