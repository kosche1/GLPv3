<x-layouts.app>
   
    <div class="relative flex h-full w-full flex-1 flex-col gap-6 text-gray-100 p-6 border border-emerald-500 rounded-lg overflow-hidden backdrop-blur-sm">
        <!-- Optimized Background Elements - Single Element -->
        <!-- <div class="absolute inset-0 -z-10 bg-[radial-gradient(ellipse_at_top_right,rgba(16,185,129,0.05),transparent_70%)]" style="background-size: 24px 24px;"></div> -->
        <!-- Header -->
        <div class="flex justify-between items-center mb-6 relative">
            <div class="flex items-center gap-3">
                <div class="h-8 w-1 bg-gradient-to-b from-emerald-400 to-emerald-600 rounded-full"></div>
                <h1 class="text-2xl font-bold text-white tracking-tight">GLP - Gamified Dashboard</h1>
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

        @php
            $user = auth()->user();
            $currentLevel = $user->getLevel();
            $currentPoints = $user->getPoints();

            // --- XP Progress Calculation ---
            $levels = \LevelUp\Experience\Models\Level::orderBy('level')->get();
            $previousLevelThreshold = $levels->where('level', '<', $currentLevel)->sortByDesc('level')->first()?->next_level_experience ?? 0;
            $pointsForNextLevel = $levels->firstWhere('level', $currentLevel + 1)?->next_level_experience ?? $currentPoints;

            $xpInCurrentLevel = $currentPoints - $previousLevelThreshold;
            $xpNeededForLevel = $pointsForNextLevel - $previousLevelThreshold;
            $progressPercentage = ($xpNeededForLevel > 0) ? round(($xpInCurrentLevel / $xpNeededForLevel) * 100) : 100;
            $xpToNextLevel = max(0, $pointsForNextLevel - $currentPoints);

            // --- Stats Data ---
            $achievement = \App\Models\StudentAchievement::getLatestScore($user->id);
            $score = $achievement ? number_format($achievement->score, 2) : '0.00';
            $scoreChange = $achievement ? $achievement->score_change : 0;

            $attendancePercentage = \App\Models\StudentAttendance::getAttendancePercentage($user->id);
            $attendanceChange = \App\Models\StudentAttendance::getAttendanceChange($user->id);

            $credits = \App\Models\StudentCredit::getCreditsInfo($user->id);
            $creditsCompleted = $credits ? $credits->credits_completed : 0;
            $creditsRequired = $credits ? ($credits->credits_required ?: 120) : 120;
            $completionPercentage = $credits ? $credits->completion_percentage : 0;

            // --- Leaderboard Data ---
            $leaderboardData = collect([
                (object)['user' => (object)['id' => 1, 'name' => 'John Doe'], 'experience' => (object)['level_id' => 5, 'experience_points' => 1500]],
                (object)['user' => (object)['id' => 2, 'name' => 'Jane Smith'], 'experience' => (object)['level_id' => 4, 'experience_points' => 1300]],
                (object)['user' => (object)['id' => $user->id, 'name' => $user->name], 'experience' => (object)['level_id' => $currentLevel, 'experience_points' => $currentPoints]],
                (object)['user' => (object)['id' => 3, 'name' => 'Alex Johnson'], 'experience' => (object)['level_id' => 3, 'experience_points' => 1100]],
                (object)['user' => (object)['id' => 4, 'name' => 'Sam Wilson'], 'experience' => (object)['level_id' => 3, 'experience_points' => 1050]],
                (object)['user' => (object)['id' => 5, 'name' => 'Chris Evans'], 'experience' => (object)['level_id' => 2, 'experience_points' => 900]],
            ])->sortByDesc('experience.experience_points')->values();
            $userRank = $leaderboardData->search(fn($item) => $item->user->id === $user->id);
            $userRank = ($userRank !== false) ? $userRank + 1 : null;

            // --- Achievements Data ---
            if (!isset($userAchievements)) {
                $userAchievements = $user->getUserAchievements();
            }

            // --- Challenges Data ---
            $activeChallenges = $user->getActiveChallenges()->take(3);
        @endphp

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <!-- Left Column (Profile + Stats) -->
            <div class="lg:col-span-8 space-y-6">
                <!-- Profile Card with Stats -->
                <div class="rounded-2xl border border-neutral-800 bg-neutral-800/50 backdrop-blur-sm shadow-xl overflow-hidden relative group hover:border-neutral-700 transition-all duration-300">
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(16,185,129,0.15),transparent_70%)] opacity-70 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-emerald-500/0 via-emerald-500/10 to-emerald-500/0 rounded-xl opacity-0 group-hover:opacity-100 blur-xl transition-opacity duration-500 group-hover:duration-200"></div>
                    <div class="relative p-6 z-10">
                        <!-- Decorative Background Elements -->
                        <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-bl from-emerald-500/10 to-transparent rounded-full blur-2xl -z-10"></div>
                        <div class="absolute bottom-0 left-0 w-48 h-48 bg-gradient-to-tr from-purple-500/10 to-transparent rounded-full blur-2xl -z-10"></div>
                        <div class="absolute inset-0 -z-10 bg-[linear-gradient(to_right,rgba(16,185,129,0.01)_1px,transparent_1px),linear-gradient(to_bottom,rgba(16,185,129,0.01)_1px,transparent_1px)] bg-[size:20px_20px] opacity-20"></div>

                        <div class="flex flex-col md:flex-row md:items-center gap-6">
                            <!-- Avatar & Welcome -->
                            <div class="flex items-center gap-4">
                                <div class="relative">
                                    <div class="relative w-20 h-20 rounded-2xl bg-gradient-to-br from-emerald-500 to-green-600 flex items-center justify-center text-2xl font-bold text-white shadow-lg overflow-hidden group-hover:scale-105 transition-transform duration-300">
                                        <div class="absolute inset-0 bg-[radial-gradient(circle_at_60%_35%,rgba(255,255,255,0.25),transparent_50%)] opacity-70"></div>
                                        <div class="relative z-10">{{ $user->initials() }}</div>
                                        <div class="absolute inset-0 bg-[linear-gradient(45deg,rgba(255,255,255,0)_25%,rgba(255,255,255,0.1)_50%,rgba(255,255,255,0)_75%)] bg-[length:250%_250%] animate-pulse-slow opacity-50"></div>
                                    </div>
                                    <div class="absolute -bottom-1 -right-1 bg-neutral-800 rounded-full p-1 shadow-lg">
                                        <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 text-white text-xs font-bold rounded-full w-6 h-6 flex items-center justify-center shadow-lg shadow-emerald-500/20">
                                            {{ $currentLevel }}
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <h2 class="text-2xl font-bold text-white tracking-tight">Welcome back, <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-teal-400">{{ explode(' ', $user->name)[0] }}</span>!</h2>
                                    <p class="text-gray-400">You're making great progress</p>
                                </div>
                            </div>

                            <!-- Stats Cards -->
                            <div class="grid grid-cols-3 gap-4 md:ml-auto">
                                <div class="rounded-xl bg-neutral-800/80 border border-neutral-700 p-3 flex flex-col items-center justify-center relative group hover:border-yellow-500/30 hover:bg-neutral-800/90 transition-all duration-300 overflow-hidden">
                                    <div class="absolute inset-0 bg-gradient-to-br from-yellow-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    <div class="absolute -inset-1 bg-yellow-400/10 blur-xl opacity-0 group-hover:opacity-70 transition-opacity duration-300 rounded-full"></div>
                                    <div class="text-yellow-400 mb-1 relative z-10">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    </div>
                                    <span class="text-xs text-gray-400 relative z-10">Score</span>
                                    <span class="text-white font-bold relative z-10 text-lg">{{ $score }}</span>
                                    <span class="text-xs {{ $scoreChange >= 0 ? 'text-green-400' : 'text-red-400' }} relative z-10">
                                        {{ $scoreChange >= 0 ? '+' : '' }}{{ number_format($scoreChange, 2) }}
                                    </span>
                                </div>
                                <div class="rounded-xl bg-neutral-800/80 border border-neutral-700 p-3 flex flex-col items-center justify-center relative group hover:border-blue-500/30 hover:bg-neutral-800/90 transition-all duration-300 overflow-hidden">
                                    <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    <div class="absolute -inset-1 bg-blue-400/10 blur-xl opacity-0 group-hover:opacity-70 transition-opacity duration-300 rounded-full"></div>
                                    <div class="text-blue-400 mb-1 relative z-10">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <span class="text-xs text-gray-400 relative z-10">Attendance</span>
                                    <span class="text-white font-bold relative z-10 text-lg">{{ $attendancePercentage }}%</span>
                                    <span class="text-xs {{ $attendanceChange >= 0 ? 'text-green-400' : 'text-red-400' }} relative z-10">
                                        {{ $attendanceChange >= 0 ? '+' : '' }}{{ $attendanceChange }}%
                                    </span>
                                </div>
                                <div class="rounded-xl bg-neutral-800/80 border border-neutral-700 p-3 flex flex-col items-center justify-center relative group hover:border-purple-500/30 hover:bg-neutral-800/90 transition-all duration-300 overflow-hidden">
                                    <div class="absolute inset-0 bg-gradient-to-br from-purple-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    <div class="absolute -inset-1 bg-purple-400/10 blur-xl opacity-0 group-hover:opacity-70 transition-opacity duration-300 rounded-full"></div>
                                    <div class="text-purple-400 mb-1 relative z-10">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 16c1.255 0 2.443-.29 3.5-.804V4.804zM14.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 0114.5 16c1.255 0 2.443-.29 3.5-.804v-10A7.968 7.968 0 0014.5 4z" />
                                        </svg>
                                    </div>
                                    <span class="text-xs text-gray-400 relative z-10">Credits</span>
                                    <span class="text-white font-bold relative z-10 text-lg">{{ $completionPercentage }}%</span>
                                    <span class="text-xs text-gray-400 relative z-10">{{ $creditsCompleted }}/{{ $creditsRequired }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- XP Progress Bar -->
                        <div class="mt-6 relative">
                            <div class="flex justify-between items-end mb-2">
                                <div class="flex items-center gap-2">
                                    <div class="relative">
                                        <div class="absolute -inset-1 bg-emerald-500/20 rounded-full blur-sm animate-pulse-slow"></div>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400 relative" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <span class="text-sm font-medium text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-teal-400">Level {{ $currentLevel }} Progress</span>
                                </div>
                                <span class="text-xs text-gray-300 font-mono bg-neutral-800/80 px-2 py-0.5 rounded-full">{{ number_format($currentPoints) }} / {{ number_format($pointsForNextLevel) }} XP</span>
                            </div>
                            <div class="w-full h-3 bg-neutral-800/80 rounded-full overflow-hidden border border-neutral-700/50">
                                <div class="h-full bg-gradient-to-r from-emerald-500 to-teal-400 rounded-full" style="width: {{ $progressPercentage }}%"></div>
                            </div>
                            <div class="flex justify-between mt-1">
                                <span class="text-xs text-gray-500">Level {{ $currentLevel }}</span>
                                <span class="text-xs text-gray-400">{{ number_format($xpToNextLevel) }} XP to Level {{ $currentLevel + 1 }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Activity Graph -->
                <div class="rounded-2xl border border-neutral-800 bg-neutral-800/50 backdrop-blur-sm shadow-xl overflow-hidden relative group hover:border-neutral-700 transition-all duration-300" style="min-height: 350px; height: 400px;">
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(16,185,129,0.15),transparent_70%)] opacity-70 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-emerald-500/0 via-emerald-500/5 to-emerald-500/0 rounded-xl opacity-0 group-hover:opacity-100 blur-xl transition-opacity duration-500 group-hover:duration-200"></div>
                    <div class="absolute inset-0 -z-10 bg-[linear-gradient(to_right,rgba(16,185,129,0.01)_1px,transparent_1px),linear-gradient(to_bottom,rgba(16,185,129,0.01)_1px,transparent_1px)] bg-[size:20px_20px] opacity-10"></div>
                    <div class="p-6 h-full relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                                <div class="relative">
                                    <div class="absolute -inset-1 bg-emerald-500/20 rounded-full blur-sm opacity-70"></div>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400 relative" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 0l-2 2a1 1 0 101.414 1.414L8 10.414l1.293 1.293a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-teal-400">Your Activity</span>
                            </h3>
                            <div class="flex items-center gap-2 bg-neutral-800/80 px-3 py-1 rounded-full border border-neutral-700/50 shadow-inner">
                                <div class="text-xs text-gray-400">Less</div>
                                <div class="flex items-center gap-1">
                                    <div class="h-3 w-3 rounded-sm bg-neutral-700 shadow-inner" title="No activity"></div>
                                    <div class="h-3 w-3 rounded-sm bg-emerald-900 shadow-inner" title="Low activity"></div>
                                    <div class="h-3 w-3 rounded-sm bg-emerald-700 shadow-inner" title="Medium activity"></div>
                                    <div class="h-3 w-3 rounded-sm bg-emerald-500 shadow-inner" title="High activity"></div>
                                    <div class="h-3 w-3 rounded-sm bg-emerald-300 shadow-inner" title="Very high activity"></div>
                                </div>
                                <div class="text-xs text-gray-400">More</div>
                            </div>
                        </div>
                        <div class="overflow-x-auto h-[calc(100%-3rem)] bg-neutral-800/30 rounded-xl border border-neutral-700/30 p-3">
                            <div class="contribution-calendar min-w-[700px] h-full">
                                <div id="contributionGraph" class="mt-2 w-full h-[calc(100%-0.5rem)]"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Achievements -->
                <div class="rounded-2xl border border-neutral-800 bg-neutral-800/50 backdrop-blur-sm shadow-xl overflow-hidden relative group hover:border-neutral-700 transition-all duration-300">
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(168,85,247,0.15),transparent_70%)] opacity-70 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-purple-500/0 via-purple-500/5 to-purple-500/0 rounded-xl opacity-0 group-hover:opacity-100 blur-xl transition-opacity duration-500 group-hover:duration-200"></div>
                    <div class="p-6 relative z-10">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                                <div class="relative">
                                    <div class="absolute -inset-1 bg-purple-500/20 rounded-full blur-sm opacity-70"></div>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-400 relative" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" />
                                    </svg>
                                </div>
                                <span class="text-white bg-clip-text bg-gradient-to-r from-purple-400 to-indigo-400">Achievements</span>
                            </h3>
                            <a href="#" class="text-sm text-emerald-400 hover:text-emerald-300 transition-colors flex items-center gap-1 bg-neutral-800/80 px-3 py-1 rounded-full border border-neutral-700/50 hover:bg-neutral-800 hover:border-purple-500/30 transition-all duration-300">
                                View All
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                        @if(isset($userAchievements) && $userAchievements->isNotEmpty())
                            <div class="grid grid-cols-3 gap-3">
                                @foreach($userAchievements as $achievement)
                                    <div class="rounded-xl bg-neutral-700/20 border border-neutral-700/50 p-2 flex flex-col items-center justify-between hover:bg-neutral-700/30 hover:border-purple-500/30 transition-all transform hover:scale-105 group relative overflow-hidden w-20 h-28 mx-auto" title="{{ $achievement->description }}">
                                        <div class="absolute inset-0 bg-gradient-to-br from-purple-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                        <div class="absolute -inset-1 bg-purple-400/5 blur-xl opacity-0 group-hover:opacity-70 transition-opacity duration-300 rounded-full"></div>
                                        <div class="relative z-10">
                                            @if($achievement->image)
                                                <div class="relative mb-0.5 mx-auto">
                                                    <div class="absolute -inset-1 bg-purple-500/10 rounded-full blur-sm opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                                    <img src="{{ asset($achievement->image) }}" alt="{{ $achievement->name }}" class="h-7 w-7 object-contain relative mx-auto">
                                                </div>
                                            @else
                                                <div class="relative mb-0.5 mx-auto">
                                                    <div class="absolute -inset-1 bg-purple-500/10 rounded-full blur-sm opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                                    <div class="h-7 w-7 rounded-full bg-gradient-to-br from-purple-500/20 to-indigo-500/20 border border-purple-500/30 flex items-center justify-center relative overflow-hidden group-hover:border-purple-500/50 transition-colors duration-300">
                                                        <div class="absolute inset-0 bg-[radial-gradient(circle_at_60%_35%,rgba(255,255,255,0.2),transparent_50%)] opacity-0 group-hover:opacity-70 transition-opacity duration-300"></div>
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-400 relative z-10" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="mt-2 w-full pb-1">
                                                <p class="text-[10px] text-gray-200 font-medium text-center leading-tight group-hover:text-purple-300 transition-colors duration-300 mx-auto px-1">{{ $achievement->name }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- <div class="mt-3 text-right">
                                <span class="text-xs text-gray-400">{{ $userAchievements->count() }} achievements earned</span>
                            </div> -->
                        @else
                            <div class="flex flex-col items-center justify-center p-6 bg-neutral-800/30 rounded-xl border border-neutral-700/50">
                                <div class="h-16 w-16 rounded-full bg-purple-500/10 flex items-center justify-center mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" />
                                    </svg>
                                </div>
                                <p class="text-gray-300 text-center mb-1">No achievements earned yet</p>
                                <p class="text-sm text-gray-500 text-center">Keep learning to earn achievements!</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Active Challenges -->
                <div class="rounded-2xl border border-neutral-800 bg-neutral-800/50 backdrop-blur-sm shadow-xl overflow-hidden relative group hover:border-neutral-700 transition-all duration-300">
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(249,115,22,0.1),transparent_70%)] opacity-70 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-orange-500/0 via-orange-500/5 to-orange-500/0 rounded-xl opacity-0 group-hover:opacity-100 blur-xl transition-opacity duration-500 group-hover:duration-200"></div>
                    <div class="p-6 relative z-10">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                                <div class="relative">
                                    <div class="absolute -inset-1 bg-orange-500/20 rounded-full blur-sm opacity-70"></div>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-orange-400 relative" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd" />
                                        <path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0010 15c-2.796 0-5.487-.46-8-1.308z" />
                                    </svg>
                                </div>
                                <span class="text-white bg-clip-text bg-gradient-to-r from-orange-400 to-yellow-400">Active Challenges</span>
                            </h3>
                            <a href="{{ route('learning') }}" class="text-sm text-emerald-400 hover:text-emerald-300 transition-colors flex items-center gap-1 bg-neutral-800/80 px-3 py-1 rounded-full border border-neutral-700/50 hover:bg-neutral-800 hover:border-emerald-500/30 transition-all duration-300">
                                View All
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                        @if($activeChallenges->isNotEmpty())
                            <div class="space-y-4">
                                @foreach($activeChallenges as $challenge)
                                    <div class="rounded-xl bg-neutral-700/20 border border-neutral-700/50 p-4 hover:bg-neutral-700/30 hover:border-orange-500/30 transition-colors duration-200 group relative overflow-hidden">
                                        <div class="relative z-10">
                                            <div class="flex justify-between items-center mb-2">
                                                <span class="font-medium text-white">{{ $challenge->name }}</span>
                                                <span class="text-xs font-semibold px-2 py-1 rounded-full {{ ($challenge->pivot->progress ?? 0) >= 100 ? 'bg-green-500/20 text-green-400 group-hover:bg-green-500/30' : 'bg-orange-500/20 text-orange-400 group-hover:bg-orange-500/30' }} transition-colors duration-300">
                                                    {{ $challenge->pivot->progress ?? 0 }}% Complete
                                                </span>
                                            </div>
                                            <div class="w-full bg-neutral-800/80 rounded-full h-2 overflow-hidden border border-neutral-700/50">
                                                <div class="bg-gradient-to-r from-orange-500 to-yellow-500 h-2 rounded-full" style="width: {{ $challenge->pivot->progress ?? 0 }}%"></div>
                                            </div>
                                            @if($challenge->description)
                                                <p class="text-xs text-gray-400 mt-2">{{ Str::limit($challenge->description, 100) }}</p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="rounded-xl bg-neutral-700/20 border border-neutral-700/50 p-6 text-center">
                                <p class="text-gray-400 text-sm mb-3">There are {{ \App\Models\Challenge::count() }} total challenges available!</p>
                                <a href="{{ route('learning') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 rounded-lg text-white transition-colors shadow-lg shadow-emerald-900/30">
                                    Explore Challenges
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Column (Leaderboard + Achievements) -->
            <div class="lg:col-span-4 space-y-6">
                <!-- Main Action Button -->
                <div class="rounded-2xl border border-emerald-500/50 bg-emerald-500/10 backdrop-blur-sm shadow-xl overflow-hidden relative">
                    <div class="absolute inset-0 bg-[linear-gradient(to_right,rgba(16,185,129,0.01)_1px,transparent_1px),linear-gradient(to_bottom,rgba(16,185,129,0.01)_1px,transparent_1px)] bg-[size:16px_16px] opacity-20"></div>
                    <a href="{{ route('learning') }}" class="block p-6 text-center relative group">
                        <!-- Background effect -->
                        <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/20 to-teal-500/10 opacity-50 group-hover:opacity-75 transition-opacity duration-300"></div>
                        <div class="absolute inset-0 bg-[radial-gradient(circle,_rgba(16,185,129,0.3)_0%,_rgba(0,0,0,0)_70%)] opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <div class="absolute -inset-1 bg-emerald-400/10 blur-xl opacity-0 group-hover:opacity-70 transition-opacity duration-300 rounded-full"></div>

                        <!-- Icon -->
                        <div class="relative mb-3">
                            <div class="w-16 h-16 mx-auto rounded-full bg-gradient-to-br from-emerald-500/30 to-teal-500/30 border border-emerald-500/50 flex items-center justify-center group-hover:scale-105 transition-transform duration-300 relative overflow-hidden">
                                <div class="absolute inset-0 bg-[radial-gradient(circle_at_60%_35%,rgba(255,255,255,0.25),transparent_50%)] opacity-70"></div>
                                <div class="absolute inset-0 bg-[linear-gradient(45deg,rgba(255,255,255,0)_25%,rgba(255,255,255,0.1)_50%,rgba(255,255,255,0)_75%)] bg-[length:250%_250%] animate-pulse-slow opacity-50"></div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-emerald-400 relative z-10" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>

                        <!-- Text -->
                        <h3 class="text-xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-teal-400 mb-1 relative">Start Learning</h3>
                        <p class="text-sm text-gray-400 relative group-hover:text-gray-300 transition-colors duration-300">Start your journey to success</p>

                        <!-- Button -->
                        <div class="mt-4 relative">
                            <span class="inline-flex items-center justify-center px-4 py-2 text-sm bg-gradient-to-r from-emerald-600 to-teal-600 group-hover:from-emerald-500 group-hover:to-teal-500 rounded-lg text-white transition-colors shadow-lg shadow-emerald-900/30 relative overflow-hidden">
                                <span class="absolute inset-0 bg-[linear-gradient(45deg,rgba(255,255,255,0)_25%,rgba(255,255,255,0.1)_50%,rgba(255,255,255,0)_75%)] bg-[length:250%_250%] opacity-0 group-hover:opacity-100 group-hover:animate-shimmer"></span>
                                <span class="relative z-10 flex items-center">Explore Now
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 group-hover:translate-x-1 transition-transform duration-300" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </span>
                        </div>
                    </a>
                </div>

                <!-- Quick Links -->
                <!-- <div class="grid grid-cols-3 gap-3">
                    <a href="{{ route('courses') }}" class="rounded-xl bg-neutral-800/50 border border-neutral-800 p-3 flex flex-col items-center justify-center hover:bg-neutral-800 hover:border-blue-500/30 transition-all duration-300 shadow-lg group relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <div class="absolute -inset-1 bg-blue-400/5 blur-xl opacity-0 group-hover:opacity-70 transition-opacity duration-300 rounded-full"></div>
                        <div class="relative z-10">
                            <div class="relative mb-1">
                                <div class="absolute -inset-1 bg-blue-500/20 rounded-full blur-sm opacity-0 group-hover:opacity-70 transition-opacity duration-300"></div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-400 relative" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                                </svg>
                            </div>
                            <span class="text-xs text-gray-300 group-hover:text-blue-300 transition-colors duration-300">Courses</span>
                        </div>
                    </a>
                    <a href="{{ route('assignments') }}" class="rounded-xl bg-neutral-800/50 border border-neutral-800 p-3 flex flex-col items-center justify-center hover:bg-neutral-800 hover:border-purple-500/30 transition-all duration-300 shadow-lg group relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-br from-purple-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <div class="absolute -inset-1 bg-purple-400/5 blur-xl opacity-0 group-hover:opacity-70 transition-opacity duration-300 rounded-full"></div>
                        <div class="relative z-10">
                            <div class="relative mb-1">
                                <div class="absolute -inset-1 bg-purple-500/20 rounded-full blur-sm opacity-0 group-hover:opacity-70 transition-opacity duration-300"></div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-400 relative" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <span class="text-xs text-gray-300 group-hover:text-purple-300 transition-colors duration-300">Assignments</span>
                        </div>
                    </a>
                    <a href="{{ route('grades') }}" class="rounded-xl bg-neutral-800/50 border border-neutral-800 p-3 flex flex-col items-center justify-center hover:bg-neutral-800 hover:border-yellow-500/30 transition-all duration-300 shadow-lg group relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-br from-yellow-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <div class="absolute -inset-1 bg-yellow-400/5 blur-xl opacity-0 group-hover:opacity-70 transition-opacity duration-300 rounded-full"></div>
                        <div class="relative z-10">
                            <div class="relative mb-1">
                                <div class="absolute -inset-1 bg-yellow-500/20 rounded-full blur-sm opacity-0 group-hover:opacity-70 transition-opacity duration-300"></div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-400 relative" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm9.707 5.707a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <span class="text-xs text-gray-300 group-hover:text-yellow-300 transition-colors duration-300">Grades</span>
                        </div>
                    </a>
                </div> -->

                <!-- Badges -->
                <div class="rounded-2xl border border-neutral-800 bg-neutral-800/50 backdrop-blur-sm shadow-xl overflow-hidden relative group hover:border-neutral-700 transition-all duration-300 mt-6">
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(59,130,246,0.1),transparent_70%)] opacity-70 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-blue-500/0 via-blue-500/5 to-blue-500/0 rounded-xl opacity-0 group-hover:opacity-100 blur-xl transition-opacity duration-500 group-hover:duration-200"></div>
                    <div class="p-6 relative z-10">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                                <div class="relative">
                                    <div class="absolute -inset-1 bg-blue-500/20 rounded-full blur-sm opacity-70"></div>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400 relative" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <span class="text-white bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-400">Badges</span>
                            </h3>
                        </div>
                        @if(isset($userBadges) && $userBadges->isNotEmpty())
                            <div class="grid grid-cols-3 gap-3">
                                @foreach($userBadges as $badge)
                                    <div class="rounded-xl bg-neutral-700/20 border border-neutral-700/50 p-2 flex flex-col items-center justify-between hover:bg-neutral-700/30 hover:border-blue-500/30 transition-all transform hover:scale-105 group relative overflow-hidden w-20 h-28 mx-auto" title="{{ $badge->description }}">
                                        <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                        <div class="absolute -inset-1 bg-blue-400/5 blur-xl opacity-0 group-hover:opacity-70 transition-opacity duration-300 rounded-full"></div>
                                        <div class="relative z-10">
                                            @if($badge->image)
                                                <div class="relative mb-1 mx-auto">
                                                    <div class="absolute -inset-1 bg-blue-500/10 rounded-full blur-sm opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                                    <img src="{{ asset($badge->image) }}" alt="{{ $badge->name }}" class="h-10 w-10 object-contain relative mx-auto">
                                                </div>
                                            @else
                                                <div class="relative mb-1 mx-auto">
                                                    <div class="absolute -inset-1 bg-blue-500/20 rounded-full blur-sm opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500/20 to-cyan-500/20 border border-blue-500/30 flex items-center justify-center relative overflow-hidden group-hover:border-blue-500/50 transition-colors duration-300">
                                                        <div class="absolute inset-0 bg-[radial-gradient(circle_at_60%_35%,rgba(255,255,255,0.2),transparent_50%)] opacity-0 group-hover:opacity-70 transition-opacity duration-300"></div>
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-400 relative z-10" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="mt-2 w-full pb-1">
                                                <p class="text-[10px] text-gray-200 font-medium text-center leading-tight group-hover:text-blue-300 transition-colors duration-300 mx-auto px-1">{{ $badge->name }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-center p-6 bg-neutral-800/30 rounded-xl border border-neutral-700/50">
                                <div class="h-16 w-16 rounded-full bg-blue-500/10 flex items-center justify-center mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <p class="text-gray-300 text-center mb-1">No badges earned yet</p>
                                <p class="text-sm text-gray-500 text-center">Keep leveling up to earn badges!</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Leaderboard -->
                <div class="rounded-2xl border border-neutral-800 bg-neutral-800/50 backdrop-blur-sm shadow-xl overflow-hidden relative group hover:border-neutral-700 transition-all duration-300">
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(234,179,8,0.1),transparent_70%)] opacity-70 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-yellow-500/0 via-yellow-500/5 to-yellow-500/0 rounded-xl opacity-0 group-hover:opacity-100 blur-xl transition-opacity duration-500 group-hover:duration-200"></div>
                    <div class="p-6 relative z-10">
                        <h3 class="text-lg font-bold text-white flex items-center gap-2 mb-4">
                            <div class="relative">
                                <div class="absolute -inset-1 bg-yellow-500/20 rounded-full blur-sm opacity-70"></div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400 relative" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                            </div>
                            <span class="text-white bg-clip-text bg-gradient-to-r from-yellow-400 to-amber-400">Leaderboard</span>
                        </h3>
                        <div class="space-y-2">
                            @forelse($leaderboardData->take(5) as $index => $entry)
                                @php $rank = $index + 1; @endphp
                                <div class="flex items-center p-3 rounded-xl {{ $entry->user->id === $user->id ? 'bg-emerald-500/10 border border-emerald-500/30 hover:bg-emerald-500/15' : 'bg-neutral-700/20 border border-neutral-700/50 hover:bg-neutral-700/30' }} transition-all duration-300 group relative overflow-hidden">
                                    <div class="absolute inset-0 bg-[linear-gradient(45deg,rgba(255,255,255,0)_25%,rgba(255,255,255,0.05)_50%,rgba(255,255,255,0)_75%)] bg-[length:250%_250%] opacity-0 group-hover:opacity-100 group-hover:animate-shimmer"></div>
                                    <div class="w-8 h-8 flex-shrink-0 rounded-full flex items-center justify-center relative {{ $rank == 1 ? 'bg-yellow-500/20 text-yellow-400' : ($rank == 2 ? 'bg-gray-300/20 text-gray-300' : ($rank == 3 ? 'bg-orange-500/20 text-orange-400' : 'bg-neutral-600/20 text-gray-400')) }}">
                                        @if($rank <= 3)
                                            <div class="absolute inset-0 rounded-full {{ $rank == 1 ? 'bg-yellow-500/10' : ($rank == 2 ? 'bg-gray-300/10' : 'bg-orange-500/10') }} animate-pulse-slow"></div>
                                        @endif
                                        <span class="relative z-10 font-bold">{{ $rank }}</span>
                                    </div>
                                    <div class="ml-3 flex-grow relative z-10">
                                        <div class="flex justify-between items-center">
                                            <span class="font-medium text-gray-100 truncate group-hover:text-white transition-colors duration-300">{{ $entry->user->name }}</span>
                                            <span class="text-xs font-mono bg-neutral-800/80 rounded-full px-2 py-0.5 text-gray-300 border border-neutral-700/50 group-hover:border-neutral-600/50 transition-colors duration-300">{{ number_format($entry->experience->experience_points ?? 0) }}</span>
                                        </div>
                                        <div class="flex items-center mt-1">
                                            <div class="text-xs text-gray-400 group-hover:text-gray-300 transition-colors duration-300">Level {{ $entry->experience->level_id ?? 1 }}</div>
                                            <div class="ml-2 w-full bg-neutral-800/80 rounded-full h-1.5 overflow-hidden backdrop-blur-sm border border-neutral-700/50 shadow-inner">
                                                <div class="bg-gradient-to-r from-emerald-500 to-teal-500 h-1.5 rounded-full relative" style="width: 70%">
                                                    <div class="absolute inset-0 bg-[linear-gradient(45deg,rgba(255,255,255,0)_25%,rgba(255,255,255,0.1)_50%,rgba(255,255,255,0)_75%)] bg-[length:200%_100%] opacity-0 group-hover:opacity-100 group-hover:animate-shimmer"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="p-4 text-center text-gray-400 text-sm">
                                    Leaderboard data is currently unavailable.
                                </div>
                            @endforelse

                            @if($userRank && $userRank > 5)
                                <div class="mt-2 pt-2 border-t border-dashed border-neutral-700">
                                    <div class="flex items-center p-3 rounded-xl bg-emerald-500/10 border border-emerald-500/30 hover:bg-emerald-500/15 transition-all duration-300 group relative overflow-hidden">
                                        <div class="absolute inset-0 bg-[linear-gradient(45deg,rgba(255,255,255,0)_25%,rgba(255,255,255,0.05)_50%,rgba(255,255,255,0)_75%)] bg-[length:250%_250%] opacity-0 group-hover:opacity-100 group-hover:animate-shimmer"></div>
                                        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(16,185,129,0.15),transparent_70%)] opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                        <div class="w-8 h-8 flex-shrink-0 rounded-full bg-neutral-600/20 flex items-center justify-center text-gray-400 relative">
                                            <span class="relative z-10 font-bold">{{ $userRank }}</span>
                                        </div>
                                        <div class="ml-3 flex-grow relative z-10">
                                            <div class="flex justify-between items-center">
                                                <span class="font-medium text-gray-100 truncate group-hover:text-white transition-colors duration-300">{{ $user->name }}</span>
                                                <span class="text-xs font-mono bg-neutral-800/80 rounded-full px-2 py-0.5 text-gray-300 border border-emerald-500/30 group-hover:border-emerald-500/50 transition-colors duration-300">{{ number_format($currentPoints) }}</span>
                                            </div>
                                            <div class="flex items-center mt-1">
                                                <div class="text-xs text-gray-400 group-hover:text-gray-300 transition-colors duration-300">Level {{ $currentLevel }}</div>
                                                <div class="ml-2 w-full bg-neutral-800/80 rounded-full h-1.5 overflow-hidden border border-neutral-700/50">
                                                    <div class="bg-gradient-to-r from-emerald-500 to-teal-500 h-1.5 rounded-full" style="width: {{ $progressPercentage }}%"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Optimized contribution graph with reduced DOM manipulation and better performance
        document.addEventListener('DOMContentLoaded', function() {
            // Configuration
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            const days = ['Mon', 'Wed', 'Fri']; // Only showing weekdays

            // Generate a smaller dataset (6 months instead of 12) to reduce DOM elements
            function generateData() {
                const data = {};
                const now = new Date();

                // Start from approx 6 months ago instead of 12
                const startDate = new Date(now);
                startDate.setMonth(now.getMonth() - 5);
                startDate.setDate(1);

                // Generate random activity data with fewer data points
                let currentDate = new Date(startDate);
                while (currentDate <= now) {
                    // Only include weekdays (Mon=1 to Fri=5)
                    const dayOfWeek = currentDate.getDay();
                    if (dayOfWeek >= 1 && dayOfWeek <= 5) {
                        // Only include every other day to reduce data points by 50%
                        if (currentDate.getDate() % 2 === 0) {
                            const dateStr = currentDate.toISOString().split('T')[0];
                            // Simpler random calculation
                            const randomActivity = Math.floor(Math.random() * 4);
                            data[dateStr] = randomActivity;
                        }
                    }
                    currentDate.setDate(currentDate.getDate() + 1);
                }
                return data;
            }

            // Create the contribution graph with optimized rendering
            function createContributionGraph() {
                const graphContainer = document.getElementById('contributionGraph');

                if (!graphContainer) return;

                const graphData = generateData();
                if (Object.keys(graphData).length === 0) {
                    graphContainer.innerHTML = '<p class="text-gray-400 text-sm">No activity data to display.</p>';
                    return;
                }

                // Clear existing content
                graphContainer.innerHTML = '';

                // Get the start and end dates from data
                const dates = Object.keys(graphData).sort();
                const startDate = new Date(dates[0] + 'T00:00:00Z');
                const endDate = new Date(dates[dates.length - 1] + 'T00:00:00Z');

                // Create simplified month labels
                let monthsHTML = '<div class="flex text-xs text-gray-500 mb-1 pl-8">';
                for (let i = 0; i < 6; i++) { // Fixed number of months
                    const monthIndex = (startDate.getMonth() + i) % 12;
                    monthsHTML += `<div class="flex-1 text-left">${months[monthIndex]}</div>`;
                }
                monthsHTML += '</div>';

                // Create simplified grid
                let gridHTML = `
                <div class="flex h-[calc(100%-1rem)]">
                    <div class="flex flex-col w-8 text-xs text-gray-500 justify-between py-0.5 pr-2">
                        <div class="h-4"></div>
                        <div class="h-4">${days[0]}</div>
                        <div class="h-4"></div>
                        <div class="h-4">${days[1]}</div>
                        <div class="h-4"></div>
                        <div class="h-4">${days[2]}</div>
                        <div class="h-4"></div>
                    </div>
                    <div class="flex flex-1 gap-1 overflow-hidden">
                `;

                // Generate a fixed number of weeks (26 weeks = ~6 months)
                const weeksToShow = 26;

                for (let week = 0; week < weeksToShow; week++) {
                    gridHTML += '<div class="flex flex-col gap-1 w-4">';

                    // Generate 5 days per week (Mon-Fri)
                    for (let day = 0; day < 5; day++) {
                        // Randomly assign activity levels for visual effect
                        const activityLevel = Math.floor(Math.random() * 5);

                        let bgColor = 'bg-neutral-700'; // Default: No activity
                        if (activityLevel === 1) bgColor = 'bg-emerald-900';
                        if (activityLevel === 2) bgColor = 'bg-emerald-700';
                        if (activityLevel === 3) bgColor = 'bg-emerald-500';
                        if (activityLevel >= 4) bgColor = 'bg-emerald-300';

                        gridHTML += `<div class="h-4 w-4 rounded-sm ${bgColor}"></div>`;
                    }

                    gridHTML += '</div>';
                }

                gridHTML += '</div></div>';

                // Set the HTML all at once to minimize DOM operations
                graphContainer.innerHTML = monthsHTML + gridHTML;
            }

            // Use requestAnimationFrame to ensure the graph renders after the page layout is complete
            requestAnimationFrame(createContributionGraph);
        });
    </script>

    <style>
        /* Optimized animations with reduced performance impact */
        @keyframes shimmer {
            0% { background-position: 200% 0; }
            100% { background-position: 0 0; }
        }
        .animate-shimmer {
            animation: shimmer 3s infinite linear;
            will-change: background-position;
        }

        /* Optimized pulse animation with fewer keyframes */
        @keyframes pulse-slow {
            50% { opacity: 1; }
        }
        .animate-pulse-slow {
            opacity: 0.7;
            animation: pulse-slow 4s infinite ease-in-out;
            will-change: opacity;
        }
    </style>
</x-layouts.app>