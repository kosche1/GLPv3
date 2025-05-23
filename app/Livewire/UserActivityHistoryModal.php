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
                    ->take(20)
                    ->get()
                    ->map(function ($entry) {
                        return [
                            'id' => $entry->id,
                            'points' => $entry->points,
                            'type' => $entry->type,
                            'reason' => $entry->reason,
                            'date' => Carbon::parse($entry->created_at)->format('M d, Y h:i A'),
                            'time_ago' => Carbon::parse($entry->created_at)->diffForHumans(),
                            'activity_type' => 'experience', // Add activity type to distinguish from notifications
                        ];
                    })
                    ->toArray();

                // Also check for daily login rewards
                $dailyRewards = DB::table('user_daily_rewards')
                    ->where('user_id', $user->id)
                    ->orderBy('claimed_at', 'desc')
                    ->take(10)
                    ->get();

                foreach ($dailyRewards as $reward) {
                    // Get the reward tier to determine points
                    $rewardTier = DB::table('daily_reward_tiers')
                        ->where('id', $reward->daily_reward_tier_id)
                        ->first();

                    $points = $rewardTier ? $rewardTier->points_reward : 10;

                    // Add to activity history
                    $this->activityHistory[] = [
                        'id' => 'dr_' . $reward->id, // Prefix to distinguish from experience audits
                        'points' => $points,
                        'type' => 'add',
                        'reason' => "Daily login reward - Day {$reward->current_streak}",
                        'date' => Carbon::parse($reward->claimed_at)->format('M d, Y h:i A'),
                        'time_ago' => Carbon::parse($reward->claimed_at)->diffForHumans(),
                        'activity_type' => 'reward', // Add activity type to distinguish from notifications
                    ];
                }

                // Get notifications for challenge completions and approvals
                $notifications = Notification::where('user_id', $user->id)
                    ->whereIn('type', ['achievement', 'grade', 'challenge'])
                    ->orderBy('created_at', 'desc')
                    ->take(20)
                    ->get();

                foreach ($notifications as $notification) {
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
                    $this->activityHistory[] = [
                        'id' => 'notif_' . $notification->id, // Prefix to distinguish from other entries
                        'points' => $points,
                        'type' => $displayType,
                        'reason' => $notification->message,
                        'date' => Carbon::parse($notification->created_at)->format('M d, Y h:i A'),
                        'time_ago' => Carbon::parse($notification->created_at)->diffForHumans(),
                        'activity_type' => 'notification', // Add activity type to distinguish from other activities
                        'notification_type' => $notification->type, // Store the original notification type
                        'link' => $notification->link, // Store the link if available
                    ];
                }

                // Sort combined history by date (newest first)
                usort($this->activityHistory, function($a, $b) {
                    return strtotime($b['date']) - strtotime($a['date']);
                });

                // Limit to 30 entries after combining (increased from 20 to show more history)
                $this->activityHistory = array_slice($this->activityHistory, 0, 30);
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
