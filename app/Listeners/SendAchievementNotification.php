<?php

namespace App\Listeners;

use App\Services\NotificationService;
use LevelUp\Experience\Events\AchievementAwarded;

class SendAchievementNotification
{
    /**
     * The notification service instance.
     *
     * @var NotificationService
     */
    protected $notificationService;

    /**
     * Create the event listener.
     */
    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Handle the event.
     */
    public function handle(AchievementAwarded $event): void
    {
        // Create an achievement notification
        $this->notificationService->achievementNotification(
            $event->user,
            $event->achievement->name,
            route('profile') // Link to profile page
        );
    }
}
