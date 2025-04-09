<x-layouts.app>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('goals.index') }}" class="text-neutral-400 hover:text-white transition-colors duration-200 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back to Goals
            </a>
        </div>

        <div class="bg-neutral-800/50 rounded-xl border border-neutral-700/50 p-6">
            <div class="flex justify-between items-start mb-6">
                <h1 class="text-2xl font-bold text-white">{{ $goal->title }}</h1>
                <div class="flex items-center gap-2">
                    @if($goal->is_completed)
                        <span class="px-3 py-1 bg-emerald-500/20 text-emerald-400 text-sm rounded-full">Completed</span>
                    @elseif($goal->isActive())
                        <span class="px-3 py-1 bg-blue-500/20 text-blue-400 text-sm rounded-full">Active</span>
                    @else
                        <span class="px-3 py-1 bg-neutral-700/50 text-neutral-400 text-sm rounded-full">Inactive</span>
                    @endif
                </div>
            </div>

            @if($goal->description)
                <div class="mb-6">
                    <h2 class="text-sm font-medium text-neutral-400 mb-2">Description</h2>
                    <p class="text-neutral-300">{{ $goal->description }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <h2 class="text-sm font-medium text-neutral-400 mb-2">Goal Details</h2>
                    <div class="bg-neutral-900/50 rounded-lg p-4 border border-neutral-700/50">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-neutral-500">Goal Type</p>
                                <p class="text-neutral-300">{{ ucfirst(str_replace('_', ' ', $goal->goal_type)) }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-neutral-500">Time Period</p>
                                <p class="text-neutral-300">{{ ucfirst($goal->period_type) }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-neutral-500">Created</p>
                                <p class="text-neutral-300">{{ $goal->created_at->format('M j, Y') }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-neutral-500">Status</p>
                                <p class="text-neutral-300">{{ $goal->is_active ? 'Active' : 'Inactive' }}</p>
                            </div>
                            @if($goal->start_date)
                                <div>
                                    <p class="text-xs text-neutral-500">Start Date</p>
                                    <p class="text-neutral-300">{{ $goal->start_date->format('M j, Y') }}</p>
                                </div>
                            @endif
                            @if($goal->end_date)
                                <div>
                                    <p class="text-xs text-neutral-500">End Date</p>
                                    <p class="text-neutral-300">{{ $goal->end_date->format('M j, Y') }}</p>
                                </div>
                            @endif
                            @if($goal->is_completed && $goal->completed_at)
                                <div class="col-span-2">
                                    <p class="text-xs text-neutral-500">Completed</p>
                                    <p class="text-emerald-400">{{ $goal->completed_at->format('M j, Y') }} ({{ $goal->completed_at->diffForHumans() }})</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div>
                    <h2 class="text-sm font-medium text-neutral-400 mb-2">Progress</h2>
                    <div class="bg-neutral-900/50 rounded-lg p-4 border border-neutral-700/50">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-neutral-300">Current Progress</span>
                            <span class="text-neutral-300 font-medium">{{ $goal->getCurrentProgress() }} / {{ $goal->target_value }}</span>
                        </div>
                        <div class="w-full h-4 bg-neutral-800 rounded-full overflow-hidden border border-neutral-700/50 mb-4">
                            <div class="h-full bg-gradient-to-r
                                @if($goal->goal_type === 'login_streak') from-blue-500 to-cyan-400
                                @elseif($goal->goal_type === 'tasks_completed') from-purple-500 to-indigo-400
                                @elseif($goal->goal_type === 'challenges_completed') from-orange-500 to-amber-400
                                @elseif($goal->goal_type === 'experience_points') from-pink-500 to-rose-400
                                @else from-emerald-500 to-teal-400 @endif
                                rounded-full" style="width: {{ $goal->getProgressPercentage() }}%"></div>
                        </div>
                        <p class="text-center text-sm text-neutral-400">{{ $goal->getProgressPercentage() }}% Complete</p>
                    </div>
                </div>
            </div>

            <div class="flex justify-between">
                <div>
                    <a href="{{ route('goals.edit', $goal) }}" class="px-4 py-2 bg-neutral-700 hover:bg-neutral-600 text-white rounded-lg transition-colors duration-200 inline-flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                        </svg>
                        Edit Goal
                    </a>
                </div>

                <div class="flex gap-2">
                    @if(!$goal->is_completed && $goal->isActive())
                        <form action="{{ route('goals.complete', $goal) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white rounded-lg transition-colors duration-200 inline-flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                Mark as Completed
                            </button>
                        </form>
                    @endif

                    <form action="{{ route('goals.destroy', $goal) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this goal?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-500 text-white rounded-lg transition-colors duration-200 inline-flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            Delete Goal
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</x-layouts.app>
