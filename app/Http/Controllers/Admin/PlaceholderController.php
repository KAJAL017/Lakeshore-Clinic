<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class PlaceholderController extends Controller
{
    public function patients()
    {
        return view('admin.placeholders.patients');
    }

    public function doctors()
    {
        return view('admin.placeholders.doctors');
    }

    public function specializations()
    {
        return view('admin.placeholders.specializations');
    }

    public function appointments()
    {
        return view('admin.placeholders.appointments');
    }

    public function telemedicine()
    {
        return view('admin.placeholders.telemedicine');
    }

    public function payments()
    {
        return view('admin.placeholders.payments');
    }

    public function insurance()
    {
        return view('admin.placeholders.insurance');
    }

    public function reports()
    {
        return view('admin.placeholders.reports');
    }

    public function settings()
    {
        return view('admin.placeholders.settings');
    }
}
