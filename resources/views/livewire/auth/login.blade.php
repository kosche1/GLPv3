<?php

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;
use App\Models\UserDailyReward;
use App\Models\DailyRewardTier;
use App\Models\Badge;
use App\Services\AchievementService;
use App\Services\NotificationService;
use Carbon\Carbon;

new #[Layout('components.layouts.auth.card')] class extends Component {
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    public ?string $rewardMessage = null;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->ensureIsNotRateLimited();

        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        // Process daily login reward
        $this->processDailyLoginReward();

        // Check for achievements
        $this->checkForAchievements();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }

    /**
     * Process the daily login reward for the user
     */
    protected function processDailyLoginReward(): void
    {
        $user = Auth::user();
        $today = Carbon::today();

        // Get the user's latest daily reward claim
        $latestReward = UserDailyReward::where('user_id', $user->id)
            ->orderBy('claimed_at', 'desc')
            ->first();

        $currentStreak = 1; // Default to 1 for first login

        if ($latestReward) {
            // Check if the user already claimed a reward today
            if ($latestReward->claimed_at->isToday()) {
                return; // Already claimed today
            }

            // Check if this is a consecutive day (yesterday)
            if ($latestReward->claimed_at->isYesterday()) {
                $currentStreak = $latestReward->current_streak + 1;
            } else {
                // Streak broken - start over
                $currentStreak = 1;
            }
        }

        // Find the appropriate reward tier for the current streak day
        $rewardTier = DailyRewardTier::where('day_number', $currentStreak)->first();

        // If no specific tier exists for this day, get the default tier for regular days
        if (!$rewardTier) {
            // For days 8-13, 15-20, 22-29, 31+ use a default reward based on the streak count
            $defaultPoints = 10 + min(($currentStreak * 5), 100); // Scale up to max 100 points

            // Create a temporary tier object
            $rewardTier = new DailyRewardTier([
                'name' => "Day {$currentStreak} Reward",
                'day_number' => $currentStreak,
                'points_reward' => $defaultPoints,
                'reward_type' => 'points',
                'reward_data' => null,
            ]);
        }

        // Record the claimed reward
        UserDailyReward::create([
            'user_id' => $user->id,
            'daily_reward_tier_id' => $rewardTier->id ?? 0, // Use 0 for custom generated tiers
            'claimed_at' => now(),
            'streak_date' => $today,
            'current_streak' => $currentStreak,
        ]);

        // Award the points
        $user->addPoints(
            $rewardTier->points_reward,
            reason: "Daily login reward - Day {$currentStreak}"
        );

        $rewardMessage = "You received {$rewardTier->points_reward} points for your Day {$currentStreak} login streak!";

        // Process additional rewards if any
        if ($rewardTier->reward_type && $rewardTier->reward_data) {
            $additionalRewards = [];

            // Handle badge rewards
            if ($rewardTier->reward_type === 'badge' && isset($rewardTier->reward_data['badge_id'])) {
                $badge = Badge::find($rewardTier->reward_data['badge_id']);

                if ($badge) {
                    // Attach the badge to the user if they don't already have it
                    if (!$user->badges()->where('badge_id', $badge->id)->exists()) {
                        $user->badges()->attach($badge->id, [
                            'earned_at' => now(),
                        ]);
                        $additionalRewards[] = "Badge: {$badge->name}";
                    }
                }
            }

            // Handle streak freeze rewards
            if (isset($rewardTier->reward_data['streak_freeze']) && method_exists($user, 'freezeStreak')) {
                $freezeDays = $rewardTier->reward_data['streak_freeze'];

                // Use Level-Up package's streak functionality if available
                try {
                    $activities = \LevelUp\Experience\Models\Activity::all();
                    foreach ($activities as $activity) {
                        $user->freezeStreak($activity, $freezeDays);
                    }
                    $additionalRewards[] = "{$freezeDays} Streak Freeze Days";
                }
                catch (\Exception $e) {
                    // Streak freeze functionality not available
                }
            }

            // Add additional rewards to message
            if (!empty($additionalRewards)) {
                $rewardMessage .= " Plus: " . implode(', ', $additionalRewards);
            }
        }

        $this->rewardMessage = $rewardMessage;

        // Store reward message in session to display after redirect
        session()->flash('daily_reward_message', $rewardMessage);
    }

    /**
     * Check for any achievements the user may have earned
     */
    protected function checkForAchievements(): void
    {
        try {
            $user = Auth::user();
            $notificationService = app(NotificationService::class);
            $achievementService = new AchievementService($notificationService);

            // Check for all types of achievements
            $achievementService->checkAllAchievements($user);

            // Get newly awarded achievements to display in notification
            $recentAchievements = session('recent_achievements', []);
            if (!empty($recentAchievements)) {
                $achievementNames = implode(', ', $recentAchievements);
                session()->flash('achievement_message', "Congratulations! You've earned new achievements: $achievementNames");
            }
        } catch (\Exception $e) {
            // Log error but don't interrupt login flow
            \Illuminate\Support\Facades\Log::error("Error checking achievements: {$e->getMessage()}");
        }
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
    }
}; ?>

<div class="flex flex-col gap-6">
    <!-- Logo Animation -->
    <div class="text-center mb-4">
        <div class="flex justify-center">
            <div class="relative">
                <div class="absolute -inset-0.5 bg-linear-to-r from-emerald-500 to-blue-500 rounded-full blur-sm opacity-75 animate-pulse-slow"></div>
                <div class="relative w-16 h-16 bg-zinc-900 rounded-full flex items-center justify-center border-2 border-emerald-500/50">
                    <x-app-logo-icon class="h-10 w-10 text-emerald-400" />
                </div>
            </div>
        </div>
    </div>

    <x-auth-header title="Log in to your account" description="Enter your email and password below to log in" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <!-- Daily Reward Message -->
    @if($rewardMessage)
        <div class="p-3 bg-emerald-900/30 border border-emerald-500/30 rounded-lg text-center text-emerald-300">
            {{ $rewardMessage }}
        </div>
    @endif

    <form wire:submit="login" class="flex flex-col gap-6">
        <!-- Email Address -->
        <flux:input
            wire:model="email"
            label="{{ __('Email address') }}"
            type="email"
            name="email"
            required
            autofocus
            autocomplete="email"
            placeholder="email@example.com"
        />

        <!-- Password -->
        <div class="relative">
            <flux:input
                wire:model="password"
                label="{{ __('Password') }}"
                type="password"
                name="password"
                required
                autocomplete="current-password"
                placeholder="Password"
            />

            @if (Route::has('password.request'))
                <flux:link class="absolute right-0 top-0 text-sm" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </flux:link>
            @endif
        </div>

        <!-- Remember Me -->
        <flux:checkbox wire:model="remember" label="{{ __('Remember me') }}" />

        <div class="flex items-center justify-end">
        <flux:button variant="primary" type="submit" class="w-full bg-linear-to-r from-emerald-500 to-blue-500 hover:from-emerald-600 hover:to-blue-600 transition-all duration-300">
            {{ __('Log in') }}
        </flux:button>
        </div>
    </form>

    <div class="space-x-1 text-center text-sm text-zinc-400">
        Don't have an account?
        <flux:link href="{{ route('register') }}" class="text-emerald-400 hover:text-emerald-300 transition-colors duration-300">Sign up</flux:link>
    </div>

    <div class="text-center text-xs text-zinc-500 mt-4">
        <flux:link href="{{ route('terms') }}" class="text-zinc-400 hover:text-emerald-300 transition-colors duration-300">Terms & Conditions</flux:link>
    </div>
</div>
