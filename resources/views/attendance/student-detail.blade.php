<x-layouts.app>
    <div class="relative flex h-full w-full flex-1 flex-col gap-6 text-gray-100 p-6 border border-emerald-500 rounded-lg overflow-hidden backdrop-blur-sm">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6 relative">
            <div class="flex items-center gap-3">
                <div class="h-8 w-1 bg-gradient-to-b from-emerald-400 to-emerald-600 rounded-full"></div>
                <h1 class="text-2xl font-bold text-white tracking-tight">Student Attendance Detail</h1>
            </div>
            <a href="{{ route('attendance.all-students') }}" class="px-4 py-2 rounded-lg bg-neutral-800/50 border border-neutral-700/50 text-white hover:bg-neutral-700/50 transition-colors duration-150 inline-flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to All Students
            </a>
        </div>

        <!-- Student Profile Card -->
        <div class="bg-linear-to-br from-neutral-800 to-neutral-900 rounded-xl border border-neutral-700 p-6 overflow-hidden shadow-lg">
            <div class="flex flex-col sm:flex-row items-start justify-between gap-4">
                <div class="flex items-center space-x-4">
                    <span class="relative flex h-20 w-20 shrink-0 overflow-hidden rounded-xl">
                        @if($student->avatar)
                            <img src="{{ $student->avatar }}" alt="{{ $student->name }}" class="h-full w-full object-cover rounded-xl">
                        @else
                            <span class="flex h-full w-full items-center justify-center rounded-xl bg-emerald-500/10 text-emerald-400 text-2xl font-semibold border border-emerald-500/20">
                                {{ substr($student->name, 0, 1) }}
                            </span>
                        @endif
                    </span>
                    <div>
                        <h2 class="text-2xl font-bold text-white">{{ $student->name }}</h2>
                        <p class="text-neutral-400">{{ $student->email }}</p>
                        <div class="mt-2 flex items-center gap-2">
                            <span class="text-xs font-medium px-2 py-1 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Student</span>
                            <span class="text-xs text-neutral-400">Joined {{ $student->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Attendance Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <!-- Total Login Days -->
            <div class="bg-linear-to-br from-neutral-800 to-neutral-900 rounded-xl border border-neutral-700 p-6 overflow-hidden shadow-lg transition-all duration-300 ease-in-out hover:scale-[1.01] hover:border-emerald-500/30 hover:shadow-emerald-900/20">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-white">Total Login Days</h3>
                    <div class="h-10 w-10 rounded-full bg-emerald-500/10 flex items-center justify-center border border-emerald-500/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
                <p class="text-4xl font-bold text-white">{{ $totalLoginDays }}</p>
                <p class="text-sm text-neutral-400 mt-2">Total days logged in</p>
            </div>

            <!-- Current Streak -->
            <div class="bg-linear-to-br from-neutral-800 to-neutral-900 rounded-xl border border-neutral-700 p-6 overflow-hidden shadow-lg transition-all duration-300 ease-in-out hover:scale-[1.01] hover:border-emerald-500/30 hover:shadow-emerald-900/20">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-white">Current Streak</h3>
                    <div class="h-10 w-10 rounded-full bg-blue-500/10 flex items-center justify-center border border-blue-500/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                </div>
                <p class="text-4xl font-bold text-white">{{ $currentStreak }}</p>
                <p class="text-sm text-neutral-400 mt-2">Consecutive days</p>
            </div>

            <!-- Attendance Rate -->
            <div class="bg-linear-to-br from-neutral-800 to-neutral-900 rounded-xl border border-neutral-700 p-6 overflow-hidden shadow-lg transition-all duration-300 ease-in-out hover:scale-[1.01] hover:border-emerald-500/30 hover:shadow-emerald-900/20">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-white">Attendance Rate</h3>
                    <div class="h-10 w-10 rounded-full bg-purple-500/10 flex items-center justify-center border border-purple-500/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                </div>
                <div class="relative pt-1">
                    <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-neutral-700">
                        <div style="width:{{ min(100, $attendancePercentage) }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-emerald-500"></div>
                    </div>
                </div>
                <p class="text-4xl font-bold text-white">{{ number_format($attendancePercentage, 1) }}%</p>
                <p class="text-sm text-neutral-400 mt-2">Overall attendance</p>
            </div>
        </div>

        <!-- Attendance History -->
        <div class="bg-linear-to-br from-neutral-800 to-neutral-900 rounded-xl border border-neutral-700 p-6 overflow-hidden shadow-lg">
            <div class="flex items-center gap-3 mb-6">
                <div class="h-6 w-1 bg-gradient-to-b from-emerald-400 to-emerald-600 rounded-full"></div>
                <h2 class="text-xl font-bold text-white">Attendance History</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="border-b border-neutral-700">
                            <th class="py-3 px-4 text-left text-sm font-semibold text-neutral-400">Date</th>
                            <th class="py-3 px-4 text-left text-sm font-semibold text-neutral-400">Status</th>
                            <th class="py-3 px-4 text-left text-sm font-semibold text-neutral-400">Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($attendanceHistory as $record)
                            <tr class="border-b border-neutral-700/50 hover:bg-neutral-800/50 transition-colors duration-150">
                                <td class="py-4 px-4 text-white">{{ $record->date->format('M d, Y') }}</td>
                                <td class="py-4 px-4">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-medium
                                        {{ $record->status === 'present' ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' :
                                           ($record->status === 'absent' ? 'bg-red-500/10 text-red-400 border border-red-500/20' :
                                           'bg-amber-500/10 text-amber-400 border border-amber-500/20') }}">
                                        {{ ucfirst($record->status) }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-neutral-300">{{ $record->notes }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-6 px-4 text-center text-neutral-400">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-neutral-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>No attendance records found.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.app>
