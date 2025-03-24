<x-layouts.app>
    <div class="container mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="mb-8 flex items-center justify-between">
            <h1 class="text-2xl font-semibold text-white">{{ __('Assignments') }}</h1>
            
            <!-- Search and Filter Section -->
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <input type="text" placeholder="Search assignments..." class="w-64 rounded-lg border border-neutral-700 bg-neutral-800 px-4 py-2 text-sm text-white placeholder-neutral-400 focus:border-neutral-600 focus:outline-none transition-all duration-300 hover:border-neutral-600">
                </div>
                <select class="rounded-lg border border-neutral-700 bg-neutral-800 px-4 py-2 text-sm text-white focus:border-neutral-600 focus:outline-none transition-all duration-300 hover:border-neutral-600">
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
            <div class="bg-neutral-800 rounded-lg shadow-lg p-6 transition-all duration-300 hover:shadow-xl hover:scale-[1.02] border border-neutral-700">
                <div class="mb-4 flex items-center justify-between">
                    <span class="rounded-full bg-blue-900 px-3 py-1 text-xs font-medium text-blue-200">Due in 3 days</span>
                    <span class="text-sm text-neutral-400">Course {{ $i }}</span>
                </div>
                <h3 class="mb-2 text-lg font-semibold text-white">Assignment {{ $i }}</h3>
                <p class="mb-4 text-sm text-neutral-300">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <span class="text-sm font-medium text-neutral-300">Points: 100</span>
                        <span class="text-sm text-neutral-400">|</span>
                        <span class="text-sm text-neutral-400">Individual</span>
                    </div>
                    <a href="#" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-300">View Details</a>
                </div>
            </div>
            @endfor
        </div>
        <br>

        <!-- Pagination -->
        <div class="mt-8 flex items-center justify-center">
            <nav class="flex space-x-2" aria-label="Pagination">
                <a href="#" class="rounded-lg border border-neutral-700 bg-neutral-800 px-4 py-2 text-sm font-medium text-neutral-400 hover:bg-neutral-700 hover:text-white transition-colors duration-300">Previous</a>
                <a href="#" class="rounded-lg border border-neutral-700 bg-neutral-800 px-4 py-2 text-sm font-medium text-white hover:bg-neutral-700 transition-colors duration-300">1</a>
                <a href="#" class="rounded-lg border border-neutral-700 bg-neutral-800 px-4 py-2 text-sm font-medium text-neutral-400 hover:bg-neutral-700 hover:text-white transition-colors duration-300">2</a>
                <a href="#" class="rounded-lg border border-neutral-700 bg-neutral-800 px-4 py-2 text-sm font-medium text-neutral-400 hover:bg-neutral-700 hover:text-white transition-colors duration-300">3</a>
                <a href="#" class="rounded-lg border border-neutral-700 bg-neutral-800 px-4 py-2 text-sm font-medium text-neutral-400 hover:bg-neutral-700 hover:text-white transition-colors duration-300">Next</a>
            </nav>
        </div>
    </div>
</x-layouts.app>