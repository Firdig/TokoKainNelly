<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

/**
 * Application Service Provider.
 * Registers rate limiters and other application-level bootstrapping.
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     * Configures rate limiters for login and checkout routes.
     */
    public function boot(): void
    {
        // Rate Limiter: Login — 5 attempts per minute per IP
        // Prevents brute-force password attacks
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by(
                $request->input('email') . '|' . $request->ip()
            )->response(function () {
                return back()->withErrors([
                    'email' => 'Terlalu banyak percobaan login. Silakan coba lagi dalam 1 menit.',
                ]);
            });
        });

        // Rate Limiter: Checkout — 10 attempts per minute per user
        // Prevents DDoS-style abuse on the checkout endpoint
        RateLimiter::for('checkout', function (Request $request) {
            return Limit::perMinute(10)->by(
                $request->user()?->id ?: $request->ip()
            );
        });
    }
}
