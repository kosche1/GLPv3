<x-layouts.app>
    <div class="p-6 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Course Progress Overview -->
            <div class="col-span-1 md:col-span-2 lg:col-span-3">
                <h2 class="text-2xl font-semibold text-zinc-900 dark:text-white mb-4">Course Progress Overview</h2>
                <div class="bg-white dark:bg-zinc-900 rounded-lg shadow p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="p-4 bg-zinc-50 dark:bg-zinc-800 rounded-lg">
                            <h3 class="text-lg font-medium text-zinc-900 dark:text-white">Current Courses</h3>
                            <p class="text-3xl font-bold text-zinc-900 dark:text-white mt-2">4</p>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">Active Enrollments</p>
                        </div>
                        <div class="p-4 bg-zinc-50 dark:bg-zinc-800 rounded-lg">
                            <h3 class="text-lg font-medium text-zinc-900 dark:text-white">Average Grade</h3>
                            <p class="text-3xl font-bold text-zinc-900 dark:text-white mt-2">85%</p>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">Across All Courses</p>
                        </div>
                        <div class="p-4 bg-zinc-50 dark:bg-zinc-800 rounded-lg">
                            <h3 class="text-lg font-medium text-zinc-900 dark:text-white">Completion Rate</h3>
                            <p class="text-3xl font-bold text-zinc-900 dark:text-white mt-2">75%</p>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">Overall Progress</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active Courses -->
            <div class="col-span-1 md:col-span-2">
                <h2 class="text-2xl font-semibold text-zinc-900 dark:text-white mb-4">Active Courses</h2>
                <div class="space-y-4">
                    <!-- Course Card 1 -->
                    <div class="bg-white dark:bg-zinc-900 rounded-lg shadow p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium text-zinc-900 dark:text-white">Introduction to Computer Science</h3>
                            <span class="px-3 py-1 text-sm rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-100">In Progress</span>
                        </div>
                        <div class="mb-4">
                            <div class="w-full bg-zinc-200 dark:bg-zinc-700 rounded-full h-2.5">
                                <div class="bg-blue-600 h-2.5 rounded-full" style="width: 65%"></div>
                            </div>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-2">65% Complete</p>
                        </div>
                        <div class="flex justify-between text-sm text-zinc-500 dark:text-zinc-400">
                            <span>Next Assignment: Project Milestone 2</span>
                            <span>Due: 7 days</span>
                        </div>
                    </div>
                    <br>

                    <!-- Course Card 2 -->
                    <div class="bg-white dark:bg-zinc-900 rounded-lg shadow p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium text-zinc-900 dark:text-white">Data Structures and Algorithms</h3>
                            <span class="px-3 py-1 text-sm rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-100">Upcoming Quiz</span>
                        </div>
                        <div class="mb-4">
                            <div class="w-full bg-zinc-200 dark:bg-zinc-700 rounded-full h-2.5">
                                <div class="bg-blue-600 h-2.5 rounded-full" style="width: 45%"></div>
                            </div>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-2">45% Complete</p>
                        </div>
                        <div class="flex justify-between text-sm text-zinc-500 dark:text-zinc-400">
                            <span>Next Quiz: Binary Trees</span>
                            <span>Due: 3 days</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Course Calendar -->
            <div class="col-span-1">
                <h2 class="text-2xl font-semibold text-zinc-900 dark:text-white mb-4">Upcoming Deadlines</h2>
                <div class="bg-white dark:bg-zinc-900 rounded-lg shadow p-6">
                    <div class="space-y-4">
                        <div class="flex items-start space-x-4">
                            <div class="min-w-[60px] text-center">
                                <span class="block text-lg font-semibold text-zinc-900 dark:text-white">MAR</span>
                                <span class="block text-2xl font-bold text-zinc-900 dark:text-white">15</span>
                            </div>
                            <div>
                                <h4 class="text-zinc-900 dark:text-white font-medium">Project Milestone 2</h4>
                                <p class="text-sm text-zinc-500 dark:text-zinc-400">Introduction to Computer Science</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4">
                            <div class="min-w-[60px] text-center">
                                <span class="block text-lg font-semibold text-zinc-900 dark:text-white">MAR</span>
                                <span class="block text-2xl font-bold text-zinc-900 dark:text-white">18</span>
                            </div>
                            <div>
                                <h4 class="text-zinc-900 dark:text-white font-medium">Binary Trees Quiz</h4>
                                <p class="text-sm text-zinc-500 dark:text-zinc-400">Data Structures and Algorithms</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>