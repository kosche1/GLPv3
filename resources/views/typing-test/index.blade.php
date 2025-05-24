<x-layouts.app>
    <div class="flex items-center justify-center">
        <div class="max-w-8xl">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Back Button -->
                    <div class="mb-6">
                        <a href="{{ url('subjects/specialized/ict') }}"
                           class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            Back to ICT Subjects
                        </a>
                    </div>

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
                                        @if($challenge->is_completed)
                                            <!-- Completed Challenge (Locked) -->
                                            <div class="challenge-btn px-5 py-3 rounded-md bg-gray-600 text-white font-medium shadow-md text-base border-2 border-gray-400 cursor-not-allowed relative">
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
                                                <!-- Lock Icon -->
                                                <div class="absolute top-2 right-2">
                                                    <svg class="w-6 h-6 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                        @else
                                            <!-- Available Challenge -->
                                            <button
                                                class="challenge-btn px-5 py-3 rounded-md {{ $loop->first && !$challenges->where('is_completed', false)->first() ? 'bg-blue-600' : 'bg-gray-600' }} text-white font-medium shadow-md hover:bg-blue-700 transition-colors duration-200 text-base border-2 border-transparent hover:border-blue-300"
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
                                        @endif
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

                    <!-- Challenge History -->
                    <div id="challenge-history-container" class="mt-10 p-8 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-600">
                        <h3 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white flex items-center">
                            <svg class="w-6 h-6 mr-3 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Challenge History
                            <span class="ml-3 text-sm font-normal text-green-600 dark:text-green-400 bg-green-100 dark:bg-green-900 px-2 py-1 rounded-full">Visible to teachers</span>
                        </h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full border border-gray-300 dark:border-gray-700 rounded-lg overflow-hidden shadow-md">
                                <thead class="bg-green-50 dark:bg-green-900">
                                    <tr>
                                        <th class="py-4 px-6 border-b border-gray-300 dark:border-gray-600 text-left font-bold text-gray-700 dark:text-gray-200">Date</th>
                                        <th class="py-4 px-6 border-b border-gray-300 dark:border-gray-600 text-left font-bold text-gray-700 dark:text-gray-200">Challenge</th>
                                        <th class="py-4 px-6 border-b border-gray-300 dark:border-gray-600 text-left font-bold text-gray-700 dark:text-gray-200">WPM</th>
                                        <th class="py-4 px-6 border-b border-gray-300 dark:border-gray-600 text-left font-bold text-gray-700 dark:text-gray-200">CPM</th>
                                        <th class="py-4 px-6 border-b border-gray-300 dark:border-gray-600 text-left font-bold text-gray-700 dark:text-gray-200">Accuracy</th>
                                        <th class="py-4 px-6 border-b border-gray-300 dark:border-gray-600 text-left font-bold text-gray-700 dark:text-gray-200">Words</th>
                                    </tr>
                                </thead>
                                <tbody id="challenge-history-table-body" class="divide-y divide-gray-200 dark:divide-gray-700">
                                    <!-- Challenge history will be loaded here -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Free Typing History -->
                    <div id="free-typing-history-container" class="mt-8 p-8 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-600">
                        <h3 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white flex items-center">
                            <svg class="w-6 h-6 mr-3 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Free Typing History
                            <span class="ml-3 text-sm font-normal text-blue-600 dark:text-blue-400 bg-blue-100 dark:bg-blue-900 px-2 py-1 rounded-full">Personal practice only</span>
                        </h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full border border-gray-300 dark:border-gray-700 rounded-lg overflow-hidden shadow-md">
                                <thead class="bg-blue-50 dark:bg-blue-900">
                                    <tr>
                                        <th class="py-4 px-6 border-b border-gray-300 dark:border-gray-600 text-left font-bold text-gray-700 dark:text-gray-200">Date</th>
                                        <th class="py-4 px-6 border-b border-gray-300 dark:border-gray-600 text-left font-bold text-gray-700 dark:text-gray-200">WPM</th>
                                        <th class="py-4 px-6 border-b border-gray-300 dark:border-gray-600 text-left font-bold text-gray-700 dark:text-gray-200">CPM</th>
                                        <th class="py-4 px-6 border-b border-gray-300 dark:border-gray-600 text-left font-bold text-gray-700 dark:text-gray-200">Accuracy</th>
                                        <th class="py-4 px-6 border-b border-gray-300 dark:border-gray-600 text-left font-bold text-gray-700 dark:text-gray-200">Words</th>
                                        <th class="py-4 px-6 border-b border-gray-300 dark:border-gray-600 text-left font-bold text-gray-700 dark:text-gray-200">Mode</th>
                                        <th class="py-4 px-6 border-b border-gray-300 dark:border-gray-600 text-left font-bold text-gray-700 dark:text-gray-200">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="free-typing-history-table-body" class="divide-y divide-gray-200 dark:divide-gray-700">
                                    <!-- Free typing history will be loaded here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alpine.js Delete Confirmation Modal -->
    <div x-data="{
        showDeleteModal: false,
        resultToDelete: null,
        deleteResult() {
            if (this.resultToDelete) {
                performDeleteFreeTypingResult(this.resultToDelete);
                this.showDeleteModal = false;
                this.resultToDelete = null;
            }
        },
        cancelDelete() {
            this.showDeleteModal = false;
            this.resultToDelete = null;
        }
    }"
    x-show="showDeleteModal"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 overflow-y-auto"
    style="display: none;">

        <!-- Background overlay -->
        <div class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm" @click="cancelDelete()"></div>

        <!-- Modal content -->
        <div class="flex items-center justify-center min-h-screen px-4 py-8">
            <div class="bg-white dark:bg-gray-800 rounded-lg px-6 py-6 text-left overflow-hidden shadow-xl transform transition-all max-w-lg w-full mx-auto"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 scale-95">

                <!-- Icon -->
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900">
                    <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                    </svg>
                </div>

                <!-- Content -->
                <div class="mt-3 text-center sm:mt-5">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                        Delete Free Typing Result
                    </h3>
                    <div class="mt-2">
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Are you sure you want to delete this free typing result? This action cannot be undone and will permanently remove this practice session from your history.
                        </p>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="mt-6 flex flex-col-reverse sm:flex-row justify-center gap-3">
                    <button @click="cancelDelete()"
                            class="w-full sm:w-auto inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-6 py-2.5 bg-white dark:bg-gray-700 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                        Cancel
                    </button>
                    <button @click="deleteResult()"
                            class="w-full sm:w-auto inline-flex justify-center rounded-md border border-transparent shadow-sm px-6 py-2.5 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Delete
                    </button>
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

            // Initialize with first available challenge if available
            const availableChallengeButtons = Array.from(challengeButtons).filter(btn => btn.tagName === 'BUTTON');
            if (availableChallengeButtons.length > 0) {
                selectChallenge(availableChallengeButtons[0]);
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

            // Challenge selection (only for available challenges)
            challengeButtons.forEach(button => {
                // Only add click listeners to actual buttons (not completed challenge divs)
                if (button.tagName === 'BUTTON') {
                    button.addEventListener('click', function() {
                        selectChallenge(this);
                        restart();
                    });
                }
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

                    // Initialize with first available challenge if available
                    const availableButtons = Array.from(challengeButtons).filter(btn => btn.tagName === 'BUTTON');
                    if (availableButtons.length > 0) {
                        selectChallenge(availableButtons[0]);
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

                // Update button styles (only for actual buttons, not completed challenge divs)
                challengeButtons.forEach(btn => {
                    if (btn.tagName === 'BUTTON') {
                        btn.classList.remove('bg-blue-600');
                        btn.classList.add('bg-gray-600');
                    }
                });
                if (button.tagName === 'BUTTON') {
                    button.classList.remove('bg-gray-600');
                    button.classList.add('bg-blue-600');
                }

                // Get challenge data
                challengeId = button.dataset.challengeId;
                testMode = button.dataset.testMode;
                WordCount = parseInt(button.dataset.wordCount) || 25;
                timeLimit = parseInt(button.dataset.timeLimit) || 60;

                selectedChallenge = {
                    id: challengeId,
                    title: button.querySelector('.font-bold').textContent,
                    mode: testMode,
                    wordCount: WordCount,
                    timeLimit: timeLimit,
                    targetWpm: parseInt(button.dataset.targetWpm),
                    targetAccuracy: parseInt(button.dataset.targetAccuracy),
                    points_reward: parseInt(button.dataset.points)
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
                    title: `Free Typing - ${timeLimit}s`,
                    mode: 'time',
                    wordCount: 0,
                    timeLimit: timeLimit,
                    targetWpm: null,
                    targetAccuracy: null,
                    points_reward: null
                };

                // Update challenge info display
                updateChallengeInfo();
            }

            function updateChallengeInfo() {
                if (!selectedChallenge) return;

                document.getElementById('challenge-name').textContent = selectedChallenge.title;

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
                    document.getElementById('challenge-points').textContent = selectedChallenge.points_reward + ' pts';
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
                // Check if we have valid results to save
                if (!WPM || !CPM || Accuracy === undefined || !enteredWords) {
                    alert('Please complete a typing test before saving results!');
                    return;
                }

                // Show loading state
                const originalText = saveResultButton.textContent;
                saveResultButton.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Saving...
                `;
                saveResultButton.disabled = true;

                // Calculate actual test duration
                const actualTestDuration = endTime && startTime ? Math.round((endTime - startTime) / 1000) : timeLimit;

                console.log('Saving result:', {
                    wpm: WPM,
                    cpm: CPM,
                    accuracy: Accuracy,
                    word_count: enteredWords,
                    test_mode: testMode,
                    time_limit: timeLimit,
                    test_duration: actualTestDuration,
                    characters_typed: correctCharactersTyped,
                    errors: incorrectWords,
                    challenge_id: challengeId
                });

                // Determine the correct endpoint based on whether it's a challenge or free typing
                const endpoint = challengeId ? '{{ route("typing-test.save-result") }}' : '{{ route("typing-test.save-result") }}';

                fetch(endpoint, {
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
                        time_limit: timeLimit,
                        test_duration: actualTestDuration,
                        characters_typed: correctCharactersTyped,
                        errors: incorrectWords,
                        challenge_id: challengeId
                    })
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    return response.json();
                })
                .then(data => {
                    console.log('Response data:', data);
                    if (data.success) {
                        saveResultButton.innerHTML = `
                            <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Saved!
                        `;

                        // Show different messages based on result type
                        if (data.type === 'challenge') {
                            console.log('✅ Challenge result saved to database and admin panel');
                            // Show a brief notification for challenge completion
                            showNotification('Challenge result saved! Visible to teachers.', 'success');
                        } else if (data.type === 'free_typing') {
                            console.log('✅ Free typing result saved to personal history only');
                            // Show a brief notification for free typing
                            showNotification('Free typing result saved to your personal history.', 'info');
                        }

                        // Refresh history (includes both database and session results)
                        loadHistoryFromDatabase();

                        // Show challenge completion message if targets were met
                        if (selectedChallenge && data.type === 'challenge') {
                            checkChallengeCompletion();
                        }
                    } else {
                        saveResultButton.textContent = originalText;
                        saveResultButton.disabled = false;
                        alert('Failed to save result: ' + (data.message || 'Unknown error'));
                    }
                })
                .catch(error => {
                    console.error('Error saving result:', error);
                    saveResultButton.textContent = originalText;
                    saveResultButton.disabled = false;
                    alert('Error saving result. Please check the console for details.');
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
                            <div class="text-sm">You've successfully completed "${selectedChallenge.title}" and earned ${selectedChallenge.points_reward} points!</div>
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



            function loadHistoryFromDatabase() {
                fetch('{{ route("typing-test.history") }}')
                    .then(response => response.json())
                    .then(data => {
                        const challengeTableBody = document.getElementById('challenge-history-table-body');
                        const freeTypingTableBody = document.getElementById('free-typing-history-table-body');

                        // Clear all existing rows
                        challengeTableBody.innerHTML = '';
                        freeTypingTableBody.innerHTML = '';

                        // Separate challenge and free typing results
                        const challengeResults = data.filter(item => item.challenge_id !== null);
                        const freeTypingResults = data.filter(item => item.challenge_id === null);

                        // Populate Challenge History
                        if (challengeResults.length === 0) {
                            const emptyRow = document.createElement('tr');
                            emptyRow.innerHTML = `
                                <td colspan="6" class="py-6 px-6 text-center text-gray-500 dark:text-gray-400 italic text-lg">No challenge completions yet. Complete a challenge to see your results here.</td>
                            `;
                            challengeTableBody.appendChild(emptyRow);
                        } else {
                            challengeResults.forEach(item => {
                                const date = new Date(item.created_at);
                                const dateString = date.toLocaleDateString() + ' ' + date.toLocaleTimeString();

                                const row = document.createElement('tr');
                                row.className = 'hover:bg-green-50 dark:hover:bg-green-900 transition-colors duration-150';

                                const challengeName = item.challenge && item.challenge.title ? item.challenge.title : 'Unknown Challenge';
                                const difficulty = item.challenge && item.challenge.difficulty ? ` (${item.challenge.difficulty})` : '';

                                row.innerHTML = `
                                    <td class="py-4 px-6 text-gray-700 dark:text-gray-300">${dateString}</td>
                                    <td class="py-4 px-6 font-medium text-green-600 dark:text-green-400">${challengeName}${difficulty}</td>
                                    <td class="py-4 px-6 font-medium text-blue-600 dark:text-blue-400">${item.wpm}</td>
                                    <td class="py-4 px-6 font-medium text-green-600 dark:text-green-400">${item.cpm}</td>
                                    <td class="py-4 px-6 font-medium text-purple-600 dark:text-purple-400">${item.accuracy}%</td>
                                    <td class="py-4 px-6 text-gray-700 dark:text-gray-300">${item.word_count}</td>
                                `;
                                challengeTableBody.appendChild(row);
                            });
                        }

                        // Populate Free Typing History
                        if (freeTypingResults.length === 0) {
                            const emptyRow = document.createElement('tr');
                            emptyRow.innerHTML = `
                                <td colspan="7" class="py-6 px-6 text-center text-gray-500 dark:text-gray-400 italic text-lg">No free typing sessions yet. Try the free typing mode to practice!</td>
                            `;
                            freeTypingTableBody.appendChild(emptyRow);
                        } else {
                            freeTypingResults.forEach(item => {
                                const date = new Date(item.created_at);
                                const dateString = date.toLocaleDateString() + ' ' + date.toLocaleTimeString();

                                const row = document.createElement('tr');
                                row.className = 'hover:bg-blue-50 dark:hover:bg-blue-900 transition-colors duration-150';

                                // Determine the mode display for free typing
                                let modeDisplay = `Free Typing (${item.time_limit ? formatTime(item.time_limit) : '60'}s)`;

                                row.innerHTML = `
                                    <td class="py-4 px-6 text-gray-700 dark:text-gray-300">${dateString}</td>
                                    <td class="py-4 px-6 font-medium text-blue-600 dark:text-blue-400">${item.wpm}</td>
                                    <td class="py-4 px-6 font-medium text-green-600 dark:text-green-400">${item.cpm}</td>
                                    <td class="py-4 px-6 font-medium text-purple-600 dark:text-purple-400">${item.accuracy}%</td>
                                    <td class="py-4 px-6 text-gray-700 dark:text-gray-300">${item.word_count}</td>
                                    <td class="py-4 px-6 text-gray-700 dark:text-gray-300">${modeDisplay}</td>
                                    <td class="py-4 px-6">
                                        <button onclick="showDeleteConfirmation(${item.id})"
                                                class="inline-flex items-center px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-md transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Delete
                                        </button>
                                    </td>
                                `;
                                freeTypingTableBody.appendChild(row);
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
                saveResultButton.innerHTML = 'Save Result';
                saveResultButton.disabled = false;

                // Reset timer display color
                timerDisplay.classList.remove('text-red-600', 'dark:text-red-400');
                timerDisplay.classList.add('text-blue-600', 'dark:text-blue-400');

                // Reset live stats display
                document.getElementById('live-wpm').textContent = '0';
                document.getElementById('live-cpm').textContent = '0';
                document.getElementById('live-accuracy').textContent = '100%';
            }

            // Load history when page loads
            loadHistoryFromDatabase();

            // Make loadHistoryFromDatabase globally accessible
            window.loadHistoryFromDatabase = loadHistoryFromDatabase;
        });

        // Notification function
        function showNotification(message, type = 'info') {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg text-white font-medium transition-all duration-300 transform translate-x-full`;

            // Set color based on type
            if (type === 'success') {
                notification.classList.add('bg-green-600');
            } else if (type === 'info') {
                notification.classList.add('bg-blue-600');
            } else if (type === 'warning') {
                notification.classList.add('bg-yellow-600');
            } else {
                notification.classList.add('bg-red-600');
            }

            notification.textContent = message;
            document.body.appendChild(notification);

            // Animate in
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
            }, 100);

            // Animate out and remove
            setTimeout(() => {
                notification.classList.add('translate-x-full');
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 3000);
        }

        // Function to show delete confirmation modal
        function showDeleteConfirmation(resultId) {
            // Get the Alpine.js component
            const modalComponent = document.querySelector('[x-data*="showDeleteModal"]');
            if (modalComponent) {
                // Access Alpine.js data
                const alpineData = Alpine.$data(modalComponent);
                alpineData.resultToDelete = resultId;
                alpineData.showDeleteModal = true;
            }
        }

        // Function to actually perform the deletion (called from Alpine.js)
        function performDeleteFreeTypingResult(resultId) {
            console.log('Attempting to delete result ID:', resultId); // Debug log

            // Get CSRF token with fallback
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
            console.log('Using CSRF token:', csrfToken ? 'Present' : 'Missing'); // Debug log

            fetch(`{{ url('typing-test/free-typing') }}/${resultId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                console.log('Response status:', response.status); // Debug log
                console.log('Response ok:', response.ok); // Debug log

                // Check if response is ok first
                if (!response.ok) {
                    return response.text().then(text => {
                        console.error('Error response text:', text);
                        throw new Error(`HTTP error! status: ${response.status}, response: ${text}`);
                    });
                }
                return response.json();
            })
            .then(data => {
                console.log('Delete response:', data); // Debug log
                if (data && data.success) {
                    showNotification('Free typing result deleted successfully.', 'success');
                    // Refresh the history to remove the deleted item
                    if (window.loadHistoryFromDatabase) {
                        window.loadHistoryFromDatabase();
                    }
                } else {
                    showNotification(data?.message || 'Failed to delete result.', 'error');
                }
            })
            .catch(error => {
                console.error('Error deleting result:', error);
                showNotification('An error occurred while deleting the result.', 'error');
            });
        }
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