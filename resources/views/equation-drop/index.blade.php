<x-layouts.app>
    <div class="flex h-full w-full flex-1 flex-col gap-6 text-gray-100 p-6 border border-emerald-500 rounded-lg">
        <!-- Header Section with Game Stats -->
        <div class="bg-neutral-800 rounded-xl border border-neutral-700 p-4 shadow-lg">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-emerald-500/10 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h8m-4 8V5m-6 8h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold text-white">Equation Drop</h1>
                </div>

                <!-- Compact Game Stats -->
                <div class="flex items-center gap-6 px-4 py-2 bg-neutral-900/70 rounded-lg border border-neutral-700">
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-emerald-400 font-medium">LEVEL</span>
                        <span id="level-display" class="text-lg font-bold text-white">1</span>
                    </div>
                    <div class="h-8 w-px bg-neutral-700"></div>
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-emerald-400 font-medium">SCORE</span>
                        <span id="score-display" class="text-lg font-bold text-white">0</span>
                    </div>
                    <div class="h-8 w-px bg-neutral-700"></div>
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-emerald-400 font-medium">TIME</span>
                        <span id="timer-display" class="text-lg font-bold text-white">60s</span>
                    </div>
                    <div class="h-8 w-px bg-neutral-700"></div>
                    <button id="results-btn" class="flex items-center gap-1 px-2 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        Results
                    </button>
                </div>

                <a href="{{ route('subjects.specialized.stem') }}" class="flex items-center gap-2 px-5 py-2.5 rounded-lg border border-emerald-500/30 bg-emerald-500/10 transition-all duration-300 hover:bg-emerald-500/20 hover:border-emerald-500/50 hover:shadow-lg hover:shadow-emerald-900/20 group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400 group-hover:text-emerald-300 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span class="text-base font-medium text-emerald-400 group-hover:text-emerald-300 transition-colors">Back to STEM Track</span>
                </a>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 flex-1">
            <!-- Left Column: Current Equation -->
            <div class="md:col-span-1">
                <div class="bg-neutral-800 rounded-xl border border-neutral-700 p-4 shadow-lg h-full">
                    <h2 class="text-lg font-semibold text-white mb-3">Current Equation</h2>
                    <div class="min-h-[100px] bg-neutral-700/50 rounded-lg flex items-center justify-center p-4 mb-4">
                        <div id="current-equation" class="flex items-center justify-center text-3xl font-bold space-x-4">
                            <span class="text-white">F</span>
                            <span class="text-white">=</span>
                            <!-- Animated Dropzone -->
                            <div id="equation-dropzone" class="w-16 h-16 border-2 border-dashed border-emerald-500/50 rounded-lg flex items-center justify-center bg-neutral-800/70 dropzone-animation"
                                ondragover="event.preventDefault();"
                                ondrop="drop(event)">
                                <span class="text-yellow-400 font-bold text-4xl animate-bounce">?</span>
                                <!-- Arrow indicators pointing to the dropzone -->
                                <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 text-emerald-400 animate-pulse">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                    </svg>
                                </div>
                                <div class="absolute -bottom-8 left-1/2 transform -translate-x-1/2 text-emerald-400 animate-pulse">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                    </svg>
                                </div>
                            </div>
                            <span class="text-white">×</span>
                            <span class="text-white">a</span>
                        </div>
                    </div>
                    <div class="text-center mb-6">
                        <p id="equation-hint" class="text-sm text-emerald-400">Hint: Newton's Second Law of Motion</p>
                    </div>
                    <div class="bg-neutral-900/70 rounded-lg p-3">
                        <p class="text-xs text-emerald-400 mb-1">Coming up next:</p>
                        <p id="next-equation" class="text-lg text-center text-gray-300">H<sub>2</sub> + O<sub>2</sub> = ?</p>
                    </div>
                </div>
            </div>

            <!-- Right Column: Drag Area and Options -->
            <div class="md:col-span-2 flex flex-col gap-6">
                <!-- Draggable Elements -->
                <div class="bg-neutral-800 rounded-xl border border-neutral-700 p-4 shadow-lg">
                    <h2 class="text-lg font-semibold text-white mb-3">Drag the correct answer:</h2>
                    <div id="answer-options" class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        <!-- Card-style answer boxes - will be populated by JavaScript -->
                    </div>
                </div>

                <!-- Feedback Area -->
                <div class="bg-neutral-800 rounded-xl border border-neutral-700 p-4 shadow-lg">
                    <h2 class="text-lg font-semibold text-white mb-3">Instructions</h2>
                    <p class="text-gray-300 mb-2">Drag the correct symbol to complete the equation. The question mark shows where to drop your answer.</p>
                    <p class="text-yellow-400 font-bold mb-2">Remember: You only get one try per question!</p>
                    <div id="feedback-area" class="p-3 rounded-lg bg-neutral-900/70 text-center min-h-[60px] flex items-center justify-center">
                        <p class="text-neutral-400">Drag an element to the question mark...</p>
                    </div>
                </div>

                <!-- Game Controls -->
                <div class="bg-neutral-800 rounded-xl border border-neutral-700 p-4 shadow-lg">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <button id="check-answer-btn" class="w-full px-4 py-3 bg-emerald-600 hover:bg-emerald-500 text-white rounded-lg transition-colors flex items-center justify-center text-base font-medium" onclick="checkAnswer()">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            Check Answer
                        </button>
                        <button id="reset-btn" class="w-full px-4 py-3 bg-red-600 hover:bg-red-500 text-white rounded-lg transition-colors flex items-center justify-center text-base font-medium" onclick="resetEquation()">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Reset
                        </button>
                        <button id="next-btn" class="w-full px-4 py-3 bg-blue-600 hover:bg-blue-500 text-white rounded-lg transition-colors flex items-center justify-center text-base font-medium" onclick="nextEquation()" disabled>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                            </svg>
                            Next Equation
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Difficulty Selection Modal -->
        <div id="difficulty-modal" class="fixed inset-0 bg-black/80 flex items-center justify-center z-50">
            <div class="bg-neutral-800 rounded-xl border border-emerald-500 p-6 shadow-lg max-w-md w-full">
                <h2 class="text-2xl font-bold text-white mb-4 text-center">Select Difficulty</h2>
                <p class="text-gray-300 mb-4 text-center">Choose a difficulty level to start the game:</p>

                <!-- How to Play Instructions -->
                <div class="bg-neutral-900/70 p-4 rounded-lg mb-6">
                    <h3 class="text-lg font-bold text-white mb-2 text-center">How to Play</h3>
                    <p class="text-gray-300 mb-2">1. Drag the correct answer to the question mark</p>
                    <p class="text-gray-300 mb-2">2. Click "Check Answer" to verify</p>
                    <p class="text-gray-300">3. The game will automatically move to the next question</p>
                    <p class="text-gray-300 font-bold mt-2 text-center text-yellow-400">Remember: You only get one try per question!</p>
                </div>

                <div class="grid grid-cols-1 gap-4 mb-6">
                    <button class="difficulty-btn w-full px-4 py-4 bg-green-600 hover:bg-green-500 text-white rounded-lg transition-colors text-lg font-medium" data-difficulty="easy">
                        Easy <span class="text-sm">(<span class="easy-timer-display">60</span>s)</span>
                    </button>
                    <button class="difficulty-btn w-full px-4 py-4 bg-yellow-600 hover:bg-yellow-500 text-white rounded-lg transition-colors text-lg font-medium" data-difficulty="medium">
                        Medium <span class="text-sm">(<span class="medium-timer-display">45</span>s)</span>
                    </button>
                    <button class="difficulty-btn w-full px-4 py-4 bg-red-600 hover:bg-red-500 text-white rounded-lg transition-colors text-lg font-medium" data-difficulty="hard">
                        Hard <span class="text-sm">(<span class="hard-timer-display">30</span>s)</span>
                    </button>
                </div>

                <div class="flex justify-between items-center">
                    <p class="text-sm text-gray-400">Select a difficulty to begin the challenge!</p>
                    <button id="view-results-btn" class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg">
                        View Results
                    </button>
                </div>
            </div>
        </div>

        <!-- Results Modal -->
        <div id="results-modal" class="fixed inset-0 bg-black/80 flex items-center justify-center z-50 hidden">
            <div class="bg-neutral-800 rounded-xl border border-emerald-500 p-6 shadow-lg max-w-4xl w-full max-h-[80vh] overflow-y-auto">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-bold text-white">Your Results</h2>
                    <button id="close-results-btn" class="p-1 rounded-full bg-neutral-700 hover:bg-neutral-600 text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div id="results-content" class="text-white">
                    <!-- Results content will be loaded here -->
                    <div class="flex justify-center items-center py-12">
                        <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-emerald-500"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Dropzone animation */
        @keyframes glowing {
            0% { box-shadow: 0 0 5px rgba(16, 185, 129, 0.4); }
            50% { box-shadow: 0 0 20px rgba(16, 185, 129, 0.6); }
            100% { box-shadow: 0 0 5px rgba(16, 185, 129, 0.4); }
        }

        .dropzone-animation {
            animation: glowing 2s infinite;
            position: relative;
        }
    </style>

    <script>
        // Pass PHP variables to JavaScript
        window.equationDropSettings = {
            easy_timer_seconds: {{ $equationDrop->easy_timer_seconds ?? 60 }},
            medium_timer_seconds: {{ $equationDrop->medium_timer_seconds ?? 45 }},
            hard_timer_seconds: {{ $equationDrop->hard_timer_seconds ?? 30 }}
        };
    </script>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Game state variables
            let currentAnswer = null;
            let currentEquationIndex = 0;
            let score = 0;
            let level = 1;
            let timer = 60;
            let timerInterval = null;
            let isCorrect = false;
            let currentDifficulty = null;

            // Timer settings from database (defaults will be overridden when loaded from server)
            let timerSettings = {
                easy_timer_seconds: 60,
                medium_timer_seconds: 45,
                hard_timer_seconds: 30
            };

            // Get timer settings from the window object (set in the separate script tag)
            if (window.equationDropSettings) {
                timerSettings = window.equationDropSettings;
            }

            // Game equations by difficulty - will be loaded from the server
            let equations = {
                easy: [],
                medium: [],
                hard: []
            };

            // Function to load questions from the server
            function loadQuestionsFromServer(difficulty) {
                return fetch(`{{ route('subjects.specialized.stem.equation-drop.questions') }}?difficulty=${difficulty}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.questions && data.questions.length > 0) {
                            // Store timer settings from the server
                            if (data.timer_settings) {
                                timerSettings = data.timer_settings;
                                console.log('Timer settings loaded:', timerSettings);
                            }

                            // Transform the data to match our expected format
                            return data.questions.map(q => {
                                return {
                                    display: q.display_elements.map(el => el.element),
                                    answer: q.answer,
                                    hint: q.hint,
                                    options: q.options,
                                    points: q.points || 100
                                };
                            });
                        } else {
                            console.error('No questions found for difficulty:', difficulty);
                            // Fallback to default questions if server returns none
                            return getDefaultQuestions(difficulty);
                        }
                    })
                    .catch(error => {
                        console.error('Error loading questions:', error);
                        // Fallback to default questions if there's an error
                        return getDefaultQuestions(difficulty);
                    });
            }

            // Fallback questions in case the server request fails
            function getDefaultQuestions(difficulty) {
                const defaultQuestions = {
                    easy: [
                        {
                            display: ['F', '=', '?', '×', 'a'],
                            answer: 'm',
                            hint: "Hint: Newton's Second Law of Motion",
                            options: [
                                { value: 'm', type: 'Variable' },
                                { value: 'p', type: 'Variable' },
                                { value: 'E', type: 'Variable' },
                                { value: 'v', type: 'Variable' }
                            ],
                            points: 100
                        },
                        {
                            display: ['H', '<sub>2</sub>', '+', 'O', '<sub>2</sub>', '=', '?'],
                            answer: 'H₂O',
                            hint: "Hint: Water formation chemical equation",
                            options: [
                                { value: 'H₂O', type: 'Compound' },
                                { value: 'CO₂', type: 'Compound' },
                                { value: 'O₃', type: 'Compound' },
                                { value: 'H₂O₂', type: 'Compound' }
                            ],
                            points: 100
                        }
                    ],
                    medium: [
                        {
                            display: ['P', '×', 'V', '=', 'n', '×', 'R', '×', '?'],
                            answer: 'T',
                            hint: "Hint: Ideal Gas Law",
                            options: [
                                { value: 'T', type: 'Variable' },
                                { value: 'P', type: 'Variable' },
                                { value: 'm', type: 'Variable' },
                                { value: 'V', type: 'Variable' }
                            ],
                            points: 200
                        }
                    ],
                    hard: [
                        {
                            display: ['∇', '×', 'E', '=', '-', '?', '∂B', '/', '∂t'],
                            answer: '∂',
                            hint: "Hint: Maxwell's equations (Faraday's law)",
                            options: [
                                { value: '∂', type: 'Operator' },
                                { value: '∇', type: 'Operator' },
                                { value: 'ρ', type: 'Variable' },
                                { value: 'μ', type: 'Constant' }
                            ],
                            points: 300
                        }
                    ]
                };

                return defaultQuestions[difficulty] || [];
            }

            // DOM elements
            const difficultyModal = document.getElementById('difficulty-modal');
            const difficultyButtons = document.querySelectorAll('.difficulty-btn');
            const currentEquationElement = document.getElementById('current-equation');
            const equationDropzone = document.getElementById('equation-dropzone');
            const equationHint = document.getElementById('equation-hint');
            const nextEquation = document.getElementById('next-equation');
            const answerOptions = document.getElementById('answer-options');
            const feedbackArea = document.getElementById('feedback-area');
            const checkAnswerBtn = document.getElementById('check-answer-btn');
            const resetBtn = document.getElementById('reset-btn');
            const nextBtn = document.getElementById('next-btn');
            const levelDisplay = document.getElementById('level-display');
            const scoreDisplay = document.getElementById('score-display');
            const timerDisplay = document.getElementById('timer-display');
            const resultsModal = document.getElementById('results-modal');
            const resultsContent = document.getElementById('results-content');
            const viewResultsBtn = document.getElementById('view-results-btn');
            const closeResultsBtn = document.getElementById('close-results-btn');

            // Update timer displays in difficulty buttons
            function updateTimerDisplaysInButtons() {
                document.querySelector('.easy-timer-display').textContent = timerSettings.easy_timer_seconds;
                document.querySelector('.medium-timer-display').textContent = timerSettings.medium_timer_seconds;
                document.querySelector('.hard-timer-display').textContent = timerSettings.hard_timer_seconds;
            }

            // Update timer displays when the page loads
            updateTimerDisplaysInButtons();

            // Initialize results modal
            viewResultsBtn.addEventListener('click', function() {
                loadResults();
                difficultyModal.style.display = 'none';
                resultsModal.style.display = 'flex';
            });

            closeResultsBtn.addEventListener('click', function() {
                resultsModal.style.display = 'none';
                difficultyModal.style.display = 'flex';
            });

            // Results button in the header
            document.getElementById('results-btn').addEventListener('click', function() {
                loadResults();
                resultsModal.style.display = 'flex';
            });

            // Function to load results from the server
            function loadResults() {
                resultsContent.innerHTML = `
                    <div class="flex justify-center items-center py-12">
                        <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-emerald-500"></div>
                    </div>
                `;

                fetch('{{ route('subjects.specialized.stem.equation-drop.results') }}')
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Failed to fetch results');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.length === 0) {
                            resultsContent.innerHTML = `
                                <div class="bg-neutral-900 p-6 rounded-lg text-center">
                                    <p class="text-lg mb-4">You haven't played any Equation Drop games yet.</p>
                                    <p>Complete a game to see your results here.</p>
                                </div>
                            `;
                            return;
                        }

                        // Calculate summary statistics
                        const totalGames = data.length;
                        const totalScore = data.reduce((sum, result) => sum + result.score, 0);
                        const averageScore = Math.round(totalScore / totalGames);
                        const totalAccuracy = data.reduce((sum, result) => sum + parseFloat(result.accuracy_percentage), 0);
                        const averageAccuracy = (totalAccuracy / totalGames).toFixed(1);

                        // Build the HTML for the results
                        let html = `
                            <div class="bg-neutral-900 rounded-lg p-4 mb-6">
                                <h3 class="text-xl font-semibold mb-4">Performance Summary</h3>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="bg-neutral-800 p-4 rounded-lg">
                                        <p class="text-sm text-emerald-400">Total Games</p>
                                        <p class="text-2xl font-bold">${totalGames}</p>
                                    </div>
                                    <div class="bg-neutral-800 p-4 rounded-lg">
                                        <p class="text-sm text-emerald-400">Average Score</p>
                                        <p class="text-2xl font-bold">${averageScore}</p>
                                    </div>
                                    <div class="bg-neutral-800 p-4 rounded-lg">
                                        <p class="text-sm text-emerald-400">Average Accuracy</p>
                                        <p class="text-2xl font-bold">${averageAccuracy}%</p>
                                    </div>
                                </div>
                            </div>

                            <h3 class="text-xl font-semibold mb-4">Game History</h3>
                            <div class="space-y-4">
                        `;

                        // Add each result
                        data.forEach((result, index) => {
                            const date = new Date(result.created_at);
                            const formattedDate = date.toLocaleDateString('en-US', {
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit'
                            });

                            const difficultyColor = result.difficulty === 'easy'
                                ? 'bg-green-100 text-green-800'
                                : (result.difficulty === 'medium'
                                    ? 'bg-yellow-100 text-yellow-800'
                                    : 'bg-red-100 text-red-800');

                            html += `
                                <div class="bg-neutral-900 rounded-lg overflow-hidden">
                                    <div class="p-4 border-b border-neutral-800 flex justify-between items-center">
                                        <div>
                                            <span class="font-semibold text-lg">Game #${totalGames - index}</span>
                                            <span class="ml-2 text-sm text-gray-400">${formattedDate}</span>
                                        </div>
                                        <div>
                                            <span class="px-3 py-1 rounded-full text-sm font-medium ${difficultyColor}">
                                                ${result.difficulty.charAt(0).toUpperCase() + result.difficulty.slice(1)}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="p-4">
                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                                            <div>
                                                <p class="text-sm text-gray-400">Score</p>
                                                <p class="font-bold text-xl">${result.score}</p>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-400">Accuracy</p>
                                                <p class="font-bold text-xl">${parseFloat(result.accuracy_percentage).toFixed(1)}%</p>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-400">Questions</p>
                                                <p class="font-bold text-xl">${result.questions_correct} / ${result.questions_attempted}</p>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-400">Time Spent</p>
                                                <p class="font-bold text-xl">${formatTime(result.time_spent_seconds)}</p>
                                            </div>
                                        </div>

                                        <div class="mt-3 flex justify-between items-center">
                                            <span class="text-sm ${result.completed ? 'text-emerald-400' : 'text-yellow-400'}">
                                                ${result.completed ? 'Completed' : 'Not Completed'}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            `;
                        });

                        html += `</div>`;
                        resultsContent.innerHTML = html;
                    })
                    .catch(error => {
                        console.error('Error loading results:', error);
                        resultsContent.innerHTML = `
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                                <p>There was an error loading your results. Please try again.</p>
                                <button onclick="loadResults()" class="underline mt-2">Try again</button>
                            </div>
                        `;
                    });
            }

            // Format time in seconds to minutes and seconds
            function formatTime(seconds) {
                const minutes = Math.floor(seconds / 60);
                const remainingSeconds = seconds % 60;
                return `${minutes}m ${remainingSeconds}s`;
            }

            // Initialize difficulty selection
            difficultyButtons.forEach(button => {
                button.addEventListener('click', function() {
                    currentDifficulty = this.getAttribute('data-difficulty');
                    difficultyModal.style.display = 'none';

                    // Show loading state
                    updateFeedback("Loading questions...", "text-emerald-400");

                    // Load questions for the selected difficulty
                    loadQuestionsFromServer(currentDifficulty)
                        .then(loadedQuestions => {
                            equations[currentDifficulty] = loadedQuestions;

                            // Update timer displays with values from database
                            updateTimerDisplaysInButtons();

                            if (equations[currentDifficulty].length === 0) {
                                // If no questions were loaded, show an error and reopen the difficulty modal
                                updateFeedback("No questions available for this difficulty. Please try another.", "text-red-400");
                                setTimeout(() => {
                                    difficultyModal.style.display = 'flex';
                                }, 2000);
                                return;
                            }

                            // Start the game with the loaded questions
                            startGame(currentDifficulty);
                        });
                });
            });

            // Start the game with selected difficulty
            function startGame(difficulty) {
                currentEquationIndex = 0;
                score = 0;
                level = 1;

                updateScoreDisplay();
                updateLevelDisplay();

                if (equations[difficulty].length > 0) {
                    loadEquation(difficulty, currentEquationIndex);
                    startTimer(); // This will set the timer based on difficulty
                } else {
                    updateFeedback("No questions available. Please try again later.", "text-red-400");
                }
            }

            // Load equation based on difficulty and index
            function loadEquation(difficulty, index) {
                const equation = equations[difficulty][index];

                // Update equation display
                currentEquationElement.innerHTML = '';
                equation.display.forEach(part => {
                    if (part === '?') {
                        currentEquationElement.appendChild(equationDropzone);
                        // Reset dropzone animations
                        equationDropzone.classList.add('dropzone-animation');

                        // Make sure the question mark and arrows are visible
                        while (equationDropzone.firstChild) {
                            equationDropzone.removeChild(equationDropzone.firstChild);
                        }

                        // Add the question mark
                        const questionMark = document.createElement("span");
                        questionMark.className = "text-yellow-400 font-bold text-4xl animate-bounce";
                        questionMark.textContent = "?";
                        equationDropzone.appendChild(questionMark);

                        // Add arrow indicators
                        const topArrow = document.createElement("div");
                        topArrow.className = "absolute -top-8 left-1/2 transform -translate-x-1/2 text-emerald-400 animate-pulse";
                        topArrow.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                        </svg>`;

                        const bottomArrow = document.createElement("div");
                        bottomArrow.className = "absolute -bottom-8 left-1/2 transform -translate-x-1/2 text-emerald-400 animate-pulse";
                        bottomArrow.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                        </svg>`;

                        equationDropzone.appendChild(topArrow);
                        equationDropzone.appendChild(bottomArrow);
                    } else {
                        const span = document.createElement('span');
                        span.className = 'text-white mx-1';
                        span.innerHTML = part;
                        currentEquationElement.appendChild(span);
                    }
                });

                // Update hint
                equationHint.textContent = equation.hint;

                // Update next equation preview
                if (index < equations[difficulty].length - 1) {
                    const nextEq = equations[difficulty][index + 1];
                    let nextPreview = '';
                    nextEq.display.forEach(part => {
                        if (part === '?') {
                            nextPreview += '?';
                        } else {
                            nextPreview += part;
                        }
                    });
                    nextEquation.innerHTML = nextPreview;
                } else {
                    nextEquation.innerHTML = 'Final equation!';
                }

                // Load answer options
                loadAnswerOptions(equation.options);

                // Reset state
                resetEquation();
                nextBtn.disabled = true;
            }

            // Load answer options
            function loadAnswerOptions(options) {
                answerOptions.innerHTML = '';

                options.forEach(option => {
                    const colorClass = getColorClassForType(option.type);

                    const card = document.createElement('div');
                    card.className = `answer-card bg-neutral-900 rounded-lg border ${colorClass.border} shadow-lg overflow-hidden cursor-grab`;
                    card.setAttribute('draggable', 'true');
                    card.setAttribute('ondragstart', 'drag(event)');
                    card.setAttribute('data-value', option.value);

                    const header = document.createElement('div');
                    header.className = `${colorClass.bg} p-2 text-center`;
                    header.innerHTML = `<span class="text-white font-medium">${option.type}</span>`;

                    const content = document.createElement('div');
                    content.className = 'p-4 flex items-center justify-center';
                    content.innerHTML = `<span class="text-white text-2xl font-bold">${option.value}</span>`;

                    card.appendChild(header);
                    card.appendChild(content);
                    answerOptions.appendChild(card);

                    // Add hover effect
                    card.addEventListener('mouseenter', function() {
                        this.classList.add('shadow-xl');
                        this.style.transform = 'translateY(-2px)';
                        this.style.transition = 'all 0.2s ease';
                    });

                    card.addEventListener('mouseleave', function() {
                        this.classList.remove('shadow-xl');
                        this.style.transform = 'translateY(0)';
                    });
                });
            }

            // Get color class based on answer type
            function getColorClassForType(type) {
                switch(type) {
                    case 'Variable':
                        return { bg: 'bg-sky-600', border: 'border-sky-600' };
                    case 'Constant':
                        return { bg: 'bg-purple-600', border: 'border-purple-600' };
                    case 'Compound':
                        return { bg: 'bg-teal-600', border: 'border-teal-600' };
                    case 'Expression':
                        return { bg: 'bg-amber-600', border: 'border-amber-600' };
                    case 'Operator':
                        return { bg: 'bg-pink-600', border: 'border-pink-600' };
                    case 'Number':
                        return { bg: 'bg-green-600', border: 'border-green-600' };
                    default:
                        return { bg: 'bg-gray-600', border: 'border-gray-600' };
                }
            }

            // Start the timer
            function startTimer() {
                // Clear any existing timer
                clearInterval(timerInterval);

                // Set timer based on difficulty using values from database
                if (currentDifficulty === 'easy') {
                    timer = timerSettings.easy_timer_seconds;
                } else if (currentDifficulty === 'medium') {
                    timer = timerSettings.medium_timer_seconds;
                } else if (currentDifficulty === 'hard') {
                    timer = timerSettings.hard_timer_seconds;
                }

                updateTimerDisplay();

                // Create a new timer that ticks every second
                timerInterval = setInterval(function() {
                    timer--;
                    updateTimerDisplay();

                    if (timer <= 0) {
                        // Stop the timer when it reaches zero
                        clearInterval(timerInterval);
                        updateFeedback("Time's up! Try again.", "text-red-400");

                        // Disable check answer button
                        checkAnswerBtn.disabled = true;

                        // Show the correct answer
                        const correctAnswer = equations[currentDifficulty][currentEquationIndex].answer;
                        setTimeout(() => {
                            updateFeedback(`The correct answer was "${correctAnswer}". Moving to next question...`, "text-yellow-400");

                            // Move to next question after a delay
                            setTimeout(() => {
                                currentEquationIndex++;

                                // Check if we've completed all equations
                                if (currentEquationIndex >= equations[currentDifficulty].length) {
                                    // Game over - all questions completed
                                    updateFeedback(`Game completed! Your final score: ${score}`, "text-emerald-400");

                                    // Save score to the server
                                    saveScoreToServer(score, currentDifficulty, true);

                                    // Show difficulty modal again after delay
                                    setTimeout(() => {
                                        difficultyModal.style.display = 'flex';

                                        // Reset buttons
                                        checkAnswerBtn.disabled = false;
                                        resetBtn.disabled = false;
                                    }, 3000);

                                    return;
                                }

                                // Load next equation
                                level++;
                                updateLevelDisplay();
                                loadEquation(currentDifficulty, currentEquationIndex);

                                // Reset timer for next equation
                                startTimer();

                                // Re-enable buttons for next question
                                checkAnswerBtn.disabled = false;
                            }, 2000);
                        }, 2000);
                    }
                }, 1000);
            }

            // Update displays
            function updateTimerDisplay() {
                timerDisplay.textContent = timer + 's';

                // Change color based on time remaining
                if (timer <= 10) {
                    timerDisplay.className = 'text-lg font-bold text-red-500';
                } else if (timer <= 30) {
                    timerDisplay.className = 'text-lg font-bold text-yellow-500';
                } else {
                    timerDisplay.className = 'text-lg font-bold text-white';
                }
            }

            function updateScoreDisplay() {
                scoreDisplay.textContent = score;
            }

            function updateLevelDisplay() {
                levelDisplay.textContent = level;
            }

            // Check answer function
            window.checkAnswer = function() {
                // Prevent multiple clicks
                if (checkAnswerBtn.disabled) return;

                if (!currentAnswer) {
                    updateFeedback("Please drag an answer to the question mark first!", "text-yellow-400");
                    return;
                }

                // Disable the check answer button to prevent multiple clicks
                checkAnswerBtn.disabled = true;

                const correctAnswer = equations[currentDifficulty][currentEquationIndex].answer;

                // Get points value for this question (default to 100 if not set)
                const basePoints = equations[currentDifficulty][currentEquationIndex].points || 100;

                if (currentAnswer === correctAnswer) {
                    // Correct answer
                    isCorrect = true;

                    // Calculate score based on time remaining and question points
                    const timeBonus = Math.floor(timer / 10) * 10;
                    const pointsEarned = basePoints + timeBonus;
                    score += pointsEarned;

                    updateFeedback(`Correct! +${pointsEarned} points (${basePoints} base + ${timeBonus} time bonus)`, "text-green-400");
                    updateScoreDisplay();

                    // Update the dropzone styling and remove animations
                    equationDropzone.className = "w-16 h-16 border-2 border-solid border-green-500 rounded-lg flex items-center justify-center bg-green-500/20";

                    // Enable next button
                    nextBtn.disabled = false;

                    // Add animation to score
                    scoreDisplay.classList.add('animate-pulse');
                    setTimeout(() => {
                        scoreDisplay.classList.remove('animate-pulse');
                    }, 1000);

                    // Save progress to the server if this is the last question
                    if (currentEquationIndex >= equations[currentDifficulty].length - 1) {
                        saveScoreToServer(score, currentDifficulty, true);
                    }

                } else {
                    // Wrong answer
                    updateFeedback(`Incorrect. "${currentAnswer}" is not the right answer. The correct answer was "${correctAnswer}".`, "text-red-400");

                    // Update the dropzone styling to indicate error
                    equationDropzone.className = "w-16 h-16 border-2 border-solid border-red-500 rounded-lg flex items-center justify-center bg-red-500/20";

                    // Re-enable the check answer button after a delay
                    setTimeout(() => {
                        checkAnswerBtn.disabled = false;
                        resetEquation();
                    }, 2000);
                }
            };

            // Function to save score to the server
            function saveScoreToServer(finalScore, difficulty, completed) {
                // Calculate additional metrics
                const questionsAttempted = level; // Current level represents questions attempted
                const questionsCorrect = Math.floor(finalScore / 100); // Estimate based on score
                const timeSpentSeconds = calculateTotalTimeSpent(difficulty);

                fetch('{{ route('subjects.specialized.stem.equation-drop.save-score') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        score: finalScore,
                        difficulty: difficulty,
                        completed: completed,
                        questions_attempted: questionsAttempted,
                        questions_correct: questionsCorrect,
                        time_spent_seconds: timeSpentSeconds,
                        notes: ''
                    })
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Score saved:', data);
                })
                .catch(error => {
                    console.error('Error saving score:', error);
                });
            }

            // Calculate total time spent based on difficulty and questions attempted
            function calculateTotalTimeSpent(difficulty) {
                const questionsAttempted = level;
                let secondsPerQuestion;

                if (difficulty === 'easy') {
                    secondsPerQuestion = timerSettings.easy_timer_seconds;
                } else if (difficulty === 'medium') {
                    secondsPerQuestion = timerSettings.medium_timer_seconds;
                } else {
                    secondsPerQuestion = timerSettings.hard_timer_seconds;
                }

                // Estimate time spent as 70% of the maximum time per question
                return Math.round(questionsAttempted * secondsPerQuestion * 0.7);
            }

            // Reset equation function
            window.resetEquation = function() {
                // Clear the dropzone
                while (equationDropzone.firstChild) {
                    equationDropzone.removeChild(equationDropzone.firstChild);
                }

                // Reset the dropzone styling and add animations back
                equationDropzone.className = "w-16 h-16 border-2 border-dashed border-emerald-500/50 rounded-lg flex items-center justify-center bg-neutral-800/70 dropzone-animation";

                // Add the question mark back with animation
                const questionMark = document.createElement("span");
                questionMark.className = "text-yellow-400 font-bold text-4xl animate-bounce";
                questionMark.textContent = "?";
                equationDropzone.appendChild(questionMark);

                // Add arrow indicators
                const topArrow = document.createElement("div");
                topArrow.className = "absolute -top-8 left-1/2 transform -translate-x-1/2 text-emerald-400 animate-pulse";
                topArrow.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                </svg>`;

                const bottomArrow = document.createElement("div");
                bottomArrow.className = "absolute -bottom-8 left-1/2 transform -translate-x-1/2 text-emerald-400 animate-pulse";
                bottomArrow.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                </svg>`;

                equationDropzone.appendChild(topArrow);
                equationDropzone.appendChild(bottomArrow);

                // Reset the current answer
                currentAnswer = null;

                // Update feedback if not already correct
                if (!isCorrect) {
                    updateFeedback("Equation reset. Try again!", "text-neutral-400");
                }
            };

            // Next equation function
            window.nextEquation = function() {
                if (!isCorrect) return;

                currentEquationIndex++;

                // Check if we've completed all equations in this difficulty
                if (currentEquationIndex >= equations[currentDifficulty].length) {
                    // Level completed
                    clearInterval(timerInterval);

                    // Show completion message
                    updateFeedback(`Congratulations! You've completed all ${currentDifficulty} equations! Final score: ${score}`, "text-emerald-400");

                    // Disable buttons
                    checkAnswerBtn.disabled = true;
                    resetBtn.disabled = true;
                    nextBtn.disabled = true;

                    // Save score to the server
                    saveScoreToServer(score, currentDifficulty, true);

                    // Show difficulty modal again after delay
                    setTimeout(() => {
                        difficultyModal.style.display = 'flex';

                        // Reset buttons
                        checkAnswerBtn.disabled = false;
                        resetBtn.disabled = false;
                    }, 5000);

                    return;
                }

                // Load next equation
                level++;
                updateLevelDisplay();
                loadEquation(currentDifficulty, currentEquationIndex);

                // Reset timer for next equation
                startTimer();

                // Reset correct flag
                isCorrect = false;

                // Re-enable check answer button for the new question
                checkAnswerBtn.disabled = false;
            };

            // Drag and Drop functions
            window.drag = function(event) {
                event.dataTransfer.setData("text", event.target.getAttribute("data-value"));
                event.dataTransfer.effectAllowed = "move";
            };

            window.drop = function(event) {
                event.preventDefault();
                const data = event.dataTransfer.getData("text");

                // Clear the dropzone first
                while (equationDropzone.firstChild) {
                    equationDropzone.removeChild(equationDropzone.firstChild);
                }

                // Create and add the new element
                const answerElement = document.createElement("div");
                answerElement.className = "text-white font-bold text-2xl";
                answerElement.textContent = data;
                equationDropzone.appendChild(answerElement);

                // Store the current answer
                currentAnswer = data;

                // Remove animations when an answer is placed
                equationDropzone.classList.remove('dropzone-animation');

                // Update feedback
                updateFeedback("Answer placed! Click 'Check Answer' to verify.", "text-emerald-400");

                // Add drop animation
                equationDropzone.classList.add('scale-110');
                setTimeout(() => {
                    equationDropzone.classList.remove('scale-110');
                }, 200);
            };

            // Update the feedback area
            function updateFeedback(message, className) {
                feedbackArea.innerHTML = `<p class="${className}">${message}</p>`;

                // Add animation
                feedbackArea.classList.add('animate-pulse');
                setTimeout(() => {
                    feedbackArea.classList.remove('animate-pulse');
                }, 500);
            }
        });
    </script>
    @endpush
</x-layouts.app>