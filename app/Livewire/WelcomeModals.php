<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\UserDailyReward;
use App\Models\DailyRewardTier;
use App\Services\NotificationService;
use Carbon\Carbon;

class WelcomeModals extends Component
{
    public $showWelcomeModal = false;
    public $showRewardModal = false;
    public $rewardPoints = 10; // Default value, will be updated based on streak
    public $currentStreak = 0;

    // Listen for property updates
    protected $listeners = ['refreshRewardPoints' => 'updateRewardPointsForStreak'];

    // Define properties that can be updated from the frontend
    protected $rules = [
        'currentStreak' => 'required|integer|min:1',
        'rewardPoints' => 'required|integer|min:1',
    ];

    protected NotificationService $notificationService;

    public function boot(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function mount()
    {
        // Check if this is a fresh login
        if (session()->has('justLoggedIn')) {
            $this->showWelcomeModal = true;
            session()->forget('justLoggedIn');

            // Create a notification for the daily reward on login
            $this->createDailyRewardNotification();
        }

        // Calculate the current streak for the user
        if (Auth::check()) {
            $user = Auth::user();

            // Get the user's latest daily reward claim to calculate streak
            $latestReward = UserDailyReward::where('user_id', $user->id)
                ->orderBy('claimed_at', 'desc')
                ->first();

            // Calculate streak - use the latest streak value directly
            $this->currentStreak = $latestReward ? $latestReward->current_streak : 1;

            // If this is a new day (not today), increment the streak
            if ($latestReward && !$latestReward->claimed_at->isToday()) {
                $this->currentStreak = $latestReward->current_streak + 1;
            }

            // Get the reward tier for the current streak
            $this->updateRewardPointsForStreak();

            Log::info('Calculated streak on mount', [
                'currentStreak' => $this->currentStreak,
                'rewardPoints' => $this->rewardPoints
            ]);
        }
    }

    /**
     * Update the reward points based on the current streak
     */
    public function updateRewardPointsForStreak()
    {
        // Calculate the current streak for the user if not already set
        if (Auth::check() && $this->currentStreak === 0) {
            $user = Auth::user();

            // Get the user's latest daily reward claim to calculate streak
            $latestReward = UserDailyReward::where('user_id', $user->id)
                ->orderBy('claimed_at', 'desc')
                ->first();

            // Calculate streak - use the latest streak value directly
            $this->currentStreak = $latestReward ? $latestReward->current_streak : 1;

            // If this is a new day (not today), increment the streak
            if ($latestReward && !$latestReward->claimed_at->isToday()) {
                $this->currentStreak = $latestReward->current_streak + 1;
            }
        }

        // Find the appropriate reward tier for the current streak day
        $rewardTier = DailyRewardTier::where('day_number', $this->currentStreak)->first();

        // If no specific tier exists for this day, use the default value
        if ($rewardTier) {
            $oldPoints = $this->rewardPoints;
            $this->rewardPoints = $rewardTier->points_reward;

            Log::info('Updated reward points from tier', [
                'day_number' => $rewardTier->day_number,
                'old_points' => $oldPoints,
                'new_points' => $this->rewardPoints
            ]);
        } else {
            // For days without specific tiers, calculate a default value
            $oldPoints = $this->rewardPoints;
            $this->rewardPoints = 10 + min(($this->currentStreak * 5), 100); // Scale up to max 100 points

            Log::info('Using calculated reward points', [
                'currentStreak' => $this->currentStreak,
                'old_points' => $oldPoints,
                'new_points' => $this->rewardPoints
            ]);
        }

        // Force a refresh of the component
        $this->dispatch('refreshComponent');
    }

    /**
     * Create a notification for the daily reward without claiming it
     */
    protected function createDailyRewardNotification()
    {
        if (!Auth::check()) {
            Log::info('User not authenticated in createDailyRewardNotification');
            return;
        }

        $user = Auth::user();

        // Check if user has already claimed a reward today
        $hasClaimedToday = UserDailyReward::where('user_id', $user->id)
            ->whereDate('claimed_at', Carbon::today())
            ->exists();

        if ($hasClaimedToday) {
            // User has already claimed a reward today
            Log::info('User has already claimed a reward today, not creating notification');
            return;
        }

        // Check if a notification for today's reward already exists
        $notificationExists = \App\Models\Notification::where('user_id', $user->id)
            ->where('type', 'reward')
            ->whereDate('created_at', Carbon::today())
            ->exists();

        if ($notificationExists) {
            // Notification already exists
            Log::info('Daily reward notification already exists for today');
            return;
        }

        // Make sure reward points are updated based on streak
        $this->updateRewardPointsForStreak();

        // Create a notification for the daily reward
        try {
            $notification = $this->notificationService->dailyRewardNotification(
                $user,
                $this->rewardPoints,
                $this->currentStreak,
                route('dashboard')
            );

            Log::info('Daily reward notification created automatically on login', [
                'notification_id' => $notification->id,
                'user_id' => $user->id,
                'message' => $notification->message,
                'type' => $notification->type,
                'points' => $this->rewardPoints,
                'streak' => $this->currentStreak
            ]);
        } catch (\Exception $e) {
            Log::error('Error creating automatic daily reward notification', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
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

        // Calculate streak - use the latest streak value directly
        $this->currentStreak = $latestReward ? $latestReward->current_streak : 1;

        // If this is a new day (not today), increment the streak
        if ($latestReward && !$latestReward->claimed_at->isToday()) {
            $this->currentStreak = $latestReward->current_streak + 1;
        }

        // Update reward points based on streak
        $this->updateRewardPointsForStreak();

        // Only show reward modal if welcome modal is not showing
        if (!$this->showWelcomeModal) {
            $this->showRewardModal = true;
            Log::info('Showing reward modal', [
                'currentStreak' => $this->currentStreak,
                'rewardPoints' => $this->rewardPoints
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

        // Calculate streak - use the latest streak value directly
        $this->currentStreak = $latestReward ? $latestReward->current_streak : 1;

        // If this is a new day (not today), increment the streak
        if ($latestReward && !$latestReward->claimed_at->isToday()) {
            $this->currentStreak = $latestReward->current_streak + 1;
        }

        // Update reward points based on streak
        $this->updateRewardPointsForStreak();

        Log::info('Showing reward modal', [
            'current_streak' => $this->currentStreak,
            'reward_points' => $this->rewardPoints
        ]);

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

        // Calculate the current streak for the user
        if (Auth::check()) {
            $user = Auth::user();

            // Get the user's latest daily reward claim to calculate streak
            $latestReward = UserDailyReward::where('user_id', $user->id)
                ->orderBy('claimed_at', 'desc')
                ->first();

            // Calculate streak - use the latest streak value directly
            $this->currentStreak = $latestReward ? $latestReward->current_streak : 1;

            // If this is a new day (not today), increment the streak
            if ($latestReward && !$latestReward->claimed_at->isToday()) {
                $this->currentStreak = $latestReward->current_streak + 1;
            }

            // Update reward points based on streak
            $this->forceUpdateRewardPoints();

            Log::info('Updated reward points for modal', [
                'currentStreak' => $this->currentStreak,
                'rewardPoints' => $this->rewardPoints
            ]);
        } else {
            // Set a default streak if not authenticated
            $this->currentStreak = 1;
            $this->rewardPoints = 10;
        }

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

        // Calculate streak - use the latest streak value directly
        $this->currentStreak = $latestReward ? $latestReward->current_streak : 1;

        // If this is a new day (not today), increment the streak
        if ($latestReward && !$latestReward->claimed_at->isToday()) {
            $this->currentStreak = $latestReward->current_streak + 1;
        }

        // Update reward points based on streak
        $this->forceUpdateRewardPoints();

        Log::info('Showing reward modal with streak', [
            'currentStreak' => $this->currentStreak,
            'rewardPoints' => $this->rewardPoints
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

        // Calculate the current streak and reward points
        // Get the user's latest daily reward claim to calculate streak
        $latestReward = UserDailyReward::where('user_id', $user->id)
            ->orderBy('claimed_at', 'desc')
            ->first();

        // Calculate streak - use the latest streak value directly
        $this->currentStreak = $latestReward ? $latestReward->current_streak : 1;

        // If this is a new day (not today), increment the streak
        if ($latestReward && !$latestReward->claimed_at->isToday()) {
            $this->currentStreak = $latestReward->current_streak + 1;
        }

        // Get the reward tier for the current streak
        $rewardTier = DailyRewardTier::where('day_number', $this->currentStreak)->first();

        if ($rewardTier) {
            $this->rewardPoints = $rewardTier->points_reward;
        } else {
            // Default to 10 points if no tier is found
            $this->rewardPoints = 10;
        }

        Log::info('Current values before claiming', [
            'currentStreak' => $this->currentStreak,
            'rewardPoints' => $this->rewardPoints
        ]);

        Log::info('Claiming daily reward', [
            'user_id' => $user->id,
            'current_streak' => $this->currentStreak,
            'points' => $this->rewardPoints
        ]);

        try {
            // Find the appropriate reward tier for the current streak day
            $rewardTier = DailyRewardTier::where('day_number', $this->currentStreak)->first();
            $rewardTierId = $rewardTier ? $rewardTier->id : 1; // Use default tier if none found

            // Record the claimed reward
            $reward = UserDailyReward::create([
                'user_id' => $user->id,
                'daily_reward_tier_id' => $rewardTierId,
                'claimed_at' => now(),
                'streak_date' => $today,
                'current_streak' => $this->currentStreak,
            ]);

            Log::info('Reward record created', [
                'reward_id' => $reward->id,
                'tier_id' => $rewardTierId,
                'points' => $this->rewardPoints
            ]);

            // Award the points
            try {
                Log::info('Attempting to award points');

                // Award points using the LevelUp package
                Log::info('Using addPoints method from LevelUp package');

                // @phpstan-ignore-next-line
                // The User model uses the GiveExperience trait which provides the addPoints method
                $user->addPoints(
                    amount: $this->rewardPoints,
                    reason: "Daily login reward - Day {$this->currentStreak}"
                );
            } catch (\Exception $e) {
                Log::error('Error awarding points', [
                    'error' => $e->getMessage()
                ]);
            }

            // Close the modal
            $this->closeRewardModal();

            // Show success message
            session()->flash('status', "You received {$this->rewardPoints} points for your Day {$this->currentStreak} login streak!");

            // Create a notification for the daily reward
            try {
                $notification = $this->notificationService->dailyRewardNotification(
                    $user,
                    $this->rewardPoints,
                    $this->currentStreak,
                    route('dashboard')
                );

                Log::info('Daily reward notification created successfully', [
                    'notification_id' => $notification->id,
                    'user_id' => $user->id,
                    'message' => $notification->message,
                    'type' => $notification->type
                ]);
            } catch (\Exception $e) {
                Log::error('Error creating daily reward notification', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }

            Log::info('Daily reward claimed successfully and notification created');
        } catch (\Exception $e) {
            Log::error('Error claiming daily reward', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            session()->flash('status', "There was an error claiming your reward. Please try again.");
        }
    }

    /**
     * Hook that runs when a property is updated
     */
    public function updated($name, $value)
    {
        // When the reward modal is shown, update the reward points
        if ($name === 'showRewardModal' && $value === true) {
            Log::info('Reward modal shown, updating reward points');
            $this->forceUpdateRewardPoints();
        }
    }

    /**
     * Force update the reward points - can be called from the frontend
     */
    public function forceUpdateRewardPoints()
    {
        Log::info('Force updating reward points');

        // Calculate the current streak
        if (Auth::check()) {
            $user = Auth::user();

            // Get the user's latest daily reward claim to calculate streak
            $latestReward = UserDailyReward::where('user_id', $user->id)
                ->orderBy('claimed_at', 'desc')
                ->first();

            // Calculate streak - use the latest streak value directly
            $this->currentStreak = $latestReward ? $latestReward->current_streak : 1;

            // If this is a new day (not today), increment the streak
            if ($latestReward && !$latestReward->claimed_at->isToday()) {
                $this->currentStreak = $latestReward->current_streak + 1;
            }

            // Get the reward tier for the current streak
            $rewardTier = DailyRewardTier::where('day_number', $this->currentStreak)->first();

            if ($rewardTier) {
                $this->rewardPoints = $rewardTier->points_reward;

                Log::info('Force updated reward points from tier', [
                    'day_number' => $rewardTier->day_number,
                    'points_reward' => $rewardTier->points_reward
                ]);
            }
        }
    }

    public function render()
    {
        return view('livewire.welcome-modals');
    }
}
