<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login untuk mengakses area ini.');
        }

        if (!in_array(Auth::user()->role, ['admin', 'staff'])) {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman admin.');
        }

        return $next($request);
    }
}
