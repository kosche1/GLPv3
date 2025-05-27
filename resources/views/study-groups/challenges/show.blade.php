<x-layouts.app>
    <div class="container mx-auto px-4 py-8">
        <div class="mb-8">
            <a href="{{ route('study-groups.show', $studyGroup) }}" class="inline-flex items-center text-sm font-medium text-emerald-600 hover:text-emerald-700 dark:text-emerald-500 dark:hover:text-emerald-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back to {{ $studyGroup->name }}
            </a>
        </div>

        <!-- Challenge Header -->
        <div class="mb-8 rounded-lg bg-white p-6 shadow-md dark:bg-zinc-800">
            <div class="flex items-start justify-between">
                <div class="flex-grow">
                    <div class="flex items-center gap-2 mb-2">
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $groupChallenge->name }}</h1>
                        <span class="inline-flex items-center rounded-full bg-{{ $groupChallenge->isActive() ? 'green' : 'gray' }}-100 px-2.5 py-0.5 text-xs font-medium text-{{ $groupChallenge->isActive() ? 'green' : 'gray' }}-800 dark:bg-{{ $groupChallenge->isActive() ? 'green' : 'gray' }}-900/30 dark:text-{{ $groupChallenge->isActive() ? 'green' : 'gray' }}-500">
                            {{ $groupChallenge->isActive() ? 'Active' : 'Inactive' }}
                        </span>
                        @if($groupChallenge->difficulty_level)
                            <span class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800 dark:bg-blue-900/30 dark:text-blue-500">
                                {{ ucfirst($groupChallenge->difficulty_level) }}
                            </span>
                        @endif
                    </div>
                    <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                        <span>Created by {{ $groupChallenge->creator->name }}</span>
                        <span class="mx-2">•</span>
                        <span>{{ $groupChallenge->created_at->diffForHumans() }}</span>
                        @if($groupChallenge->category)
                            <span class="mx-2">•</span>
                            <span>{{ $groupChallenge->category->name }}</span>
                        @endif
                    </div>
                </div>
                
                <div class="flex gap-2">
                    @if($studyGroup->isModerator(auth()->user()))
                        <a href="{{ route('study-groups.challenges.edit', [$studyGroup, $groupChallenge]) }}" class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:border-gray-600 dark:bg-zinc-800 dark:text-white dark:hover:border-gray-600 dark:hover:bg-zinc-700 dark:focus:ring-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                            </svg>
                            Edit
                        </a>
                    @endif
                    
                    @if($groupChallenge->isActive() && !$userProgress)
                        <form action="{{ route('study-groups.challenges.join', [$studyGroup, $groupChallenge]) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="inline-flex items-center rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-700 focus:outline-none focus:ring-4 focus:ring-emerald-300 dark:bg-emerald-600 dark:hover:bg-emerald-700 dark:focus:ring-emerald-800">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                Join Challenge
                            </button>
                        </form>
                    @endif
                </div>
            </div>
            
            @if($groupChallenge->description)
                <div class="mt-4">
                    <div class="prose max-w-none dark:prose-invert">
                        {!! nl2br(e($groupChallenge->description)) !!}
                    </div>
                </div>
            @endif
        </div>

        <!-- Challenge Details -->
        <div class="mb-8 grid gap-6 md:grid-cols-2">
            <!-- Challenge Info -->
            <div class="rounded-lg bg-white p-6 shadow-md dark:bg-zinc-800">
                <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Challenge Details</h2>
                <div class="space-y-3">
                    @if($groupChallenge->start_date)
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Start Date:</span>
                            <span class="font-medium text-gray-900 dark:text-white">{{ $groupChallenge->start_date->format('M d, Y') }}</span>
                        </div>
                    @endif
                    @if($groupChallenge->end_date)
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">End Date:</span>
                            <span class="font-medium text-gray-900 dark:text-white">{{ $groupChallenge->end_date->format('M d, Y') }}</span>
                        </div>
                    @endif
                    @if($groupChallenge->points_reward)
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Points Reward:</span>
                            <span class="font-medium text-emerald-600 dark:text-emerald-500">{{ $groupChallenge->points_reward }} points</span>
                        </div>
                    @endif
                    @if($groupChallenge->time_limit)
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Time Limit:</span>
                            <span class="font-medium text-gray-900 dark:text-white">{{ $groupChallenge->time_limit }} minutes</span>
                        </div>
                    @endif
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Participants:</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $groupChallenge->participants->count() }}</span>
                    </div>
                </div>
            </div>

            <!-- User Progress -->
            @if($userProgress)
                <div class="rounded-lg bg-white p-6 shadow-md dark:bg-zinc-800">
                    <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Your Progress</h2>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Status:</span>
                            <span class="inline-flex items-center rounded-full bg-{{ $userProgress->pivot->status === 'completed' ? 'green' : ($userProgress->pivot->status === 'in_progress' ? 'blue' : 'gray') }}-100 px-2.5 py-0.5 text-xs font-medium text-{{ $userProgress->pivot->status === 'completed' ? 'green' : ($userProgress->pivot->status === 'in_progress' ? 'blue' : 'gray') }}-800 dark:bg-{{ $userProgress->pivot->status === 'completed' ? 'green' : ($userProgress->pivot->status === 'in_progress' ? 'blue' : 'gray') }}-900/30 dark:text-{{ $userProgress->pivot->status === 'completed' ? 'green' : ($userProgress->pivot->status === 'in_progress' ? 'blue' : 'gray') }}-500">
                                {{ ucfirst(str_replace('_', ' ', $userProgress->pivot->status)) }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Progress:</span>
                            <span class="font-medium text-gray-900 dark:text-white">{{ $userProgress->pivot->progress }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2 dark:bg-gray-700">
                            <div class="bg-emerald-600 h-2 rounded-full" style="width: {{ $userProgress->pivot->progress }}%"></div>
                        </div>
                        @if($userProgress->pivot->completed_at)
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Completed:</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($userProgress->pivot->completed_at)->format('M d, Y') }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Attempts:</span>
                            <span class="font-medium text-gray-900 dark:text-white">{{ $userProgress->pivot->attempts }}</span>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Challenge Content -->
        @if($groupChallenge->challenge_content)
            <div class="mb-8 rounded-lg bg-white p-6 shadow-md dark:bg-zinc-800">
                <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Challenge Content</h2>
                <div class="prose max-w-none dark:prose-invert">
                    {!! nl2br(e($groupChallenge->challenge_content)) !!}
                </div>
            </div>
        @endif

        <!-- Tasks -->
        @if($groupChallenge->tasks->count() > 0)
            <div class="mb-8 rounded-lg bg-white p-6 shadow-md dark:bg-zinc-800">
                <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Tasks</h2>
                <div class="space-y-4">
                    @foreach($groupChallenge->tasks as $task)
                        <div class="rounded-lg border border-gray-200 p-4 dark:border-gray-600">
                            <h3 class="font-semibold text-gray-900 dark:text-white">{{ $task->name }}</h3>
                            @if($task->description)
                                <p class="mt-2 text-gray-600 dark:text-gray-400">{{ $task->description }}</p>
                            @endif
                            @if($task->points_reward)
                                <div class="mt-2">
                                    <span class="inline-flex items-center rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-medium text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-500">
                                        {{ $task->points_reward }} points
                                    </span>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Participants -->
        <div class="rounded-lg bg-white p-6 shadow-md dark:bg-zinc-800">
            <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Participants ({{ $groupChallenge->participants->count() }})</h2>
            @if($groupChallenge->participants->count() > 0)
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($groupChallenge->participants as $participant)
                        <div class="flex items-center rounded-lg border border-gray-200 p-4 dark:border-gray-600">
                            <div class="h-10 w-10 flex-shrink-0 overflow-hidden rounded-full bg-emerald-100 dark:bg-emerald-900/30">
                                @if($participant->avatar)
                                    <img src="{{ $participant->avatar }}" alt="{{ $participant->name }}" class="h-full w-full object-cover">
                                @else
                                    <div class="flex h-full w-full items-center justify-center">
                                        <span class="text-sm font-bold text-emerald-600 dark:text-emerald-500">{{ $participant->initials() }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="ml-3">
                                <p class="font-medium text-gray-900 dark:text-white">{{ $participant->name }}</p>
                                <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                    <span>{{ $participant->pivot->progress }}% complete</span>
                                    <span class="ml-2 inline-flex items-center rounded-full bg-{{ $participant->pivot->status === 'completed' ? 'green' : ($participant->pivot->status === 'in_progress' ? 'blue' : 'gray') }}-100 px-2 py-0.5 text-xs font-medium text-{{ $participant->pivot->status === 'completed' ? 'green' : ($participant->pivot->status === 'in_progress' ? 'blue' : 'gray') }}-800 dark:bg-{{ $participant->pivot->status === 'completed' ? 'green' : ($participant->pivot->status === 'in_progress' ? 'blue' : 'gray') }}-900/30 dark:text-{{ $participant->pivot->status === 'completed' ? 'green' : ($participant->pivot->status === 'in_progress' ? 'blue' : 'gray') }}-500">
                                        {{ ucfirst(str_replace('_', ' ', $participant->pivot->status)) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-600 dark:text-gray-400">No participants yet. Be the first to join this challenge!</p>
            @endif
        </div>
    </div>
</x-layouts.app>
