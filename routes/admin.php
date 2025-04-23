<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

// Test route to check admin authentication
Route::get('/admin-test', function () {
    if (Auth::guard('admin')->check()) {
        return 'Logged in as admin: ' . Auth::guard('admin')->user()->name;
    } else {
        return 'Not logged in as admin';
    }
});

// Admin login test routes
Route::get('/admin-login-test', function () {
    return view('admin-login-test');
})->name('admin.login.test');

Route::post('/admin-login-attempt', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::guard('admin')->attempt($credentials)) {
        return redirect('/admin-test');
    }

    return back()->with('error', 'Invalid credentials');
})->name('admin.login.attempt');
