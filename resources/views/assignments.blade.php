<x-layouts.app>
    <div class="container mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="mb-8 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">{{ __('Assignments') }}</h1>
            
            <!-- Search and Filter Section -->
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <input type="text" placeholder="Search assignments..." class="w-64 rounded-lg border border-zinc-200 bg-white px-4 py-2 text-sm text-zinc-900 placeholder-zinc-500 focus:border-blue-500 focus:outline-none dark:border-zinc-700 dark:bg-zinc-800 dark:text-white dark:placeholder-zinc-400">
                </div>
                <select class="rounded-lg border border-zinc-200 bg-white px-4 py-2 text-sm text-zinc-900 focus:border-blue-500 focus:outline-none dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                    <option value="all">All Courses</option>
                    <option value="pending">Pending</option>
                    <option value="submitted">Submitted</option>
                    <option value="graded">Graded</option>
                </select>
            </div>
        </div>
        <br>
        <!-- Assignments Grid -->
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
            <!-- Assignment Card -->
            @for ($i = 1; $i <= 3; $i++)
            <div class="bg-white dark:bg-zinc-900 rounded-lg shadow p-6">
                <div class="mb-4 flex items-center justify-between">
                    <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-800 dark:bg-blue-900 dark:text-blue-200">Due in 3 days</span>
                    <span class="text-sm text-zinc-500 dark:text-zinc-400">Course {{ $i }}</span>
                </div>
                <h3 class="mb-2 text-lg font-semibold text-zinc-900 dark:text-white">Assignment {{ $i }}</h3>
                <p class="mb-4 text-sm text-zinc-600 dark:text-zinc-300">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Points: 100</span>
                        <span class="text-sm text-zinc-500 dark:text-zinc-400">|</span>
                        <span class="text-sm text-zinc-500 dark:text-zinc-400">Individual</span>
                    </div>
                    <a href="#" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:hover:bg-blue-500">View Details</a>
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