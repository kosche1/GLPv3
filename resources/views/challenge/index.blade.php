<x-layouts.app>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        @if(session('message'))
            <div class="p-4 mb-4 rounded-lg bg-emerald-500/20 border border-emerald-500 text-emerald-400">
                {{ session('message') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="p-4 mb-4 rounded-lg bg-red-500/20 border border-red-500 text-red-400">
                {{ session('error') }}
            </div>
        @endif

        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold text-white">{{ $challenge->name }}</h1>
            <div class="flex gap-4">
                <a href="{{ route('challenges') }}" class="flex flex-col items-center justify-center p-4 rounded-xl border-2 border-emerald-500 bg-emerald-500/10 transition-all duration-300 hover:scale-[1.02] hover:shadow-lg hover:shadow-emerald-900/50 hover:bg-emerald-500/20 group">
                    <span class="text-lg font-semibold text-emerald-400 group-hover:text-emerald-300">Back to Challenges</span>
                </a>
            </div>
        </div>

        <!-- Challenge Progress -->
        <div class="p-6 rounded-xl border border-neutral-700 bg-neutral-800 mb-4">
            <h2 class="text-xl font-semibold text-white mb-4">Your Progress</h2>
            
            @php
                $totalTasks = $challenge->tasks->count();
                $completedTasks = Auth::user()->studentAnswers()
                    ->whereIn('task_id', $challenge->tasks->pluck('id'))
                    ->where('is_correct', true)
                    ->distinct('task_id')
                    ->count();
                $progress = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;
            @endphp
            
            <x-progress-bar :progress="$progress" />
            
            <div class="mt-2 text-neutral-300">
                <span class="font-medium">{{ $completedTasks }} of {{ $totalTasks }} tasks completed</span>
                @if($completedTasks >= $totalTasks && $totalTasks > 0)
                    <div class="mt-2 p-3 bg-emerald-500/20 border border-emerald-500 rounded-lg">
                        <p class="text-emerald-400 font-medium">Congratulations! You've completed all tasks in this challenge.</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="grid gap-4 grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
            <!-- Challenge Info -->
            <div class="flex flex-col p-6 rounded-xl border border-neutral-700 bg-neutral-800">
                <h2 class="text-xl font-semibold text-white mb-4">Challenge Details</h2>
                <div class="space-y-4 flex-1">
                    <div>
                        <span class="text-neutral-400">Difficulty:</span>
                        <span class="ml-2 px-2 py-1 text-xs font-medium rounded-full
                            @if($challenge->difficulty_level === 'Beginner') bg-green-500/20 text-green-400
                            @elseif($challenge->difficulty_level === 'Intermediate') bg-yellow-500/20 text-yellow-400
                            @elseif($challenge->difficulty_level === 'Advanced') bg-red-500/20 text-red-400
                            @else bg-blue-500/20 text-blue-400
                            @endif">
                            {{ $challenge->difficulty_level }}
                        </span>
                    </div>
                    <div>
                        <span class="text-neutral-400">Points:</span>
                        <span class="ml-2 text-emerald-400">{{ $challenge->points_reward }}</span>
                    </div>
                    <div>
                        <span class="text-neutral-400">Language:</span>
                        <span class="ml-2 text-purple-400">{{ $challenge->programming_language ?? 'Multiple' }}</span>
                    </div>
                    <div>
                        <span class="text-neutral-400">Category:</span>
                        <span class="ml-2 text-blue-400">{{ $challenge->tech_category ?? 'General' }}</span>
                    </div>
                    <div>
                        <span class="text-neutral-400">Time Limit:</span>
                        <span class="ml-2 text-orange-400">{{ $challenge->time_limit ? $challenge->time_limit . ' minutes' : 'No limit' }}</span>
                    </div>
                    <div class="pt-4">
                        <h3 class="text-lg font-medium text-white mb-2">Description</h3>
                        <p class="text-neutral-300">{{ $challenge->description }}</p>
                    </div>
                </div>
            </div>

            <!-- Tasks List -->
            <div class="flex flex-col p-6 rounded-xl border border-neutral-700 bg-neutral-800 md:col-span-2">
                <h2 class="text-xl font-semibold text-white mb-4">Tasks</h2>
                <div class="space-y-4">
                    @foreach($challenge->tasks->sortBy('order') as $task)
                        @php
                            // Force a fresh check for completed tasks
                            $isCompleted = \App\Models\StudentAnswer::where('user_id', Auth::id())
                                ->where('task_id', $task->id)
                                ->where('is_correct', true)
                                ->exists();
                        @endphp
                        <div class="p-4 rounded-lg border {{ $isCompleted ? 'border-emerald-500 bg-emerald-900/20' : 'border-neutral-700 bg-neutral-900' }} transition-all duration-300 hover:border-neutral-600">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center">
                                    @if($isCompleted)
                                        <div class="w-8 h-8 rounded-full bg-emerald-500/20 flex items-center justify-center mr-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    @else
                                        <div class="w-8 h-8 rounded-full bg-neutral-700 flex items-center justify-center mr-3">
                                            <span class="text-neutral-300 font-medium">{{ $loop->iteration }}</span>
                                        </div>
                                    @endif
                                    <div>
                                        <h3 class="font-medium text-white">{{ $task->name }}</h3>
                                        <p class="text-sm text-neutral-400">{{ Str::limit($task->description, 100) }}</p>
                                        @if($isCompleted)
                                            <p class="text-sm text-emerald-400 mt-1">✓ Task completed successfully!</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="px-3 py-1 text-sm font-medium text-emerald-400 bg-emerald-500/10 rounded-full">{{ $task->points_reward ?? 0 }} Points</span>
                                    @if($isCompleted)
                                        <span class="px-4 py-2 rounded-lg bg-emerald-500/20 text-emerald-400 font-medium cursor-not-allowed">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                            </svg>
                                            Completed
                                        </span>
                                    @else
                                        <a href="{{ route('challenge.task', ['challenge' => $challenge, 'task' => $task]) }}" class="px-4 py-2 rounded-lg bg-emerald-500 hover:bg-emerald-600 transition-colors duration-300 text-white font-medium">
                                            Start Task
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>

<script>
    // Check if we need to refresh the page (coming from a task completion)
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('message')) {
            // Remove the message parameter from the URL without refreshing
            const newUrl = window.location.pathname;
            window.history.replaceState({}, document.title, newUrl);
            
            // Force a refresh after a short delay to ensure the task list is updated
            setTimeout(() => {
                window.location.reload();
            }, 100);
        }
    });
</script> 