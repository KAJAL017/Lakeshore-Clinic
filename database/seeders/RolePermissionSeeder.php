<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // Patients
            ['name' => 'View Patients', 'slug' => 'patients.view', 'group' => 'Patients'],
            ['name' => 'Create Patients', 'slug' => 'patients.create', 'group' => 'Patients'],
            ['name' => 'Edit Patients', 'slug' => 'patients.edit', 'group' => 'Patients'],
            ['name' => 'Delete Patients', 'slug' => 'patients.delete', 'group' => 'Patients'],

            // Doctors
            ['name' => 'View Doctors', 'slug' => 'doctors.view', 'group' => 'Doctors'],
            ['name' => 'Create Doctors', 'slug' => 'doctors.create', 'group' => 'Doctors'],
            ['name' => 'Edit Doctors', 'slug' => 'doctors.edit', 'group' => 'Doctors'],
            ['name' => 'Delete Doctors', 'slug' => 'doctors.delete', 'group' => 'Doctors'],

            // Appointments
            ['name' => 'View Appointments', 'slug' => 'appointments.view', 'group' => 'Appointments'],
            ['name' => 'Create Appointments', 'slug' => 'appointments.create', 'group' => 'Appointments'],
            ['name' => 'Edit Appointments', 'slug' => 'appointments.edit', 'group' => 'Appointments'],
            ['name' => 'Delete Appointments', 'slug' => 'appointments.delete', 'group' => 'Appointments'],
            ['name' => 'Approve Appointments', 'slug' => 'appointments.approve', 'group' => 'Appointments'],

            // Telemedicine
            ['name' => 'Start Consultation', 'slug' => 'telemedicine.start', 'group' => 'Telemedicine'],
            ['name' => 'Join Consultation', 'slug' => 'telemedicine.join', 'group' => 'Telemedicine'],

            // Prescriptions
            ['name' => 'View Prescriptions', 'slug' => 'prescriptions.view', 'group' => 'Prescriptions'],
            ['name' => 'Create Prescriptions', 'slug' => 'prescriptions.create', 'group' => 'Prescriptions'],
            ['name' => 'Edit Prescriptions', 'slug' => 'prescriptions.edit', 'group' => 'Prescriptions'],

            // Reports
            ['name' => 'View Reports', 'slug' => 'reports.view', 'group' => 'Reports'],
            ['name' => 'Export Reports', 'slug' => 'reports.export', 'group' => 'Reports'],

            // Settings
            ['name' => 'View Settings', 'slug' => 'settings.view', 'group' => 'Settings'],
            ['name' => 'Manage Settings', 'slug' => 'settings.manage', 'group' => 'Settings'],

            // Users
            ['name' => 'View Users', 'slug' => 'users.view', 'group' => 'Users'],
            ['name' => 'Manage Users', 'slug' => 'users.manage', 'group' => 'Users'],

            // Roles
            ['name' => 'View Roles', 'slug' => 'roles.view', 'group' => 'Roles'],
            ['name' => 'Manage Roles', 'slug' => 'roles.manage', 'group' => 'Roles'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        $adminRole = Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'description' => 'Full system access',
        ]);
        $adminRole->permissions()->attach(Permission::all());

        $doctorRole = Role::create([
            'name' => 'Doctor',
            'slug' => 'doctor',
            'description' => 'Medical professional access',
        ]);
        $doctorRole->permissions()->attach(
            Permission::whereIn('slug', [
                'patients.view', 'patients.edit',
                'appointments.view', 'appointments.create', 'appointments.edit', 'appointments.approve',
                'telemedicine.start', 'telemedicine.join',
                'prescriptions.view', 'prescriptions.create', 'prescriptions.edit',
                'reports.view',
            ])->pluck('id')
        );

        $patientRole = Role::create([
            'name' => 'Patient',
            'slug' => 'patient',
            'description' => 'Patient portal access',
        ]);
        $patientRole->permissions()->attach(
            Permission::whereIn('slug', [
                'appointments.view', 'appointments.create',
                'telemedicine.join',
                'prescriptions.view',
            ])->pluck('id')
        );

        User::where('email', 'super@gmail.com')->first()?->roles()->attach($adminRole);
        User::where('email', 'doctor@lakeshore.com')->first()?->roles()->attach($doctorRole);
    }
}
