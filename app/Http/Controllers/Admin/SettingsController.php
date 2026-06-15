<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = [
            'clinic_name' => Setting::getValue('clinic_name', 'Lakeshore Clinic'),
            'clinic_email' => Setting::getValue('clinic_email', 'info@lakeshore.com'),
            'clinic_phone' => Setting::getValue('clinic_phone', '+1 (555) 123-4567'),
            'clinic_address' => Setting::getValue('clinic_address', '123 Medical Center Drive'),
            'clinic_logo' => Setting::getValue('clinic_logo'),
            'clinic_favicon' => Setting::getValue('clinic_favicon'),
            'timezone' => Setting::getValue('timezone', 'UTC'),
            'language' => Setting::getValue('language', 'en'),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request): JsonResponse
    {
        $request->validate([
            'clinic_name' => ['required', 'string', 'max:255'],
            'clinic_email' => ['required', 'email', 'max:255'],
            'clinic_phone' => ['nullable', 'string', 'max:20'],
            'clinic_address' => ['nullable', 'string', 'max:500'],
            'timezone' => ['nullable', 'string', 'max:50'],
            'language' => ['nullable', 'string', 'max:10'],
        ]);

        $fields = ['clinic_name', 'clinic_email', 'clinic_phone', 'clinic_address', 'timezone', 'language'];

        foreach ($fields as $field) {
            if ($request->has($field)) {
                Setting::setValue($field, $request->input($field), 'clinic');
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Settings updated successfully.',
        ]);
    }

    public function uploadLogo(Request $request): JsonResponse
    {
        $request->validate([
            'logo' => ['required', 'image', 'max:2048'],
        ]);

        $oldLogo = Setting::getValue('clinic_logo');

        if ($oldLogo && file_exists(public_path('uploads/branding/'.$oldLogo))) {
            unlink(public_path('uploads/branding/'.$oldLogo));
        }

        $file = $request->file('logo');
        $filename = 'logo_'.time().'.'.$file->getClientOriginalExtension();
        $file->move(public_path('uploads/branding'), $filename);

        Setting::setValue('clinic_logo', $filename, 'branding');

        return response()->json([
            'success' => true,
            'message' => 'Logo uploaded successfully.',
            'logo_url' => asset('uploads/branding/'.$filename),
        ]);
    }

    public function removeLogo(): JsonResponse
    {
        $logo = Setting::getValue('clinic_logo');

        if ($logo && file_exists(public_path('uploads/branding/'.$logo))) {
            unlink(public_path('uploads/branding/'.$logo));
        }

        Setting::setValue('clinic_logo', null, 'branding');

        return response()->json([
            'success' => true,
            'message' => 'Logo removed successfully.',
        ]);
    }

    public function uploadFavicon(Request $request): JsonResponse
    {
        $request->validate([
            'favicon' => ['required', 'image', 'max:512'],
        ]);

        $oldFavicon = Setting::getValue('clinic_favicon');

        if ($oldFavicon && file_exists(public_path('uploads/branding/'.$oldFavicon))) {
            unlink(public_path('uploads/branding/'.$oldFavicon));
        }

        $file = $request->file('favicon');
        $filename = 'favicon_'.time().'.'.$file->getClientOriginalExtension();
        $file->move(public_path('uploads/branding'), $filename);

        Setting::setValue('clinic_favicon', $filename, 'branding');

        return response()->json([
            'success' => true,
            'message' => 'Favicon uploaded successfully.',
            'favicon_url' => asset('uploads/branding/'.$filename),
        ]);
    }

    public function removeFavicon(): JsonResponse
    {
        $favicon = Setting::getValue('clinic_favicon');

        if ($favicon && file_exists(public_path('uploads/branding/'.$favicon))) {
            unlink(public_path('uploads/branding/'.$favicon));
        }

        Setting::setValue('clinic_favicon', null, 'branding');

        return response()->json([
            'success' => true,
            'message' => 'Favicon removed successfully.',
        ]);
    }
}
