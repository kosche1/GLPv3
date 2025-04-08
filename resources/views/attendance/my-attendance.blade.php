<x-layouts.app>
    <div class="relative flex h-full w-full flex-1 flex-col gap-6 text-gray-100 p-6 border border-emerald-500 rounded-lg overflow-hidden backdrop-blur-sm">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6 relative">
            <div class="flex items-center gap-3">
                <div class="h-8 w-1 bg-gradient-to-b from-emerald-400 to-emerald-600 rounded-full"></div>
                <h1 class="text-2xl font-bold text-white tracking-tight">My Attendance</h1>
            </div>
            <div class="flex items-center gap-3 bg-neutral-800/50 px-4 py-1.5 rounded-full border border-neutral-700/50 shadow-lg backdrop-blur-sm">
                <span class="text-sm text-gray-300 font-medium">{{ date('l, F j, Y') }}</span>
                <div class="h-6 w-6 rounded-full bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center shadow-lg shadow-emerald-500/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-white" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Today's Login Card -->
        <div class="bg-linear-to-br from-neutral-800 to-neutral-900 rounded-xl border border-neutral-700 p-6 overflow-hidden shadow-lg mb-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-white">Today's Attendance</h3>
                <div class="h-10 w-10 rounded-full bg-indigo-500/10 flex items-center justify-center border border-indigo-500/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            @php
                // Debug information
                $today = now()->toDateString();
                $todayRecord = null;

                // Loop through attendance records to find today's record
                foreach ($attendanceHistory as $record) {
                    if ($record->date->format('Y-m-d') === $today) {
                        $todayRecord = $record;
                        break;
                    }
                }
            @endphp

            @if($todayRecord)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-neutral-800/50 rounded-lg p-4 border border-neutral-700/50">
                        <h4 class="text-sm font-medium text-neutral-400 mb-2">First Login</h4>
                        <p class="text-xl font-bold text-white">{{ $todayRecord->first_login_time ?? 'N/A' }}</p>
                    </div>

                    <div class="bg-neutral-800/50 rounded-lg p-4 border border-neutral-700/50">
                        <h4 class="text-sm font-medium text-neutral-400 mb-2">Last Login</h4>
                        <p class="text-xl font-bold text-white">{{ $todayRecord->last_login_time ?? 'N/A' }}</p>
                    </div>

                    <div class="bg-neutral-800/50 rounded-lg p-4 border border-neutral-700/50">
                        <h4 class="text-sm font-medium text-neutral-400 mb-2">Login Count</h4>
                        <p class="text-xl font-bold text-white">
                            <span class="px-2.5 py-1 rounded-full text-sm font-medium {{ $todayRecord->login_count > 1 ? 'bg-blue-500/10 text-blue-400 border border-blue-500/20' : 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' }}">
                                {{ $todayRecord->login_count ?? '0' }}
                            </span>
                        </p>
                    </div>
                </div>
            @else
                <div class="bg-neutral-800/50 rounded-lg p-6 border border-neutral-700/50 text-center">
                    <p class="text-neutral-400">No attendance recorded for today ({{ $today }}).</p>

                    @if(count($attendanceHistory) > 0)
                        <p class="text-xs text-neutral-500 mt-2">Latest record: {{ $attendanceHistory->first()->date->format('Y-m-d') }}</p>
                    @else
                        <p class="text-xs text-neutral-500 mt-2">No attendance records found.</p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Attendance Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
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
                        <div class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-emerald-500" style="width: {{ min(100, $attendancePercentage) }}%"></div>
                    </div>
                </div>
                <p class="text-4xl font-bold text-white">{{ number_format($attendancePercentage, 1) }}%</p>
                <p class="text-sm text-neutral-400 mt-2">Overall attendance</p>
            </div>

            <!-- This Month -->
            <div class="bg-linear-to-br from-neutral-800 to-neutral-900 rounded-xl border border-neutral-700 p-6 overflow-hidden shadow-lg transition-all duration-300 ease-in-out hover:scale-[1.01] hover:border-emerald-500/30 hover:shadow-emerald-900/20">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-white">This Month</h3>
                    <div class="h-10 w-10 rounded-full bg-amber-500/10 flex items-center justify-center border border-amber-500/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="relative pt-1">
                    <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-neutral-700">
                        <div class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-amber-500" style="width: {{ min(100, $monthlyPercentage) }}%"></div>
                    </div>
                </div>
                <p class="text-4xl font-bold text-white">{{ $currentMonthLogins }}/{{ $daysInMonth }}</p>
                <p class="text-sm text-neutral-400 mt-2">{{ number_format($monthlyPercentage, 1) }}% this month</p>
            </div>
        </div>

        <!-- Weekly Attendance -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <!-- This Week -->
            <div class="bg-linear-to-br from-neutral-800 to-neutral-900 rounded-xl border border-neutral-700 p-6 overflow-hidden shadow-lg">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-white">This Week</h3>
                    <div class="h-10 w-10 rounded-full bg-indigo-500/10 flex items-center justify-center border border-indigo-500/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                </div>
                <div class="relative pt-1">
                    <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-neutral-700">
                        <div class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-indigo-500" style="width: {{ min(100, $weeklyPercentage) }}%"></div>
                    </div>
                </div>
                <p class="text-4xl font-bold text-white">{{ $currentWeekLogins }}/7</p>
                <p class="text-sm text-neutral-400 mt-2">{{ number_format($weeklyPercentage, 1) }}% this week</p>
            </div>

            <!-- Last 7 Days -->
            <div class="bg-linear-to-br from-neutral-800 to-neutral-900 rounded-xl border border-neutral-700 p-6 overflow-hidden shadow-lg">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-white">Last 7 Days</h3>
                    <div class="h-10 w-10 rounded-full bg-pink-500/10 flex items-center justify-center border border-pink-500/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-pink-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
                <div class="flex items-end justify-between h-24 mb-4">
                    @foreach($last7Days as $index => $attended)
                        <div class="flex flex-col items-center">
                            @if($attended)
                                <div class="w-8 bg-emerald-500 rounded-t h-full"></div>
                            @else
                                <div class="w-8 bg-neutral-700 rounded-t h-8"></div>
                            @endif
                            <span class="text-xs text-neutral-400 mt-2">{{ $last7DaysLabels[$index] }}</span>
                        </div>
                    @endforeach
                </div>
                <p class="text-sm text-neutral-400 mt-2 text-center">Your attendance for the last 7 days</p>
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
                            <th class="py-3 px-4 text-left text-sm font-semibold text-neutral-400">Login Times</th>
                            <th class="py-3 px-4 text-left text-sm font-semibold text-neutral-400">Count</th>
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
                                <td class="py-4 px-4 text-neutral-300">
                                    @if($record->first_login_time)
                                        <span class="text-emerald-400">First:</span> {{ $record->first_login_time }}
                                        @if($record->last_login_time && $record->first_login_time != $record->last_login_time)
                                            <br><span class="text-amber-400">Last:</span> {{ $record->last_login_time }}
                                        @endif
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="py-4 px-4 text-center">
                                    @if($record->login_count > 1)
                                        <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-blue-500/10 text-blue-400 border border-blue-500/20">
                                            {{ $record->login_count }}
                                        </span>
                                    @else
                                        <span class="text-neutral-400">1</span>
                                    @endif
                                </td>
                                <td class="py-4 px-4 text-neutral-300">{{ $record->notes }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-6 px-4 text-center text-neutral-400">
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