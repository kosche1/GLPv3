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
                    $this->lockoutSeconds = RateLimiter::availableIn($throttleKey);

                    // Store the lockout end time in the session
                    session()->put('login_lockout_end_time', time() + $this->lockoutSeconds);

                    // Dispatch the lockout event with the seconds remaining
                    $this->dispatch('lockout-started', seconds: $this->lockoutSeconds);
                }

                throw ValidationException::withMessages([
                    'email' => __('auth.failed'),
                ]);
            }

            RateLimiter::clear($throttleKey);
            Session::regenerate();

            // Set a session flag to indicate a fresh login
            session()->put('justLoggedIn', true);

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

        $seconds = RateLimiter::availableIn($throttleKey);
        $this->lockoutSeconds = $seconds;
        $this->isLocked = true;

        // Store the lockout end time in the session
        session()->put('login_lockout_end_time', time() + $seconds);

        // Dispatch an event for the JavaScript to handle the countdown
        // This will trigger the client-side countdown timer
        $this->dispatch('lockout-started', seconds: $seconds);

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

        <!-- Lockout Timer - This will be dynamically managed by JavaScript -->
        @if($isLocked)
        <div class="p-3 bg-red-900/30 border border-red-500/30 rounded-lg text-center lockout-message-container">
            <div class="text-red-300 mb-1">Too many failed attempts</div>
            <div class="text-red-300">
                Please wait <span id="lockout-timer" class="font-bold" data-seconds="{{ $lockoutSeconds }}"
                    data-end-time="{{ session('login_lockout_end_time', time() + $lockoutSeconds) }}">{{ $lockoutSeconds }}</span> seconds before trying again
            </div>
        </div>
        @endif

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
        // Handle login attempts and lockout timer
        document.addEventListener('DOMContentLoaded', function() {
            localStorage.removeItem('sessionLocked');
            console.log('Session lock state cleared on login page');

            // Set up login form to mark a fresh login
            const loginForm = document.querySelector('form[wire\\:submit="login"]');
            if (loginForm) {
                loginForm.addEventListener('submit', function() {
                    // This is a backup in case the server-side session flag doesn't work
                    sessionStorage.setItem('justLoggedIn', 'true');
                    console.log('Login form submitted, marked as fresh login');
                });
            }

            // Global variable to store the countdown interval
            let countdownInterval;

            // Function to create and show the lockout message with timer
            function showLockoutMessage(seconds) {
                // Check if the lockout message already exists
                let lockoutContainer = document.querySelector('.lockout-message-container');

                if (!lockoutContainer) {
                    // Create the lockout message container if it doesn't exist
                    lockoutContainer = document.createElement('div');
                    lockoutContainer.className = 'p-3 bg-red-900/30 border border-red-500/30 rounded-lg text-center lockout-message-container';

                    // Create the message elements
                    const titleDiv = document.createElement('div');
                    titleDiv.className = 'text-red-300 mb-1';
                    titleDiv.textContent = 'Too many failed attempts';

                    const messageDiv = document.createElement('div');
                    messageDiv.className = 'text-red-300';
                    messageDiv.innerHTML = 'Please wait <span id="lockout-timer" class="font-bold"></span> seconds before trying again';

                    // Append the elements to the container
                    lockoutContainer.appendChild(titleDiv);
                    lockoutContainer.appendChild(messageDiv);

                    // Find the submit button container to insert before
                    const submitButtonContainer = document.querySelector('form[wire\\:submit="login"] > div.flex.items-center');
                    if (submitButtonContainer) {
                        submitButtonContainer.parentNode.insertBefore(lockoutContainer, submitButtonContainer);
                    } else {
                        // Fallback: append to the form
                        const form = document.querySelector('form[wire\\:submit="login"]');
                        if (form) {
                            form.appendChild(lockoutContainer);
                        }
                    }
                }

                // Get or create the timer element
                let timerElement = document.getElementById('lockout-timer');
                if (!timerElement) {
                    timerElement = lockoutContainer.querySelector('.text-red-300:last-child').appendChild(document.createElement('span'));
                    timerElement.id = 'lockout-timer';
                    timerElement.className = 'font-bold';
                }

                // Set the initial seconds
                timerElement.textContent = seconds;
                timerElement.setAttribute('data-seconds', seconds);

                // Calculate and store the end time
                const endTime = Date.now() + (seconds * 1000);
                timerElement.setAttribute('data-end-time', Math.floor(endTime / 1000));
                localStorage.setItem('login_lockout_end_time', endTime.toString());

                // Disable the login button
                const loginButton = document.querySelector('form[wire\\:submit="login"] button[type="submit"]');
                if (loginButton) {
                    loginButton.setAttribute('disabled', 'disabled');
                }

                // Start the countdown
                startCountdown();
            }

            // Function to start the countdown timer
            function startCountdown() {
                const timerElement = document.getElementById('lockout-timer');
                if (!timerElement) return;

                // Clear any existing interval
                if (countdownInterval) {
                    clearInterval(countdownInterval);
                }

                // Get the end time from the data attribute or from localStorage
                let endTime;
                if (timerElement.hasAttribute('data-end-time')) {
                    endTime = parseInt(timerElement.getAttribute('data-end-time')) * 1000; // Convert to milliseconds
                } else {
                    const storedEndTime = localStorage.getItem('login_lockout_end_time');
                    if (storedEndTime) {
                        endTime = parseInt(storedEndTime);
                    } else {
                        // Fallback to using the seconds attribute
                        const seconds = parseInt(timerElement.getAttribute('data-seconds') || timerElement.textContent);
                        endTime = Date.now() + (seconds * 1000);
                    }
                }

                // Store the end time in localStorage
                localStorage.setItem('login_lockout_end_time', endTime.toString());

                // Update the timer immediately
                updateTimer(timerElement, endTime);

                // Update the timer every second
                countdownInterval = setInterval(() => {
                    if (!updateTimer(timerElement, endTime)) {
                        // If timer is complete, clear the interval
                        clearInterval(countdownInterval);

                        // Reset the lockout state
                        resetLockout();
                    }
                }, 1000);
            }

            // Function to update the timer display
            function updateTimer(timerElement, endTime) {
                // Calculate remaining time
                const now = Date.now();
                const timeLeft = Math.max(0, Math.ceil((endTime - now) / 1000));

                // Update the display
                timerElement.textContent = timeLeft;

                // If countdown is complete
                if (timeLeft <= 0) {
                    return false;
                }
                return true;
            }

            // Function to reset the lockout state
            function resetLockout() {
                localStorage.removeItem('login_lockout_end_time');

                // Remove the lockout message if it exists
                const lockoutContainer = document.querySelector('.lockout-message-container');
                if (lockoutContainer) {
                    lockoutContainer.remove();
                }

                // Enable the login button
                const loginButton = document.querySelector('form[wire\\:submit="login"] button[type="submit"]');
                if (loginButton) {
                    loginButton.removeAttribute('disabled');
                }

                // Reset the lockout state via Livewire if available
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
            }

            // Start the countdown timer if the lockout element exists
            const timerElement = document.getElementById('lockout-timer');
            if (timerElement) {
                startCountdown();
            }

            // Listen for lockout events from Livewire
            document.addEventListener('livewire:initialized', () => {
                Livewire.on('lockout-started', (event) => {
                    console.log('Lockout started, seconds:', event.seconds);
                    showLockoutMessage(event.seconds);
                });
            });
        });
    </script>

    <div class="text-center text-xs text-zinc-500 mt-4">
        <flux:link href="{{ route('terms') }}" class="text-zinc-400 hover:text-emerald-300 transition-colors duration-300">Terms & Conditions</flux:link>
    </div>
</div>
