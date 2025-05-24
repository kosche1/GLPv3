<x-layouts.app>
    <div class="flex items-center justify-center">
        <div class="max-w-8xl">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-3xl font-bold mb-4 text-center text-gray-800 dark:text-white">Typing Speed Test</h2>
                    <p class="text-center mb-8 text-gray-700 dark:text-gray-300 text-lg max-w-3xl mx-auto">Improve your typing speed and accuracy with this typing test. Type the words as they appear and see your results.</p>

                    <div class="mb-8">
                        <!-- Mode Selection Tabs -->
                        <div class="mb-6">
                            <div class="flex justify-center mb-4">
                                <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-1 flex">
                                    <button id="challenges-tab" class="tab-btn px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200 bg-blue-600 text-white">
                                        Challenges
                                    </button>
                                    <button id="free-typing-tab" class="tab-btn px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200 text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200">
                                        Free Typing
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Challenges Section -->
                        <div id="challenges-section" class="mb-8">
                            <h3 class="text-xl font-bold mb-4 text-center text-gray-800 dark:text-white">Select a Challenge</h3>
                            <div class="flex flex-wrap justify-center gap-3 mb-4">
                                @if($challenges->count() > 0)
                                    @foreach($challenges as $challenge)
                                        <button
                                            class="challenge-btn px-5 py-3 rounded-md {{ $loop->first ? 'bg-blue-600' : 'bg-gray-600' }} text-white font-medium shadow-md hover:bg-blue-700 transition-colors duration-200 text-base border-2 border-transparent hover:border-blue-300"
                                            data-challenge-id="{{ $challenge->id }}"
                                            data-test-mode="{{ $challenge->test_mode }}"
                                            data-word-count="{{ $challenge->word_count }}"
                                            data-time-limit="{{ $challenge->time_limit }}"
                                            data-target-wpm="{{ $challenge->target_wpm }}"
                                            data-target-accuracy="{{ $challenge->target_accuracy }}"
                                            data-points="{{ $challenge->points_reward }}"

                                        >
                                            <div class="text-center">
                                                <div class="font-bold">{{ $challenge->title }}</div>
                                                <div class="text-xs opacity-90">
                                                    {{ ucfirst($challenge->difficulty) }} •
                                                    @if($challenge->test_mode === 'words')
                                                        {{ $challenge->word_count }} words • {{ $challenge->time_limit }}s timer
                                                    @else
                                                        {{ $challenge->time_limit }}s timer
                                                    @endif
                                                </div>
                                                <div class="text-xs opacity-75">
                                                    Target: {{ $challenge->target_wpm }} WPM, {{ $challenge->target_accuracy }}% ACC
                                                </div>
                                            </div>
                                        </button>
                                    @endforeach
                                @else
                                    <div class="text-center text-gray-500 dark:text-gray-400">
                                        <p class="text-lg">No challenges available at the moment.</p>
                                        <p class="text-sm">Please check back later or contact your teacher.</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Free Typing Section -->
                        <div id="free-typing-section" class="mb-8 hidden">
                            <h3 class="text-xl font-bold mb-4 text-center text-gray-800 dark:text-white">Free Typing Mode</h3>
                            <p class="text-center text-gray-600 dark:text-gray-400 mb-4">Practice typing without targets - just focus on speed and accuracy!</p>

                            <div class="flex flex-wrap justify-center gap-3 mb-4">
                                <button class="free-time-btn px-5 py-3 rounded-md bg-gray-600 text-white font-medium shadow-md hover:bg-blue-700 transition-colors duration-200 text-base border-2 border-transparent hover:border-blue-300" data-time="10">
                                    <div class="text-center">
                                        <div class="font-bold">10 Seconds</div>
                                        <div class="text-xs opacity-90">Quick Sprint</div>
                                    </div>
                                </button>
                                <button class="free-time-btn px-5 py-3 rounded-md bg-gray-600 text-white font-medium shadow-md hover:bg-blue-700 transition-colors duration-200 text-base border-2 border-transparent hover:border-blue-300" data-time="15">
                                    <div class="text-center">
                                        <div class="font-bold">15 Seconds</div>
                                        <div class="text-xs opacity-90">Speed Burst</div>
                                    </div>
                                </button>
                                <button class="free-time-btn px-5 py-3 rounded-md bg-blue-600 text-white font-medium shadow-md hover:bg-blue-700 transition-colors duration-200 text-base border-2 border-transparent hover:border-blue-300" data-time="30">
                                    <div class="text-center">
                                        <div class="font-bold">30 Seconds</div>
                                        <div class="text-xs opacity-90">Standard Test</div>
                                    </div>
                                </button>
                                <button class="free-time-btn px-5 py-3 rounded-md bg-gray-600 text-white font-medium shadow-md hover:bg-blue-700 transition-colors duration-200 text-base border-2 border-transparent hover:border-blue-300" data-time="60">
                                    <div class="text-center">
                                        <div class="font-bold">60 Seconds</div>
                                        <div class="text-xs opacity-90">One Minute</div>
                                    </div>
                                </button>
                                <button class="free-time-btn px-5 py-3 rounded-md bg-gray-600 text-white font-medium shadow-md hover:bg-blue-700 transition-colors duration-200 text-base border-2 border-transparent hover:border-blue-300" data-time="120">
                                    <div class="text-center">
                                        <div class="font-bold">120 Seconds</div>
                                        <div class="text-xs opacity-90">Endurance</div>
                                    </div>
                                </button>
                            </div>
                        </div>

                        <!-- Challenge Info Display -->
                        <div id="challenge-info" class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800 hidden">
                            <div class="text-center">
                                <h4 id="challenge-name" class="text-lg font-bold text-blue-800 dark:text-blue-200 mb-2"></h4>
                                <div class="grid grid-cols-2 md:grid-cols-5 gap-4 text-sm">
                                    <div class="text-center">
                                        <div class="font-medium text-gray-600 dark:text-gray-400">Mode</div>
                                        <div id="challenge-mode" class="font-bold text-blue-600 dark:text-blue-400"></div>
                                    </div>
                                    <div class="text-center">
                                        <div class="font-medium text-gray-600 dark:text-gray-400">Duration</div>
                                        <div id="challenge-duration" class="font-bold text-indigo-600 dark:text-indigo-400"></div>
                                    </div>
                                    <div class="text-center">
                                        <div class="font-medium text-gray-600 dark:text-gray-400">Target WPM</div>
                                        <div id="challenge-wpm" class="font-bold text-green-600 dark:text-green-400"></div>
                                    </div>
                                    <div class="text-center">
                                        <div class="font-medium text-gray-600 dark:text-gray-400">Target Accuracy</div>
                                        <div id="challenge-accuracy" class="font-bold text-purple-600 dark:text-purple-400"></div>
                                    </div>
                                    <div class="text-center">
                                        <div class="font-medium text-gray-600 dark:text-gray-400">Points</div>
                                        <div id="challenge-points" class="font-bold text-orange-600 dark:text-orange-400"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="result-container" class="hidden p-6 bg-gray-100 dark:bg-gray-700 rounded-lg shadow-md border border-gray-200 dark:border-gray-600 mb-8">
                            <h3 class="text-xl font-bold mb-4 text-center text-gray-800 dark:text-white">Your Results</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="text-center p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-600">
                                    <div id="wpm" class="text-4xl font-bold text-blue-600 dark:text-blue-400 mb-2">0</div>
                                    <p class="text-gray-700 dark:text-gray-300 font-medium">Words Per Minute</p>
                                </div>
                                <div class="text-center p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-600">
                                    <div id="cpm" class="text-4xl font-bold text-green-600 dark:text-green-400 mb-2">0</div>
                                    <p class="text-gray-700 dark:text-gray-300 font-medium">Characters Per Minute</p>
                                </div>
                                <div class="text-center p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-600">
                                    <div id="accuracy" class="text-4xl font-bold text-purple-600 dark:text-purple-400 mb-2">0%</div>
                                    <p class="text-gray-700 dark:text-gray-300 font-medium">Accuracy</p>
                                </div>
                            </div>
                            <div class="mt-8 text-center">
                                <button id="save-result-button" class="px-6 py-3 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 font-medium shadow-md transition-colors duration-200">
                                    Save Result
                                </button>
                            </div>
                        </div>
                    </div>

                    <div id="typing-test-container" class="mb-6 p-6 bg-gray-100 dark:bg-gray-700 rounded-lg shadow-md border border-gray-200 dark:border-gray-600">
                        <div id="timer-container" class="hidden mb-4 text-center">
                            <div class="inline-block px-4 py-2 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-600">
                                <span class="text-xl font-bold text-gray-800 dark:text-gray-200">Time: <span id="timer-display" class="text-blue-600 dark:text-blue-400">60</span></span>
                            </div>
                        </div>
                        <div id="live-stats-container" class="mb-4 text-center flex justify-center space-x-4">
                            <div class="inline-block px-4 py-2 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-600">
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">WPM</span>
                                <span id="live-wpm" class="ml-2 text-lg font-bold text-blue-600 dark:text-blue-400">0</span>
                            </div>
                            <div class="inline-block px-4 py-2 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-600">
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">CPM</span>
                                <span id="live-cpm" class="ml-2 text-lg font-bold text-green-600 dark:text-green-400">0</span>
                            </div>
                            <div class="inline-block px-4 py-2 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-600">
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">ACC</span>
                                <span id="live-accuracy" class="ml-2 text-lg font-bold text-purple-600 dark:text-purple-400">100%</span>
                            </div>
                        </div>
                        <div id="word-container" class="text-lg mb-6 leading-relaxed min-h-[150px] p-6 bg-white dark:bg-gray-800 rounded-md border border-gray-200 dark:border-gray-600 shadow-inner"></div>
                        <div class="flex">
                            <input type="text" id="input-field" class="flex-grow p-4 border border-gray-300 dark:border-gray-600 rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:text-white text-lg font-medium" placeholder="Start typing..." autocomplete="off">
                            <button id="restart-button" class="px-5 py-2 bg-blue-600 text-white rounded-r-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-200 shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div id="history-container" class="mt-10 p-8 bg-gray-100 dark:bg-gray-700 rounded-lg shadow-lg border border-gray-200 dark:border-gray-600">
                        <h3 class="text-2xl font-bold mb-6 text-center text-gray-800 dark:text-white">Your History</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg overflow-hidden shadow-md">
                                <thead class="bg-gray-100 dark:bg-gray-700">
                                    <tr>
                                        <th class="py-4 px-6 border-b border-gray-300 dark:border-gray-600 text-left font-bold text-gray-700 dark:text-gray-200">Date</th>
                                        <th class="py-4 px-6 border-b border-gray-300 dark:border-gray-600 text-left font-bold text-gray-700 dark:text-gray-200">WPM</th>
                                        <th class="py-4 px-6 border-b border-gray-300 dark:border-gray-600 text-left font-bold text-gray-700 dark:text-gray-200">CPM</th>
                                        <th class="py-4 px-6 border-b border-gray-300 dark:border-gray-600 text-left font-bold text-gray-700 dark:text-gray-200">Accuracy</th>
                                        <th class="py-4 px-6 border-b border-gray-300 dark:border-gray-600 text-left font-bold text-gray-700 dark:text-gray-200">Words</th>
                                        <th class="py-4 px-6 border-b border-gray-300 dark:border-gray-600 text-left font-bold text-gray-700 dark:text-gray-200">Mode</th>
                                    </tr>
                                </thead>
                                <tbody id="history-table-body" class="divide-y divide-gray-200 dark:divide-gray-700">
                                    <!-- History will be loaded here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let words;
            let correctCharactersTyped = 0;
            let charactersTyped = 0;
            let incorrectWords = 0;
            let enteredWords = 0;
            let activeWordIndex = 0;
            let activeWord;
            let startTime;
            let endTime;
            let WPM;
            let CPM;
            let Accuracy;
            let WordCount = 25;
            let testMode = 'words'; // 'words' or 'time'
            let timeLimit = 60; // in seconds
            let timerInterval;
            let remainingTime;
            let statsUpdateInterval;
            let selectedChallenge = null;
            let challengeId = null;
            let currentMode = 'challenges'; // 'challenges' or 'free-typing'

            const wordContainer = document.getElementById("word-container");
            const inputField = document.getElementById('input-field');
            const resultContainer = document.getElementById("result-container");
            const restartButton = document.getElementById("restart-button");
            const saveResultButton = document.getElementById("save-result-button");
            const challengeButtons = document.querySelectorAll('.challenge-btn');
            const freeTimeButtons = document.querySelectorAll('.free-time-btn');
            const challengeInfo = document.getElementById('challenge-info');
            const timerContainer = document.getElementById('timer-container');
            const timerDisplay = document.getElementById('timer-display');

            // Tab elements
            const challengesTab = document.getElementById('challenges-tab');
            const freeTypingTab = document.getElementById('free-typing-tab');
            const challengesSection = document.getElementById('challenges-section');
            const freeTypingSection = document.getElementById('free-typing-section');

            // Initialize with first challenge if available
            if (challengeButtons.length > 0) {
                selectChallenge(challengeButtons[0]);
            }

            // Load history
            loadHistoryFromDatabase();

            // Event listeners
            restartButton.addEventListener('click', function() {
                restart();
            });

            saveResultButton.addEventListener('click', function() {
                saveResult();
            });

            // Tab switching
            challengesTab.addEventListener('click', function() {
                switchToTab('challenges');
            });

            freeTypingTab.addEventListener('click', function() {
                switchToTab('free-typing');
            });

            // Challenge selection
            challengeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    selectChallenge(this);
                    restart();
                });
            });

            // Free typing time selection
            freeTimeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    selectFreeTypingTime(this);
                    restart();
                });
            });

            function switchToTab(mode) {
                currentMode = mode;

                if (mode === 'challenges') {
                    // Update tab styles
                    challengesTab.classList.add('bg-blue-600', 'text-white');
                    challengesTab.classList.remove('text-gray-600', 'dark:text-gray-400');
                    freeTypingTab.classList.remove('bg-blue-600', 'text-white');
                    freeTypingTab.classList.add('text-gray-600', 'dark:text-gray-400');

                    // Show/hide sections
                    challengesSection.classList.remove('hidden');
                    freeTypingSection.classList.add('hidden');

                    // Initialize with first challenge if available
                    if (challengeButtons.length > 0) {
                        selectChallenge(challengeButtons[0]);
                    }
                } else {
                    // Update tab styles
                    freeTypingTab.classList.add('bg-blue-600', 'text-white');
                    freeTypingTab.classList.remove('text-gray-600', 'dark:text-gray-400');
                    challengesTab.classList.remove('bg-blue-600', 'text-white');
                    challengesTab.classList.add('text-gray-600', 'dark:text-gray-400');

                    // Show/hide sections
                    freeTypingSection.classList.remove('hidden');
                    challengesSection.classList.add('hidden');

                    // Initialize with 30 seconds (default)
                    const defaultButton = document.querySelector('.free-time-btn[data-time="30"]');
                    if (defaultButton) {
                        selectFreeTypingTime(defaultButton);
                    }
                }
            }

            function selectChallenge(button) {
                currentMode = 'challenges';

                // Update button styles
                challengeButtons.forEach(btn => {
                    btn.classList.remove('bg-blue-600');
                    btn.classList.add('bg-gray-600');
                });
                button.classList.remove('bg-gray-600');
                button.classList.add('bg-blue-600');

                // Get challenge data
                challengeId = button.dataset.challengeId;
                testMode = button.dataset.testMode;
                WordCount = parseInt(button.dataset.wordCount) || 25;
                timeLimit = parseInt(button.dataset.timeLimit) || 60;

                selectedChallenge = {
                    id: challengeId,
                    name: button.querySelector('.font-bold').textContent,
                    mode: testMode,
                    wordCount: WordCount,
                    timeLimit: timeLimit,
                    targetWpm: parseInt(button.dataset.targetWpm),
                    targetAccuracy: parseInt(button.dataset.targetAccuracy),
                    points: parseInt(button.dataset.points)
                };

                // Update challenge info display
                updateChallengeInfo();
            }

            function selectFreeTypingTime(button) {
                currentMode = 'free-typing';

                // Update button styles
                freeTimeButtons.forEach(btn => {
                    btn.classList.remove('bg-blue-600');
                    btn.classList.add('bg-gray-600');
                });
                button.classList.remove('bg-gray-600');
                button.classList.add('bg-blue-600');

                // Set free typing data
                challengeId = null; // No challenge ID for free typing
                testMode = 'time'; // Always time-based for free typing
                WordCount = 0; // No word count limit
                timeLimit = parseInt(button.dataset.time);

                selectedChallenge = {
                    id: null,
                    name: `Free Typing - ${timeLimit}s`,
                    mode: 'time',
                    wordCount: 0,
                    timeLimit: timeLimit,
                    targetWpm: null,
                    targetAccuracy: null,
                    points: null
                };

                // Update challenge info display
                updateChallengeInfo();
            }

            function updateChallengeInfo() {
                if (!selectedChallenge) return;

                document.getElementById('challenge-name').textContent = selectedChallenge.name;

                if (currentMode === 'free-typing') {
                    document.getElementById('challenge-mode').textContent = 'Free Typing';
                    document.getElementById('challenge-duration').textContent = formatTime(selectedChallenge.timeLimit);
                    document.getElementById('challenge-wpm').textContent = 'No Target';
                    document.getElementById('challenge-accuracy').textContent = 'No Target';
                    document.getElementById('challenge-points').textContent = 'No Points';
                } else {
                    document.getElementById('challenge-mode').textContent = selectedChallenge.mode === 'words' ? 'Word Count' : 'Timed Test';

                    // Update duration display - show both word count and timer for word-based challenges
                    if (selectedChallenge.mode === 'words') {
                        document.getElementById('challenge-duration').textContent = `${selectedChallenge.wordCount} words in ${formatTime(selectedChallenge.timeLimit)}`;
                    } else {
                        document.getElementById('challenge-duration').textContent = formatTime(selectedChallenge.timeLimit);
                    }

                    document.getElementById('challenge-wpm').textContent = selectedChallenge.targetWpm + ' WPM';
                    document.getElementById('challenge-accuracy').textContent = selectedChallenge.targetAccuracy + '%';
                    document.getElementById('challenge-points').textContent = selectedChallenge.points + ' pts';
                }

                challengeInfo.classList.remove('hidden');
            }

            function restart() {
                // Clear any existing timer
                if (timerInterval) {
                    clearInterval(timerInterval);
                    timerInterval = null;
                }

                // Clear any existing stats update interval
                if (statsUpdateInterval) {
                    clearInterval(statsUpdateInterval);
                    statsUpdateInterval = null;
                }

                resetVariables();
                resetStyles();

                // Get a lot of words for timed tests, or the word count for word-based tests
                const wordRequestCount = testMode === 'time' ? 300 : WordCount;
                getRandomWords(wordRequestCount);

                // Setup timer for ALL challenges (both word-based and time-based)
                timerContainer.classList.remove('hidden');
                remainingTime = timeLimit;
                timerDisplay.textContent = formatTime(remainingTime);

                // Start the timer when user starts typing
                const startTimerOnFirstInput = function() {
                    startTimer();
                    inputField.removeEventListener('input', startTimerOnFirstInput);
                };

                inputField.addEventListener('input', startTimerOnFirstInput);

                // Start stats update interval when user starts typing
                const startStatsUpdateOnFirstInput = function() {
                    // Update stats every 500ms
                    statsUpdateInterval = setInterval(updateLiveStats, 500);
                    inputField.removeEventListener('input', startStatsUpdateOnFirstInput);
                };

                inputField.addEventListener('input', startStatsUpdateOnFirstInput);
            }

            function startTimer() {
                if (timerInterval) return; // Don't start if already running

                timerInterval = setInterval(() => {
                    remainingTime--;
                    timerDisplay.textContent = formatTime(remainingTime);

                    // Update color as time runs out
                    if (remainingTime <= 10) {
                        timerDisplay.classList.remove('text-blue-600', 'dark:text-blue-400');
                        timerDisplay.classList.add('text-red-600', 'dark:text-red-400');
                    }

                    if (remainingTime <= 0) {
                        endTimedTest();
                    }
                }, 1000);
            }

            function endTimedTest() {
                clearInterval(timerInterval);
                timerInterval = null;

                // Clear stats update interval
                if (statsUpdateInterval) {
                    clearInterval(statsUpdateInterval);
                    statsUpdateInterval = null;
                }

                endTime = Date.now();

                // For time-based challenges, use the full time limit
                // For word-based challenges that ran out of time, use actual elapsed time
                let calculationTime;
                if (testMode === 'time') {
                    calculationTime = timeLimit; // Use the full time limit for time-based challenges
                } else {
                    // Word-based challenge that ran out of time - use actual elapsed time
                    calculationTime = (endTime - startTime) / 1000;
                }

                const minutes = calculationTime / 60;

                CPM = Math.round(correctCharactersTyped / minutes);
                WPM = Math.round((correctCharactersTyped / 5) / minutes);
                Accuracy = enteredWords > 0 ? Math.round(((enteredWords - incorrectWords) / enteredWords) * 100) : 100;

                inputField.disabled = true;
                inputField.removeEventListener('input', handleInput);

                showResults();
            }

            function formatTime(seconds) {
                if (seconds < 60) {
                    return seconds;
                } else {
                    const minutes = Math.floor(seconds / 60);
                    const remainingSeconds = seconds % 60;
                    return `${minutes}:${remainingSeconds < 10 ? '0' : ''}${remainingSeconds}`;
                }
            }



            // Store all words for timed test
            let allWords = [];
            let visibleWordCount = 0;
            let wordsPerRow = 6; // Reduced number of words per row for better visibility and spacing

            function getRandomWords(numberOfWords) {
                let url = '{{ route("typing-test.words") }}?count=' + numberOfWords;
                if (challengeId) {
                    url += '&challenge_id=' + challengeId;
                }

                fetch(url)
                    .then(response => response.json())
                    .then(randomWords => {
                        allWords = randomWords;
                        displayWords();
                        getTextInput();
                    })
                    .catch(error => {
                        console.error('Error fetching words:', error);
                        // Fallback to hardcoded words if API fails
                        const fallbackWords = ['the', 'of', 'to', 'and', 'a', 'in', 'is', 'it', 'you', 'that', 'he', 'was', 'for', 'on', 'are', 'with', 'as', 'I', 'his', 'they', 'be', 'at', 'one', 'have', 'this'];

                        // Repeat the fallback words to reach the desired count
                        allWords = [];
                        while (allWords.length < numberOfWords) {
                            allWords = allWords.concat(fallbackWords);
                        }
                        allWords = allWords.slice(0, numberOfWords);

                        displayWords();
                        getTextInput();
                    });
            }

            function displayWords() {
                wordContainer.innerHTML = "";

                // For both modes, display all words in a continuous flow
                // This allows for smooth scrolling like monkeytype.com
                visibleWordCount = allWords.length;

                // Create a wrapper div for all words
                const wordsWrapper = document.createElement('div');
                wordsWrapper.className = 'words-wrapper';

                // Add all words to the wrapper
                for (let i = 0; i < allWords.length; i++) {
                    const wordSpan = document.createElement('span');
                    wordSpan.className = 'word';
                    wordSpan.dataset.index = i; // Store the index for easier reference
                    wordSpan.dataset.text = allWords[i]; // Store the original text

                    // Split the word into individual character spans
                    const wordText = allWords[i];
                    for (let j = 0; j < wordText.length; j++) {
                        const charSpan = document.createElement('span');
                        charSpan.className = 'char';
                        charSpan.textContent = wordText[j];
                        charSpan.dataset.index = j; // Store the character index
                        wordSpan.appendChild(charSpan);
                    }

                    wordsWrapper.appendChild(wordSpan);

                    // Add a space after each word except the last one
                    if (i < allWords.length - 1) {
                        const space = document.createTextNode(' ');
                        wordsWrapper.appendChild(space);
                    }
                }

                wordContainer.appendChild(wordsWrapper);
                words = wordContainer.getElementsByClassName("word");
                activeWord = words[activeWordIndex];

                if (activeWord) {
                    activeWord.classList.add('active');
                    // Ensure the active word is visible initially
                    scrollActiveWordIntoView();
                }
            }

            // Function to scroll the active word into view
            function scrollActiveWordIntoView() {
                if (!activeWord) return;

                // Calculate the position of the active word relative to the container
                const containerRect = wordContainer.getBoundingClientRect();
                const activeWordRect = activeWord.getBoundingClientRect();

                // Calculate the scroll position to center the active word vertically
                const scrollTop = activeWordRect.top - containerRect.top - (containerRect.height / 2) + (activeWordRect.height / 2);

                // Smooth scroll to the active word
                wordContainer.scrollTo({
                    top: scrollTop + wordContainer.scrollTop,
                    behavior: 'smooth'
                });
            }

            // We no longer need the loadMoreWords function as we're using a scrolling approach
            // All words are loaded at once and we scroll to the active word

            function getTextInput() {
                if (inputField) {
                    inputField.disabled = false;
                    inputField.focus();
                    inputField.addEventListener('input', handleInput);
                }
            }

            function handleInput(event) {
                if (!startTime) startTime = Date.now();

                charactersTyped++;

                if (isNextWordTriggered()) {
                    inputField.style.backgroundColor = "";
                    inputValidation();
                } else {
                    updateTextfieldColor();
                }

                // Update live stats
                updateLiveStats();

                checkIfTestEnded();
            }

            // Function to update live WPM, CPM, and Accuracy stats
            function updateLiveStats() {
                if (!startTime) return;

                const currentTime = Date.now();
                const elapsedTimeInSeconds = (currentTime - startTime) / 1000;
                const elapsedTimeInMinutes = elapsedTimeInSeconds / 60;

                // Only update if we have some elapsed time to avoid division by zero
                if (elapsedTimeInMinutes > 0) {
                    // Calculate live stats
                    const liveWPM = Math.round((correctCharactersTyped / 5) / elapsedTimeInMinutes);
                    const liveCPM = Math.round(correctCharactersTyped / elapsedTimeInMinutes);
                    const liveAccuracy = enteredWords > 0 ? Math.round(((enteredWords - incorrectWords) / enteredWords) * 100) : 100;

                    // Update the display
                    document.getElementById('live-wpm').textContent = liveWPM;
                    document.getElementById('live-cpm').textContent = liveCPM;
                    document.getElementById('live-accuracy').textContent = liveAccuracy + '%';
                }
            }

            function updateTextfieldColor() {
                if (!activeWord) return;

                const wordText = activeWord.dataset.text;
                const inputText = inputField.value;
                const chars = activeWord.querySelectorAll('.char');

                // Reset all characters
                chars.forEach(char => {
                    char.classList.remove('correct', 'incorrect', 'current');
                });

                // Process each character
                for (let i = 0; i < Math.max(inputText.length, wordText.length); i++) {
                    // If we've gone beyond the word length, break
                    if (i >= wordText.length) break;

                    // If we've gone beyond the input length, this character hasn't been typed yet
                    if (i >= inputText.length) {
                        if (i === inputText.length) {
                            chars[i].classList.add('current'); // Mark the next character as current
                        }
                        continue;
                    }

                    // Compare the characters
                    if (inputText[i] === wordText[i]) {
                        chars[i].classList.add('correct');
                    } else {
                        chars[i].classList.add('incorrect');
                    }
                }

                // Update input field background color
                if (inputText !== wordText.substring(0, inputText.length)) {
                    inputField.classList.add('bg-red-100');
                    inputField.classList.remove('bg-green-100');
                } else {
                    inputField.classList.remove('bg-red-100');
                    inputField.classList.add('bg-green-100');
                }
            }

            function inputValidation() {
                if (inputField.value.length > 1) {
                    handleEnteredWord();
                } else {
                    inputField.value = "";
                }
            }

            function handleEnteredWord() {
                if (isInputCorrect()) {
                    activeWord.classList.add('text-green-500');
                    correctCharactersTyped += activeWord.dataset.text.length;
                } else {
                    activeWord.classList.add('text-red-500');
                    incorrectWords++;
                }

                // Reset character highlighting
                const chars = activeWord.querySelectorAll('.char');
                chars.forEach(char => {
                    char.classList.remove('correct', 'incorrect', 'current');
                });

                activeWord.classList.remove('active');
                nextWord();
            }

            function nextWord() {
                inputField.value = "";
                inputField.classList.remove('bg-red-100', 'bg-green-100');

                activeWordIndex++;

                if (activeWordIndex < words.length) {
                    activeWord = words[activeWordIndex];
                    activeWord.classList.add('active');

                    // Scroll the active word into view
                    scrollActiveWordIntoView();
                }

                enteredWords++;
            }

            function checkIfTestEnded() {
                // For word count mode, check if we've reached the word count
                // But the timer will still be running and can end the test early
                if (testMode === 'words' && enteredWords >= WordCount) {
                    endWordBasedTest();
                }

                // For timed mode, the test ends when the timer reaches 0
                // This is handled in the endTimedTest function
            }

            function endWordBasedTest() {
                // Clear any existing timer
                if (timerInterval) {
                    clearInterval(timerInterval);
                    timerInterval = null;
                }

                // Clear stats update interval
                if (statsUpdateInterval) {
                    clearInterval(statsUpdateInterval);
                    statsUpdateInterval = null;
                }

                endTime = Date.now();
                const totalTime = (endTime - startTime) / 1000;
                const minutes = totalTime / 60;

                CPM = Math.round(correctCharactersTyped / minutes);
                WPM = Math.round((correctCharactersTyped / 5) / minutes);
                Accuracy = enteredWords > 0 ? Math.round(((enteredWords - incorrectWords) / enteredWords) * 100) : 100;

                inputField.disabled = true;
                inputField.removeEventListener('input', handleInput);

                showResults();
            }

            function isInputCorrect() {
                return inputField.value.slice(0, -1) === activeWord.dataset.text;
            }

            function isNextWordTriggered() {
                return inputField.value.slice(-1) === " ";
            }

            function showResults() {
                document.getElementById("cpm").textContent = CPM;
                document.getElementById("wpm").textContent = WPM;
                document.getElementById("accuracy").textContent = `${Accuracy}%`;

                resultContainer.classList.remove('hidden');

                // Scroll to the results container
                resultContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }

            function saveResult() {
                fetch('{{ route("typing-test.save-result") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        wpm: WPM,
                        cpm: CPM,
                        accuracy: Accuracy,
                        word_count: enteredWords,
                        test_mode: testMode,
                        time_limit: testMode === 'time' ? timeLimit : null,
                        challenge_id: challengeId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        saveResultButton.textContent = 'Saved!';
                        saveResultButton.disabled = true;
                        loadHistory();

                        // Show challenge completion message if targets were met
                        if (selectedChallenge) {
                            checkChallengeCompletion();
                        }
                    }
                })
                .catch(error => {
                    console.error('Error saving result:', error);
                });
            }

            function checkChallengeCompletion() {
                if (!selectedChallenge) return;

                const metWpmTarget = WPM >= selectedChallenge.targetWpm;
                const metAccuracyTarget = Accuracy >= selectedChallenge.targetAccuracy;

                if (metWpmTarget && metAccuracyTarget) {
                    // Show success message
                    const successMessage = document.createElement('div');
                    successMessage.className = 'mt-4 p-4 bg-green-100 dark:bg-green-900/20 border border-green-300 dark:border-green-700 rounded-lg text-center';
                    successMessage.innerHTML = `
                        <div class="text-green-800 dark:text-green-200">
                            <div class="text-lg font-bold mb-2">🎉 Challenge Completed!</div>
                            <div class="text-sm">You've successfully completed "${selectedChallenge.name}" and earned ${selectedChallenge.points} points!</div>
                        </div>
                    `;
                    resultContainer.appendChild(successMessage);
                } else {
                    // Show encouragement message
                    const encouragementMessage = document.createElement('div');
                    encouragementMessage.className = 'mt-4 p-4 bg-yellow-100 dark:bg-yellow-900/20 border border-yellow-300 dark:border-yellow-700 rounded-lg text-center';
                    encouragementMessage.innerHTML = `
                        <div class="text-yellow-800 dark:text-yellow-200">
                            <div class="text-lg font-bold mb-2">Keep Practicing!</div>
                            <div class="text-sm">
                                Target: ${selectedChallenge.targetWpm} WPM, ${selectedChallenge.targetAccuracy}% accuracy<br>
                                Your result: ${WPM} WPM, ${Accuracy}% accuracy
                            </div>
                        </div>
                    `;
                    resultContainer.appendChild(encouragementMessage);
                }
            }

            function loadHistory() {
                // Add the current result to the history table
                const historyTableBody = document.getElementById('history-table-body');
                const now = new Date();
                const dateString = now.toLocaleDateString() + ' ' + now.toLocaleTimeString();

                const newRow = document.createElement('tr');
                newRow.className = 'hover:bg-gray-50 dark:hover:bg-gray-750 transition-colors duration-150';

                // Determine mode display
                let modeDisplay;
                if (currentMode === 'free-typing') {
                    modeDisplay = `Free Typing (${formatTime(timeLimit)})`;
                } else {
                    modeDisplay = testMode === 'time' ? `${formatTime(timeLimit)} Timer` : `${enteredWords} Words in ${formatTime(timeLimit)}`;
                    if (selectedChallenge && selectedChallenge.name) {
                        modeDisplay = `${selectedChallenge.name} (${modeDisplay})`;
                    }
                }

                newRow.innerHTML = `
                    <td class="py-4 px-6 text-gray-700 dark:text-gray-300">${dateString}</td>
                    <td class="py-4 px-6 font-medium text-blue-600 dark:text-blue-400">${WPM}</td>
                    <td class="py-4 px-6 font-medium text-green-600 dark:text-green-400">${CPM}</td>
                    <td class="py-4 px-6 font-medium text-purple-600 dark:text-purple-400">${Accuracy}%</td>
                    <td class="py-4 px-6 text-gray-700 dark:text-gray-300">${enteredWords}</td>
                    <td class="py-4 px-6 text-gray-700 dark:text-gray-300">${modeDisplay}</td>
                `;

                historyTableBody.prepend(newRow);

                // After adding the new result, refresh the history from the database
                loadHistoryFromDatabase();
            }

            function loadHistoryFromDatabase() {
                fetch('{{ route("typing-test.history") }}')
                    .then(response => response.json())
                    .then(data => {
                        const historyTableBody = document.getElementById('history-table-body');

                        // Clear existing rows except the first one (which is the current result)
                        if (historyTableBody.children.length > 1) {
                            while (historyTableBody.children.length > 1) {
                                historyTableBody.removeChild(historyTableBody.lastChild);
                            }
                        } else {
                            historyTableBody.innerHTML = '';
                        }

                        // Add history rows
                        if (data.length === 0) {
                            // If no history, show a message
                            const emptyRow = document.createElement('tr');
                            emptyRow.innerHTML = `
                                <td colspan="6" class="py-6 px-6 text-center text-gray-500 dark:text-gray-400 italic text-lg">No typing test history yet. Complete a test to see your results here.</td>
                            `;
                            historyTableBody.appendChild(emptyRow);
                        } else {
                            // Add each history item
                            data.forEach(item => {
                                const date = new Date(item.created_at);
                                const dateString = date.toLocaleDateString() + ' ' + date.toLocaleTimeString();

                                const row = document.createElement('tr');
                                row.className = 'hover:bg-gray-50 dark:hover:bg-gray-750 transition-colors duration-150';

                                // Determine the mode display
                                let modeDisplay;
                                if (item.test_mode === 'time') {
                                    modeDisplay = `${item.time_limit ? formatTime(item.time_limit) : '1:00'} Timer`;
                                } else {
                                    modeDisplay = `${item.word_count} Words in ${item.time_limit ? formatTime(item.time_limit) : '1:00'}`;
                                }

                                // Add challenge name if available
                                if (item.challenge && item.challenge.name) {
                                    modeDisplay = `${item.challenge.name} (${modeDisplay})`;
                                }

                                row.innerHTML = `
                                    <td class="py-4 px-6 text-gray-700 dark:text-gray-300">${dateString}</td>
                                    <td class="py-4 px-6 font-medium text-blue-600 dark:text-blue-400">${item.wpm}</td>
                                    <td class="py-4 px-6 font-medium text-green-600 dark:text-green-400">${item.cpm}</td>
                                    <td class="py-4 px-6 font-medium text-purple-600 dark:text-purple-400">${item.accuracy}%</td>
                                    <td class="py-4 px-6 text-gray-700 dark:text-gray-300">${item.word_count}</td>
                                    <td class="py-4 px-6 text-gray-700 dark:text-gray-300">${modeDisplay}</td>
                                `;
                                historyTableBody.appendChild(row);
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error loading history:', error);
                    });
            }

            function resetVariables() {
                correctCharactersTyped = 0;
                charactersTyped = 0;
                incorrectWords = 0;
                enteredWords = 0;
                activeWordIndex = 0;
                activeWord = undefined;
                startTime = undefined;
                endTime = undefined;
                WPM = undefined;
                CPM = undefined;
                Accuracy = undefined;
            }

            function resetStyles() {
                inputField.value = "";
                inputField.classList.remove('bg-red-100', 'bg-green-100');
                inputField.disabled = false;
                inputField.focus();

                resultContainer.classList.add('hidden');
                saveResultButton.textContent = 'Save Result';
                saveResultButton.disabled = false;

                // Reset timer display color
                timerDisplay.classList.remove('text-red-600', 'dark:text-red-400');
                timerDisplay.classList.add('text-blue-600', 'dark:text-blue-400');

                // Reset live stats display
                document.getElementById('live-wpm').textContent = '0';
                document.getElementById('live-cpm').textContent = '0';
                document.getElementById('live-accuracy').textContent = '100%';
            }
        });
    </script>

    @push('styles')
    <style>
        .word {
            margin-right: 8px;
            margin-bottom: 8px;
            display: inline-block;
            padding: 2px 4px;
            border-radius: 3px;
            transition: all 0.2s ease;
            font-size: 1.35rem;
            font-weight: 500;
            color: #4B5563; /* Medium gray for better contrast */
            letter-spacing: 0.02em;
        }

        .dark .word {
            color: #9CA3AF; /* Medium gray for dark mode */
        }

        .active {
            color: #4F46E5; /* Indigo for better contrast */
            background-color: rgba(79, 70, 229, 0.1);
            border-bottom: 2px solid #4F46E5;
            font-weight: 600;
            position: relative;
        }

        /* Add a subtle cursor effect */
        .active::after {
            content: '';
            position: absolute;
            right: -2px;
            top: 0;
            height: 100%;
            width: 2px;
            background-color: #4F46E5;
            animation: blink 1s infinite;
        }

        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0; }
        }

        .text-green-500 {
            color: #059669; /* Green for correct words */
            background-color: transparent;
        }

        .text-red-500 {
            color: #DC2626; /* Red for incorrect words */
            background-color: rgba(239, 68, 68, 0.1);
            text-decoration: underline;
            text-decoration-color: #DC2626;
            text-decoration-thickness: 2px;
        }

        /* Character styling */
        .char {
            display: inline-block;
            position: relative;
            transition: all 0.1s ease;
            border-left: 2px solid transparent;
            border-right: 2px solid transparent;
            margin: 0 -2px; /* Compensate for the borders */
        }

        .char.correct {
            color: #059669; /* Green for correct characters */
        }

        .char.incorrect {
            color: #DC2626; /* Red for incorrect characters */
            background-color: rgba(239, 68, 68, 0.2);
            border-radius: 2px;
        }

        .char.current {
            border-left: 2px solid #4F46E5;
            animation: blink-char 1s infinite;
        }

        @keyframes blink-char {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        /* Adjust active word styling to work better with character highlighting */
        .active {
            color: #4B5563; /* Reset to default color */
            background-color: rgba(79, 70, 229, 0.05);
            border-radius: 4px;
            padding: 2px 4px;
            margin: -2px -4px;
        }

        /* Remove the cursor effect from active word since we have it on characters now */
        .active::after {
            display: none;
        }

        #word-container {
            line-height: 2.5;
            font-size: 1.35rem;
            padding: 1.5rem;
            background-color: #F9FAFB; /* Light gray background */
            border-radius: 8px;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
            overflow-y: auto; /* Enable vertical scrolling */
            overflow-x: hidden; /* Hide horizontal scrollbar */
            position: relative;
            height: 12rem; /* Fixed height for scrolling container */
            scrollbar-width: thin; /* For Firefox */
            scrollbar-color: rgba(0, 0, 0, 0.2) transparent; /* For Firefox */
        }

        /* Webkit scrollbar styling */
        #word-container::-webkit-scrollbar {
            width: 6px;
        }

        #word-container::-webkit-scrollbar-track {
            background: transparent;
        }

        #word-container::-webkit-scrollbar-thumb {
            background-color: rgba(0, 0, 0, 0.2);
            border-radius: 3px;
        }

        .dark #word-container {
            background-color: #1F2937; /* Darker background for dark mode */
            scrollbar-color: rgba(255, 255, 255, 0.2) transparent; /* For Firefox */
        }

        .dark #word-container::-webkit-scrollbar-thumb {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .words-wrapper {
            padding: 1rem 0.5rem;
            line-height: 2.8;
            display: flex;
            flex-wrap: wrap;
            align-content: flex-start;
            max-width: 100%;
            justify-content: center; /* Center words horizontally */
            gap: 0 4px; /* Add some gap between words */
        }

        /* Challenge button styling */
        .challenge-btn {
            min-width: 200px;
            transition: all 0.3s ease;
            cursor: pointer;
            pointer-events: auto;
        }

        .challenge-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .challenge-btn.bg-blue-600 {
            background: linear-gradient(135deg, #3B82F6, #1D4ED8);
            border-color: #1D4ED8;
        }

        .challenge-btn.bg-gray-600 {
            background: linear-gradient(135deg, #6B7280, #4B5563);
        }

        /* Tab button styling */
        .tab-btn {
            transition: all 0.3s ease;
        }

        .tab-btn:hover {
            transform: translateY(-1px);
        }

        /* Free typing button styling */
        .free-time-btn {
            min-width: 120px;
            transition: all 0.3s ease;
            cursor: pointer;
            pointer-events: auto;
        }

        .free-time-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .free-time-btn.bg-blue-600 {
            background: linear-gradient(135deg, #3B82F6, #1D4ED8);
            border-color: #1D4ED8;
        }

        .free-time-btn.bg-gray-600 {
            background: linear-gradient(135deg, #6B7280, #4B5563);
        }
    </style>
    @endpush
</x-layouts.app>