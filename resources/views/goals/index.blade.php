<x-layouts.app>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-5xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-white">Your Activity Goals</h1>
            <a href="{{ route('goals.create') }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white rounded-lg transition-colors duration-200 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Create New Goal
            </a>
        </div>

        @if(session('success'))
            <div class="bg-emerald-500/20 border border-emerald-500/50 text-emerald-300 px-4 py-3 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if($goals->isEmpty())
            <div class="bg-neutral-800/50 rounded-xl border border-neutral-700/50 p-8 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-neutral-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <h3 class="text-xl font-medium text-gray-300 mb-2">No Goals Yet</h3>
                <p class="text-gray-400 mb-3">You haven't created any activity goals yet. Goals help you stay motivated and track your progress.</p>
                <p class="text-gray-500 text-sm">Use the "Create New Goal" button at the top to get started.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($goals as $goal)
                    <div class="bg-neutral-800/50 rounded-xl border border-neutral-700/50 p-6 hover:border-neutral-600/50 transition-all duration-300">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-lg font-medium text-white">{{ $goal->title }}</h3>
                            <div class="flex items-center gap-2">
                                @if($goal->is_completed)
                                    <span class="px-2 py-1 bg-emerald-500/20 text-emerald-400 text-xs rounded-full">Completed</span>
                                @elseif($goal->isActive())
                                    <span class="px-2 py-1 bg-blue-500/20 text-blue-400 text-xs rounded-full">Active</span>
                                @else
                                    <span class="px-2 py-1 bg-neutral-700/50 text-neutral-400 text-xs rounded-full">Inactive</span>
                                @endif
                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open" class="text-neutral-400 hover:text-white transition-colors duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                                        </svg>
                                    </button>
                                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-neutral-900 rounded-lg shadow-lg border border-neutral-700 z-10" style="display: none;">
                                        <a href="{{ route('goals.edit', $goal) }}" class="block px-4 py-2 text-sm text-neutral-300 hover:bg-neutral-800 hover:text-white rounded-t-lg">Edit Goal</a>
                                        <form action="{{ route('goals.destroy', $goal) }}" method="POST" class="block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-400 hover:bg-neutral-800 hover:text-red-300 rounded-b-lg" onclick="return confirm('Are you sure you want to delete this goal?')">Delete Goal</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($goal->description)
                            <p class="text-neutral-400 text-sm mb-4">{{ $goal->description }}</p>
                        @endif

                        <div class="mb-4">
                            <div class="flex justify-between items-center mb-1">
                                <div class="text-sm text-neutral-400">
                                    <span class="font-medium">{{ ucfirst(str_replace('_', ' ', $goal->goal_type)) }}</span>
                                    @if($goal->period_type !== 'all_time')
                                        <span class="text-neutral-500"> • {{ ucfirst($goal->period_type) }}</span>
                                    @endif
                                </div>
                                <span class="text-sm text-neutral-300 font-medium">{{ $goal->getCurrentProgress() }} / {{ $goal->target_value }}</span>
                            </div>
                            <div class="w-full h-3 bg-neutral-800 rounded-full overflow-hidden border border-neutral-700/50">
                                <div class="h-full bg-gradient-to-r
                                    @if($goal->goal_type === 'login_streak') from-blue-500 to-cyan-400
                                    @elseif($goal->goal_type === 'tasks_completed') from-purple-500 to-indigo-400
                                    @elseif($goal->goal_type === 'challenges_completed') from-orange-500 to-amber-400
                                    @elseif($goal->goal_type === 'experience_points') from-pink-500 to-rose-400
                                    @else from-emerald-500 to-teal-400 @endif
                                    rounded-full" style="width: {{ $goal->getProgressPercentage() }}%"></div>
                            </div>
                        </div>

                        <div class="flex justify-between items-center text-xs text-neutral-500">
                            <div>
                                @if($goal->start_date)
                                    <span>{{ $goal->start_date->format('M j, Y') }}</span>
                                    @if($goal->end_date)
                                        <span> - {{ $goal->end_date->format('M j, Y') }}</span>
                                    @endif
                                @else
                                    <span>All time</span>
                                @endif
                            </div>

                            @if(!$goal->is_completed && $goal->isActive())
                                <form action="{{ route('goals.complete', $goal) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-emerald-400 hover:text-emerald-300 transition-colors duration-200">
                                        Mark as Completed
                                    </button>
                                </form>
                            @elseif($goal->is_completed)
                                <span class="text-emerald-400">Completed {{ $goal->completed_at->diffForHumans() }}</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
</x-layouts.app>
