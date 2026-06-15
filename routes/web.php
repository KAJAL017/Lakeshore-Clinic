<?php

use App\Http\Controllers\Admin\AdminAuditController;
use App\Http\Controllers\Admin\AdminConsultationController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminDeliveryController;
use App\Http\Controllers\Admin\AdminDoctorRegistrationController;
use App\Http\Controllers\Admin\AdminInsuranceController;
use App\Http\Controllers\Admin\AdminNotificationController;
use App\Http\Controllers\Admin\AdminPatientRecordController;
use App\Http\Controllers\Admin\AdminPaymentController;
use App\Http\Controllers\Admin\AdminPrescriptionController;
use App\Http\Controllers\Admin\AdminTelemedicineController;
use App\Http\Controllers\Admin\AdminTimeSlotController;
use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\AppointmentLifecycleController;
use App\Http\Controllers\Admin\AppointmentReviewController;
use App\Http\Controllers\Admin\BackupController;
use App\Http\Controllers\Admin\DoctorAvailabilityController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\MeetingController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\PlaceholderController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\SpecializationController;
use App\Http\Controllers\Admin\SystemSettingsController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\DoctorRegistrationController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Doctor\DoctorAppointmentsController;
use App\Http\Controllers\Doctor\DoctorConsultationController;
use App\Http\Controllers\Doctor\DoctorDashboardController;
use App\Http\Controllers\Doctor\DoctorMeetingController;
use App\Http\Controllers\Doctor\DoctorPatientRecordController;
use App\Http\Controllers\Doctor\DoctorPrescriptionController;
use App\Http\Controllers\Doctor\DoctorProfileController;
use App\Http\Controllers\Doctor\DoctorTelemedicineController;
use App\Http\Controllers\Doctor\DoctorTimeSlotController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Patient\PatientBookingController;
use App\Http\Controllers\Patient\PatientDashboardController;
use App\Http\Controllers\Patient\PatientInsuranceController;
use App\Http\Controllers\Patient\PatientPaymentController;
use App\Http\Controllers\Patient\PatientProfileController;
use App\Http\Controllers\Patient\PatientRecordController;
use App\Http\Controllers\Patient\PatientTelemedicineController;
use App\Http\Controllers\UnauthorizedController;
use App\Models\Meeting;
use App\Models\UserNotification;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/unauthorized', UnauthorizedController::class)->name('unauthorized');

Route::get('/book-appointment', [PatientBookingController::class, 'index'])->name('public.booking');
Route::post('/book-appointment', [PatientBookingController::class, 'store'])->name('public.booking.store');
Route::get('/book-appointment/doctors', [PatientBookingController::class, 'getDoctors'])->name('public.booking.doctors');
Route::get('/book-appointment/dates', [PatientBookingController::class, 'getAvailableDates'])->name('public.booking.dates');
Route::get('/book-appointment/slots', [PatientBookingController::class, 'getAvailableSlots'])->name('public.booking.slots');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

    Route::get('/doctor/login', function () {
        if (auth()->check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.doctor-login');
    })->name('doctor.login');

    Route::get('/doctor/register', [DoctorRegistrationController::class, 'showRegistrationForm'])->name('doctor.register.form');
    Route::post('/doctor/register', [DoctorRegistrationController::class, 'register'])->name('doctor.register');

    Route::get('/patient/login', function () {
        if (auth()->check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.patient-login');
    })->name('patient.login');
});

Route::get('/book-appointment', [PatientBookingController::class, 'index'])->name('public.booking');
Route::post('/book-appointment', [PatientBookingController::class, 'store'])->middleware('throttle:5,1')->name('public.booking.store');
Route::get('/book-appointment/doctors', [PatientBookingController::class, 'getDoctors'])->name('public.booking.doctors');
Route::get('/book-appointment/dates', [PatientBookingController::class, 'getAvailableDates'])->name('public.booking.dates');
Route::get('/book-appointment/slots', [PatientBookingController::class, 'getAvailableSlots'])->name('public.booking.slots');

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
    Route::get('/notifications/{notification}', [NotificationController::class, 'show'])->name('notifications.show');
    Route::put('/notifications/{notification}/read', [NotificationController::class, 'markRead'])->name('notifications.mark-read');
    Route::put('/notifications/{notification}/unread', [NotificationController::class, 'markUnread'])->name('notifications.mark-unread');
    Route::put('/notifications/{notification}/archive', [NotificationController::class, 'archive'])->name('notifications.archive');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.mark-all-read');
    Route::get('/notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('notifications.unread-count');

    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo');
        Route::delete('/profile/photo', [ProfileController::class, 'removePhoto'])->name('profile.photo.remove');
        Route::post('/profile/password', [ProfileController::class, 'changePassword'])->name('profile.password');

        Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
        Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');
        Route::post('/settings/logo', [SettingsController::class, 'uploadLogo'])->name('settings.logo.upload');
        Route::delete('/settings/logo', [SettingsController::class, 'removeLogo'])->name('settings.logo.remove');
        Route::post('/settings/favicon', [SettingsController::class, 'uploadFavicon'])->name('settings.favicon.upload');
        Route::delete('/settings/favicon', [SettingsController::class, 'removeFavicon'])->name('settings.favicon.remove');

        Route::get('/patients', [PatientController::class, 'index'])->name('patients');
        Route::get('/patients/{patient}', [PatientController::class, 'show'])->name('patients.show');
        Route::put('/patients/{patient}', [PatientController::class, 'update'])->name('patients.update');
        Route::put('/patients/{patient}/status', [PatientController::class, 'updateStatus'])->name('patients.status');
        Route::post('/patients/{patient}/photo', [PatientController::class, 'updatePhoto'])->name('patients.photo');
        Route::delete('/patients/{patient}/photo', [PatientController::class, 'removePhoto'])->name('patients.photo.remove');

        Route::get('/doctors', [DoctorController::class, 'index'])->name('doctors');
        Route::post('/doctors', [DoctorController::class, 'store'])->name('doctors.store');
        Route::get('/doctors/{doctor}', [DoctorController::class, 'show'])->name('doctors.show');
        Route::put('/doctors/{doctor}', [DoctorController::class, 'update'])->name('doctors.update');
        Route::delete('/doctors/{doctor}', [DoctorController::class, 'destroy'])->name('doctors.destroy');
        Route::put('/doctors/{doctor}/status', [DoctorController::class, 'updateStatus'])->name('doctors.status');
        Route::put('/doctors/{doctor}/approval', [DoctorController::class, 'updateApproval'])->name('doctors.approval');
        Route::post('/doctors/{doctor}/photo', [DoctorController::class, 'updatePhoto'])->name('doctors.photo');
        Route::delete('/doctors/{doctor}/photo', [DoctorController::class, 'removePhoto'])->name('doctors.photo.remove');

        Route::get('/availability', [DoctorAvailabilityController::class, 'index'])->name('availability');
        Route::post('/availability', [DoctorAvailabilityController::class, 'store'])->name('availability.store');
        Route::get('/availability/{availability}', [DoctorAvailabilityController::class, 'show'])->name('availability.show');
        Route::put('/availability/{availability}', [DoctorAvailabilityController::class, 'update'])->name('availability.update');
        Route::delete('/availability/{availability}', [DoctorAvailabilityController::class, 'destroy'])->name('availability.destroy');
        Route::put('/availability/{availability}/status', [DoctorAvailabilityController::class, 'updateStatus'])->name('availability.status');
        Route::put('/availability/{availability}/toggle', [DoctorAvailabilityController::class, 'toggleAvailability'])->name('availability.toggle');

        Route::get('/specializations', [SpecializationController::class, 'index'])->name('specializations');
        Route::post('/specializations', [SpecializationController::class, 'store'])->name('specializations.store');
        Route::get('/specializations/{specialization}', [SpecializationController::class, 'show'])->name('specializations.show');
        Route::put('/specializations/{specialization}', [SpecializationController::class, 'update'])->name('specializations.update');
        Route::delete('/specializations/{specialization}', [SpecializationController::class, 'destroy'])->name('specializations.destroy');
        Route::put('/specializations/{specialization}/status', [SpecializationController::class, 'updateStatus'])->name('specializations.status');

        Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments');
        Route::get('/appointments/{appointment}', [AppointmentController::class, 'show'])->name('appointments.show');
        Route::put('/appointments/{appointment}/status', [AppointmentController::class, 'updateStatus'])->name('appointments.status');

        Route::get('/time-slots', [AdminTimeSlotController::class, 'index'])->name('time-slots');
        Route::get('/time-slots/{timeSlot}', [AdminTimeSlotController::class, 'show'])->name('time-slots.show');
        Route::put('/time-slots/{timeSlot}/status', [AdminTimeSlotController::class, 'updateStatus'])->name('time-slots.status');
        Route::put('/time-slots/{timeSlot}/toggle', [AdminTimeSlotController::class, 'toggleAvailability'])->name('time-slots.toggle');
        Route::delete('/time-slots/{timeSlot}', [AdminTimeSlotController::class, 'destroy'])->name('time-slots.destroy');

        Route::get('/reviews', [AppointmentReviewController::class, 'index'])->name('reviews');
        Route::get('/reviews/{appointment}', [AppointmentReviewController::class, 'show'])->name('reviews.show');
        Route::put('/reviews/{appointment}/approve', [AppointmentReviewController::class, 'approve'])->name('reviews.approve');
        Route::put('/reviews/{appointment}/reject', [AppointmentReviewController::class, 'reject'])->name('reviews.reject');
        Route::put('/reviews/{appointment}/assign', [AppointmentReviewController::class, 'assignDoctor'])->name('reviews.assign');
        Route::put('/reviews/{appointment}/cancel', [AppointmentReviewController::class, 'cancel'])->name('reviews.cancel');

        Route::get('/meetings', [MeetingController::class, 'index'])->name('meetings');
        Route::get('/meetings/{meeting}', [MeetingController::class, 'show'])->name('meetings.show');
        Route::post('/meetings/generate', [MeetingController::class, 'generateMeeting'])->name('meetings.generate');
        Route::put('/meetings/{meeting}/status', [MeetingController::class, 'updateStatus'])->name('meetings.status');

        Route::get('/consultations', [AdminConsultationController::class, 'index'])->name('consultations');
        Route::get('/consultations/{consultation}', [AdminConsultationController::class, 'show'])->name('consultations.show');

        Route::get('/prescriptions', [AdminPrescriptionController::class, 'index'])->name('prescriptions');
        Route::get('/prescriptions/{prescription}', [AdminPrescriptionController::class, 'show'])->name('prescriptions.show');

        Route::get('/records', [AdminPatientRecordController::class, 'index'])->name('records');
        Route::get('/records/{patient}', [AdminPatientRecordController::class, 'showPatient'])->name('records.show');
        Route::get('/records/{document}/download', [AdminPatientRecordController::class, 'downloadDocument'])->name('records.download');

        Route::get('/payments', [AdminPaymentController::class, 'index'])->name('payments');
        Route::get('/payments', [AdminPaymentController::class, 'index'])->name('payments');
        Route::get('/payments/{payment}', [AdminPaymentController::class, 'show'])->name('payments.show');

        Route::get('/insurance', [AdminInsuranceController::class, 'index'])->name('insurance');
        Route::get('/insurance/{insuranceRequest}', [AdminInsuranceController::class, 'show'])->name('insurance.show');
        Route::put('/insurance/{insuranceRequest}/approve', [AdminInsuranceController::class, 'approve'])->name('insurance.approve');
        Route::put('/insurance/{insuranceRequest}/reject', [AdminInsuranceController::class, 'reject'])->name('insurance.reject');

        Route::get('/notifications', [AdminNotificationController::class, 'index'])->name('notifications');
        Route::post('/notifications', [AdminNotificationController::class, 'store'])->name('notifications.store');
        Route::delete('/notifications/{notification}', [AdminNotificationController::class, 'destroy'])->name('notifications.destroy');

        Route::get('/deliveries', [AdminDeliveryController::class, 'index'])->name('deliveries');
        Route::get('/deliveries/{deliveryLog}', [AdminDeliveryController::class, 'show'])->name('deliveries.show');
        Route::post('/deliveries', [AdminDeliveryController::class, 'store'])->name('deliveries.store');
        Route::delete('/deliveries/{deliveryLog}', [AdminDeliveryController::class, 'destroy'])->name('deliveries.destroy');

        Route::get('/lifecycle', [AppointmentLifecycleController::class, 'index'])->name('lifecycle');
        Route::get('/lifecycle/{appointment}', [AppointmentLifecycleController::class, 'show'])->name('lifecycle.show');
        Route::put('/lifecycle/{appointment}/status', [AppointmentLifecycleController::class, 'updateStatus'])->name('lifecycle.status');
        Route::put('/lifecycle/{appointment}/cancel', [AppointmentLifecycleController::class, 'cancel'])->name('lifecycle.cancel');
        Route::put('/lifecycle/{appointment}/reschedule', [AppointmentLifecycleController::class, 'reschedule'])->name('lifecycle.reschedule');
        Route::put('/lifecycle/{appointment}/no-show', [AppointmentLifecycleController::class, 'markNoShow'])->name('lifecycle.no-show');

        Route::get('/audit', [AdminAuditController::class, 'index'])->name('audit');
        Route::post('/audit', [AdminAuditController::class, 'store'])->name('audit.store');

        Route::get('/backup', [BackupController::class, 'index'])->name('backup');
        Route::get('/backup/{backupLog}', [BackupController::class, 'show'])->name('backup.show');
        Route::post('/backup/create', [BackupController::class, 'createBackup'])->name('backup.create');

        Route::get('/registrations', [AdminDoctorRegistrationController::class, 'index'])->name('registrations');
        Route::put('/registrations/{registration}/approve', [AdminDoctorRegistrationController::class, 'approve'])->name('registrations.approve');
        Route::put('/registrations/{registration}/reject', [AdminDoctorRegistrationController::class, 'reject'])->name('registrations.reject');

        Route::get('/system-settings', [SystemSettingsController::class, 'index'])->name('system-settings');
        Route::put('/system-settings', [SystemSettingsController::class, 'update'])->name('system-settings.update');

        Route::get('/telemedicine', [AdminTelemedicineController::class, 'index'])->name('telemedicine');
        Route::get('/telemedicine/{appointment}', [AdminTelemedicineController::class, 'show'])->name('telemedicine.show');
        Route::put('/telemedicine/{appointment}/status', [AdminTelemedicineController::class, 'updateStatus'])->name('telemedicine.status');

        Route::get('/payments', [PlaceholderController::class, 'payments'])->name('payments');
        Route::get('/insurance', [PlaceholderController::class, 'insurance'])->name('insurance');
        Route::get('/reports', [PlaceholderController::class, 'reports'])->name('reports');

        Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
        Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
        Route::get('/roles/{role}', [RoleController::class, 'show'])->name('roles.show');
        Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
        Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');

        Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
        Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store');
        Route::put('/permissions/{permission}', [PermissionController::class, 'update'])->name('permissions.update');
        Route::delete('/permissions/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy');
        Route::post('/permissions/assign-role', [PermissionController::class, 'assignRole'])->name('permissions.assign-role');

        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');
        Route::put('/users/{user}/role', [AdminUserController::class, 'updateRole'])->name('users.update-role');
        Route::put('/users/{user}/status', [AdminUserController::class, 'updateStatus'])->name('users.update-status');
    });

    Route::prefix('doctor')->name('doctor.')->middleware('role:doctor')->group(function () {
        Route::get('/dashboard', [DoctorDashboardController::class, 'index'])->name('dashboard');

        Route::get('/availability', [App\Http\Controllers\Doctor\DoctorAvailabilityController::class, 'index'])->name('availability');
        Route::post('/availability', [App\Http\Controllers\Doctor\DoctorAvailabilityController::class, 'store'])->name('availability.store');
        Route::put('/availability/{availability}', [App\Http\Controllers\Doctor\DoctorAvailabilityController::class, 'update'])->name('availability.update');
        Route::delete('/availability/{availability}', [App\Http\Controllers\Doctor\DoctorAvailabilityController::class, 'destroy'])->name('availability.destroy');
        Route::put('/availability/{availability}/toggle', [App\Http\Controllers\Doctor\DoctorAvailabilityController::class, 'toggleAvailability'])->name('availability.toggle');

        Route::get('/profile', [DoctorProfileController::class, 'index'])->name('profile');
        Route::post('/profile', [DoctorProfileController::class, 'update'])->name('profile.update');
        Route::post('/profile/photo', [DoctorProfileController::class, 'updatePhoto'])->name('profile.photo');
        Route::post('/profile/password', [DoctorProfileController::class, 'changePassword'])->name('profile.password');

        Route::get('/telemedicine', [DoctorTelemedicineController::class, 'index'])->name('telemedicine');
        Route::get('/telemedicine/{appointment}', [DoctorTelemedicineController::class, 'show'])->name('telemedicine.show');

        Route::get('/time-slots', [DoctorTimeSlotController::class, 'index'])->name('time-slots');
        Route::post('/time-slots', [DoctorTimeSlotController::class, 'store'])->name('time-slots.store');
        Route::get('/time-slots/{timeSlot}', [DoctorTimeSlotController::class, 'show'])->name('time-slots.show');
        Route::put('/time-slots/{timeSlot}', [DoctorTimeSlotController::class, 'update'])->name('time-slots.update');
        Route::delete('/time-slots/{timeSlot}', [DoctorTimeSlotController::class, 'destroy'])->name('time-slots.destroy');
        Route::put('/time-slots/{timeSlot}/toggle', [DoctorTimeSlotController::class, 'toggleAvailability'])->name('time-slots.toggle');

        Route::get('/appointments', [DoctorAppointmentsController::class, 'index'])->name('appointments');
        Route::get('/appointments/{appointment}', [DoctorAppointmentsController::class, 'show'])->name('appointments.show');

        Route::get('/meetings', [DoctorMeetingController::class, 'index'])->name('meetings');
        Route::get('/meetings/{meeting}', [DoctorMeetingController::class, 'show'])->name('meetings.show');

        Route::get('/consultations', [DoctorConsultationController::class, 'index'])->name('consultations');
        Route::get('/consultations/{consultation}', [DoctorConsultationController::class, 'show'])->name('consultations.show');
        Route::post('/consultations', [DoctorConsultationController::class, 'store'])->name('consultations.store');
        Route::put('/consultations/{consultation}', [DoctorConsultationController::class, 'update'])->name('consultations.update');
        Route::put('/consultations/{consultation}/complete', [DoctorConsultationController::class, 'complete'])->name('consultations.complete');

        Route::get('/prescriptions', [DoctorPrescriptionController::class, 'index'])->name('prescriptions');
        Route::get('/prescriptions/{prescription}', [DoctorPrescriptionController::class, 'show'])->name('prescriptions.show');
        Route::post('/prescriptions', [DoctorPrescriptionController::class, 'store'])->name('prescriptions.store');
        Route::put('/prescriptions/{prescription}', [DoctorPrescriptionController::class, 'update'])->name('prescriptions.update');
        Route::put('/prescriptions/{prescription}/ready', [DoctorPrescriptionController::class, 'markReady'])->name('prescriptions.ready');

        Route::get('/records', [DoctorPatientRecordController::class, 'index'])->name('records');
        Route::get('/records/{patient}', [DoctorPatientRecordController::class, 'show'])->name('records.show');
    });

    Route::prefix('patient')->name('patient.')->middleware('role:patient')->group(function () {
        Route::get('/dashboard', [PatientDashboardController::class, 'index'])->name('dashboard');

        Route::get('/book-appointment', function () {
            $isMobile = preg_match('/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i', request()->userAgent());

            return view($isMobile ? 'patient.mobile.book-appointment' : 'patient.book-appointment.index');
        })->name('book-appointment');
        Route::get('/booking', [PatientBookingController::class, 'index'])->name('booking');
        Route::post('/booking', [PatientBookingController::class, 'store'])->name('booking.store');
        Route::get('/booking/doctors', [PatientBookingController::class, 'getDoctors'])->name('booking.doctors');
        Route::get('/booking/dates', [PatientBookingController::class, 'getAvailableDates'])->name('booking.dates');
        Route::get('/booking/slots', [PatientBookingController::class, 'getAvailableSlots'])->name('booking.slots');

        Route::get('/my-appointments', [PatientBookingController::class, 'myAppointments'])->name('my-appointments');
        Route::get('/appointments', [PatientBookingController::class, 'myAppointments'])->name('appointments');
        Route::get('/appointments/{appointment}', [PatientBookingController::class, 'show'])->name('appointments.show');

        Route::get('/telemedicine', [PatientTelemedicineController::class, 'index'])->name('telemedicine');
        Route::post('/telemedicine', [PatientTelemedicineController::class, 'store'])->name('telemedicine.store');

        Route::get('/medical-records', function () {
            $isMobile = preg_match('/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i', request()->userAgent());

            return view($isMobile ? 'patient.mobile.medical-records' : 'patient.medical-records.index');
        })->name('medical-records');
        Route::get('/medical-records/documents', [PatientRecordController::class, 'index'])->name('medical-records.documents');
        Route::get('/medical-records/consultations', [PatientRecordController::class, 'index'])->name('medical-records.consultations');
        Route::get('/medical-records/prescriptions', [PatientRecordController::class, 'index'])->name('medical-records.prescriptions');

        Route::get('/telemedicine-sessions', function () {
            $meetings = Meeting::with(['appointment.patient', 'appointment.doctor', 'appointment.specialization'])
                ->whereHas('appointment', fn ($q) => $q->where('patient_id', auth()->id()))
                ->latest()
                ->paginate(10);

            return view('patient.telemedicine-sessions.index', compact('meetings'));
        })->name('telemedicine-sessions');

        Route::get('/records', [PatientRecordController::class, 'index'])->name('records');

        Route::get('/payments', [PatientPaymentController::class, 'index'])->name('payments');
        Route::get('/payments/{payment}', [PatientPaymentController::class, 'show'])->name('payments.show');
        Route::post('/payments', [PatientPaymentController::class, 'processPayment'])->name('payments.process');

        Route::get('/insurance', [PatientInsuranceController::class, 'index'])->name('insurance');
        Route::post('/insurance', [PatientInsuranceController::class, 'store'])->name('insurance.store');
        Route::get('/insurance/{insuranceRequest}', [PatientInsuranceController::class, 'show'])->name('insurance.show');

        Route::get('/notifications', function () {
            $isMobile = preg_match('/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i', request()->userAgent());
            $query = UserNotification::where('user_id', auth()->id());
            if (request('status')) {
                $query->where('status', request('status'));
            }
            $notifications = $query->latest()->paginate(10)->withQueryString();
            $unreadCount = UserNotification::where('user_id', auth()->id())->where('status', 'unread')->count();

            return view($isMobile ? 'patient.mobile.notifications' : 'patient.notifications.index', compact('notifications', 'unreadCount'));
        })->name('notifications');

        Route::get('/profile', function () {
            $isMobile = preg_match('/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i', request()->userAgent());

            return view($isMobile ? 'patient.mobile.profile' : 'patient.profile.index');
        })->name('profile');
        Route::post('/profile', [PatientProfileController::class, 'update'])->name('profile.update');
        Route::post('/profile/password', [PatientProfileController::class, 'changePassword'])->name('profile.password');
    });
});
