<?php

namespace App\Livewire;

use App\Models\User;
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
                    ];
                }

                // Sort combined history by date (newest first)
                usort($this->activityHistory, function($a, $b) {
                    return strtotime($b['date']) - strtotime($a['date']);
                });

                // Limit to 20 entries after combining
                $this->activityHistory = array_slice($this->activityHistory, 0, 20);
            } catch (\Exception $e) {
                Log::error('Error fetching activity history: ' . $e->getMessage());
            }
        } catch (\Exception $e) {
            // Handle error
            $this->activityHistory = [];
        }

        $this->loading = false;
    }

    public function render()
    {
        return view('livewire.user-activity-history-modal');
    }
}
