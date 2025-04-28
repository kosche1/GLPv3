<x-layouts.app>
    <div class="flex items-center justify-center min-h-screen py-12">
        <div class="max-w-7xl w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-2xl font-bold mb-6 text-center">Typing Speed Test</h2>
                    <p class="text-center mb-6 text-gray-600 dark:text-gray-400">Improve your typing speed and accuracy with this typing test. Type the words as they appear and see your results.</p>

                    <div class="mb-8">
                        <div class="flex justify-center mb-6">
                            <div class="inline-flex rounded-md shadow-sm" role="group">
                                <button id="mode-words" class="test-mode-btn px-5 py-2 text-sm font-medium bg-blue-600 text-white rounded-l-lg border border-blue-600 hover:bg-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-500 transition-colors duration-200">
                                    Word Count
                                </button>
                                <button id="mode-time" class="test-mode-btn px-5 py-2 text-sm font-medium bg-gray-500 text-white rounded-r-lg border border-gray-500 hover:bg-gray-600 focus:z-10 focus:ring-2 focus:ring-gray-500 transition-colors duration-200">
                                    Timed Test
                                </button>
                            </div>
                        </div>

                        <div id="word-count-options" class="mb-6">
                            <h3 class="text-lg font-semibold mb-3 text-center">Select Word Count</h3>
                            <div class="flex flex-wrap justify-center gap-2 mb-4">
                                <button id="wordCount-25" class="word-count-btn px-4 py-2 rounded-md bg-blue-500 text-white font-medium shadow-sm hover:bg-blue-600 transition-colors duration-200" data-count="25">25 words</button>
                                <button id="wordCount-50" class="word-count-btn px-4 py-2 rounded-md bg-gray-500 text-white font-medium shadow-sm hover:bg-gray-600 transition-colors duration-200" data-count="50">50 words</button>
                                <button id="wordCount-100" class="word-count-btn px-4 py-2 rounded-md bg-gray-500 text-white font-medium shadow-sm hover:bg-gray-600 transition-colors duration-200" data-count="100">100 words</button>
                            </div>
                        </div>

                        <div id="time-options" class="mb-6 hidden">
                            <h3 class="text-lg font-semibold mb-3 text-center">Select Time Limit</h3>
                            <div class="flex flex-wrap justify-center gap-2 mb-4">
                                <button id="timeLimit-15" class="time-limit-btn px-4 py-2 rounded-md bg-gray-500 text-white font-medium shadow-sm hover:bg-gray-600 transition-colors duration-200" data-seconds="15">15 seconds</button>
                                <button id="timeLimit-30" class="time-limit-btn px-4 py-2 rounded-md bg-gray-500 text-white font-medium shadow-sm hover:bg-gray-600 transition-colors duration-200" data-seconds="30">30 seconds</button>
                                <button id="timeLimit-60" class="time-limit-btn px-4 py-2 rounded-md bg-blue-500 text-white font-medium shadow-sm hover:bg-blue-600 transition-colors duration-200" data-seconds="60">1 minute</button>
                                <button id="timeLimit-120" class="time-limit-btn px-4 py-2 rounded-md bg-gray-500 text-white font-medium shadow-sm hover:bg-gray-600 transition-colors duration-200" data-seconds="120">2 minutes</button>
                                <button id="timeLimit-180" class="time-limit-btn px-4 py-2 rounded-md bg-gray-500 text-white font-medium shadow-sm hover:bg-gray-600 transition-colors duration-200" data-seconds="180">3 minutes</button>
                                <button id="timeLimit-240" class="time-limit-btn px-4 py-2 rounded-md bg-gray-500 text-white font-medium shadow-sm hover:bg-gray-600 transition-colors duration-200" data-seconds="240">4 minutes</button>
                                <button id="timeLimit-300" class="time-limit-btn px-4 py-2 rounded-md bg-gray-500 text-white font-medium shadow-sm hover:bg-gray-600 transition-colors duration-200" data-seconds="300">5 minutes</button>
                            </div>
                        </div>
                    </div>

                    <div id="typing-test-container" class="mb-6 p-6 bg-gray-100 dark:bg-gray-700 rounded-lg shadow-md border border-gray-200 dark:border-gray-600">
                        <div id="timer-container" class="hidden mb-4 text-center">
                            <div class="inline-block px-4 py-2 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-600">
                                <span class="text-xl font-bold text-gray-800 dark:text-gray-200">Time: <span id="timer-display" class="text-blue-600 dark:text-blue-400">60</span></span>
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

                    <div id="result-container" class="hidden p-6 bg-gray-100 dark:bg-gray-700 rounded-lg shadow-md border border-gray-200 dark:border-gray-600 mb-6">
                        <h3 class="text-xl font-bold mb-4 text-center">Your Results</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="text-center p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-600">
                                <div id="wpm" class="text-4xl font-bold text-blue-500 mb-2">0</div>
                                <p class="text-gray-600 dark:text-gray-400 font-medium">Words Per Minute</p>
                            </div>
                            <div class="text-center p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-600">
                                <div id="cpm" class="text-4xl font-bold text-green-500 mb-2">0</div>
                                <p class="text-gray-600 dark:text-gray-400 font-medium">Characters Per Minute</p>
                            </div>
                            <div class="text-center p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-600">
                                <div id="accuracy" class="text-4xl font-bold text-purple-500 mb-2">0%</div>
                                <p class="text-gray-600 dark:text-gray-400 font-medium">Accuracy</p>
                            </div>
                        </div>
                        <div class="mt-8 text-center">
                            <button id="save-result-button" class="px-6 py-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 font-medium shadow-sm transition-colors duration-200">
                                Save Result
                            </button>
                        </div>
                    </div>

                    <div id="history-container" class="mt-8 p-6 bg-gray-100 dark:bg-gray-700 rounded-lg shadow-md border border-gray-200 dark:border-gray-600">
                        <h3 class="text-xl font-bold mb-4 text-center">Your History</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg overflow-hidden">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="py-3 px-4 border-b border-gray-300 dark:border-gray-700 text-left font-semibold">Date</th>
                                        <th class="py-3 px-4 border-b border-gray-300 dark:border-gray-700 text-left font-semibold">WPM</th>
                                        <th class="py-3 px-4 border-b border-gray-300 dark:border-gray-700 text-left font-semibold">CPM</th>
                                        <th class="py-3 px-4 border-b border-gray-300 dark:border-gray-700 text-left font-semibold">Accuracy</th>
                                        <th class="py-3 px-4 border-b border-gray-300 dark:border-gray-700 text-left font-semibold">Words</th>
                                        <th class="py-3 px-4 border-b border-gray-300 dark:border-gray-700 text-left font-semibold">Mode</th>
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

            const wordContainer = document.getElementById("word-container");
            const inputField = document.getElementById('input-field');
            const resultContainer = document.getElementById("result-container");
            const restartButton = document.getElementById("restart-button");
            const saveResultButton = document.getElementById("save-result-button");
            const wordCountButtons = document.querySelectorAll('.word-count-btn');
            const timeLimitButtons = document.querySelectorAll('.time-limit-btn');
            const testModeButtons = document.querySelectorAll('.test-mode-btn');
            const wordCountOptions = document.getElementById('word-count-options');
            const timeOptions = document.getElementById('time-options');
            const timerContainer = document.getElementById('timer-container');
            const timerDisplay = document.getElementById('timer-display');

            // Initialize
            restart();

            // Load history
            loadHistoryFromDatabase();

            // Event listeners
            restartButton.addEventListener('click', function() {
                restart();
            });

            saveResultButton.addEventListener('click', function() {
                saveResult();
            });

            // Test mode selection
            testModeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const mode = this.id.split('-')[1]; // Extract mode from button id
                    setTestMode(mode);
                    restart();
                });
            });

            // Word count selection
            wordCountButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const count = parseInt(this.dataset.count);
                    WordCount = count;
                    updateWordCountStyle(count);
                    restart();
                });
            });

            // Time limit selection
            timeLimitButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const seconds = parseInt(this.dataset.seconds);
                    timeLimit = seconds;
                    updateTimeLimitStyle(seconds);
                    restart();
                });
            });

            function restart() {
                // Clear any existing timer
                if (timerInterval) {
                    clearInterval(timerInterval);
                    timerInterval = null;
                }

                resetVariables();
                resetStyles();

                // Get a lot of words for timed tests
                const wordRequestCount = testMode === 'time' ? 300 : WordCount;
                getRandomWords(wordRequestCount);

                // Setup timer for timed tests
                if (testMode === 'time') {
                    timerContainer.classList.remove('hidden');
                    remainingTime = timeLimit;
                    timerDisplay.textContent = formatTime(remainingTime);

                    // Start the timer when user starts typing
                    const startTimerOnFirstInput = function() {
                        startTimer();
                        inputField.removeEventListener('input', startTimerOnFirstInput);
                    };

                    inputField.addEventListener('input', startTimerOnFirstInput);
                } else {
                    timerContainer.classList.add('hidden');
                }
            }

            function setTestMode(mode) {
                testMode = mode;

                // Update UI
                testModeButtons.forEach(button => {
                    button.classList.remove('bg-blue-600', 'border-blue-600');
                    button.classList.add('bg-gray-500', 'border-gray-500');
                });

                const activeButton = document.getElementById(`mode-${mode}`);
                if (activeButton) {
                    activeButton.classList.remove('bg-gray-500', 'border-gray-500');
                    activeButton.classList.add('bg-blue-600', 'border-blue-600');
                }

                // Show/hide appropriate options
                if (mode === 'words') {
                    wordCountOptions.classList.remove('hidden');
                    timeOptions.classList.add('hidden');
                    document.body.classList.remove('timed-mode');
                } else {
                    wordCountOptions.classList.add('hidden');
                    timeOptions.classList.remove('hidden');
                    document.body.classList.add('timed-mode');
                }
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

                endTime = Date.now();
                const totalTime = timeLimit; // Use the full time limit for calculations
                const minutes = totalTime / 60;

                CPM = Math.round(correctCharactersTyped / minutes);
                WPM = Math.round((correctCharactersTyped / 5) / minutes);
                Accuracy = Math.round((correctCharactersTyped / charactersTyped) * 100);

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

            function updateWordCountStyle(wordCount) {
                wordCountButtons.forEach(button => {
                    button.classList.remove('bg-blue-500');
                    button.classList.add('bg-gray-500');
                });

                const selectedButton = document.getElementById(`wordCount-${wordCount}`);
                if (selectedButton) {
                    selectedButton.classList.remove('bg-gray-500');
                    selectedButton.classList.add('bg-blue-500');
                }
            }

            function updateTimeLimitStyle(seconds) {
                timeLimitButtons.forEach(button => {
                    button.classList.remove('bg-blue-500');
                    button.classList.add('bg-gray-500');
                });

                const selectedButton = document.getElementById(`timeLimit-${seconds}`);
                if (selectedButton) {
                    selectedButton.classList.remove('bg-gray-500');
                    selectedButton.classList.add('bg-blue-500');
                }
            }

            // Store all words for timed test
            let allWords = [];
            let visibleWordCount = 0;
            let wordsPerRow = 7; // Approximate number of words per row - adjusted for better fit

            function getRandomWords(numberOfWords) {
                fetch('{{ route("typing-test.words") }}?count=' + numberOfWords)
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

                if (testMode === 'time') {
                    // For timed mode, organize words into rows
                    // Display exactly 3 rows
                    visibleWordCount = 0;

                    // Create 3 rows
                    for (let row = 0; row < 3; row++) {
                        const rowDiv = document.createElement('div');
                        rowDiv.className = 'word-row';

                        // Add words to this row
                        for (let i = 0; i < wordsPerRow; i++) {
                            const wordIndex = row * wordsPerRow + i;

                            // Break if we run out of words
                            if (wordIndex >= allWords.length) break;

                            const wordSpan = document.createElement('span');
                            wordSpan.className = 'word';
                            wordSpan.textContent = allWords[wordIndex];

                            rowDiv.appendChild(wordSpan);
                            visibleWordCount++;

                            // Add a space after each word except the last one in a row
                            if (i < wordsPerRow - 1 && wordIndex < allWords.length - 1) {
                                const space = document.createTextNode(' ');
                                rowDiv.appendChild(space);
                            }
                        }

                        // Only add the row if it has words
                        if (rowDiv.childNodes.length > 0) {
                            wordContainer.appendChild(rowDiv);
                        } else {
                            break; // No more words to add
                        }
                    }
                } else {
                    // For word count mode, display all words in a single flow
                    let spanWords = '';
                    visibleWordCount = allWords.length;

                    for(let i = 0; i < allWords.length; ++i) {
                        spanWords += `<span class="word">${allWords[i]}</span> `;
                    }

                    wordContainer.innerHTML = spanWords;
                }

                words = wordContainer.getElementsByClassName("word");
                activeWord = words[activeWordIndex];

                if (activeWord) {
                    activeWord.classList.add('active');
                }
            }

            // Function to load more words when user reaches the end of visible words
            function loadMoreWords() {
                if (testMode !== 'time') {
                    return; // Only load more words in timed mode
                }

                // Calculate which row the active word is in (0-based index)
                // We need to account for the actual DOM structure, not just the index
                // Get all word-row elements
                const rows = wordContainer.querySelectorAll('.word-row');
                if (rows.length === 0) return;

                // Find which row contains the active word
                let activeWordRow = -1;
                let wordIndexInRow = -1;

                for (let i = 0; i < rows.length; i++) {
                    const wordsInRow = rows[i].querySelectorAll('.word');
                    for (let j = 0; j < wordsInRow.length; j++) {
                        if (wordsInRow[j].classList.contains('active')) {
                            activeWordRow = i;
                            wordIndexInRow = j;
                            break;
                        }
                    }
                    if (activeWordRow !== -1) break;
                }

                // If we're on the last word of the 2nd row, scroll to maintain 3 visible rows
                const isLastWordOfSecondRow = (activeWordRow === 1 && wordIndexInRow === rows[1].querySelectorAll('.word').length - 1);

                if (!isLastWordOfSecondRow) {
                    return; // Only scroll when at the end of the 2nd row
                }

                // Scrolling to next row

                // Remove the first row
                if (wordContainer.firstChild) {
                    wordContainer.removeChild(wordContainer.firstChild);
                }

                // Add a new row at the end
                const newRow = document.createElement('div');
                newRow.className = 'word-row';
                let wordCount = 0;

                // Calculate the start index for the new row
                const startIndex = visibleWordCount;
                const endIndex = Math.min(startIndex + wordsPerRow, allWords.length);

                for (let i = startIndex; i < endIndex; i++) {
                    if (!allWords[i]) continue; // Skip if no more words

                    const wordSpan = document.createElement('span');
                    wordSpan.className = 'word';
                    wordSpan.textContent = allWords[i];

                    newRow.appendChild(wordSpan);
                    wordCount++;

                    // Add a space after each word except the last one
                    if (wordCount < wordsPerRow && i < endIndex - 1) {
                        const space = document.createTextNode(' ');
                        newRow.appendChild(space);
                    }
                }

                // Only add the row if it has words
                if (wordCount > 0) {
                    wordContainer.appendChild(newRow);
                    visibleWordCount = endIndex;

                    // Update the words collection
                    words = wordContainer.getElementsByClassName("word");
                }
            }

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

                checkIfTestEnded();
            }

            function updateTextfieldColor() {
                if (activeWord && inputField.value !== (activeWord.textContent).substring(0, inputField.value.length)) {
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
                    correctCharactersTyped += activeWord.textContent.length;
                } else {
                    activeWord.classList.add('text-red-500');
                }

                activeWord.classList.remove('active');
                nextWord();
            }

            function nextWord() {
                inputField.value = "";
                inputField.classList.remove('bg-red-100', 'bg-green-100');

                activeWordIndex++;

                // loadMoreWords will check if we need to load more words
                // It will only load more when we're at the end of the 3rd row
                loadMoreWords();

                if (activeWordIndex < words.length) {
                    activeWord = words[activeWordIndex];
                    activeWord.classList.add('active');

                    // We'll let the loadMoreWords function handle scrolling
                    // No need for additional scrolling here as we're controlling
                    // exactly when rows are added and removed
                }

                enteredWords++;
            }

            function checkIfTestEnded() {
                // For word count mode, check if we've reached the word count
                if (testMode === 'words' && enteredWords >= WordCount) {
                    endTime = Date.now();
                    const totalTime = (endTime - startTime) / 1000;
                    const minutes = totalTime / 60;

                    CPM = Math.round(correctCharactersTyped / minutes);
                    WPM = Math.round((correctCharactersTyped / 5) / minutes);
                    Accuracy = Math.round((correctCharactersTyped / charactersTyped) * 100);

                    inputField.disabled = true;
                    inputField.removeEventListener('input', handleInput);

                    showResults();
                }

                // For timed mode, the test ends when the timer reaches 0
                // This is handled in the endTimedTest function
            }

            function isInputCorrect() {
                return inputField.value.slice(0, -1) === activeWord.textContent;
            }

            function isNextWordTriggered() {
                return inputField.value.slice(-1) === " ";
            }

            function showResults() {
                document.getElementById("cpm").textContent = CPM;
                document.getElementById("wpm").textContent = WPM;
                document.getElementById("accuracy").textContent = `${Accuracy}%`;

                resultContainer.classList.remove('hidden');
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
                        time_limit: testMode === 'time' ? timeLimit : null
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        saveResultButton.textContent = 'Saved!';
                        saveResultButton.disabled = true;
                        loadHistory();
                    }
                })
                .catch(error => {
                    console.error('Error saving result:', error);
                });
            }

            function loadHistory() {
                // Add the current result to the history table
                const historyTableBody = document.getElementById('history-table-body');
                const now = new Date();
                const dateString = now.toLocaleDateString() + ' ' + now.toLocaleTimeString();

                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td class="py-3 px-4">${dateString}</td>
                    <td class="py-3 px-4 font-medium text-blue-500">${WPM}</td>
                    <td class="py-3 px-4 font-medium text-green-500">${CPM}</td>
                    <td class="py-3 px-4 font-medium text-purple-500">${Accuracy}%</td>
                    <td class="py-3 px-4">${enteredWords}</td>
                    <td class="py-3 px-4">${testMode === 'time' ? `${formatTime(timeLimit)}` : 'Words'}</td>
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
                                <td colspan="6" class="py-4 px-4 text-center text-gray-500 italic">No typing test history yet. Complete a test to see your results here.</td>
                            `;
                            historyTableBody.appendChild(emptyRow);
                        } else {
                            // Add each history item
                            data.forEach(item => {
                                const date = new Date(item.created_at);
                                const dateString = date.toLocaleDateString() + ' ' + date.toLocaleTimeString();

                                const row = document.createElement('tr');
                                row.innerHTML = `
                                    <td class="py-3 px-4">${dateString}</td>
                                    <td class="py-3 px-4 font-medium text-blue-500">${item.wpm}</td>
                                    <td class="py-3 px-4 font-medium text-green-500">${item.cpm}</td>
                                    <td class="py-3 px-4 font-medium text-purple-500">${item.accuracy}%</td>
                                    <td class="py-3 px-4">${item.word_count}</td>
                                    <td class="py-3 px-4">${item.test_mode === 'time' ? (item.time_limit ? formatTime(item.time_limit) : '1:00') : 'Words'}</td>
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
            }
        });
    </script>

    @push('styles')
    <style>
        .word {
            margin-right: 10px;
            display: inline-block;
            padding: 3px 6px;
            border-radius: 4px;
            transition: all 0.2s ease;
            font-size: 1.35rem;
            font-weight: 500;
            color: #1F2937; /* Dark gray for better contrast */
            letter-spacing: 0.02em;
        }

        .dark .word {
            color: #E5E7EB; /* Light gray for dark mode */
        }

        .active {
            color: #4338CA; /* Darker indigo for better contrast */
            background-color: rgba(79, 70, 229, 0.15);
            border-bottom: 3px solid #4338CA;
            font-weight: 600;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .text-green-500 {
            color: #047857; /* Darker green for better contrast */
            background-color: rgba(16, 185, 129, 0.15);
        }

        .text-red-500 {
            color: #B91C1C; /* Darker red for better contrast */
            background-color: rgba(239, 68, 68, 0.15);
        }

        #word-container {
            line-height: 2.1;
            font-size: 1.35rem;
            padding: 1.25rem;
            background-color: #F9FAFB; /* Light gray background */
            border-radius: 8px;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            position: relative;
        }

        .dark #word-container {
            background-color: #1F2937; /* Darker background for dark mode */
        }

        /* For timed test mode - limit to 3 lines */
        .timed-mode #word-container {
            height: 8.5rem; /* Approximately 3 lines of text */
            overflow: hidden;
        }

        .word-row {
            white-space: nowrap;
            overflow: hidden;
            margin-bottom: 0.4rem;
        }
    </style>
    @endpush
</x-layouts.app.sidebar>