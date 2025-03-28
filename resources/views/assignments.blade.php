<x-layouts.app>
    <!-- <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">    -->
    <div class="flex h-full w-full flex-1 flex-col gap-6 text-gray-100 p-6 border border-emerald-500 rounded-lg" id="app">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                    <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">{{ __('Challenges') }}</h1>
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
                        <input type="text" placeholder="Search notifications..." 
                            class="w-full md:min-w-[250px] rounded-lg border border-neutral-700 bg-neutral-800 pl-10 pr-4 py-2 text-sm text-white placeholder-neutral-400 focus:border-neutral-600 focus:outline-none transition-all duration-300 hover:border-neutral-600">
                    </div>

                    <!-- Filter Dropdown -->
                    <div x-data="{ status: 'all' }">
                        <select class="w-full md:w-auto rounded-lg border border-neutral-700 bg-neutral-800 px-4 py-2 text-sm text-white focus:border-neutral-600 focus:outline-none transition-all duration-300 hover:border-neutral-600" 
                                x-model="status" 
                                @change="$wire.setStatus(status)">
                            <option value="all">All Notifications</option>
                            <option value="unread">Unread</option>
                            <option value="read">Read</option>
                            <option value="important">Important</option>
                        </select>
                    </div>
                </div>
            </div>

        <!-- Assignments Grid -->
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
            @if(isset($challenges) && count($challenges) > 0)
                @foreach($challenges as $challenge)
                    <!-- Challenge Header Card -->
                    <div class="bg-neutral-800 rounded-lg shadow-lg p-6 transition-all duration-300 hover:shadow-xl hover:scale-[1.02] border border-neutral-700">
                        <div class="mb-4 flex items-center justify-between">
                            <span class="rounded-full bg-emerald-500/10 px-3 py-1 text-xs font-medium text-emerald-400">{{ ucfirst($challenge->difficulty_level) }}</span>
                            <span class="text-sm text-neutral-400">{{ str_replace('_', ' ', ucfirst($challenge->challenge_type)) }}</span>
                        </div>
                        <h3 class="mb-2 text-lg font-semibold text-white">{{ $challenge->name }}</h3>
                        <p class="mb-4 text-sm text-neutral-300">{{ \Illuminate\Support\Str::limit($challenge->description, 100) }}</p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                @php
                                    $totalPoints = $challenge->tasks->sum('points_reward');
                                @endphp
                                <span class="text-sm font-medium text-neutral-300">Points: {{ $totalPoints }}</span>
                                @if($challenge->time_limit)
                                    <span class="text-sm text-neutral-400">|</span>
                                    <span class="text-sm text-neutral-400">{{ $challenge->time_limit }} min</span>
                                @endif
                            </div>
                            <a href="{{ route('challenge', ['challenge' => $challenge]) }}" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition-colors duration-300">View Challenge</a>
                        </div>
                    </div>
                @endforeach
            @endif

            @if(isset($challengeTasks) && count($challengeTasks) > 0)
                @foreach($challengeTasks as $task)
                    <div class="bg-neutral-800 rounded-lg shadow-lg p-6 transition-all duration-300 hover:shadow-xl hover:scale-[1.02] border border-neutral-700">
                        <div class="mb-4 flex items-center justify-between">
                            @php
                                $status = 'Not Started';
                                $statusClass = 'bg-neutral-500/10 text-neutral-400';
                                
                                if ($task->completed) {
                                    $status = 'Completed';
                                    $statusClass = 'bg-emerald-500/10 text-emerald-400';
                                } elseif ($task->progress > 0) {
                                    $status = 'In Progress';
                                    $statusClass = 'bg-amber-500/10 text-amber-400';
                                }
                                
                                $dueText = '';
                                if (isset($task->challenge->end_date)) {
                                    $daysLeft = now()->diffInDays($task->challenge->end_date, false);
                                    if ($daysLeft > 0) {
                                        $dueText = "Due in {$daysLeft} " . Str::plural('day', $daysLeft);
                                    } elseif ($daysLeft == 0) {
                                        $dueText = "Due today";
                                    } else {
                                        $dueText = "Overdue";
                                    }
                                }
                            @endphp
                            <span class="rounded-full {{ $statusClass }} px-3 py-1 text-xs font-medium">{{ $status }}</span>
                            @if($dueText)
                                <span class="text-sm text-neutral-400">{{ $dueText }}</span>
                            @endif
                        </div>
                        <h3 class="mb-2 text-lg font-semibold text-white">Task {{ $task->id }} - {{ $task->challenge->name }}</h3>
                        
                        <!-- Progress bar -->
                        <div class="mb-4">
                            <div class="h-1.5 w-full rounded-full bg-neutral-700">
                                <div class="h-1.5 rounded-full bg-emerald-400" style="width: {{ $task->progress ?? 0 }}%"></div>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <span class="text-sm font-medium text-neutral-300">Points: {{ $task->points_reward }}</span>
                                @if($task->time_limit)
                                    <span class="text-sm text-neutral-400">|</span>
                                    <span class="text-sm text-neutral-400">{{ $task->time_limit }} min</span>
                                @endif
                            </div>
                            <a href="{{ route('challenge.task', ['challenge' => $task->challenge, 'task' => $task]) }}" 
                               class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition-colors duration-300">
                                {{ $task->completed ? 'Review' : 'Start Task' }}
                            </a>
                        </div>
                    </div>
                @endforeach
            @endif
            
            @if((!isset($challenges) || count($challenges) == 0) && (!isset($challengeTasks) || count($challengeTasks) == 0))
                <div class="col-span-3 flex flex-col items-center justify-center p-10 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-neutral-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                    <h3 class="text-lg font-semibold text-white mb-2">No Challenges Available</h3>
                    <p class="text-sm text-neutral-400">There are currently no challenges or tasks assigned to you.</p>
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
</x-layouts.app>