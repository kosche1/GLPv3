<?php

namespace App\Listeners;

use App\Services\NotificationService;
use LevelUp\Experience\Events\UserLevelledUp;

class SendLevelUpNotification
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
    public function handle(UserLevelledUp $event): void
    {
        // Create a level up notification
        $this->notificationService->levelUpNotification(
            $event->user,
            $event->level,
            route('profile') // Link to profile page
        );
    }
}
