<?php

namespace App\Services;

use App\Events\ActivityTracked;
use App\Events\ChallengeProgressUpdated;
use App\Events\LeaderboardUpdated;
use App\Events\RealTimeNotification;
use App\Models\User;
use App\Models\Challenge;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class RealTimeService
{
    /**
     * Broadcast leaderboard update
     */
    public function broadcastLeaderboardUpdate(User $user): void
    {
        $leaderboardData = $this->getLeaderboardData();
        $userRank = $this->getUserRank($user, $leaderboardData);

        event(new LeaderboardUpdated($user, $leaderboardData, $userRank));
    }

    /**
     * Broadcast real-time notification
     */
    public function broadcastNotification(User $user, array $notification): void
    {
        event(new RealTimeNotification($user, $notification));
    }

    /**
     * Broadcast activity tracking
     */
    public function broadcastActivity(User $user, string $activityType, array $activityData = []): void
    {
        event(new ActivityTracked($user, $activityType, $activityData));
    }

    /**
     * Broadcast challenge progress update
     */
    public function broadcastChallengeProgress(User $user, Challenge $challenge, int $progress, bool $isCompleted = false): void
    {
        event(new ChallengeProgressUpdated($user, $challenge, $progress, $isCompleted));
    }

    /**
     * Get current leaderboard data
     */
    private function getLeaderboardData(): array
    {
        return Cache::remember('leaderboard_data', 60, function () {
            return User::query()
                ->role('student')
                ->join('experiences', 'users.id', '=', 'experiences.user_id')
                ->leftJoin('levels', 'experiences.level_id', '=', 'levels.id')
                ->select([
                    'users.id',
                    'users.name',
                    'experiences.experience_points',
                    'experiences.level_id',
                    'levels.level'
                ])
                ->orderBy('experiences.experience_points', 'desc')
                ->limit(50)
                ->get()
                ->map(function ($user, $index) {
                    return [
                        'rank' => $index + 1,
                        'user_id' => $user->id,
                        'user_name' => $user->name,
                        'experience_points' => $user->experience_points,
                        'level' => $user->level ?? 1,
                    ];
                })
                ->toArray();
        });
    }

    /**
     * Get user's rank in leaderboard
     */
    private function getUserRank(User $user, array $leaderboardData): ?int
    {
        foreach ($leaderboardData as $entry) {
            if ($entry['user_id'] === $user->id) {
                return $entry['rank'];
            }
        }
        return null;
    }

    /**
     * Send achievement notification
     */
    public function sendAchievementNotification(User $user, string $achievementName, string $description = ''): void
    {
        $notification = [
            'type' => 'achievement',
            'title' => 'Achievement Unlocked!',
            'message' => "You've earned the '{$achievementName}' achievement!",
            'link' => route('profile'),
        ];

        $this->broadcastNotification($user, $notification);
    }

    /**
     * Send level up notification
     */
    public function sendLevelUpNotification(User $user, int $newLevel): void
    {
        $notification = [
            'type' => 'level_up',
            'title' => 'Level Up!',
            'message' => "Congratulations! You've reached Level {$newLevel}!",
            'link' => route('profile'),
        ];

        $this->broadcastNotification($user, $notification);
        $this->broadcastLeaderboardUpdate($user);
    }

    /**
     * Send challenge completion notification
     */
    public function sendChallengeCompletionNotification(User $user, Challenge $challenge): void
    {
        $notification = [
            'type' => 'challenge',
            'title' => 'Challenge Completed!',
            'message' => "You've completed the '{$challenge->name}' challenge!",
            'link' => route('learning'),
        ];

        $this->broadcastNotification($user, $notification);
        $this->broadcastChallengeProgress($user, $challenge, 100, true);
        $this->broadcastLeaderboardUpdate($user);
    }

    /**
     * Track user activity in real-time
     */
    public function trackActivity(User $user, string $activityType, array $data = []): void
    {
        $activityData = array_merge($data, [
            'timestamp' => now()->toISOString(),
            'user_level' => $user->getLevel(),
            'user_points' => $user->getPoints(),
        ]);

        $this->broadcastActivity($user, $activityType, $activityData);
    }
}
