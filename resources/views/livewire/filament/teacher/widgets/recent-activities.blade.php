<div class="p-6 bg-white rounded-xl shadow-sm dark:bg-gray-800">
    <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Recent Student Activities</h2>
    
    <div class="space-y-4">
        @forelse($activities as $activity)
            <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-700 flex items-start gap-3">
                <div class="p-2 rounded-lg bg-primary-50 dark:bg-primary-500/10 mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $activity->user->name }}</p>
                        <span class="text-xs text-gray-500 dark:text-gray-400">{{ $activity->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $activity->description }}</p>
                </div>
            </div>
        @empty
            <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-700">
                <p class="text-sm text-gray-500 dark:text-gray-400">No recent activities found.</p>
            </div>
        @endforelse
    </div>
</div>
