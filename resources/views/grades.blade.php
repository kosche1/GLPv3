<x-layouts.app>
    <div class="container mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">{{ __('Grades') }}</h1>
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

        <!-- GPA Summary Card -->
        <div class="mb-8 grid gap-6 md:grid-cols-3">
            <div class="flex flex-col justify-between p-6 rounded-xl border border-neutral-700 bg-neutral-800 transition-all duration-300 ease-in-out hover:scale-[1.02] hover:shadow-lg hover:shadow-neutral-900/50 hover:border-neutral-600 hover:bg-neutral-800/90">
                <div class="space-y-1">
                    <h3 class="text-sm font-medium text-neutral-400">{{ __('Current GPA') }}</h3>
                    <p class="text-2xl font-semibold text-white">3.85</p>
                </div>
            </div>
            <div class="flex flex-col justify-between p-6 rounded-xl border border-neutral-700 bg-neutral-800 transition-all duration-300 ease-in-out hover:scale-[1.02] hover:shadow-lg hover:shadow-neutral-900/50 hover:border-neutral-600 hover:bg-neutral-800/90">
                <div class="space-y-1">
                    <h3 class="text-sm font-medium text-neutral-400">{{ __('Cumulative GPA') }}</h3>
                    <p class="text-2xl font-semibold text-white">3.92</p>
                </div>
            </div>
            <div class="flex flex-col justify-between p-6 rounded-xl border border-neutral-700 bg-neutral-800 transition-all duration-300 ease-in-out hover:scale-[1.02] hover:shadow-lg hover:shadow-neutral-900/50 hover:border-neutral-600 hover:bg-neutral-800/90">
                <div class="space-y-1">
                    <h3 class="text-sm font-medium text-neutral-400">{{ __('Credits Completed') }}</h3>
                    <p class="text-2xl font-semibold text-white">86</p>
                </div>
            </div>
        </div>

        <!-- Course Grades Table -->
        <div class="rounded-xl border border-neutral-700 bg-neutral-800 transition-all duration-300 ease-in-out hover:border-neutral-600 mb-8">
            <div class="border-b border-neutral-700 px-8 py-5">
                <h2 class="text-lg font-semibold text-white">{{ __('Current Semester Grades') }}</h2>
            </div>
            <div class="overflow-x-auto p-1">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-neutral-700 text-sm">
                            <th class="whitespace-nowrap px-8 py-4 text-left font-medium text-neutral-400">{{ __('Course') }}</th>
                            <th class="whitespace-nowrap px-8 py-4 text-left font-medium text-neutral-400">{{ __('Code') }}</th>
                            <th class="whitespace-nowrap px-8 py-4 text-left font-medium text-neutral-400">{{ __('Credits') }}</th>
                            <th class="whitespace-nowrap px-8 py-4 text-left font-medium text-neutral-400">{{ __('Grade') }}</th>
                            <th class="whitespace-nowrap px-8 py-4 text-left font-medium text-neutral-400">{{ __('Status') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-700">
                        <tr class="text-sm transition-colors hover:bg-neutral-700/50">
                            <td class="whitespace-nowrap px-8 py-5 text-white">Advanced Mathematics</td>
                            <td class="whitespace-nowrap px-8 py-5 text-neutral-400">MATH301</td>
                            <td class="whitespace-nowrap px-8 py-5 text-neutral-400">3</td>
                            <td class="whitespace-nowrap px-8 py-5 text-white">A</td>
                            <td class="whitespace-nowrap px-8 py-5">
                                <span class="inline-flex rounded-full bg-green-900/20 border border-green-900/30 px-3 py-1 text-xs font-semibold leading-5 text-green-400">Completed</span>
                            </td>
                        </tr>
                        <tr class="text-sm transition-colors hover:bg-neutral-700/50">
                            <td class="whitespace-nowrap px-8 py-5 text-white">Computer Science Fundamentals</td>
                            <td class="whitespace-nowrap px-8 py-5 text-neutral-400">CS201</td>
                            <td class="whitespace-nowrap px-8 py-5 text-neutral-400">4</td>
                            <td class="whitespace-nowrap px-8 py-5 text-white">A-</td>
                            <td class="whitespace-nowrap px-8 py-5">
                                <span class="inline-flex rounded-full bg-green-900/20 border border-green-900/30 px-3 py-1 text-xs font-semibold leading-5 text-green-400">Completed</span>
                            </td>
                        </tr>
                        <tr class="text-sm transition-colors hover:bg-neutral-700/50">
                            <td class="whitespace-nowrap px-8 py-5 text-white">Data Structures</td>
                            <td class="whitespace-nowrap px-8 py-5 text-neutral-400">CS302</td>
                            <td class="whitespace-nowrap px-8 py-5 text-neutral-400">4</td>
                            <td class="whitespace-nowrap px-8 py-5 text-white">B+</td>
                            <td class="whitespace-nowrap px-8 py-5">
                                <span class="inline-flex rounded-full bg-yellow-900/20 border border-yellow-900/30 px-3 py-1 text-xs font-semibold leading-5 text-yellow-400">In Progress</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- GPA Progress Bar -->
        <div class="mb-8 rounded-xl border border-neutral-700 bg-neutral-800 p-6 transition-all duration-300 ease-in-out hover:border-neutral-600">
            <h3 class="text-lg font-semibold text-white">{{ __('GPA Progress') }}</h3>
            <div class="w-full h-2 bg-neutral-700 rounded-full mt-2">
                <div class="h-2 bg-blue-500 rounded-full" style="width: 80%"></div>
            </div>
            <div class="flex justify-between text-sm mt-2">
                <span class="text-neutral-400">Target GPA: 4.0</span>
                <span class="text-neutral-400">Current: 3.85</span>
            </div>
        </div>

        <!-- Recent Activity Section -->
        <div class="mb-8 rounded-xl border border-neutral-700 bg-neutral-800 p-6 transition-all duration-300 ease-in-out hover:border-neutral-600">
            <h3 class="text-lg font-semibold text-white">{{ __('Recent Activities') }}</h3>
            <ul class="space-y-4 mt-4 text-sm text-neutral-400">
                <li>
                    <span class="font-medium text-white">March 4, 2025</span>: Completed a final project for Data Structures.
                </li>
                <li>
                    <span class="font-medium text-white">February 28, 2025</span>: Received feedback on Computer Science Fundamentals.
                </li>
                <li>
                    <span class="font-medium text-white">February 20, 2025</span>: Attended a seminar on AI in the Digital Age.
                </li>
            </ul>
        </div>
    </div>
</x-layouts.app>
