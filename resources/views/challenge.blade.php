<x-layouts.app>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-emerald-500/10 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-white">{{ $challenge->name }}</h1>
            </div>
            <div class="flex gap-4">
                <a href="{{ route('learning') }}" class="flex items-center justify-center gap-2 px-5 py-2.5 rounded-lg border border-emerald-500/30 bg-emerald-500/10 transition-all duration-300 hover:bg-emerald-500/20 hover:border-emerald-500/50 hover:shadow-lg hover:shadow-emerald-900/20 group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400 group-hover:text-emerald-300 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span class="text-base font-medium text-emerald-400 group-hover:text-emerald-300 transition-colors">Back to Learning</span>
                </a>
            </div>
        </div>

        <div class="grid gap-6 md:grid-cols-3">
            <!-- Challenge Details -->
            <div class="md:col-span-2 flex flex-col p-6 rounded-xl border border-neutral-700 bg-gradient-to-br from-neutral-800 to-neutral-900 shadow-lg">
                <div class="space-y-6">
                    <div class="h-48 rounded-lg bg-emerald-500/10 flex items-center justify-center overflow-hidden relative group">
                        @if($challenge->image)
                            <img src="{{ asset('storage/' . $challenge->image) }}" alt="{{ $challenge->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        @else
                            <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/5 to-emerald-500/20 opacity-50"></div>
                            <svg class="w-24 h-24 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                        @endif
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="px-3 py-1 text-sm font-medium text-emerald-400 bg-emerald-500/10 border border-emerald-500/20 rounded-full">{{ ucfirst($challenge->difficulty_level) }}</span>
                            @php
                                $totalPoints = $challenge->tasks->sum('points_reward');
                            @endphp
                            <span class="px-3 py-1 text-sm font-medium text-amber-400 bg-amber-500/10 border border-amber-500/20 rounded-full flex items-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                                {{ $totalPoints }} Points
                            </span>
                            <span class="px-3 py-1 text-sm font-medium text-blue-400 bg-blue-500/10 border border-blue-500/20 rounded-full">{{ str_replace('_', ' ', ucfirst($challenge->challenge_type)) }}</span>
                            @if($challenge->programming_language && $challenge->programming_language !== 'none')
                                <span class="px-3 py-1 text-sm font-medium text-purple-400 bg-purple-500/10 border border-purple-500/20 rounded-full">{{ ucfirst($challenge->programming_language) }}</span>
                            @endif
                            @if($challenge->time_limit)
                                <span class="px-3 py-1 text-sm font-medium text-neutral-300 bg-neutral-500/10 border border-neutral-500/20 rounded-full flex items-center gap-1.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $challenge->time_limit }} min
                                </span>
                            @endif
                        </div>
                        <p class="text-neutral-300 leading-relaxed">{{ $challenge->description }}</p>
                    </div>
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Challenge Details
                        </h3>
                        @if($challenge->challenge_content)
                            @switch($challenge->challenge_type)
                                @case('coding_challenge')
                                    <div class="space-y-4 text-neutral-300">
                                        <div class="p-4 rounded-lg bg-neutral-800/50 border border-neutral-700">
                                            <h4 class="font-medium text-white mb-2 flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Problem Statement
                                            </h4>
                                            <p>{{ $challenge->challenge_content['problem_statement'] ?? 'No problem statement available' }}</p>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div class="p-4 rounded-lg bg-neutral-800/50 border border-neutral-700">
                                                <h4 class="font-medium text-white mb-2 flex items-center gap-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
                                                    </svg>
                                                    Input Format
                                                </h4>
                                                <p>{{ $challenge->challenge_content['input_format'] ?? 'Not specified' }}</p>
                                            </div>
                                            <div class="p-4 rounded-lg bg-neutral-800/50 border border-neutral-700">
                                                <h4 class="font-medium text-white mb-2 flex items-center gap-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                                    </svg>
                                                    Output Format
                                                </h4>
                                                <p>{{ $challenge->challenge_content['output_format'] ?? 'Not specified' }}</p>
                                            </div>
                                        </div>
                                        @if(isset($challenge->challenge_content['constraints']))
                                            <div class="p-4 rounded-lg bg-neutral-800/50 border border-neutral-700">
                                                <h4 class="font-medium text-white mb-2 flex items-center gap-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                                    </svg>
                                                    Constraints
                                                </h4>
                                                <p>{{ $challenge->challenge_content['constraints'] }}</p>
                                            </div>
                                        @endif
                                    </div>
                                    @break

                                @case('debugging')
                                    <div class="space-y-4 text-neutral-300">
                                        <div class="p-4 rounded-lg bg-neutral-800/50 border border-neutral-700">
                                            <h4 class="font-medium text-white mb-2 flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Scenario
                                            </h4>
                                            <p>{{ $challenge->challenge_content['scenario'] ?? 'No scenario available' }}</p>
                                        </div>
                                        {{-- <div>
                                            <h4 class="font-medium text-white">Code with Bugs</h4>
                                            <pre class="p-4 rounded-lg bg-neutral-900 text-neutral-300 font-mono text-sm whitespace-pre overflow-x-auto">{{ $challenge->challenge_content['buggy_code'] ?? 'No code available' }}</pre>
                                        </div>
                                        <div>
                                            <h4 class="font-medium text-white">Current Behavior</h4>
                                            <p>{{ $challenge->challenge_content['current_behavior'] ?? 'Not specified' }}</p>
                                        </div>
                                        <div>
                                            <h4 class="font-medium text-white">Expected Behavior</h4>
                                            <p>{{ $challenge->challenge_content['expected_behavior'] ?? 'Not specified' }}</p>
                                        </div> --}}
                                    </div>
                                    @break

                                @case('algorithm')
                                    <div class="space-y-4 text-neutral-300">
                                        <div class="p-4 rounded-lg bg-neutral-800/50 border border-neutral-700">
                                            <h4 class="font-medium text-white mb-2 flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Problem Statement
                                            </h4>
                                            <p>{{ $challenge->challenge_content['problem_statement'] ?? 'No problem statement available' }}</p>
                                        </div>
                                        @if(isset($challenge->challenge_content['example']))
                                            <div class="p-4 rounded-lg bg-neutral-800/50 border border-neutral-700">
                                                <h4 class="font-medium text-white mb-2 flex items-center gap-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                                    </svg>
                                                    Example
                                                </h4>
                                                <p>{{ $challenge->challenge_content['example'] }}</p>
                                            </div>
                                        @endif
                                    </div>
                                    @break

                                @case('project')
                                    <div class="space-y-4 text-neutral-300">
                                        <div class="p-4 rounded-lg bg-neutral-800/50 border border-neutral-700">
                                            <h4 class="font-medium text-white mb-2 flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                </svg>
                                                Project Brief
                                            </h4>
                                            <p>{{ $challenge->challenge_content['project_brief'] ?? 'No project brief available' }}</p>
                                        </div>
                                        <div class="p-4 rounded-lg bg-neutral-800/50 border border-neutral-700">
                                            <h4 class="font-medium text-white mb-2 flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                                </svg>
                                                Technical Requirements
                                            </h4>
                                            <p>{{ $challenge->challenge_content['requirements'] ?? 'Not specified' }}</p>
                                        </div>
                                    </div>
                                    @break

                                @default
                                    <div class="p-4 rounded-lg bg-neutral-800/50 border border-neutral-700 text-neutral-300">
                                        <p>Additional challenge details will be revealed when you start the challenge.</p>
                                    </div>
                            @endswitch
                        @endif

                        <div class="mt-6 p-4 rounded-lg bg-emerald-500/5 border border-emerald-500/20">
                            <h3 class="text-lg font-semibold text-white mb-3 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Requirements
                            </h3>
                            <ul class="list-none space-y-2 text-neutral-300">
                                <li class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>Complete all tasks within the challenge</span>
                                </li>
                                @if($challenge->time_limit)
                                    <li class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                        <span>Complete within {{ $challenge->time_limit }} minutes</span>
                                    </li>
                                @endif
                                @if($challenge->end_date)
                                    <li class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                        <span>Submit before {{ $challenge->end_date->format('M d, Y H:i') }}</span>
                                    </li>
                                @endif
                                <li class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>Follow the coding guidelines</span>
                                </li>
                                <li class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>Pass all test cases</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Challenge Progress -->
            <div class="flex flex-col p-6 rounded-xl border border-neutral-700 bg-gradient-to-br from-neutral-800 to-neutral-900 shadow-lg">
                <h2 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Your Progress
                </h2>
                <div class="space-y-6">
                    <div class="space-y-2">
                        @php
                            $totalTasks = $challenge->tasks->count();
                            $completedTasks = $challenge->tasks->where('completed', true)->count();
                            $progressPercentage = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;
                        @endphp
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-neutral-400">Overall Progress</span>
                            <span class="text-emerald-400">{{ $progressPercentage }}%</span>
                        </div>
                        <div class="h-2 rounded-full bg-neutral-700 overflow-hidden">
                            <div class="h-2 rounded-full bg-gradient-to-r from-emerald-500 to-emerald-400" style="width: {{ $progressPercentage }}%"></div>
                        </div>
                    </div>
                    <div class="space-y-4">
                        @if($challenge->tasks->count() > 0)
                            <div class="px-3 py-1.5 text-sm font-medium rounded-lg bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 flex items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>{{ $challenge->tasks->count() }} Tasks Available</span>
                            </div>
                            @php
                                $previousTaskCompleted = true; // First task is always accessible
                            @endphp
                            @foreach($challenge->tasks as $task)
                            <div class="space-y-2 p-3 rounded-lg {{ $previousTaskCompleted ? 'bg-neutral-800/50 border border-neutral-700 hover:border-emerald-500/30 hover:bg-neutral-800 transition-all duration-300' : 'bg-neutral-800/30 border border-neutral-700/50' }}">
                                <div class="flex items-center gap-4">
                                    <div class="w-3 h-3 rounded-full {{ $task->completed ? 'bg-emerald-400' : ($previousTaskCompleted ? 'bg-amber-400' : 'bg-neutral-600') }}"></div>
                                    <div class="flex-1">
                                        <div class="flex justify-between items-center">
                                            <div class="flex flex-col gap-1">
                                                <span class="text-sm {{ $task->completed ? 'text-emerald-400' : ($previousTaskCompleted ? 'text-white' : 'text-neutral-500') }}">Task {{ $loop->iteration }} Challenge</span>
                                                <div class="flex gap-2">
                                                    <span class="text-xs px-2 py-0.5 rounded-full text-amber-400 bg-amber-500/10 border border-amber-500/20 flex items-center gap-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                                        </svg>
                                                        {{ $task->points_reward ?? 0 }} Points
                                                    </span>
                                                    @if($task->time_limit)
                                                        <span class="text-xs px-2 py-0.5 rounded-full text-neutral-300 bg-neutral-500/10 border border-neutral-500/20 flex items-center gap-1">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                            {{ $task->time_limit }} min
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            @if($previousTaskCompleted)
                                                <a href="{{ route('challenge.task', ['challenge' => $challenge, 'task' => $task]) }}" 
                                                   class="px-6 py-1.5 text-sm font-medium rounded-lg bg-emerald-500 hover:bg-emerald-600 text-white transition-colors duration-300 flex items-center gap-1.5">
                                                    {{ $task->completed ? 'Review' : 'Start' }}
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                                    </svg>
                                                </a>
                                            @else
                                                <span class="px-3 py-1.5 text-sm font-medium rounded-lg bg-neutral-700/50 text-neutral-400 cursor-not-allowed flex items-center gap-1.5">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                                    </svg>
                                                    Locked
                                                </span>
                                            @endif
                                        </div>
                                        <div class="flex items-center gap-2 mt-1">
                                            @php
                                                $status = 'Not Started';
                                                if ($task->completed) {
                                                    $status = 'Completed';
                                                } elseif ($task->progress > 0) {
                                                    $status = 'In Progress';
                                                }
                                                $statusColor = match($status) {
                                                    'Completed' => 'text-emerald-400 bg-emerald-500/10 border-emerald-500/20',
                                                    'In Progress' => 'text-amber-400 bg-amber-500/10 border-amber-500/20',
                                                    default => 'text-neutral-400 bg-neutral-500/10 border-neutral-500/20'
                                                };
                                            @endphp
                                            <span class="text-xs px-2 py-0.5 rounded-full {{ $statusColor }} border">{{ $status }}</span>
                                            @if($status === 'In Progress')
                                                <span class="text-xs text-neutral-400">({{ $task->progress }}% done)</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="ml-7">
                                    <div class="h-1.5 w-full rounded-full bg-neutral-700 overflow-hidden">
                                        <div class="h-1.5 rounded-full bg-gradient-to-r from-emerald-500 to-emerald-400" style="width: {{ $task->progress ?? 0 }}%"></div>
                                    </div>
                                </div>
                            </div>
                            @php
                                $previousTaskCompleted = $task->completed;
                            @endphp
                            @endforeach
                        @else
                            <div class="px-3 py-1.5 text-sm font-medium rounded-lg bg-neutral-600/10 text-neutral-400 border border-neutral-600/20 flex items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>No Tasks Available</span>
                            </div>
                            @for($i = 1; $i <= 3; $i++)
                            <div class="space-y-2 p-3 rounded-lg bg-neutral-800/30 border border-neutral-700/50">
                                <div class="flex items-center gap-4">
                                    <div class="w-3 h-3 rounded-full bg-neutral-600"></div>
                                    <div class="flex-1">
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm text-neutral-500">Task {{ $i }} Challenge</span>
                                            <span class="px-3 py-1.5 text-sm font-medium rounded-lg bg-neutral-700/50 text-neutral-400 cursor-not-allowed flex items-center gap-1.5">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                                </svg>
                                                Locked
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="ml-7">
                                    <div class="h-1.5 w-full rounded-full bg-neutral-700"></div>
                                </div>
                            </div>
                            @endfor
                        @endif
                    </div>
                </div>
                
                <!-- Challenge Rewards -->
                <div class="mt-6 p-4 rounded-lg bg-amber-500/5 border border-amber-500/20">
                    <h3 class="text-base font-semibold text-white mb-3 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Rewards
                    </h3>
                    <ul class="list-none space-y-2 text-neutral-300">
                        <li class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>{{ $totalPoints }} points upon completion</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>{{ ucfirst($challenge->difficulty_level) }} badge for your profile</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Certificate of completion</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>