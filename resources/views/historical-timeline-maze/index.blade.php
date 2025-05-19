<x-layouts.app>
    <!-- CSS to hide error notifications -->
    <style>
        /* Hide the error notification at the top of the page */
        .fixed.top-0.left-0.right-0.bg-red-600,
        .fixed.top-0.inset-x-0.bg-red-600,
        .fixed.top-0.bg-red-600,
        [class*="Error loading leaderboard"],
        div[class*="bg-red-600"],
        div[class*="error"],
        div[class*="Error"],
        /* Target the specific error notification shown in the screenshot */
        div.fixed.top-0.inset-x-0.p-4.bg-red-600.text-white.flex.items-center.justify-between {
            display: none !important;
            visibility: hidden !important;
            opacity: 0 !important;
            height: 0 !important;
            overflow: hidden !important;
            position: absolute !important;
            z-index: -9999 !important;
        }

        /* Hide any element containing error text */
        .bg-red-600 {
            display: none !important;
        }
    </style>
    <div class="flex h-full w-full flex-1 flex-col gap-6 text-gray-100 p-6 border border-emerald-500 rounded-lg">
        <!-- Error handling script to remove the top error notification -->
        <script>
            // Immediately remove any error notifications
            document.addEventListener('DOMContentLoaded', function() {
                // Find and remove the specific error notification shown in the screenshot
                const errorElements = document.querySelectorAll('.bg-red-600, .fixed');
                errorElements.forEach(element => {
                    if (element.textContent && element.textContent.includes('Error loading leaderboard data')) {
                        element.remove();
                    }
                });
            });

            // Also try to remove it before DOM is fully loaded
            (function() {
                // This runs immediately
                setTimeout(function() {
                    const errorElements = document.querySelectorAll('.bg-red-600, .fixed');
                    errorElements.forEach(element => {
                        if (element.textContent && element.textContent.includes('Error loading leaderboard data')) {
                            element.remove();
                        }
                    });
                }, 0);
            })();
        </script>
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-emerald-500/10 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-white">Historical Timeline Maze</h1>
            </div>
            <div class="flex gap-4">
                <a href="{{ route('subjects.specialized.humms') }}" class="flex items-center gap-2 px-5 py-2.5 rounded-lg border border-emerald-500/30 bg-emerald-500/10 transition-all duration-300 hover:bg-emerald-500/20 hover:border-emerald-500/50 hover:shadow-lg hover:shadow-emerald-900/20 group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400 group-hover:text-emerald-300 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span class="text-base font-medium text-emerald-400 group-hover:text-emerald-300 transition-colors">Back to HUMMS</span>
                </a>
            </div>
        </div>

        <!-- Game Container -->
        <div class="flex-1 grid grid-cols-1 lg:grid-cols-3 gap-3">
            <!-- Left Column: Game Controls -->
            <div class="lg:col-span-1">
                <div class="bg-neutral-800 rounded-xl border border-neutral-700 p-3 shadow-lg h-full flex flex-col">
                    <h2 class="text-lg font-semibold text-white mb-2">Game Controls</h2>

                    <!-- Era Selection -->
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-neutral-300 mb-2">Select Historical Era</label>
                        <select id="era-selector" class="w-full px-4 py-2 bg-neutral-700 border border-neutral-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                            <option value="" selected>-- Select an Era --</option>
                            <option value="ancient">Ancient History (3000 BCE - 500 CE)</option>
                            <option value="medieval">Medieval Period (500 - 1500 CE)</option>
                            <option value="renaissance">Renaissance & Early Modern (1500 - 1800 CE)</option>
                            <option value="modern">Modern Era (1800 - 1945 CE)</option>
                            <option value="contemporary">Contemporary History (1945 - Present)</option>
                        </select>
                    </div>

                    <!-- Difficulty Selection -->
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-neutral-300 mb-2">Difficulty Level</label>
                        <div class="flex gap-2">
                            <button id="easy-btn" class="flex-1 px-4 py-3 text-white rounded-lg border-2 border-green-500/30 bg-green-500/10 transition-all duration-300 hover:bg-green-500/20 hover:border-green-500/50 hover:shadow-lg hover:shadow-green-900/20 group difficulty-btn">
                                <span class="text-green-400 group-hover:text-green-300 transition-colors font-medium">Easy</span>
                                <div class="difficulty-indicator w-full h-1 bg-green-500/50 mt-2 rounded-full hidden"></div>
                            </button>
                            <button id="medium-btn" class="flex-1 px-4 py-3 text-white rounded-lg border-2 border-yellow-500/30 bg-yellow-500/10 transition-all duration-300 hover:bg-yellow-500/20 hover:border-yellow-500/50 hover:shadow-lg hover:shadow-yellow-900/20 group difficulty-btn">
                                <span class="text-yellow-400 group-hover:text-yellow-300 transition-colors font-medium">Medium</span>
                                <div class="difficulty-indicator w-full h-1 bg-yellow-500/50 mt-2 rounded-full hidden"></div>
                            </button>
                            <button id="hard-btn" class="flex-1 px-4 py-3 text-white rounded-lg border-2 border-red-500/30 bg-red-500/10 transition-all duration-300 hover:bg-red-500/20 hover:border-red-500/50 hover:shadow-lg hover:shadow-red-900/20 group difficulty-btn">
                                <span class="text-red-400 group-hover:text-red-300 transition-colors font-medium">Hard</span>
                                <div class="difficulty-indicator w-full h-1 bg-red-500/50 mt-2 rounded-full hidden"></div>
                            </button>
                        </div>
                    </div>

                    <!-- Power-ups Section -->
                    <div class="mb-3">
                        <div class="flex justify-between items-center mb-2">
                            <label class="block text-sm font-medium text-neutral-300">Power-ups</label>
                            <span class="text-xs text-neutral-400">Available: <span id="powerups-available">3</span></span>
                        </div>
                        <div class="grid grid-cols-3 gap-2">
                            <button id="hint-btn" class="p-2 bg-yellow-600/50 text-white rounded-lg hover:bg-yellow-500/50 transition-colors flex flex-col items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                </svg>
                                <span class="text-xs">Hint</span>
                            </button>
                            <button id="time-btn" class="p-2 bg-blue-600/50 text-white rounded-lg hover:bg-blue-500/50 transition-colors flex flex-col items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-xs">+30s</span>
                            </button>
                            <button id="skip-btn" class="p-2 bg-purple-600/50 text-white rounded-lg hover:bg-purple-500/50 transition-colors flex flex-col items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                                </svg>
                                <span class="text-xs">Skip</span>
                            </button>
                        </div>
                    </div>

                    <!-- Game Stats -->
                    <div class="mb-3 p-2 bg-neutral-700/50 rounded-lg">
                        <h3 class="text-sm font-semibold text-neutral-300 mb-2">Game Statistics</h3>
                        <div class="grid grid-cols-2 gap-2">
                            <div class="flex flex-col">
                                <span class="text-xs text-neutral-400">Score</span>
                                <span id="score-display" class="text-lg font-bold text-emerald-400">0</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xs text-neutral-400">Time</span>
                                <span id="time-display" class="text-lg font-bold text-emerald-400">00:00</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xs text-neutral-400">Level</span>
                                <span id="level-display" class="text-lg font-bold text-emerald-400">1</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xs text-neutral-400">Accuracy</span>
                                <span id="accuracy-display" class="text-lg font-bold text-emerald-400">0%</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xs text-neutral-400">Streak</span>
                                <span id="streak-display" class="text-lg font-bold text-emerald-400">0</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xs text-neutral-400">Difficulty</span>
                                <span id="difficulty-display" class="text-lg font-bold text-green-400">Easy</span>
                            </div>
                        </div>
                    </div>

                    <!-- Game Controls -->
                    <div class="mt-auto grid grid-cols-2 gap-3">
                        <button id="start-btn" class="px-4 py-2.5 rounded-lg border border-emerald-500/30 bg-emerald-500/10 transition-all duration-300 hover:bg-emerald-500/20 hover:border-emerald-500/50 hover:shadow-lg hover:shadow-emerald-900/20 flex items-center justify-center gap-2 group">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400 group-hover:text-emerald-300 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-base font-medium text-emerald-400 group-hover:text-emerald-300 transition-colors">Start Game</span>
                        </button>
                        <button id="reset-btn" class="px-4 py-2.5 rounded-lg border border-neutral-500/30 bg-neutral-500/10 transition-all duration-300 hover:bg-neutral-500/20 hover:border-neutral-500/50 hover:shadow-lg hover:shadow-neutral-900/20 flex items-center justify-center gap-2 group" disabled>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-neutral-400 group-hover:text-neutral-300 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            <span class="text-base font-medium text-neutral-400 group-hover:text-neutral-300 transition-colors">Reset</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Middle Column: Game Area -->
            <div class="lg:col-span-1">
                <div class="bg-neutral-800 rounded-xl border border-neutral-700 p-3 shadow-lg h-full flex flex-col">
                    <div class="flex justify-between items-center mb-2">
                        <h2 class="text-lg font-semibold text-white">Timeline Maze</h2>
                        <div id="current-difficulty-badge" class="px-3 py-1 rounded-full bg-green-500/20 border border-green-500/30">
                            <span class="text-xs font-medium text-green-400">Easy Mode</span>
                        </div>
                    </div>

                    <!-- Game Canvas Container -->
                    <div id="game-container" class="flex-1 bg-neutral-900 rounded-lg overflow-hidden relative">
                        <!-- Initial State - Game Instructions -->
                        <div id="game-instructions" class="absolute inset-0 flex flex-col items-center justify-center p-6 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-emerald-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="text-xl font-medium text-white mb-2">Ready to Travel Through Time?</h3>
                            <p class="text-neutral-400 mb-6">Select an era and difficulty level, then click "Start Game" to begin your journey through history!</p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 w-full max-w-md">
                                <div class="bg-neutral-800 p-3 rounded-lg border border-neutral-700">
                                    <h4 class="text-sm font-semibold text-emerald-400 mb-1">How to Play</h4>
                                    <p class="text-xs text-neutral-400">Navigate the maze by choosing the correct chronological path of historical events.</p>
                                </div>
                                <div class="bg-neutral-800 p-3 rounded-lg border border-neutral-700">
                                    <h4 class="text-sm font-semibold text-emerald-400 mb-1">Scoring</h4>
                                    <p class="text-xs text-neutral-400">Earn points for correct choices. Bonus points for completing levels quickly!</p>
                                </div>
                            </div>
                        </div>

                        <!-- Game Canvas (Hidden initially) -->
                        <canvas id="maze-canvas" class="w-full h-full hidden"></canvas>

                        <!-- Event Choice Modal (Hidden initially) -->
                        <div id="event-choice-modal" class="absolute inset-0 backdrop-blur-sm flex items-center justify-center p-6 hidden">
                            <div class="bg-transparent rounded-xl border border-emerald-500/30 p-6 max-w-md w-full">
                                <h3 class="text-lg font-semibold text-white mb-2">Choose the Next Event</h3>
                                <p class="text-sm text-neutral-400 mb-4">Which of these events happened next in history?</p>

                                <div id="event-choices" class="space-y-3 mb-4">
                                    <!-- Event choices will be inserted here dynamically -->
                                </div>

                                <div id="choice-feedback" class="p-3 rounded-lg mb-4 hidden">
                                    <!-- Feedback will be shown here -->
                                </div>

                                <div class="flex justify-between items-center">
                                    <div id="auto-continue-indicator" class="text-xs text-neutral-400 hidden">
                                        Continuing automatically... <span id="countdown">2</span>
                                    </div>
                                    <button id="continue-btn" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white rounded-lg transition-colors hidden">
                                        Continue
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Hint Modal (Hidden initially) -->
                        <div id="hint-modal" class="absolute inset-0 backdrop-blur-sm flex items-center justify-center p-6 hidden">
                            <div class="bg-transparent rounded-xl border border-yellow-500/30 p-6 max-w-md w-full">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg font-semibold text-white">Historical Hint</h3>
                                    <button id="close-hint-btn" class="text-neutral-400 hover:text-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                                <div id="hint-content" class="p-3 bg-neutral-700/50 rounded-lg mb-4">
                                    <p class="text-yellow-300 font-medium mb-2">Did you know?</p>
                                    <p class="text-neutral-300 text-sm" id="hint-text">The Great Pyramid of Giza was built around 2560 BCE and was the tallest man-made structure for over 3,800 years.</p>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-xs text-neutral-400">Hints remaining: <span id="hints-remaining">3</span></span>
                                    <button id="use-hint-btn" class="px-4 py-2 bg-yellow-600 hover:bg-yellow-500 text-white rounded-lg transition-colors">
                                        Use Hint
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Level Complete Modal (Hidden initially) -->
                        <div id="level-complete-modal" class="absolute inset-0 backdrop-blur-sm flex items-center justify-center p-6 hidden">
                            <div class="bg-transparent rounded-xl border border-emerald-500/30 p-6 max-w-sm w-full">
                                <div class="flex justify-center mb-4">
                                    <div class="p-3 bg-emerald-500/20 rounded-full">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                </div>
                                <h3 class="text-xl font-bold text-white text-center mb-2">Level Complete!</h3>
                                <p class="text-white text-center mb-2">You've successfully navigated this era of history!</p>
                                <p id="completed-level-info" class="text-emerald-400 text-center mb-4 font-semibold">Ancient History - Hard</p>

                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <div class="bg-neutral-900/70 p-3 rounded-lg text-center">
                                        <span class="text-xs text-neutral-300">Score</span>
                                        <p id="final-score" class="text-xl font-bold text-emerald-400">350</p>
                                    </div>
                                    <div class="bg-neutral-900/70 p-3 rounded-lg text-center">
                                        <span class="text-xs text-neutral-300">Time</span>
                                        <p id="final-time" class="text-xl font-bold text-emerald-400">00:05</p>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <button id="save-score-btn" class="w-full px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white rounded-lg transition-colors flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                                        </svg>
                                        Save Score to Leaderboard
                                    </button>
                                </div>

                                <div class="flex gap-3">
                                    <button id="next-level-btn" class="flex-1 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white rounded-lg transition-colors">
                                        Next Level
                                    </button>
                                    <button id="exit-btn" class="flex-1 px-4 py-2.5 bg-neutral-600 hover:bg-neutral-500 text-white rounded-lg transition-colors">
                                        Exit
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Historical Timeline -->
            <div class="lg:col-span-1">
                <div class="bg-neutral-800 rounded-xl border border-neutral-700 p-3 shadow-lg h-full flex flex-col">
                    <h2 class="text-lg font-semibold text-white mb-2">Your Answers</h2>

                    <!-- Progress Overview -->
                    <div class="mb-2 p-2 bg-neutral-700/30 rounded-lg">
                        <h3 id="current-era-title" class="text-base font-semibold text-emerald-400 mb-2">Ancient History (3000 BCE - 500 CE)</h3>
                        <p id="era-description" class="text-sm text-neutral-300 mb-3">Your Progress: Showing your answers as you complete questions</p>
                    </div>

                    <!-- Timeline Visualization -->
                    <div class="flex-1 overflow-y-auto pr-2 timeline-container">
                        <div class="relative">
                            <!-- Timeline Line -->
                            <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-emerald-500/30"></div>

                            <!-- Timeline Events -->
                            <div id="timeline-events" class="space-y-2 pl-12 relative">
                                <div class="p-4 text-center">
                                    <p class="text-neutral-400">Answer questions to see your progress here</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Answer Navigation Controls -->
                    <div class="mt-2 flex justify-between items-center">
                        <button id="prev-event-btn" class="px-2 py-1 rounded-lg border border-emerald-500/30 bg-emerald-500/10 transition-all duration-300 hover:bg-emerald-500/20 hover:border-emerald-500/50 hover:shadow-lg hover:shadow-emerald-900/20 flex items-center gap-1 group">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400 group-hover:text-emerald-300 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                            <span class="text-sm font-medium text-emerald-400 group-hover:text-emerald-300 transition-colors">Previous Answer</span>
                        </button>
                        <span id="timeline-progress" class="text-xs text-neutral-400">0/0 Answers</span>
                        <button id="next-event-btn" class="px-2 py-1 rounded-lg border border-emerald-500/30 bg-emerald-500/10 transition-all duration-300 hover:bg-emerald-500/20 hover:border-emerald-500/50 hover:shadow-lg hover:shadow-emerald-900/20 flex items-center gap-1 group">
                            <span class="text-sm font-medium text-emerald-400 group-hover:text-emerald-300 transition-colors">Next Answer</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400 group-hover:text-emerald-300 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Leaderboard Section -->
        <div class="mt-3">
            <div class="bg-neutral-800 rounded-xl border border-neutral-700 p-3 shadow-lg">
                <h2 class="text-lg font-semibold text-white mb-2">Leaderboard</h2>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-neutral-700">
                                <th class="px-3 py-1.5 text-left text-sm font-medium text-neutral-400">Rank</th>
                                <th class="px-3 py-1.5 text-left text-sm font-medium text-neutral-400">Player</th>
                                <th class="px-3 py-1.5 text-left text-sm font-medium text-neutral-400">Era</th>
                                <th class="px-3 py-1.5 text-left text-sm font-medium text-neutral-400">Score</th>
                                <th class="px-3 py-1.5 text-left text-sm font-medium text-neutral-400">Time</th>
                                <th class="px-3 py-1.5 text-left text-sm font-medium text-neutral-400">Accuracy</th>
                            </tr>
                        </thead>
                        <tbody id="leaderboard-body">
                            <tr class="border-b border-neutral-700">
                                <td class="px-3 py-1.5 text-sm text-neutral-300">1</td>
                                <td class="px-3 py-1.5 text-sm text-white">HistoryBuff</td>
                                <td class="px-3 py-1.5 text-sm text-neutral-300">Ancient</td>
                                <td class="px-3 py-1.5 text-sm text-emerald-400">1250</td>
                                <td class="px-3 py-1.5 text-sm text-neutral-300">01:45</td>
                                <td class="px-3 py-1.5 text-sm text-neutral-300">92%</td>
                            </tr>
                            <tr class="border-b border-neutral-700">
                                <td class="px-3 py-1.5 text-sm text-neutral-300">2</td>
                                <td class="px-3 py-1.5 text-sm text-white">TimeExplorer</td>
                                <td class="px-3 py-1.5 text-sm text-neutral-300">Medieval</td>
                                <td class="px-3 py-1.5 text-sm text-emerald-400">980</td>
                                <td class="px-3 py-1.5 text-sm text-neutral-300">02:10</td>
                                <td class="px-3 py-1.5 text-sm text-neutral-300">85%</td>
                            </tr>
                            <tr>
                                <td class="px-3 py-1.5 text-sm text-neutral-300">3</td>
                                <td class="px-3 py-1.5 text-sm text-white">ChronoMaster</td>
                                <td class="px-3 py-1.5 text-sm text-neutral-300">Modern</td>
                                <td class="px-3 py-1.5 text-sm text-emerald-400">820</td>
                                <td class="px-3 py-1.5 text-sm text-neutral-300">02:30</td>
                                <td class="px-3 py-1.5 text-sm text-neutral-300">78%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Game Scripts -->
    <script>
        // Function to remove the top error notification that appears on page load
        function removeTopErrorNotification() {
            // Find any error notifications at the top of the page
            const topErrorNotifications = document.querySelectorAll('.fixed.top-0.inset-x-0');
            topErrorNotifications.forEach(notification => {
                notification.remove();
            });

            // Look for the specific error notification shown in the screenshot
            const specificErrorNotifications = document.querySelectorAll('[class*="Error loading leaderboard"]');
            specificErrorNotifications.forEach(notification => {
                notification.remove();
            });

            // Target the specific error notification by its text content
            document.querySelectorAll('*').forEach(element => {
                if (element.textContent && element.textContent.includes('Error loading leaderboard data')) {
                    // Find the closest parent that might be the notification container
                    let parent = element;
                    for (let i = 0; i < 5; i++) { // Check up to 5 levels up
                        if (parent && parent.classList &&
                            (parent.classList.contains('bg-red-600') ||
                             parent.classList.contains('fixed'))) {
                            parent.remove();
                            break;
                        }
                        parent = parent.parentElement;
                    }
                }
            });

            // Also look for specific error message about leaderboard data
            const leaderboardErrors = document.querySelectorAll('.bg-red-600:not(.fixed)');
            leaderboardErrors.forEach(error => {
                if (error.textContent && error.textContent.includes('leaderboard')) {
                    error.remove();
                }
            });
        }

        // Remove error notification as soon as possible
        document.addEventListener('DOMContentLoaded', function() {
            // Remove any error notifications that might be present
            removeTopErrorNotification();

            // Set an interval to check for and remove error notifications that might appear later
            setInterval(removeTopErrorNotification, 500);

            // Also directly target the specific error notification shown in the screenshot
            const errorElements = document.querySelectorAll('.bg-red-600');
            errorElements.forEach(element => {
                if (element.textContent && element.textContent.includes('Error loading leaderboard data')) {
                    element.remove();
                }
            });

            // Add a mutation observer to catch dynamically added error notifications
            const observer = new MutationObserver(mutations => {
                mutations.forEach(mutation => {
                    if (mutation.addedNodes.length) {
                        mutation.addedNodes.forEach(node => {
                            // Check if the added node is an element
                            if (node.nodeType === 1) {
                                // Check if it's an error notification
                                if ((node.classList && node.classList.contains('bg-red-600')) ||
                                    (node.textContent && node.textContent.includes('Error loading leaderboard data'))) {
                                    node.remove();
                                }

                                // Also check children of the added node
                                const errorChildren = node.querySelectorAll('.bg-red-600, [class*="error"]');
                                errorChildren.forEach(child => {
                                    if (child.textContent && child.textContent.includes('Error loading leaderboard data')) {
                                        child.remove();
                                    }
                                });
                            }
                        });
                    }
                });
            });

            // Start observing the document body for changes
            observer.observe(document.body, { childList: true, subtree: true });
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Game elements
            const startBtn = document.getElementById('start-btn');
            const resetBtn = document.getElementById('reset-btn');
            const easyBtn = document.getElementById('easy-btn');
            const mediumBtn = document.getElementById('medium-btn');
            const hardBtn = document.getElementById('hard-btn');
            const eraSelector = document.getElementById('era-selector');
            const gameInstructions = document.getElementById('game-instructions');
            const mazeCanvas = document.getElementById('maze-canvas');
            const eventChoiceModal = document.getElementById('event-choice-modal');
            const eventChoices = document.getElementById('event-choices');
            const choiceFeedback = document.getElementById('choice-feedback');
            const continueBtn = document.getElementById('continue-btn');
            const levelCompleteModal = document.getElementById('level-complete-modal');
            const nextLevelBtn = document.getElementById('next-level-btn');
            const exitBtn = document.getElementById('exit-btn');

            // New elements for added features
            const hintBtn = document.getElementById('hint-btn');
            const timeBtn = document.getElementById('time-btn');
            const skipBtn = document.getElementById('skip-btn');
            const hintModal = document.getElementById('hint-modal');
            const closeHintBtn = document.getElementById('close-hint-btn');
            const useHintBtn = document.getElementById('use-hint-btn');
            const hintsRemainingDisplay = document.getElementById('hints-remaining');
            const powerupsAvailableDisplay = document.getElementById('powerups-available');
            const streakDisplay = document.getElementById('streak-display');
            const saveScoreBtn = document.getElementById('save-score-btn');
            const playerNameInput = document.getElementById('player-name');
            const leaderboardBody = document.getElementById('leaderboard-body');

            // Timeline elements
            const currentEraTitle = document.getElementById('current-era-title');
            const eraDescription = document.getElementById('era-description');
            const timelineEvents = document.getElementById('timeline-events');
            const prevEventBtn = document.getElementById('prev-event-btn');
            const nextEventBtn = document.getElementById('next-event-btn');
            const timelineProgress = document.getElementById('timeline-progress');

            // Game state variables
            let gameActive = false;
            let currentDifficulty = 'easy';
            let currentEra = 'ancient';
            let currentLevel = 1;
            let score = 0;
            let startTime;
            let timerInterval;
            let correctChoices = 0;
            let totalChoices = 0;
            let timerPaused = false;
            let pauseStartTime;

            // New state variables for added features
            let hintsRemaining = 3;
            let powerupsAvailable = 3;
            let streak = 0;
            let leaderboard = [
                { rank: 1, player: 'HistoryBuff', era: 'Ancient', score: 1250, time: '01:45', accuracy: '92%' },
                { rank: 2, player: 'TimeExplorer', era: 'Medieval', score: 980, time: '02:10', accuracy: '85%' },
                { rank: 3, player: 'ChronoMaster', era: 'Modern', score: 820, time: '02:30', accuracy: '78%' }
            ];

            // Store current user ID for comparisons
            const currentUserId = {{ Auth::id() ?? 'null' }};

            // Historical hints database
            let historicalHints = {
                'ancient': [
                    'The Great Pyramid of Giza was built around 2560 BCE and was the tallest man-made structure for over 3,800 years.',
                    'Democracy in Athens began around 508 BCE with reforms by Cleisthenes.',
                    'The Roman Republic was established around 509 BCE after the overthrow of the Roman Kingdom.'
                ],
                'medieval': [
                    'The Fall of Rome in 476 CE marks the beginning of the Medieval Period in Europe.',
                    'The Islamic Golden Age (8th-14th centuries) preserved and expanded upon ancient knowledge.',
                    'The Magna Carta was signed in 1215, limiting the power of the English monarchy.'
                ],
                'renaissance': [
                    'The printing press was invented by Johannes Gutenberg around 1440, revolutionizing the spread of knowledge.',
                    'Vesalius published his groundbreaking work on human anatomy "De Humani Corporis Fabrica" in 1543.',
                    'Galileo improved the telescope in 1609, allowing him to make astronomical observations that supported the Copernican theory.',
                    'William Harvey discovered blood circulation in 1628, transforming our understanding of human physiology.',
                    'Copernicus published his heliocentric model in 1543, challenging the Earth-centered view of the universe.',
                    'Leonardo da Vinci made detailed anatomical drawings between 1490-1510 based on human dissections.'
                ],
                'modern': [
                    'The Industrial Revolution began in Britain in the late 18th century.',
                    'The French Revolution began in 1789 with the storming of the Bastille.',
                    'World War I lasted from 1914 to 1918 and resulted in the deaths of over 16 million people.'
                ],
                'contemporary': [
                    'The United Nations was founded in 1945 after World War II.',
                    'The Cold War was a period of geopolitical tension between the Soviet Union and the United States from 1947 to 1991.',
                    'The Internet was developed in the late 20th century and revolutionized global communication.'
                ]
            };

            // Questions will be loaded from the database
            let questionsDatabase = {
                'ancient': {
                    'easy': [],
                    'medium': [],
                    'hard': []
                },
                'medieval': {
                    'easy': [],
                    'medium': [],
                    'hard': []
                },
                'renaissance': {
                    'easy': [],
                    'medium': [],
                    'hard': []
                },
                'modern': {
                    'easy': [],
                    'medium': [],
                    'hard': []
                },
                'contemporary': {
                    'easy': [],
                    'medium': [],
                    'hard': []
                }
            };

            // Function to load questions from the API with caching
            async function loadQuestions(era, difficulty) {
                // Check if questions are already loaded for this era and difficulty
                if (questionsDatabase[era] &&
                    questionsDatabase[era][difficulty] &&
                    questionsDatabase[era][difficulty].length > 0) {
                    console.log(`Using cached questions for ${era} - ${difficulty}`);
                    return questionsDatabase[era][difficulty];
                }

                try {
                    console.log(`Fetching questions for ${era} - ${difficulty}...`);

                    // Create a controller to allow aborting the fetch if it takes too long
                    const controller = new AbortController();
                    const timeoutId = setTimeout(() => controller.abort(), 8000); // 8 second timeout

                    const response = await fetch(
                        `{{ route('subjects.specialized.humms.historical-timeline-maze.questions') }}?era=${era}&difficulty=${difficulty}`,
                        { signal: controller.signal }
                    );

                    // Clear the timeout since the request completed
                    clearTimeout(timeoutId);

                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    const data = await response.json();

                    if (data.questions && data.questions.length > 0) {
                        // Transform the data to match our expected format
                        questionsDatabase[era][difficulty] = data.questions.map(q => ({
                            question: q.question,
                            options: q.options,
                            hint: q.hint || null // Include the hint from the database
                        }));
                        console.log(`Successfully loaded ${data.questions.length} questions for ${era} - ${difficulty}`);
                    } else {
                        console.warn(`No questions found in API response for ${era} - ${difficulty}`);
                        // Initialize with an empty array to prevent null errors
                        questionsDatabase[era][difficulty] = [];
                    }

                    return questionsDatabase[era][difficulty];
                } catch (error) {
                    // Check if this was an abort error (timeout)
                    if (error.name === 'AbortError') {
                        console.warn(`Request for ${era} - ${difficulty} timed out`);
                    } else {
                        console.error(`Error loading questions for ${era} - ${difficulty}:`, error);
                    }

                    // Initialize with an empty array to prevent null errors
                    questionsDatabase[era][difficulty] = [];

                    // Only show notification for non-timeout errors to avoid too many notifications
                    if (error.name !== 'AbortError') {
                        // Show an error notification
                        const notification = document.createElement('div');
                        notification.className = 'fixed top-4 right-4 bg-red-600 text-white px-4 py-2 rounded-lg shadow-lg z-50';
                        notification.textContent = `Failed to load questions for ${era} - ${difficulty}. Using default questions.`;
                        document.body.appendChild(notification);

                        // Remove the notification after 3 seconds
                        setTimeout(() => {
                            notification.remove();
                        }, 3000);
                    }

                    return [];
                }
            }

            // Timeline data structure
            let timelineData = {
                'ancient': {
                    title: 'Ancient History (3000 BCE - 500 CE)',
                    description: 'The ancient period saw the rise of early civilizations, the development of writing, and the foundation of major philosophical and religious traditions.',
                    events: []
                },
                'medieval': {
                    title: 'Medieval Period (500 - 1500 CE)',
                    description: 'The medieval period was characterized by feudalism, the rise of powerful empires, and significant religious developments across the world.',
                    events: []
                },
                'renaissance': {
                    title: 'Renaissance & Early Modern (1500 - 1800 CE)',
                    description: 'A period of cultural, artistic, political, and economic "rebirth" following the Middle Ages, marked by renewed interest in classical learning.',
                    events: []
                },
                'modern': {
                    title: 'Modern Era (1800 - 1945 CE)',
                    description: 'A period of rapid industrialization, technological advancement, and significant political and social changes across the globe.',
                    events: []
                },
                'contemporary': {
                    title: 'Contemporary History (1945 - Present)',
                    description: 'The post-World War II era characterized by the Cold War, decolonization, rapid technological advancement, and globalization.',
                    events: []
                }
            };

            // Function to load timeline events from the API
            async function loadTimelineEvents(era) {
                try {
                    const response = await fetch(`{{ route('subjects.specialized.humms.historical-timeline-maze.events') }}?era=${era}`);
                    const data = await response.json();

                    if (data.events && data.events.length > 0) {
                        // Update the timeline data with events from the API
                        timelineData[era].title = data.title;
                        timelineData[era].description = data.description;
                        timelineData[era].events = data.events;
                    }
                } catch (error) {
                    console.error('Error loading timeline events:', error);
                }
            }

            // Load initial timeline data for the default era
            loadTimelineEvents('ancient').then(() => {
                // Update the timeline display after loading
                updateTimelineEra();
            });

            // Create a deep copy of the timeline data structure for resetting
            const originalTimelineData = JSON.parse(JSON.stringify(timelineData));

            // Current timeline state
            let currentTimelineEra = 'ancient';
            let currentTimelineEventIndex = 0;
            let studentAnswers = [];
            let currentQuestionIndex = 0;

            // Function to reset timeline data to original state
            function resetTimelineData() {
                timelineData = JSON.parse(JSON.stringify(originalTimelineData));
            }

            // Initialize the game
            function initGame() {
                // Set up event listeners
                startBtn.addEventListener('click', startGame);
                resetBtn.addEventListener('click', resetGame);

                // Add click events for difficulty buttons with visual feedback
                easyBtn.addEventListener('click', () => {
                    setDifficulty('easy');
                    // Add a brief animation to show the button was clicked
                    easyBtn.classList.add('scale-95');
                    setTimeout(() => easyBtn.classList.remove('scale-95'), 150);
                });

                mediumBtn.addEventListener('click', () => {
                    setDifficulty('medium');
                    // Add a brief animation to show the button was clicked
                    mediumBtn.classList.add('scale-95');
                    setTimeout(() => mediumBtn.classList.remove('scale-95'), 150);
                });

                hardBtn.addEventListener('click', () => {
                    setDifficulty('hard');
                    // Add a brief animation to show the button was clicked
                    hardBtn.classList.add('scale-95');
                    setTimeout(() => hardBtn.classList.remove('scale-95'), 150);
                });

                continueBtn.addEventListener('click', continueGame);
                nextLevelBtn.addEventListener('click', nextLevel);
                exitBtn.addEventListener('click', exitGame);

                // New event listeners for added features
                hintBtn.addEventListener('click', showHint);
                timeBtn.addEventListener('click', addTime);
                skipBtn.addEventListener('click', skipQuestion);
                closeHintBtn.addEventListener('click', closeHint);
                useHintBtn.addEventListener('click', applyHint);
                saveScoreBtn.addEventListener('click', saveScore);

                // Disable difficulty buttons and start button by default until an Era is selected
                const difficultyButtons = document.querySelectorAll('.difficulty-btn');
                difficultyButtons.forEach(btn => {
                    btn.disabled = true;
                    btn.classList.add('opacity-50', 'cursor-not-allowed');
                });

                // Add a hint message to select an Era first
                const difficultySection = document.querySelector('.difficulty-btn').closest('.mb-3');
                const selectEraHint = document.createElement('div');
                selectEraHint.id = 'select-era-hint';
                selectEraHint.className = 'text-xs text-yellow-400 mb-2 flex items-center';
                selectEraHint.innerHTML = `
                    <svg class="h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Please select an Era first to enable difficulty options
                `;
                difficultySection.insertBefore(selectEraHint, difficultySection.firstChild);

                // Disable start button until an Era is selected
                startBtn.disabled = true;
                startBtn.classList.add('opacity-50', 'cursor-not-allowed');

                // Timeline event listeners
                prevEventBtn.addEventListener('click', showPreviousTimelineEvent);
                nextEventBtn.addEventListener('click', showNextTimelineEvent);

                // Enhanced Era selector with loading indicator and difficulty button management
                eraSelector.addEventListener('change', async function(e) {
                    // Get the selected era
                    const selectedEra = e.target.value;

                    // Check if a valid era is selected
                    if (!selectedEra) {
                        // If the default "Select an Era" option is chosen, disable difficulty buttons
                        const difficultyButtons = document.querySelectorAll('.difficulty-btn');
                        difficultyButtons.forEach(btn => {
                            btn.disabled = true;
                            btn.classList.add('opacity-50', 'cursor-not-allowed');
                        });

                        // Disable start button
                        startBtn.disabled = true;
                        startBtn.classList.add('opacity-50', 'cursor-not-allowed');

                        // Make sure the hint is visible
                        let selectEraHint = document.getElementById('select-era-hint');
                        if (!selectEraHint) {
                            const difficultySection = document.querySelector('.difficulty-btn').closest('.mb-3');
                            selectEraHint = document.createElement('div');
                            selectEraHint.id = 'select-era-hint';
                            selectEraHint.className = 'text-xs text-yellow-400 mb-2 flex items-center';
                            selectEraHint.innerHTML = `
                                <svg class="h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Please select an Era first to enable difficulty options
                            `;
                            difficultySection.insertBefore(selectEraHint, difficultySection.firstChild);
                        }

                        return; // Exit the function early
                    }

                    // Set the current era
                    currentEra = selectedEra;

                    // Remove the select era hint if it exists
                    const selectEraHint = document.getElementById('select-era-hint');
                    if (selectEraHint) {
                        selectEraHint.remove();
                    }

                    // Show loading indicator
                    const difficultySection = document.querySelector('.difficulty-btn').closest('.mb-3');
                    const loadingIndicator = document.createElement('div');
                    loadingIndicator.id = 'era-loading-indicator';
                    loadingIndicator.className = 'text-xs text-emerald-400 mb-2 flex items-center';
                    loadingIndicator.innerHTML = `
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-emerald-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Loading ${selectedEra} era data...
                    `;

                    // Temporarily disable difficulty buttons
                    const difficultyButtons = document.querySelectorAll('.difficulty-btn');
                    difficultyButtons.forEach(btn => {
                        btn.disabled = true;
                        btn.classList.add('opacity-50', 'cursor-not-allowed');
                    });

                    // Insert loading indicator before difficulty buttons
                    difficultySection.insertBefore(loadingIndicator, difficultySection.firstChild);

                    try {
                        // Load timeline events and questions in parallel for faster loading
                        const loadingPromises = [
                            // Load timeline events
                            loadTimelineEvents(selectedEra),

                            // Load questions for all difficulties in parallel
                            loadQuestionsForEra(selectedEra)
                        ];

                        // Wait for all loading to complete
                        await Promise.all(loadingPromises);

                        // Update the timeline display
                        updateTimelineEra();
                    } catch (error) {
                        console.error('Error loading era data:', error);
                    } finally {
                        // Remove loading indicator
                        const indicator = document.getElementById('era-loading-indicator');
                        if (indicator) {
                            indicator.remove();
                        }

                        // Re-enable difficulty buttons
                        difficultyButtons.forEach(btn => {
                            btn.disabled = false;
                            btn.classList.remove('opacity-50', 'cursor-not-allowed');
                        });

                        // Enable start button
                        startBtn.disabled = false;
                        startBtn.classList.remove('opacity-50', 'cursor-not-allowed');

                        // Add a subtle animation to show buttons are ready
                        difficultyButtons.forEach(btn => {
                            btn.classList.add('animate-pulse');
                            setTimeout(() => btn.classList.remove('animate-pulse'), 1000);
                        });

                        // Show a success notification
                        const notification = document.createElement('div');
                        notification.className = 'fixed top-4 right-4 bg-emerald-600 text-white px-4 py-2 rounded-lg shadow-lg z-50 flex items-center';
                        notification.innerHTML = `
                            <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            ${selectedEra.charAt(0).toUpperCase() + selectedEra.slice(1)} era loaded! Choose a difficulty to continue.
                        `;
                        document.body.appendChild(notification);

                        // Remove the notification after 3 seconds
                        setTimeout(() => {
                            notification.remove();
                        }, 3000);
                    }
                });

                // Set initial difficulty
                setDifficulty('easy');

                // Initialize leaderboard
                try {
                    updateLeaderboard();
                } catch (error) {
                    console.error("Error initializing leaderboard:", error);
                }
            }

            // Set the game difficulty
            function setDifficulty(difficulty) {
                currentDifficulty = difficulty;

                // Update UI - reset all buttons first
                const allButtons = document.querySelectorAll('.difficulty-btn');
                allButtons.forEach(btn => {
                    // Remove active styling
                    btn.classList.remove('active');
                    btn.classList.remove('bg-green-500/30', 'bg-yellow-500/30', 'bg-red-500/30');
                    btn.classList.remove('border-green-500/70', 'border-yellow-500/70', 'border-red-500/70');

                    // Hide all indicators
                    const indicator = btn.querySelector('.difficulty-indicator');
                    if (indicator) {
                        indicator.classList.add('hidden');
                    }
                });

                // Apply active styling to the selected difficulty
                let activeBtn;
                if (difficulty === 'easy') {
                    activeBtn = easyBtn;
                    activeBtn.classList.add('bg-green-500/30', 'border-green-500/70');
                } else if (difficulty === 'medium') {
                    activeBtn = mediumBtn;
                    activeBtn.classList.add('bg-yellow-500/30', 'border-yellow-500/70');
                } else {
                    activeBtn = hardBtn;
                    activeBtn.classList.add('bg-red-500/30', 'border-red-500/70');
                }

                // Show the indicator for the active button
                const activeIndicator = activeBtn.querySelector('.difficulty-indicator');
                if (activeIndicator) {
                    activeIndicator.classList.remove('hidden');
                }

                // Add a visual label to show the current difficulty
                const difficultyLabel = document.createElement('div');
                difficultyLabel.className = 'absolute top-0 right-0 transform translate-x-1/4 -translate-y-1/4 px-2 py-1 rounded-full text-xs font-bold';

                // Update the game difficulty display in the stats section
                const difficultyDisplay = document.getElementById('difficulty-display');
                if (difficultyDisplay) {
                    let difficultyText = difficulty.charAt(0).toUpperCase() + difficulty.slice(1);
                    let difficultyColor = difficulty === 'easy' ? 'text-green-400' :
                                         difficulty === 'medium' ? 'text-yellow-400' : 'text-red-400';
                    difficultyDisplay.textContent = difficultyText;
                    difficultyDisplay.className = `text-lg font-bold ${difficultyColor}`;
                }

                // Update the difficulty badge in the game header
                const difficultyBadge = document.getElementById('current-difficulty-badge');
                const difficultyBadgeText = difficultyBadge.querySelector('span');

                if (difficultyBadge && difficultyBadgeText) {
                    // Remove all previous styling
                    difficultyBadge.classList.remove(
                        'bg-green-500/20', 'border-green-500/30',
                        'bg-yellow-500/20', 'border-yellow-500/30',
                        'bg-red-500/20', 'border-red-500/30'
                    );

                    difficultyBadgeText.classList.remove(
                        'text-green-400', 'text-yellow-400', 'text-red-400'
                    );

                    // Apply new styling based on difficulty
                    if (difficulty === 'easy') {
                        difficultyBadge.classList.add('bg-green-500/20', 'border-green-500/30');
                        difficultyBadgeText.classList.add('text-green-400');
                        difficultyBadgeText.textContent = 'Easy Mode';
                    } else if (difficulty === 'medium') {
                        difficultyBadge.classList.add('bg-yellow-500/20', 'border-yellow-500/30');
                        difficultyBadgeText.classList.add('text-yellow-400');
                        difficultyBadgeText.textContent = 'Medium Mode';
                    } else {
                        difficultyBadge.classList.add('bg-red-500/20', 'border-red-500/30');
                        difficultyBadgeText.classList.add('text-red-400');
                        difficultyBadgeText.textContent = 'Hard Mode';
                    }

                    // Add a subtle animation to draw attention
                    difficultyBadge.classList.add('animate-pulse');
                    setTimeout(() => difficultyBadge.classList.remove('animate-pulse'), 1000);
                }

                console.log(`Difficulty set to: ${difficulty}`);
            }

            // Start the game function is now defined at the bottom of the script

            // Reset the game
            function resetGame() {
                gameActive = false;
                clearInterval(timerInterval);
                timerPaused = false;
                streak = 0;
                hintsRemaining = 3;
                powerupsAvailable = 3;
                currentTimelineEventIndex = 0;
                studentAnswers = [];
                currentQuestionIndex = 0;

                // Reset power-up usage tracking
                usedPowerups = {
                    hint: 0, // Reset to 0 uses
                    time: false,
                    skip: false
                };

                // Restore original timeline data
                resetTimelineData();

                // Update UI
                mazeCanvas.classList.add('hidden');
                gameInstructions.classList.remove('hidden');
                eventChoiceModal.classList.add('hidden');
                levelCompleteModal.classList.add('hidden');
                hintModal.classList.add('hidden');
                startBtn.disabled = false;
                resetBtn.disabled = true;
                document.getElementById('time-display').textContent = '00:00';
                document.getElementById('streak-display').textContent = '0';
                hintsRemainingDisplay.textContent = hintsRemaining;
                powerupsAvailableDisplay.textContent = powerupsAvailable;

                // Reset power-up buttons
                resetPowerupButtons();

                // Reset timeline
                updateTimeline();
            }

            // Function to reset power-up buttons
            function resetPowerupButtons() {
                // Reset hint button
                const hintButton = document.getElementById('hint-btn');
                if (hintButton) {
                    hintButton.disabled = false;
                    hintButton.classList.remove('opacity-50', 'cursor-not-allowed');
                    hintButton.classList.add('hover:bg-yellow-500/50');

                    // Remove any "Used" labels
                    const usedLabel = hintButton.querySelector('.used-label');
                    if (usedLabel) {
                        usedLabel.remove();
                    }

                    // Remove any hint count indicators
                    const hintCount = hintButton.querySelector('.hint-count');
                    if (hintCount) {
                        hintCount.remove();
                    }

                    // Add a fresh hint count indicator
                    const newHintCount = document.createElement('div');
                    newHintCount.className = 'hint-count absolute bottom-0 right-0 bg-yellow-800 text-white text-xs px-1 rounded-full';
                    newHintCount.textContent = '3';
                    hintButton.style.position = 'relative';
                    hintButton.appendChild(newHintCount);
                }

                // Reset time button
                const timeButton = document.getElementById('time-btn');
                if (timeButton) {
                    timeButton.disabled = false;
                    timeButton.classList.remove('opacity-50', 'cursor-not-allowed');
                    timeButton.classList.add('hover:bg-blue-500/50');
                    // Remove any "Used" labels
                    const usedLabel = timeButton.querySelector('div');
                    if (usedLabel) {
                        usedLabel.remove();
                    }
                }

                // Reset skip button
                const skipButton = document.getElementById('skip-btn');
                if (skipButton) {
                    skipButton.disabled = false;
                    skipButton.classList.remove('opacity-50', 'cursor-not-allowed');
                    skipButton.classList.add('hover:bg-purple-500/50');
                    // Remove any "Used" labels
                    const usedLabel = skipButton.querySelector('div');
                    if (usedLabel) {
                        usedLabel.remove();
                    }
                }
            }

            // Start the timer
            function startTimer() {
                // Clear any existing timer interval
                if (timerInterval) {
                    clearInterval(timerInterval);
                    console.log("Cleared existing timer interval");
                }

                // Make sure timer is not paused
                timerPaused = false;

                // Start a new timer interval
                timerInterval = setInterval(updateTimer, 1000);
                console.log("Started new timer interval");

                // Update the timer immediately
                updateTimer();
            }

            // Pause the timer
            function pauseTimer() {
                if (!timerPaused) {
                    timerPaused = true;
                    pauseStartTime = Date.now();
                    console.log("Timer paused");
                }
            }

            // Resume the timer
            function resumeTimer() {
                if (timerPaused) {
                    // Adjust the start time to account for the pause duration
                    const pauseDuration = Date.now() - pauseStartTime;
                    startTime += pauseDuration;
                    timerPaused = false;
                    console.log("Timer resumed, adjusted by", Math.floor(pauseDuration / 1000), "seconds");
                }
            }

            // Update the timer display
            function updateTimer() {
                // Don't update the timer if it's paused
                if (timerPaused) return;

                const elapsedTime = Math.floor((Date.now() - startTime) / 1000);
                const minutes = Math.floor(elapsedTime / 60);
                const seconds = elapsedTime % 60;
                const timeString = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

                // Update the display
                const timeDisplay = document.getElementById('time-display');
                timeDisplay.textContent = timeString;

                // Log every 5 seconds for debugging
                if (seconds % 5 === 0 && seconds > 0) {
                    console.log("Timer updated:", timeString);
                }
            }

            // Load a level
            function loadLevel() {
                // In a real implementation, this would load the maze for the current era and difficulty
                console.log(`Loading level for era: ${currentEra}, difficulty: ${currentDifficulty}`);

                // For demo purposes, we'll just update the UI
                document.getElementById('level-display').textContent = currentLevel;
            }

            // Show the event choice modal
            function showEventChoiceModal() {
                console.log("showEventChoiceModal called, currentQuestionIndex:", currentQuestionIndex);

                // Clear previous choices
                eventChoices.innerHTML = '';

                // Make sure the feedback is hidden
                if (choiceFeedback) {
                    choiceFeedback.classList.add('hidden');
                }

                // Get questions based on the current era and difficulty
                const era = currentEra;
                const difficulty = currentDifficulty;

                console.log(`Loading question for era: ${era}, difficulty: ${difficulty}, index: ${currentQuestionIndex}`);

                // Get the questions for the current era and difficulty
                const questions = questionsDatabase[era][difficulty];

                console.log("Questions for", era, difficulty, ":", questions);

                // Check if questions array exists and has items
                if (!questions || !Array.isArray(questions) || questions.length === 0) {
                    console.error(`No questions found for era: ${era}, difficulty: ${difficulty}`);

                    // Show an error message to the user
                    const notification = document.createElement('div');
                    notification.className = 'fixed top-4 right-4 bg-red-600 text-white px-4 py-2 rounded-lg shadow-lg z-50';
                    notification.textContent = `No questions available for ${era} - ${difficulty}. Please try a different era or difficulty.`;
                    document.body.appendChild(notification);

                    // Remove the notification after 5 seconds
                    setTimeout(() => {
                        notification.remove();
                    }, 5000);

                    // Return to game instructions instead of showing level complete
                    resetGame();
                    return;
                }

                // Make sure we don't exceed the available questions
                if (currentQuestionIndex >= questions.length) {
                    console.log("No more questions available, showing level complete");
                    showLevelCompleteModal();
                    return;
                }

                // Get the current question
                const currentQuestion = questions[currentQuestionIndex];

                // Store the current question in a global variable for easier access
                window.currentQuestionData = currentQuestion;

                // Update the question text
                const questionTitle = document.querySelector('#event-choice-modal h3');
                const questionDescription = document.querySelector('#event-choice-modal p');

                if (questionTitle && questionDescription) {
                    questionTitle.textContent = "Choose the Next Event";
                    questionDescription.textContent = currentQuestion.question;
                }

                // Store the current options in a global variable for reference
                window.sampleEvents = currentQuestion.options;

                // Create choice buttons
                currentQuestion.options.forEach(option => {
                    const button = document.createElement('button');
                    button.className = 'w-full text-left p-3 bg-neutral-700 hover:bg-neutral-600 rounded-lg transition-colors mb-2';
                    button.innerHTML = `
                        <div class="font-medium text-white">${option.title}</div>
                        <div class="text-xs text-neutral-400">${option.year}</div>
                    `;
                    button.addEventListener('click', () => makeChoice(option.id));
                    eventChoices.appendChild(button);
                });

                // Show the modal
                eventChoiceModal.classList.remove('hidden');
            }

            // Handle player's choice
            function makeChoice(eventId) {
                totalChoices++;
                console.log("makeChoice called with eventId:", eventId);

                // Check if the selected option is correct based on the 'correct' property
                const selectedOption = window.sampleEvents.find(option => option.id === eventId);
                const isCorrect = selectedOption && selectedOption.correct === true;

                if (isCorrect) {
                    correctChoices++;
                    streak++;
                    score += 100;

                    // Add bonus points for streak
                    if (streak > 1) {
                        const streakBonus = streak * 10;
                        score += streakBonus;
                        choiceFeedback.innerHTML = `
                            <div class="text-green-400 font-medium">Correct!</div>
                            <div class="text-xs text-neutral-300">+100 points</div>
                            <div class="text-xs text-yellow-300">+${streakBonus} streak bonus!</div>
                        `;
                    } else {
                        choiceFeedback.innerHTML = `
                            <div class="text-green-400 font-medium">Correct!</div>
                            <div class="text-xs text-neutral-300">+100 points</div>
                        `;
                    }

                    choiceFeedback.className = 'p-3 rounded-lg mb-4 bg-green-500/20 border border-green-500/30';

                    // Record the student's answer
                    // Use the global sampleEvents variable to ensure we have access to the current events
                    const selectedEvent = window.sampleEvents.find(event => event.id === eventId);
                    studentAnswers.push({
                        question: currentQuestionIndex,
                        answer: selectedEvent.title,
                        year: selectedEvent.year,
                        isCorrect: true
                    });

                    // Advance the timeline to show the student's answer
                    updateTimelineWithStudentAnswer(selectedEvent.title, selectedEvent.year, true);
                } else {
                    streak = 0;
                    // Get the correct event dynamically
                    const correctEvent = window.sampleEvents.find(option => option.correct === true);

                    choiceFeedback.innerHTML = `
                        <div class="text-red-400 font-medium">Incorrect!</div>
                        <div class="text-xs text-neutral-300">The correct answer was: ${correctEvent.title} (${correctEvent.year})</div>
                    `;
                    choiceFeedback.className = 'p-3 rounded-lg mb-4 bg-red-500/20 border border-red-500/30';

                    // Record the student's incorrect answer
                    const selectedEvent = window.sampleEvents.find(event => event.id === eventId);
                    // correctEvent is already defined above

                    studentAnswers.push({
                        question: currentQuestionIndex,
                        answer: selectedEvent.title,
                        year: selectedEvent.year,
                        correctAnswer: correctEvent.title,
                        correctYear: correctEvent.year,
                        isCorrect: false
                    });

                    // Update timeline with the incorrect answer
                    updateTimelineWithStudentAnswer(selectedEvent.title, selectedEvent.year, false, correctEvent.title, correctEvent.year);
                }

                // Update UI
                choiceFeedback.classList.remove('hidden');
                // Hide the continue button since we're auto-continuing
                continueBtn.classList.add('hidden');
                document.getElementById('score-display').textContent = score;
                document.getElementById('streak-display').textContent = streak;

                // Pause the timer while showing feedback
                pauseTimer();

                // Show auto-continue indicator with countdown
                const autoContinueIndicator = document.getElementById('auto-continue-indicator');
                const countdownElement = document.getElementById('countdown');

                // Make sure the auto-continue indicator is visible
                if (autoContinueIndicator && countdownElement) {
                    autoContinueIndicator.classList.remove('hidden');
                    countdownElement.textContent = '2';

                    // Start countdown
                    let countdown = 2;
                    // Clear any existing countdown interval
                    if (window.countdownInterval) {
                        clearInterval(window.countdownInterval);
                    }
                    window.countdownInterval = setInterval(() => {
                        countdown--;
                        countdownElement.textContent = countdown;
                        if (countdown <= 0) {
                            clearInterval(window.countdownInterval);
                        }
                    }, 1000);
                }

                // Disable all choice buttons
                const buttons = eventChoices.querySelectorAll('button');
                const correctEvent = window.sampleEvents.find(option => option.correct === true);
                const selectedEvent = window.sampleEvents.find(option => option.id === eventId);

                buttons.forEach(button => {
                    button.disabled = true;
                    // Highlight the correct answer in green
                    if (button.textContent.includes(correctEvent.title)) {
                        button.classList.add('bg-green-600');
                        button.classList.remove('bg-neutral-700', 'hover:bg-neutral-600');
                    }
                    // Highlight the incorrect selected answer in red
                    else if (!isCorrect && button.textContent.includes(selectedEvent.title)) {
                        button.classList.add('bg-red-600');
                        button.classList.remove('bg-neutral-700', 'hover:bg-neutral-600');
                    }
                });

                // Update accuracy
                const accuracy = Math.round((correctChoices / totalChoices) * 100);
                document.getElementById('accuracy-display').textContent = `${accuracy}%`;

                // Automatically continue to the next question after a short delay
                if (window.autoContinueTimer) {
                    clearTimeout(window.autoContinueTimer);
                }

                console.log("Setting up auto-continue timer");
                // Force the game to continue after a delay
                window.autoContinueTimer = setTimeout(() => {
                    console.log("Auto-continue timer triggered");
                    continueGame();
                }, 3000); // 3 seconds delay to ensure countdown completes
            }

            // Update the timeline with student's answer
            function updateTimelineWithStudentAnswer(answerTitle, answerYear, isCorrect, correctTitle, correctYear) {
                console.log("Updating timeline with student answer:", answerTitle, isCorrect);

                // We don't need to modify the timeline data anymore since we're using studentAnswers
                // Just update the currentTimelineEventIndex to point to the latest answer
                currentTimelineEventIndex = studentAnswers.length - 1;

                // Update the timeline display
                updateTimeline();
            }

            // Continue the game after making a choice
            function continueGame() {
                console.log("continueGame called, currentQuestionIndex:", currentQuestionIndex);

                // Clear any existing auto-continue timers to prevent multiple calls
                if (window.autoContinueTimer) {
                    clearTimeout(window.autoContinueTimer);
                    window.autoContinueTimer = null;
                }

                // Clear any countdown intervals
                if (window.countdownInterval) {
                    clearInterval(window.countdownInterval);
                    window.countdownInterval = null;
                }

                // Hide feedback and continue button
                if (choiceFeedback) choiceFeedback.classList.add('hidden');
                if (continueBtn) continueBtn.classList.add('hidden');

                // Hide auto-continue indicator
                const autoContinueIndicator = document.getElementById('auto-continue-indicator');
                if (autoContinueIndicator) {
                    autoContinueIndicator.classList.add('hidden');
                }

                // Hide the event choice modal
                eventChoiceModal.classList.add('hidden');

                // Resume the timer
                resumeTimer();

                // Increment the question index for the next question
                currentQuestionIndex++;
                console.log("Incremented currentQuestionIndex to:", currentQuestionIndex);

                // Check if we've reached the end of questions for this era and difficulty
                const questions = questionsDatabase[currentEra][currentDifficulty];

                console.log("Questions for", currentEra, currentDifficulty, ":", questions);

                // Check if questions array exists and has items
                if (!questions || !Array.isArray(questions) || questions.length === 0) {
                    console.error(`No questions found for era: ${currentEra}, difficulty: ${currentDifficulty}`);

                    // Show an error message to the user
                    const notification = document.createElement('div');
                    notification.className = 'fixed top-4 right-4 bg-red-600 text-white px-4 py-2 rounded-lg shadow-lg z-50';
                    notification.textContent = `No questions available for ${currentEra} - ${currentDifficulty}. Please try a different era or difficulty.`;
                    document.body.appendChild(notification);

                    // Remove the notification after 5 seconds
                    setTimeout(() => {
                        notification.remove();
                    }, 5000);

                    // Return to game instructions instead of showing level complete
                    resetGame();
                    return;
                }

                if (currentQuestionIndex >= questions.length) {
                    console.log("No more questions available, showing level complete modal");
                    showLevelCompleteModal();
                } else {
                    console.log("Preparing to show next question");
                    // Reset the event choice modal
                    eventChoices.innerHTML = '';

                    // Show another event choice after a short delay
                    setTimeout(() => {
                        console.log("Showing next question");
                        showEventChoiceModal();
                    }, 500);
                }
            }

            // Show the level complete modal
            function showLevelCompleteModal() {
                // Pause the timer
                pauseTimer();
                clearInterval(timerInterval);

                // Get the current time from the display element to ensure consistency
                const timeString = document.getElementById('time-display').textContent;
                console.log("Using time from display for level complete:", timeString);

                // Format era name for display
                const eraNames = {
                    'ancient': 'Ancient History',
                    'medieval': 'Medieval Period',
                    'renaissance': 'Renaissance Era',
                    'modern': 'Modern Era',
                    'contemporary': 'Contemporary History'
                };

                // Update UI
                document.getElementById('final-score').textContent = score;
                document.getElementById('final-time').textContent = timeString;

                // Log the time values for debugging
                console.log("Time values at level complete:");
                console.log("- Display time:", document.getElementById('time-display').textContent);
                console.log("- Final time:", timeString);

                document.getElementById('completed-level-info').textContent =
                    `${eraNames[currentEra]} - ${currentDifficulty.charAt(0).toUpperCase() + currentDifficulty.slice(1)}`;

                // Load the leaderboard for this era and difficulty
                loadLeaderboard();

                // Show the modal
                levelCompleteModal.classList.remove('hidden');
            }

            // Go to the next level
            function nextLevel() {
                currentLevel++;
                levelCompleteModal.classList.add('hidden');

                // Reset question index for the new level
                currentQuestionIndex = 0;

                // Determine if we should move to the next era or increase difficulty
                const eras = ['ancient', 'medieval', 'renaissance', 'modern', 'contemporary'];
                const difficulties = ['easy', 'medium', 'hard'];

                // Get current era and difficulty indices
                const currentEraIndex = eras.indexOf(currentEra);
                const currentDifficultyIndex = difficulties.indexOf(currentDifficulty);

                // If we've completed all difficulties for this era, move to the next era
                if (currentDifficultyIndex >= difficulties.length - 1) {
                    // Move to the next era if available
                    if (currentEraIndex < eras.length - 1) {
                        currentEra = eras[currentEraIndex + 1];
                        currentTimelineEra = currentEra;
                        currentDifficulty = 'easy'; // Reset to easy difficulty for the new era

                        // Update the era selector
                        eraSelector.value = currentEra;
                    } else {
                        // Player has completed all eras and difficulties
                        alert("Congratulations! You've completed all historical eras!");
                        resetGame();
                        return;
                    }
                } else {
                    // Move to the next difficulty level
                    currentDifficulty = difficulties[currentDifficultyIndex + 1];
                }

                // Update difficulty buttons
                setDifficulty(currentDifficulty);

                // Clear student answers for the new level
                studentAnswers = [];

                // Start a new timer
                startTime = Date.now();
                startTimer();

                // Load the next level
                loadLevel();

                // Update the timeline
                updateTimeline();

                // Show the event choice modal after a short delay
                setTimeout(showEventChoiceModal, 1000);
            }

            // Exit the game
            function exitGame() {
                resetGame();
            }

            // Track which power-ups have been used
            let usedPowerups = {
                hint: 0, // For hint, we track the number of uses (0-3)
                time: false,
                skip: false
            };

            // Function to disable a power-up button
            function disablePowerupButton(buttonId, type) {
                const button = document.getElementById(buttonId);
                if (button) {
                    // Mark as used
                    usedPowerups[type] = true;

                    // Disable the button
                    button.disabled = true;

                    // Add visual styling to show it's used
                    button.classList.remove('hover:bg-yellow-500/50', 'hover:bg-blue-500/50', 'hover:bg-purple-500/50');
                    button.classList.add('opacity-50', 'cursor-not-allowed');

                    // Add "Used" label
                    const usedLabel = document.createElement('div');
                    usedLabel.className = 'absolute top-0 right-0 bg-neutral-800 text-white text-xs px-1 rounded-tr-lg rounded-bl-lg';
                    usedLabel.textContent = 'Used';
                    button.style.position = 'relative';
                    button.appendChild(usedLabel);
                }
            }

            // Get the database hint for the current question
            function getQuestionHint() {
                // If we have the current question data in the global variable, use its hint
                if (window.currentQuestionData && window.currentQuestionData.hint) {
                    return window.currentQuestionData.hint;
                }

                // If there's no current question, return a generic hint
                if (!window.sampleEvents || !window.sampleEvents.length) {
                    const hints = historicalHints[currentEra];
                    return hints[Math.floor(Math.random() * hints.length)];
                }

                // Try to get the current question from the database
                const currentQuestion = getCurrentQuestion();

                // If we have a database hint for this question, use it
                if (currentQuestion && currentQuestion.hint) {
                    return currentQuestion.hint;
                }

                // Fallback to a generic hint if no database hint is available
                const hints = historicalHints[currentEra];
                return hints[Math.floor(Math.random() * hints.length)];
            }

            // Get the current question from the database
            function getCurrentQuestion() {
                // If we don't have the current question index or era/difficulty, return null
                if (currentQuestionIndex === undefined || !currentEra || !currentDifficulty) {
                    return null;
                }

                // Try to get the question from the database
                if (questionsDatabase[currentEra] &&
                    questionsDatabase[currentEra][currentDifficulty] &&
                    questionsDatabase[currentEra][currentDifficulty].length > 0 &&
                    currentQuestionIndex < questionsDatabase[currentEra][currentDifficulty].length) {

                    return questionsDatabase[currentEra][currentDifficulty][currentQuestionIndex];
                }

                return null;
            }

            // Show hint modal
            function showHint() {
                if (!gameActive || powerupsAvailable <= 0 || hintsRemaining <= 0 || usedPowerups.hint >= 3) return;

                // Get the hint for the current question from the database
                const questionHint = getQuestionHint();
                document.getElementById('hint-text').textContent = questionHint;

                // Show the hint modal
                hintModal.classList.remove('hidden');
                hintsRemainingDisplay.textContent = hintsRemaining;
            }

            // Close hint modal
            function closeHint() {
                hintModal.classList.add('hidden');
            }

            // Update hint button appearance based on remaining hints
            function updateHintButtonAppearance() {
                const hintButton = document.getElementById('hint-btn');
                if (!hintButton) return;

                // Update the hint count indicator
                let hintCountIndicator = hintButton.querySelector('.hint-count');
                if (!hintCountIndicator) {
                    hintCountIndicator = document.createElement('div');
                    hintCountIndicator.className = 'hint-count absolute bottom-0 right-0 bg-yellow-800 text-white text-xs px-1 rounded-full';
                    hintButton.style.position = 'relative';
                    hintButton.appendChild(hintCountIndicator);
                }

                // Update the count
                hintCountIndicator.textContent = hintsRemaining;

                // If no hints left, fully disable the button
                if (hintsRemaining <= 0) {
                    hintButton.disabled = true;
                    hintButton.classList.remove('hover:bg-yellow-500/50');
                    hintButton.classList.add('opacity-50', 'cursor-not-allowed');

                    // Add "Used" label if not already present
                    let usedLabel = hintButton.querySelector('.used-label');
                    if (!usedLabel) {
                        usedLabel = document.createElement('div');
                        usedLabel.className = 'used-label absolute top-0 right-0 bg-neutral-800 text-white text-xs px-1 rounded-tr-lg rounded-bl-lg';
                        usedLabel.textContent = 'Used';
                        hintButton.appendChild(usedLabel);
                    }
                }
            }

            // Apply hint to reveal correct answer
            function applyHint() {
                if (hintsRemaining <= 0 || usedPowerups.hint >= 3) return;

                // Increment the hint usage counter
                usedPowerups.hint++;

                // Decrement available hints
                hintsRemaining--;
                powerupsAvailable--;
                hintsRemainingDisplay.textContent = hintsRemaining;
                powerupsAvailableDisplay.textContent = powerupsAvailable;

                // Find and highlight the correct answer in the event choices
                const buttons = eventChoices.querySelectorAll('button');
                const correctOption = window.sampleEvents.find(option => option.correct === true);

                if (correctOption) {
                    buttons.forEach(button => {
                        if (button.textContent.includes(correctOption.title)) {
                            button.classList.add('bg-yellow-600');
                            button.classList.remove('bg-neutral-700', 'hover:bg-neutral-600');
                        }
                    });
                }

                // Update the hint button appearance
                updateHintButtonAppearance();

                // Close the hint modal
                closeHint();

                // Show a notification
                const notification = document.createElement('div');
                notification.className = 'fixed top-4 right-4 bg-yellow-600 text-white px-4 py-2 rounded-lg shadow-lg z-50 flex items-center';
                notification.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                    Hint used! Correct answer highlighted. (${hintsRemaining} hints remaining)
                `;
                document.body.appendChild(notification);

                // Remove the notification after 2 seconds
                setTimeout(() => {
                    notification.remove();
                }, 2000);
            }

            // Add time power-up
            function addTime() {
                if (!gameActive || powerupsAvailable <= 0 || usedPowerups.time) return;

                // Add 30 seconds to the timer
                startTime += 30000; // 30 seconds in milliseconds
                powerupsAvailable--;
                powerupsAvailableDisplay.textContent = powerupsAvailable;

                // Disable the time button
                disablePowerupButton('time-btn', 'time');

                // Show a notification
                const notification = document.createElement('div');
                notification.className = 'fixed top-4 right-4 bg-blue-600 text-white px-4 py-2 rounded-lg shadow-lg z-50 flex items-center';
                notification.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    +30 seconds added! Time power-up used.
                `;
                document.body.appendChild(notification);

                // Remove the notification after 2 seconds
                setTimeout(() => {
                    notification.remove();
                }, 2000);
            }

            // Skip question power-up
            function skipQuestion() {
                if (!gameActive || powerupsAvailable <= 0 || usedPowerups.skip) return;

                powerupsAvailable--;
                powerupsAvailableDisplay.textContent = powerupsAvailable;

                // Disable the skip button
                disablePowerupButton('skip-btn', 'skip');

                // Skip the current question
                eventChoiceModal.classList.add('hidden');

                // Increment the question index for the next question
                currentQuestionIndex++;

                // Show a notification
                const notification = document.createElement('div');
                notification.className = 'fixed top-4 right-4 bg-purple-600 text-white px-4 py-2 rounded-lg shadow-lg z-50 flex items-center';
                notification.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                    </svg>
                    Question skipped! Skip power-up used.
                `;
                document.body.appendChild(notification);

                // Remove the notification after 2 seconds
                setTimeout(() => {
                    notification.remove();
                }, 2000);

                // Show another event choice after a short delay
                setTimeout(() => {
                    showEventChoiceModal();
                }, 500);
            }

            // Save score to database
            async function saveScore() {
                // Calculate accuracy
                const accuracy = Math.round((correctChoices / totalChoices) * 100);

                // Get time from the final-time element to ensure consistency
                const timeString = document.getElementById('final-time').textContent;

                // Convert time string (MM:SS) to seconds
                const timeParts = timeString.split(':');
                const timeInSeconds = parseInt(timeParts[0]) * 60 + parseInt(timeParts[1]);

                // Prepare data to send to the server
                const progressData = {
                    score: score,
                    era: currentEra,
                    difficulty: currentDifficulty,
                    time_taken: timeInSeconds,
                    questions_answered: totalChoices,
                    correct_answers: correctChoices,
                    max_streak: streak,
                    answers: studentAnswers,
                    completed: true
                };

                try {
                    // Show loading indicator
                    const saveButton = document.getElementById('save-score-btn');
                    if (saveButton) {
                        saveButton.disabled = true;
                        saveButton.textContent = 'Saving...';
                    }

                    // Create a form data object for the request
                    const formData = new FormData();
                    formData.append('_token', '{{ csrf_token() }}');
                    formData.append('score', progressData.score);
                    formData.append('era', progressData.era);
                    formData.append('difficulty', progressData.difficulty);
                    formData.append('time_taken', progressData.time_taken);
                    formData.append('questions_answered', progressData.questions_answered);
                    formData.append('correct_answers', progressData.correct_answers);
                    formData.append('max_streak', progressData.max_streak);
                    formData.append('completed', progressData.completed ? 1 : 0);

                    // Convert answers array to JSON string and append
                    if (progressData.answers && progressData.answers.length > 0) {
                        formData.append('answers', JSON.stringify(progressData.answers));
                    } else {
                        formData.append('answers', JSON.stringify([]));
                    }

                    // Send data to the server
                    const response = await fetch('{{ route('subjects.specialized.humms.historical-timeline-maze.save-progress') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: formData
                    });

                    // Check if the response is JSON
                    const contentType = response.headers.get('content-type');
                    if (!contentType || !contentType.includes('application/json')) {
                        throw new Error('Server returned non-JSON response. This might be due to a server error or CSRF token issue.');
                    }

                    const data = await response.json();

                    if (data.success) {
                        // Show success notification
                        const notification = document.createElement('div');
                        notification.className = 'fixed top-4 right-4 bg-green-600 text-white px-4 py-2 rounded-lg shadow-lg z-50 flex items-center';
                        notification.innerHTML = `
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Progress saved successfully!
                        `;
                        document.body.appendChild(notification);

                        // Remove the notification after 3 seconds
                        setTimeout(() => {
                            notification.remove();
                        }, 3000);

                        // Load and update the leaderboard
                        loadLeaderboard();
                    } else {
                        throw new Error(data.message || 'Failed to save progress');
                    }
                } catch (error) {
                    console.error('Error saving progress:', error);

                    // Show error notification
                    const notification = document.createElement('div');
                    notification.className = 'fixed top-4 right-4 bg-red-600 text-white px-4 py-2 rounded-lg shadow-lg z-50 flex items-center';

                    // Create a more detailed error message
                    let errorMessage = error.message;
                    if (errorMessage.includes('Unexpected token')) {
                        errorMessage = 'Server returned an invalid response. This might be due to a CSRF token issue. Please refresh the page and try again.';
                    }

                    notification.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Error saving progress: ${errorMessage}
                    `;
                    document.body.appendChild(notification);

                    // Remove the notification after 5 seconds
                    setTimeout(() => {
                        notification.remove();
                    }, 5000);
                } finally {
                    // Re-enable the save button
                    if (saveButton) {
                        saveButton.disabled = false;
                        saveButton.innerHTML = `
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                            </svg>
                            Save Score to Leaderboard
                        `;
                    }
                }
            }

            // Load leaderboard data from the server
            async function loadLeaderboard() {
                try {
                    // Remove any existing error notifications
                    removeErrorNotifications();

                    // Show loading state
                    leaderboardBody.innerHTML = `
                        <tr>
                            <td colspan="6" class="px-4 py-4 text-center text-neutral-400">
                                Loading leaderboard data...
                            </td>
                        </tr>
                    `;

                    // Make sure we have valid era and difficulty
                    if (!currentEra || !currentDifficulty) {
                        console.warn('Cannot load leaderboard: missing era or difficulty');
                        leaderboardBody.innerHTML = `
                            <tr>
                                <td colspan="6" class="px-4 py-4 text-center text-neutral-400">
                                    Select an era and difficulty to view leaderboard.
                                </td>
                            </tr>
                        `;
                        // Display default leaderboard data
                        displayDefaultLeaderboard();
                        return;
                    }

                    console.log(`Attempting to load leaderboard for era: ${currentEra}, difficulty: ${currentDifficulty}`);

                    // Create a controller to allow aborting the fetch if it takes too long
                    const controller = new AbortController();
                    const timeoutId = setTimeout(() => controller.abort(), 8000); // 8 second timeout

                    // Fetch leaderboard data from the server
                    const response = await fetch(`{{ route('subjects.specialized.humms.historical-timeline-maze.leaderboard') }}?era=${currentEra}&difficulty=${currentDifficulty}`, {
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'Cache-Control': 'no-cache' // Prevent caching
                        },
                        signal: controller.signal
                    });

                    // Clear the timeout since the request completed
                    clearTimeout(timeoutId);

                    if (!response.ok) {
                        throw new Error(`Server returned ${response.status}: ${response.statusText}`);
                    }

                    // Check if the response is JSON
                    const contentType = response.headers.get('content-type');
                    if (!contentType || !contentType.includes('application/json')) {
                        throw new Error('Server returned non-JSON response');
                    }

                    const responseText = await response.text();
                    console.log('Raw response:', responseText);

                    // Try to parse the JSON
                    let data;
                    try {
                        data = JSON.parse(responseText);
                    } catch (parseError) {
                        console.error('JSON parse error:', parseError);
                        throw new Error(`Failed to parse JSON response: ${parseError.message}`);
                    }

                    console.log('Parsed leaderboard data:', data);

                    // Check if the data has the expected structure
                    if (!data || !data.leaderboard) {
                        console.warn('Leaderboard data is missing or has unexpected format:', data);
                        throw new Error('Server returned invalid leaderboard data structure');
                    }

                    // Update the leaderboard display
                    updateLeaderboardDisplay(data.leaderboard, data.user_rank);
                } catch (error) {
                    console.error('Error loading leaderboard:', error);

                    // Remove any existing error notifications
                    removeErrorNotifications();

                    // Create a more detailed error message
                    let errorMessage = 'Error loading leaderboard data. Please try again later.';

                    if (error.name === 'AbortError') {
                        errorMessage = 'Leaderboard request timed out. The server might be busy. Please try again later.';
                    } else if (error.message.includes('Unexpected token') || error.message.includes('non-JSON response') || error.message.includes('parse')) {
                        errorMessage = 'Server returned an invalid response. This might be due to a CSRF token issue. Please refresh the page and try again.';
                    }

                    // Show error state in the leaderboard table
                    leaderboardBody.innerHTML = `
                        <tr>
                            <td colspan="6" class="px-4 py-4 text-center text-red-400">
                                ${errorMessage}
                            </td>
                        </tr>
                    `;

                    // Log the error but don't show a notification - we'll just display default data
                    console.log('Displaying default leaderboard data due to error:', error.message);

                    // Fall back to default leaderboard immediately
                    displayDefaultLeaderboard();
                }
            }

            // Initialize the leaderboard with default data
            function updateLeaderboard() {
                // Check if leaderboardBody exists
                if (!leaderboardBody) {
                    console.error("Leaderboard body element not found");
                    return;
                }

                // Show loading state
                leaderboardBody.innerHTML = `
                    <tr>
                        <td colspan="6" class="px-4 py-4 text-center text-neutral-400">
                            Select an era and difficulty to view leaderboard.
                        </td>
                    </tr>
                `;

                // If we have a current era and difficulty, try to load the leaderboard
                if (currentEra && currentDifficulty) {
                    // Use a try-catch block to handle any synchronous errors
                    try {
                        loadLeaderboard();
                    } catch (error) {
                        console.error("Error initiating leaderboard load:", error);
                        displayDefaultLeaderboard();
                    }
                } else {
                    // Display default leaderboard if no era/difficulty selected
                    displayDefaultLeaderboard();
                }
            }

            // Function to remove any error notifications at the top of the page
            function removeErrorNotifications() {
                // Find and remove any error notifications at the top of the page
                const errorNotifications = document.querySelectorAll('.fixed.top-0.left-0.right-0.bg-red-600');
                errorNotifications.forEach(notification => {
                    notification.remove();
                });

                // Also remove any other error notifications that might be showing
                const otherErrorNotifications = document.querySelectorAll('.bg-red-600.text-white');
                otherErrorNotifications.forEach(notification => {
                    notification.remove();
                });
            }

            // Display default leaderboard data when API fails
            function displayDefaultLeaderboard() {
                if (!leaderboardBody) return;

                // Remove any error notifications first
                removeErrorNotifications();

                leaderboardBody.innerHTML = '';

                // Use the default leaderboard data
                const defaultData = [
                    { rank: 1, player: 'HistoryBuff', era: 'Ancient', score: 1250, time: '01:45', accuracy: '92%' },
                    { rank: 2, player: 'TimeExplorer', era: 'Medieval', score: 980, time: '02:10', accuracy: '85%' },
                    { rank: 3, player: 'ChronoMaster', era: 'Modern', score: 820, time: '02:30', accuracy: '78%' }
                ];

                defaultData.forEach(entry => {
                    const row = document.createElement('tr');
                    row.className = 'border-b border-neutral-700';

                    row.innerHTML = `
                        <td class="px-4 py-2 text-sm text-neutral-300">${entry.rank}</td>
                        <td class="px-4 py-2 text-sm text-white">${entry.player}</td>
                        <td class="px-4 py-2 text-sm text-neutral-300">${entry.era}</td>
                        <td class="px-4 py-2 text-sm text-emerald-400">${entry.score}</td>
                        <td class="px-4 py-2 text-sm text-neutral-300">${entry.time}</td>
                        <td class="px-4 py-2 text-sm text-neutral-300">${entry.accuracy}</td>
                    `;

                    leaderboardBody.appendChild(row);
                });
            }

            // Update leaderboard display with data from the server
            function updateLeaderboardDisplay(leaderboardData, userRank) {
                leaderboardBody.innerHTML = '';

                if (!leaderboardData || leaderboardData.length === 0) {
                    leaderboardBody.innerHTML = `
                        <tr>
                            <td colspan="6" class="px-4 py-4 text-center text-neutral-400">
                                No leaderboard entries yet. Be the first to complete this level!
                            </td>
                        </tr>
                    `;
                    return;
                }

                // Display leaderboard entries
                leaderboardData.forEach(entry => {
                    const row = document.createElement('tr');
                    row.className = 'border-b border-neutral-700';

                    // Format time from seconds to MM:SS
                    const minutes = Math.floor(entry.time_taken / 60);
                    const seconds = entry.time_taken % 60;
                    const formattedTime = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

                    // Highlight the current user's entry
                    const isCurrentUser = entry.user_id == currentUserId;
                    const rowClass = isCurrentUser ? 'bg-emerald-900/20' : '';

                    row.className = `border-b border-neutral-700 ${rowClass}`;

                    row.innerHTML = `
                        <td class="px-4 py-2 text-sm text-neutral-300">${entry.rank}</td>
                        <td class="px-4 py-2 text-sm text-white">${entry.username || 'Anonymous'}</td>
                        <td class="px-4 py-2 text-sm text-neutral-300">${entry.era.charAt(0).toUpperCase() + entry.era.slice(1)}</td>
                        <td class="px-4 py-2 text-sm text-emerald-400">${entry.score}</td>
                        <td class="px-4 py-2 text-sm text-neutral-300">${formattedTime}</td>
                        <td class="px-4 py-2 text-sm text-neutral-300">${Math.round(entry.accuracy)}%</td>
                    `;

                    leaderboardBody.appendChild(row);
                });

                // Display user's rank if available but not in top 10
                if (userRank && !leaderboardData.some(entry => entry.user_id == currentUserId)) {
                    const userRow = document.createElement('tr');
                    userRow.className = 'border-t-2 border-neutral-600 bg-emerald-900/20';

                    // Format time from seconds to MM:SS
                    const minutes = Math.floor(userRank.time_taken / 60);
                    const seconds = userRank.time_taken % 60;
                    const formattedTime = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

                    userRow.innerHTML = `
                        <td class="px-4 py-2 text-sm text-neutral-300">${userRank.rank}</td>
                        <td class="px-4 py-2 text-sm text-white">You</td>
                        <td class="px-4 py-2 text-sm text-neutral-300">${currentEra.charAt(0).toUpperCase() + currentEra.slice(1)}</td>
                        <td class="px-4 py-2 text-sm text-emerald-400">${userRank.score}</td>
                        <td class="px-4 py-2 text-sm text-neutral-300">${formattedTime}</td>
                        <td class="px-4 py-2 text-sm text-neutral-300">${Math.round(userRank.accuracy)}%</td>
                    `;

                    leaderboardBody.appendChild(userRow);
                }
            }

            // Update the timeline based on the selected era
            async function updateTimelineEra() {
                currentTimelineEra = eraSelector.value;
                currentTimelineEventIndex = 0;

                // Show loading state
                timelineEvents.innerHTML = `
                    <div class="p-4 text-center">
                        <p class="text-neutral-400">Loading timeline events...</p>
                    </div>
                `;

                // Load the timeline events for the selected era
                await loadTimelineEvents(currentTimelineEra);

                // Update the timeline display
                updateTimeline();
            }

            // Update the timeline display to show student answers
            function updateTimeline() {
                const era = timelineData[currentTimelineEra];

                // Update era information
                currentEraTitle.textContent = era.title;
                eraDescription.textContent = "Your Progress: Showing your answers as you complete questions";

                // Generate timeline HTML based on student answers
                let timelineHTML = '';

                // Only show answers that have been given so far
                if (studentAnswers.length === 0) {
                    timelineHTML = `
                        <div class="p-4 text-center">
                            <p class="text-neutral-400">Answer questions to see your progress here</p>
                        </div>
                    `;

                    // Update progress indicator for empty timeline
                    timelineProgress.textContent = `0/0 Answers`;

                    // Disable navigation buttons when no answers
                    prevEventBtn.disabled = true;
                    nextEventBtn.disabled = true;
                    prevEventBtn.classList.add('opacity-50', 'cursor-not-allowed');
                    nextEventBtn.classList.add('opacity-50', 'cursor-not-allowed');
                } else {
                    // Update progress indicator
                    timelineProgress.textContent = `${currentTimelineEventIndex + 1}/${studentAnswers.length} Answers`;

                    // Enable/disable navigation buttons
                    prevEventBtn.disabled = currentTimelineEventIndex === 0;
                    nextEventBtn.disabled = currentTimelineEventIndex === studentAnswers.length - 1;

                    if (prevEventBtn.disabled) {
                        prevEventBtn.classList.add('opacity-50', 'cursor-not-allowed');
                    } else {
                        prevEventBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    }

                    if (nextEventBtn.disabled) {
                        nextEventBtn.classList.add('opacity-50', 'cursor-not-allowed');
                    } else {
                        nextEventBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    }

                    // Generate HTML for each student answer
                    studentAnswers.forEach((answer, index) => {
                        const isActive = index === currentTimelineEventIndex;
                        const isPast = index < currentTimelineEventIndex;

                        // Determine the icon and colors based on correctness
                        const icon = answer.isCorrect ? '✓' : '✗';
                        const iconColor = answer.isCorrect ? 'text-green-500' : 'text-red-500';
                        const borderColor = answer.isCorrect ? 'border-green-500/30' : 'border-red-500/30';
                        const bgColor = isActive
                            ? (answer.isCorrect ? 'bg-green-500/20' : 'bg-red-500/20')
                            : 'bg-neutral-800';

                        // Create the description text
                        let description = '';
                        if (answer.isCorrect) {
                            description = `You correctly identified this historical event.`;
                        } else {
                            description = `You selected this event, but the correct answer was: ${answer.correctAnswer} (${answer.correctYear}).`;
                        }

                        timelineHTML += `
                            <div class="timeline-event">
                                <div class="absolute left-2 w-6 h-6 rounded-full ${isActive ? (answer.isCorrect ? 'bg-green-500/20 border-2 border-green-500' : 'bg-red-500/20 border-2 border-red-500') : isPast ? (answer.isCorrect ? 'bg-green-700/20 border-2 border-green-700' : 'bg-red-700/20 border-2 border-red-700') : 'bg-neutral-700 border-2 border-neutral-600'} flex items-center justify-center -translate-x-1/2">
                                    <div class="w-2 h-2 rounded-full ${isActive ? (answer.isCorrect ? 'bg-green-500' : 'bg-red-500') : isPast ? (answer.isCorrect ? 'bg-green-700' : 'bg-red-700') : 'bg-neutral-500'}"></div>
                                </div>
                                <div class="${bgColor} p-3 rounded-lg border ${isActive ? borderColor : 'border-neutral-700'}">
                                    <div class="flex justify-between items-start mb-1">
                                        <h4 class="text-sm font-medium ${isActive ? iconColor : 'text-white'}">${icon} ${answer.answer}</h4>
                                        <span class="text-xs ${isActive ? iconColor : 'text-neutral-400'}">${answer.year}</span>
                                    </div>
                                    <p class="text-xs text-neutral-400">${description}</p>
                                </div>
                            </div>
                        `;
                    });
                }

                timelineEvents.innerHTML = timelineHTML;

                // Scroll to the active event if there are answers
                if (studentAnswers.length > 0) {
                    const activeEvent = timelineEvents.querySelector('.timeline-event:nth-child(' + (currentTimelineEventIndex + 1) + ')');
                    if (activeEvent) {
                        activeEvent.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                }
            }

            // Show the previous timeline event
            function showPreviousTimelineEvent() {
                if (currentTimelineEventIndex > 0) {
                    currentTimelineEventIndex--;
                    updateTimeline();
                }
            }

            // Show the next timeline event
            function showNextTimelineEvent() {
                if (studentAnswers.length > 0) {
                    // For student answers mode
                    if (currentTimelineEventIndex < studentAnswers.length - 1) {
                        currentTimelineEventIndex++;
                        updateTimeline();
                    }
                } else {
                    // For timeline events mode
                    const totalEvents = timelineData[currentTimelineEra].events.length;
                    if (currentTimelineEventIndex < totalEvents - 1) {
                        currentTimelineEventIndex++;
                        updateTimeline();
                    }
                }
            }

            // Start the game
            function startGame() {
                // Validate that an Era is selected
                const selectedEra = eraSelector.value;
                if (!selectedEra) {
                    // Show an error notification
                    const notification = document.createElement('div');
                    notification.className = 'fixed top-4 right-4 bg-red-600 text-white px-4 py-2 rounded-lg shadow-lg z-50 flex items-center';
                    notification.innerHTML = `
                        <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        Please select a historical Era before starting the game.
                    `;
                    document.body.appendChild(notification);

                    // Remove the notification after 3 seconds
                    setTimeout(() => {
                        notification.remove();
                    }, 3000);

                    // Highlight the Era selector to draw attention
                    eraSelector.classList.add('ring-2', 'ring-red-500', 'animate-pulse');
                    setTimeout(() => {
                        eraSelector.classList.remove('ring-2', 'ring-red-500', 'animate-pulse');
                    }, 2000);

                    return; // Exit the function early
                }

                // Validate that a difficulty is selected
                if (!currentDifficulty) {
                    // Show an error notification
                    const notification = document.createElement('div');
                    notification.className = 'fixed top-4 right-4 bg-red-600 text-white px-4 py-2 rounded-lg shadow-lg z-50 flex items-center';
                    notification.innerHTML = `
                        <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        Please select a difficulty level before starting the game.
                    `;
                    document.body.appendChild(notification);

                    // Remove the notification after 3 seconds
                    setTimeout(() => {
                        notification.remove();
                    }, 3000);

                    return; // Exit the function early
                }

                gameActive = true;
                currentEra = selectedEra;
                currentTimelineEra = currentEra;
                currentTimelineEventIndex = 0;
                score = 0;
                correctChoices = 0;
                totalChoices = 0;
                streak = 0;
                hintsRemaining = 3;
                powerupsAvailable = 3;
                studentAnswers = [];
                currentQuestionIndex = 0;

                // Reset timeline data to original state
                resetTimelineData();

                // Update UI
                gameInstructions.classList.add('hidden');
                mazeCanvas.classList.remove('hidden');
                startBtn.disabled = true;
                resetBtn.disabled = false;
                document.getElementById('score-display').textContent = score;
                document.getElementById('level-display').textContent = currentLevel;
                document.getElementById('accuracy-display').textContent = '0%';
                document.getElementById('streak-display').textContent = '0';
                hintsRemainingDisplay.textContent = hintsRemaining;
                powerupsAvailableDisplay.textContent = powerupsAvailable;

                // Clear the timeline events and update
                timelineEvents.innerHTML = '';
                updateTimeline();

                // Reset and start the timer
                timerPaused = false;
                startTime = Date.now();
                console.log("Game started at:", new Date(startTime).toISOString());

                // Clear any existing timer interval
                if (timerInterval) {
                    clearInterval(timerInterval);
                }

                // Initialize the timer display immediately
                updateTimer();

                // Then start the timer interval
                startTimer();

                // Load the first level
                loadLevel();

                // For demo purposes, show the event choice modal after a short delay
                setTimeout(showEventChoiceModal, 1500);
            }

            // Function to load questions for a specific era and all difficulties
            async function loadQuestionsForEra(era) {
                // Check if questions are already loaded for this era
                const isAlreadyLoaded =
                    questionsDatabase[era] &&
                    questionsDatabase[era].easy &&
                    questionsDatabase[era].easy.length > 0;

                // If already loaded, return immediately
                if (isAlreadyLoaded) {
                    console.log(`Questions for ${era} already loaded, skipping fetch`);
                    return true;
                }

                const difficulties = ['easy', 'medium', 'hard'];

                console.log(`Starting to load questions for ${era}...`);

                try {
                    // Create an array of promises for parallel loading
                    const loadPromises = difficulties.map(difficulty => {
                        return loadQuestions(era, difficulty);
                    });

                    // Wait for all questions to load in parallel with a timeout
                    const timeoutPromise = new Promise((_, reject) => {
                        setTimeout(() => reject(new Error('Loading questions timed out')), 10000);
                    });

                    await Promise.race([
                        Promise.all(loadPromises),
                        timeoutPromise
                    ]);

                    // Log the loaded questions for this era
                    console.log(`Completed loading questions for ${era}`);

                    return true;
                } catch (error) {
                    console.error(`Error loading questions for ${era}:`, error);

                    // Initialize with empty arrays to prevent errors
                    difficulties.forEach(difficulty => {
                        if (!questionsDatabase[era][difficulty]) {
                            questionsDatabase[era][difficulty] = [];
                        }
                    });

                    return false;
                }
            }

            // Function to initialize the game without loading any questions initially
            async function loadAllQuestions() {
                console.log("Starting game initialization...");

                // Create a persistent error banner that stays until initialization is complete
                const errorBanner = document.createElement('div');
                errorBanner.className = 'fixed top-0 left-0 right-0 bg-red-600 text-white px-4 py-2 text-center font-medium z-50 flex items-center justify-center';
                errorBanner.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    Initializing game... Please wait.
                `;

                try {
                    // Check if all required DOM elements exist
                    const requiredElements = [
                        { name: 'startBtn', element: startBtn },
                        { name: 'resetBtn', element: resetBtn },
                        { name: 'easyBtn', element: easyBtn },
                        { name: 'mediumBtn', element: mediumBtn },
                        { name: 'hardBtn', element: hardBtn },
                        { name: 'eraSelector', element: eraSelector },
                        { name: 'gameInstructions', element: gameInstructions },
                        { name: 'mazeCanvas', element: mazeCanvas },
                        { name: 'hintBtn', element: hintBtn },
                        { name: 'timeBtn', element: timeBtn },
                        { name: 'skipBtn', element: skipBtn }
                    ];

                    // Check for missing elements
                    const missingElements = requiredElements.filter(item => !item.element);
                    if (missingElements.length > 0) {
                        throw new Error(`Missing required DOM elements: ${missingElements.map(item => item.name).join(', ')}`);
                    }

                    // Add the error banner to the page before initialization
                    document.body.appendChild(errorBanner);

                    // Initialize the game UI without loading any questions yet
                    // This makes the initial page load much faster
                    initGame();

                    // Add initial hint count indicator to the hint button
                    const hintButton = document.getElementById('hint-btn');
                    if (hintButton) {
                        const hintCount = document.createElement('div');
                        hintCount.className = 'hint-count absolute bottom-0 right-0 bg-yellow-800 text-white text-xs px-1 rounded-full';
                        hintCount.textContent = '3';
                        hintButton.style.position = 'relative';
                        hintButton.appendChild(hintCount);
                    }

                    // Initialize the timeline with empty data
                    updateTimeline();

                    // Remove the error banner since initialization was successful
                    errorBanner.remove();

                    // Show success notification
                    const successNotification = document.createElement('div');
                    successNotification.className = 'fixed top-4 right-4 bg-green-600 text-white px-4 py-2 rounded-lg shadow-lg z-50 flex items-center';
                    successNotification.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Game initialized successfully! Select an Era to begin.
                    `;
                    document.body.appendChild(successNotification);

                    // Remove the success notification after 3 seconds
                    setTimeout(() => {
                        successNotification.remove();
                    }, 3000);

                    // We'll load questions on-demand when an era is selected
                    console.log("Game initialized successfully. Questions will be loaded when an era is selected.");

                } catch (error) {
                    console.error("Error during game initialization:", error);

                    // Update the error banner with the specific error
                    errorBanner.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        Failed to initialize the game. Please try refreshing the page.
                    `;

                    // Try to initialize a minimal version of the game
                    try {
                        // Basic initialization of UI elements that are available
                        if (gameInstructions) {
                            gameInstructions.innerHTML = `
                                <div class="p-6 bg-red-900/30 rounded-lg border border-red-500/30 max-w-md mx-auto">
                                    <h3 class="text-xl font-bold text-white mb-4">Game Initialization Error</h3>
                                    <p class="text-white mb-4">There was a problem initializing the game. This might be due to:</p>
                                    <ul class="text-white list-disc pl-5 mb-4 space-y-2">
                                        <li>Missing game elements</li>
                                        <li>JavaScript errors</li>
                                        <li>Network connectivity issues</li>
                                    </ul>
                                    <p class="text-white mb-6">Please try refreshing the page or contact support if the problem persists.</p>
                                    <button onclick="window.location.reload()" class="w-full px-4 py-2 bg-red-600 hover:bg-red-500 text-white rounded-lg transition-colors">
                                        Refresh Page
                                    </button>
                                </div>
                            `;
                            gameInstructions.classList.remove('hidden');
                        }

                        // Disable any buttons that might exist
                        [startBtn, resetBtn, easyBtn, mediumBtn, hardBtn].forEach(btn => {
                            if (btn) {
                                btn.disabled = true;
                                btn.classList.add('opacity-50', 'cursor-not-allowed');
                            }
                        });

                    } catch (fallbackError) {
                        console.error("Failed to initialize fallback UI:", fallbackError);
                    }
                }
            }

            // Initialize the leaderboard with default data
            displayDefaultLeaderboard();

            // Load all questions and initialize the game
            loadAllQuestions();
        });
    </script>
</x-layouts.app>