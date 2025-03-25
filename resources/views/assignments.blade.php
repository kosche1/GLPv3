<x-layouts.app>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">   
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
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
            <br>

        <!-- Assignments Grid -->
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
            @for ($i = 1; $i <= 3; $i++)
            <div class="bg-neutral-800 rounded-lg shadow-lg p-6 transition-all duration-300 hover:shadow-xl hover:scale-105 border border-neutral-700">
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