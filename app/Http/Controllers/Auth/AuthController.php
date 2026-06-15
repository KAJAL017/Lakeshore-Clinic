<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (! Auth::attempt($credentials, $remember)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials do not match our records.'],
            ]);
        }

        $user = Auth::user();

        if (! $user->canLogin()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            $message = match ($user->status) {
                'inactive' => 'Your account is inactive. Please contact support.',
                'pending' => 'Your account is pending approval. Please wait for admin activation.',
                'blocked' => 'Your account has been blocked. Please contact support.',
                'suspended' => 'Your account has been suspended. Please contact support.',
                default => 'Your account is not authorized to access this system.',
            };

            return response()->json([
                'success' => false,
                'message' => $message,
            ], 403);
        }

        $request->session()->regenerate();

        $redirect = $user->getDashboardRoute();

        return response()->json([
            'success' => true,
            'message' => 'Login successful. Redirecting...',
            'redirect' => $redirect,
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully.',
            'redirect' => route('login'),
        ]);
    }
}
