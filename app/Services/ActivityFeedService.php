<?php

namespace App\Services;

use App\Models\User;
use App\Models\FriendActivity;
use App\Models\Challenge;
use App\Models\Badge;
use LevelUp\Experience\Models\Achievement;

class ActivityFeedService
{
    /**
     * Record a new activity for the user.
     */
    public function recordActivity(User $user, string $type, array $data): FriendActivity
    {
        return FriendActivity::create([
            'user_id' => $user->id,
            'activity_type' => $type,
            'activity_title' => $this->generateTitle($type, $data),
            'activity_description' => $this->generateDescription($type, $data),
            'activity_data' => $data,
            'points_earned' => $data['points'] ?? 0,
            'is_public' => $data['is_public'] ?? true,
        ]);
    }

    /**
     * Record challenge completion activity.
     */
    public function recordChallengeCompletion(User $user, $challenge, array $additionalData = []): FriendActivity
    {
        $data = array_merge([
            'challenge_id' => $challenge->id ?? null,
            'challenge_name' => $challenge->name ?? $challenge->title ?? 'Challenge',
            'points' => $challenge->points_reward ?? 0,
            'difficulty' => $challenge->difficulty_level ?? null,
            'completion_time' => $additionalData['completion_time'] ?? null,
        ], $additionalData);

        return $this->recordActivity($user, 'challenge_completed', $data);
    }

    /**
     * Record badge earned activity.
     */
    public function recordBadgeEarned(User $user, Badge $badge): FriendActivity
    {
        $data = [
            'badge_id' => $badge->id,
            'badge_name' => $badge->name,
            'badge_description' => $badge->description,
            'rarity_level' => $badge->rarity_level,
        ];

        return $this->recordActivity($user, 'badge_earned', $data);
    }

    /**
     * Record achievement unlocked activity.
     */
    public function recordAchievementUnlocked(User $user, Achievement $achievement): FriendActivity
    {
        $data = [
            'achievement_id' => $achievement->id,
            'achievement_name' => $achievement->name,
            'achievement_description' => $achievement->description,
            'is_secret' => $achievement->is_secret ?? false,
        ];

        return $this->recordActivity($user, 'achievement_unlocked', $data);
    }

    /**
     * Record level up activity.
     */
    public function recordLevelUp(User $user, int $newLevel, int $previousLevel = null): FriendActivity
    {
        $data = [
            'new_level' => $newLevel,
            'previous_level' => $previousLevel ?? ($newLevel - 1),
            'total_points' => $user->getPoints(),
        ];

        return $this->recordActivity($user, 'level_up', $data);
    }

    /**
     * Record streak milestone activity.
     */
    public function recordStreakMilestone(User $user, int $streakDays): FriendActivity
    {
        $data = [
            'streak_days' => $streakDays,
            'streak_type' => 'daily_login', // or other streak types
        ];

        return $this->recordActivity($user, 'streak_milestone', $data);
    }

    /**
     * Record points milestone activity.
     */
    public function recordPointsMilestone(User $user, int $milestone): FriendActivity
    {
        $data = [
            'milestone' => $milestone,
            'total_points' => $user->getPoints(),
        ];

        return $this->recordActivity($user, 'points_milestone', $data);
    }

    /**
     * Get friend activities for a user.
     */
    public function getFriendActivities(User $user, array $filters = ['all'], int $limit = 20): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $friendIds = $user->friends()->pluck('id');

        $query = FriendActivity::whereIn('user_id', $friendIds)
            ->with(['user', 'likes'])
            ->public()
            ->orderBy('created_at', 'desc');

        // Apply filters
        if (!in_array('all', $filters)) {
            $query->whereIn('activity_type', $filters);
        }

        return $query->paginate($limit);
    }

    /**
     * Generate activity title based on type and data.
     */
    private function generateTitle(string $type, array $data): string
    {
        return match($type) {
            'challenge_completed' => "Completed {$data['challenge_name']}",
            'badge_earned' => "Earned the '{$data['badge_name']}' badge",
            'level_up' => "Reached Level {$data['new_level']}",
            'achievement_unlocked' => "Unlocked '{$data['achievement_name']}'",
            'streak_milestone' => "Achieved {$data['streak_days']}-day streak",
            'leaderboard_rank' => "Ranked #{$data['rank']} on leaderboard",
            'study_group_joined' => "Joined '{$data['group_name']}' study group",
            'task_completed' => "Completed task: {$data['task_name']}",
            'points_milestone' => "Reached {$data['milestone']} points milestone",
            default => "New activity",
        };
    }

    /**
     * Generate activity description based on type and data.
     */
    private function generateDescription(string $type, array $data): ?string
    {
        return match($type) {
            'challenge_completed' => $this->getChallengeDescription($data),
            'badge_earned' => $data['badge_description'] ?? null,
            'level_up' => "Advanced from Level {$data['previous_level']} with {$data['total_points']} total points",
            'achievement_unlocked' => $data['achievement_description'] ?? null,
            'streak_milestone' => "Maintained consistent daily activity",
            'points_milestone' => "Accumulated {$data['total_points']} experience points",
            default => null,
        };
    }

    /**
     * Get challenge completion description.
     */
    private function getChallengeDescription(array $data): ?string
    {
        $parts = [];
        
        if (isset($data['difficulty'])) {
            $parts[] = ucfirst($data['difficulty']) . " difficulty";
        }
        
        if (isset($data['points']) && $data['points'] > 0) {
            $parts[] = "+{$data['points']} XP";
        }
        
        if (isset($data['completion_time'])) {
            $parts[] = "in {$data['completion_time']}";
        }

        return !empty($parts) ? implode(' • ', $parts) : null;
    }
}
