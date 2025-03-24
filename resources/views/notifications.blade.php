<x-layouts.app>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="mx-auto w-full max-w-7xl p-8">
            <!-- Header Section -->
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-semibold text-zinc-900 dark:text-white">{{ __('Notifications') }}</h1>
                
                <!-- Search and Filter Section -->
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <input type="text" placeholder="Search notifications..." class="w-64 rounded-lg border border-neutral-700 bg-neutral-800 px-4 py-2 text-sm text-white placeholder-neutral-400 focus:border-neutral-600 focus:outline-none transition-all duration-300 hover:border-neutral-600">
                    </div>
                    <select class="rounded-lg border border-neutral-700 bg-neutral-800 px-4 py-2 text-sm text-white focus:border-neutral-600 focus:outline-none transition-all duration-300 hover:border-neutral-600">
                        <option value="all">All Notifications</option>
                        <option value="unread">Unread</option>
                        <option value="read">Read</option>
                        <option value="important">Important</option>
                    </select>
                </div>
            </div>

            <!-- Notifications List -->
            <div class="mt-8 space-y-4">
                @for ($i = 1; $i <= 3; $i++)
                <div class="rounded-xl border border-neutral-700 bg-neutral-800 p-6 transition-all duration-300 hover:scale-[1.02] hover:shadow-lg hover:shadow-neutral-900/50 hover:border-neutral-600 hover:bg-neutral-800/90">
                    <div class="mb-4 flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <span class="h-2.5 w-2.5 rounded-full bg-rose-500"></span>
                            <span class="text-sm font-medium text-white">{{ $i === 1 ? 'New Message' : ($i === 2 ? 'System Update' : 'Assignment Feedback') }}</span>
                        </div>
                        <span class="text-sm text-neutral-400">{{ $i }} hour{{ $i !== 1 ? 's' : '' }} ago</span>
                    </div>
                    <p class="mb-4 text-sm text-neutral-300">{{ $i === 1 ? 'You have received a new message from your instructor regarding your recent submission.' : ($i === 2 ? 'Important system maintenance update scheduled for tomorrow at 2:00 PM.' : 'Your assignment has been graded. Click to view the feedback.') }}</p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-neutral-400">{{ $i === 1 ? 'Course Message' : ($i === 2 ? 'System Notice' : 'Grade Update') }}</span>
                        </div>
                        <button class="text-sm font-medium text-rose-400 hover:text-rose-300 transition-colors">Mark as read</button>
                    </div>
                </div>
                @endfor
            </div>

        <!-- Pagination -->
        <div class="mt-8 flex items-center justify-center">
            <nav class="flex space-x-2" aria-label="Pagination">
                <a href="#" class="rounded-lg border border-zinc-200 bg-white px-4 py-2 text-sm font-medium text-zinc-500 hover:bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-400 dark:hover:bg-zinc-700">Previous</a>
                <a href="#" class="rounded-lg border border-zinc-200 bg-white px-4 py-2 text-sm font-medium text-zinc-900 hover:bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white dark:hover:bg-zinc-700">1</a>
                <a href="#" class="rounded-lg border border-zinc-200 bg-white px-4 py-2 text-sm font-medium text-zinc-500 hover:bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-400 dark:hover:bg-zinc-700">2</a>
                <a href="#" class="rounded-lg border border-zinc-200 bg-white px-4 py-2 text-sm font-medium text-zinc-500 hover:bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-400 dark:hover:bg-zinc-700">3</a>
                <a href="#" class="rounded-lg border border-zinc-200 bg-white px-4 py-2 text-sm font-medium text-zinc-500 hover:bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-400 dark:hover:bg-zinc-700">Next</a>
            </nav>
        </div>
    </div>
</x-layouts.app>