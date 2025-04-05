<x-layouts.app>
    <div class="flex h-full w-full flex-1 flex-col gap-6 text-gray-100 p-6 border border-emerald-500 rounded-lg">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-emerald-500/10 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-white">{{ __('Tasks') }}</h1>
            </div>

            <!-- Search and Filter Section -->
            <div class="flex flex-col md:flex-row items-center gap-4">
                <!-- Search Input -->
                <div class="relative w-full md:w-auto">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input type="text" id="task-search" placeholder="Search tasks..."
                        class="w-full md:min-w-[250px] rounded-lg border border-neutral-700/50 bg-neutral-800/50 pl-10 pr-4 py-2.5 text-sm text-white placeholder-neutral-400 focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/30 focus:outline-hidden transition-all duration-300 hover:border-neutral-600">
                </div>

                <!-- Filter Dropdown -->
                <div class="w-full md:w-auto">
                    <div class="relative">
                        <select id="task-status-filter" class="w-full rounded-lg border border-neutral-700/50 bg-neutral-800/50 px-4 py-2.5 text-sm text-white appearance-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/30 focus:outline-hidden transition-all duration-300 hover:border-neutral-600">
                            <option value="all">All Tasks</option>
                            <option value="not-started">Not Started</option>
                            <option value="in-progress">In Progress</option>
                            <option value="completed">Completed</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Sort Dropdown -->
                <div class="w-full md:w-auto">
                    <div class="relative">
                        <select id="task-sort" class="w-full rounded-lg border border-neutral-700/50 bg-neutral-800/50 px-4 py-2.5 text-sm text-white appearance-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/30 focus:outline-hidden transition-all duration-300 hover:border-neutral-600">
                            <option value="name-asc">Name (A-Z)</option>
                            <option value="name-desc">Name (Z-A)</option>
                            <option value="points-asc">Points (Low to High)</option>
                            <option value="points-desc">Points (High to Low)</option>
                            <option value="difficulty-asc">Difficulty (Easy to Hard)</option>
                            <option value="difficulty-desc">Difficulty (Hard to Easy)</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Challenge Stats -->
        <div class="mt-4 p-6 bg-gradient-to-br from-neutral-800 to-neutral-900 rounded-xl border border-neutral-700 shadow-lg">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-emerald-500/10 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h2 class="text-lg font-semibold text-white">Your Task Stats</h2>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="p-4 bg-neutral-800/50 rounded-xl border border-neutral-700 transition-all duration-300 hover:border-emerald-500/30 hover:bg-neutral-800">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-emerald-500/10 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-neutral-400">Completed</h3>
                            <p class="text-2xl font-bold text-white">{{ isset($challengeTasks) ? $challengeTasks->where('completed', true)->count() : 0 }}</p>
                        </div>
                    </div>
                </div>

                <div class="p-4 bg-neutral-800/50 rounded-xl border border-neutral-700 transition-all duration-300 hover:border-emerald-500/30 hover:bg-neutral-800">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-emerald-500/10 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-neutral-400">Total Points</h3>
                            <p class="text-2xl font-bold text-white">{{ isset($challengeTasks) ? $challengeTasks->sum('points_reward') : 0 }}</p>
                        </div>
                    </div>
                </div>

                <div class="p-4 bg-neutral-800/50 rounded-xl border border-neutral-700 transition-all duration-300 hover:border-emerald-500/30 hover:bg-neutral-800">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-emerald-500/10 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-neutral-400">Completion Rate</h3>
                            <p class="text-2xl font-bold text-white">{{ isset($challengeTasks) && $challengeTasks->count() > 0 ? number_format(($challengeTasks->where('completed', true)->count() / $challengeTasks->count()) * 100, 0) : 0 }}%</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Task Categories -->
        <div class="flex flex-wrap gap-2 py-2">
            <button id="filter-all" class="bg-emerald-500/10 text-emerald-400 px-4 py-1.5 rounded-full text-sm font-medium border border-emerald-500/20 hover:bg-emerald-500/20 transition-all duration-300">All</button>
            <button id="filter-coding" class="bg-neutral-800 text-neutral-300 px-4 py-1.5 rounded-full text-sm font-medium border border-neutral-700 hover:bg-neutral-700/50 hover:text-white transition-all duration-300">Coding</button>
            <button id="filter-quiz" class="bg-neutral-800 text-neutral-300 px-4 py-1.5 rounded-full text-sm font-medium border border-neutral-700 hover:bg-neutral-700/50 hover:text-white transition-all duration-300">Quiz</button>
            <button id="filter-project" class="bg-neutral-800 text-neutral-300 px-4 py-1.5 rounded-full text-sm font-medium border border-neutral-700 hover:bg-neutral-700/50 hover:text-white transition-all duration-300">Project</button>
            <button id="filter-assignment" class="bg-neutral-800 text-neutral-300 px-4 py-1.5 rounded-full text-sm font-medium border border-neutral-700 hover:bg-neutral-700/50 hover:text-white transition-all duration-300">Assignment</button>
        </div>

        <!-- Assignments Grid -->
        <div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-3">
            @php
                // Collect all tasks from all challenges
                $allTasks = collect();
                if(isset($challenges) && count($challenges) > 0) {
                    foreach($challenges as $challenge) {
                        foreach($challenge->tasks as $task) {
                            // Add challenge data to each task
                            $task->challenge_data = $challenge;
                            $allTasks->push($task);
                        }
                    }
                }
            @endphp

            @if($allTasks->count() > 0)
                @foreach($allTasks as $task)
                    @php
                        $challenge = $task->challenge_data;
                    @endphp
                    <div class="task-card group bg-gradient-to-br from-neutral-800 to-neutral-900 rounded-xl shadow-lg p-6 transition-all duration-300 hover:shadow-xl hover:scale-[1.02] border border-neutral-700 hover:border-emerald-500/30 hover:shadow-emerald-900/20"
                         data-name="{{ strtolower($task->name) }}"
                         data-description="{{ strtolower($task->description) }}"
                         data-challenge="{{ strtolower($challenge->name) }}"
                         data-submission-type="{{ strtolower($task->submission_type ?? 'standard') }}"
                         data-difficulty="{{ strtolower($challenge->difficulty_level) }}">
                        <div class="mb-4 flex items-center justify-between">
                            <span class="rounded-full bg-emerald-500/10 px-3 py-1 text-xs font-medium text-emerald-400 border border-emerald-500/20">{{ ucfirst($challenge->difficulty_level) }}</span>
                            <span class="text-sm text-neutral-400">{{ str_replace('_', ' ', ucfirst($challenge->challenge_type)) }}</span>
                        </div>
                        <h3 class="mb-2 text-lg font-semibold text-white group-hover:text-emerald-400 transition-colors duration-300">{{ $task->name }}</h3>
                        <p class="mb-4 text-sm text-neutral-300">{{ \Illuminate\Support\Str::limit($task->description, 100) }}</p>

                        <!-- Task Info -->
                        <div class="grid grid-cols-2 gap-2 mb-4">
                            <div class="flex items-center gap-1.5 text-xs text-neutral-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>{{ $task->time_limit ?? 'No time limit' }}</span>
                            </div>
                            <div class="flex items-center gap-1.5 text-xs text-neutral-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>{{ $task->submission_type ?? 'Standard' }}</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-4 border-t border-neutral-700">
                            <div class="flex items-center space-x-2">
                                <div class="flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                    </svg>
                                    <span class="text-sm font-medium text-white">{{ $task->points_reward }}</span>
                                </div>
                                <div class="text-xs text-neutral-400 ml-3">
                                    <span>From: {{ $challenge->name }}</span>
                                </div>
                            </div>
                            <a href="{{ route('challenge.task', ['challenge' => $challenge, 'task' => $task]) }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-emerald-600 rounded-lg transition-all duration-300 hover:bg-emerald-500 focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 focus:ring-offset-neutral-800">
                                View Task
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            @endif

            @if(isset($challengeTasks) && count($challengeTasks) > 0)
                @foreach($challengeTasks as $task)
                    <div class="group bg-gradient-to-br from-neutral-800 to-neutral-900 rounded-xl shadow-lg p-6 transition-all duration-300 hover:shadow-xl hover:scale-[1.02] border border-neutral-700 hover:border-emerald-500/30 hover:shadow-emerald-900/20">
                        <div class="mb-4 flex items-center justify-between">
                            @php
                                $status = 'Not Started';
                                $statusClass = 'bg-neutral-500/10 text-neutral-400 border-neutral-500/20';

                                if ($task->completed) {
                                    $status = 'Completed';
                                    $statusClass = 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20';
                                } elseif ($task->progress > 0) {
                                    $status = 'In Progress';
                                    $statusClass = 'bg-amber-500/10 text-amber-400 border-amber-500/20';
                                }

                                $dueText = '';
                                $dueClass = '';
                                if (isset($task->challenge->end_date)) {
                                    $daysLeft = now()->diffInDays($task->challenge->end_date, false);
                                    if ($daysLeft > 0) {
                                        $dueText = "Due in {$daysLeft} " . Str::plural('day', $daysLeft);
                                        $dueClass = 'text-neutral-400';
                                    } elseif ($daysLeft == 0) {
                                        $dueText = "Due today";
                                        $dueClass = 'text-amber-400';
                                    } else {
                                        $dueText = "Overdue";
                                        $dueClass = 'text-red-400';
                                    }
                                }
                            @endphp
                            <span class="rounded-full {{ $statusClass }} px-3 py-1 text-xs font-medium border">{{ $status }}</span>
                            @if($dueText)
                                <span class="text-xs font-medium {{ $dueClass }}">{{ $dueText }}</span>
                            @endif
                        </div>
                        <h3 class="mb-2 text-lg font-semibold text-white group-hover:text-emerald-400 transition-colors duration-300">Task {{ $task->id }} - {{ $task->challenge->name }}</h3>

                        <!-- Progress bar -->
                        <div class="mb-4">
                            <div class="flex justify-between text-xs mb-1">
                                <span class="text-neutral-400">Progress</span>
                                <span class="text-emerald-400">{{ $task->progress ?? 0 }}%</span>
                            </div>
                            <div class="h-1.5 w-full rounded-full bg-neutral-700 overflow-hidden">
                                <div class="h-1.5 rounded-full bg-gradient-to-r from-emerald-500 to-emerald-400" style="width: {{ $task->progress ?? 0 }}%"></div>
                            </div>
                        </div>

                        <!-- Task Info -->
                        <div class="grid grid-cols-2 gap-2 mb-4">
                            <div class="flex items-center gap-1.5 text-xs text-neutral-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>{{ $task->time_limit ?? 'No time limit' }}</span>
                            </div>
                            <div class="flex items-center gap-1.5 text-xs text-neutral-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>{{ $task->completed ? 'Completed' : 'Incomplete' }}</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-4 border-t border-neutral-700">
                            <div class="flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                                <span class="text-sm font-medium text-white">{{ $task->points_reward }}</span>
                            </div>
                            <a href="{{ route('challenge.task', ['challenge' => $task->challenge, 'task' => $task]) }}"
                               class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-emerald-600 rounded-lg transition-all duration-300 hover:bg-emerald-500 focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 focus:ring-offset-neutral-800">
                                {{ $task->completed ? 'Review' : 'Start Task' }}
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            @endif

            @if((!isset($challenges) || count($challenges) == 0) && (!isset($challengeTasks) || count($challengeTasks) == 0))
                <div class="col-span-3 flex flex-col items-center justify-center p-10 text-center bg-neutral-800/50 rounded-xl border border-neutral-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-neutral-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                    <h3 class="text-xl font-semibold text-white mb-2">No Tasks Available</h3>
                    <p class="text-neutral-400 text-center mb-6">There are currently no tasks assigned to you.</p>
                    <button class="flex items-center justify-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white font-medium py-2 px-4 rounded-lg transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        <span>Browse Tasks</span>
                    </button>
                </div>
            @endif
        </div>

        <!-- Pagination -->
        @if(isset($challenges) && $challenges instanceof \Illuminate\Pagination\LengthAwarePaginator ||
            isset($challengeTasks) && $challengeTasks instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="mt-8 flex items-center justify-center">
            @if(isset($challenges) && $challenges instanceof \Illuminate\Pagination\LengthAwarePaginator)
                {{ $challenges->links() }}
            @elseif(isset($challengeTasks) && $challengeTasks instanceof \Illuminate\Pagination\LengthAwarePaginator)
                {{ $challengeTasks->links() }}
            @endif
        </div>
        @endif
    </div>
    <!-- JavaScript for filtering and sorting tasks -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('task-search');
            const statusFilter = document.getElementById('task-status-filter');
            const sortSelect = document.getElementById('task-sort');
            const taskCards = document.querySelectorAll('.task-card');

            // Function to filter and sort tasks
            function filterAndSortTasks() {
                const searchTerm = searchInput.value.toLowerCase();
                const statusValue = statusFilter.value;
                const sortValue = sortSelect.value;

                // Create an array from the task cards for sorting
                let taskCardsArray = Array.from(taskCards);

                // Filter tasks
                taskCardsArray.forEach(card => {
                    // Get task data for filtering from data attributes
                    const taskName = card.dataset.name || '';
                    const taskDescription = card.dataset.description || '';
                    const challengeName = card.dataset.challenge || '';
                    const submissionType = card.dataset.submissionType || '';

                    // Get task status for filtering
                    let taskStatus = 'not-started';
                    const statusElement = card.querySelector('.rounded-full');
                    if (statusElement) {
                        const statusText = statusElement.textContent.toLowerCase();
                        if (statusText.includes('completed')) {
                            taskStatus = 'completed';
                        } else if (statusText.includes('progress')) {
                            taskStatus = 'in-progress';
                        }
                    }

                    // Check if task matches search and filter criteria
                    const matchesSearch = taskName.includes(searchTerm) ||
                                         taskDescription.includes(searchTerm) ||
                                         challengeName.includes(searchTerm);
                    const matchesStatus = statusValue === 'all' || taskStatus === statusValue;

                    // Show or hide based on filters
                    if (matchesSearch && matchesStatus) {
                        card.style.display = '';
                    } else {
                        card.style.display = 'none';
                    }
                });

                // Sort visible tasks
                taskCardsArray = Array.from(document.querySelectorAll('.task-card:not([style*="display: none"])'));

                // Sort based on selected criteria
                taskCardsArray.sort((a, b) => {
                    if (sortValue === 'name-asc' || sortValue === 'name-desc') {
                        const nameA = a.dataset.name || '';
                        const nameB = b.dataset.name || '';
                        return sortValue === 'name-asc' ? nameA.localeCompare(nameB) : nameB.localeCompare(nameA);
                    }
                    else if (sortValue === 'points-asc' || sortValue === 'points-desc') {
                        const pointsA = parseInt(a.querySelector('.text-sm.font-medium.text-white')?.textContent || '0');
                        const pointsB = parseInt(b.querySelector('.text-sm.font-medium.text-white')?.textContent || '0');
                        return sortValue === 'points-asc' ? pointsA - pointsB : pointsB - pointsA;
                    }
                    else if (sortValue === 'difficulty-asc' || sortValue === 'difficulty-desc') {
                        const difficultyMap = {
                            'beginner': 1,
                            'easy': 2,
                            'medium': 3,
                            'intermediate': 4,
                            'hard': 5,
                            'advanced': 6,
                            'expert': 7
                        };

                        const difficultyA = a.dataset.difficulty || '';
                        const difficultyB = b.dataset.difficulty || '';

                        const diffValueA = difficultyMap[difficultyA] || 0;
                        const diffValueB = difficultyMap[difficultyB] || 0;

                        return sortValue === 'difficulty-asc' ? diffValueA - diffValueB : diffValueB - diffValueA;
                    }

                    return 0;
                });

                // Reorder the DOM elements based on sort
                const container = document.querySelector('.grid-cols-1.gap-5');
                taskCardsArray.forEach(card => {
                    container.appendChild(card);
                });
            }

            // Handle category filter buttons
            const categoryButtons = document.querySelectorAll('.flex-wrap.gap-2.py-2 button');
            let activeCategory = 'all';

            categoryButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active class from all buttons
                    categoryButtons.forEach(btn => {
                        btn.classList.remove('bg-emerald-500/10', 'text-emerald-400', 'border-emerald-500/20');
                        btn.classList.add('bg-neutral-800', 'text-neutral-300', 'border-neutral-700');
                    });

                    // Add active class to clicked button
                    this.classList.remove('bg-neutral-800', 'text-neutral-300', 'border-neutral-700');
                    this.classList.add('bg-emerald-500/10', 'text-emerald-400', 'border-emerald-500/20');

                    // Get category from button id
                    activeCategory = this.id.replace('filter-', '');

                    // Filter tasks
                    filterAndSortTasks();
                });
            });

            // Update filter function to include category filtering
            const originalFilterAndSortTasks = filterAndSortTasks;
            filterAndSortTasks = function() {
                const searchTerm = searchInput.value.toLowerCase();
                const statusValue = statusFilter.value;
                const sortValue = sortSelect.value;

                // Create an array from the task cards for sorting
                let taskCardsArray = Array.from(taskCards);

                // Filter tasks
                taskCardsArray.forEach(card => {
                    // Get task data for filtering
                    const taskName = card.querySelector('h3')?.textContent.toLowerCase() || '';
                    const taskDescription = card.querySelector('p')?.textContent.toLowerCase() || '';
                    const challengeName = card.querySelector('.text-xs.text-neutral-400.ml-3 span')?.textContent.toLowerCase() || '';
                    const submissionType = card.querySelector('.grid-cols-2.gap-2.mb-4 .flex.items-center.gap-1\\.5:nth-child(2) span')?.textContent.toLowerCase() || '';

                    // Get task status for filtering
                    let taskStatus = 'not-started';
                    const statusElement = card.querySelector('.rounded-full');
                    if (statusElement) {
                        const statusText = statusElement.textContent.toLowerCase();
                        if (statusText.includes('completed')) {
                            taskStatus = 'completed';
                        } else if (statusText.includes('progress')) {
                            taskStatus = 'in-progress';
                        }
                    }

                    // Check if task matches category
                    let matchesCategory = activeCategory === 'all';
                    if (!matchesCategory) {
                        if (activeCategory === 'coding' && (submissionType.includes('code') || taskName.includes('code') || taskDescription.includes('code'))) {
                            matchesCategory = true;
                        } else if (activeCategory === 'quiz' && (submissionType.includes('quiz') || taskName.includes('quiz') || taskDescription.includes('quiz') || submissionType.includes('multiple_choice'))) {
                            matchesCategory = true;
                        } else if (activeCategory === 'project' && (submissionType.includes('project') || taskName.includes('project') || taskDescription.includes('project'))) {
                            matchesCategory = true;
                        } else if (activeCategory === 'assignment' && (submissionType.includes('assignment') || taskName.includes('assignment') || taskDescription.includes('assignment'))) {
                            matchesCategory = true;
                        }
                    }

                    // Check if task matches search and filter criteria
                    const matchesSearch = taskName.includes(searchTerm) ||
                                         taskDescription.includes(searchTerm) ||
                                         challengeName.includes(searchTerm);
                    const matchesStatus = statusValue === 'all' || taskStatus === statusValue;

                    // Show or hide based on filters
                    if (matchesSearch && matchesStatus && matchesCategory) {
                        card.style.display = '';
                    } else {
                        card.style.display = 'none';
                    }
                });

                // Sort visible tasks
                taskCardsArray = Array.from(document.querySelectorAll('.grid-cols-1.gap-5 > div.group:not([style*="display: none"])'));

                // Sort based on selected criteria
                taskCardsArray.sort((a, b) => {
                    if (sortValue === 'name-asc' || sortValue === 'name-desc') {
                        const nameA = a.querySelector('h3')?.textContent.toLowerCase() || '';
                        const nameB = b.querySelector('h3')?.textContent.toLowerCase() || '';
                        return sortValue === 'name-asc' ? nameA.localeCompare(nameB) : nameB.localeCompare(nameA);
                    }
                    else if (sortValue === 'points-asc' || sortValue === 'points-desc') {
                        const pointsA = parseInt(a.querySelector('.text-sm.font-medium.text-white')?.textContent || '0');
                        const pointsB = parseInt(b.querySelector('.text-sm.font-medium.text-white')?.textContent || '0');
                        return sortValue === 'points-asc' ? pointsA - pointsB : pointsB - pointsA;
                    }
                    else if (sortValue === 'difficulty-asc' || sortValue === 'difficulty-desc') {
                        const difficultyMap = {
                            'beginner': 1,
                            'easy': 2,
                            'medium': 3,
                            'intermediate': 4,
                            'hard': 5,
                            'advanced': 6,
                            'expert': 7
                        };

                        const difficultyA = a.querySelector('.rounded-full')?.textContent.toLowerCase() || '';
                        const difficultyB = b.querySelector('.rounded-full')?.textContent.toLowerCase() || '';

                        const diffValueA = difficultyMap[difficultyA] || 0;
                        const diffValueB = difficultyMap[difficultyB] || 0;

                        return sortValue === 'difficulty-asc' ? diffValueA - diffValueB : diffValueB - diffValueA;
                    }

                    return 0;
                });

                // Reorder the DOM elements based on sort
                const container = document.querySelector('.grid-cols-1.gap-5');
                taskCardsArray.forEach(card => {
                    container.appendChild(card);
                });
            };

            // Add event listeners
            searchInput.addEventListener('input', filterAndSortTasks);
            statusFilter.addEventListener('change', filterAndSortTasks);
            sortSelect.addEventListener('change', filterAndSortTasks);

            // Initial filter and sort
            filterAndSortTasks();
        });
    </script>
</x-layouts.app>