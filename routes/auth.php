<?php

use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\VerifyEmailController;
use Laravel\WorkOS\Http\Requests\AuthKitLoginRequest;
use Laravel\WorkOS\Http\Requests\AuthKitLogoutRequest;
use Laravel\WorkOS\Http\Requests\AuthKitAuthenticationRequest;
use Illuminate\Support\Facades\Session;
if (env('USE_WORKOS', false) === false) {
    Route::middleware('guest')->group(function () {
        Volt::route('login', 'auth.login')
            ->name('login');

        Volt::route('register', 'auth.register')
            ->name('register');

        Volt::route('forgot-password', 'auth.forgot-password')
            ->name('password.request');

        Volt::route('reset-password/{token}', 'auth.reset-password')
            ->name('password.reset');

    });

    Route::middleware('auth')->group(function () {
        Volt::route('verify-email', 'auth.verify-email')
            ->name('verification.notice');

        Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
            ->middleware(['signed', 'throttle:6,1'])
            ->name('verification.verify');

        Volt::route('confirm-password', 'auth.confirm-password')
            ->name('password.confirm');
    });

    Route::post('logout', App\Livewire\Actions\Logout::class)
        ->name('logout');
}
else {

    Route::get('login', function (AuthKitLoginRequest $request) {
        return $request->redirect();
    })->middleware(['guest'])->name('login');
    
    Route::get('authenticate', function (AuthKitAuthenticationRequest $request) {
        return tap(to_route('dashboard'), fn () => $request->authenticate());
    })->middleware(['guest']);
    
    Route::post('logout', function (AuthKitLogoutRequest $request) {
        Auth::guard('web')->logout();

        Session::invalidate();
        Session::regenerateToken();
        return $request->logout();
    })->middleware(['auth'])->name('logout');
}
