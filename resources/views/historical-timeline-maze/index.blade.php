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
                            <button id="easy-btn" class="flex-1 px-4 py-2 text-white rounded-lg border border-green-500/30 bg-green-500/10 transition-all duration-300 hover:bg-green-500/20 hover:border-green-500/50 hover:shadow-lg hover:shadow-green-900/20 group active">
                                <span class="text-green-400 group-hover:text-green-300 transition-colors">Easy</span>
                            </button>
                            <button id="medium-btn" class="flex-1 px-4 py-2 text-white rounded-lg border border-yellow-500/30 bg-yellow-500/10 transition-all duration-300 hover:bg-yellow-500/20 hover:border-yellow-500/50 hover:shadow-lg hover:shadow-yellow-900/20 group">
                                <span class="text-yellow-400 group-hover:text-yellow-300 transition-colors">Medium</span>
                            </button>
                            <button id="hard-btn" class="flex-1 px-4 py-2 text-white rounded-lg border border-red-500/30 bg-red-500/10 transition-all duration-300 hover:bg-red-500/20 hover:border-red-500/50 hover:shadow-lg hover:shadow-red-900/20 group">
                                <span class="text-red-400 group-hover:text-red-300 transition-colors">Hard</span>
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
                    <h2 class="text-lg font-semibold text-white mb-2">Timeline Maze</h2>

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
                                <p class="text-neutral-400 text-center mb-6">You've successfully navigated this era of history!</p>

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
                    <h2 class="text-lg font-semibold text-white mb-2">Historical Timeline</h2>

                    <!-- Era Overview -->
                    <div class="mb-2 p-2 bg-neutral-700/30 rounded-lg">
                        <h3 id="current-era-title" class="text-base font-semibold text-emerald-400 mb-2">Ancient History (3000 BCE - 500 CE)</h3>
                        <p id="era-description" class="text-sm text-neutral-300 mb-3">The ancient period saw the rise of early civilizations, the development of writing, and the foundation of major philosophical and religious traditions.</p>
                    </div>

                    <!-- Timeline Visualization -->
                    <div class="flex-1 overflow-y-auto pr-2 timeline-container">
                        <div class="relative">
                            <!-- Timeline Line -->
                            <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-emerald-500/30"></div>

                            <!-- Timeline Events -->
                            <div id="timeline-events" class="space-y-2 pl-12 relative">
                                <!-- Event 1 -->
                                <div class="timeline-event">
                                    <div class="absolute left-2 w-6 h-6 rounded-full bg-emerald-500/20 border-2 border-emerald-500 flex items-center justify-center -translate-x-1/2">
                                        <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                                    </div>
                                    <div class="bg-neutral-800 p-2 rounded-lg border border-neutral-700">
                                        <div class="flex justify-between items-start mb-1">
                                            <h4 class="text-sm font-medium text-white">Building of the Great Pyramid of Giza</h4>
                                            <span class="text-xs text-emerald-400">2560 BCE</span>
                                        </div>
                                        <p class="text-xs text-neutral-400">One of the Seven Wonders of the Ancient World, built as a tomb for Pharaoh Khufu.</p>
                                    </div>
                                </div>

                                <!-- Event 2 -->
                                <div class="timeline-event">
                                    <div class="absolute left-2 w-6 h-6 rounded-full bg-neutral-700 border-2 border-neutral-600 flex items-center justify-center -translate-x-1/2">
                                        <div class="w-2 h-2 rounded-full bg-neutral-500"></div>
                                    </div>
                                    <div class="bg-neutral-800 p-2 rounded-lg border border-neutral-700">
                                        <div class="flex justify-between items-start mb-1">
                                            <h4 class="text-sm font-medium text-white">Code of Hammurabi</h4>
                                            <span class="text-xs text-neutral-400">1754 BCE</span>
                                        </div>
                                        <p class="text-xs text-neutral-400">One of the earliest and most complete legal codes from ancient Mesopotamia.</p>
                                    </div>
                                </div>

                                <!-- Event 3 -->
                                <div class="timeline-event">
                                    <div class="absolute left-2 w-6 h-6 rounded-full bg-neutral-700 border-2 border-neutral-600 flex items-center justify-center -translate-x-1/2">
                                        <div class="w-2 h-2 rounded-full bg-neutral-500"></div>
                                    </div>
                                    <div class="bg-neutral-800 p-2 rounded-lg border border-neutral-700">
                                        <div class="flex justify-between items-start mb-1">
                                            <h4 class="text-sm font-medium text-white">Founding of the Roman Republic</h4>
                                            <span class="text-xs text-neutral-400">509 BCE</span>
                                        </div>
                                        <p class="text-xs text-neutral-400">Established after the overthrow of the Roman Kingdom, introducing a new system of government.</p>
                                    </div>
                                </div>

                                <!-- Event 4 -->
                                <div class="timeline-event">
                                    <div class="absolute left-2 w-6 h-6 rounded-full bg-neutral-700 border-2 border-neutral-600 flex items-center justify-center -translate-x-1/2">
                                        <div class="w-2 h-2 rounded-full bg-neutral-500"></div>
                                    </div>
                                    <div class="bg-neutral-800 p-2 rounded-lg border border-neutral-700">
                                        <div class="flex justify-between items-start mb-1">
                                            <h4 class="text-sm font-medium text-white">Birth of Democracy in Athens</h4>
                                            <span class="text-xs text-neutral-400">508 BCE</span>
                                        </div>
                                        <p class="text-xs text-neutral-400">Cleisthenes introduces democratic reforms in Athens, creating the world's first democratic system.</p>
                                    </div>
                                </div>

                                <!-- Event 5 -->
                                <div class="timeline-event">
                                    <div class="absolute left-2 w-6 h-6 rounded-full bg-neutral-700 border-2 border-neutral-600 flex items-center justify-center -translate-x-1/2">
                                        <div class="w-2 h-2 rounded-full bg-neutral-500"></div>
                                    </div>
                                    <div class="bg-neutral-800 p-2 rounded-lg border border-neutral-700">
                                        <div class="flex justify-between items-start mb-1">
                                            <h4 class="text-sm font-medium text-white">Birth of Jesus Christ</h4>
                                            <span class="text-xs text-neutral-400">~4 BCE</span>
                                        </div>
                                        <p class="text-xs text-neutral-400">The birth of Jesus of Nazareth, central figure of Christianity and basis for the Western calendar system.</p>
                                    </div>
                                </div>

                                <!-- Event 6 -->
                                <div class="timeline-event">
                                    <div class="absolute left-2 w-6 h-6 rounded-full bg-neutral-700 border-2 border-neutral-600 flex items-center justify-center -translate-x-1/2">
                                        <div class="w-2 h-2 rounded-full bg-neutral-500"></div>
                                    </div>
                                    <div class="bg-neutral-800 p-2 rounded-lg border border-neutral-700">
                                        <div class="flex justify-between items-start mb-1">
                                            <h4 class="text-sm font-medium text-white">Fall of the Western Roman Empire</h4>
                                            <span class="text-xs text-neutral-400">476 CE</span>
                                        </div>
                                        <p class="text-xs text-neutral-400">The Western Roman Empire falls when Emperor Romulus Augustus is deposed by Odoacer, marking the end of Ancient Rome.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Timeline Controls -->
                    <div class="mt-2 flex justify-between items-center">
                        <button id="prev-event-btn" class="px-2 py-1 rounded-lg border border-emerald-500/30 bg-emerald-500/10 transition-all duration-300 hover:bg-emerald-500/20 hover:border-emerald-500/50 hover:shadow-lg hover:shadow-emerald-900/20 flex items-center gap-1 group">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400 group-hover:text-emerald-300 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                            <span class="text-sm font-medium text-emerald-400 group-hover:text-emerald-300 transition-colors">Previous</span>
                        </button>
                        <span id="timeline-progress" class="text-xs text-neutral-400">1/6 Events</span>
                        <button id="next-event-btn" class="px-2 py-1 rounded-lg border border-emerald-500/30 bg-emerald-500/10 transition-all duration-300 hover:bg-emerald-500/20 hover:border-emerald-500/50 hover:shadow-lg hover:shadow-emerald-900/20 flex items-center gap-1 group">
                            <span class="text-sm font-medium text-emerald-400 group-hover:text-emerald-300 transition-colors">Next</span>
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
                easyBtn.addEventListener('click', () => setDifficulty('easy'));
                mediumBtn.addEventListener('click', () => setDifficulty('medium'));
                hardBtn.addEventListener('click', () => setDifficulty('hard'));
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

                // Update UI
                easyBtn.classList.remove('active');
                mediumBtn.classList.remove('active');
                hardBtn.classList.remove('active');

                if (difficulty === 'easy') {
                    easyBtn.classList.add('active');
                } else if (difficulty === 'medium') {
                    mediumBtn.classList.add('active');
                } else {
                    hardBtn.classList.add('active');
                }
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

                // In a real implementation, this would show real historical events based on the current era
                eventChoices.innerHTML = '';

                // Make sure the feedback is hidden
                if (choiceFeedback) {
                    choiceFeedback.classList.add('hidden');
                }

                // Get events based on the current question index
                let sampleEvents;

                if (currentQuestionIndex === 0) {
                    console.log("Loading first question set");
                    sampleEvents = [
                        { id: 1, title: 'Building of the Great Pyramid of Giza', year: '2560 BCE' },
                        { id: 2, title: 'Birth of Democracy in Athens', year: '508 BCE' },
                        { id: 3, title: 'Founding of the Roman Republic', year: '509 BCE' }
                    ];
                } else if (currentQuestionIndex === 1) {
                    console.log("Loading second question set");
                    sampleEvents = [
                        { id: 1, title: 'Code of Hammurabi', year: '1754 BCE' },
                        { id: 2, title: 'Trojan War', year: '1200 BCE' },
                        { id: 3, title: 'First Olympic Games', year: '776 BCE' }
                    ];
                } else {
                    console.log("Loading third question set");
                    sampleEvents = [
                        { id: 1, title: 'Birth of Jesus Christ', year: '~4 BCE' },
                        { id: 2, title: 'Assassination of Julius Caesar', year: '44 BCE' },
                        { id: 3, title: 'Construction of the Colosseum', year: '80 CE' }
                    ];
                }

                // Store the current sample events in a global variable for reference
                window.sampleEvents = sampleEvents;

                // Create choice buttons
                sampleEvents.forEach(event => {
                    const button = document.createElement('button');
                    button.className = 'w-full text-left p-3 bg-neutral-700 hover:bg-neutral-600 rounded-lg transition-colors';
                    button.innerHTML = `
                        <div class="font-medium text-white">${event.title}</div>
                        <div class="text-xs text-neutral-400">${event.year}</div>
                    `;
                    button.addEventListener('click', () => makeChoice(event.id));
                    eventChoices.appendChild(button);
                });

                // Show the modal
                eventChoiceModal.classList.remove('hidden');
            }

            // Handle player's choice
            function makeChoice(eventId) {
                totalChoices++;
                console.log("makeChoice called with eventId:", eventId);

                // For demo purposes, let's say event ID 1 is always correct
                const isCorrect = eventId === 1;

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
                    const correctEvent = window.sampleEvents.find(event => event.id === 1);

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
                const correctEvent = window.sampleEvents.find(event => event.id === 1);
                const selectedEvent = window.sampleEvents.find(event => event.id === eventId);

                buttons.forEach(button => {
                    button.disabled = true;
                    // Highlight the correct answer in green
                    if (button.textContent.includes(correctEvent.title)) {
                        button.classList.add('bg-green-600');
                        button.classList.remove('bg-neutral-700', 'hover:bg-neutral-600');
                    }
                    // Highlight the incorrect selected answer in red
                    else if (eventId !== 1 && button.textContent.includes(selectedEvent.title)) {
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
                // Create a new event for the timeline
                const studentAnswerEvent = {
                    title: isCorrect ? `✓ ${answerTitle}` : `✗ ${answerTitle}`,
                    year: answerYear,
                    description: isCorrect
                        ? `You correctly identified this historical event.`
                        : `You selected this event, but the correct answer was: ${correctTitle} (${correctYear}).`
                };

                // Add the student's answer to the timeline data
                const currentEvents = timelineData[currentTimelineEra].events;

                // If we're at the beginning of the game, replace the first event
                // Otherwise, add a new event
                if (currentQuestionIndex === 0) {
                    timelineData[currentTimelineEra].events[0] = studentAnswerEvent;
                } else if (currentQuestionIndex < currentEvents.length) {
                    // Replace an existing event
                    timelineData[currentTimelineEra].events[currentQuestionIndex] = studentAnswerEvent;
                } else {
                    // Add a new event
                    timelineData[currentTimelineEra].events.push(studentAnswerEvent);
                }

                // Update the timeline display
                currentTimelineEventIndex = currentQuestionIndex;
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

                // For demo purposes, show the level complete modal after 3 choices
                if (totalChoices >= 3) {
                    console.log("Showing level complete modal");
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

                // Update UI
                document.getElementById('final-score').textContent = score;
                document.getElementById('final-time').textContent = timeString;

                // Show the modal
                levelCompleteModal.classList.remove('hidden');
            }

            // Go to the next level
            function nextLevel() {
                currentLevel++;
                levelCompleteModal.classList.add('hidden');

                // Start a new timer
                startTime = Date.now();
                startTimer();

                // Load the next level
                loadLevel();

                // For demo purposes, show the event choice modal after a short delay
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

            // Update the timeline display
            function updateTimeline() {
                const era = timelineData[currentTimelineEra];
                const events = era.events;
                const totalEvents = events.length;

                // Update era information
                currentEraTitle.textContent = era.title;
                eraDescription.textContent = era.description;

                // Update progress indicator
                timelineProgress.textContent = `${currentTimelineEventIndex + 1}/${totalEvents} Events`;

                // Enable/disable navigation buttons
                prevEventBtn.disabled = currentTimelineEventIndex === 0;
                nextEventBtn.disabled = currentTimelineEventIndex === totalEvents - 1;

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

                // Generate timeline HTML
                let timelineHTML = '';

                events.forEach((event, index) => {
                    const isActive = index === currentTimelineEventIndex;
                    const isPast = index < currentTimelineEventIndex;

                    timelineHTML += `
                        <div class="timeline-event">
                            <div class="absolute left-2 w-6 h-6 rounded-full ${isActive ? 'bg-emerald-500/20 border-2 border-emerald-500' : isPast ? 'bg-emerald-700/20 border-2 border-emerald-700' : 'bg-neutral-700 border-2 border-neutral-600'} flex items-center justify-center -translate-x-1/2">
                                <div class="w-2 h-2 rounded-full ${isActive ? 'bg-emerald-500' : isPast ? 'bg-emerald-700' : 'bg-neutral-500'}"></div>
                            </div>
                            <div class="bg-neutral-800 p-3 rounded-lg border ${isActive ? 'border-emerald-500/30' : 'border-neutral-700'}">
                                <div class="flex justify-between items-start mb-1">
                                    <h4 class="text-sm font-medium ${isActive ? 'text-emerald-400' : 'text-white'}">${event.title}</h4>
                                    <span class="text-xs ${isActive ? 'text-emerald-400' : 'text-neutral-400'}">${event.year}</span>
                                </div>
                                <p class="text-xs text-neutral-400">${event.description}</p>
                            </div>
                        </div>
                    `;
                });

                timelineEvents.innerHTML = timelineHTML;

                // Scroll to the active event
                const activeEvent = timelineEvents.querySelector('.timeline-event:nth-child(' + (currentTimelineEventIndex + 1) + ')');
                if (activeEvent) {
                    activeEvent.scrollIntoView({ behavior: 'smooth', block: 'center' });
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

                // Update timeline
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