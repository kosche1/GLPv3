<?php

namespace App\Services;

use App\Models\Badge;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Log;

class BadgeService
{
    /**
     * The notification service instance.
     *
     * @var NotificationService
     */
    private NotificationService $notificationService;

    /**
     * Create a new badge service instance.
     *
     * @param NotificationService $notificationService
     */
    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Check and award level-based badges to a user
     *
     * @param User $user
     * @return array Array of awarded badge IDs
     */
    public function checkAndAwardLevelBadges(User $user): array
    {
        $userLevel = $user->getLevel();
        $awardedBadges = [];
        $processedBadgeTypes = []; // Track badge types by name and level to avoid duplicates

        // First, let's clean up any duplicate badges the user might have
        $this->cleanupDuplicateBadges($user);

        // Get all level-based badges
        $levelBadges = Badge::where('trigger_type', 'level')
            ->orderBy('trigger_conditions->level', 'asc')
            ->get();

        foreach ($levelBadges as $badge) {
            // Handle JSON string or array for trigger_conditions
            $triggerConditions = $badge->trigger_conditions;
            if (is_string($triggerConditions)) {
                $triggerConditions = json_decode($triggerConditions, true);
            }

            $requiredLevel = $triggerConditions['level'] ?? null;

            // Skip if no level requirement or user doesn't meet the requirement
            if (!$requiredLevel || $userLevel < $requiredLevel) {
                continue;
            }

            // Create a unique key for this badge type (name + level)
            $badgeKey = $badge->name . '_' . $requiredLevel;

            // Skip if we've already processed a badge of this type (same name and level)
            if (in_array($badgeKey, $processedBadgeTypes)) {
                Log::info("Skipping duplicate badge type: {$badgeKey}");
                continue;
            }

            // Mark this badge type as processed
            $processedBadgeTypes[] = $badgeKey;

            // Check if user already has this badge
            $hasBadge = $user->badges()->where('badge_id', $badge->id)->exists();

            if (!$hasBadge) {
                // Award the badge
                $user->badges()->attach($badge->id, [
                    'earned_at' => now(),
                    'is_pinned' => false,
                    'is_showcased' => false,
                ]);

                $awardedBadges[] = $badge->id;

                // Create a notification for the badge
                $this->notificationService->badgeNotification(
                    $user,
                    $badge->name,
                    route('profile') // Link to profile page where badges are displayed
                );

                Log::info("Awarded level badge '{$badge->name}' to user {$user->name} (ID: {$user->id})");
            }
        }

        return $awardedBadges;
    }

    /**
     * Clean up duplicate badges for a user
     *
     * @param User $user
     * @return void
     */
    private function cleanupDuplicateBadges(User $user): void
    {
        // Get all the user's badges grouped by name
        $userBadges = $user->badges()->get();
        $badgesByName = [];

        foreach ($userBadges as $badge) {
            $badgeName = $badge->name;

            if (!isset($badgesByName[$badgeName])) {
                $badgesByName[$badgeName] = [];
            }

            $badgesByName[$badgeName][] = $badge;
        }

        // For each group of badges with the same name, keep only the first one
        foreach ($badgesByName as $badgeName => $badges) {
            if (count($badges) > 1) {
                // Keep the first badge, detach the rest
                array_shift($badges); // Remove the first badge from the array (we're keeping it)

                foreach ($badges as $badge) {
                    Log::info("Removing duplicate badge '{$badgeName}' (ID: {$badge->id}) from user {$user->name} (ID: {$user->id})");
                    $user->badges()->detach($badge->id);
                }
            }
        }
    }

    /**
     * Get badges for a user
     *
     * @param User $user
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUserBadges(User $user)
    {
        return $user->badges()->orderBy('user_badges.earned_at', 'desc')->get();
    }
}


