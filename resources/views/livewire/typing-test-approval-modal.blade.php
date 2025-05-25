<div
    wire:poll.1s="checkForApprovedTypingTests"
    x-data="{
        showApprovalModal: @entangle('showApprovalModal')
    }"
    x-init="
        // Check for approved typing tests on page load and set up interval
        @this.checkForApprovedTypingTests();

        // Set up an interval to check more frequently
        const checkInterval = setInterval(() => {
            @this.checkForApprovedTypingTests();
        }, 1000);

        // Clean up interval when component is destroyed
        return () => clearInterval(checkInterval);
    "
>
    <!-- Typing Test Approval Modal -->
    <div x-show="showApprovalModal"
         x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">

        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black bg-opacity-10 backdrop-blur-md"></div>

        <!-- Modal Content -->
        <div class="relative bg-neutral-800 rounded-xl shadow-lg p-8 max-w-md w-full mx-4 border border-emerald-500/30 transform transition-all max-h-[90vh] overflow-y-auto"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95">

            <!-- Close Button -->
            <div class="absolute top-4 right-4">
                <button wire:click="closeModal" class="text-neutral-400 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Content -->
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-emerald-500/20 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Typing Test Approved!</h3>
                <p class="text-neutral-300 mb-4">Your typing test result for "{{ $challengeTitle }}" has been reviewed and approved by your teacher.</p>

                <!-- Performance Stats -->
                <div class="bg-neutral-700/50 rounded-lg p-4 mb-4 border border-neutral-600">
                    <h4 class="text-sm font-medium text-emerald-400 mb-3">Your Performance</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-white">{{ $wpm }}</div>
                            <div class="text-xs text-neutral-400">WPM</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-white">{{ number_format($accuracy, 1) }}%</div>
                            <div class="text-xs text-neutral-400">Accuracy</div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-center mb-6">
                    <div class="bg-emerald-500/20 rounded-full px-4 py-2 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-emerald-400 font-medium">+{{ $pointsAwarded }} points awarded!</span>
                    </div>
                </div>

                <button wire:click="closeModal" class="w-full py-3 px-4 bg-emerald-600 hover:bg-emerald-500 text-white font-medium rounded-lg transition-colors duration-300">
                    Continue Learning
                </button>

                <!-- Debug button - remove in production -->
                @if(config('app.debug'))
                <div class="mt-4 text-center">
                    <button wire:click="checkForApprovedTypingTests" class="text-xs text-neutral-400 hover:text-neutral-300">
                        Check for approved typing tests
                    </button>
                </div>
                @endif
            </div>
        </div>
        </div>
    </div>
</div>
