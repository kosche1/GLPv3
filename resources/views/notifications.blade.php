<x-layouts.app>
    <div class="container mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="mb-8 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">{{ __('Notifications') }}</h1>
            
            <!-- Search and Filter Section -->
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <input type="text" placeholder="Search notifications..." class="w-64 rounded-lg border border-zinc-200 bg-white px-4 py-2 text-sm text-zinc-900 placeholder-zinc-500 focus:border-blue-500 focus:outline-none dark:border-zinc-700 dark:bg-zinc-800 dark:text-white dark:placeholder-zinc-400">
                </div>
                <select class="rounded-lg border border-zinc-200 bg-white px-4 py-2 text-sm text-zinc-900 focus:border-blue-500 focus:outline-none dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                    <option value="all">All Notifications</option>
                    <option value="unread">Unread</option>
                    <option value="read">Read</option>
                    <option value="important">Important</option>
                </select>
            </div>
        </div>
        <br>
        <!-- Notifications Grid -->
        <div class="grid grid-cols-1 gap-4">
            <!-- Notification Card -->
            @for ($i = 1; $i <= 3; $i++)
            <div class="bg-white dark:bg-zinc-900 rounded-lg shadow p-6 hover:bg-zinc-50/90 dark:hover:bg-zinc-800/90 transition duration-150 ease-in-out">
                <div class="mb-4 flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <span class="h-2 w-2 rounded-full bg-blue-600"></span>
                        <span class="text-sm font-medium text-zinc-900 dark:text-white">{{ $i === 1 ? 'New Message' : ($i === 2 ? 'System Update' : 'Assignment Feedback') }}</span>
                    </div>
                    <span class="text-sm text-zinc-500 dark:text-zinc-400">{{ $i }} hour{{ $i !== 1 ? 's' : '' }} ago</span>
                </div>
                <p class="mb-4 text-sm text-zinc-600 dark:text-zinc-300">{{ $i === 1 ? 'You have received a new message from your instructor regarding your recent submission.' : ($i === 2 ? 'Important system maintenance update scheduled for tomorrow at 2:00 PM.' : 'Your assignment has been graded. Click to view the feedback.') }}</p>
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-zinc-500 dark:text-zinc-400">{{ $i === 1 ? 'Course Message' : ($i === 2 ? 'System Notice' : 'Grade Update') }}</span>
                    </div>
                    <button class="text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 font-medium">Mark as read</button>
                </div>
            </div>
            @endfor
        </div>
        <br>

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