<?php

use Livewire\Volt\Volt;
use App\Models\Challenge;

use App\Http\Controllers\CourseController;
use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\ScheduleController;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;




Route::get('/challenge/{challenge}', function (Challenge $challenge) {
    return view('challenge', ['challenge' => $challenge]);
})->name('challenge');

use Laravel\WorkOS\Http\Middleware\ValidateSessionWithWorkOS;

Route::get('/', function () {
    $challenges = \App\Models\Challenge::orderBy('id')->take(3)->get();
    return view('welcome', ['challenges' => $challenges]);
})->name('home');



Route::middleware(
    array_filter([
        'auth',
        env('USE_WORKOS') ? ValidateSessionWithWorkOS::class : null,
    ])
)->group(function () {

    Route::get('dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('learning', [\App\Http\Controllers\LearningController::class, 'index'])->name('learning');
    Route::get('challenge/{challenge}', [\App\Http\Controllers\LearningController::class, 'show'])->name('challenge');
    Route::get('/challenges/{challenge}/tasks/{task}', [ChallengeController::class, 'showTask'])
        ->name('challenge.task')
        ->middleware(['auth', \App\Http\Middleware\CheckTaskCompletion::class]);
    Route::view('notifications', 'notifications')->name('notifications');
    Route::get('courses', [CourseController::class, 'index'])->name('courses');
    Route::get('learning-materials', [\App\Http\Controllers\LearningMaterialController::class, 'index'])->name('learning-materials');
    Route::get('assignments', [\App\Http\Controllers\AssignmentController::class, 'index'])->name('assignments');
    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'index'])->name('profile');
    Route::get('feedback', [\App\Http\Controllers\FeedbackController::class, 'index'])->name('feedback');
    Route::get('schedule', [ScheduleController::class, 'index'])->name('schedule');
    Route::view('grades','grades')->name('grades');
    Route::view('messages','messages')->name('messages');
// <<<<<<< v3

//     // Attendance routes
//     Route::get('attendance', [\App\Http\Controllers\AttendanceController::class, 'myAttendance'])->name('attendance.my-attendance');
//     Route::get('attendance/students', [\App\Http\Controllers\AttendanceController::class, 'allStudents'])
//         ->name('attendance.all-students')
//         ->middleware('can:view-student-attendance');
//     Route::get('attendance/students/{id}', [\App\Http\Controllers\AttendanceController::class, 'studentDetail'])
//         ->name('attendance.student-detail')
//         ->middleware('can:view-student-attendance');

//     // Test routes for attendance
//     Route::get('test-attendance', [\App\Http\Controllers\TestAttendanceController::class, 'index'])->name('test.attendance.index');
//     Route::get('test-attendance/run', [\App\Http\Controllers\TestAttendanceController::class, 'testAttendance'])->name('test.attendance');

//     // Debug route for attendance middleware
//     Route::get('debug-attendance', function() {
//         return response()->json([
//             'message' => 'Attendance middleware test',
//             'user_id' => \Illuminate\Support\Facades\Auth::id(),
//             'authenticated' => \Illuminate\Support\Facades\Auth::check(),
//             'timestamp' => now()->toDateTimeString(),
//         ]);
//     })->name('debug.attendance');
// =======
// >>>>>>> main
    // Forum routes
    Route::get('forums', [ForumController::class, 'index'])->name('forums');
    Route::get('forums/create', [ForumController::class, 'createTopic'])->name('forum.create-topic');
    Route::post('forums/create', [ForumController::class, 'storeTopic'])->name('forum.store-topic');
    Route::get('forums/search', [ForumController::class, 'search'])->name('forum.search');
    Route::get('forums/{category}', [ForumController::class, 'category'])->name('forum.category');
    Route::get('forums/{category}/create', [ForumController::class, 'createTopic'])->name('forum.category.create-topic');
    Route::get('forums/{category}/{topic}', [ForumController::class, 'topic'])->name('forum.topic');
    Route::post('forums/comment/{topic}', [ForumController::class, 'storeComment'])->name('forum.store-comment')->where('topic', '[0-9]+');
    Route::post('forums/like', [ForumController::class, 'like'])->name('forum.like');
    Route::view('help-center', 'help-center')->name('help-center');
    Route::view('technical-support', 'technical-support')->name('technical-support');

    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

// Add this debug route temporarily
Route::get('/debug-task-status/{task}', function (\App\Models\Task $task) {
    $isCompleted = \App\Models\StudentAnswer::where('user_id', Auth::id())
        ->where('task_id', $task->id)
        ->where('is_correct', true)
        ->exists();

    return response()->json([
        'task_id' => $task->id,
        'user_id' => Auth::id(),
        'is_completed' => $isCompleted,
        'answers' => \App\Models\StudentAnswer::where('user_id', Auth::id())
            ->where('task_id', $task->id)
            ->get()
    ]);
})->middleware('auth');

// AI Chat routes
Route::get('/ai/stream', [\App\Http\Controllers\AiStreamController::class, 'stream'])->name('ai.stream');

// Activity data for dashboard
Route::get('/api/user-activity', [\App\Http\Controllers\ActivityController::class, 'getUserActivityData'])
    ->name('api.user-activity')
    ->middleware('auth');

// Level-up Data Demo
Route::get('/level-up-data-demo', function () {
    return view('level-up-data-demo');
})->name('level-up-data-demo');

require __DIR__.'/auth.php';
