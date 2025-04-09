<?php

namespace App\Listeners;

use App\Events\UserCompletedChallenge;
use App\Services\NotificationService;

class SendChallengeCompletionNotification
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
    public function handle(UserCompletedChallenge $event): void
    {
        // Create a challenge completion notification
        $this->notificationService->createNotification(
            $event->user,
            "Congratulations! You've completed the challenge: {$event->challenge->name}",
            'achievement',
            route('challenge', ['challenge' => $event->challenge->id])
        );
    }
}
