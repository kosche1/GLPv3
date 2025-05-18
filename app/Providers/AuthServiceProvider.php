<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Define who can view student attendance
        Gate::define('view-student-attendance', function ($user) {
            return $user->hasRole(['admin', 'teacher']);
        });

        // Configure the login throttling to use a 60-second lockout
        RateLimiter::for('login', function (Request $request) {
            $email = (string) ($request->email ?? '');

            return Limit::perMinute(5)->by($email.'|'.$request->ip())
                ->response(function () {
                    return back()->with('status', 'Too many login attempts. Please try again in 60 seconds.');
                });
        });
    }
}
