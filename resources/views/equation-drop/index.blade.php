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
                    <p class="text-gray-300 mb-4">Drag the correct symbol to complete the equation. The question mark shows where to drop your answer.</p>
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
                <p class="text-gray-300 mb-6 text-center">Choose a difficulty level to start the game:</p>

                <div class="grid grid-cols-1 gap-4 mb-6">
                    <button class="difficulty-btn w-full px-4 py-4 bg-green-600 hover:bg-green-500 text-white rounded-lg transition-colors text-lg font-medium" data-difficulty="easy">
                        Easy
                    </button>
                    <button class="difficulty-btn w-full px-4 py-4 bg-yellow-600 hover:bg-yellow-500 text-white rounded-lg transition-colors text-lg font-medium" data-difficulty="medium">
                        Medium
                    </button>
                    <button class="difficulty-btn w-full px-4 py-4 bg-red-600 hover:bg-red-500 text-white rounded-lg transition-colors text-lg font-medium" data-difficulty="hard">
                        Hard
                    </button>
                </div>

                <p class="text-sm text-gray-400 text-center">Select a difficulty to begin the challenge!</p>
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

            // Game equations by difficulty - will be loaded from the server
            let equations = {
                easy: [],
                medium: [],
                hard: []
            };

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

            // Load questions from the server
            function loadQuestionsFromServer(difficulty) {
                return fetch(`{{ route('subjects.specialized.stem.equation-drop.questions') }}?difficulty=${difficulty}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.questions && data.questions.length > 0) {
                            // Transform the data to match our expected format
                            return data.questions.map(q => {
                                return {
                                    display: q.display_elements.map(el => el.element),
                                    answer: q.answer,
                                    hint: q.hint,
                                    options: q.options
                                };
                            });
                        } else {
                            console.error('No questions found for difficulty:', difficulty);
                            return [];
                        }
                    })
                    .catch(error => {
                        console.error('Error loading questions:', error);
                        return [];
                    });
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
                timer = 60;

                updateScoreDisplay();
                updateLevelDisplay();

                if (equations[difficulty].length > 0) {
                    loadEquation(difficulty, currentEquationIndex);
                    startTimer();
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
                clearInterval(timerInterval);
                timer = 60;
                updateTimerDisplay();

                timerInterval = setInterval(function() {
                    timer--;
                    updateTimerDisplay();

                    if (timer <= 0) {
                        clearInterval(timerInterval);
                        updateFeedback("Time's up! Try again.", "text-red-400");
                        resetEquation();
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
                if (!currentAnswer) {
                    updateFeedback("Please drag an answer to the question mark first!", "text-yellow-400");
                    return;
                }

                const correctAnswer = equations[currentDifficulty][currentEquationIndex].answer;

                if (currentAnswer === correctAnswer) {
                    // Correct answer
                    isCorrect = true;

                    // Calculate score based on time remaining
                    const timeBonus = Math.floor(timer / 10) * 10;
                    const pointsEarned = 100 + timeBonus;
                    score += pointsEarned;

                    updateFeedback(`Correct! +${pointsEarned} points (100 base + ${timeBonus} time bonus)`, "text-green-400");
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

                } else {
                    // Wrong answer
                    updateFeedback(`Incorrect. "${currentAnswer}" is not the right answer. Try again!`, "text-red-400");

                    // Update the dropzone styling to indicate error
                    equationDropzone.className = "w-16 h-16 border-2 border-solid border-red-500 rounded-lg flex items-center justify-center bg-red-500/20";

                    // Reset after a delay
                    setTimeout(resetEquation, 2000);
                }
            };

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
                    fetch('{{ route('subjects.specialized.stem.equation-drop.save-score') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            score: score,
                            difficulty: currentDifficulty,
                            completed: true
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Score saved:', data);
                    })
                    .catch(error => {
                        console.error('Error saving score:', error);
                    });

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