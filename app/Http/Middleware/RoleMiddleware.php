<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (! auth()->check()) {
            if (in_array('admin', $roles)) {
                return redirect()->route('admin.login');
            }

            return redirect()->route('login');
        }

        $user = auth()->user();

        if (! $user->roles()->whereIn('slug', $roles)->exists()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized. You do not have the required role.',
                ], 403);
            }

            return redirect()->route('unauthorized');
        }

        return $next($request);
    }
}
