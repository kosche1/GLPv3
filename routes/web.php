<?php

use Illuminate\Support\Facades\Route;
use App\Models\Challenge;
use App\Http\Controllers\CourseController;




Route::get('/challenge/{challenge}', function (Challenge $challenge) {
    return view('challenge', ['challenge' => $challenge]);
})->name('challenge');

use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('learning', [\App\Http\Controllers\LearningController::class, 'index'])->name('learning');
    Route::get('challenge/{challenge}', [\App\Http\Controllers\LearningController::class, 'show'])->name('challenge');
    Route::get('challenge/{challenge}/task/{task}', [\App\Http\Controllers\LearningController::class, 'showTask'])->name('challenge.task');
    Route::view('notifications', 'notifications')->name('notifications');
    Route::get('courses', [CourseController::class, 'index'])->name('courses');
    Route::view('learning-materials', 'learning-materials')->name('learning-materials');
    Route::view('assignments', 'assignments')->name('assignments');
    Route::view('profile', 'profile')->name('profile');
    Route::view('schedule', 'schedule')->name('schedule');
    Route::view('grades','grades')->name('grades');
    Route::view('messages','messages')->name('messages');
    Route::view('forums','forums')->name('forums');
    Route::view('help-center', 'help-center')->name('help-center');
    Route::view('technical-support', 'technical-support')->name('technical-support');

    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
