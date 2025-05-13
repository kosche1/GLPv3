<?php

use Livewire\Volt\Volt;
use App\Models\Challenge;

use App\Http\Controllers\CourseController;
use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ActivityGoalController;
use App\Http\Controllers\MoleculeBuilderController;
use App\Http\Controllers\EquationDropController;
use App\Http\Controllers\HistoricalTimelineMazeController;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;




Route::get('/challenge/{challenge}', function (Challenge $challenge) {
    return view('challenge', ['challenge' => $challenge]);
})->name('challenge');

use Laravel\WorkOS\Http\Middleware\ValidateSessionWithWorkOS;

Route::get('/', [\App\Http\Controllers\WelcomeController::class, 'index'])->name('home');

// Terms & Conditions page - accessible without authentication
Route::view('terms', 'terms')->name('terms');



Route::middleware(
    array_filter([
        'auth',
        env('USE_WORKOS') ? ValidateSessionWithWorkOS::class : null,
    ])
)->group(function () {

    // Admin routes - removed custom user management in favor of Filament admin panel

    Route::get('dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('learning', [\App\Http\Controllers\LearningController::class, 'index'])->name('learning');
    Route::get('challenge/{challenge}', [\App\Http\Controllers\LearningController::class, 'show'])->name('challenge');
    // Original route with middleware that prevents viewing if already submitted
    Route::get('/challenges/{challenge}/tasks/{task}', [ChallengeController::class, 'showTask'])
        ->name('challenge.task')
        ->middleware(['auth', \App\Http\Middleware\CheckTaskCompletion::class]);

    // New route for core subjects without the CheckTaskCompletion middleware
    Route::get('/core-subjects/{challenge}/tasks/{task}', [ChallengeController::class, 'showCoreSubjectTask'])
        ->name('core.challenge.task')
        ->middleware(['auth']);

    // New route for applied subjects without the CheckTaskCompletion middleware
    Route::get('/applied-subjects/{challenge}/tasks/{task}', [ChallengeController::class, 'showAppliedSubjectTask'])
        ->name('applied.challenge.task')
        ->middleware(['auth']);

    // New route for specialized subjects without the CheckTaskCompletion middleware
    Route::get('/specialized-subjects/{challenge}/tasks/{task}', [ChallengeController::class, 'showSpecializedSubjectTask'])
        ->name('specialized.challenge.task')
        ->middleware(['auth']);

    // Debug route for task type
    Route::get('/debug-task-type/{challenge}/{task}', function (\App\Models\Challenge $challenge, \App\Models\Task $task) {
        $categoryName = $challenge->category->name ?? '';
        // Updated coding categories to match the actual subjects
        $codingCategories = [];
        // For applied subjects, we don't want to use the coding task view
        $isCodingTask = in_array($categoryName, $codingCategories) || !empty($challenge->programming_language);

        // Determine which view to use
        $viewUsed = 'challenge.non-coding-task';
        $controllerMethod = 'showTask';

        if ($isCodingTask) {
            $viewUsed = 'challenge.task';
            $controllerMethod = 'showTask';
        } else if ($challenge->subject_type === 'core') {
            $viewUsed = 'challenge.core-subject-task';
            $controllerMethod = 'showCoreSubjectTask';
        } else if ($challenge->subject_type === 'applied') {
            $viewUsed = 'challenge.core-subject-task';
            $controllerMethod = 'showAppliedSubjectTask';
        } else if ($challenge->subject_type === 'specialized') {
            $viewUsed = 'challenge.core-subject-task';
            $controllerMethod = 'showSpecializedSubjectTask';
        }

        return response()->json([
            'task_id' => $task->id,
            'challenge_id' => $challenge->id,
            'category_name' => $categoryName,
            'programming_language' => $challenge->programming_language ?? 'none',
            'is_coding_task' => $isCodingTask,
            'subject_type' => $challenge->subject_type,
            'view_used' => $viewUsed,
            'controller_method' => $controllerMethod,
            'route_used' => $challenge->subject_type === 'core' ? 'core.challenge.task' :
                           ($challenge->subject_type === 'applied' ? 'applied.challenge.task' :
                           ($challenge->subject_type === 'specialized' ? 'specialized.challenge.task' : 'challenge.task'))
        ]);
    })->middleware('auth');

    // Subject routes
    Route::get('subjects/core', [\App\Http\Controllers\SubjectsController::class, 'coreSubjects'])->name('subjects.core');
    Route::get('subjects/applied', [\App\Http\Controllers\SubjectsController::class, 'appliedSubjects'])->name('subjects.applied');
    Route::get('subjects/specialized', [\App\Http\Controllers\SubjectsController::class, 'specializedSubjects'])->name('subjects.specialized');

    // Specialized Track routes
    Route::get('subjects/specialized/abm', [\App\Http\Controllers\SubjectsController::class, 'abmTrack'])->name('subjects.specialized.abm');
    Route::get('subjects/specialized/abm/investsmart', [\App\Http\Controllers\InvestSmartController::class, 'index'])->name('subjects.specialized.abm.investsmart');

    // InvestSmart API Routes
    Route::prefix('api/investsmart')->middleware('auth')->group(function () {
        Route::get('/portfolio', [\App\Http\Controllers\InvestSmartController::class, 'getPortfolio']);
        Route::get('/market', [\App\Http\Controllers\InvestSmartController::class, 'getMarketData']);
        Route::post('/buy', [\App\Http\Controllers\InvestSmartController::class, 'buyStock']);
        Route::post('/sell', [\App\Http\Controllers\InvestSmartController::class, 'sellStock']);
        Route::get('/transactions', [\App\Http\Controllers\InvestSmartController::class, 'getTransactions']);
        Route::post('/update-prices', [\App\Http\Controllers\InvestSmartController::class, 'updatePrices']);
    });


    Route::get('subjects/specialized/he', [\App\Http\Controllers\SubjectsController::class, 'heTrack'])->name('subjects.specialized.he');
    Route::get('subjects/specialized/humms', [\App\Http\Controllers\SubjectsController::class, 'hummsTrack'])->name('subjects.specialized.humms');
    Route::get('subjects/specialized/stem', [\App\Http\Controllers\SubjectsController::class, 'stemTrack'])->name('subjects.specialized.stem');
    // Route::get('subjects/specialized/stem/chemistry-lab', [\App\Http\Controllers\ChemistryLabController::class, 'index'])->name('subjects.specialized.stem.chemistry-lab');
    // Route::get('subjects/specialized/stem/chemistry-lab/free-experiment', [\App\Http\Controllers\ChemistryLabController::class, 'freeExperiment'])->name('subjects.specialized.stem.chemistry-lab.free-experiment');
    // Route::get('subjects/specialized/stem/chemistry-lab/challenge/{challenge}', [\App\Http\Controllers\ChemistryLabController::class, 'showChallenge'])->name('subjects.specialized.stem.chemistry-lab.challenge');
    // Route::post('subjects/specialized/stem/chemistry-lab/challenge/{challenge}/submit', [\App\Http\Controllers\ChemistryLabController::class, 'submitChallenge'])->name('subjects.specialized.stem.chemistry-lab.submit');
    Route::get('subjects/specialized/ict', [\App\Http\Controllers\SubjectsController::class, 'ictTrack'])->name('subjects.specialized.ict');

    // Dynamic route for any strand - must be after specific strand routes
    Route::get('subjects/specialized/{code}', [\App\Http\Controllers\SubjectsController::class, 'showStrand'])->name('subjects.specialized.strand');

    // Dynamic route for any subject type - must be after specific routes
    Route::get('subjects/{code}', [\App\Http\Controllers\SubjectsController::class, 'showSubjectType'])->name('subjects.type');
    // Notification routes
    Route::get('notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications');
    Route::get('api/notifications', [\App\Http\Controllers\NotificationController::class, 'getNotifications'])->name('notifications.get');
    Route::post('api/notifications/{id}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('api/notifications/read-all', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');

    // Approval notification routes
    Route::get('api/check-pending-approvals', [\App\Http\Controllers\ApprovalNotificationController::class, 'checkPendingApprovals'])->name('check-pending-approvals');
    Route::get('api/check-pending-recipe-approvals', [\App\Http\Controllers\ApprovalNotificationController::class, 'checkPendingRecipeApprovals'])->name('check-pending-recipe-approvals');


    Route::get('courses', [CourseController::class, 'index'])->name('courses');
    Route::get('learning-materials', [\App\Http\Controllers\LearningMaterialController::class, 'index'])->name('learning-materials');
    Route::get('assignments', [\App\Http\Controllers\AssignmentController::class, 'index'])->name('assignments');
    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'index'])->name('profile');
    Route::get('feedback', [\App\Http\Controllers\FeedbackController::class, 'index'])->name('feedback');
    Route::get('schedule', [ScheduleController::class, 'index'])->name('schedule');
    Route::view('grades','grades')->name('grades');
    Route::view('messages','messages')->name('messages');
    // Attendance routes
    Route::get('attendance', [\App\Http\Controllers\AttendanceController::class, 'myAttendance'])->name('attendance.my-attendance');
    Route::get('attendance/students', [\App\Http\Controllers\AttendanceController::class, 'allStudents'])
        ->name('attendance.all-students')
        ->middleware('can:view-student-attendance');
    Route::get('attendance/students/{id}', [\App\Http\Controllers\AttendanceController::class, 'studentDetail'])
        ->name('attendance.student-detail')
        ->middleware('can:view-student-attendance');

    // Activity Goals Routes
    Route::resource('goals', ActivityGoalController::class);
    Route::post('/goals/{goal}/complete', [ActivityGoalController::class, 'complete'])->name('goals.complete');
    Route::get('/api/active-goals', [ActivityGoalController::class, 'getActiveGoals'])->name('api.active-goals');

    // Test routes for attendance
    Route::get('test-attendance', [\App\Http\Controllers\TestAttendanceController::class, 'index'])->name('test.attendance.index');
    Route::get('test-attendance/run', [\App\Http\Controllers\TestAttendanceController::class, 'testAttendance'])->name('test.attendance');

    // Debug route for attendance middleware
    Route::get('debug-attendance', function() {
        return response()->json([
            'message' => 'Attendance middleware test',
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'authenticated' => \Illuminate\Support\Facades\Auth::check(),
            'timestamp' => now()->toDateTimeString(),
        ]);
    })->name('debug.attendance');

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

    // Typing Test routes
    Route::get('typing-test', [\App\Http\Controllers\TypingTestController::class, 'index'])->name('typing-test');
    Route::get('typing-test/words', [\App\Http\Controllers\TypingTestController::class, 'getWords'])->name('typing-test.words');
    Route::post('typing-test/save-result', [\App\Http\Controllers\TypingTestController::class, 'saveResult'])->name('typing-test.save-result');
    Route::get('typing-test/history', [\App\Http\Controllers\TypingTestController::class, 'getHistory'])->name('typing-test.history');

    // Recipe Builder routes
    Route::get('recipe-builder', [\App\Http\Controllers\RecipeBuilderController::class, 'index'])->name('recipe-builder');
    Route::get('recipe-builder/ingredients', [\App\Http\Controllers\RecipeBuilderController::class, 'getIngredients'])->name('recipe-builder.ingredients');
    Route::get('recipe-builder/template/{id}', [\App\Http\Controllers\RecipeBuilderController::class, 'getTemplate'])->name('recipe-builder.template');
    Route::post('recipe-builder/save', [\App\Http\Controllers\RecipeBuilderController::class, 'saveRecipe'])->name('recipe-builder.save');
    Route::get('recipe-builder/user-recipe/{id}', [\App\Http\Controllers\RecipeBuilderController::class, 'getUserRecipe'])->name('recipe-builder.user-recipe');
    Route::get('recipe-builder/user-recipes', [\App\Http\Controllers\RecipeBuilderController::class, 'getUserRecipes'])->name('recipe-builder.user-recipes');
    Route::delete('recipe-builder/delete/{id}', [\App\Http\Controllers\RecipeBuilderController::class, 'deleteRecipe'])->name('recipe-builder.delete');

    Route::view('help-center', 'help-center')->name('help-center');
    Route::view('technical-support', 'technical-support')->name('technical-support');
    Route::get('rate-us', [\App\Http\Controllers\RateUsController::class, 'index'])->name('rate-us');
    Route::post('rate-us', [\App\Http\Controllers\RateUsController::class, 'store'])->name('rate-us.store');

    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

    // STEM Specialized Subject Routes
    Route::prefix('subjects/specialized/stem')->name('subjects.specialized.stem.')->group(function () {
        // Route::get('/molecule-builder', [MoleculeBuilderController::class, 'index'])->name('molecule-builder.index'); // Comment out or remove old route
        Route::get('/equation-drop', [EquationDropController::class, 'index'])->name('equation-drop.index'); // Add new route
    });

    // HUMMS Specialized Subject Routes
    Route::prefix('subjects/specialized/humms')->name('subjects.specialized.humms.')->group(function () {
        Route::get('/historical-timeline-maze', [HistoricalTimelineMazeController::class, 'index'])->name('historical-timeline-maze.index');
        Route::get('/historical-timeline-maze/events', [HistoricalTimelineMazeController::class, 'getEvents'])->name('historical-timeline-maze.events');
        Route::post('/historical-timeline-maze/save-progress', [HistoricalTimelineMazeController::class, 'saveProgress'])->name('historical-timeline-maze.save-progress');
    });
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

// Database connection test routes
Route::get('/test-db-connection', function () {
    return view('test-db-connection');
})->middleware('auth')->name('test.db-connection');

// Database fix route
Route::get('/fix-student-answers-table', [\App\Http\Controllers\DatabaseFixController::class, 'fixStudentAnswersTable'])
    ->middleware('auth')->name('fix.student-answers-table');

Route::post('/test-create-student-answer', function (Illuminate\Http\Request $request) {
    try {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'task_id' => 'required|exists:tasks,id',
            'submitted_text' => 'required|string'
        ]);

        $studentAnswer = \App\Models\StudentAnswer::create([
            'user_id' => $validated['user_id'],
            'task_id' => $validated['task_id'],
            'submitted_text' => $validated['submitted_text'],
            'status' => 'submitted',
            'is_correct' => false
        ]);

        return redirect()->route('test.db-connection')
            ->with('success', "Test answer created successfully! ID: {$studentAnswer->id}");
    } catch (\Exception $e) {
        return redirect()->route('test.db-connection')
            ->with('error', "Error creating test answer: {$e->getMessage()}");
    }
})->middleware('auth')->name('test.create-student-answer');

// Debug route to test core-subject-task template
Route::get('/debug-core-task/{challenge}/{task}', [ChallengeController::class, 'showCoreSubjectTask'])
    ->middleware('auth');

// AI Chat routes
Route::get('/ai/stream', [\App\Http\Controllers\AiStreamController::class, 'stream'])->name('ai.stream');

// Activity data for dashboard
Route::get('/api/user-activity', [\App\Http\Controllers\ActivityController::class, 'getUserActivityData'])
    ->name('api.user-activity')
    ->middleware('auth');

// Refresh activity graph cache
Route::get('/refresh-activity', function() {
    $userId = Auth::id();
    if (!$userId) return redirect()->route('login');

    // Clear all activity-related caches
    Cache::forget("user_activity_{$userId}_6_all");
    Cache::forget("user_activity_{$userId}_3_all");
    Cache::forget("user_activity_{$userId}_9_all");
    Cache::forget("user_activity_{$userId}_12_all");
    Cache::forget("dashboard_data_{$userId}");

    return redirect()->route('dashboard')->with('status', 'Activity graph refreshed!');
})->name('refresh-activity')->middleware('auth');

// Level-up Data Demo
Route::get('/level-up-data-demo', function () {
    return view('level-up-data-demo');
})->name('level-up-data-demo');

// Debug route for investment challenges
Route::get('/debug-investment-challenges', function() {
    $challenges = \App\Models\InvestmentChallenge::all();
    return response()->json([
        'count' => $challenges->count(),
        'challenges' => $challenges
    ]);
});

// Fix ICT Programming Tasks
Route::get('/fix-ict-tasks', [\App\Http\Controllers\FixIctTasksController::class, 'fixTasks'])
    ->name('fix.ict-tasks');

// Password verification for auto-lock feature
Route::post('/verify-password', [\App\Http\Controllers\PasswordVerificationController::class, 'verify'])
    ->middleware('auth')
    ->name('verify-password');

// Debug route for investment challenges
Route::get('/debug-investment-challenges', function() {
    $challenges = \App\Models\InvestmentChallenge::all();
    return response()->json([
        'count' => $challenges->count(),
        'challenges' => $challenges
    ]);
});

require __DIR__.'/auth.php';
