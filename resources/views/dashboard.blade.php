<x-layouts.app>
    <div class="flex h-full w-full flex-1 flex-col gap-6 text-gray-100 p-6 border border-emerald-500 rounded-lg">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-white">GLP - Gamified Dashboard</h1>
            <div class="flex items-center gap-2">
                <span class="text-sm text-gray-400">{{ date('l, F j, Y') }}</span>
                <div class="h-6 w-6 rounded-full bg-emerald-500 flex items-center justify-center">
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

            // --- Achievements/Badges Data ---
            $userAchievements = $user->getUserAchievements()->take(4);

            // --- Challenges Data ---
            $activeChallenges = $user->getActiveChallenges()->take(3);
        @endphp

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <!-- Left Column (Profile + Stats) -->
            <div class="lg:col-span-8 space-y-6">
                <!-- Profile Card with Stats -->
                <div class="rounded-2xl border border-neutral-800 bg-neutral-800/50 backdrop-blur-sm shadow-xl overflow-hidden">
                    <div class="relative p-6">
                        <!-- Decorative Background Elements -->
                        <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-bl from-emerald-500/10 to-transparent rounded-full blur-2xl -z-10"></div>
                        <div class="absolute bottom-0 left-0 w-48 h-48 bg-gradient-to-tr from-purple-500/10 to-transparent rounded-full blur-2xl -z-10"></div>
                        
                        <div class="flex flex-col md:flex-row md:items-center gap-6">
                            <!-- Avatar & Welcome -->
                            <div class="flex items-center gap-4">
                                <div class="relative">
                                    <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-emerald-500 to-green-600 flex items-center justify-center text-2xl font-bold text-white shadow-lg">
                                        {{ $user->initials() }}
                                    </div>
                                    <div class="absolute -bottom-1 -right-1 bg-neutral-800 rounded-full p-1 shadow-lg">
                                        <div class="bg-emerald-500 text-white text-xs font-bold rounded-full w-6 h-6 flex items-center justify-center">
                                            {{ $currentLevel }}
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <h2 class="text-2xl font-bold text-white">Welcome back, {{ explode(' ', $user->name)[0] }}!</h2>
                                    <p class="text-gray-400">You're making great progress</p>
                                </div>
                            </div>
                            
                            <!-- Stats Cards -->
                            <div class="grid grid-cols-3 gap-4 md:ml-auto">
                                <div class="rounded-xl bg-neutral-800/80 border border-neutral-700 p-3 flex flex-col items-center justify-center">
                                    <div class="text-yellow-400 mb-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    </div>
                                    <span class="text-xs text-gray-400">Score</span>
                                    <span class="text-white font-bold">{{ $score }}</span>
                                    <span class="text-xs {{ $scoreChange >= 0 ? 'text-green-400' : 'text-red-400' }}">
                                        {{ $scoreChange >= 0 ? '+' : '' }}{{ number_format($scoreChange, 2) }}
                                    </span>
                                </div>
                                <div class="rounded-xl bg-neutral-800/80 border border-neutral-700 p-3 flex flex-col items-center justify-center">
                                    <div class="text-blue-400 mb-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <span class="text-xs text-gray-400">Attendance</span>
                                    <span class="text-white font-bold">{{ $attendancePercentage }}%</span>
                                    <span class="text-xs {{ $attendanceChange >= 0 ? 'text-green-400' : 'text-red-400' }}">
                                        {{ $attendanceChange >= 0 ? '+' : '' }}{{ $attendanceChange }}%
                                    </span>
                                </div>
                                <div class="rounded-xl bg-neutral-800/80 border border-neutral-700 p-3 flex flex-col items-center justify-center">
                                    <div class="text-purple-400 mb-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 16c1.255 0 2.443-.29 3.5-.804V4.804zM14.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 0114.5 16c1.255 0 2.443-.29 3.5-.804v-10A7.968 7.968 0 0014.5 4z" />
                                        </svg>
                                    </div>
                                    <span class="text-xs text-gray-400">Credits</span>
                                    <span class="text-white font-bold">{{ $completionPercentage }}%</span>
                                    <span class="text-xs text-gray-400">{{ $creditsCompleted }}/{{ $creditsRequired }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- XP Progress Bar -->
                        <div class="mt-6">
                            <div class="flex justify-between items-end mb-2">
                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-sm font-medium text-emerald-400">Level {{ $currentLevel }} Progress</span>
                                </div>
                                <span class="text-xs text-gray-400">{{ number_format($currentPoints) }} / {{ number_format($pointsForNextLevel) }} XP</span>
                            </div>
                            <div class="w-full h-3 bg-neutral-700/50 rounded-full overflow-hidden backdrop-blur-sm">
                                <div class="h-full bg-gradient-to-r from-emerald-500 to-teal-400 rounded-full transition-all duration-500 ease-out relative" style="width: {{ $progressPercentage }}%">
                                    <div class="absolute inset-0 bg-[linear-gradient(45deg,rgba(255,255,255,0)_25%,rgba(255,255,255,0.2)_50%,rgba(255,255,255,0)_75%)] bg-[length:200%_100%] animate-shimmer"></div>
                                </div>
                            </div>
                            <p class="text-right text-xs text-gray-400 mt-1">
                                {{ number_format($xpToNextLevel) }} XP to Level {{ $currentLevel + 1 }}
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Activity Graph -->
                <div class="rounded-2xl border border-neutral-800 bg-neutral-800/50 backdrop-blur-sm shadow-xl overflow-hidden" style="min-height: 350px; height: 400px;">
                    <div class="p-6 h-full">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 0l-2 2a1 1 0 101.414 1.414L8 10.414l1.293 1.293a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                Your Activity
                            </h3>
                            <div class="flex items-center gap-2">
                                <div class="text-xs text-gray-400">Less</div>
                                <div class="flex items-center gap-1">
                                    <div class="h-3 w-3 rounded-sm bg-neutral-700" title="No activity"></div>
                                    <div class="h-3 w-3 rounded-sm bg-emerald-900" title="Low activity"></div>
                                    <div class="h-3 w-3 rounded-sm bg-emerald-700" title="Medium activity"></div>
                                    <div class="h-3 w-3 rounded-sm bg-emerald-500" title="High activity"></div>
                                    <div class="h-3 w-3 rounded-sm bg-emerald-300" title="Very high activity"></div>
                                </div>
                                <div class="text-xs text-gray-400">More</div>
                            </div>
                        </div>
                        <div class="overflow-x-auto h-[calc(100%-3rem)]">
                            <div class="contribution-calendar min-w-[700px] h-full">
                                <div id="contributionGraph" class="mt-2 w-full h-[calc(100%-0.5rem)]"></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Active Challenges -->
                <div class="rounded-2xl border border-neutral-800 bg-neutral-800/50 backdrop-blur-sm shadow-xl overflow-hidden">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-orange-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd" />
                                    <path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0010 15c-2.796 0-5.487-.46-8-1.308z" />
                                </svg>
                                Active Challenges
                            </h3>
                            <a href="{{ route('learning') }}" class="text-sm text-emerald-400 hover:text-emerald-300 transition-colors flex items-center gap-1">
                                View All
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                        @if($activeChallenges->isNotEmpty())
                            <div class="space-y-4">
                                @foreach($activeChallenges as $challenge)
                                    <div class="rounded-xl bg-neutral-700/20 border border-neutral-700/50 p-4 hover:bg-neutral-700/30 transition-colors">
                                        <div class="flex justify-between items-center mb-2">
                                            <span class="font-medium text-white">{{ $challenge->name }}</span>
                                            <span class="text-xs font-semibold px-2 py-1 rounded-full {{ ($challenge->pivot->progress ?? 0) >= 100 ? 'bg-green-500/20 text-green-400' : 'bg-orange-500/20 text-orange-400' }}">
                                                {{ $challenge->pivot->progress ?? 0 }}% Complete
                                            </span>
                                        </div>
                                        <div class="w-full bg-neutral-700/50 rounded-full h-2 overflow-hidden">
                                            <div class="bg-gradient-to-r from-orange-500 to-yellow-500 h-2 rounded-full transition-all duration-300 relative" style="width: {{ $challenge->pivot->progress ?? 0 }}%">
                                                <div class="absolute inset-0 bg-[linear-gradient(45deg,rgba(255,255,255,0)_25%,rgba(255,255,255,0.2)_50%,rgba(255,255,255,0)_75%)] bg-[length:200%_100%] animate-shimmer"></div>
                                            </div>
                                        </div>
                                        @if($challenge->description)
                                            <p class="text-xs text-gray-400 mt-2">{{ Str::limit($challenge->description, 100) }}</p>
                                        @endif
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
                <!-- Personalized Recommendations -->
                <div class="rounded-2xl border border-neutral-800 bg-neutral-800/50 backdrop-blur-sm shadow-xl overflow-hidden mt-6">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-pink-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                </svg>
                                Recommended For You
                            </h3>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div class="rounded-xl bg-gradient-to-br from-pink-500/20 to-purple-500/20 border border-pink-500/30 p-4 hover:from-pink-500/30 hover:to-purple-500/30 transition-colors group">
                                <div class="flex items-start gap-3">
                                    <div class="w-12 h-12 rounded-lg bg-pink-500/30 flex items-center justify-center flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-pink-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-white mb-1">Machine Learning Basics</h4>
                                        <p class="text-xs text-gray-400 mb-2">Based on your interest in Data Science</p>
                                        <div class="flex items-center gap-2">
                                            <span class="text-xs bg-pink-500/20 text-pink-400 px-2 py-0.5 rounded-full">4 Weeks</span>
                                            <span class="text-xs bg-pink-500/20 text-pink-400 px-2 py-0.5 rounded-full">Beginner</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3 text-right">
                                    <a href="#" class="text-xs text-pink-400 group-hover:text-pink-300 transition-colors inline-flex items-center gap-1">
                                        Start Learning
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            
                            <div class="rounded-xl bg-gradient-to-br from-blue-500/20 to-teal-500/20 border border-blue-500/30 p-4 hover:from-blue-500/30 hover:to-teal-500/30 transition-colors group">
                                <div class="flex items-start gap-3">
                                    <div class="w-12 h-12 rounded-lg bg-blue-500/30 flex items-center justify-center flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M12.316 3.051a1 1 0 01.633 1.265l-4 12a1 1 0 11-1.898-.632l4-12a1 1 0 011.265-.633zM5.707 6.293a1 1 0 010 1.414L3.414 10l2.293 2.293a1 1 0 11-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0zm8.586 0a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 11-1.414-1.414L16.586 10l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-white mb-1">Advanced JavaScript</h4>
                                        <p class="text-xs text-gray-400 mb-2">Continue your web development journey</p>
                                        <div class="flex items-center gap-2">
                                            <span class="text-xs bg-blue-500/20 text-blue-400 px-2 py-0.5 rounded-full">3 Weeks</span>
                                            <span class="text-xs bg-blue-500/20 text-blue-400 px-2 py-0.5 rounded-full">Intermediate</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3 text-right">
                                    <a href="#" class="text-xs text-blue-400 group-hover:text-blue-300 transition-colors inline-flex items-center gap-1">
                                        Start Learning
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-4 text-center">
                            <a href="{{ route('courses') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 rounded-lg text-white transition-colors shadow-lg shadow-emerald-900/30">
                                View All Recommendations
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Right Column (Leaderboard + Achievements) -->
            <div class="lg:col-span-4 space-y-6">
                <!-- Main Action Button -->
                <div class="rounded-2xl border border-emerald-500/50 bg-emerald-500/10 backdrop-blur-sm shadow-xl overflow-hidden">
                    <a href="{{ route('learning') }}" class="block p-6 text-center relative group">
                        <!-- Background effect -->
                        <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/20 to-teal-500/10 opacity-50 group-hover:opacity-75 transition-opacity duration-300"></div>
                        <div class="absolute inset-0 bg-[radial-gradient(circle,_rgba(16,185,129,0.3)_0%,_rgba(0,0,0,0)_70%)] opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        
                        <!-- Icon -->
                        <div class="relative mb-3">
                            <div class="w-16 h-16 mx-auto rounded-full bg-emerald-500/20 border border-emerald-500/50 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-emerald-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        
                        <!-- Text -->
                        <h3 class="text-xl font-bold text-emerald-400 mb-1 relative">Start Learning</h3>
                        <p class="text-sm text-gray-400 relative">Start your journey to success</p>
                        
                        <!-- Button -->
                        <div class="mt-4 relative">
                            <span class="inline-flex items-center justify-center px-4 py-2 text-sm bg-gradient-to-r from-emerald-600 to-teal-600 group-hover:from-emerald-500 group-hover:to-teal-500 rounded-lg text-white transition-colors shadow-lg shadow-emerald-900/30">
                                Explore Now
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </div>
                    </a>
                </div>
                
                <!-- Quick Links -->
                <div class="grid grid-cols-3 gap-3">
                    <a href="{{ route('courses') }}" class="rounded-xl bg-neutral-800/50 border border-neutral-800 p-3 flex flex-col items-center justify-center hover:bg-neutral-800 hover:border-neutral-700 transition-colors shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-400 mb-1" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                        </svg>
                        <span class="text-xs text-gray-300">Courses</span>
                    </a>
                    <a href="{{ route('assignments') }}" class="rounded-xl bg-neutral-800/50 border border-neutral-800 p-3 flex flex-col items-center justify-center hover:bg-neutral-800 hover:border-neutral-700 transition-colors shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-400 mb-1" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-xs text-gray-300">Assignments</span>
                    </a>
                    <a href="{{ route('grades') }}" class="rounded-xl bg-neutral-800/50 border border-neutral-800 p-3 flex flex-col items-center justify-center hover:bg-neutral-800 hover:border-neutral-700 transition-colors shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-400 mb-1" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm9.707 5.707a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-xs text-gray-300">Grades</span>
                    </a>
                </div>
                
                <!-- Leaderboard -->
                <div class="rounded-2xl border border-neutral-800 bg-neutral-800/50 backdrop-blur-sm shadow-xl overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-white flex items-center gap-2 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                            Leaderboard
                        </h3>
                        <div class="space-y-2">
                            @forelse($leaderboardData->take(5) as $index => $entry)
                                @php $rank = $index + 1; @endphp
                                <div class="flex items-center p-3 rounded-xl {{ $entry->user->id === $user->id ? 'bg-emerald-500/10 border border-emerald-500/30' : 'bg-neutral-700/20 border border-neutral-700/50' }}">
                                    <div class="w-8 h-8 flex-shrink-0 rounded-full flex items-center justify-center {{ $rank == 1 ? 'bg-yellow-500/20 text-yellow-400' : ($rank == 2 ? 'bg-gray-300/20 text-gray-300' : ($rank == 3 ? 'bg-orange-500/20 text-orange-400' : 'bg-neutral-600/20 text-gray-400')) }}">
                                        {{ $rank }}
                                    </div>
                                    <div class="ml-3 flex-grow">
                                        <div class="flex justify-between items-center">
                                            <span class="font-medium text-gray-100 truncate">{{ $entry->user->name }}</span>
                                            <span class="text-xs font-mono bg-neutral-800/80 rounded-full px-2 py-0.5 text-gray-300">{{ number_format($entry->experience->experience_points ?? 0) }}</span>
                                        </div>
                                        <div class="flex items-center mt-1">
                                            <div class="text-xs text-gray-400">Level {{ $entry->experience->level_id }}</div>
                                            <div class="ml-2 w-full bg-neutral-700/50 rounded-full h-1.5 overflow-hidden">
                                                <div class="bg-gradient-to-r from-emerald-500 to-teal-500 h-1.5 rounded-full" style="width: 70%"></div>
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
                                    <div class="flex items-center p-3 rounded-xl bg-emerald-500/10 border border-emerald-500/30">
                                        <div class="w-8 h-8 flex-shrink-0 rounded-full bg-neutral-600/20 flex items-center justify-center text-gray-400">
                                            {{ $userRank }}
                                        </div>
                                        <div class="ml-3 flex-grow">
                                            <div class="flex justify-between items-center">
                                                <span class="font-medium text-gray-100 truncate">{{ $user->name }}</span>
                                                <span class="text-xs font-mono bg-neutral-800/80 rounded-full px-2 py-0.5 text-gray-300">{{ number_format($currentPoints) }}</span>
                                            </div>
                                            <div class="flex items-center mt-1">
                                                <div class="text-xs text-gray-400">Level {{ $currentLevel }}</div>
                                                <div class="ml-2 w-full bg-neutral-700/50 rounded-full h-1.5 overflow-hidden">
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
                
                <!-- Achievements -->
                <div class="rounded-2xl border border-neutral-800 bg-neutral-800/50 backdrop-blur-sm shadow-xl overflow-hidden">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" />
                                </svg>
                                Achievements
                            </h3>
                            <a href="#" class="text-sm text-emerald-400 hover:text-emerald-300 transition-colors flex items-center gap-1">
                                View All
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                        @if($userAchievements->isNotEmpty())
                            <div class="grid grid-cols-2 gap-3">
                                @foreach($userAchievements as $achievement)
                                    <div class="rounded-xl bg-neutral-700/20 border border-neutral-700/50 p-3 flex flex-col items-center justify-center hover:bg-neutral-700/30 transition-all transform hover:scale-105" title="{{ $achievement->description }}">
                                        @if($achievement->image)
                                            <img src="{{ $achievement->image }}" alt="{{ $achievement->name }}" class="h-12 w-12 mb-2 object-contain">
                                        @else
                                            <div class="h-12 w-12 mb-2 rounded-full bg-purple-500/20 border border-purple-500/30 flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-400" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        @endif
                                        <p class="text-xs text-gray-200 font-medium text-center leading-tight">{{ $achievement->name }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="rounded-xl bg-neutral-700/20 border border-neutral-700/50 p-6 text-center">
                                <p class="text-gray-400 text-sm mb-3">No achievements earned yet. Keep learning and complete challenges!</p>
                                <!-- <a href="{{ route('learning') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 rounded-lg text-white transition-colors shadow-lg shadow-purple-900/30">
                                    Start Earning
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </a> -->
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // IMPORTANT: The generateData() function currently uses random data.
        // Replace this with a function that fetches actual user activity data,
        // possibly via an API call to the backend (e.g., fetching Audit logs or task completions).
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM Content Loaded for Contribution Graph');
            // Configuration
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            const days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri']; // Only showing weekdays
            
            // Generate a year of data (for demo purposes)
            function generateData() {
                console.log('Generating demo contribution data');
                const data = {};
                const now = new Date();
                const currentYear = now.getFullYear();
                
                // Start from approx 12 months ago
                const startDate = new Date(now);
                startDate.setMonth(now.getMonth() - 11);
                startDate.setDate(1);
                
                // Generate random activity data for each day up to today
                let currentDate = new Date(startDate);
                while (currentDate <= now) {
                    // Only include weekdays (Mon=1 to Fri=5)
                    const dayOfWeek = currentDate.getDay();
                    if (dayOfWeek >= 1 && dayOfWeek <= 5) {
                        const dateStr = currentDate.toISOString().split('T')[0];
                        // Skew towards lower activity levels
                        const randomActivity = Math.floor(Math.pow(Math.random(), 1.5) * 5);
                        data[dateStr] = randomActivity;
                    }
                    currentDate.setDate(currentDate.getDate() + 1);
                }
                console.log(`Generated ${Object.keys(data).length} demo data points`);
                return data;
            }
            
            // Create the contribution graph
            function createContributionGraph() {
                console.log('Creating contribution graph');
                const graphContainer = document.getElementById('contributionGraph');
                
                if (!graphContainer) {
                    console.error('Graph container #contributionGraph not found!');
                    return;
                }
                
                const graphData = generateData();
                if (Object.keys(graphData).length === 0) {
                    console.warn('No data available for contribution graph.');
                    graphContainer.innerHTML = '<p class="text-gray-400 text-sm">No activity data to display.</p>';
                    return;
                }
                
                // Clear existing content
                graphContainer.innerHTML = '';
                
                // Create month labels row
                const monthsRow = document.createElement('div');
                monthsRow.className = 'flex text-xs text-gray-500 mb-1 pl-8'; // Added padding to align with days
                
                // Get the start and end dates from data
                const dates = Object.keys(graphData).sort();
                const startDate = new Date(dates[0] + 'T00:00:00Z'); // Use UTC to avoid timezone issues
                const endDate = new Date(dates[dates.length - 1] + 'T00:00:00Z');

                // Add month labels dynamically based on weeks
                let currentMonth = -1;
                let weekCount = 0;
                let monthElements = [];
                let tempDate = new Date(startDate);
                // Align start date to the previous Monday
                tempDate.setDate(tempDate.getDate() - (tempDate.getDay() + 6) % 7);

                while (tempDate <= endDate) {
                    const month = tempDate.getMonth();
                    if (month !== currentMonth) {
                        // Only add month label if it's not the very first week (looks cleaner)
                        if (weekCount > 1) {
                            monthElements.push(`<div class="w-[${(weekCount) * 16 + (weekCount-1)*4}px] text-left">${months[month]}</div>`); // Approx width: (weeks * (cell_width + gap))
                        } else if (monthElements.length === 0 && weekCount === 1) {
                             // Handle first month label specially if it starts mid-graph
                             monthElements.push(`<div class="w-[16px] text-left">${months[month]}</div>`);
                        }
                        currentMonth = month;
                        weekCount = 0; // Reset week count for the new month
                    }
                    // Increment date by 7 days (a week)
                    tempDate.setDate(tempDate.getDate() + 7);
                    weekCount++;
                }
                // Add the last month label segment
                if (weekCount > 0) {
                     monthElements.push(`<div class="flex-1 text-left">${months[currentMonth]}</div>`);
                }

                monthsRow.innerHTML = monthElements.join('');
                graphContainer.appendChild(monthsRow);
                

                // Create the main grid (days + weeks)
                const grid = document.createElement('div');
                grid.className = 'flex h-[calc(100%-1rem)]'; // Adjust height accounting for month labels
                
                // Create day labels column (Mon, Wed, Fri)
                const daysCol = document.createElement('div');
                daysCol.className = 'flex flex-col w-8 text-xs text-gray-500 justify-between py-0.5 pr-2'; // Adjusted padding
                daysCol.innerHTML = `
                    <div class="h-4"></div>
                    <div class="h-4">${days[0]}</div> {{-- Mon --}}
                    <div class="h-4"></div>
                    <div class="h-4">${days[2]}</div> {{-- Wed --}}
                    <div class="h-4"></div>
                    <div class="h-4">${days[4]}</div> {{-- Fri --}}
                    <div class="h-4"></div>
                `;
                grid.appendChild(daysCol);
                
                // Create the weeks container
                const weeksContainer = document.createElement('div');
                weeksContainer.className = 'flex flex-1 gap-1 overflow-hidden'; // Added overflow hidden

                // Calculate number of weeks needed (including partial weeks)
                let iterDate = new Date(startDate);
                // Align start date to the previous Monday for grid start
                iterDate.setDate(iterDate.getDate() - (iterDate.getDay() + 6) % 7);
                const gridEndDate = new Date(endDate);
                // Align end date to the next Sunday for grid end
                gridEndDate.setDate(gridEndDate.getDate() + (7 - gridEndDate.getDay()) % 7);


                // Create week columns and day cells
                while (iterDate <= gridEndDate) {
                    const weekCol = document.createElement('div');
                    weekCol.className = 'flex flex-col gap-1 w-4'; // w-4 + gap-1 = 20px total width per week

                    for (let dayIndex = 0; dayIndex < 7; dayIndex++) { // Iterate through all 7 days
                        const currentDay = new Date(iterDate);
                        currentDay.setDate(iterDate.getDate() + dayIndex);

                        // Only render cells for Mon-Fri
                        if (dayIndex >= 1 && dayIndex <= 5) {
                            // Check if the day is within the actual data range and not in the future
                            if (currentDay >= startDate && currentDay <= new Date() && currentDay <= endDate) {
                                const dateStr = currentDay.toISOString().split('T')[0];
                                const activityLevel = graphData[dateStr] || 0;
                                
                                let bgColor = 'bg-neutral-700'; // Default: No activity
                                if (activityLevel === 1) bgColor = 'bg-emerald-900';
                                if (activityLevel === 2) bgColor = 'bg-emerald-700';
                                if (activityLevel === 3) bgColor = 'bg-emerald-500';
                                if (activityLevel >= 4) bgColor = 'bg-emerald-300'; // Cap at level 4 color
                                
                                weekCol.innerHTML += `
                                    <div class="h-4 w-4 rounded-sm ${bgColor} transition-colors duration-150"
                                         title="${currentDay.toDateString()}: ${activityLevel} contribution${activityLevel !== 1 ? 's' : ''}">
                                    </div>`;
                            } else {
                                // Render an empty placeholder for days outside the range or future days within the grid
                                weekCol.innerHTML += '<div class="h-4 w-4 rounded-sm bg-neutral-800"></div>'; // Use background color for empty
                            }
                        }
                    }
                    // Only add the week column if it contains Mon-Fri cells
                    if (weekCol.innerHTML.includes('<div')) {
                        weeksContainer.appendChild(weekCol);
                    }

                    // Move to the next week
                    iterDate.setDate(iterDate.getDate() + 7);
                }
                
                grid.appendChild(weeksContainer);
                graphContainer.appendChild(grid);
                console.log('Contribution graph creation completed');
            }
            
            createContributionGraph();
        });
    </script>
    
    <style>
        /* Add shimmer animation for progress bars */
        @keyframes shimmer {
            0% { background-position: 200% 0; }
            100% { background-position: 0 0; }
        }
        .animate-shimmer {
            animation: shimmer 2s infinite linear;
        }
    </style>
</x-layouts.app>