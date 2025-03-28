<x-layouts.app>
    <head>
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
        </script>
    </head>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold text-white">{{ $challenge->name }}</h1>
            <div class="flex gap-4">
                <a href="{{ route('challenge', $challenge) }}" class="flex flex-col items-center justify-center p-4 rounded-xl border-2 border-emerald-500 bg-emerald-500/10 transition-all duration-300 hover:scale-[1.02] hover:shadow-lg hover:shadow-emerald-900/50 hover:bg-emerald-500/20 group">
                    <span class="text-lg font-semibold text-emerald-400 group-hover:text-emerald-300">Back to Challenge</span>
                </a>
            </div>
        </div>

        <div class="grid gap-4 grid-cols-1 md:grid-cols-2 h-full">
            <!-- Task Content -->
            <div class="flex flex-col p-6 rounded-xl border border-neutral-700 bg-neutral-800 h-full">
                <div class="space-y-6 flex-1">
                    <div class="space-y-4">
                        <div class="flex items-center gap-2">
                            <span class="px-3 py-1 text-sm font-medium text-emerald-400 bg-emerald-500/10 rounded-full">{{ $currentTask->points_reward ?? 0 }} Points</span>
                        </div>
                        <div>
                            <h4 class="font-medium text-white">Scenario</h4>
                            <p>{{ $challenge->challenge_content['scenario'] ?? 'No scenario available' }}</p>
                        </div>
                        <div>
                            <h4 class="font-medium text-white">Code with Bugs</h4>
                            <pre class="p-4 rounded-lg bg-neutral-900 text-neutral-300 font-mono text-sm whitespace-pre overflow-x-auto">{{ $challenge->challenge_content['buggy_code'] ?? 'No code available' }}</pre>
                        </div>
                        <div>
                            <h4 class="font-medium text-white">Current Behavior</h4>
                            <p>{{ $challenge->challenge_content['current_behavior'] ?? 'Not specified' }}</p>
                        </div>
                        <div>
                            <h4 class="font-medium text-white">Expected Behavior</h4>
                            <p>{{ $currentTask->description }}</p>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-white">Task Instructions</h3>
                        <div class="prose prose-invert max-w-none">
                            <div class="space-y-4">
                                <div class="p-4 rounded-lg bg-neutral-700/50">
                                    <h4 class="text-emerald-400 font-medium mb-2">Debug Process</h4>
                                    <ul class="list-disc list-inside space-y-2">
                                        <li>Review the code and identify the issue</li>
                                        <li>Test the code with different inputs</li>
                                        <li>Fix the bug with minimal changes</li>
                                        <li>Verify the solution works</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Code Editor -->
            <div class="flex flex-col p-6 rounded-xl border border-neutral-700 bg-neutral-800 h-full">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold text-white">Your Solution</h2>
                    <button id="run-code-btn" class="flex items-center justify-center p-2 rounded-xl bg-emerald-500 hover:bg-emerald-600 transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
                <div class="flex-1 relative min-h-[400px]" id="monaco-editor-container">
                    <div id="monaco-loading" class="absolute inset-0 flex items-center justify-center bg-neutral-900">
                        <div class="animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-emerald-400"></div>
                    </div>
                </div>
                <div id="code-output" class="mt-4 p-4 rounded-xl bg-neutral-900 border border-neutral-700 hidden">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-sm font-medium text-neutral-300">Execution Output</h3>
                        <button id="clear-output-btn" class="text-sm text-neutral-500 hover:text-neutral-400 transition-colors duration-300">
                            Clear
                        </button>
                    </div>
                    <div id="output-content" class="font-mono text-sm whitespace-pre-wrap break-words overflow-x-auto max-h-[200px] overflow-y-auto">
                        <!-- Output will be displayed here -->
                    </div>
                </div>
                <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <button id="submit-solution" class="w-full py-3 px-4 rounded-xl bg-emerald-500 hover:bg-emerald-600 transition-colors duration-300 text-white font-semibold text-center">
                        Submit Solution
                    </button>
                    @if($nextTask)
                        <a href="{{ route('challenge.task', ['challenge' => $challenge, 'task' => $nextTask]) }}" class="w-full py-3 px-4 rounded-xl bg-emerald-500 hover:bg-emerald-600 transition-colors duration-300 text-white font-semibold text-center">
                            Next Task
                        </a>
                    @else
                        <div class="w-full py-3 px-4 rounded-xl bg-neutral-700 text-neutral-400 font-semibold text-center cursor-not-allowed">
                            Last Task
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
                if (!editor) {
                    console.error('Editor not initialized');
                    return;
                }

                const code = editor.getValue();
                const currentOutput = lastExecutionOutput;

                clearOutput();
                displayOutput('Submitting solution...', false);

                fetch('/api/submit-solution', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    },
                    body: JSON.stringify({
                        task_id: {{ $currentTask->id }},
                        student_answer: {
                            code: code,
                            output: currentOutput
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
                            displayOutput('Redirecting to Challenge Page...', false);

                            if (data.redirect) {
                                setTimeout(() => {
                                    if (data.with_message) {
                                        const redirectUrl = new URL(data.redirect);
                                        const params = new URLSearchParams(redirectUrl.search);
                                        params.append('message', 'Task completed successfully!');
                                        redirectUrl.search = params.toString();
                                        window.location.href = redirectUrl.toString();
                                    } else {
                                        window.location.href = data.redirect;
                                    }
                                }, 3000);
                            }
                        } else {
                            displayOutput('❌ Your solution output doesn\'t match the expected result. Please try again.', true);
                        }
                    } else {
                        displayOutput(data.message || 'Failed to submit solution', true);
                    }
                })
                .catch(error => {
                    clearOutput();
                    console.error('Submission error:', error);
                    displayOutput(`Error submitting solution: ${error.message}`, true);
                });
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

            // Handle window resize
            window.addEventListener('resize', function() {
                if (editor) editor.layout();
            });
        });
    </script>
</x-layouts.app>
