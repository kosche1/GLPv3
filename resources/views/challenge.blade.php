<x-layouts.app>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold text-white">{{ $challenge->name }}</h1>
            <div class="flex gap-4">
                <a href="{{ route('learning') }}" class="flex flex-col items-center justify-center p-4 rounded-xl border-2 border-emerald-500 bg-emerald-500/10 transition-all duration-300 hover:scale-[1.02] hover:shadow-lg hover:shadow-emerald-900/50 hover:bg-emerald-500/20 group">
                    <span class="text-lg font-semibold text-emerald-400 group-hover:text-emerald-300">Back</span>
                </a>
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-3">
            <!-- Challenge Details -->
            <div class="md:col-span-2 flex flex-col p-6 rounded-xl border border-neutral-700 bg-neutral-800">
                <div class="space-y-6">
                    <div class="h-48 rounded-lg bg-emerald-500/10 flex items-center justify-center overflow-hidden">
                        @if($challenge->image)
                            <img src="{{ asset('storage/' . $challenge->image) }}" alt="{{ $challenge->name }}" class="w-full h-full object-cover">
                        @else
                            <svg class="w-24 h-24 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                        @endif
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="px-3 py-1 text-sm font-medium text-emerald-400 bg-emerald-500/10 rounded-full">{{ ucfirst($challenge->difficulty_level) }}</span>
                            @php
                                $totalPoints = $challenge->tasks->sum('points_reward');
                            @endphp
                            <span class="px-3 py-1 text-sm font-medium text-emerald-400 bg-emerald-500/10 rounded-full">{{ $totalPoints }} Points</span>
                            <span class="px-3 py-1 text-sm font-medium text-emerald-400 bg-emerald-500/10 rounded-full">{{ str_replace('_', ' ', ucfirst($challenge->challenge_type)) }}</span>
                            @if($challenge->programming_language && $challenge->programming_language !== 'none')
                                <span class="px-3 py-1 text-sm font-medium text-emerald-400 bg-emerald-500/10 rounded-full">{{ ucfirst($challenge->programming_language) }}</span>
                            @endif
                            @if($challenge->time_limit)
                                <span class="px-3 py-1 text-sm font-medium text-emerald-400 bg-emerald-500/10 rounded-full">{{ $challenge->time_limit }} min</span>
                            @endif
                        </div>
                        <p class="text-neutral-400">{{ $challenge->description }}</p>
                    </div>
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-white">Challenge Details</h3>
                        @if($challenge->challenge_content)
                            @switch($challenge->challenge_type)
                                @case('coding_challenge')
                                    <div class="space-y-4 text-neutral-400">
                                        <div>
                                            <h4 class="font-medium text-white">Problem Statement</h4>
                                            <p>{{ $challenge->challenge_content['problem_statement'] ?? 'No problem statement available' }}</p>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <h4 class="font-medium text-white">Input Format</h4>
                                                <p>{{ $challenge->challenge_content['input_format'] ?? 'Not specified' }}</p>
                                            </div>
                                            <div>
                                                <h4 class="font-medium text-white">Output Format</h4>
                                                <p>{{ $challenge->challenge_content['output_format'] ?? 'Not specified' }}</p>
                                            </div>
                                        </div>
                                        @if(isset($challenge->challenge_content['constraints']))
                                            <div>
                                                <h4 class="font-medium text-white">Constraints</h4>
                                                <p>{{ $challenge->challenge_content['constraints'] }}</p>
                                            </div>
                                        @endif
                                    </div>
                                    @break

                                @case('debugging')
                                    <div class="space-y-4 text-neutral-400">
                                        <div>
                                            <h4 class="font-medium text-white">Scenario</h4>
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
                                    <div class="space-y-4 text-neutral-400">
                                        <div>
                                            <h4 class="font-medium text-white">Problem Statement</h4>
                                            <p>{{ $challenge->challenge_content['problem_statement'] ?? 'No problem statement available' }}</p>
                                        </div>
                                        @if(isset($challenge->challenge_content['example']))
                                            <div>
                                                <h4 class="font-medium text-white">Example</h4>
                                                <p>{{ $challenge->challenge_content['example'] }}</p>
                                            </div>
                                        @endif
                                    </div>
                                    @break

                                @case('project')
                                    <div class="space-y-4 text-neutral-400">
                                        <div>
                                            <h4 class="font-medium text-white">Project Brief</h4>
                                            <p>{{ $challenge->challenge_content['project_brief'] ?? 'No project brief available' }}</p>
                                        </div>
                                        <div>
                                            <h4 class="font-medium text-white">Technical Requirements</h4>
                                            <p>{{ $challenge->challenge_content['requirements'] ?? 'Not specified' }}</p>
                                        </div>
                                    </div>
                                    @break

                                @default
                                    <p class="text-neutral-400">Additional challenge details will be revealed when you start the challenge.</p>
                            @endswitch
                        @endif

                        <div class="mt-6">
                            <h3 class="text-lg font-semibold text-white mb-3">Requirements</h3>
                            <ul class="list-disc list-inside space-y-2 text-neutral-400">
                                <li>Complete all tasks within the challenge</li>
                                @if($challenge->time_limit)
                                    <li>Complete within {{ $challenge->time_limit }} minutes</li>
                                @endif
                                @if($challenge->end_date)
                                    <li>Submit before {{ $challenge->end_date->format('M d, Y H:i') }}</li>
                                @endif
                                <li>Follow the coding guidelines</li>
                                <li>Pass all test cases</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Challenge Progress -->
            <div class="flex flex-col p-6 rounded-xl border border-neutral-700 bg-neutral-800">
                <h2 class="text-lg font-semibold text-white mb-4">Your Progress</h2>
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
                        <div class="h-2 rounded-full bg-neutral-700">
                            <div class="h-2 rounded-full bg-emerald-400" style="width: {{ $progressPercentage }}%"></div>
                        </div>
                    </div>
                    <div class="space-y-4">
                        @if($challenge->tasks->count() > 0)
                            <div class="px-3 py-1 text-sm font-medium rounded-lg bg-emerald-500/10 text-emerald-400 flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Tasks Available
                            </div>
                            @php
                                $previousTaskCompleted = true; // First task is always accessible
                            @endphp
                            @foreach($challenge->tasks as $task)
                            <div class="space-y-2">
                                <div class="flex items-center gap-4">
                                    <div class="w-2 h-2 rounded-full {{ $task->completed ? 'bg-emerald-400' : 'bg-neutral-700' }}"></div>
                                    <div class="flex-1">
                                        <div class="flex justify-between items-center">
                                            <div class="flex flex-col gap-1">
                                                <span class="text-sm {{ $task->completed ? 'text-emerald-400' : 'text-neutral-400' }}">Task {{ $loop->iteration }} Challenge</span>
                                                <div class="flex gap-2">
                                                    <span class="text-xs px-2 py-0.5 rounded-full text-emerald-400 bg-emerald-500/10">{{ $task->points_reward ?? 0 }} Points</span>
                                                    @if($task->time_limit)
                                                        <span class="text-xs px-2 py-0.5 rounded-full text-emerald-400 bg-emerald-500/10">{{ $task->time_limit }} min</span>
                                                    @endif
                                                </div>
                                            </div>
                                            @if($previousTaskCompleted)
                                                <a href="{{ route('challenge.task', ['challenge' => $challenge, 'task' => $task]) }}" 
                                                   class="px-6 py-1 text-sm font-medium rounded-lg bg-emerald-500 hover:bg-emerald-600 text-white transition-colors duration-300">
                                                    {{ $task->completed ? 'Review' : 'Go' }}
                                                </a>
                                            @else
                                                <span class="px-3 py-1 text-sm font-medium rounded-lg bg-neutral-600 text-neutral-400 cursor-not-allowed flex items-center gap-2">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
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
                                                    'Completed' => 'text-emerald-400 bg-emerald-500/10',
                                                    'In Progress' => 'text-amber-400 bg-amber-500/10',
                                                    default => 'text-neutral-400 bg-neutral-500/10'
                                                };
                                            @endphp
                                            <span class="text-xs px-2 py-0.5 rounded-full {{ $statusColor }}">{{ $status }}</span>
                                            @if($status === 'In Progress')
                                                <span class="text-xs text-neutral-400">({{ $task->progress }}% done)</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="ml-6">
                                    <div class="h-1.5 w-full rounded-full bg-neutral-700">
                                        <div class="h-1.5 rounded-full bg-emerald-400" style="width: {{ $task->progress ?? 0 }}%"></div>
                                    </div>
                                </div>
                            </div>
                            @php
                                $previousTaskCompleted = $task->completed;
                            @endphp
                            @endforeach
                        @else
                            <div class="px-3 py-1 text-sm font-medium rounded-lg bg-neutral-600/10 text-neutral-400 flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                No Tasks Available
                            </div>
                            @for($i = 1; $i <= 3; $i++)
                            <div class="space-y-2">
                                <div class="flex items-center gap-4">
                                    <div class="w-2 h-2 rounded-full bg-neutral-700"></div>
                                    <span class="text-sm text-neutral-400">Task {{ $i }} Challenge</span>
                                </div>
                                <div class="ml-6">
                                    <div class="h-1.5 w-full rounded-full bg-neutral-700"></div>
                                </div>
                            </div>
                            @endfor
                        @endif
                    </div>
                    {{-- @if($nextTask)
                    <a href="{{ route('challenge.task', ['challenge' => $challenge, 'task' => $nextTask]) }}" class="w-full py-3 px-4 rounded-xl bg-emerald-500 hover:bg-emerald-600 transition-colors duration-300 text-white font-semibold text-center">
                        @if($challenge->tasks->where('progress', '>', 0)->count() > 0)
                            Continue Challenge
                        @else
                            Start Challenge
                        @endif
                    </a>
                    @else
                    <div class="w-full py-3 px-4 rounded-xl bg-neutral-600 text-white font-semibold text-center cursor-not-allowed">
                        No tasks available
                    </div>
                    @endif --}}
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>