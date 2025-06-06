<x-layouts.app>
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <!-- Hidden element to store next task URL -->
        <div id="next-task-url" class="hidden" data-url="{{ $nextTask ?
            ($challenge->subject_type === 'core' ? route('core.challenge.task', ['challenge' => $challenge, 'task' => $nextTask]) :
            ($challenge->subject_type === 'applied' ? route('applied.challenge.task', ['challenge' => $challenge, 'task' => $nextTask]) :
            route('challenge.task', ['challenge' => $challenge, 'task' => $nextTask]))) : '' }}"></div>

        <!-- Timer Display (shown when task is started) -->
        @if($currentTask->time_limit)
        <div id="timer-display" class="hidden mb-4 p-4 rounded-xl border border-amber-500/30 bg-amber-500/10 text-center">
            <div class="flex items-center justify-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-lg font-semibold text-amber-400">Time Remaining: </span>
                <span id="timer-countdown" class="text-2xl font-bold text-white">{{ $currentTask->time_limit }}:00</span>
            </div>
        </div>
        @endif
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-emerald-500/10 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-white">{{ $challenge->name }} - Task {{ $currentTask->id }}</h1>
            </div>
            <div class="flex gap-4">
                <a href="{{ route('challenge', $challenge) }}" class="flex items-center justify-center gap-2 px-5 py-2.5 rounded-lg border border-emerald-500/30 bg-emerald-500/10 transition-all duration-300 hover:bg-emerald-500/20 hover:border-emerald-500/50 hover:shadow-lg hover:shadow-emerald-900/20 group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400 group-hover:text-emerald-300 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span class="text-base font-medium text-emerald-400 group-hover:text-emerald-300 transition-colors">Back to Challenge</span>
                </a>
            </div>
        </div>

        <div class="grid gap-6 grid-cols-1 lg:grid-cols-2 h-full">
            <!-- Task Content -->
            <div class="flex flex-col p-6 rounded-xl border border-neutral-700 bg-linear-to-br from-neutral-800 to-neutral-900 shadow-lg h-full">
                <div class="space-y-6 flex-1">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="px-3 py-1 text-sm font-medium text-amber-400 bg-amber-500/10 border border-amber-500/20 rounded-full flex items-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                                {{ $currentTask->points_reward ?? 0 }} Points
                            </span>
                            @if($currentTask->time_limit)
                                <span class="px-3 py-1 text-sm font-medium text-neutral-300 bg-neutral-500/10 border border-neutral-500/20 rounded-full flex items-center gap-1.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $currentTask->time_limit }} min
                                </span>
                            @endif
                        </div>
                        <span class="px-3 py-1 text-sm font-medium text-blue-400 bg-blue-500/10 border border-blue-500/20 rounded-full">
                            {{ ucfirst($challenge->subject_type ?? 'Subject') }}
                        </span>
                    </div>

                    <div class="space-y-4">
                        <div class="p-4 rounded-lg bg-neutral-800/50 border border-neutral-700">
                            <h4 class="font-medium text-white mb-2 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Task
                            </h4>
                            <p class="text-neutral-300">
                                {{ $currentTask->description }}
                            </p>
                        </div>
                    </div>

                    <div class="p-4 rounded-lg bg-emerald-500/5 border border-emerald-500/20">
                        <h3 class="text-lg font-semibold text-white mb-3 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            Task Instructions
                        </h3>
                        <div class="prose prose-invert max-w-none">
                            <div class="space-y-4">
                                @if($currentTask->instructions)
                                    <div class="text-neutral-300">{!! $currentTask->instructions !!}</div>
                                @endif
                                <h4 class="text-emerald-400 font-medium mb-2">Completion Steps</h4>
                                <ul class="list-none space-y-2 text-neutral-300">
                                    <li class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                        </svg>
                                        <span>Read the task description carefully</span>
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                        </svg>
                                        <span>Analyze the requirements</span>
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                        </svg>
                                        <span>Formulate your answer</span>
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                        </svg>
                                        <span>Review your answer before submitting</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Solution Field -->
            <div class="flex flex-col p-6 rounded-xl border border-neutral-700 bg-linear-to-br from-neutral-800 to-neutral-900 shadow-lg h-full">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold text-white flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                        </svg>
                        Your Answer
                    </h2>
                </div>

                <!-- Text Area for non-coding challenges -->
                <div class="flex-1">
                    @php
                        $evaluationType = $currentTask->evaluation_type ?? 'manual';
                        $evaluationDetails = $currentTask->evaluation_details ?? [];
                    @endphp

                    @if($evaluationType === 'multiple_choice')
                        <div class="space-y-3">
                            @foreach($evaluationDetails['options'] ?? [] as $index => $option)
                                <label class="flex items-center space-x-3">
                                    <input type="checkbox"
                                           name="answer_options[]"
                                           value="{{ $index }}"
                                           class="form-checkbox rounded border-neutral-700 bg-neutral-800 text-emerald-500 focus:ring-emerald-500/50">
                                    <span class="text-white">{{ $option }}</span>
                                </label>
                            @endforeach
                        </div>
                    @else
                        <textarea id="answer-input"
                            class="w-full h-48 p-4 rounded-lg bg-neutral-800 border border-neutral-700 text-white focus:outline-none focus:ring-2 focus:ring-emerald-500/50 resize-none"
                            placeholder="Type your answer here..."></textarea>
                    @endif
                </div>

                <!-- Message container for submission status -->
                <div id="submission-message" class="mt-4 p-3 rounded-lg border hidden">
                    <p id="message-text" class="text-center font-medium"></p>
                </div>

                <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <button id="submit-solution" class="w-full py-3 px-4 rounded-xl bg-emerald-500 hover:bg-emerald-600 transition-colors duration-300 text-white font-semibold text-center flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Submit Answer
                    </button>

                    <script>
                        // Timer functionality - make global
                        window.taskTimer = null;
                        window.timerStarted = false;

                        // Timer persistence key
                        const TIMER_KEY = 'task_timer_{{ $currentTask->id }}_{{ auth()->user()->id }}';
                        const TIMER_START_KEY = 'task_start_{{ $currentTask->id }}_{{ auth()->user()->id }}';

                        // Initialize time remaining with persistence
                        function initializeTimer() {
                            const originalTime = {{ $currentTask->time_limit ? $currentTask->time_limit * 60 : 0 }};
                            const savedStartTime = localStorage.getItem(TIMER_START_KEY);

                            if (savedStartTime && originalTime > 0) {
                                // Calculate elapsed time since timer started
                                const startTime = parseInt(savedStartTime);
                                const currentTime = Math.floor(Date.now() / 1000);
                                const elapsedTime = currentTime - startTime;

                                // Calculate remaining time
                                window.timeRemaining = Math.max(0, originalTime - elapsedTime);

                                console.log('Timer restored:', {
                                    originalTime,
                                    elapsedTime,
                                    timeRemaining: window.timeRemaining
                                });
                            } else {
                                // First time starting the timer
                                window.timeRemaining = originalTime;
                                if (originalTime > 0) {
                                    localStorage.setItem(TIMER_START_KEY, Math.floor(Date.now() / 1000).toString());
                                }
                            }
                        }

                        // Initialize timer on page load
                        initializeTimer();

                        window.startTaskTimer = function() {
                            if (!window.timeRemaining || window.timerStarted) return;

                            window.timerStarted = true;
                            const timerDisplay = document.getElementById('timer-display');
                            const timerCountdown = document.getElementById('timer-countdown');

                            if (timerDisplay) {
                                timerDisplay.classList.remove('hidden');
                            }

                            window.taskTimer = setInterval(function() {
                                window.timeRemaining--;
                                window.updateTimerDisplay();

                                if (window.timeRemaining <= 0) {
                                    clearInterval(window.taskTimer);
                                    window.handleTimeUp();
                                }
                            }, 1000);

                            window.updateTimerDisplay();
                        }

                        window.updateTimerDisplay = function() {
                            const timerCountdown = document.getElementById('timer-countdown');
                            if (!timerCountdown) return;

                            const minutes = Math.floor(window.timeRemaining / 60);
                            const seconds = window.timeRemaining % 60;
                            const timeString = `${minutes}:${seconds.toString().padStart(2, '0')}`;

                            timerCountdown.textContent = timeString;

                            // Change color when time is running low
                            if (window.timeRemaining <= 60) { // Last minute
                                timerCountdown.classList.add('text-red-400');
                                timerCountdown.classList.remove('text-white');
                            } else if (window.timeRemaining <= 300) { // Last 5 minutes
                                timerCountdown.classList.add('text-amber-400');
                                timerCountdown.classList.remove('text-white');
                            }
                        }

                        window.handleTimeUp = function() {
                            // Clear timer storage
                            localStorage.removeItem(TIMER_KEY);
                            localStorage.removeItem(TIMER_START_KEY);

                            // Auto-submit the current answer
                            window.autoSubmitAnswer();

                            // Show time's up modal
                            const modal = document.getElementById('times-up-modal');
                            if (modal) {
                                modal.classList.remove('hidden');
                            }
                        }

                        // Clear timer storage when task is completed
                        window.clearTimerStorage = function() {
                            localStorage.removeItem(TIMER_KEY);
                            localStorage.removeItem(TIMER_START_KEY);
                        }

                        window.autoSubmitAnswer = function() {
                            const answerInput = document.getElementById('answer-input');
                            const evaluationType = '{{ $currentTask->evaluation_type ?? "manual" }}';
                            let submittedAnswer;

                            if (evaluationType === 'multiple_choice') {
                                const selectedOptions = Array.from(document.querySelectorAll('input[name="answer_options[]"]:checked'))
                                    .map(checkbox => checkbox.value);
                                submittedAnswer = selectedOptions.join(',');
                            } else {
                                submittedAnswer = answerInput ? answerInput.value.trim() : '';
                            }

                            // Submit with auto-submission flags
                            fetch('/api/direct-text-solution', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify({
                                    task_id: {{ $currentTask->id }},
                                    user_id: {{ auth()->user()->id }},
                                    student_answer: {
                                        submitted_text: submittedAnswer || 'No answer provided (time expired)',
                                        output: submittedAnswer || 'No answer provided (time expired)',
                                        auto_submitted: true,
                                        time_expired: true
                                    }
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                console.log('Auto-submission completed:', data);
                            })
                            .catch(error => {
                                console.error('Auto-submission failed:', error);
                            });
                        }

                        window.showTaskSubmittedModal = function() {
                            const modal = document.getElementById('task-submitted-modal');
                            if (modal) {
                                modal.classList.remove('hidden');
                            }
                        }

                        window.navigateToNextTask = function() {
                            const nextTaskUrl = document.getElementById('next-task-url').dataset.url;

                            if (nextTaskUrl) {
                                window.location.href = nextTaskUrl;
                            } else {
                                // Redirect to challenge page if no next task
                                window.location.href = '{{ route("challenge", $challenge) }}';
                            }
                        }

                        // Add handler for non-coding challenges
                        document.addEventListener('DOMContentLoaded', function() {
                            const answerInput = document.getElementById('answer-input');
                            const submitBtn = document.getElementById('submit-solution');
                            const evaluationType = '{{ $currentTask->evaluation_type ?? "manual" }}';

                            if (submitBtn) {
                                submitBtn.addEventListener('click', function() {
                                    let submittedAnswer;

                                    if (evaluationType === 'multiple_choice') {
                                        // Gather selected checkboxes for multiple choice
                                        const selectedOptions = Array.from(document.querySelectorAll('input[name="answer_options[]"]:checked'))
                                            .map(checkbox => checkbox.value);
                                        submittedAnswer = selectedOptions.join(',');
                                    } else {
                                        // Get text input for other types
                                        submittedAnswer = answerInput ? answerInput.value.trim() : '';
                                    }

                                    // Log the answer for debugging
                                    console.log('Submitting answer:', submittedAnswer);

                                    if (!submittedAnswer) {
                                        // Show error message
                                        const messageContainer = document.getElementById('submission-message');
                                        const messageText = document.getElementById('message-text');

                                        if (messageContainer && messageText) {
                                            messageContainer.classList.remove('hidden');
                                            messageContainer.classList.add('bg-amber-500/10', 'border-amber-500/20');
                                            messageText.classList.add('text-amber-400');
                                            messageText.textContent = 'Please enter your answer before submitting.';
                                        }
                                        return;
                                    }

                                    // Disable submit button to prevent double submission
                                    submitBtn.disabled = true;
                                    submitBtn.innerHTML = '<svg class="animate-spin h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Submitting...';

                                    // Use the direct submission route
                                    fetch('/api/direct-text-solution', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                                            'Accept': 'application/json'
                                        },
                                        body: JSON.stringify({
                                            task_id: {{ $currentTask->id }},
                                            user_id: {{ auth()->user()->id }},
                                            student_answer: {
                                                submitted_text: submittedAnswer,
                                                output: submittedAnswer
                                            }
                                        })
                                    })
                                    .then(response => {
                                        console.log('Response received:', response.status);
                                        return response.json();
                                    })
                                    .then(data => {
                                        console.log('Response data:', data);
                                        if (data.success) {
                                            console.log('Answer submitted successfully');

                                            // Stop timer if running and clear storage
                                            if (window.taskTimer) {
                                                clearInterval(window.taskTimer);
                                            }
                                            window.clearTimerStorage();

                                            // Show task submitted modal instead of completion modal
                                            setTimeout(() => {
                                                window.showTaskSubmittedModal();
                                            }, 1000);
                                        } else {
                                            console.error('Failed to submit answer:', data.message);
                                            // Re-enable button on failure
                                            submitBtn.disabled = false;
                                            submitBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>Submit Answer';
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error submitting answer:', error);
                                        console.error('Error details:', error.stack || 'No stack trace available');

                                        // Show error message
                                        const messageContainer = document.getElementById('submission-message');
                                        const messageText = document.getElementById('message-text');

                                        if (messageContainer && messageText) {
                                            messageContainer.classList.remove('hidden');
                                            messageContainer.classList.add('bg-red-500/10', 'border-red-500/20');
                                            messageText.classList.add('text-red-400');
                                            messageText.textContent = 'Error submitting answer. Please try again.';
                                        }
                                        // Re-enable button on error
                                        submitBtn.disabled = false;
                                        submitBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>Submit Answer';
                                    });
                                });
                            }

                            // Start timer when page loads (if task has time limit)
                            @if($currentTask->time_limit)
                                window.startTaskTimer();
                            @endif

                            // Modal event listeners
                            const timesUpNextBtn = document.getElementById('times-up-next-btn');
                            const submittedNextBtn = document.getElementById('submitted-next-btn');
                            const closeSubmittedModal = document.getElementById('close-submitted-modal');

                            if (timesUpNextBtn) {
                                timesUpNextBtn.addEventListener('click', window.navigateToNextTask);
                            }

                            if (submittedNextBtn) {
                                submittedNextBtn.addEventListener('click', window.navigateToNextTask);
                            }

                            if (closeSubmittedModal) {
                                closeSubmittedModal.addEventListener('click', function() {
                                    const modal = document.getElementById('task-submitted-modal');
                                    if (modal) {
                                        modal.classList.add('hidden');
                                    }
                                });
                            }

                            // Anti-cheating measures
                            @if($currentTask->time_limit)
                                // Prevent back button navigation
                                history.pushState(null, null, location.href);
                                window.addEventListener('popstate', function(event) {
                                    history.pushState(null, null, location.href);

                                    // Show warning modal or message
                                    alert('Navigation is disabled during timed tasks to prevent cheating. Please complete the task or wait for the timer to expire.');
                                });

                                // Prevent page refresh with confirmation
                                window.addEventListener('beforeunload', function(e) {
                                    if (window.timerStarted && window.timeRemaining > 0) {
                                        const confirmationMessage = 'Are you sure you want to leave? Your timer will continue running and you may lose your progress.';
                                        e.returnValue = confirmationMessage;
                                        return confirmationMessage;
                                    }
                                });

                                // Disable right-click context menu
                                document.addEventListener('contextmenu', function(e) {
                                    e.preventDefault();
                                    return false;
                                });

                                // Disable common keyboard shortcuts
                                document.addEventListener('keydown', function(e) {
                                    // Disable F5 (refresh)
                                    if (e.key === 'F5') {
                                        e.preventDefault();
                                        alert('Page refresh is disabled during timed tasks.');
                                        return false;
                                    }

                                    // Disable Ctrl+R (refresh)
                                    if (e.ctrlKey && e.key === 'r') {
                                        e.preventDefault();
                                        alert('Page refresh is disabled during timed tasks.');
                                        return false;
                                    }

                                    // Disable Ctrl+Shift+I (Developer Tools)
                                    if (e.ctrlKey && e.shiftKey && e.key === 'I') {
                                        e.preventDefault();
                                        return false;
                                    }

                                    // Disable F12 (Developer Tools)
                                    if (e.key === 'F12') {
                                        e.preventDefault();
                                        return false;
                                    }

                                    // Disable Ctrl+U (View Source)
                                    if (e.ctrlKey && e.key === 'u') {
                                        e.preventDefault();
                                        return false;
                                    }
                                });

                                // Detect tab visibility changes (user switching tabs)
                                document.addEventListener('visibilitychange', function() {
                                    if (document.hidden && window.timerStarted && window.timeRemaining > 0) {
                                        console.warn('User switched away from task tab');
                                        // You could implement additional logging here
                                    }
                                });
                            @endif
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>

    <!-- Time's Up Modal -->
    <div id="times-up-modal" class="fixed inset-0 z-50 flex items-center justify-center hidden">
        <div class="absolute inset-0 bg-black bg-opacity-50 backdrop-blur-sm"></div>
        <div class="relative bg-neutral-800 rounded-xl shadow-lg p-8 max-w-md w-full mx-4 border border-red-500/30 transform transition-all">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-500/20 mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-white mb-2">Time's Up!</h3>
                <p class="text-neutral-300 mb-6">Your time limit has expired. Your current answer will be automatically submitted.</p>
                <div class="flex flex-col gap-3">
                    <button id="times-up-next-btn" class="w-full py-3 px-4 rounded-xl bg-emerald-500 hover:bg-emerald-600 transition-colors duration-300 text-white font-semibold text-center flex items-center justify-center gap-2">
                        <span>Next Task</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Task Submitted Modal -->
    <div id="task-submitted-modal" class="fixed inset-0 z-50 flex items-center justify-center hidden">
        <div class="absolute inset-0 bg-black bg-opacity-50 backdrop-blur-sm"></div>
        <div class="relative bg-neutral-800 rounded-xl shadow-lg p-8 max-w-md w-full mx-4 border border-emerald-500/30 transform transition-all">
            <div class="absolute top-4 right-4">
                <button id="close-submitted-modal" class="text-neutral-400 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-emerald-500/20 mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-white mb-2">Task Submitted!</h3>
                <p class="text-neutral-300 mb-2">Great job! Your answer has been submitted successfully.</p>
                <div class="bg-blue-500/10 border border-blue-500/20 rounded-lg p-4 mb-6">
                    <p class="text-blue-400 flex items-start gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Your answer will be reviewed by your teacher. You'll receive feedback and points once the review is complete.</span>
                    </p>
                </div>
                <div class="flex flex-col gap-3">
                    <button id="submitted-next-btn" class="w-full py-3 px-4 rounded-xl bg-emerald-500 hover:bg-emerald-600 transition-colors duration-300 text-white font-semibold text-center flex items-center justify-center gap-2">
                        <span>Next Task</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Task Completion Modal -->
    <div id="task-completion-modal" class="fixed inset-0 z-50 flex items-center justify-center hidden">
        <div class="absolute inset-0 bg-black bg-opacity-10 backdrop-blur-md"></div>
        <div class="relative bg-neutral-800 rounded-xl shadow-lg p-8 max-w-md w-full mx-4 border border-emerald-500/30 transform transition-all">
            <div class="absolute top-4 right-4">
                <button id="close-task-modal" class="text-neutral-400 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-emerald-500/20 mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-white mb-2">Task Submitted!</h3>
                <p class="text-neutral-300 mb-2">Great job! Your answer has been submitted successfully.</p>
                <div class="bg-blue-500/10 border border-blue-500/20 rounded-lg p-4 mb-6">
                    <p class="text-blue-400 flex items-start gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Your answer will be reviewed by your teacher. You'll receive feedback and points once the review is complete.</span>
                    </p>
                </div>
                <div class="flex flex-col gap-3">
                    @if($nextTask)
                        <a href="{{
                            $challenge->subject_type === 'core' ? route('core.challenge.task', ['challenge' => $challenge, 'task' => $nextTask]) :
                            ($challenge->subject_type === 'applied' ? route('applied.challenge.task', ['challenge' => $challenge, 'task' => $nextTask]) :
                            route('challenge.task', ['challenge' => $challenge, 'task' => $nextTask]))
                        }}" class="w-full py-3 px-4 rounded-xl bg-emerald-500 hover:bg-emerald-600 transition-colors duration-300 text-white font-semibold text-center flex items-center justify-center gap-2">
                            <span>Next Task</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    @else
                        <a href="{{ route('challenge', $challenge) }}" class="w-full py-3 px-4 rounded-xl bg-emerald-500 hover:bg-emerald-600 transition-colors duration-300 text-white font-semibold text-center flex items-center justify-center gap-2">
                            <span>Back to Challenge</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        // Show modal when task is completed
        function showCompletionModal() {
            const modal = document.getElementById('task-completion-modal');
            if (modal) {
                modal.classList.remove('hidden');
            }
        }

        // Close modal when clicking the close button
        const closeButton = document.getElementById('close-task-modal');
        if (closeButton) {
            closeButton.addEventListener('click', function() {
                const modal = document.getElementById('task-completion-modal');
                if (modal) {
                    modal.classList.add('hidden');
                }
            });
        }

        // Close modal when clicking outside
        const modalOverlay = document.querySelector('#task-completion-modal .absolute.inset-0');
        if (modalOverlay) {
            modalOverlay.addEventListener('click', function() {
                const modal = document.getElementById('task-completion-modal');
                if (modal) {
                    modal.classList.add('hidden');
                }
            });
        }
    </script>
</x-layouts.app>
