/**
 * Auto-lock functionality for student accounts
 * Displays a modal requiring password re-entry after a period of inactivity
 */

class AutoLock {
    constructor(options = {}) {
        // Get CSRF token from meta tag
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        console.log('CSRF token from meta tag:', csrfToken);

        // Default settings
        this.settings = {
            inactivityTime: options.inactivityTime || 15 * 1000, // Default: 15 seconds for testing (normally 5 minutes)
            warningTime: options.warningTime || 5 * 1000, // Default: 5 seconds warning before lock (for testing)
            modalId: options.modalId || 'auto-lock-modal',
            excludedRoles: options.excludedRoles || ['admin', 'faculty'],
            currentUserRole: options.currentUserRole || 'student',
            csrfToken: options.csrfToken || csrfToken || '',
            debugMode: typeof options.debugMode !== 'undefined' ? options.debugMode : false // Default to false for real-time testing
        };

        console.log('Auto-lock initializing with settings:', this.settings);

        // For testing purposes, initialize for all roles
        // if (this.settings.excludedRoles.includes(this.settings.currentUserRole)) {
        //     console.log('Auto-lock not initialized for role:', this.settings.currentUserRole);
        //     return;
        // }

        this.timers = {
            inactivity: null,
            warning: null
        };

        this.state = {
            isLocked: false,
            isWarning: false
        };

        this.initialize();
    }

    initialize() {
        console.log('Auto-lock initialize method called');

        // Create modal if it doesn't exist
        this.createModal();

        // Set up event listeners
        this.setupEventListeners();

        // Start the inactivity timer
        this.resetTimer();

        // Disable debug mode for real-time testing
        // if (this.settings.debugMode) {
        //     console.log('Debug mode enabled, will show warning in 3 seconds');
        //     setTimeout(() => {
        //         console.log('Debug: Showing warning modal');
        //         this.showWarning();
        //
        //         // Then show the lock modal after another short delay
        //         setTimeout(() => {
        //             console.log('Debug: Showing lock modal');
        //             this.lockSession();
        //         }, 3000);
        //     }, 3000);
        // }

        console.log('Auto-lock initialized with timeout:', this.settings.inactivityTime / 1000, 'seconds');
    }

    createModal() {
        // Check if modal already exists
        if (document.getElementById(this.settings.modalId)) {
            return;
        }

        // Create modal HTML
        const modalHtml = `
            <div id="${this.settings.modalId}" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div class="flex min-h-screen items-end justify-center px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                    <!-- Background overlay -->
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

                    <!-- Modal panel -->
                    <div class="inline-block transform overflow-hidden rounded-lg bg-white text-left align-bottom shadow-xl transition-all dark:bg-gray-800 sm:my-8 sm:w-full sm:max-w-lg sm:align-middle">
                        <div class="bg-white px-4 pt-5 pb-4 dark:bg-gray-800 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-yellow-100 dark:bg-yellow-900 sm:mx-0 sm:h-10 sm:w-10">
                                    <svg class="h-6 w-6 text-yellow-600 dark:text-yellow-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                    </svg>
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white" id="modal-title">
                                        Session Locked
                                    </h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            Your session has been locked due to inactivity. Please enter your password to continue.
                                        </p>
                                    </div>
                                    <div class="mt-4">
                                        <form id="unlock-form" class="space-y-4">
                                            <input type="hidden" name="_token" id="csrf-token" value="">
                                            <div>
                                                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                                                <input type="password" name="password" id="unlock-password" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm">
                                            </div>
                                            <div id="unlock-error" class="text-sm text-red-600 dark:text-red-400 hidden">
                                                Incorrect password. Please try again.
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 dark:bg-gray-700 sm:flex sm:flex-row-reverse sm:px-6">
                            <button type="button" id="unlock-button" class="inline-flex w-full justify-center rounded-md border border-transparent bg-green-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm">
                                Unlock
                            </button>
                            <button type="button" id="logout-button" class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Logout
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Warning modal -->
            <div id="${this.settings.modalId}-warning" class="fixed bottom-0 right-0 z-40 hidden m-4 max-w-sm overflow-hidden rounded-lg bg-white shadow-lg dark:bg-gray-800">
                <div class="p-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-yellow-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                        </div>
                        <div class="ml-3 w-0 flex-1 pt-0.5">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">Session timeout warning</p>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Your session will be locked soon due to inactivity.</p>
                            <div class="mt-3">
                                <button type="button" id="continue-session-button" class="inline-flex items-center rounded-md border border-transparent bg-green-600 px-3 py-2 text-sm font-medium leading-4 text-white shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                    Continue Session
                                </button>
                            </div>
                        </div>
                        <div class="ml-4 flex flex-shrink-0">
                            <button type="button" id="close-warning-button" class="inline-flex rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-gray-800 dark:text-gray-500 dark:hover:text-gray-400">
                                <span class="sr-only">Close</span>
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Append modal to body
        document.body.insertAdjacentHTML('beforeend', modalHtml);

        // Set CSRF token in the form
        setTimeout(() => {
            const csrfTokenInput = document.getElementById('csrf-token');
            if (csrfTokenInput) {
                csrfTokenInput.value = this.settings.csrfToken;
                console.log('CSRF token set in form:', this.settings.csrfToken);
            } else {
                console.error('CSRF token input not found in form');
            }
        }, 50);

        // Set up modal event listeners
        this.setupModalListeners();
    }

    setupModalListeners() {
        console.log('Setting up modal listeners');

        // Use a small delay to ensure DOM is fully loaded
        setTimeout(() => {
            // Unlock button
            const unlockButton = document.getElementById('unlock-button');
            if (unlockButton) {
                unlockButton.addEventListener('click', () => {
                    console.log('Unlock button clicked');
                    this.verifyPassword();
                });
                console.log('Unlock button listener added');
            } else {
                console.error('Unlock button not found in DOM');
            }

            // Unlock form submission
            const unlockForm = document.getElementById('unlock-form');
            if (unlockForm) {
                unlockForm.addEventListener('submit', (e) => {
                    console.log('Unlock form submitted');
                    e.preventDefault();
                    this.verifyPassword();
                });
                console.log('Unlock form listener added');
            } else {
                console.error('Unlock form not found in DOM');
            }

            // Logout button
            const logoutButton = document.getElementById('logout-button');
            if (logoutButton) {
                logoutButton.addEventListener('click', () => {
                    console.log('Logout button clicked');
                    window.location.href = '/logout';
                });
                console.log('Logout button listener added');
            } else {
                console.error('Logout button not found in DOM');
            }

            // Continue session button (warning modal)
            const continueButton = document.getElementById('continue-session-button');
            if (continueButton) {
                continueButton.addEventListener('click', () => {
                    console.log('Continue session button clicked');
                    this.dismissWarning();
                    this.resetTimer();
                });
                console.log('Continue session button listener added');
            } else {
                console.error('Continue session button not found in DOM');
            }

            // Close warning button
            const closeButton = document.getElementById('close-warning-button');
            if (closeButton) {
                closeButton.addEventListener('click', () => {
                    console.log('Close warning button clicked');
                    this.dismissWarning();
                    this.resetTimer();
                });
                console.log('Close warning button listener added');
            } else {
                console.error('Close warning button not found in DOM');
            }

            console.log('All modal listeners set up');
        }, 100); // Small delay to ensure DOM is ready
    }

    setupEventListeners() {
        console.log('Setting up user activity event listeners');

        // Track user activity
        const events = ['mousedown', 'mousemove', 'keypress', 'scroll', 'touchstart'];

        // For debugging - count events to avoid console spam
        let eventCount = 0;
        const eventThreshold = 10; // Log every 10 events

        events.forEach(event => {
            document.addEventListener(event, () => {
                // Only reset timer if not locked
                if (!this.state.isLocked) {
                    eventCount++;
                    if (eventCount % eventThreshold === 0) {
                        console.log(`User activity detected (${event}), resetting timer`);
                    }

                    this.resetTimer();

                    // If warning is showing, dismiss it
                    if (this.state.isWarning) {
                        console.log('Warning was showing, dismissing it');
                        this.dismissWarning();
                    }
                }
            }, true);
        });

        // Handle page visibility changes
        document.addEventListener('visibilitychange', () => {
            console.log('Page visibility changed:', document.visibilityState);
            if (document.visibilityState === 'visible' && !this.state.isLocked) {
                this.resetTimer();
            }
        });

        console.log('All event listeners set up');
    }

    resetTimer() {
        console.log('Resetting inactivity timers');

        // Clear existing timers
        clearTimeout(this.timers.inactivity);
        clearTimeout(this.timers.warning);

        // Set warning timer
        const warningDelay = this.settings.inactivityTime - this.settings.warningTime;
        console.log(`Setting warning timer for ${warningDelay/1000} seconds`);
        this.timers.warning = setTimeout(() => {
            console.log('Warning timer triggered');
            this.showWarning();
        }, warningDelay);

        // Set inactivity timer
        console.log(`Setting lock timer for ${this.settings.inactivityTime/1000} seconds`);
        this.timers.inactivity = setTimeout(() => {
            console.log('Lock timer triggered');
            this.lockSession();
        }, this.settings.inactivityTime);
    }

    showWarning() {
        console.log('Showing warning modal');
        const warningModal = document.getElementById(`${this.settings.modalId}-warning`);
        if (warningModal) {
            warningModal.classList.remove('hidden');
            console.log('Warning modal displayed');
            this.state.isWarning = true;
        } else {
            console.error('Warning modal element not found!');
        }
    }

    dismissWarning() {
        const warningModal = document.getElementById(`${this.settings.modalId}-warning`);
        warningModal.classList.add('hidden');
        this.state.isWarning = false;
    }

    lockSession() {
        console.log('Locking session...');

        // Show lock modal
        const modal = document.getElementById(this.settings.modalId);
        if (modal) {
            modal.classList.remove('hidden');
            console.log('Lock modal displayed');
        } else {
            console.error('Lock modal element not found!');
        }

        // Hide warning if it's showing
        this.dismissWarning();

        // Set locked state
        this.state.isLocked = true;
        console.log('Session locked state set to true');

        // Focus password field
        setTimeout(() => {
            const passwordField = document.getElementById('unlock-password');
            if (passwordField) {
                passwordField.focus();
                console.log('Password field focused');
            } else {
                console.error('Password field not found!');
            }
        }, 100);
    }

    verifyPassword() {
        console.log('Verifying password...');
        const password = document.getElementById('unlock-password').value;
        const errorElement = document.getElementById('unlock-error');

        if (!password) {
            console.log('No password entered');
            errorElement.textContent = 'Please enter your password.';
            errorElement.classList.remove('hidden');
            return;
        }

        console.log('Sending password verification request');
        console.log('CSRF Token:', this.settings.csrfToken);

        // Send password verification request
        fetch('/verify-password', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': this.settings.csrfToken
            },
            body: JSON.stringify({ password })
        })
        .then(response => {
            console.log('Response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Verification response:', data);
            if (data.success) {
                // Password correct, unlock session
                console.log('Password verified successfully');
                this.unlockSession();
            } else {
                // Password incorrect, show error
                console.log('Password verification failed:', data.message);
                errorElement.textContent = data.message || 'Incorrect password. Please try again.';
                errorElement.classList.remove('hidden');
                document.getElementById('unlock-password').value = '';
                document.getElementById('unlock-password').focus();
            }
        })
        .catch(error => {
            console.error('Error verifying password:', error);
            errorElement.textContent = 'An error occurred. Please try again.';
            errorElement.classList.remove('hidden');
        });
    }

    unlockSession() {
        // Hide modal
        const modal = document.getElementById(this.settings.modalId);
        modal.classList.add('hidden');

        // Reset form
        document.getElementById('unlock-password').value = '';
        document.getElementById('unlock-error').classList.add('hidden');

        // Reset state
        this.state.isLocked = false;

        // Reset timer
        this.resetTimer();
    }
}

// Export the class
export default AutoLock;
