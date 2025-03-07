<x-layouts.app>
    <div class="container mx-auto px-4 py-8">
        <!-- Page Header -->
        <div class="mb-8 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">{{ __('Academic Performance') }}</h1>
            <div class="flex items-center space-x-4">
                <select class="rounded-lg border border-zinc-300 bg-white px-4 py-2 text-sm text-zinc-700 dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-300">
                    <option>{{ __('1st Semester') }}</option>
                    <option>{{ __('2nd Semester') }}</option>
                    <option>{{ __('All Semesters') }}</option>
                </select>
            </div>
        </div>
        <br>

        <!-- GPA Summary Card -->
        <div class="mb-8 rounded-lg bg-white p-6 shadow-sm dark:bg-zinc-900">
            <div class="grid gap-6 md:grid-cols-3">
                <div class="rounded-lg bg-white p-6 shadow-md dark:bg-zinc-800 text-center transition-all hover:shadow-lg">
                    <h3 class="text-sm font-medium text-zinc-500 dark:text-zinc-400">{{ __('Current GPA') }}</h3>
                    <p class="mt-2 text-3xl font-bold text-zinc-900 dark:text-white">3.85</p>
                </div>
                <div class="rounded-lg bg-white p-6 shadow-md dark:bg-zinc-800 text-center transition-all hover:shadow-lg">
                    <h3 class="text-sm font-medium text-zinc-500 dark:text-zinc-400">{{ __('Cumulative GPA') }}</h3>
                    <p class="mt-2 text-3xl font-bold text-zinc-900 dark:text-white">3.92</p>
                </div>
                <div class="rounded-lg bg-white p-6 shadow-md dark:bg-zinc-800 text-center transition-all hover:shadow-lg">
                    <h3 class="text-sm font-medium text-zinc-500 dark:text-zinc-400">{{ __('Credits Completed') }}</h3>
                    <p class="mt-2 text-3xl font-bold text-zinc-900 dark:text-white">86</p>
                </div>
            </div>
        </div>
        <br>

        <!-- Course Grades Table -->
        <div class="rounded-lg bg-white shadow-sm dark:bg-zinc-900">
            <div class="border-b border-zinc-200 px-8 py-5 dark:border-zinc-700">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">{{ __('Current Semester Grades') }}</h2>
            </div>
            <div class="overflow-x-auto p-1">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-zinc-200 text-sm dark:border-zinc-700">
                            <th class="whitespace-nowrap px-8 py-4 text-left font-medium text-zinc-500 dark:text-zinc-400">{{ __('Course') }}</th>
                            <th class="whitespace-nowrap px-8 py-4 text-left font-medium text-zinc-500 dark:text-zinc-400">{{ __('Code') }}</th>
                            <th class="whitespace-nowrap px-8 py-4 text-left font-medium text-zinc-500 dark:text-zinc-400">{{ __('Credits') }}</th>
                            <th class="whitespace-nowrap px-8 py-4 text-left font-medium text-zinc-500 dark:text-zinc-400">{{ __('Grade') }}</th>
                            <th class="whitespace-nowrap px-8 py-4 text-left font-medium text-zinc-500 dark:text-zinc-400">{{ __('Status') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        <tr class="text-sm hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                            <td class="whitespace-nowrap px-8 py-5 text-zinc-900 dark:text-white">Advanced Mathematics</td>
                            <td class="whitespace-nowrap px-8 py-5 text-zinc-500 dark:text-zinc-400">MATH301</td>
                            <td class="whitespace-nowrap px-8 py-5 text-zinc-500 dark:text-zinc-400">3</td>
                            <td class="whitespace-nowrap px-8 py-5 text-zinc-900 dark:text-white">A</td>
                            <td class="whitespace-nowrap px-8 py-5">
                                <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold leading-5 text-green-800 dark:bg-green-900 dark:text-green-200">Completed</span>
                            </td>
                        </tr>
                        <tr class="text-sm hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                            <td class="whitespace-nowrap px-8 py-5 text-zinc-900 dark:text-white">Computer Science Fundamentals</td>
                            <td class="whitespace-nowrap px-8 py-5 text-zinc-500 dark:text-zinc-400">CS201</td>
                            <td class="whitespace-nowrap px-8 py-5 text-zinc-500 dark:text-zinc-400">4</td>
                            <td class="whitespace-nowrap px-8 py-5 text-zinc-900 dark:text-white">A-</td>
                            <td class="whitespace-nowrap px-8 py-5">
                                <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold leading-5 text-green-800 dark:bg-green-900 dark:text-green-200">Completed</span>
                            </td>
                        </tr>
                        <tr class="text-sm hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                            <td class="whitespace-nowrap px-8 py-5 text-zinc-900 dark:text-white">Data Structures</td>
                            <td class="whitespace-nowrap px-8 py-5 text-zinc-500 dark:text-zinc-400">CS302</td>
                            <td class="whitespace-nowrap px-8 py-5 text-zinc-500 dark:text-zinc-400">4</td>
                            <td class="whitespace-nowrap px-8 py-5 text-zinc-900 dark:text-white">B+</td>
                            <td class="whitespace-nowrap px-8 py-5">
                                <span class="inline-flex rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold leading-5 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">In Progress</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <br>

        <!-- GPA Progress Bar -->
        <div class="mb-8 rounded-lg bg-white p-6 shadow-sm dark:bg-zinc-900">
            <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">{{ __('GPA Progress') }}</h3>
            <div class="w-full h-2 bg-gray-200 rounded-full mt-2">
                <div class="h-2 bg-blue-500 rounded-full" style="width: 80%"></div>
            </div>
            <div class="flex justify-between text-sm mt-2">
                <span>Target GPA: 4.0</span>
                <span>Current: 3.85</span>
            </div>
        </div>
        <br>

        <!-- Recent Activity Section -->
        <div class="mb-8 rounded-lg bg-white p-6 shadow-sm dark:bg-zinc-900">
            <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">{{ __('Recent Activities') }}</h3>
            <ul class="space-y-4 mt-4 text-sm text-zinc-900 dark:text-white">
                <li>
                    <span class="font-medium">March 4, 2025</span>: Completed a final project for Data Structures.
                </li>
                <li>
                    <span class="font-medium">February 28, 2025</span>: Received feedback on Computer Science Fundamentals.
                </li>
                <li>
                    <span class="font-medium">February 20, 2025</span>: Attended a seminar on AI in the Digital Age.
                </li>
            </ul>
        </div>
        <br>
    </div>
</x-layouts.app>
