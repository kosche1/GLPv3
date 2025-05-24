<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Notification;
use Livewire\Component;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserActivityHistoryModal extends Component
{
    public $isOpen = false;
    public $userId = null;
    public $userName = '';
    public $userLevel = 1;
    public $userPoints = 0;
    public $activityHistory = [];
    public $loading = false;

    protected $listeners = ['openUserActivityModal' => 'openModal'];

    /**
     * Open the modal and load user activity history
     *
     * @param int $userId
     * @return void
     */
    public function openModal($userId)
    {
        $this->loading = true;
        $this->userId = $userId;
        $this->isOpen = true;
        $this->loadUserActivityHistory();
    }

    /**
     * Close the modal
     *
     * @return void
     */
    public function closeModal()
    {
        $this->isOpen = false;
        $this->userId = null;
        $this->userName = '';
        $this->userLevel = 1;
        $this->userPoints = 0;
        $this->activityHistory = [];
    }

    /**
     * Load user activity history
     *
     * @return void
     */
    protected function loadUserActivityHistory()
    {
        if (!$this->userId) {
            $this->loading = false;
            return;
        }

        try {
            $user = User::findOrFail($this->userId);
            $this->userName = $user->name;
            $this->userLevel = $user->getLevel();
            $this->userPoints = $user->getPoints();

            // Get experience history from experience_audits table
            try {
                $this->activityHistory = DB::table('experience_audits')
                    ->where('user_id', $user->id)
                    ->orderBy('created_at', 'desc')
                    ->get()
                    ->map(function ($entry) {
                        $createdAt = Carbon::parse($entry->created_at)->setTimezone('Asia/Manila');
                        return [
                            'id' => $entry->id,
                            'points' => $entry->points,
                            'type' => $entry->type,
                            'reason' => $entry->reason,
                            'date' => $createdAt->format('M d, Y h:i A'),
                            'time_ago' => $createdAt->diffForHumans(),
                            'activity_type' => 'experience', // Add activity type to distinguish from notifications
                            'sort_timestamp' => $createdAt->timestamp, // Add for proper sorting
                        ];
                    })
                    ->toArray();

                // Also check for daily login rewards
                $dailyRewards = DB::table('user_daily_rewards')
                    ->where('user_id', $user->id)
                    ->orderBy('claimed_at', 'desc')
                    ->get();

                foreach ($dailyRewards as $reward) {
                    // Get the reward tier to determine points
                    $rewardTier = DB::table('daily_reward_tiers')
                        ->where('id', $reward->daily_reward_tier_id)
                        ->first();

                    $points = $rewardTier ? $rewardTier->points_reward : 10;

                    // Add to activity history
                    $claimedAt = Carbon::parse($reward->claimed_at)->setTimezone('Asia/Manila');
                    $this->activityHistory[] = [
                        'id' => 'dr_' . $reward->id, // Prefix to distinguish from experience audits
                        'points' => $points,
                        'type' => 'add',
                        'reason' => "Daily login reward - Day {$reward->current_streak}",
                        'date' => $claimedAt->format('M d, Y h:i A'),
                        'time_ago' => $claimedAt->diffForHumans(),
                        'activity_type' => 'reward', // Add activity type to distinguish from notifications
                        'sort_timestamp' => $claimedAt->timestamp, // Add for proper sorting
                    ];
                }

                // Get badges earned by the user
                $userBadges = DB::table('user_badges')
                    ->join('badges', 'user_badges.badge_id', '=', 'badges.id')
                    ->where('user_badges.user_id', $user->id)
                    ->orderBy('user_badges.earned_at', 'desc')
                    ->get();

                foreach ($userBadges as $badge) {
                    $earnedAt = Carbon::parse($badge->earned_at)->setTimezone('Asia/Manila');
                    $this->activityHistory[] = [
                        'id' => 'badge_' . $badge->badge_id,
                        'points' => 0, // Badges don't give points directly
                        'type' => 'badge',
                        'reason' => "Earned badge: {$badge->name}",
                        'date' => $earnedAt->format('M d, Y h:i A'),
                        'time_ago' => $earnedAt->diffForHumans(),
                        'activity_type' => 'badge',
                        'badge_name' => $badge->name,
                        'badge_description' => $badge->description,
                        'badge_image' => $badge->image,
                        'rarity_level' => $badge->rarity_level,
                        'sort_timestamp' => $earnedAt->timestamp, // Add for proper sorting
                    ];
                }

                // Get achievements earned by the user
                $userAchievements = DB::table('achievement_user')
                    ->join('achievements', 'achievement_user.achievement_id', '=', 'achievements.id')
                    ->where('achievement_user.user_id', $user->id)
                    ->orderBy('achievement_user.created_at', 'desc')
                    ->get();

                foreach ($userAchievements as $achievement) {
                    // Use unlocked_at if available, otherwise fall back to created_at
                    $timestamp = $achievement->unlocked_at ?? $achievement->created_at;
                    $unlockedAt = Carbon::parse($timestamp)->setTimezone('Asia/Manila');

                    $this->activityHistory[] = [
                        'id' => 'achievement_' . $achievement->achievement_id,
                        'points' => 0, // Achievements don't directly give points in this system
                        'type' => 'achievement',
                        'reason' => "Unlocked achievement: {$achievement->name}",
                        'date' => $unlockedAt->format('M d, Y h:i A'),
                        'time_ago' => $unlockedAt->diffForHumans(),
                        'activity_type' => 'achievement',
                        'achievement_name' => $achievement->name,
                        'achievement_description' => $achievement->description,
                        'achievement_image' => $achievement->image,
                        'sort_timestamp' => $unlockedAt->timestamp, // Add for proper sorting
                    ];
                }

                // Get notifications for challenge completions and approvals (including achievements as fallback)
                $notifications = Notification::where('user_id', $user->id)
                    ->whereIn('type', ['achievement', 'grade', 'challenge'])
                    ->orderBy('created_at', 'desc')
                    ->get();

                // Keep track of achievement names and reasons we've already added to avoid duplicates
                $addedAchievements = collect($this->activityHistory)
                    ->where('activity_type', 'achievement')
                    ->map(function($item) {
                        return [
                            'name' => $item['achievement_name'] ?? '',
                            'reason' => $item['reason'] ?? '',
                            'normalized_reason' => strtolower(preg_replace('/[^a-z0-9\s]/i', '', $item['reason'] ?? ''))
                        ];
                    })
                    ->toArray();

                foreach ($notifications as $notification) {
                    // Skip achievement notifications if we already have them from the direct query
                    if ($notification->type === 'achievement') {
                        // Normalize the notification message for comparison
                        $normalizedNotification = strtolower(preg_replace('/[^a-z0-9\s]/i', '', $notification->message));

                        // Check if this achievement is already in our list
                        $isDuplicate = false;
                        foreach ($addedAchievements as $existing) {
                            // Compare normalized reasons to catch similar messages
                            if (similar_text($normalizedNotification, $existing['normalized_reason']) > 80) {
                                $isDuplicate = true;
                                break;
                            }

                            // Also check for exact achievement name matches
                            if (!empty($existing['name'])) {
                                $achievementNamePattern = '/achievement[:\s]+(.+?)(?:\s*!|$)/i';
                                if (preg_match($achievementNamePattern, $notification->message, $matches)) {
                                    $achievementName = trim($matches[1]);
                                    if (stripos($existing['name'], $achievementName) !== false ||
                                        stripos($achievementName, $existing['name']) !== false) {
                                        $isDuplicate = true;
                                        break;
                                    }
                                }
                            }
                        }

                        if ($isDuplicate) {
                            continue; // Skip this duplicate achievement
                        }
                    }

                    // Extract points from notification message if available
                    $points = 0;
                    $pointsPattern = '/(\d+) points/i';

                    if (preg_match($pointsPattern, $notification->message, $matches)) {
                        $points = (int) $matches[1];
                    }

                    // Determine notification type for display
                    $displayType = 'add'; // Default to 'add' for most notifications

                    if (strpos($notification->message, 'approved') !== false ||
                        strpos($notification->message, 'completed') !== false ||
                        $notification->type === 'achievement' ||
                        $notification->type === 'grade') {
                        $displayType = 'add';
                    }

                    // Add to activity history
                    $createdAt = Carbon::parse($notification->created_at)->setTimezone('Asia/Manila');
                    $activityType = $notification->type === 'achievement' ? 'achievement' : 'notification';

                    $this->activityHistory[] = [
                        'id' => 'notif_' . $notification->id, // Prefix to distinguish from other entries
                        'points' => $points,
                        'type' => $displayType,
                        'reason' => $notification->message,
                        'date' => $createdAt->format('M d, Y h:i A'),
                        'time_ago' => $createdAt->diffForHumans(),
                        'activity_type' => $activityType, // Use 'achievement' for achievement notifications
                        'notification_type' => $notification->type, // Store the original notification type
                        'link' => $notification->link, // Store the link if available
                        'sort_timestamp' => $createdAt->timestamp, // Add for proper sorting
                    ];
                }

                // Sort combined history by timestamp (newest first) with priority for badges and achievements
                usort($this->activityHistory, function($a, $b) {
                    $timestampA = $a['sort_timestamp'] ?? strtotime($a['date']);
                    $timestampB = $b['sort_timestamp'] ?? strtotime($b['date']);

                    // Give slight priority to badges and achievements if they're within 1 hour of other activities
                    $timeDiff = abs($timestampA - $timestampB);
                    $oneHour = 3600; // 1 hour in seconds

                    if ($timeDiff <= $oneHour) {
                        // If activities are within 1 hour of each other, prioritize badges and achievements
                        $aPriority = (isset($a['activity_type']) && in_array($a['activity_type'], ['badge', 'achievement'])) ? 1 : 0;
                        $bPriority = (isset($b['activity_type']) && in_array($b['activity_type'], ['badge', 'achievement'])) ? 1 : 0;

                        if ($aPriority !== $bPriority) {
                            return $bPriority - $aPriority; // Higher priority first
                        }
                    }

                    return $timestampB - $timestampA; // Newest first
                });

                // Limit to 50 entries after combining to show more comprehensive history
                $this->activityHistory = array_slice($this->activityHistory, 0, 50);
            } catch (\Exception $e) {
                Log::error('Error fetching activity history: ' . $e->getMessage());
            }
        } catch (\Exception $e) {
            // Handle error
            Log::error('Error in user activity history: ' . $e->getMessage());
            $this->activityHistory = [];
        }

        $this->loading = false;
    }

    public function render()
    {
        return view('livewire.user-activity-history-modal');
    }
}
