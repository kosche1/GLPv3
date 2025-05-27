<?php

namespace App\Listeners;

use App\Services\NotificationService;
use App\Services\RealTimeService;
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
     * The real-time service instance.
     *
     * @var RealTimeService
     */
    protected $realTimeService;

    /**
     * Create the event listener.
     */
    public function __construct(NotificationService $notificationService, RealTimeService $realTimeService)
    {
        $this->notificationService = $notificationService;
        $this->realTimeService = $realTimeService;
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

        // Broadcast real-time level up notification
        $this->realTimeService->sendLevelUpNotification($event->user, $event->level);
    }
}
