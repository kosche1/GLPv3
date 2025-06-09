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

    /**
     * Broadcast user online status to friends
     */
    public function broadcastUserOnlineStatus(User $user, string $status): void
    {
        // Get user's friends
        $friends = $user->friends();

        foreach ($friends as $friend) {
            $this->broadcastToUser($friend, 'friend-status-update', [
                'friend_id' => $user->id,
                'friend_name' => $user->name,
                'status' => $status,
                'last_activity_at' => $user->last_activity_at?->toISOString(),
                'timestamp' => now()->toISOString(),
            ]);
        }
    }

    /**
     * Broadcast friend request notification
     */
    public function broadcastFriendRequest(User $sender, User $receiver): void
    {
        $this->broadcastToUser($receiver, 'friend-request-received', [
            'sender_id' => $sender->id,
            'sender_name' => $sender->name,
            'sender_initials' => $sender->initials(),
            'sender_level' => $sender->getLevel(),
            'sender_points' => $sender->getPoints(),
            'timestamp' => now()->toISOString(),
        ]);
    }

    /**
     * Broadcast friend request acceptance
     */
    public function broadcastFriendRequestAccepted(User $accepter, User $requester): void
    {
        $this->broadcastToUser($requester, 'friend-request-accepted', [
            'accepter_id' => $accepter->id,
            'accepter_name' => $accepter->name,
            'accepter_initials' => $accepter->initials(),
            'accepter_level' => $accepter->getLevel(),
            'accepter_points' => $accepter->getPoints(),
            'timestamp' => now()->toISOString(),
        ]);
    }

    /**
     * Get online friends for a user
     */
    public function getOnlineFriends(User $user): array
    {
        $friends = $user->friends();

        return $friends->filter(function ($friend) {
            return $friend->last_activity_at &&
                   $friend->last_activity_at->diffInMinutes(now()) <= 5;
        })->map(function ($friend) {
            return [
                'id' => $friend->id,
                'name' => $friend->name,
                'initials' => $friend->initials(),
                'level' => $friend->getLevel(),
                'points' => $friend->getPoints(),
                'status' => 'online',
                'last_activity_at' => $friend->last_activity_at->toISOString(),
            ];
        })->values()->toArray();
    }

    /**
     * Broadcast message to a specific user
     */
    private function broadcastToUser(User $user, string $eventType, array $data): void
    {
        // Store the message in cache for the user to retrieve
        $cacheKey = "user_messages_{$user->id}";
        $messages = Cache::get($cacheKey, []);

        $messages[] = [
            'event' => $eventType,
            'data' => $data,
            'timestamp' => now()->toISOString(),
            'id' => uniqid(),
        ];

        // Keep only the last 20 messages
        $messages = array_slice($messages, -20);

        Cache::put($cacheKey, $messages, now()->addHours(24));

        // Here you would typically broadcast to WebSocket channels
        // broadcast(new UserMessage($user, $eventType, $data));
    }
}
