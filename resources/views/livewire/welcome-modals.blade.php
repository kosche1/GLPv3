

<div
    wire:poll.visible.750ms
    x-data="{
        showWelcomeModal: @entangle('showWelcomeModal'),
        showRewardModal: @entangle('showRewardModal'),

        closeWelcomeAndShowReward() {
            this.showWelcomeModal = false;
            setTimeout(() => {
                this.showRewardModal = true;
                $wire.updateRewardPointsForStreak();
            }, 300);
        },

        skipAllModals() {
            this.showWelcomeModal = false;
            this.showRewardModal = false;
        }
    }"
>
    <!-- Welcome Modal -->
    <div x-show="showWelcomeModal"
         x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">

        <!-- Backdrop with improved blur effect -->
        <div class="absolute inset-0 bg-transparent backdrop-blur-md welcome-modal-backdrop"></div>

        <!-- Modal panel -->
        <div class="relative bg-neutral-800 rounded-xl shadow-lg p-8 max-w-md w-full mx-4 border border-emerald-500/30 transform transition-all"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform scale-95"
             x-transition:enter-end="opacity-100 transform scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform scale-100"
             x-transition:leave-end="opacity-0 transform scale-95">

            <!-- Close button -->
            <div class="absolute top-4 right-4">
                <button @click="showWelcomeModal = false" class="text-neutral-400 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Content -->
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-emerald-500/20 mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                    </svg>
                </div>

                <h3 class="text-xl font-semibold text-white mb-2">Welcome to GameLearnPro!</h3>
                <p class="text-neutral-300 mb-6">
                    We're excited to have you back! Get ready to continue your learning journey with interactive challenges and rewards.
                </p>

                <button @click="closeWelcomeAndShowReward()" class="w-full px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg transition-all duration-300 hover:shadow-lg hover:scale-105 hover:font-bold mb-3">
                    Let's Get Started
                </button>

                <button @click="skipAllModals()" class="w-full px-4 py-2 bg-transparent hover:bg-neutral-700 text-neutral-400 hover:text-white rounded-lg border border-neutral-600 transition-all duration-300 hover:shadow-lg hover:scale-105 hover:font-bold mb-2">
                    Skip
                </button>
            </div>
        </div>
    </div>

    <!-- Daily Reward Modal -->
    <div x-show="showRewardModal"
         x-cloak
         x-init="$watch('showRewardModal', value => {
            if(value) {
                $wire.forceUpdateRewardPoints();
                $wire.$refresh();
            }
         })"
         class="fixed inset-0 z-50 flex items-center justify-center"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">

        <!-- Backdrop with improved blur effect -->
        <div class="absolute inset-0 bg-transparent backdrop-blur-md welcome-modal-backdrop"></div>

        <!-- Modal panel -->
        <div class="relative bg-neutral-800 rounded-xl shadow-lg p-8 max-w-md w-full mx-4 border border-emerald-500/30 transform transition-all"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform scale-95"
             x-transition:enter-end="opacity-100 transform scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform scale-100"
             x-transition:leave-end="opacity-0 transform scale-95">

            <!-- Close button -->
            <div class="absolute top-4 right-4">
                <button wire:click="closeRewardModal" class="text-neutral-400 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Content -->
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-amber-500/20 mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>

                <h3 class="text-xl font-semibold text-white mb-2">Daily Reward!</h3>
                <div>
                    <p class="text-neutral-300 mb-2">
                        @php
                            use Illuminate\Support\Facades\Auth;
                            use App\Models\UserDailyReward;
                            use App\Models\DailyRewardTier;

                            // Get the reward tier directly in the template
                            $user = Auth::user();
                            $latestReward = UserDailyReward::where('user_id', $user->id)
                                ->orderBy('claimed_at', 'desc')
                                ->first();

                            // Calculate streak - use the latest streak value directly
                            $currentStreakDay = $latestReward ? $latestReward->current_streak : 1;

                            // If this is a new day (not today), increment the streak
                            if ($latestReward && !$latestReward->claimed_at->isToday()) {
                                $currentStreakDay = $latestReward->current_streak + 1;
                            }

                            // Get reward tier
                            $rewardTier = DailyRewardTier::where('day_number', $currentStreakDay)->first();

                            // Set points to show
                            $pointsToShow = $rewardTier ? $rewardTier->points_reward : 10;
                        @endphp
                        You've earned <span class="text-amber-400 font-bold">{{ $pointsToShow }} points</span> for logging in today!
                    </p>
                    <p class="text-neutral-300 mb-6">
                        Current login streak: <span class="text-emerald-400 font-bold">Day {{ $currentStreakDay }}</span>
                    </p>


                </div>

                <button
                    wire:click="claimDailyReward"
                    class="w-full px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-lg transition-all duration-300 hover:shadow-lg hover:scale-105 hover:font-bold">
                    Claim Reward ({{ $pointsToShow }} points)
                </button>
            </div>
        </div>
    </div>
</div>
