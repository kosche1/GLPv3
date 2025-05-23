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

    // Login attempt tracking
    public int $remainingAttempts = 5;
    public bool $isLocked = false;
    public int $lockoutSeconds = 0;

    /**
     * Initialize component state
     */
    public function mount(): void
    {
        // Check if there's a stored throttle key in the session
        if (session()->has('login_throttle_key')) {
            $throttleKey = session('login_throttle_key');

            // Check if the user is rate limited
            if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
                $this->isLocked = true;
                $this->remainingAttempts = 0;
                $this->lockoutSeconds = RateLimiter::availableIn($throttleKey);
            } else {
                // Get the number of attempts made
                $attempts = RateLimiter::attempts($throttleKey);
                $this->remainingAttempts = max(5 - $attempts, 0);
            }
        }
    }

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        // Store the throttle key in session to persist across page refreshes
        $throttleKey = $this->throttleKey();
        session()->put('login_throttle_key', $throttleKey);

        try {
            $this->ensureIsNotRateLimited();

            if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
                RateLimiter::hit($throttleKey);

                // Update remaining attempts
                $this->remainingAttempts = max(5 - RateLimiter::attempts($throttleKey), 0);

                // Check if we've hit the limit after this attempt
                if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
                    $this->isLocked = true;

                    // Set a fixed lockout time of 60 seconds
                    $this->lockoutSeconds = 60;

                    // Apply the rate limiter with our custom duration
                    RateLimiter::hit($throttleKey, $this->lockoutSeconds);

                    // Store the lockout end time in the session
                    $lockoutEndTime = time() + $this->lockoutSeconds;
                    session()->put('login_lockout_end_time', $lockoutEndTime);

                    // Dispatch the lockout event with the seconds remaining and end time
                    $this->dispatch('lockout-started', [
                        'seconds' => $this->lockoutSeconds,
                        'endTime' => $lockoutEndTime * 1000 // Convert to milliseconds for JavaScript
                    ]);

                    // Add a small delay to ensure the event is processed before the page reloads
                    usleep(100000); // 100ms delay
                }

                throw ValidationException::withMessages([
                    'email' => __('auth.failed'),
                ]);
            }

            RateLimiter::clear($throttleKey);
            Session::regenerate();

            // Set a session flag to indicate a fresh login
            session()->put('justLoggedIn', true);

            // We don't need to manually fire the Login event anymore
            // The Auth::attempt() call above already fires the Login event

            // Log successful login
            \Illuminate\Support\Facades\Log::info('User logged in successfully', [
                'user_id' => Auth::id(),
                'user_name' => Auth::user()->name
            ]);

            // Process daily login reward
            $this->processDailyLoginReward();

            // Check for achievements
            $this->checkForAchievements();

            // Check for redirect parameter
            $redirect = request()->query('redirect');
            if ($redirect) {
                $this->redirect($redirect);
            } else {
                $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
            }
        } catch (\Exception $e) {
            // If any error occurs during login process, ensure we update the attempts
            $this->remainingAttempts = max(5 - RateLimiter::attempts($throttleKey), 0);
            throw $e;
        }
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

        // Create a notification for the daily reward
        try {
            $notificationService = app(NotificationService::class);

            // Check if a notification for today's reward already exists
            $notificationExists = \App\Models\Notification::where('user_id', $user->id)
                ->where('type', 'reward')
                ->whereDate('created_at', Carbon::today())
                ->exists();

            if (!$notificationExists) {
                $notification = $notificationService->dailyRewardNotification(
                    $user,
                    $rewardTier->points_reward,
                    $currentStreak,
                    route('dashboard')
                );

                \Illuminate\Support\Facades\Log::info('Daily reward notification created on login', [
                    'notification_id' => $notification->id,
                    'user_id' => $user->id,
                    'message' => $notification->message,
                    'type' => $notification->type
                ]);
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error creating daily reward notification on login', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
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
        $throttleKey = $this->throttleKey();

        // Update remaining attempts
        $attempts = RateLimiter::attempts($throttleKey);
        $this->remainingAttempts = max(5 - $attempts, 0);

        if (! RateLimiter::tooManyAttempts($throttleKey, 5)) {
            return;
        }

        event(new Lockout(request()));

        // Set a fixed lockout time of 60 seconds
        $seconds = 60;
        $this->lockoutSeconds = $seconds;
        $this->isLocked = true;

        // Apply the rate limiter with our custom duration
        RateLimiter::hit($throttleKey, $seconds);

        // Store the lockout end time in the session
        $lockoutEndTime = time() + $seconds;
        session()->put('login_lockout_end_time', $lockoutEndTime);

        // Dispatch an event for Alpine.js to handle the countdown
        // This will trigger the client-side countdown timer with the exact end time
        $this->dispatch('lockout-started', [
            'seconds' => $seconds,
            'endTime' => $lockoutEndTime * 1000 // Convert to milliseconds for JavaScript
        ]);

        // Add a small delay to ensure the event is processed before the exception is thrown
        usleep(100000); // 100ms delay

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

    /**
     * Reset the lockout when the cooldown period is over
     */
    public function resetLockout(): void
    {
        $this->isLocked = false;
        $this->lockoutSeconds = 0;
        $this->remainingAttempts = 5;

        // Clear the throttle key from the session
        if (session()->has('login_throttle_key')) {
            $throttleKey = session('login_throttle_key');
            RateLimiter::clear($throttleKey);
            session()->forget('login_throttle_key');
        }
    }
}; ?>

<div>
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

        <!-- Login Attempts Counter -->
        @if($remainingAttempts < 5 && !$isLocked)
        <div class="text-sm text-amber-400 text-center">
            {{ $remainingAttempts }} {{ Str::plural('attempt', $remainingAttempts) }} remaining
        </div>
        @endif

        <!-- Lockout Timer - Using Alpine.js for reliable countdown -->
        <div
            x-data="lockoutTimer({{ $lockoutSeconds > 0 ? $lockoutSeconds : 0 }}, {{ session('login_lockout_end_time', time()) }})"
            x-show="isLocked"
            x-init="initTimer()"
            x-cloak
            class="p-3 bg-red-900/30 border border-red-500/30 rounded-lg text-center lockout-message-container"
        >
            <div class="text-red-300 mb-1">Too many failed attempts</div>
            <div class="text-red-300">
                Please wait <span x-text="remainingSeconds || 0" class="font-bold"></span> seconds before trying again
            </div>
        </div>

        <div class="flex items-center justify-end">
        <flux:button
            variant="primary"
            type="submit"
            class="w-full bg-linear-to-r from-emerald-500 to-blue-500 hover:from-emerald-600 hover:to-blue-600 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed"
            :disabled="$isLocked"
            wire:loading.attr="disabled"
        >
            <span wire:loading.remove>{{ __('Log in') }}</span>
            <span wire:loading class="inline-flex items-center">
                <svg class="animate-spin mr-2 h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>{{ __('Logging in...') }}</span>
            </span>
        </flux:button>
        </div>
    </form>

    <div class="space-x-1 text-center text-sm text-zinc-400">
        Don't have an account?
        <flux:link href="{{ route('register') }}" class="text-emerald-400 hover:text-emerald-300 transition-colors duration-300">Sign up</flux:link>
    </div>

    <script>
        // Alpine.js component for the lockout timer
        document.addEventListener('alpine:init', function() {
            Alpine.data('lockoutTimer', function(initialSeconds, endTimeUnix) {
                const LOCKOUT_STORAGE_KEY = 'glp_login_lockout';
                const LOCKOUT_END_TIME_KEY = 'glp_login_lockout_end_time';

                // Ensure we have valid numbers
                initialSeconds = isNaN(initialSeconds) ? 0 : initialSeconds;
                endTimeUnix = isNaN(endTimeUnix) ? Math.floor(Date.now() / 1000) : endTimeUnix;

                return {
                    remainingSeconds: initialSeconds || 0,
                    endTime: endTimeUnix * 1000, // Convert Unix timestamp to JS milliseconds
                    isLocked: initialSeconds > 0 && endTimeUnix > (Date.now() / 1000),
                    timerInterval: null,

                    initTimer() {
                        // First, check if we actually have a lockout from the server
                        const hasServerLockout = this.remainingSeconds > 0;

                        // Then check if there's a stored lockout that's more recent
                        this.checkStoredLockout();

                        // Only start the timer if we're actually locked out
                        if (this.isLocked && (hasServerLockout || this.remainingSeconds > 0)) {
                            // Store the lockout state
                            this.storeLockout();

                            // Start the countdown
                            this.startCountdown();

                            // Disable the login button
                            this.updateLoginButton(true);
                        } else {
                            // Make sure we're not locked if there's no valid lockout
                            this.isLocked = false;
                            this.clearLockout();
                        }
                    },

                    checkStoredLockout() {
                        const storedLockout = localStorage.getItem(LOCKOUT_STORAGE_KEY);
                        const storedEndTime = localStorage.getItem(LOCKOUT_END_TIME_KEY);

                        if (storedLockout && storedEndTime) {
                            const storedEndTimeMs = parseInt(storedEndTime);
                            const now = Date.now();

                            // If the stored end time is in the future and later than our current end time
                            if (storedEndTimeMs > now && storedEndTimeMs > this.endTime) {
                                this.endTime = storedEndTimeMs;
                                this.remainingSeconds = Math.ceil((storedEndTimeMs - now) / 1000);
                                this.isLocked = true;
                            } else if (storedEndTimeMs <= now) {
                                // If the stored lockout has expired, clear it
                                this.clearLockout();
                                this.isLocked = false;
                            }
                        } else if (this.remainingSeconds <= 0) {
                            // If there's no stored lockout and no server lockout, make sure we're not locked
                            this.isLocked = false;
                        }
                    },

                    storeLockout() {
                        localStorage.setItem(LOCKOUT_STORAGE_KEY, 'true');
                        localStorage.setItem(LOCKOUT_END_TIME_KEY, this.endTime.toString());
                    },

                    clearLockout() {
                        localStorage.removeItem(LOCKOUT_STORAGE_KEY);
                        localStorage.removeItem(LOCKOUT_END_TIME_KEY);
                    },

                    startCountdown() {
                        // Clear any existing interval
                        if (this.timerInterval) {
                            clearInterval(this.timerInterval);
                        }

                        // Update immediately
                        this.updateTimer();

                        // Then update every second
                        this.timerInterval = setInterval(() => {
                            const stillRunning = this.updateTimer();

                            if (!stillRunning) {
                                clearInterval(this.timerInterval);
                                this.resetLockout();
                            }
                        }, 1000);
                    },

                    updateTimer() {
                        const now = Date.now();
                        // Ensure endTime is a valid number
                        if (isNaN(this.endTime) || this.endTime <= 0) {
                            this.endTime = now;
                            this.remainingSeconds = 0;
                            return false;
                        }

                        const timeLeft = Math.max(0, Math.ceil((this.endTime - now) / 1000));
                        this.remainingSeconds = timeLeft;

                        // Return whether the timer is still running
                        return timeLeft > 0;
                    },

                    resetLockout() {
                        // Clear the lockout state
                        this.isLocked = false;
                        this.remainingSeconds = 0;
                        this.clearLockout();

                        // Enable the login button
                        this.updateLoginButton(false);

                        // Reset the lockout state via Livewire
                        if (typeof Livewire !== 'undefined') {
                            try {
                                const component = Livewire.find(document.querySelector('[wire\\:id]')?.getAttribute('wire:id'));
                                if (component && typeof component.resetLockout === 'function') {
                                    component.resetLockout();
                                }
                            } catch (e) {
                                console.error('Error resetting lockout via Livewire:', e);
                            }
                        }
                    },

                    updateLoginButton(disabled) {
                        const loginButton = document.querySelector('form[wire\\:submit="login"] button[type="submit"]');
                        if (loginButton) {
                            if (disabled) {
                                loginButton.setAttribute('disabled', 'disabled');
                            } else {
                                loginButton.removeAttribute('disabled');
                            }
                        }
                    }
                };
            });
        });

        // Handle login form submission
        document.addEventListener('DOMContentLoaded', function() {
            // Clear session lock state
            localStorage.removeItem('sessionLocked');

            // Check if we just registered successfully
            const successMessage = document.querySelector('.text-emerald-400');
            const hasSuccessMessage = successMessage && successMessage.textContent.includes('Account created successfully');
            if (hasSuccessMessage || window.location.search.includes('registered=1')) {
                // Clear any lockout data if we just registered
                localStorage.removeItem('glp_login_lockout');
                localStorage.removeItem('glp_login_lockout_end_time');
            }

            // Set up login form to mark a fresh login
            const loginForm = document.querySelector('form[wire\\:submit="login"]');
            if (loginForm) {
                loginForm.addEventListener('submit', function() {
                    // This is a backup in case the server-side session flag doesn't work
                    sessionStorage.setItem('justLoggedIn', 'true');
                });
            }

            // Listen for lockout events from Livewire
            document.addEventListener('livewire:initialized', () => {
                Livewire.on('lockout-started', (event) => {
                    console.log('Lockout started:', event);

                    // If Alpine.js is available, update the existing component
                    if (typeof Alpine !== 'undefined') {
                        Alpine.nextTick(() => {
                            // Try to find existing lockout timer component
                            const existingComponent = document.querySelector('[x-data="lockoutTimer"]');

                            if (existingComponent) {
                                // Update the existing component
                                const alpineComponent = Alpine.$data(existingComponent);

                                // Update the component with the new lockout data
                                if (event.endTime) {
                                    alpineComponent.endTime = event.endTime;
                                    alpineComponent.remainingSeconds = Math.ceil((event.endTime - Date.now()) / 1000);
                                } else if (event.seconds) {
                                    alpineComponent.endTime = Date.now() + (event.seconds * 1000);
                                    alpineComponent.remainingSeconds = event.seconds;
                                }

                                alpineComponent.isLocked = true;
                                alpineComponent.initTimer();

                                // Make sure the component is visible
                                existingComponent.style.display = 'block';
                            } else {
                                // If no component exists, we need to create one dynamically
                                const lockoutContainer = document.createElement('div');
                                lockoutContainer.className = 'p-3 bg-red-900/30 border border-red-500/30 rounded-lg text-center lockout-message-container mb-4';
                                lockoutContainer.innerHTML = `
                                    <div class="text-red-300 mb-1">Too many failed attempts</div>
                                    <div class="text-red-300">
                                        Please wait <span id="dynamic-lockout-timer" class="font-bold"></span> seconds before trying again
                                    </div>
                                `;

                                // Find where to insert the lockout message
                                const loginButton = document.querySelector('form[wire\\:submit="login"] button[type="submit"]');
                                if (loginButton) {
                                    const buttonContainer = loginButton.closest('.flex.items-center.justify-end');
                                    if (buttonContainer) {
                                        buttonContainer.parentNode.insertBefore(lockoutContainer, buttonContainer);
                                    }
                                }

                                                // Calculate the end time and remaining seconds
                                // Ensure we have valid values
                                const seconds = !isNaN(event.seconds) ? event.seconds : 60; // Default to 60 seconds if invalid
                                const endTimeValue = !isNaN(event.endTime) ? event.endTime : (Date.now() + (seconds * 1000));

                                const endTime = event.endTime || (Date.now() + (seconds * 1000));
                                const remainingSeconds = event.endTime
                                    ? Math.max(0, Math.ceil((endTimeValue - Date.now()) / 1000))
                                    : seconds;

                                // Update the timer display
                                const timerElement = document.getElementById('dynamic-lockout-timer');
                                if (timerElement) {
                                    timerElement.textContent = remainingSeconds;

                                    // Start a countdown
                                    const countdownInterval = setInterval(() => {
                                        const now = Date.now();
                                        const timeLeft = Math.max(0, Math.ceil((endTime - now) / 1000));

                                        timerElement.textContent = timeLeft;

                                        if (timeLeft <= 0) {
                                            clearInterval(countdownInterval);
                                            lockoutContainer.style.display = 'none';

                                            // Enable the login button
                                            if (loginButton) {
                                                loginButton.removeAttribute('disabled');
                                            }
                                        }
                                    }, 1000);
                                }

                                // Store the lockout data for page refreshes
                                localStorage.setItem('glp_login_lockout', 'true');
                                localStorage.setItem('glp_login_lockout_end_time', endTime.toString());

                                // Disable the login button
                                if (loginButton) {
                                    loginButton.setAttribute('disabled', 'disabled');
                                }
                            }
                        });
                    }
                });
            });
        });
    </script>

    <div class="text-center text-xs text-zinc-500 mt-4">
        <flux:link href="{{ route('terms') }}" class="text-zinc-400 hover:text-emerald-300 transition-colors duration-300">Terms & Conditions</flux:link>
    </div>
</div>
</div>
