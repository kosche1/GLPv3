<x-layouts.app>
    <div class="flex h-full w-full flex-1 flex-col gap-6 text-gray-100 p-6 border border-emerald-500 rounded-lg">
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
                        <div id="event-choice-modal" class="absolute inset-0 bg-black/80 backdrop-blur-sm flex items-center justify-center p-6 hidden">
                            <div class="bg-neutral-800 rounded-xl border border-emerald-500/30 p-6 max-w-md w-full">
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
                        <div id="hint-modal" class="absolute inset-0 bg-black/80 backdrop-blur-sm flex items-center justify-center p-6 hidden">
                            <div class="bg-neutral-800 rounded-xl border border-yellow-500/30 p-6 max-w-md w-full">
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
                        <div id="level-complete-modal" class="absolute inset-0 bg-black/80 backdrop-blur-sm flex items-center justify-center p-6 hidden">
                            <div class="bg-neutral-800 rounded-xl border border-emerald-500/30 p-6 max-w-md w-full">
                                <div class="flex justify-center mb-4">
                                    <div class="p-3 bg-emerald-500/20 rounded-full">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                </div>
                                <h3 class="text-xl font-bold text-white text-center mb-2">Level Complete!</h3>
                                <p class="text-neutral-400 text-center mb-2">You've successfully navigated this era of history!</p>
                                <p id="completed-level-info" class="text-emerald-400 text-center mb-6">Ancient History - Easy</p>

                                <div class="grid grid-cols-2 gap-4 mb-6">
                                    <div class="bg-neutral-700/50 p-3 rounded-lg text-center">
                                        <span class="text-xs text-neutral-400">Score</span>
                                        <p id="final-score" class="text-xl font-bold text-emerald-400">850</p>
                                    </div>
                                    <div class="bg-neutral-700/50 p-3 rounded-lg text-center">
                                        <span class="text-xs text-neutral-400">Time</span>
                                        <p id="final-time" class="text-xl font-bold text-emerald-400">01:45</p>
                                    </div>
                                </div>

                                <div class="mb-6">
                                    <label for="player-name" class="block text-sm font-medium text-neutral-300 mb-2">Save your score:</label>
                                    <div class="flex gap-2">
                                        <input type="text" id="player-name" placeholder="Enter your name" class="flex-1 px-4 py-2 bg-neutral-700 border border-neutral-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                                        <button id="save-score-btn" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white rounded-lg transition-colors">
                                            Save
                                        </button>
                                    </div>
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
                    'The printing press was invented by Johannes Gutenberg around 1440.',
                    'The Renaissance began in Italy in the 14th century and spread throughout Europe.',
                    'The Age of Exploration began in the early 15th century with Portuguese expeditions.'
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

            // Questions database organized by era and difficulty
            let questionsDatabase = {
                'ancient': {
                    'easy': [
                        {
                            question: "Which of these events happened first in ancient history?",
                            options: [
                                { id: 1, title: 'Building of the Great Pyramid of Giza', year: '2560 BCE', correct: true },
                                { id: 2, title: 'Code of Hammurabi', year: '1754 BCE', correct: false },
                                { id: 3, title: 'Founding of the Roman Republic', year: '509 BCE', correct: false }
                            ]
                        },
                        {
                            question: "Which ancient civilization development came next?",
                            options: [
                                { id: 1, title: 'Code of Hammurabi', year: '1754 BCE', correct: true },
                                { id: 2, title: 'Trojan War', year: '1200 BCE', correct: false },
                                { id: 3, title: 'First Olympic Games', year: '776 BCE', correct: false }
                            ]
                        },
                        {
                            question: "Which of these events occurred last in the ancient world?",
                            options: [
                                { id: 1, title: 'Birth of Jesus Christ', year: '~4 BCE', correct: true },
                                { id: 2, title: 'Founding of the Roman Republic', year: '509 BCE', correct: false },
                                { id: 3, title: 'Birth of Democracy in Athens', year: '508 BCE', correct: false }
                            ]
                        }
                    ],
                    'medium': [
                        {
                            question: "Place these ancient events in chronological order. Which came first?",
                            options: [
                                { id: 1, title: 'Construction of the Great Wall of China', year: '700-214 BCE', correct: true },
                                { id: 2, title: 'Alexander the Great conquers Persia', year: '330 BCE', correct: false },
                                { id: 3, title: 'Julius Caesar becomes dictator of Rome', year: '49 BCE', correct: false }
                            ]
                        },
                        {
                            question: "Which of these ancient inventions was developed first?",
                            options: [
                                { id: 1, title: 'Invention of Paper in China', year: '105 CE', correct: true },
                                { id: 2, title: 'First use of concrete by Romans', year: '300 BCE', correct: false },
                                { id: 3, title: 'Development of the Compass', year: '200 CE', correct: false }
                            ]
                        },
                        {
                            question: "Which ancient empire reached its peak first?",
                            options: [
                                { id: 1, title: 'Persian Empire under Darius I', year: '522-486 BCE', correct: true },
                                { id: 2, title: 'Roman Empire under Augustus', year: '27 BCE-14 CE', correct: false },
                                { id: 3, title: 'Han Dynasty in China', year: '206 BCE-220 CE', correct: false }
                            ]
                        }
                    ],
                    'hard': [
                        {
                            question: "Which of these lesser-known ancient events occurred first?",
                            options: [
                                { id: 1, title: 'Ashoka the Great converts to Buddhism', year: '263 BCE', correct: true },
                                { id: 2, title: 'The Silk Road trade route established', year: '130 BCE', correct: false },
                                { id: 3, title: 'Ptolemy creates his world map', year: '150 CE', correct: false }
                            ]
                        },
                        {
                            question: "Arrange these ancient battles chronologically. Which happened first?",
                            options: [
                                { id: 1, title: 'Battle of Marathon', year: '490 BCE', correct: true },
                                { id: 2, title: 'Battle of Thermopylae', year: '480 BCE', correct: false },
                                { id: 3, title: 'Battle of Gaugamela', year: '331 BCE', correct: false }
                            ]
                        },
                        {
                            question: "Which of these ancient scientific achievements came first?",
                            options: [
                                { id: 1, title: 'Eratosthenes measures Earth\'s circumference', year: '240 BCE', correct: true },
                                { id: 2, title: 'Archimedes\' principle of buoyancy', year: '212 BCE', correct: false },
                                { id: 3, title: 'Hipparchus creates trigonometry', year: '150 BCE', correct: false }
                            ]
                        }
                    ]
                },
                'medieval': {
                    'easy': [
                        {
                            question: "Which event marked the beginning of the Medieval period?",
                            options: [
                                { id: 1, title: 'Fall of the Western Roman Empire', year: '476 CE', correct: true },
                                { id: 2, title: 'Crowning of Charlemagne', year: '800 CE', correct: false },
                                { id: 3, title: 'Beginning of the First Crusade', year: '1096 CE', correct: false }
                            ]
                        },
                        {
                            question: "Which medieval development came next?",
                            options: [
                                { id: 1, title: 'Magna Carta Signed', year: '1215 CE', correct: true },
                                { id: 2, title: 'Black Death Pandemic', year: '1347 CE', correct: false },
                                { id: 3, title: 'Hundred Years\' War Begins', year: '1337 CE', correct: false }
                            ]
                        },
                        {
                            question: "Which event signaled the end of the Medieval period?",
                            options: [
                                { id: 1, title: 'Fall of Constantinople', year: '1453 CE', correct: true },
                                { id: 2, title: 'Columbus reaches the Americas', year: '1492 CE', correct: false },
                                { id: 3, title: 'Protestant Reformation Begins', year: '1517 CE', correct: false }
                            ]
                        }
                    ],
                    'medium': [
                        {
                            question: "Which medieval empire was established first?",
                            options: [
                                { id: 1, title: 'Byzantine Empire under Justinian', year: '527-565 CE', correct: true },
                                { id: 2, title: 'Carolingian Empire under Charlemagne', year: '800-814 CE', correct: false },
                                { id: 3, title: 'Holy Roman Empire under Otto I', year: '962 CE', correct: false }
                            ]
                        },
                        {
                            question: "Which medieval university was founded first?",
                            options: [
                                { id: 1, title: 'University of Bologna', year: '1088 CE', correct: true },
                                { id: 2, title: 'University of Oxford', year: '1096 CE', correct: false },
                                { id: 3, title: 'University of Paris', year: '1150 CE', correct: false }
                            ]
                        },
                        {
                            question: "Which medieval technological innovation came first?",
                            options: [
                                { id: 1, title: 'Heavy Plow in Europe', year: '~700 CE', correct: true },
                                { id: 2, title: 'Mechanical Clock', year: '~1300 CE', correct: false },
                                { id: 3, title: 'Gunpowder weapons in Europe', year: '~1320 CE', correct: false }
                            ]
                        }
                    ],
                    'hard': [
                        {
                            question: "Which medieval scholar's work was completed first?",
                            options: [
                                { id: 1, title: 'Al-Khwarizmi\'s algebra treatise', year: '~820 CE', correct: true },
                                { id: 2, title: 'Avicenna\'s Canon of Medicine', year: '1025 CE', correct: false },
                                { id: 3, title: 'Thomas Aquinas\' Summa Theologica', year: '1274 CE', correct: false }
                            ]
                        },
                        {
                            question: "Which medieval trade network was established first?",
                            options: [
                                { id: 1, title: 'Viking trade routes in Northern Europe', year: '~800 CE', correct: true },
                                { id: 2, title: 'Hanseatic League', year: '~1150 CE', correct: false },
                                { id: 3, title: 'Venetian trade monopoly in Mediterranean', year: '~1200 CE', correct: false }
                            ]
                        },
                        {
                            question: "Which medieval military order was founded first?",
                            options: [
                                { id: 1, title: 'Knights Hospitaller', year: '1099 CE', correct: true },
                                { id: 2, title: 'Knights Templar', year: '1119 CE', correct: false },
                                { id: 3, title: 'Teutonic Knights', year: '1190 CE', correct: false }
                            ]
                        }
                    ]
                },
                'renaissance': {
                    'easy': [
                        {
                            question: "Which Renaissance invention came first?",
                            options: [
                                { id: 1, title: 'Gutenberg Prints the Bible', year: '1455 CE', correct: true },
                                { id: 2, title: 'First Mechanical Watch', year: '1510 CE', correct: false },
                                { id: 3, title: 'Telescope Invented by Hans Lippershey', year: '1608 CE', correct: false }
                            ]
                        },
                        {
                            question: "Which Renaissance exploration happened first?",
                            options: [
                                { id: 1, title: 'Columbus Reaches the Americas', year: '1492 CE', correct: true },
                                { id: 2, title: 'Magellan\'s Circumnavigation Begins', year: '1519 CE', correct: false },
                                { id: 3, title: 'Cortés Conquers the Aztec Empire', year: '1521 CE', correct: false }
                            ]
                        },
                        {
                            question: "Which Renaissance artistic achievement came first?",
                            options: [
                                { id: 1, title: 'Leonardo da Vinci Paints the Mona Lisa', year: '1503 CE', correct: true },
                                { id: 2, title: 'Michelangelo Completes the Sistine Chapel Ceiling', year: '1512 CE', correct: false },
                                { id: 3, title: 'Shakespeare Writes Romeo and Juliet', year: '1595 CE', correct: false }
                            ]
                        }
                    ],
                    'medium': [
                        {
                            question: "Which Renaissance scientific discovery came first?",
                            options: [
                                { id: 1, title: 'Copernicus\' Heliocentric Model', year: '1543 CE', correct: true },
                                { id: 2, title: 'Vesalius\' Anatomy Book', year: '1543 CE', correct: false },
                                { id: 3, title: 'Kepler\'s Laws of Planetary Motion', year: '1609 CE', correct: false }
                            ]
                        },
                        {
                            question: "Which Renaissance political development happened first?",
                            options: [
                                { id: 1, title: 'Machiavelli Writes The Prince', year: '1513 CE', correct: true },
                                { id: 2, title: 'Peace of Augsburg', year: '1555 CE', correct: false },
                                { id: 3, title: 'Dutch Declaration of Independence', year: '1581 CE', correct: false }
                            ]
                        },
                        {
                            question: "Which Renaissance architectural achievement was completed first?",
                            options: [
                                { id: 1, title: 'Brunelleschi\'s Dome in Florence', year: '1436 CE', correct: true },
                                { id: 2, title: 'St. Peter\'s Basilica in Rome', year: '1626 CE', correct: false },
                                { id: 3, title: 'Palace of Versailles Construction Begins', year: '1631 CE', correct: false }
                            ]
                        }
                    ],
                    'hard': [
                        {
                            question: "Which Renaissance philosophical work was published first?",
                            options: [
                                { id: 1, title: 'Erasmus\' In Praise of Folly', year: '1511 CE', correct: true },
                                { id: 2, title: 'Thomas More\'s Utopia', year: '1516 CE', correct: false },
                                { id: 3, title: 'Francis Bacon\'s Novum Organum', year: '1620 CE', correct: false }
                            ]
                        },
                        {
                            question: "Which Renaissance banking innovation came first?",
                            options: [
                                { id: 1, title: 'Medici Bank Founded', year: '1397 CE', correct: true },
                                { id: 2, title: 'First Stock Exchange in Amsterdam', year: '1602 CE', correct: false },
                                { id: 3, title: 'Bank of England Established', year: '1694 CE', correct: false }
                            ]
                        },
                        {
                            question: "Which Renaissance musical development came first?",
                            options: [
                                { id: 1, title: 'Palestrina\'s Pope Marcellus Mass', year: '1562 CE', correct: true },
                                { id: 2, title: 'Monteverdi\'s L\'Orfeo (First Major Opera)', year: '1607 CE', correct: false },
                                { id: 3, title: 'First Violin Concerto by Torelli', year: '1698 CE', correct: false }
                            ]
                        }
                    ]
                },
                'modern': {
                    'easy': [
                        {
                            question: "Which modern revolution happened first?",
                            options: [
                                { id: 1, title: 'American Revolution', year: '1775-1783 CE', correct: true },
                                { id: 2, title: 'French Revolution', year: '1789-1799 CE', correct: false },
                                { id: 3, title: 'Latin American Independence Wars', year: '1808-1826 CE', correct: false }
                            ]
                        },
                        {
                            question: "Which modern invention came first?",
                            options: [
                                { id: 1, title: 'Steam Engine by James Watt', year: '1769 CE', correct: true },
                                { id: 2, title: 'Telegraph by Samuel Morse', year: '1837 CE', correct: false },
                                { id: 3, title: 'Telephone by Alexander Graham Bell', year: '1876 CE', correct: false }
                            ]
                        },
                        {
                            question: "Which modern war began first?",
                            options: [
                                { id: 1, title: 'First World War', year: '1914 CE', correct: true },
                                { id: 2, title: 'Russian Civil War', year: '1917 CE', correct: false },
                                { id: 3, title: 'Spanish Civil War', year: '1936 CE', correct: false }
                            ]
                        }
                    ],
                    'medium': [
                        {
                            question: "Which modern scientific theory was proposed first?",
                            options: [
                                { id: 1, title: 'Darwin\'s Theory of Evolution', year: '1859 CE', correct: true },
                                { id: 2, title: 'Mendeleev\'s Periodic Table', year: '1869 CE', correct: false },
                                { id: 3, title: 'Einstein\'s Theory of Relativity', year: '1905 CE', correct: false }
                            ]
                        },
                        {
                            question: "Which modern political movement began first?",
                            options: [
                                { id: 1, title: 'Abolition Movement in Britain', year: '1787 CE', correct: true },
                                { id: 2, title: 'Women\'s Suffrage Movement', year: '~1840s CE', correct: false },
                                { id: 3, title: 'Labor Movement', year: '~1860s CE', correct: false }
                            ]
                        },
                        {
                            question: "Which modern transportation development came first?",
                            options: [
                                { id: 1, title: 'First Commercial Railway', year: '1825 CE', correct: true },
                                { id: 2, title: 'First Automobile by Karl Benz', year: '1885 CE', correct: false },
                                { id: 3, title: 'Wright Brothers\' First Flight', year: '1903 CE', correct: false }
                            ]
                        }
                    ],
                    'hard': [
                        {
                            question: "Which modern philosophical work was published first?",
                            options: [
                                { id: 1, title: 'Kant\'s Critique of Pure Reason', year: '1781 CE', correct: true },
                                { id: 2, title: 'Hegel\'s Phenomenology of Spirit', year: '1807 CE', correct: false },
                                { id: 3, title: 'Marx\'s Das Kapital', year: '1867 CE', correct: false }
                            ]
                        },
                        {
                            question: "Which modern medical breakthrough came first?",
                            options: [
                                { id: 1, title: 'Jenner\'s Smallpox Vaccine', year: '1796 CE', correct: true },
                                { id: 2, title: 'Pasteur\'s Germ Theory', year: '1862 CE', correct: false },
                                { id: 3, title: 'Fleming\'s Discovery of Penicillin', year: '1928 CE', correct: false }
                            ]
                        },
                        {
                            question: "Which modern international organization was founded first?",
                            options: [
                                { id: 1, title: 'International Red Cross', year: '1863 CE', correct: true },
                                { id: 2, title: 'League of Nations', year: '1920 CE', correct: false },
                                { id: 3, title: 'International Labour Organization', year: '1919 CE', correct: false }
                            ]
                        }
                    ]
                },
                'contemporary': {
                    'easy': [
                        {
                            question: "Which contemporary event happened first?",
                            options: [
                                { id: 1, title: 'United Nations Founded', year: '1945 CE', correct: true },
                                { id: 2, title: 'NATO Established', year: '1949 CE', correct: false },
                                { id: 3, title: 'European Union Formed', year: '1993 CE', correct: false }
                            ]
                        },
                        {
                            question: "Which space exploration milestone came first?",
                            options: [
                                { id: 1, title: 'First Human in Space (Yuri Gagarin)', year: '1961 CE', correct: true },
                                { id: 2, title: 'First Moon Landing', year: '1969 CE', correct: false },
                                { id: 3, title: 'First Space Station (Salyut 1)', year: '1971 CE', correct: false }
                            ]
                        },
                        {
                            question: "Which technological innovation came first?",
                            options: [
                                { id: 1, title: 'World Wide Web Invented', year: '1989 CE', correct: true },
                                { id: 2, title: 'First Smartphone (iPhone)', year: '2007 CE', correct: false },
                                { id: 3, title: 'Social Media (Facebook)', year: '2004 CE', correct: false }
                            ]
                        }
                    ],
                    'medium': [
                        {
                            question: "Which Cold War event happened first?",
                            options: [
                                { id: 1, title: 'Berlin Blockade', year: '1948-1949 CE', correct: true },
                                { id: 2, title: 'Cuban Missile Crisis', year: '1962 CE', correct: false },
                                { id: 3, title: 'Vietnam War U.S. Involvement', year: '1955-1975 CE', correct: false }
                            ]
                        },
                        {
                            question: "Which environmental milestone came first?",
                            options: [
                                { id: 1, title: 'First Earth Day', year: '1970 CE', correct: true },
                                { id: 2, title: 'Montreal Protocol on Ozone Depletion', year: '1987 CE', correct: false },
                                { id: 3, title: 'Kyoto Protocol on Climate Change', year: '1997 CE', correct: false }
                            ]
                        },
                        {
                            question: "Which medical advancement came first?",
                            options: [
                                { id: 1, title: 'First Heart Transplant', year: '1967 CE', correct: true },
                                { id: 2, title: 'First Test Tube Baby', year: '1978 CE', correct: false },
                                { id: 3, title: 'Human Genome Project Completed', year: '2003 CE', correct: false }
                            ]
                        }
                    ],
                    'hard': [
                        {
                            question: "Which economic development came first?",
                            options: [
                                { id: 1, title: 'Bretton Woods System', year: '1944 CE', correct: true },
                                { id: 2, title: 'Nixon Shock (End of Gold Standard)', year: '1971 CE', correct: false },
                                { id: 3, title: 'Formation of World Trade Organization', year: '1995 CE', correct: false }
                            ]
                        },
                        {
                            question: "Which political transformation happened first?",
                            options: [
                                { id: 1, title: 'Decolonization of Africa Begins', year: '~1957 CE', correct: true },
                                { id: 2, title: 'Fall of the Berlin Wall', year: '1989 CE', correct: false },
                                { id: 3, title: 'Dissolution of the Soviet Union', year: '1991 CE', correct: false }
                            ]
                        },
                        {
                            question: "Which technological breakthrough came first?",
                            options: [
                                { id: 1, title: 'First Commercial Computer (UNIVAC I)', year: '1951 CE', correct: true },
                                { id: 2, title: 'First Personal Computer (Altair 8800)', year: '1975 CE', correct: false },
                                { id: 3, title: 'First Artificial Intelligence Program', year: '1956 CE', correct: false }
                            ]
                        }
                    ]
                }
            };

            // Timeline data
            let timelineData = {
                'ancient': {
                    title: 'Ancient History (3000 BCE - 500 CE)',
                    description: 'The ancient period saw the rise of early civilizations, the development of writing, and the foundation of major philosophical and religious traditions.',
                    events: [
                        {
                            title: 'Building of the Great Pyramid of Giza',
                            year: '2560 BCE',
                            description: 'One of the Seven Wonders of the Ancient World, built as a tomb for Pharaoh Khufu.'
                        },
                        {
                            title: 'Code of Hammurabi',
                            year: '1754 BCE',
                            description: 'One of the earliest and most complete legal codes from ancient Mesopotamia.'
                        },
                        {
                            title: 'Founding of the Roman Republic',
                            year: '509 BCE',
                            description: 'Established after the overthrow of the Roman Kingdom, introducing a new system of government.'
                        },
                        {
                            title: 'Birth of Democracy in Athens',
                            year: '508 BCE',
                            description: 'Cleisthenes introduces democratic reforms in Athens, creating the world\'s first democratic system.'
                        },
                        {
                            title: 'Birth of Jesus Christ',
                            year: '~4 BCE',
                            description: 'The birth of Jesus of Nazareth, central figure of Christianity and basis for the Western calendar system.'
                        },
                        {
                            title: 'Fall of the Western Roman Empire',
                            year: '476 CE',
                            description: 'The Western Roman Empire falls when Emperor Romulus Augustus is deposed by Odoacer, marking the end of Ancient Rome.'
                        }
                    ]
                },
                'medieval': {
                    title: 'Medieval Period (500 - 1500 CE)',
                    description: 'The medieval period was characterized by feudalism, the rise of powerful empires, and significant religious developments across the world.',
                    events: [
                        {
                            title: 'Justinian\'s Code',
                            year: '529 CE',
                            description: 'Emperor Justinian I codifies Roman law, creating a unified legal system for the Byzantine Empire.'
                        },
                        {
                            title: 'Rise of Islam',
                            year: '622 CE',
                            description: 'Muhammad\'s migration from Mecca to Medina marks the beginning of the Islamic calendar.'
                        },
                        {
                            title: 'Charlemagne Crowned Emperor',
                            year: '800 CE',
                            description: 'Charlemagne is crowned Emperor of the Romans by Pope Leo III, reviving the concept of a Western European empire.'
                        },
                        {
                            title: 'Magna Carta Signed',
                            year: '1215 CE',
                            description: 'King John of England signs the Magna Carta, limiting royal power and establishing that everyone is subject to the law.'
                        },
                        {
                            title: 'Black Death Pandemic',
                            year: '1347-1351 CE',
                            description: 'The bubonic plague kills an estimated 75-200 million people across Eurasia and North Africa.'
                        },
                        {
                            title: 'Fall of Constantinople',
                            year: '1453 CE',
                            description: 'The Byzantine Empire falls when Constantinople is captured by the Ottoman Empire, marking the end of the Medieval Period.'
                        }
                    ]
                },
                'renaissance': {
                    title: 'Renaissance & Early Modern (1500 - 1800 CE)',
                    description: 'A period of cultural, artistic, political, and economic "rebirth" following the Middle Ages, marked by renewed interest in classical learning.',
                    events: [
                        {
                            title: 'Gutenberg Prints the Bible',
                            year: '1455 CE',
                            description: 'Johannes Gutenberg produces the first printed Bible using movable type, revolutionizing information sharing.'
                        },
                        {
                            title: 'Columbus Reaches the Americas',
                            year: '1492 CE',
                            description: 'Christopher Columbus reaches the Americas, beginning the Columbian Exchange and European colonization.'
                        },
                        {
                            title: 'Leonardo da Vinci Paints the Mona Lisa',
                            year: '1503 CE',
                            description: 'Leonardo da Vinci begins painting the Mona Lisa, one of the most famous paintings in the world.'
                        },
                        {
                            title: 'Protestant Reformation Begins',
                            year: '1517 CE',
                            description: 'Martin Luther publishes his Ninety-five Theses, challenging the Catholic Church and starting the Protestant Reformation.'
                        },
                        {
                            title: 'Scientific Revolution',
                            year: '1543 CE',
                            description: 'Copernicus publishes "On the Revolutions of the Celestial Spheres," proposing a heliocentric model of the universe.'
                        },
                        {
                            title: 'American Declaration of Independence',
                            year: '1776 CE',
                            description: 'The United States declares independence from Great Britain, establishing a new nation.'
                        }
                    ]
                },
                'modern': {
                    title: 'Modern Era (1800 - 1945 CE)',
                    description: 'A period of rapid industrialization, technological advancement, and significant political and social changes across the globe.',
                    events: [
                        {
                            title: 'French Revolution',
                            year: '1789 CE',
                            description: 'The French Revolution begins with the storming of the Bastille, leading to radical social and political change.'
                        },
                        {
                            title: 'Industrial Revolution',
                            year: '1760-1840 CE',
                            description: 'A period of transition to new manufacturing processes in Europe and the United States.'
                        },
                        {
                            title: 'Abolition of Slavery in the US',
                            year: '1865 CE',
                            description: 'The 13th Amendment to the US Constitution abolishes slavery following the American Civil War.'
                        },
                        {
                            title: 'First World War',
                            year: '1914-1918 CE',
                            description: 'A global conflict that led to major political changes and the redrawing of national boundaries.'
                        },
                        {
                            title: 'Russian Revolution',
                            year: '1917 CE',
                            description: 'The Russian Revolution overthrows the Tsarist autocracy and leads to the creation of the Soviet Union.'
                        },
                        {
                            title: 'End of World War II',
                            year: '1945 CE',
                            description: 'World War II ends with the surrender of Nazi Germany and Imperial Japan, leading to a new global order.'
                        }
                    ]
                },
                'contemporary': {
                    title: 'Contemporary History (1945 - Present)',
                    description: 'The post-World War II era characterized by the Cold War, decolonization, rapid technological advancement, and globalization.',
                    events: [
                        {
                            title: 'United Nations Founded',
                            year: '1945 CE',
                            description: 'The United Nations is established to promote international cooperation after World War II.'
                        },
                        {
                            title: 'First Human in Space',
                            year: '1961 CE',
                            description: 'Yuri Gagarin becomes the first human to journey into outer space, completing one orbit of Earth.'
                        },
                        {
                            title: 'Moon Landing',
                            year: '1969 CE',
                            description: 'Neil Armstrong becomes the first person to walk on the Moon during the Apollo 11 mission.'
                        },
                        {
                            title: 'Fall of the Berlin Wall',
                            year: '1989 CE',
                            description: 'The Berlin Wall falls, symbolizing the end of the Cold War and the reunification of Germany.'
                        },
                        {
                            title: 'World Wide Web Invented',
                            year: '1989 CE',
                            description: 'Tim Berners-Lee invents the World Wide Web, revolutionizing global communication and information sharing.'
                        },
                        {
                            title: 'COVID-19 Pandemic',
                            year: '2019-2023 CE',
                            description: 'A global pandemic caused by the SARS-CoV-2 virus, leading to significant social and economic disruption worldwide.'
                        }
                    ]
                }
            };

            // Create a deep copy of the original timeline data for resetting
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

                // Timeline event listeners
                prevEventBtn.addEventListener('click', showPreviousTimelineEvent);
                nextEventBtn.addEventListener('click', showNextTimelineEvent);
                eraSelector.addEventListener('change', updateTimelineEra);

                // Set initial difficulty
                setDifficulty('easy');

                // Initialize leaderboard
                updateLeaderboard();
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

                // Reset timeline
                updateTimeline();
            }

            // Start the timer
            function startTimer() {
                clearInterval(timerInterval);
                timerPaused = false;
                timerInterval = setInterval(updateTimer, 1000);
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
                document.getElementById('time-display').textContent =
                    `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
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

                // Make sure we don't exceed the available questions
                if (currentQuestionIndex >= questions.length) {
                    console.log("No more questions available, showing level complete");
                    showLevelCompleteModal();
                    return;
                }

                // Get the current question
                const currentQuestion = questions[currentQuestionIndex];

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

                // Calculate final time
                const elapsedTime = Math.floor((Date.now() - startTime) / 1000);
                const minutes = Math.floor(elapsedTime / 60);
                const seconds = elapsedTime % 60;
                const timeString = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

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
                document.getElementById('completed-level-info').textContent =
                    `${eraNames[currentEra]} - ${currentDifficulty.charAt(0).toUpperCase() + currentDifficulty.slice(1)}`;

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

            // Show hint modal
            function showHint() {
                if (!gameActive || powerupsAvailable <= 0) return;

                // Get a random hint for the current era
                const hints = historicalHints[currentEra];
                const randomHint = hints[Math.floor(Math.random() * hints.length)];
                document.getElementById('hint-text').textContent = randomHint;

                // Show the hint modal
                hintModal.classList.remove('hidden');
                hintsRemainingDisplay.textContent = hintsRemaining;
            }

            // Close hint modal
            function closeHint() {
                hintModal.classList.add('hidden');
            }

            // Apply hint to reveal correct answer
            function applyHint() {
                if (hintsRemaining <= 0) return;

                hintsRemaining--;
                powerupsAvailable--;
                hintsRemainingDisplay.textContent = hintsRemaining;
                powerupsAvailableDisplay.textContent = powerupsAvailable;

                // Highlight the correct answer in the event choices
                const buttons = eventChoices.querySelectorAll('button');
                buttons.forEach(button => {
                    if (button.textContent.includes('Great Pyramid')) {
                        button.classList.add('bg-yellow-600');
                        button.classList.remove('bg-neutral-700', 'hover:bg-neutral-600');
                    }
                });

                // Close the hint modal
                closeHint();
            }

            // Add time power-up
            function addTime() {
                if (!gameActive || powerupsAvailable <= 0) return;

                // Add 30 seconds to the timer
                startTime += 30000; // 30 seconds in milliseconds
                powerupsAvailable--;
                powerupsAvailableDisplay.textContent = powerupsAvailable;

                // Show a notification
                const notification = document.createElement('div');
                notification.className = 'fixed top-4 right-4 bg-blue-600 text-white px-4 py-2 rounded-lg shadow-lg z-50';
                notification.textContent = '+30 seconds added!';
                document.body.appendChild(notification);

                // Remove the notification after 2 seconds
                setTimeout(() => {
                    notification.remove();
                }, 2000);
            }

            // Skip question power-up
            function skipQuestion() {
                if (!gameActive || powerupsAvailable <= 0) return;

                powerupsAvailable--;
                powerupsAvailableDisplay.textContent = powerupsAvailable;

                // Skip the current question
                eventChoiceModal.classList.add('hidden');

                // Increment the question index for the next question
                currentQuestionIndex++;

                // Show a notification
                const notification = document.createElement('div');
                notification.className = 'fixed top-4 right-4 bg-purple-600 text-white px-4 py-2 rounded-lg shadow-lg z-50';
                notification.textContent = 'Question skipped!';
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

            // Save score to leaderboard
            function saveScore() {
                const playerName = playerNameInput.value.trim();
                if (!playerName) {
                    alert('Please enter your name to save your score.');
                    return;
                }

                // Calculate accuracy
                const accuracy = Math.round((correctChoices / totalChoices) * 100);

                // Get time
                const elapsedTime = Math.floor((Date.now() - startTime) / 1000);
                const minutes = Math.floor(elapsedTime / 60);
                const seconds = elapsedTime % 60;
                const timeString = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

                // Create new score entry
                const newScore = {
                    player: playerName,
                    era: currentEra.charAt(0).toUpperCase() + currentEra.slice(1),
                    score: score,
                    time: timeString,
                    accuracy: `${accuracy}%`
                };

                // Add to leaderboard and sort
                leaderboard.push(newScore);
                leaderboard.sort((a, b) => b.score - a.score);

                // Update ranks
                leaderboard = leaderboard.map((entry, index) => {
                    return { ...entry, rank: index + 1 };
                });

                // Keep only top 10
                if (leaderboard.length > 10) {
                    leaderboard = leaderboard.slice(0, 10);
                }

                // Update leaderboard display
                updateLeaderboard();

                // Clear input and show confirmation
                playerNameInput.value = '';
                alert('Score saved successfully!');

                // In a real application, you would send this data to your server
                // to be stored in a database
                console.log('Score saved:', newScore);
            }

            // Update leaderboard display
            function updateLeaderboard() {
                leaderboardBody.innerHTML = '';

                leaderboard.forEach(entry => {
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

            // Update the timeline based on the selected era
            function updateTimelineEra() {
                currentTimelineEra = eraSelector.value;
                currentTimelineEventIndex = 0;
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
                const totalEvents = timelineData[currentTimelineEra].events.length;
                if (currentTimelineEventIndex < totalEvents - 1) {
                    currentTimelineEventIndex++;
                    updateTimeline();
                }
            }

            // Start the game
            function startGame() {
                gameActive = true;
                currentEra = eraSelector.value;
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
                startTimer();

                // Load the first level
                loadLevel();

                // For demo purposes, show the event choice modal after a short delay
                setTimeout(showEventChoiceModal, 1500);
            }

            // Initialize the timeline
            updateTimeline();

            // Initialize the game
            initGame();
        });
    </script>
</x-layouts.app>