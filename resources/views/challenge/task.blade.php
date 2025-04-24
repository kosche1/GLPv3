<x-layouts.app>
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script>
            // Configure Monaco loader
            window.MonacoEnvironment = {
                getWorkerUrl: function(workerId, label) {
                    return `data:text/javascript;charset=utf-8,${encodeURIComponent(`
                        self.MonacoEnvironment = {
                            baseUrl: '${window.location.origin}/js/monaco-editor/min/'
                        };
                        importScripts('${window.location.origin}/js/monaco-editor/min/vs/base/worker/workerMain.js');
                    `)}`;
                }
            };
        </script>
        <script src="{{ asset('js/monaco-editor/min/vs/loader.js') }}"></script>
        <script>
            require.config({
                paths: {
                    'vs': '{{ asset('js/monaco-editor/min/vs') }}'
                }
            });

            // Preload Monaco features for faster initialization
            if (document.querySelector('#monaco-editor-container')) {
                require(['vs/editor/editor.main'], function() {
                    // Preload language contributions
                    require([
                        'vs/basic-languages/php/php.contribution',
                        'vs/basic-languages/sql/sql.contribution',
                        'vs/basic-languages/java/java.contribution',
                        'vs/basic-languages/python/python.contribution',
                        'vs/basic-languages/javascript/javascript.contribution',
                        'vs/basic-languages/html/html.contribution',
                        'vs/basic-languages/css/css.contribution'
                    ], function() {
                        console.log('Monaco language modules preloaded');
                    });
                });
            }

            // Add handler for non-coding challenges
            const answerInput = document.getElementById('answer-input');
            const submitBtn = document.getElementById('submit-solution');

            if (answerInput && submitBtn) {
                submitBtn.addEventListener('click', function() {
                    const answer = answerInput.value.trim();

                    if (!answer) {
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

                    // Log the submission URL and data
                    const submitUrl = '/api/direct-text-solution';
                    console.log('Submitting to:', submitUrl);
                    console.log('Submission data:', {
                        task_id: {{ $currentTask->id }},
                        user_id: {{ auth()->user()->id }},
                        student_answer: {
                            submitted_text: answer,
                            output: answer
                        }
                    });

                    // Use the direct submission route that's working
                    console.log('Submitting answer to:', submitUrl);

                    try {
                        console.log('Starting fetch request...');
                        fetch(submitUrl, {
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
                                submitted_text: answer,
                                output: answer
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
                            // Show appropriate message based on status
                            const messageContainer = document.getElementById('submission-message');
                            const messageText = document.getElementById('message-text');

                            if (messageContainer && messageText) {
                                messageContainer.classList.remove('hidden');
                                messageContainer.classList.add('bg-emerald-500/10', 'border-emerald-500/20');
                                messageText.classList.add('text-emerald-400');
                                messageText.textContent = data.message;
                            }

                            // If pending review, maybe disable the submit button
                            if (data.status === 'pending_review') {
                                submitBtn.disabled = true;
                                submitBtn.textContent = 'Answer Submitted - Pending Review';
                            }

                            // Redirect to challenge page after a short delay
                            setTimeout(() => {
                                window.location.href = '{{ route("challenge", ["challenge" => $currentTask->challenge_id]) }}';
                            }, 1500);
                        } else {
                            // Show error message
                            const messageContainer = document.getElementById('submission-message');
                            const messageText = document.getElementById('message-text');

                            if (messageContainer && messageText) {
                                messageContainer.classList.remove('hidden');
                                messageContainer.classList.add('bg-red-500/10', 'border-red-500/20');
                                messageText.classList.add('text-red-400');
                                messageText.textContent = data.message || 'Failed to submit answer';
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error submitting answer:', error);
                        console.error('Error details:', error.stack || 'No stack trace available');
                        // Try to get more detailed error information
                        let errorMessage = 'Failed to submit answer. Please try again.';
                        if (error.response && error.response.data && error.response.data.message) {
                            errorMessage = error.response.data.message;
                        }

                        // Show error message
                        const messageContainer = document.getElementById('submission-message');
                        const messageText = document.getElementById('message-text');

                        if (messageContainer && messageText) {
                            messageContainer.classList.remove('hidden');
                            messageContainer.classList.add('bg-red-500/10', 'border-red-500/20');
                            messageText.classList.add('text-red-400');
                            messageText.textContent = errorMessage;
                        }
                    });
                    } catch (error) {
                        console.error('Critical error in fetch operation:', error);
                        console.error('Error details:', error.stack || 'No stack trace available');

                        // Show error message
                        const messageContainer = document.getElementById('submission-message');
                        const messageText = document.getElementById('message-text');

                        if (messageContainer && messageText) {
                            messageContainer.classList.remove('hidden');
                            messageContainer.classList.add('bg-red-500/10', 'border-red-500/20');
                            messageText.classList.add('text-red-400');
                            messageText.textContent = 'A critical error occurred while submitting your answer. Please try again.';
                        }
                    }
                });
            }
        </script>
    </head>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <!-- Hidden element to store next task URL -->
        <div id="next-task-url" class="hidden" data-url="{{ $nextTask ? route('challenge.task', ['challenge' => $challenge, 'task' => $nextTask]) : '' }}"></div>
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
                            {{ ucfirst($challenge->programming_language ?? 'Code') }}
                        </span>
                    </div>

                    <div class="space-y-4">
                        @php
                            $categoryName = $challenge->category->name ?? '';
                            $codingCategories = ['Computer Science', 'Web Development', 'Mobile Development'];
                            $isCodingTask = in_array($categoryName, $codingCategories) || !empty($challenge->programming_language);
                        @endphp

                        <div class="p-4 rounded-lg bg-neutral-800/50 border border-neutral-700">
                            <h4 class="font-medium text-white mb-2 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                @if($isCodingTask)
                                Scenario
                                @else
                                Task
                                @endif
                            </h4>
                            <p class="text-neutral-300">
                                @if($isCodingTask)
                                {{ $challenge->challenge_content['scenario'] ?? 'No scenario available' }}
                                @else
                                {{ $currentTask->description }}
                                @endif
                            </p>
                        </div>

                        @if($isCodingTask)
                        <div class="p-4 rounded-lg bg-neutral-800/50 border border-neutral-700">
                            <h4 class="font-medium text-white mb-2 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                                </svg>
                                Code with Bugs
                            </h4>
                            <div class="relative">
                                <pre class="p-4 rounded-lg bg-neutral-900 text-neutral-300 font-mono text-sm whitespace-pre overflow-x-auto max-h-[200px] overflow-y-auto">{{ $challenge->challenge_content['buggy_code'] ?? 'No code available' }}</pre>
                                <button class="absolute top-2 right-2 p-1 rounded-sm bg-neutral-800 hover:bg-neutral-700 transition-colors" onclick="copyToClipboard(this)" data-content="{{ $challenge->challenge_content['buggy_code'] ?? '' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="p-4 rounded-lg bg-neutral-800/50 border border-neutral-700">
                            <h4 class="font-medium text-white mb-2 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Current Behavior
                            </h4>
                            <p class="text-neutral-300">{{ $challenge->challenge_content['current_behavior'] ?? 'Not specified' }}</p>
                        </div>

                        <div class="p-4 rounded-lg bg-neutral-800/50 border border-neutral-700">
                            <h4 class="font-medium text-white mb-2 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Expected Behavior
                            </h4>
                            <p class="text-neutral-300">{{ $currentTask->description }}</p>
                        </div>
                        @endif
                    </div>
                    {{-- @dd(auth()->user()->id) --}}
                    <div class="p-4 rounded-lg bg-emerald-500/5 border border-emerald-500/20">
                        <h3 class="text-lg font-semibold text-white mb-3 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            Task Instructions
                        </h3>
                        <div class="prose prose-invert max-w-none">
                            <div class="space-y-4">
                                @php
                                    $categoryName = $challenge->category->name ?? '';
                                    $codingCategories = ['Computer Science', 'Web Development', 'Mobile Development'];
                                    $isCodingTask = in_array($categoryName, $codingCategories) || !empty($challenge->programming_language);
                                @endphp

                                @if($isCodingTask)
                                <h4 class="text-emerald-400 font-medium mb-2">Debug Process</h4>
                                <ul class="list-none space-y-2 text-neutral-300">
                                    <li class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                        </svg>
                                        <span>Review the code and identify the issue</span>
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                        </svg>
                                        <span>Test the code with different inputs</span>
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                        </svg>
                                        <span>Fix the bug with minimal changes</span>
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                        </svg>
                                        <span>Verify the solution works</span>
                                    </li>
                                </ul>
                                @else
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
                                @endif
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
                    @php
                        $categoryName = $challenge->category->name; // Assuming the category name is stored in the 'name' column
                        $codingCategories = ['Computer Science', 'Web Development', 'Mobile Development'];
                        $showRunCode = in_array($categoryName, $codingCategories);
                    @endphp

                    @if($showRunCode)
                    <button id="run-code-btn" class="flex items-center justify-center gap-1.5 p-2 rounded-lg bg-emerald-500 hover:bg-emerald-600 transition-colors duration-300 text-sm text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Run Code
                    </button>
                    @endif
                </div>

                @if($showRunCode)
                    <!-- Monaco Editor Container -->
                    <div class="flex-1 relative min-h-[400px] rounded-lg overflow-hidden border border-neutral-700" id="monaco-editor-container">
                        <div id="monaco-loading" class="absolute inset-0 flex items-center justify-center bg-neutral-900">
                            <div class="flex flex-col items-center">
                                <div class="animate-spin rounded-full h-10 w-10 border-t-2 border-b-2 border-emerald-400 mb-2"></div>
                                <span class="text-sm text-neutral-400">Loading editor...</span>
                            </div>
                        </div>
                    </div>
                    <!-- Output Container -->
                    <div id="code-output" class="mt-4 p-4 rounded-xl bg-neutral-900 border border-neutral-700 hidden">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-sm font-medium text-white flex items-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Execution Output
                            </h3>
                            <button id="clear-output-btn" class="text-sm text-neutral-500 hover:text-neutral-400 transition-colors duration-300 flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Clear
                            </button>
                        </div>
                        <div id="output-content" class="font-mono text-sm whitespace-pre-wrap break-words overflow-x-auto max-h-[200px] overflow-y-auto p-3 bg-neutral-800 rounded-lg">
                            <!-- Output will be displayed here -->
                        </div>
                    </div>
                @else
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
                @endif

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
                        // Add handler for non-coding challenges
                        document.addEventListener('DOMContentLoaded', function() {
                            const answerInput = document.getElementById('answer-input');
                            const submitBtn = document.getElementById('submit-solution');
                            const evaluationType = '{{ $currentTask->evaluation_type ?? "manual" }}';

                            // We'll use the submitSolution function defined in the main script
                            // This event listener will be replaced by our main script
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

                                    // Get the evaluation type directly from the task data
                                    const taskEvalType = '{{ $currentTask->evaluation_type ?? "manual" }}';
                                    console.log('Text submission - Current evaluation type:', taskEvalType);
                                    console.log('Text submission - Answer content:', submittedAnswer);

                                    // Check for errors in the submitted text
                                    const hasTextErrors = submittedAnswer.includes('ERROR') ||
                                                      submittedAnswer.toLowerCase().includes('error') ||
                                                      submittedAnswer.includes('Exception') ||
                                                      submittedAnswer.toLowerCase().includes('exception');

                                    console.log('Text submission - Has errors:', hasTextErrors);
                                    console.log('Text submission - Is exact match:', taskEvalType === 'exact_match');

                                    // Check if this is an Exact Match evaluation and if there's an error in the output
                                    if (taskEvalType === 'exact_match' && hasTextErrors) {
                                        console.log('BLOCKING TEXT SUBMISSION: Exact match with errors detected');

                                        // Show error message
                                        const messageContainer = document.getElementById('submission-message');
                                        const messageText = document.getElementById('message-text');

                                        if (messageContainer && messageText) {
                                            messageContainer.classList.remove('hidden');
                                            messageContainer.classList.add('bg-red-500/10', 'border-red-500/20');
                                            messageText.classList.add('text-red-400');
                                            messageText.textContent = 'Cannot submit solution with errors. Please fix your answer and try again.';
                                        }

                                        // Re-enable button
                                        submitBtn.disabled = false;
                                        submitBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>Submit Answer';

                                        return;
                                    }

                                    // For exact_match, warn the user that their answer must match exactly
                                    if (taskEvalType === 'exact_match') {
                                        console.log('Exact match evaluation type detected - answer must match exactly');
                                    }

                                    // Log the submission URL and data
                                    const submitUrl = '/api/direct-text-solution';
                                    console.log('Submitting to:', submitUrl);
                                    console.log('Submission data:', {
                                        task_id: {{ $currentTask->id }},
                                        user_id: {{ auth()->user()->id }},
                                        student_answer: {
                                            submitted_text: submittedAnswer,
                                            output: submittedAnswer
                                        }
                                    });

                                    // Use the direct submission route that's working
                                    console.log('Submitting answer to:', submitUrl);

                                    try {
                                        console.log('Starting fetch request...');
                                        fetch(submitUrl, {
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

                                            // Get the next task URL
                                            const nextTaskUrl = '{{ $nextTask ? route("challenge.task", ["challenge" => $challenge, "task" => $nextTask]) : "" }}';

                                            if (nextTaskUrl) {
                                                console.log('Redirecting to next task...');
                                                window.location.href = nextTaskUrl;
                                            } else {
                                                // Redirect to the challenge page if there's no next task
                                                console.log('Redirecting to challenge page...');
                                                window.location.href = '{{ route("challenge", ["challenge" => $currentTask->challenge_id]) }}';
                                            }
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
                                    } catch (error) {
                                        console.error('Critical error in fetch operation:', error);
                                        console.error('Error details:', error.stack || 'No stack trace available');

                                        // Show error message
                                        const messageContainer = document.getElementById('submission-message');
                                        const messageText = document.getElementById('message-text');

                                        if (messageContainer && messageText) {
                                            messageContainer.classList.remove('hidden');
                                            messageContainer.classList.add('bg-red-500/10', 'border-red-500/20');
                                            messageText.classList.add('text-red-400');
                                            messageText.textContent = 'A critical error occurred while submitting your answer. Please try again.';
                                        }
                                        // Re-enable button on error
                                        submitBtn.disabled = false;
                                        submitBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>Submit Answer';
                                    }
                                });
                            }
                        });
                    </script>
                    @if($nextTask)
                        <a href="{{ route('challenge.task', ['challenge' => $challenge, 'task' => $nextTask]) }}" class="w-full py-3 px-4 rounded-xl bg-blue-500 hover:bg-blue-600 transition-colors duration-300 text-white font-semibold text-center flex items-center justify-center gap-2">
                            <span>Next Task</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    @else
                        <div class="w-full py-3 px-4 rounded-xl bg-neutral-700 text-neutral-400 font-semibold text-center cursor-not-allowed flex items-center justify-center gap-2">
                            <span>Last Task</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        #monaco-editor-container {
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
            height: 100%;
            min-height: 400px;
            width: 100%;
        }
        .monaco-editor {
            height: 100% !important;
            width: 100% !important;
        }
        .monaco-editor .overflow-guard {
            border-radius: 0.5rem;
        }
        #monaco-loading {
            z-index: 10;
        }
    </style>

    <script>
        // Wait until the DOM is fully loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize variables
            let editor = null;
            let lastExecutionOutput = '';

            // Store references to DOM elements
            const container = document.getElementById('monaco-editor-container');
            const loadingEl = document.getElementById('monaco-loading');
            const runBtn = document.getElementById('run-code-btn');
            const submitBtn = document.getElementById('submit-solution');
            const outputDiv = document.getElementById('code-output');
            const outputContent = document.getElementById('output-content');
            const clearOutputBtn = document.getElementById('clear-output-btn');

            // Store initial values - need to escape properly for JS
            const initialCode = `{!! addslashes($challenge->challenge_content['buggy_code'] ?? '') !!}`;
            const programmingLanguage = '{!! $challenge->programming_language ?? "javascript" !!}';
            // const userId =;
            // Map challenge language names to Monaco language names
            const languageMap = {
                'php': 'php',
                'python': 'python',
                'java': 'java',
                'sql': 'sql',
                'javascript': 'javascript',
                'js': 'javascript',
                'html': 'html',
                'css': 'css',
                'none': 'plaintext'
            };

            // Normalize the language name
            let monacoLanguage = (programmingLanguage || 'plaintext').toLowerCase();
            monacoLanguage = languageMap[monacoLanguage] || 'plaintext';

            console.log('Language detected:', programmingLanguage, 'Mapped to:', monacoLanguage);

            // Output handling functions
            function clearOutput() {
                if (!outputContent) return;
                outputContent.innerHTML = '';
                outputDiv.classList.add('hidden');
                lastExecutionOutput = '';
            }

            function displayOutput(content, isError = false) {
                if (!outputDiv || !outputContent) return;
                outputDiv.classList.remove('hidden');
                const sanitizedContent = content.toString()
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/\n/g, '<br>');
                const outputElement = document.createElement('div');
                outputElement.className = isError ? 'text-red-400' : 'text-emerald-400';
                outputElement.innerHTML = sanitizedContent;
                outputContent.appendChild(outputElement);
                outputContent.scrollTop = outputContent.scrollHeight;
                lastExecutionOutput = content.toString();
            }

            // Execute code function
            function executeCode() {
                if (!editor) {
                    console.error('Editor not initialized');
                    return;
                }

                const code = editor.getValue();
                clearOutput();

                const language = editor.getModel().getLanguageId();
                const endpoint = language === 'java' ? '/api/execute-java' : '/api/execute-python';

                fetch(endpoint, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    },
                    body: JSON.stringify({ code: code })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.error) {
                        displayOutput(data.error, true);
                    } else if (data.output) {
                        displayOutput(data.output);
                    } else {
                        displayOutput('No output received from execution');
                    }
                })
                .catch(error => {
                    displayOutput(`Error executing code: ${error.message}`, true);
                });
            }

            // Submit solution function
            function submitSolution() {
                // Check if we're in a coding challenge with an editor
                if (document.getElementById('monaco-editor-container')) {
                    if (!editor) {
                        console.error('Editor not initialized');
                        alert('Editor not initialized. Please try again in a moment.');
                        return;
                    }

                    const code = editor.getValue();
                    const currentOutput = lastExecutionOutput;
                    // Get the evaluation type directly from the task data
                    const evaluationType = '{{ $currentTask->evaluation_type ?? "manual" }}';
                    console.log('Current evaluation type:', evaluationType);
                    console.log('Current output:', currentOutput);

                    // Check for errors in the output
                    const hasErrors = currentOutput.includes('ERROR') ||
                                     currentOutput.toLowerCase().includes('error') ||
                                     currentOutput.includes('Exception') ||
                                     currentOutput.toLowerCase().includes('exception');

                    console.log('Has errors:', hasErrors);
                    console.log('Is exact match:', evaluationType === 'exact_match');

                    // Check if this is an Exact Match evaluation and if there's an error in the output
                    if (evaluationType === 'exact_match' && hasErrors) {
                        console.log('BLOCKING SUBMISSION: Exact match with errors detected');

                        clearOutput();
                        displayOutput('Cannot submit solution with errors. Please fix your code and run it again before submitting.', true);

                        // Show error message in the submission message container
                        const messageContainer = document.getElementById('submission-message');
                        const messageText = document.getElementById('message-text');

                        if (messageContainer && messageText) {
                            messageContainer.classList.remove('hidden');
                            messageContainer.classList.add('bg-red-500/10', 'border-red-500/20');
                            messageText.classList.add('text-red-400');
                            messageText.textContent = 'Cannot submit solution with errors. Please fix your code and run it again.';
                        }

                        return;
                    }

                    clearOutput();
                    displayOutput('Submitting solution...', false);

                    // Use the direct submission endpoint
                    fetch('/api/direct-text-solution', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    },
                    body: JSON.stringify({
                        task_id: {{ $currentTask->id }},
                        user_id:  {{ auth()->user()->id }},
                        student_answer: {
                            code: code,
                            output: currentOutput,
                            submitted_text: currentOutput // Store execution output in submitted_text
                        }
                    })
                })
                .then(response => {
                    const contentType = response.headers.get('content-type');
                    if (contentType && contentType.includes('application/json')) {
                        return response.json().then(data => {
                            if (!response.ok) {
                                throw new Error(`HTTP error! status: ${response.status}, message: ${data.message || 'Unknown error'}`);
                            }
                            return data;
                        });
                    } else {
                        return response.text().then(text => {
                            console.error('Received non-JSON response:', text.substring(0, 100) + '...');
                            throw new Error(`Received non-JSON response. You might need to log in or there's a server error.`);
                        });
                    }
                })
                .then(data => {
                    clearOutput();

                    if (data.success) {
                        if (data.is_correct) {
                            displayOutput('✅ Your answer is correct! Solution and Results are Correct.', false);
                        } else {
                            displayOutput('Solution submitted successfully.', false);
                        }

                        // Get the next task URL
                        const nextTaskUrl = '{{ $nextTask ? route("challenge.task", ["challenge" => $challenge, "task" => $nextTask]) : "" }}';

                        if (nextTaskUrl) {
                            displayOutput('Redirecting to Next Task...', false);
                            setTimeout(() => {
                                window.location.href = nextTaskUrl;
                            }, 1500);
                        } else {
                            // Redirect to the challenge page if there's no next task
                            displayOutput('Redirecting to Challenge Page...', false);
                            setTimeout(() => {
                                window.location.href = '{{ route("challenge", ["challenge" => $currentTask->challenge_id]) }}';
                            }, 1500);
                        }
                    } else {
                        displayOutput(data.message || 'Failed to submit solution', true);
                    }
                })
                .catch(error => {
                    clearOutput();
                    console.error('Submission error:', error);
                    displayOutput(`Error submitting solution. Please try again.`, true);
                    // No alert, just log the error
                });
                } else {
                    // Handle non-coding challenges (text input)
                    const answerInput = document.getElementById('answer-input');
                    if (!answerInput) {
                        console.error('Answer input not found');
                        // No alert, just log the error
                        return;
                    }

                    const submittedAnswer = answerInput.value.trim();

                    if (!submittedAnswer) {
                        console.error('Empty answer submitted');
                        // No alert, just log the error
                        return;
                    }

                    console.log('Submitting text answer:', submittedAnswer);

                    // Use the direct submission endpoint
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
                            // Show success message
                            const messageContainer = document.getElementById('submission-message');
                            const messageText = document.getElementById('message-text');

                            if (messageContainer && messageText) {
                                messageContainer.classList.remove('hidden');
                                messageContainer.classList.add('bg-emerald-500/10', 'border-emerald-500/20');
                                messageText.classList.add('text-emerald-400');
                                messageText.textContent = data.message;
                            }

                            // Redirect to challenge page after a short delay
                            setTimeout(() => {
                                window.location.href = '{{ route("challenge", ["challenge" => $currentTask->challenge_id]) }}';
                            }, 1500);
                        } else {
                            // Show error message
                            const messageContainer = document.getElementById('submission-message');
                            const messageText = document.getElementById('message-text');

                            if (messageContainer && messageText) {
                                messageContainer.classList.remove('hidden');
                                messageContainer.classList.add('bg-red-500/10', 'border-red-500/20');
                                messageText.classList.add('text-red-400');
                                messageText.textContent = data.message || 'Failed to submit answer';
                            }
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
                            messageText.textContent = 'Failed to submit answer. Please try again.';
                        }
                    });
                }
            }

            // Initialize Monaco editor directly (simpler approach than before)
            if (typeof require !== 'undefined') {
                require(['vs/editor/editor.main'], function() {
                    // Load language definitions explicitly
                    Promise.all([
                        // Load language definitions
                        monaco.languages.typescript.javascriptDefaults.setEagerModelSync(true),
                        // Load additional languages
                        require(['vs/basic-languages/php/php.contribution'], function() {}),
                        require(['vs/basic-languages/sql/sql.contribution'], function() {}),
                        require(['vs/basic-languages/java/java.contribution'], function() {}),
                        require(['vs/basic-languages/python/python.contribution'], function() {})
                    ]).then(() => {
                        console.log('Language definitions loaded');

                        // Create editor
                        try {
                            editor = monaco.editor.create(container, {
                                value: initialCode,
                                language: monacoLanguage,
                                theme: 'vs-dark',
                                automaticLayout: true,
                                minimap: { enabled: false },
                                scrollBeyondLastLine: false,
                                lineNumbers: 'on',
                                roundedSelection: true,
                                readOnly: false,
                                fontSize: 14,
                                lineHeight: 21,
                                scrollbar: {
                                    vertical: 'visible',
                                    horizontal: 'visible',
                                    useShadows: false,
                                    verticalHasArrows: true,
                                    horizontalHasArrows: true
                                }
                            });

                            // Hide loading indicator and show editor
                            if (loadingEl) loadingEl.style.display = 'none';
                            container.style.opacity = '1';

                            // Force layout update
                            setTimeout(() => editor.layout(), 100);

                            console.log('Monaco editor initialized successfully with language:', monacoLanguage);
                        } catch (error) {
                            console.error('Failed to initialize Monaco editor:', error);
                            if (loadingEl) {
                                loadingEl.innerHTML = `<div class="text-red-500 text-center p-4">Editor initialization failed: ${error.message}</div>`;
                            }
                        }
                    }).catch(err => {
                        console.error('Failed to load language definitions:', err);
                        if (loadingEl) {
                            loadingEl.innerHTML = `<div class="text-red-500 text-center p-4">Failed to load language definitions: ${err.message}</div>`;
                        }
                    });
                });
            } else {
                console.error('Monaco editor dependencies not loaded');
                if (loadingEl) {
                    loadingEl.innerHTML = '<div class="text-red-500 text-center p-4">Monaco editor dependencies not loaded</div>';
                }
            }

            // Add event listeners
            if (runBtn) runBtn.addEventListener('click', executeCode);
            if (submitBtn) submitBtn.addEventListener('click', submitSolution);
            if (clearOutputBtn) clearOutputBtn.addEventListener('click', clearOutput);

            // Make sure the submit button always uses our submitSolution function
            document.querySelectorAll('#submit-solution').forEach(btn => {
                // Remove any existing click listeners
                const newBtn = btn.cloneNode(true);
                btn.parentNode.replaceChild(newBtn, btn);

                // Add our submitSolution function
                newBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    submitSolution();
                });
            });

            // Handle window resize
            window.addEventListener('resize', function() {
                if (editor) editor.layout();
            });
        });

    </script>
</x-layouts.app>