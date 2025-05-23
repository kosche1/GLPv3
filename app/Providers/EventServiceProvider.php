<?php

namespace App\Providers;

use App\Models\StudentAnswer;
use App\Observers\StudentAnswerObserver;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use App\Events\UserCompletedChallenge;
use App\Events\UserEnrolledInChallenge;
use App\Events\ChallengeCompleted;
use App\Events\TaskSubmitted;
use App\Listeners\RecordUserAttendance;
use App\Listeners\RecordUserLogin;
use App\Listeners\RecordUserRegistration;
use App\Listeners\RecordChallengeCompletion;
use App\Listeners\RecordTaskSubmission;
use App\Listeners\SendAchievementNotification;
use App\Listeners\SendChallengeCompletionNotification;
use App\Listeners\SendLevelUpNotification;
use App\Listeners\SendNewChallengeNotification;
use App\Listeners\AssignStudentRole;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use LevelUp\Experience\Events\AchievementAwarded;
use LevelUp\Experience\Events\UserLevelledUp;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
            AssignStudentRole::class,
            // RecordUserRegistration is now handled directly in the registration process
            // but we'll keep it here as a backup
            RecordUserRegistration::class,
        ],
        Login::class => [
            RecordUserAttendance::class,
            RecordUserLogin::class,
        ],
        UserLevelledUp::class => [
            SendLevelUpNotification::class,
        ],
        AchievementAwarded::class => [
            SendAchievementNotification::class,
        ],
        UserEnrolledInChallenge::class => [
            SendNewChallengeNotification::class,
        ],
        UserCompletedChallenge::class => [
            SendChallengeCompletionNotification::class,
        ],
        ChallengeCompleted::class => [
            RecordChallengeCompletion::class,
        ],
        TaskSubmitted::class => [
            RecordTaskSubmission::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        // Register the StudentAnswerObserver
        StudentAnswer::observe(StudentAnswerObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
