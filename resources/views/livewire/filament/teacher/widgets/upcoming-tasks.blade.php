<div class="p-6 bg-white rounded-xl shadow-sm dark:bg-gray-800">
    <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Upcoming Tasks</h2>
    
    <div class="space-y-4">
        @forelse($tasks as $task)
            <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-700">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="font-medium text-gray-900 dark:text-white">{{ $task->title }}</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ Str::limit($task->description, 50) }}</p>
                        @if($task->challenge)
                            <p class="text-xs text-primary-500 mt-1">{{ $task->challenge->title }}</p>
                        @endif
                    </div>
                    <div class="text-right">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-100 text-primary-800 dark:bg-primary-500/10 dark:text-primary-400">
                            {{ $task->due_date->format('M d, Y') }}
                        </span>
                    </div>
                </div>
            </div>
        @empty
            <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-700">
                <p class="text-sm text-gray-500 dark:text-gray-400">No upcoming tasks found.</p>
            </div>
        @endforelse
    </div>
</div>
