<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use App\Models\UserDailyReward;
use Carbon\Carbon;

class WelcomeModals extends Component
{
    public $showWelcomeModal = false;
    public $showRewardModal = false;
    public $rewardPoints = 10;
    public $currentStreak = 0;

    public function mount()
    {
        // Check if this is a fresh login
        if (session()->has('justLoggedIn')) {
            $this->showWelcomeModal = true;
            session()->forget('justLoggedIn');
        }

        // Calculate the current streak for the user
        if (Auth::check()) {
            $user = Auth::user();

            // Get the user's latest daily reward claim to calculate streak
            $latestReward = UserDailyReward::where('user_id', $user->id)
                ->orderBy('claimed_at', 'desc')
                ->first();

            $this->currentStreak = $latestReward && $latestReward->claimed_at->isYesterday()
                ? $latestReward->current_streak + 1
                : 1;

            Log::info('Calculated streak on mount', [
                'currentStreak' => $this->currentStreak
            ]);
        }
    }

    public function checkDailyReward()
    {
        if (!Auth::check()) {
            return;
        }

        $user = Auth::user();

        // Check if user has already claimed a reward today
        $hasClaimedToday = UserDailyReward::where('user_id', $user->id)
            ->whereDate('claimed_at', Carbon::today())
            ->exists();

        if ($hasClaimedToday) {
            // User has already claimed a reward today, don't show the reward modal
            Log::info('User has already claimed a reward today, not showing reward modal');
            $this->showRewardModal = false;
            return;
        }

        // Get the user's latest daily reward claim to calculate streak
        $latestReward = UserDailyReward::where('user_id', $user->id)
            ->orderBy('claimed_at', 'desc')
            ->first();

        $this->currentStreak = $latestReward && $latestReward->claimed_at->isYesterday()
            ? $latestReward->current_streak + 1
            : 1;

        // Only show reward modal if welcome modal is not showing
        if (!$this->showWelcomeModal) {
            $this->showRewardModal = true;
            Log::info('Showing reward modal', [
                'currentStreak' => $this->currentStreak
            ]);
        }
    }

    public function closeWelcomeModal()
    {
        Log::info('Closing welcome modal');
        $this->showWelcomeModal = false;
    }

    public function checkAndShowReward()
    {
        if (!Auth::check()) {
            Log::info('User not authenticated in checkAndShowReward');
            return;
        }

        $user = Auth::user();
        Log::info('Checking rewards for user', ['user_id' => $user->id]);

        // Check if user has already claimed a reward today
        $hasClaimedToday = UserDailyReward::where('user_id', $user->id)
            ->whereDate('claimed_at', Carbon::today())
            ->exists();

        if ($hasClaimedToday) {
            // User has already claimed a reward today, don't show the reward modal
            Log::info('User has already claimed a reward today, not showing reward modal');
            $this->showRewardModal = false;
            return;
        }

        // Get the user's latest daily reward claim to calculate streak
        $latestReward = UserDailyReward::where('user_id', $user->id)
            ->orderBy('claimed_at', 'desc')
            ->first();

        if ($latestReward) {
            Log::info('Latest reward found', [
                'claimed_at' => $latestReward->claimed_at,
                'is_today' => $latestReward->claimed_at->isToday(),
                'is_yesterday' => $latestReward->claimed_at->isYesterday(),
                'current_streak' => $latestReward->current_streak
            ]);
        } else {
            Log::info('No previous rewards found for user');
        }

        // Calculate streak
        $this->currentStreak = $latestReward && $latestReward->claimed_at->isYesterday()
            ? $latestReward->current_streak + 1
            : 1;

        Log::info('Showing reward modal', ['current_streak' => $this->currentStreak]);

        // Show the reward modal
        $this->showRewardModal = true;
    }

    public function closeRewardModal()
    {
        $this->showRewardModal = false;
    }

    public function skipAllModals()
    {
        Log::info('Skipping all modals');
        $this->showWelcomeModal = false;
        $this->showRewardModal = false;
    }

    public function showRewardModal()
    {
        Log::info('Showing reward modal from direct method call');

        // Close welcome modal first
        $this->showWelcomeModal = false;

        // Set a default streak
        $this->currentStreak = 1;

        // Show the reward modal
        $this->showRewardModal = true;
    }

    public function showRewardAfterWelcome()
    {
        Log::info('Showing reward modal after welcome modal');

        // First close the welcome modal
        $this->showWelcomeModal = false;

        // Check if user should see the reward modal
        if (!Auth::check()) {
            Log::info('User not authenticated, not showing reward modal');
            return;
        }

        $user = Auth::user();

        // Check if user has already claimed a reward today
        $hasClaimedToday = UserDailyReward::where('user_id', $user->id)
            ->whereDate('claimed_at', Carbon::today())
            ->exists();

        if ($hasClaimedToday) {
            Log::info('User has already claimed a reward today, not showing reward modal');
            return;
        }

        // Get the user's latest daily reward claim to calculate streak
        $latestReward = UserDailyReward::where('user_id', $user->id)
            ->orderBy('claimed_at', 'desc')
            ->first();

        $this->currentStreak = $latestReward && $latestReward->claimed_at->isYesterday()
            ? $latestReward->current_streak + 1
            : 1;

        Log::info('Showing reward modal with streak', [
            'currentStreak' => $this->currentStreak
        ]);

        // Then show the reward modal
        $this->showRewardModal = true;
    }

    public function claimDailyReward()
    {
        if (!Auth::check()) {
            Log::info('User not authenticated in claimDailyReward');
            return;
        }

        $user = Auth::user();
        $today = Carbon::today();

        // Check if user has already claimed a reward today
        $hasClaimedToday = UserDailyReward::where('user_id', $user->id)
            ->whereDate('claimed_at', Carbon::today())
            ->exists();

        if ($hasClaimedToday) {
            // User has already claimed a reward today
            Log::info('User has already claimed a reward today, preventing duplicate claim');
            $this->closeRewardModal();
            session()->flash('status', "You've already claimed your daily reward today!");
            return;
        }

        Log::info('Claiming daily reward', [
            'user_id' => $user->id,
            'current_streak' => $this->currentStreak,
            'points' => $this->rewardPoints
        ]);

        try {
            // Record the claimed reward
            $reward = UserDailyReward::create([
                'user_id' => $user->id,
                'daily_reward_tier_id' => 1, // Default tier
                'claimed_at' => now(),
                'streak_date' => $today,
                'current_streak' => $this->currentStreak,
            ]);

            Log::info('Reward record created', ['reward_id' => $reward->id]);

            // Award the points
            try {
                Log::info('Attempting to award points');

                // Try using the LevelUp package method
                if (method_exists($user, 'addPoints')) {
                    Log::info('Using addPoints method');
                    // @phpstan-ignore-next-line
                    $user->addPoints(
                        amount: $this->rewardPoints,
                        reason: "Daily login reward - Day {$this->currentStreak}"
                    );
                }
                // Try using the increment method
                else if (method_exists($user, 'increment') && Schema::hasColumn('users', 'points')) {
                    Log::info('Using increment method');
                    // @phpstan-ignore-next-line
                    $user->increment('points', $this->rewardPoints);
                }
                // Last resort - update directly
                else {
                    Log::info('Using direct update method');
                    $currentPoints = $user->points ?? 0;
                    // @phpstan-ignore-next-line
                    $user->update(['points' => $currentPoints + $this->rewardPoints]);
                }
            } catch (\Exception $e) {
                Log::error('Error awarding points', [
                    'error' => $e->getMessage()
                ]);
            }

            // Close the modal
            $this->closeRewardModal();

            // Show success message
            session()->flash('status', "You received {$this->rewardPoints} points for your Day {$this->currentStreak} login streak!");

            Log::info('Daily reward claimed successfully');
        } catch (\Exception $e) {
            Log::error('Error claiming daily reward', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            session()->flash('status', "There was an error claiming your reward. Please try again.");
        }
    }

    public function render()
    {
        return view('livewire.welcome-modals');
    }
}
