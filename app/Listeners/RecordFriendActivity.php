<?php

namespace App\Listeners;

use App\Services\ActivityFeedService;
use App\Events\FriendActivityCreated;
use LevelUp\Experience\Events\AchievementAwarded;
use LevelUp\Experience\Events\UserLevelledUp;
use App\Events\UserCompletedChallenge;
use App\Events\ChallengeCompleted;

class RecordFriendActivity
{
    /**
     * The activity feed service instance.
     */
    protected ActivityFeedService $activityService;

    /**
     * Create the event listener.
     */
    public function __construct(ActivityFeedService $activityService)
    {
        $this->activityService = $activityService;
    }

    /**
     * Handle challenge completion events.
     */
    public function handleChallengeCompleted($event): void
    {
        $user = $event->user;
        $challenge = $event->challenge;
        
        $activity = $this->activityService->recordChallengeCompletion($user, $challenge);
        
        // Broadcast the activity to friends
        broadcast(new FriendActivityCreated($activity));
    }

    /**
     * Handle achievement awarded events.
     */
    public function handleAchievementAwarded(AchievementAwarded $event): void
    {
        $user = $event->user;
        $achievement = $event->achievement;
        
        $activity = $this->activityService->recordAchievementUnlocked($user, $achievement);
        
        // Broadcast the activity to friends
        broadcast(new FriendActivityCreated($activity));
    }

    /**
     * Handle user level up events.
     */
    public function handleUserLevelledUp(UserLevelledUp $event): void
    {
        $user = $event->user;
        $newLevel = $event->level;
        
        $activity = $this->activityService->recordLevelUp($user, $newLevel);
        
        // Broadcast the activity to friends
        broadcast(new FriendActivityCreated($activity));
    }

    /**
     * Register the listeners for the subscriber.
     */
    public function subscribe($events): array
    {
        return [
            UserCompletedChallenge::class => 'handleChallengeCompleted',
            ChallengeCompleted::class => 'handleChallengeCompleted',
            AchievementAwarded::class => 'handleAchievementAwarded',
            UserLevelledUp::class => 'handleUserLevelledUp',
        ];
    }
}
