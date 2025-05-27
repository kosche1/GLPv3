<div class="flex h-full w-full flex-1 flex-col gap-6 text-gray-100 p-6 border border-emerald-500 rounded-lg">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
            <h1 class="text-2xl font-bold text-white">{{ __('Grades') }}</h1>
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
                <input type="text" placeholder="Search courses..." wire:model.live="searchQuery"
                    class="w-full md:min-w-[250px] rounded-lg border border-neutral-700 bg-neutral-800 pl-10 pr-4 py-2 text-sm text-white placeholder-neutral-400 focus:border-emerald-500/30 focus:outline-hidden transition-all duration-300 hover:border-neutral-600">
            </div>

            <!-- Filter Dropdown -->
            <div>
                <select class="w-full md:w-auto rounded-lg border border-neutral-700 bg-neutral-800 px-4 py-2 text-sm text-white focus:border-emerald-500/30 focus:outline-hidden transition-all duration-300 hover:border-neutral-600"
                        wire:model.live="selectedSemester"
                        wire:change="setSemester($event.target.value)">
                        <option value="current">2nd Semester</option>
                        <option value="previous">1st Semester</option>
                        <option value="all">All Semesters</option>
                </select>
            </div>

            <!-- Sort Dropdown -->
            <div>
                <select class="w-full md:w-auto rounded-lg border border-neutral-700 bg-neutral-800 px-4 py-2 text-sm text-white focus:border-emerald-500/30 focus:outline-hidden transition-all duration-300 hover:border-neutral-600"
                        wire:model.live="sortField">
                        <option value="name">Sort by Course Name</option>
                        <option value="code">Sort by Course Code</option>
                        <option value="credits">Sort by Credits</option>
                        <option value="grade">Sort by Grade</option>
                        <option value="status">Sort by Status</option>
                </select>
            </div>
        </div>
    </div>

    <!-- GPA Summary Cards -->
    <div class="grid gap-6 md:grid-cols-3">
        <div class="flex flex-col justify-between p-6 rounded-xl border border-neutral-700 bg-linear-to-br from-neutral-800 to-neutral-900 transition-all duration-300 ease-in-out hover:scale-[1.02] hover:shadow-lg hover:shadow-emerald-900/20 hover:border-emerald-500/30">
            <div class="space-y-3">
                <div class="flex items-center gap-2">
                    <div class="p-2 rounded-lg bg-emerald-500/10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h3 class="text-sm font-medium text-neutral-300">{{ __('Current GPA') }}</h3>
                </div>
                <p class="text-3xl font-semibold text-white">{{ $currentGPA }}</p>
                <span class="text-xs px-2 py-1 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 inline-flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                    </svg>
                    +{{ $gpaChange }} from last semester
                </span>
            </div>
        </div>
        <div class="flex flex-col justify-between p-6 rounded-xl border border-neutral-700 bg-linear-to-br from-neutral-800 to-neutral-900 transition-all duration-300 ease-in-out hover:scale-[1.02] hover:shadow-lg hover:shadow-emerald-900/20 hover:border-emerald-500/30">
            <div class="space-y-3">
                <div class="flex items-center gap-2">
                    <div class="p-2 rounded-lg bg-blue-500/10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                        </svg>
                    </div>
                    <h3 class="text-sm font-medium text-neutral-300">{{ __('Cumulative GPA') }}</h3>
                </div>
                <p class="text-3xl font-semibold text-white">{{ $cumulativeGPA }}</p>
                <span class="text-xs px-2 py-1 rounded-full bg-blue-500/10 text-blue-400 border border-blue-500/20 inline-flex items-center">
                    Top 10% of class
                </span>
            </div>
        </div>
        <div class="flex flex-col justify-between p-6 rounded-xl border border-neutral-700 bg-linear-to-br from-neutral-800 to-neutral-900 transition-all duration-300 ease-in-out hover:scale-[1.02] hover:shadow-lg hover:shadow-emerald-900/20 hover:border-emerald-500/30">
            <div class="space-y-3">
                <div class="flex items-center gap-2">
                    <div class="p-2 rounded-lg bg-purple-500/10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="M12 14l9-5-9-5-9 5 9 5z" />
                            <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                        </svg>
                    </div>
                    <h3 class="text-sm font-medium text-neutral-300">{{ __('Credits Completed') }}</h3>
                </div>
                <p class="text-3xl font-semibold text-white">{{ $creditsCompleted }}</p>
                <span class="text-xs px-2 py-1 rounded-full bg-purple-500/10 text-purple-400 border border-purple-500/20 inline-flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                    {{ $completionPercentage }}% toward graduation
                </span>
            </div>
        </div>
    </div>

    <!-- Course Grades Table -->
    <div class="rounded-xl border border-neutral-700 bg-linear-to-br from-neutral-800 to-neutral-900 transition-all duration-300 ease-in-out hover:border-emerald-500/30 hover:shadow-lg hover:shadow-emerald-900/20">
        <div class="border-b border-neutral-700 px-6 py-4 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-white flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                {{ __('Current Semester Grades') }}
            </h2>
            <span class="text-sm text-neutral-400">{{ $currentSemester }}</span>
        </div>
        <div class="overflow-x-auto p-1">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-neutral-700 text-sm">
                        <th class="whitespace-nowrap px-6 py-4 text-left font-medium text-neutral-400">
                            <button wire:click="sortBy('name')" class="flex items-center gap-1 hover:text-white transition-colors">
                                {{ __('Course') }}
                                @if($sortField === 'name')
                                    @if($sortDirection === 'asc')
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    @endif
                                @endif
                            </button>
                        </th>
                        <th class="whitespace-nowrap px-6 py-4 text-left font-medium text-neutral-400">
                            <button wire:click="sortBy('credits')" class="flex items-center gap-1 hover:text-white transition-colors">
                                {{ __('Credits') }}
                                @if($sortField === 'credits')
                                    @if($sortDirection === 'asc')
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    @endif
                                @endif
                            </button>
                        </th>
                        <th class="whitespace-nowrap px-6 py-4 text-left font-medium text-neutral-400">
                            <button wire:click="sortBy('grade')" class="flex items-center gap-1 hover:text-white transition-colors">
                                {{ __('Grade') }}
                                @if($sortField === 'grade')
                                    @if($sortDirection === 'asc')
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    @endif
                                @endif
                            </button>
                        </th>
                        <th class="whitespace-nowrap px-6 py-4 text-left font-medium text-neutral-400">
                            <button wire:click="sortBy('status')" class="flex items-center gap-1 hover:text-white transition-colors">
                                {{ __('Status') }}
                                @if($sortField === 'status')
                                    @if($sortDirection === 'asc')
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    @endif
                                @endif
                            </button>
                        </th>
                        <th class="whitespace-nowrap px-6 py-4 text-left font-medium text-neutral-400">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-700">
                    @forelse($courses as $course)
                        <tr class="text-sm transition-colors hover:bg-neutral-700/50">
                            <td class="whitespace-nowrap px-6 py-4 text-white">{{ $course['name'] }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-neutral-400">{{ $course['credits'] }}</td>
                            <td class="whitespace-nowrap px-6 py-4">
                                @if($course['grade'] === 'No Grade')
                                    <span class="text-neutral-400 font-medium">{{ $course['grade'] }}</span>
                                @elseif(in_array($course['grade'], ['A+', 'A', 'A-']))
                                    <span class="text-emerald-400 font-medium">{{ $course['grade'] }}</span>
                                @elseif(in_array($course['grade'], ['B+', 'B', 'B-']))
                                    <span class="text-blue-400 font-medium">{{ $course['grade'] }}</span>
                                @elseif(in_array($course['grade'], ['C+', 'C', 'C-']))
                                    <span class="text-yellow-400 font-medium">{{ $course['grade'] }}</span>
                                @else
                                    <span class="text-red-400 font-medium">{{ $course['grade'] }}</span>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                @if($course['status'] === 'Completed')
                                    <span class="inline-flex rounded-full bg-emerald-500/10 border border-emerald-500/20 px-3 py-1 text-xs font-medium text-emerald-400">Completed</span>
                                @elseif($course['status'] === 'In Progress')
                                    <span class="inline-flex rounded-full bg-amber-500/10 border border-amber-500/20 px-3 py-1 text-xs font-medium text-amber-400">In Progress</span>
                                @else
                                    <span class="inline-flex rounded-full bg-neutral-500/10 border border-neutral-500/20 px-3 py-1 text-xs font-medium text-neutral-400">Not Started</span>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <button class="text-neutral-400 hover:text-white transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-neutral-400">No courses found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- GPA Progress Bar -->
    <div class="rounded-xl border border-neutral-700 bg-linear-to-br from-neutral-800 to-neutral-900 p-6 transition-all duration-300 ease-in-out hover:border-emerald-500/30 hover:shadow-lg hover:shadow-emerald-900/20">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                {{ __('GPA Progress') }}
            </h3>
            <span class="text-sm px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">{{ $gpaProgressPercentage }}% to Target</span>
        </div>
        <div class="p-4 rounded-lg bg-neutral-800/50 border border-neutral-700">
            <div class="w-full h-3 bg-neutral-700 rounded-full">
                <div class="h-3 bg-gradient-to-r from-emerald-500 to-emerald-400 rounded-full" style="width: {{ $gpaProgressPercentage }}%"></div>
            </div>
            <div class="flex justify-between text-sm mt-2">
                <span class="text-neutral-400">Target GPA: {{ $targetGPA }}</span>
                <span class="text-emerald-400">Current: {{ $currentGPA }}</span>
            </div>
        </div>
    </div>
</div>
