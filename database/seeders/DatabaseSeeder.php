<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'super@gmail.com',
            'password' => Hash::make('2580'),
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Dr. Sarah Wilson',
            'email' => 'doctor@lakeshore.com',
            'password' => Hash::make('Password1'),
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Pending User',
            'email' => 'pending@lakeshore.com',
            'password' => Hash::make('Password1'),
            'status' => 'pending',
        ]);

        User::create([
            'name' => 'Blocked User',
            'email' => 'blocked@lakeshore.com',
            'password' => Hash::make('Password1'),
            'status' => 'blocked',
        ]);

        $this->call(RolePermissionSeeder::class);
    }
}
