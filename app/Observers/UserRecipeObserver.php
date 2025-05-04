<?php

namespace App\Observers;

use App\Models\UserRecipe;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Log;

class UserRecipeObserver
{
    /**
     * The notification service instance.
     *
     * @var NotificationService
     */
    protected $notificationService;

    /**
     * Create a new observer instance.
     *
     * @param NotificationService $notificationService
     */
    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Handle the UserRecipe "updated" event.
     */
    public function updated(UserRecipe $userRecipe): void
    {
        // Check if points_awarded was changed from false to true
        if ($userRecipe->points_awarded && $userRecipe->getOriginal('points_awarded') === false) {
            // Create a notification for the student
            try {
                $user = $userRecipe->user;
                $pointsAwarded = $userRecipe->potential_points ?? 0;

                if ($user) {
                    // Create a recipe approval notification
                    $notification = $this->notificationService->createNotification(
                        $user,
                        "Your recipe '{$userRecipe->name}' has been approved! You've earned {$pointsAwarded} points.",
                        'grade',
                        route('recipe-builder')
                    );

                    Log::info('Recipe approval notification created', [
                        'notification_id' => $notification->id,
                        'user_id' => $user->id,
                        'recipe_id' => $userRecipe->id,
                        'points' => $pointsAwarded
                    ]);
                }
            } catch (\Exception $e) {
                Log::error('Error creating recipe approval notification', [
                    'error' => $e->getMessage(),
                    'recipe_id' => $userRecipe->id
                ]);
            }
        }
    }
}
