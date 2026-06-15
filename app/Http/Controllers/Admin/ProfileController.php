<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return view('admin.profile.index', compact('user'));
    }

    public function update(Request $request): JsonResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.auth()->id()],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        $user = User::findOrFail(auth()->id());
        $user->update($request->only('name', 'email', 'phone'));

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully.',
            'user' => $user,
        ]);
    }

    public function updatePhoto(Request $request): JsonResponse
    {
        $request->validate([
            'photo' => ['required', 'image', 'max:2048'],
        ]);

        $user = User::findOrFail(auth()->id());

        if ($user->photo && file_exists(public_path('uploads/profile/'.$user->photo))) {
            unlink(public_path('uploads/profile/'.$user->photo));
        }

        $file = $request->file('photo');
        $filename = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
        $file->move(public_path('uploads/profile'), $filename);

        $user->update(['photo' => $filename]);

        return response()->json([
            'success' => true,
            'message' => 'Profile photo updated successfully.',
            'photo_url' => asset('uploads/profile/'.$filename),
        ]);
    }

    public function removePhoto(): JsonResponse
    {
        $user = User::findOrFail(auth()->id());

        if ($user->photo && file_exists(public_path('uploads/profile/'.$user->photo))) {
            unlink(public_path('uploads/profile/'.$user->photo));
        }

        $user->update(['photo' => null]);

        return response()->json([
            'success' => true,
            'message' => 'Profile photo removed successfully.',
        ]);
    }

    public function changePassword(Request $request): JsonResponse
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(8)->numbers()->mixedCase()],
        ]);

        $user = User::findOrFail(auth()->id());
        $user->update(['password' => Hash::make($request->password)]);

        return response()->json([
            'success' => true,
            'message' => 'Password changed successfully.',
        ]);
    }
}
