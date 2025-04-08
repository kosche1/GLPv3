<x-layouts.app>
    <div class="relative flex h-full w-full flex-1 flex-col gap-6 text-gray-100 p-6 border border-emerald-500 rounded-lg overflow-hidden backdrop-blur-sm">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6 relative">
            <div class="flex items-center gap-3">
                <div class="h-8 w-1 bg-gradient-to-b from-emerald-400 to-emerald-600 rounded-full"></div>
                <h1 class="text-2xl font-bold text-white tracking-tight">Student Attendance</h1>
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

        <!-- Student Attendance Table -->
        <div class="bg-linear-to-br from-neutral-800 to-neutral-900 rounded-xl border border-neutral-700 p-6 overflow-hidden shadow-lg">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <div class="h-6 w-1 bg-gradient-to-b from-emerald-400 to-emerald-600 rounded-full"></div>
                    <h2 class="text-xl font-bold text-white">All Students</h2>
                </div>
                <div class="flex items-center gap-2">
                    <div class="relative">
                        <input type="text" placeholder="Search students..." class="w-64 px-4 py-2 rounded-lg bg-neutral-800/50 border border-neutral-700/50 text-white placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/50">
                        <div class="absolute right-3 top-2.5 text-neutral-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="border-b border-neutral-700">
                            <th class="py-3 px-4 text-left text-sm font-semibold text-neutral-400">Student</th>
                            <th class="py-3 px-4 text-left text-sm font-semibold text-neutral-400">Email</th>
                            <th class="py-3 px-4 text-left text-sm font-semibold text-neutral-400">Total Logins</th>
                            <th class="py-3 px-4 text-left text-sm font-semibold text-neutral-400">Current Streak</th>
                            <th class="py-3 px-4 text-left text-sm font-semibold text-neutral-400">Attendance %</th>
                            <th class="py-3 px-4 text-left text-sm font-semibold text-neutral-400">Last Login</th>
                            <th class="py-3 px-4 text-left text-sm font-semibold text-neutral-400">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($studentsData as $student)
                            <tr class="border-b border-neutral-700/50 hover:bg-neutral-800/50 transition-colors duration-150">
                                <td class="py-4 px-4 text-white font-medium">{{ $student['name'] }}</td>
                                <td class="py-4 px-4 text-neutral-300">{{ $student['email'] }}</td>
                                <td class="py-4 px-4 text-white">{{ $student['total_logins'] }}</td>
                                <td class="py-4 px-4">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-blue-500/10 text-blue-400 border border-blue-500/20">
                                        {{ $student['current_streak'] }} days
                                    </span>
                                </td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-16 h-2 bg-neutral-700 rounded-full overflow-hidden">
                                            <div class="h-full bg-emerald-500 rounded-full" style="width: {{ min(100, $student['attendance_percentage']) }}%"></div>
                                        </div>
                                        <span class="text-white">{{ number_format($student['attendance_percentage'], 1) }}%</span>
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-neutral-300">
                                    @if ($student['last_login'] === 'Never')
                                        <span class="text-neutral-500">Never</span>
                                    @else
                                        {{ \Carbon\Carbon::parse($student['last_login'])->format('M d, Y') }}
                                    @endif
                                </td>
                                <td class="py-4 px-4">
                                    <a href="{{ route('attendance.student-detail', $student['id']) }}"
                                       class="px-3 py-1.5 rounded-lg bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 hover:bg-emerald-500/20 transition-colors duration-150 inline-flex items-center gap-1.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        Details
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-6 px-4 text-center text-neutral-400">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-neutral-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                        <span>No students found.</span>
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
