<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::view('notifications', 'notifications')->name('notifications');
    Route::view('courses', 'courses')->name('courses');
    Route::view('learning-materials', 'learning-materials')->name('learning-materials');
    Route::view('assignments', 'assignments')->name('assignments');
    Route::view('profile', 'profile')->name('profile');
    Route::view('schedule', 'schedule')->name('schedule');
    Route::view('grades','grades')->name('grades');
    Route::view('messages','messages')->name('messages');

    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
