<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SystemSettingsController extends Controller
{
    public function index()
    {
        $settings = [
            'general' => SystemSetting::getGroup('general'),
            'appointment' => SystemSetting::getGroup('appointment'),
            'telemedicine' => SystemSetting::getGroup('telemedicine'),
            'payment' => SystemSetting::getGroup('payment'),
            'notification' => SystemSetting::getGroup('notification'),
            'doctor' => SystemSetting::getGroup('doctor'),
        ];

        return view('admin.system-settings.index', compact('settings'));
    }

    public function update(Request $request): JsonResponse
    {
        $request->validate([
            'settings' => ['required', 'array'],
            'group' => ['required', 'string'],
        ]);

        foreach ($request->settings as $key => $value) {
            SystemSetting::setValue($key, $value, $request->group);
        }

        return response()->json([
            'success' => true,
            'message' => 'Settings updated successfully.',
        ]);
    }
}
