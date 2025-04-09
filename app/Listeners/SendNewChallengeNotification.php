<?php

namespace App\Listeners;

use App\Events\UserEnrolledInChallenge;
use App\Services\NotificationService;

class SendNewChallengeNotification
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
    public function handle(UserEnrolledInChallenge $event): void
    {
        // Create a new challenge notification
        $this->notificationService->newChallengeNotification(
            $event->user,
            $event->challenge->name,
            route('challenge', ['challenge' => $event->challenge->id])
        );
    }
}
