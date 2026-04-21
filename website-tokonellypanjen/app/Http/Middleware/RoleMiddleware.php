<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Flexible Role-Based Access Control (RBAC) Middleware.
 *
 * Usage in routes:
 *   ->middleware('role:admin')           — only admin
 *   ->middleware('role:admin,staff')     — admin or staff
 *   ->middleware('role:customer')        — only customer
 *
 * Replaces the simpler IsAdmin middleware for more granular control.
 */
class RoleMiddleware
{
    /**
     * Handle an incoming request by checking the user's role
     * against the allowed roles.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles  One or more allowed roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login untuk mengakses halaman ini.');
        }

        $userRole = Auth::user()->role;

        if (!in_array($userRole, $roles)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Anda tidak memiliki akses.'], 403);
            }

            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
