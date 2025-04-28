<div>
    <!-- Warning Modal -->
    <div x-data="{
        inactivityTime: {{ $inactivityTimeout }},
        warningTime: {{ $warningTimeout }},
        timer: null,
        warningTimer: null,
        lastActivity: Date.now(),
        isLocked: false,

        init() {
            // Check if this is a fresh login
            const isNewLogin = sessionStorage.getItem('justLoggedIn');
            if (isNewLogin === 'true') {
                // Clear the lock state for fresh logins
                localStorage.removeItem('sessionLocked');
                sessionStorage.removeItem('justLoggedIn');
                console.log('Fresh login detected, cleared session lock state');
                this.isLocked = false;
            } else {
                // Check if session was locked before refresh
                const storedLockState = localStorage.getItem('sessionLocked');
                if (storedLockState === 'true') {
                    // If it was locked, keep it locked
                    this.isLocked = true;

                    // Use setTimeout to ensure this happens after Livewire is fully initialized
                    setTimeout(() => {
                        $wire.lockSession();
                        console.log('Session was locked before refresh, keeping it locked');
                    }, 100);
                }
            }

            // Add event listener for beforeunload to ensure lock state is saved
            window.addEventListener('beforeunload', () => {
                if (this.isLocked || $wire.showLockModal) {
                    localStorage.setItem('sessionLocked', 'true');
                    console.log('Saving locked state before page unload');
                }
            });

            // Set a small delay to avoid showing modals during page refresh
            setTimeout(() => {
                // Only start timers if not locked
                if (!this.isLocked) {
                    this.resetTimer();
                }

                // Track user activity
                const events = ['mousedown', 'mousemove', 'keypress', 'scroll', 'touchstart'];
                events.forEach(event => {
                    document.addEventListener(event, () => {
                        this.lastActivity = Date.now();
                        if (!this.isLocked && !$wire.showLockModal) {
                            this.resetTimer();
                            if ($wire.showWarning) {
                                $wire.hideWarningModal();
                            }
                        }
                    }, true);
                });

                // Listen for Livewire events
                window.addEventListener('session-continued', () => {
                    this.resetTimer();
                });

                window.addEventListener('session-unlocked', () => {
                    this.resetTimer();
                });

                // Listen for session-refreshed event
                window.addEventListener('session-refreshed', () => {
                    // Only reset state if not locked
                    if (!this.isLocked) {
                        $wire.showWarning = false;
                        $wire.showLockModal = false;
                        this.resetTimer();
                    }
                });

                // Listen for lock-session event
                window.addEventListener('lock-session', () => {
                    this.isLocked = true;
                    localStorage.setItem('sessionLocked', 'true');
                });

                // Listen for unlock-session event
                window.addEventListener('unlock-session', () => {
                    console.log('Unlock session event received');
                    this.isLocked = false;
                    localStorage.setItem('sessionLocked', 'false');

                    // Force UI update
                    $wire.showLockModal = false;

                    // Reset timer with a slight delay to ensure UI is updated
                    setTimeout(() => {
                        this.resetTimer();
                        console.log('Session unlocked, timers reset');
                    }, 100);
                });

                // Listen for clear-session-lock event
                window.addEventListener('clear-session-lock', () => {
                    this.isLocked = false;
                    localStorage.removeItem('sessionLocked');
                    console.log('Session lock state cleared');
                });

                // Listen for refresh event
                window.addEventListener('refresh', () => {
                    console.log('Refresh event received, updating UI');
                    if (!this.isLocked) {
                        $wire.showLockModal = false;
                        this.resetTimer();
                    }
                });

                // Listen for page visibility changes
                document.addEventListener('visibilitychange', () => {
                    if (document.visibilityState === 'visible') {
                        // Reset timer when page becomes visible again
                        this.resetTimer();
                    }
                });

                // Listen for page beforeunload event
                window.addEventListener('beforeunload', () => {
                    // Clear timers when page is about to unload
                    clearTimeout(this.timer);
                    clearTimeout(this.warningTimer);
                });
            }, 1000); // 1 second delay to avoid showing modals during page refresh
        },

        resetTimer() {
            // Don't reset timers if session is locked
            if (this.isLocked) {
                console.log('Session is locked, not resetting timers');
                return;
            }

            clearTimeout(this.timer);
            clearTimeout(this.warningTimer);

            // Set warning timer
            this.warningTimer = setTimeout(() => {
                console.log('Warning timer triggered');
                $wire.showWarningModal();
            }, (this.inactivityTime - this.warningTime) * 1000);

            // Set lock timer
            this.timer = setTimeout(() => {
                console.log('Lock timer triggered');
                $wire.lockSession();
            }, this.inactivityTime * 1000);
        }
    }"
    x-init="init()"
    class="">
        <!-- Warning Modal -->
        <div x-show="$wire.showWarning"
             x-cloak
             class="fixed bottom-0 right-0 z-40 m-4 max-w-sm overflow-hidden rounded-lg bg-neutral-800 border border-emerald-500/30 shadow-lg"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform translate-y-4"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform translate-y-0"
             x-transition:leave-end="opacity-0 transform translate-y-4">
            <div class="p-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="p-2 bg-amber-500/10 rounded-lg">
                            <svg class="h-6 w-6 text-amber-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3 w-0 flex-1 pt-0.5">
                        <p class="text-sm font-medium text-white">Session Timeout Warning</p>
                        <p class="mt-1 text-sm text-neutral-300">Your session will be locked soon due to inactivity.</p>
                        <div class="mt-3">
                            <button type="button" wire:click="continueSession" class="flex items-center justify-center gap-2 px-4 py-2 rounded-lg border border-emerald-500/30 bg-emerald-500/10 transition-all duration-300 hover:bg-emerald-500/20 hover:border-emerald-500/50 hover:shadow-lg hover:shadow-emerald-900/20 text-sm font-medium text-emerald-400 hover:text-emerald-300">
                                Continue Session
                            </button>
                        </div>
                    </div>
                    <div class="ml-4 flex flex-shrink-0">
                        <button type="button" wire:click="continueSession" class="text-neutral-400 hover:text-white transition-colors">
                            <span class="sr-only">Close</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lock Modal -->
        <div x-show="$wire.showLockModal"
             x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center"
             aria-labelledby="modal-title"
             role="dialog"
             aria-modal="true"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            <div class="absolute inset-0 bg-black bg-opacity-50 backdrop-blur-sm"></div>

            <!-- Modal panel -->
            <div class="relative bg-neutral-800 rounded-xl shadow-lg p-8 max-w-md w-full mx-4 border border-emerald-500/30 transform transition-all">
                <div class="absolute top-4 right-4">
                    <button type="button" wire:click="continueSession" class="text-neutral-400 hover:text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="text-center">
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-amber-500/20 mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-amber-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-2">Session Locked</h3>
                    <p class="text-neutral-300 mb-6">Your session has been locked due to inactivity. Please enter your password to continue.</p>

                    <form id="unlock-form" wire:submit.prevent="verifyPassword" class="space-y-4 mb-6">
                        <div>
                            <label for="password" class="block text-sm font-medium text-neutral-300 mb-2">Password</label>
                            <input
                                type="password"
                                wire:model.lazy="password"
                                id="password"
                                name="password"
                                class="w-full p-3 rounded-lg bg-neutral-700 border border-neutral-600 text-white focus:outline-none focus:ring-2 focus:ring-emerald-500/50"
                                x-on:keydown.enter.prevent="$wire.verifyPassword()"
                                autofocus
                                autocomplete="current-password">
                        </div>
                        @if($errorMessage)
                            <div class="text-sm text-amber-400 bg-amber-500/10 border border-amber-500/20 rounded-lg p-3">
                                {{ $errorMessage }}
                            </div>
                        @endif
                        <div class="hidden">
                            <button type="submit">Submit</button>
                        </div>
                    </form>

                    <div class="flex flex-col gap-3 sm:flex-row">
                        <button type="button" wire:click="verifyPassword" class="w-full py-3 px-4 rounded-xl bg-emerald-500 hover:bg-emerald-600 transition-colors duration-300 text-white font-semibold text-center flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <span>Unlock</span>
                        </button>
                        <button type="button" wire:click="logout" class="w-full py-3 px-4 rounded-xl border border-neutral-600 bg-neutral-700 hover:bg-neutral-600 transition-colors duration-300 text-white font-semibold text-center flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span>Logout</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
