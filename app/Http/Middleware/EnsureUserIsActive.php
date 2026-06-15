<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsActive
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && ! auth()->user()->canLogin()) {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->with('error', 'Your account is not authorized to access this system.');
        }

        if (auth()->check() && $request->routeIs('dashboard') && ! $request->routeIs('admin.*', 'doctor.*', 'patient.*')) {
            $user = auth()->user();
            $redirect = $user->getDashboardRoute();

            if ($redirect !== route('dashboard')) {
                return redirect($redirect);
            }
        }

        return $next($request);
    }
}
