<x-layouts.app>
    <!-- Task and recipe approval notifications are now handled by global components -->

    <div class="relative flex h-full w-full flex-1 flex-col gap-6 text-gray-100 p-6 border border-emerald-500 rounded-lg overflow-hidden backdrop-blur-sm">
        <!-- Optimized Background Elements - Single Element -->
        <!-- <div class="absolute inset-0 -z-10 bg-[radial-gradient(ellipse_at_top_right,rgba(16,185,129,0.05),transparent_70%)]" style="background-size: 24px 24px;"></div> -->
        <!-- Header -->
        <div class="flex justify-between items-center mb-6 relative">
            <div class="flex items-center gap-3">
                <div class="h-8 w-1 bg-gradient-to-b from-emerald-400 to-emerald-600 rounded-full"></div>
                <h1 class="text-2xl font-bold text-white tracking-tight">GLP - Gamified Dashboard</h1>
            </div>
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-3 bg-neutral-800/50 px-4 py-1.5 rounded-full border border-neutral-700/50 shadow-lg backdrop-blur-sm">
                    <span class="text-sm text-gray-300 font-medium">{{ date('l, F j, Y') }}</span>
                    <div class="h-6 w-6 rounded-full bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center shadow-lg shadow-emerald-500/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-white" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>

                <!-- Real Notification System -->
                <div x-data="{
                    notifications: [],
                    showNotifications: false,
                    loading: true,
                    init() {
                        this.fetchNotifications();

                        // Poll for new notifications every 30 seconds
                        setInterval(() => {
                            this.fetchNotifications();
                        }, 30000);
                    },
                    fetchNotifications() {
                        this.loading = true;
                        fetch('{{ route("notifications.get") }}')
                            .then(response => response.json())
                            .then(data => {
                                this.notifications = data;
                                this.loading = false;
                            })
                            .catch(error => {
                                console.error('Error fetching notifications:', error);
                                this.loading = false;
                            });
                    },
                    markAsRead(id) {
                        fetch(`{{ url('api/notifications') }}/${id}/read`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                this.notifications = this.notifications.map(n =>
                                    n.id === id ? {...n, read: true} : n
                                );
                            }
                        })
                        .catch(error => console.error('Error marking notification as read:', error));
                    },
                    markAllAsRead() {
                        fetch('{{ route("notifications.read-all") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                this.notifications = this.notifications.map(n => ({...n, read: true}));
                            }
                        })
                        .catch(error => console.error('Error marking all notifications as read:', error));
                    },
                    getUnreadCount() {
                        return this.notifications.filter(n => !n.read).length;
                    }
                }" class="relative">
                    <button @click="showNotifications = !showNotifications" class="relative p-2 rounded-full bg-neutral-800/50 border border-neutral-700/50 hover:bg-neutral-700/50 transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span x-show="getUnreadCount() > 0" x-text="getUnreadCount()" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center"></span>
                    </button>

                    <!-- Notification Panel -->
                    <div x-show="showNotifications" @click.away="showNotifications = false" class="absolute right-0 mt-2 w-[25rem] bg-neutral-800 border border-neutral-700 rounded-lg shadow-xl z-50 overflow-hidden" style="transform: translateX(0);">
                        <div class="p-3 border-b border-neutral-700 flex justify-between items-center">
                            <h3 class="text-white font-medium">Notifications</h3>
                            <button @click="markAllAsRead()" class="text-sm text-emerald-400 hover:text-emerald-300 transition-colors">Mark all as read</button>
                        </div>
                        <div class="max-h-[16rem] overflow-y-auto">
                            <template x-if="loading">
                                <div class="p-3 space-y-3">
                                    <div class="flex items-start gap-3 animate-pulse">
                                        <div class="h-8 w-8 rounded-full bg-neutral-700/50"></div>
                                        <div class="flex-1 space-y-2">
                                            <div class="h-4 bg-neutral-700/50 rounded w-3/4"></div>
                                            <div class="flex justify-between">
                                                <div class="h-3 bg-neutral-700/50 rounded w-1/4"></div>
                                                <div class="h-3 bg-emerald-700/50 rounded w-1/6"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-start gap-3 animate-pulse">
                                        <div class="h-8 w-8 rounded-full bg-neutral-700/50"></div>
                                        <div class="flex-1 space-y-2">
                                            <div class="h-4 bg-neutral-700/50 rounded w-2/3"></div>
                                            <div class="flex justify-between">
                                                <div class="h-3 bg-neutral-700/50 rounded w-1/4"></div>
                                                <div class="h-3 bg-emerald-700/50 rounded w-1/6"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <template x-if="!loading && notifications.length === 0">
                                <div class="p-4 text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto text-neutral-600 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                    </svg>
                                    <p class="text-gray-400 text-sm font-medium">No notifications yet</p>
                                    <p class="text-gray-500 text-xs mt-1">New notifications will appear here</p>
                                </div>
                            </template>
                            <template x-for="notification in notifications" :key="notification.id">
                                <div @click="markAsRead(notification.id)" :class="{'bg-emerald-900/30': !notification.read}" class="p-3 border-b border-neutral-700 hover:bg-neutral-700 cursor-pointer transition-colors duration-200">
                                    <div class="flex items-start gap-3">
                                        <div>
                                            <template x-if="notification.type === 'achievement'">
                                                <div class="h-7 w-7 rounded-full bg-blue-500/20 border border-blue-500/30 flex items-center justify-center text-blue-400">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                            </template>
                                            <template x-if="notification.type === 'challenge'">
                                                <div class="h-7 w-7 rounded-full bg-orange-500/20 border border-orange-500/30 flex items-center justify-center text-orange-400">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                            </template>
                                            <template x-if="notification.type === 'grade'">
                                                <div class="h-7 w-7 rounded-full bg-purple-500/20 border border-purple-500/30 flex items-center justify-center text-purple-400">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm9.707 5.707a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                            </template>
                                            <template x-if="notification.type === 'system'">
                                                <div class="h-7 w-7 rounded-full bg-gray-500/20 border border-gray-500/30 flex items-center justify-center text-gray-400">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                            </template>
                                            <template x-if="notification.type === 'reward'">
                                                <div class="h-7 w-7 rounded-full bg-amber-500/20 border border-amber-500/30 flex items-center justify-center text-amber-400">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                            </template>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-xs font-medium text-white truncate max-w-full" x-text="notification.message"></p>
                                            <div class="flex justify-between mt-1">
                                                <p class="text-xs text-gray-400" x-text="notification.time"></p>
                                                <span x-show="notification.link" class="text-xs text-emerald-400 ml-2">View details</span>
                                            </div>
                                        </div>
                                        <div x-show="!notification.read" class="h-2 w-2 rounded-full bg-emerald-500"></div>
                                    </div>
                                </div>
                            </template>
                        </div>
                        <div class="p-2 border-t border-neutral-700 text-center">
                            <div class="text-center">
                                <a href="{{ route('notifications') }}" class="text-xs text-emerald-400 hover:text-emerald-300 transition-colors">View all notifications</a>
                            </div>
                        </div>
                    </div>
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

            // Get challenges as proxy for courses
            $challenges = \App\Models\Challenge::where('is_active', true)
                ->orderBy('required_level', 'asc')
                ->take(5)
                ->get();

            $completedCredits = 0;
            $creditsRequired = 120;

            foreach ($challenges as $challenge) {
                // Get tasks related to this challenge
                $tasks = \App\Models\Task::where('challenge_id', $challenge->id)->get();

                // Calculate completion status
                $totalTasks = $tasks->count();
                $completedTasks = \App\Models\StudentAnswer::where('user_id', $user->id)
                    ->whereIn('task_id', $tasks->pluck('id'))
                    ->where('is_correct', true)
                    ->count();

                $status = 'Not Started';
                if ($completedTasks > 0) {
                    $status = ($completedTasks >= $totalTasks) ? 'Completed' : 'In Progress';
                }

                // Count completed credits
                if ($status === 'Completed') {
                    // Determine credits based on challenge ID
                    if ($challenge->id % 3 === 0) {
                        $completedCredits += 4; // Advanced courses (divisible by 3)
                    } elseif ($challenge->id % 2 === 0) {
                        $completedCredits += 3; // Intermediate courses (divisible by 2 but not 3)
                    } else {
                        $completedCredits += 2; // Basic courses (not divisible by 2 or 3)
                    }
                }
            }

            $creditsCompleted = $completedCredits;
            $completionPercentage = round(($completedCredits / $creditsRequired) * 100, 2);

            // --- Leaderboard Data ---
            $leaderboardData = \App\Models\User::query()
                ->role('student')
                ->join('experiences', 'users.id', '=', 'experiences.user_id')
                ->leftJoin('levels', 'experiences.level_id', '=', 'levels.id')
                ->select([
                    'users.id',
                    'users.name',
                    'experiences.experience_points',
                    'experiences.level_id',
                    'levels.level'
                ])
                ->selectSub(function ($query) {
                    $query->select('created_at')
                        ->from('experience_audits')
                        ->whereColumn('experience_audits.user_id', 'users.id')
                        ->where('experience_audits.type', 'add')
                        ->where('experience_audits.points', '>', 0)
                        ->orderBy('created_at', 'desc')
                        ->limit(1);
                }, 'last_points_earned_at')
                ->selectSub(function ($query) {
                    $query->select('points')
                        ->from('experience_audits')
                        ->whereColumn('experience_audits.user_id', 'users.id')
                        ->where('experience_audits.type', 'add')
                        ->where('experience_audits.points', '>', 0)
                        ->orderBy('created_at', 'desc')
                        ->limit(1);
                }, 'last_points_earned')
                ->orderBy('experiences.experience_points', 'desc')
                ->get()
                ->map(function ($user) {
                    // Convert to the expected object structure
                    return (object)[
                        'user' => (object)[
                            'id' => $user->id,
                            'name' => $user->name
                        ],
                        'experience' => (object)[
                            'level_id' => $user->level_id,
                            'experience_points' => $user->experience_points
                        ],
                        'last_points_earned_at' => $user->last_points_earned_at
                            ? \Carbon\Carbon::parse($user->last_points_earned_at)->setTimezone('Asia/Manila')
                            : null,
                        'last_points_earned' => $user->last_points_earned ?? 0
                    ];
                });
            $userRank = $leaderboardData->search(fn($item) => $item->user->id === $user->id);
            $userRank = ($userRank !== false) ? $userRank + 1 : null;

            // --- Achievements Data ---
            if (!isset($userAchievements)) {
                $userAchievements = $user->getUserAchievements();
            }

            // --- Challenges Data ---
            $activeChallenges = $user->getActiveChallenges()->take(3);
        @endphp

        <!-- Main Content Grid - Improved Mobile Responsiveness -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-4 sm:gap-6">
            <!-- Left Column (Profile + Stats) -->
            <div class="lg:col-span-8 space-y-6">
                <!-- Profile Card with Stats - Progressive Loading -->
                <div x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 100)"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform scale-95"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    class="rounded-2xl border border-neutral-800 bg-neutral-800/50 backdrop-blur-sm shadow-xl overflow-hidden relative group hover:border-neutral-700 transition-all duration-300">
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

                            <!-- Stats Cards - Horizontal Layout -->
                            <div class="flex flex-row flex-wrap md:flex-nowrap gap-3 md:gap-4 md:ml-auto w-full md:w-auto mt-4 md:mt-0 justify-center md:justify-end">
                                <div class="rounded-xl bg-neutral-800/80 border border-neutral-700 p-3 flex items-center gap-3 relative group hover:border-yellow-500/30 hover:bg-neutral-800/90 transition-all duration-300 overflow-hidden w-32">
                                    <div class="absolute inset-0 bg-gradient-to-br from-yellow-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    <div class="absolute -inset-1 bg-yellow-400/10 blur-xl opacity-0 group-hover:opacity-70 transition-opacity duration-300 rounded-full"></div>
                                    <div class="text-yellow-400 relative z-10">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-xs text-gray-400 relative z-10">Score</span>
                                        <span class="text-white font-bold relative z-10 text-lg">{{ $score }}</span>
                                        <span class="text-xs {{ $scoreChange >= 0 ? 'text-green-400' : 'text-red-400' }} relative z-10">
                                            {{ $scoreChange >= 0 ? '+' : '' }}{{ number_format($scoreChange, 2) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="rounded-xl bg-neutral-800/80 border border-neutral-700 p-3 flex items-center gap-3 relative group hover:border-blue-500/30 hover:bg-neutral-800/90 transition-all duration-300 overflow-hidden w-32">
                                    <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    <div class="absolute -inset-1 bg-blue-400/10 blur-xl opacity-0 group-hover:opacity-70 transition-opacity duration-300 rounded-full"></div>
                                    <div class="text-blue-400 relative z-10">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-xs text-gray-400 relative z-10">Attendance</span>
                                        <span class="text-white font-bold relative z-10 text-lg">{{ $attendancePercentage }}%</span>
                                        <span class="text-xs {{ $attendanceChange >= 0 ? 'text-green-400' : 'text-red-400' }} relative z-10">
                                            {{ $attendanceChange >= 0 ? '+' : '' }}{{ $attendanceChange }}%
                                        </span>
                                    </div>
                                </div>
                                <div class="rounded-xl bg-neutral-800/80 border border-neutral-700 p-3 flex items-center gap-3 relative group hover:border-purple-500/30 hover:bg-neutral-800/90 transition-all duration-300 overflow-hidden w-32">
                                    <div class="absolute inset-0 bg-gradient-to-br from-purple-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    <div class="absolute -inset-1 bg-purple-400/10 blur-xl opacity-0 group-hover:opacity-70 transition-opacity duration-300 rounded-full"></div>
                                    <div class="text-purple-400 relative z-10">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 16c1.255 0 2.443-.29 3.5-.804V4.804zM14.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 0114.5 16c1.255 0 2.443-.29 3.5-.804v-10A7.968 7.968 0 0014.5 4z" />
                                        </svg>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-xs text-gray-400 relative z-10">Credits</span>
                                        <span class="text-white font-bold relative z-10 text-lg">{{ $completionPercentage }}%</span>
                                        <span class="text-xs text-gray-400 relative z-10">{{ $creditsCompleted }}/{{ $creditsRequired }}</span>
                                    </div>
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
                                <span
                                    x-data="{
                                        currentPoints: 0,
                                        targetPoints: {{ $currentPoints }},
                                        pointsForNextLevel: {{ $pointsForNextLevel }},
                                        formatNumber(num) {
                                            return new Intl.NumberFormat().format(Math.round(num));
                                        },
                                        init() {
                                            const duration = 1500;
                                            const startTime = performance.now();
                                            const animate = (currentTime) => {
                                                const elapsedTime = currentTime - startTime;
                                                const progress = Math.min(elapsedTime / duration, 1);
                                                // Use cubic-bezier easing similar to the progress bar
                                                const t = progress;
                                                const easedProgress = t < 0.5 ? 4 * t * t * t : 1 - Math.pow(-2 * t + 2, 3) / 2;

                                                this.currentPoints = easedProgress * this.targetPoints;

                                                if (progress < 1) {
                                                    requestAnimationFrame(animate);
                                                }
                                            };
                                            requestAnimationFrame(animate);
                                        }
                                    }"
                                    class="text-xs text-gray-300 font-mono bg-neutral-800/80 px-2 py-0.5 rounded-full relative overflow-hidden group"
                                >
                                    <span class="relative z-10">
                                        <span x-text="formatNumber(currentPoints)"></span> / {{ number_format($pointsForNextLevel) }} XP
                                    </span>
                                    <span class="absolute inset-0 bg-emerald-500/10 transform scale-x-0 group-hover:scale-x-100 origin-left transition-transform duration-700 ease-out"></span>
                                </span>
                            </div>
                            <div class="w-full h-3 bg-neutral-800/80 rounded-full overflow-hidden border border-neutral-700/50">
                                <div
                                    x-data="{
                                        width: 0,
                                        targetWidth: {{ $progressPercentage }},
                                        init() {
                                            const duration = 1500;
                                            const startTime = performance.now();
                                            const animate = (currentTime) => {
                                                const elapsedTime = currentTime - startTime;
                                                const progress = Math.min(elapsedTime / duration, 1);
                                                // Use cubic-bezier easing for smooth animation
                                                const t = progress;
                                                const easedProgress = t < 0.5 ? 4 * t * t * t : 1 - Math.pow(-2 * t + 2, 3) / 2;

                                                this.width = easedProgress * this.targetWidth;

                                                if (progress < 1) {
                                                    requestAnimationFrame(animate);
                                                } else {
                                                    // Ensure we end exactly at the target width
                                                    this.width = this.targetWidth;
                                                }
                                            };
                                            requestAnimationFrame(animate);
                                        }
                                    }"
                                    class="h-full bg-gradient-to-r from-emerald-500 to-teal-400 rounded-full hw-accelerate relative overflow-hidden"
                                    :style="`width: ${width}%;`"
                                    style="width: 0%;"
                                >
                                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white to-transparent opacity-20 animate-shimmer" style="background-size: 200% 100%;"></div>
                                </div>
                            </div>
                            <div class="flex justify-between mt-1">
                                <span class="text-xs text-gray-500 group-hover:text-emerald-500 transition-colors duration-300">Level {{ $currentLevel }}</span>
                                <span class="text-xs text-gray-400 group-hover:text-teal-400 transition-colors duration-300">{{ number_format($xpToNextLevel) }} XP to Level {{ $currentLevel + 1 }}</span>
                            </div>

                            @php
                                // Get the current user's last points earned date and amount for the progress section
                                $progressLastAudit = \Illuminate\Support\Facades\DB::table('experience_audits')
                                    ->where('user_id', $user->id)
                                    ->where('type', 'add')
                                    ->where('points', '>', 0)
                                    ->orderBy('created_at', 'desc')
                                    ->first();

                                $progressLastPointsDate = null;
                                $progressLastPointsEarned = 0;

                                if ($progressLastAudit) {
                                    $progressLastPointsDate = \Carbon\Carbon::parse($progressLastAudit->created_at)->setTimezone('Asia/Manila');
                                    $progressLastPointsEarned = $progressLastAudit->points;
                                }
                            @endphp

                            @if($progressLastPointsDate)
                                <div class="flex justify-center mt-2 pt-2 border-t border-neutral-700/50">
                                    <div class="text-xs bg-neutral-800/60 px-3 py-1.5 rounded-full border border-neutral-700/50 flex items-center gap-2">
                                        <div class="w-1.5 h-1.5 bg-emerald-400 rounded-full animate-pulse"></div>
                                        <span class="text-white">Last earned: {{ $progressLastPointsDate->format('M j, Y') }}</span>
                                        @if($progressLastPointsEarned > 0)
                                            <span class="text-emerald-400 font-medium">+{{ $progressLastPointsEarned }} XP</span>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Activity Graph (Server-Side Rendered) -->
                <div class="rounded-2xl border border-neutral-800 bg-neutral-800/50 backdrop-blur-sm shadow-xl overflow-hidden relative group hover:border-neutral-700 transition-all duration-300" style="min-height: 550px; height: auto;">
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
                            <div class="flex items-center gap-2">
                                <!-- Refresh Activity Button -->
                                <a href="{{ route('refresh-activity') }}" class="flex items-center gap-1 bg-neutral-800/80 px-3 py-1 rounded-full border border-neutral-700/50 shadow-inner hover:bg-neutral-700/80 transition-colors duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-xs text-emerald-400">Refresh</span>
                                </a>
                            </div>
                        </div>

                        <!-- Activity Filters and Time Range -->
                        <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
                            <!-- Activity Type Filter -->
                            <form action="{{ route('dashboard') }}" method="GET" class="flex items-center gap-2">
                                <input type="hidden" name="time_range" value="{{ $selectedTimeRange }}">
                                <div class="flex items-center gap-2 bg-neutral-800/80 px-3 py-1 rounded-full border border-neutral-700/50 shadow-inner">
                                    <div class="text-xs text-gray-400">Filter:</div>
                                    <select name="activity_type" onchange="this.form.submit()" class="bg-transparent text-xs text-white border-0 focus:ring-0 cursor-pointer">
                                        <option value="all" {{ $selectedActivityType == 'all' ? 'selected' : '' }}>All Activity</option>
                                        <option value="logins" {{ $selectedActivityType == 'logins' ? 'selected' : '' }}>Logins</option>
                                        <option value="submissions" {{ $selectedActivityType == 'submissions' ? 'selected' : '' }}>Submissions</option>
                                        <option value="tasks" {{ $selectedActivityType == 'tasks' ? 'selected' : '' }}>Tasks</option>
                                    </select>
                                </div>
                            </form>

                            <!-- Time Range Selector -->
                            <form action="{{ route('dashboard') }}" method="GET" class="flex items-center gap-2">
                                <input type="hidden" name="activity_type" value="{{ $selectedActivityType }}">
                                <div class="flex items-center gap-2 bg-neutral-800/80 px-3 py-1 rounded-full border border-neutral-700/50 shadow-inner">
                                    <div class="text-xs text-gray-400">Time Range:</div>
                                    <select name="time_range" onchange="this.form.submit()" class="bg-transparent text-xs text-white border-0 focus:ring-0 cursor-pointer">
                                        @foreach($timeRanges as $value => $label)
                                            <option value="{{ $value }}" {{ $selectedTimeRange == $value ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </form>

                            <!-- Activity Level Legend -->
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

                        <!-- Status Message -->
                        @if(session('status'))
                            <div class="mb-4 p-3 bg-emerald-500/20 border border-emerald-500/30 rounded-lg text-emerald-400 text-sm flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                {{ session('status') }}
                            </div>
                        @endif

                        <!-- Modern Activity Graph with Weekly Breakdown -->
                        <div x-data="{
                            months: {},
                            activityData: {},
                            init() {
                                // Initialize months as collapsed except for the first one
                                @if(isset($activityData) && isset($activityData['monthly_data']))
                                    @foreach($activityData['monthly_data'] as $month => $data)
                                        this.months['{{ $month }}'] = {{ $loop->first ? 'true' : 'false' }};
                                    @endforeach
                                @else
                                    // Default months if no data available
                                    const currentDate = new Date();
                                    for (let i = 0; i < 6; i++) {
                                        const date = new Date(currentDate);
                                        date.setMonth(currentDate.getMonth() - i);
                                        const monthKey = date.toLocaleString('default', { month: 'long' }) + ' ' + date.getFullYear();
                                        this.months[monthKey] = i === 0;
                                    }
                                @endif
                            },
                            toggleMonth(month) {
                                this.months[month] = !this.months[month];
                            }
                        }" class="space-y-4">
                            <!-- Stats Summary -->
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 bg-neutral-800/30 rounded-xl border border-neutral-700/30 p-4">
                                <div class="text-center">
                                    <p class="text-gray-400 text-sm">Total Activity</p>
                                    <p class="text-2xl font-bold text-white">{{ isset($activityData['total_activity']) ? number_format($activityData['total_activity']) : '0' }}</p>
                                </div>
                                <div class="text-center">
                                    <p class="text-gray-400 text-sm">Weekly Average</p>
                                    <p class="text-2xl font-bold text-white">{{ isset($activityData['weekly_average']) ? number_format($activityData['weekly_average']) : '0' }}</p>
                                </div>
                                <div class="text-center">
                                    <p class="text-gray-400 text-sm">Current Streak</p>
                                    <p class="text-2xl font-bold text-white">{{ $currentLoginStreak }} days</p>
                                </div>
                                <div class="text-center">
                                    <p class="text-gray-400 text-sm">Completion Rate</p>
                                    <p class="text-2xl font-bold text-white">{{ isset($activityData['completion_rate']) ? $activityData['completion_rate'] : '0' }}%</p>
                                </div>
                            </div>

                            <!-- Monthly Activity Breakdown -->
                            @if(isset($activityData) && isset($activityData['monthly_data']))
                                @foreach($activityData['monthly_data'] as $month => $monthData)
                                    <div class="bg-neutral-800/30 rounded-xl border border-neutral-700/30 overflow-hidden">
                                        <!-- Month Header -->
                                        <div class="p-4 border-b border-neutral-700/50 bg-neutral-800/50">
                                            <div class="flex items-center justify-between">
                                                <span class="text-sm font-medium text-gray-300">{{ $month }}</span>
                                                <div class="flex items-center">
                                                    <div class="w-32 h-2 bg-neutral-700/50 rounded-full overflow-hidden mr-3">
                                                        <div class="h-full bg-gradient-to-r from-emerald-400 to-emerald-600 rounded-full" style="width: {{ $monthData['completion_percentage'] }}%"></div>
                                                    </div>
                                                    <span class="text-sm font-medium text-gray-300">{{ $monthData['completion_percentage'] }}%</span>
                                                    <button @click="toggleMonth('{{ $month }}')" class="ml-3 text-emerald-400 hover:text-emerald-300 transition-colors">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" :class="{ 'transform rotate-180': months['{{ $month }}'] }" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Weekly Breakdown -->
                                        <div x-show="months['{{ $month }}']" x-transition class="p-4">
                                            <div class="space-y-3">
                                                @foreach($monthData['weeks'] as $weekNum => $weekData)
                                                    <div>
                                                        <div class="flex items-center justify-between mb-1">
                                                            <span class="text-xs text-gray-500">Week {{ $weekNum }}</span>
                                                            <span class="text-xs text-gray-500">{{ $weekData['date_range'] }}</span>
                                                        </div>
                                                        <div class="flex items-center">
                                                            <div class="flex-1 h-1.5 bg-neutral-700/50 rounded-full overflow-hidden">
                                                                <div class="h-full bg-emerald-500 rounded-full" style="width: {{ $weekData['completion_percentage'] }}%"></div>
                                                            </div>
                                                            <span class="ml-3 text-xs font-medium text-gray-400">{{ $weekData['completion_percentage'] }}%</span>
                                                        </div>
                                                        <!-- Daily dots -->
                                                        <div class="flex space-x-1 mt-1.5">
                                                            @foreach($weekData['days'] as $day)
                                                                @php
                                                                    $bgColor = 'bg-neutral-700';
                                                                    if ($day['activity_level'] === 1) $bgColor = 'bg-emerald-900';
                                                                    if ($day['activity_level'] === 2) $bgColor = 'bg-emerald-700';
                                                                    if ($day['activity_level'] === 3) $bgColor = 'bg-emerald-500';
                                                                    if ($day['activity_level'] >= 4) $bgColor = 'bg-emerald-300';
                                                                @endphp
                                                                <div class="w-1.5 h-1.5 rounded-full {{ $bgColor }}" title="{{ $day['date'] }}: {{ $day['activity_count'] }} activities"></div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <!-- Collapsed State -->
                                        <div x-show="!months['{{ $month }}']" class="p-4 text-center">
                                            <button @click="toggleMonth('{{ $month }}')" class="text-xs text-emerald-500 font-medium hover:text-emerald-400 transition-colors">
                                                Click to expand weekly breakdown
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <!-- Fallback for when no activity data is available -->
                                <div class="bg-neutral-800/30 rounded-xl border border-neutral-700/30 p-6 text-center">
                                    <p class="text-gray-400 mb-2">No activity data available yet.</p>
                                    <a href="{{ route('refresh-activity') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 rounded-lg text-white transition-colors shadow-lg shadow-emerald-900/30">
                                        Refresh Activity Data
                                    </a>
                                </div>
                            @endif

                            <!-- Activity Goals Section -->
                            <div class="mt-4">
                                {!! $weeklySummaryHtml !!}
                            </div>
                        </div>
                    </div>
                </div>



                <!-- Active Challenges with Skeleton Loading -->
                <div x-data="{ loading: true }" x-init="setTimeout(() => loading = false, 1000)" class="rounded-2xl border border-neutral-800 bg-neutral-800/50 backdrop-blur-sm shadow-xl overflow-hidden relative group hover:border-neutral-700 transition-all duration-300">
                    <!-- Skeleton Loading State -->
                    <div x-show="loading" class="absolute inset-0 z-20 flex flex-col p-6 space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="h-5 w-5 rounded-full bg-neutral-700/70 animate-pulse"></div>
                                <div class="h-6 w-40 rounded-md bg-neutral-700/70 animate-pulse"></div>
                            </div>
                            <div class="h-6 w-20 rounded-md bg-neutral-700/70 animate-pulse"></div>
                        </div>
                        <div class="space-y-4">
                            <template x-for="i in 3">
                                <div class="p-4 rounded-xl bg-neutral-700/50 animate-pulse space-y-3">
                                    <div class="flex justify-between">
                                        <div class="h-5 w-32 rounded-md bg-neutral-700/70 animate-pulse"></div>
                                        <div class="h-5 w-16 rounded-md bg-neutral-700/70 animate-pulse"></div>
                                    </div>
                                    <div class="h-2 w-full rounded-full bg-neutral-700/70 animate-pulse"></div>
                                    <div class="h-4 w-3/4 rounded-md bg-neutral-700/70 animate-pulse"></div>
                                </div>
                            </template>
                        </div>
                    </div>
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
                                                <span
                                                    x-data="{
                                                        progress: 0,
                                                        targetProgress: {{ $challenge->pivot->progress ?? 0 }},
                                                        init() {
                                                            const duration = 1500;
                                                            const startTime = performance.now();
                                                            const animate = (currentTime) => {
                                                                const elapsedTime = currentTime - startTime;
                                                                const progress = Math.min(elapsedTime / duration, 1);
                                                                const easedProgress = progress < 0.5 ? 4 * progress * progress * progress : 1 - Math.pow(-2 * progress + 2, 3) / 2;

                                                                this.progress = Math.round(easedProgress * this.targetProgress);

                                                                if (progress < 1) {
                                                                    requestAnimationFrame(animate);
                                                                }
                                                            };
                                                            requestAnimationFrame(animate);
                                                        }
                                                    }"
                                                    class="text-xs font-semibold px-2 py-1 rounded-full {{ ($challenge->pivot->progress ?? 0) >= 100 ? 'bg-green-500/20 text-green-400 group-hover:bg-green-500/30' : 'bg-orange-500/20 text-orange-400 group-hover:bg-orange-500/30' }} transition-colors duration-300"
                                                >
                                                    <span x-text="progress"></span>% Complete
                                                </span>
                                            </div>
                                            <div class="w-full bg-neutral-800/80 rounded-full h-2 overflow-hidden border border-neutral-700/50">
                                                <div
                                                    x-data="{
                                                        width: 0,
                                                        targetWidth: {{ $challenge->pivot->progress ?? 0 }},
                                                        init() {
                                                            const duration = 1500;
                                                            const startTime = performance.now();
                                                            const animate = (currentTime) => {
                                                                const elapsedTime = currentTime - startTime;
                                                                const progress = Math.min(elapsedTime / duration, 1);
                                                                // Use cubic-bezier easing for smooth animation
                                                                const t = progress;
                                                                const easedProgress = t < 0.5 ? 4 * t * t * t : 1 - Math.pow(-2 * t + 2, 3) / 2;

                                                                this.width = easedProgress * this.targetWidth;

                                                                if (progress < 1) {
                                                                    requestAnimationFrame(animate);
                                                                } else {
                                                                    // Ensure we end exactly at the target width
                                                                    this.width = this.targetWidth;
                                                                }
                                                            };
                                                            requestAnimationFrame(animate);
                                                        }
                                                    }"
                                                    class="bg-gradient-to-r from-orange-500 to-yellow-500 h-2 rounded-full hw-accelerate relative overflow-hidden"
                                                    :style="`width: ${width}%;`"
                                                    style="width: 0%;"
                                                >
                                                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white to-transparent opacity-20 animate-shimmer" style="background-size: 200% 100%;"></div>
                                                </div>
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

                <!-- Keyboard Shortcuts Help -->
                <div x-data="{ showShortcuts: false }" class="rounded-2xl border border-neutral-800 bg-neutral-800/50 backdrop-blur-sm shadow-xl overflow-hidden relative group hover:border-neutral-700 transition-all duration-300 mt-6">
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(139,92,246,0.1),transparent_70%)] opacity-70 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-purple-500/0 via-purple-500/5 to-purple-500/0 rounded-xl opacity-0 group-hover:opacity-100 blur-xl transition-opacity duration-500 group-hover:duration-200"></div>
                    <div class="p-6 relative z-10">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                                <div class="relative">
                                    <div class="absolute -inset-1 bg-purple-500/20 rounded-full blur-sm opacity-70"></div>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-400 relative" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <span class="text-white bg-clip-text bg-gradient-to-r from-purple-400 to-indigo-400">Keyboard Shortcuts</span>
                            </h3>
                            <button @click="showShortcuts = !showShortcuts" class="text-xs text-purple-400 hover:text-purple-300 transition-colors duration-300">
                                <span x-text="showShortcuts ? 'Hide' : 'Show'"></span>
                            </button>
                        </div>
                        <div x-show="showShortcuts" x-transition class="space-y-2">
                            <div class="grid grid-cols-2 gap-2">
                                <div class="p-2 rounded-lg bg-neutral-800/80 border border-neutral-700/50">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-neutral-300">Learning</span>
                                        <span class="text-xs font-medium px-2 py-1 rounded-full bg-neutral-700/50 text-neutral-400 border border-neutral-700/50">Alt + L</span>
                                    </div>
                                </div>
                                <div class="p-2 rounded-lg bg-neutral-800/80 border border-neutral-700/50">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-neutral-300">Profile</span>
                                        <span class="text-xs font-medium px-2 py-1 rounded-full bg-neutral-700/50 text-neutral-400 border border-neutral-700/50">Alt + P</span>
                                    </div>
                                </div>
                                <div class="p-2 rounded-lg bg-neutral-800/80 border border-neutral-700/50">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-neutral-300">Grades</span>
                                        <span class="text-xs font-medium px-2 py-1 rounded-full bg-neutral-700/50 text-neutral-400 border border-neutral-700/50">Alt + G</span>
                                    </div>
                                </div>
                                <div class="p-2 rounded-lg bg-neutral-800/80 border border-neutral-700/50">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-neutral-300">Schedule</span>
                                        <span class="text-xs font-medium px-2 py-1 rounded-full bg-neutral-700/50 text-neutral-400 border border-neutral-700/50">Alt + S</span>
                                    </div>
                                </div>
                                <div class="p-2 rounded-lg bg-neutral-800/80 border border-neutral-700/50">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-neutral-300">Forums</span>
                                        <span class="text-xs font-medium px-2 py-1 rounded-full bg-neutral-700/50 text-neutral-400 border border-neutral-700/50">Alt + F</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

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

                <!-- Achievements -->
                <div class="rounded-2xl border border-neutral-800 bg-neutral-800/50 backdrop-blur-sm shadow-xl overflow-hidden relative group hover:border-neutral-700 transition-all duration-300 mt-6">
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
                                <div
                                    onclick="Livewire.dispatch('openUserActivityModal', { userId: {{ $entry->user->id }} })"
                                    class="flex items-center p-3 rounded-xl {{ $entry->user->id === $user->id ? 'bg-emerald-500/10 border border-emerald-500/30 hover:bg-emerald-500/15' : 'bg-neutral-700/20 border border-neutral-700/50 hover:bg-neutral-700/30' }} transition-all duration-300 group relative overflow-hidden cursor-pointer"
                                >
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
                                        <div class="flex items-center justify-between mt-1">
                                            <div class="flex items-center">
                                                <div class="text-xs text-gray-400 group-hover:text-gray-300 transition-colors duration-300">Level {{ $entry->experience->level_id ?? 1 }}</div>
                                                <div class="ml-2 w-20 bg-neutral-800/80 rounded-full h-1.5 overflow-hidden backdrop-blur-sm border border-neutral-700/50 shadow-inner">
                                                    <div class="bg-gradient-to-r from-emerald-500 to-teal-500 h-1.5 rounded-full relative" style="width: 70%">
                                                        <div class="absolute inset-0 bg-[linear-gradient(45deg,rgba(255,255,255,0)_25%,rgba(255,255,255,0.1)_50%,rgba(255,255,255,0)_75%)] bg-[length:200%_100%] opacity-0 group-hover:opacity-100 group-hover:animate-shimmer"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            @if($entry->last_points_earned_at)
                                                <div class="text-xs text-gray-500 group-hover:text-gray-400 transition-colors duration-300">
                                                    {{ $entry->last_points_earned_at->format('M j, Y') }}
                                                    @if($entry->last_points_earned > 0)
                                                        <span class="text-emerald-400 font-medium">+{{ $entry->last_points_earned }} XP</span>
                                                    @endif
                                                </div>
                                            @endif
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
                                    <div
                                        onclick="Livewire.dispatch('openUserActivityModal', { userId: {{ $user->id }} })"
                                        class="flex items-center p-3 rounded-xl bg-emerald-500/10 border border-emerald-500/30 hover:bg-emerald-500/15 transition-all duration-300 group relative overflow-hidden cursor-pointer"
                                    >
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
                                            <div class="flex items-center justify-between mt-1">
                                                <div class="flex items-center">
                                                    <div class="text-xs text-gray-400 group-hover:text-gray-300 transition-colors duration-300">Level {{ $currentLevel }}</div>
                                                    <div class="ml-2 w-20 bg-neutral-800/80 rounded-full h-1.5 overflow-hidden border border-neutral-700/50">
                                                        <div
                                                            x-data="{
                                                                width: 0,
                                                                targetWidth: {{ $progressPercentage }},
                                                                init() {
                                                                    const duration = 1500;
                                                                    const startTime = performance.now();
                                                                    const animate = (currentTime) => {
                                                                        const elapsedTime = currentTime - startTime;
                                                                        const progress = Math.min(elapsedTime / duration, 1);
                                                                        // Use cubic-bezier easing for smooth animation
                                                                        const t = progress;
                                                                        const easedProgress = t < 0.5 ? 4 * t * t * t : 1 - Math.pow(-2 * t + 2, 3) / 2;

                                                                        this.width = easedProgress * this.targetWidth;

                                                                        if (progress < 1) {
                                                                            requestAnimationFrame(animate);
                                                                        } else {
                                                                            // Ensure we end exactly at the target width
                                                                            this.width = this.targetWidth;
                                                                        }
                                                                    };
                                                                    requestAnimationFrame(animate);
                                                                }
                                                            }"
                                                            class="bg-gradient-to-r from-emerald-500 to-teal-500 h-1.5 rounded-full hw-accelerate relative overflow-hidden"
                                                            :style="`width: ${width}%;`"
                                                            style="width: 0%;"
                                                        >
                                                            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white to-transparent opacity-20 animate-shimmer" style="background-size: 200% 100%;"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @php
                                                    // Get the current user's last points earned date and amount directly from the database
                                                    $userLastAudit = \Illuminate\Support\Facades\DB::table('experience_audits')
                                                        ->where('user_id', $user->id)
                                                        ->where('type', 'add')
                                                        ->where('points', '>', 0)
                                                        ->orderBy('created_at', 'desc')
                                                        ->first();

                                                    $userLastPointsDate = null;
                                                    $userLastPointsEarned = 0;

                                                    if ($userLastAudit) {
                                                        $userLastPointsDate = \Carbon\Carbon::parse($userLastAudit->created_at)->setTimezone('Asia/Manila');
                                                        $userLastPointsEarned = $userLastAudit->points;
                                                    }
                                                @endphp
                                                @if($userLastPointsDate)
                                                    <div class="text-xs text-gray-500 group-hover:text-gray-400 transition-colors duration-300">
                                                        {{ $userLastPointsDate->format('M j, Y') }}
                                                        @if($userLastPointsEarned > 0)
                                                            <span class="text-emerald-400 font-medium">+{{ $userLastPointsEarned }} XP</span>
                                                        @endif
                                                    </div>
                                                @endif
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

    <!-- Activity graph is now server-side rendered -->

    <!-- Keyboard Shortcuts -->
    <script>
        // Keyboard shortcuts for quick navigation
        document.addEventListener('keydown', function(e) {
            // Only trigger shortcuts if no input is focused
            if (document.activeElement.tagName !== 'INPUT' && document.activeElement.tagName !== 'TEXTAREA') {
                // Alt+L to go to Learning page
                if (e.altKey && e.key === 'l') {
                    window.location.href = '{{ route("learning") }}';
                }
                // Alt+P to go to Profile page
                if (e.altKey && e.key === 'p') {
                    window.location.href = '{{ route("profile") }}';
                }
                // Alt+G to go to Grades page
                if (e.altKey && e.key === 'g') {
                    window.location.href = '{{ route("grades") }}';
                }
                // Alt+S to go to Schedule page
                if (e.altKey && e.key === 's') {
                    window.location.href = '{{ route("schedule") }}';
                }
                // Alt+F to go to Forums page
                if (e.altKey && e.key === 'f') {
                    window.location.href = '{{ route("forums") }}';
                }
            }
        });
    </script>

    <style>
        /* Further optimized animations with reduced performance impact */
        @keyframes shimmer {
            0% { background-position: 200% 0; }
            100% { background-position: 0 0; }
        }
        .animate-shimmer {
            animation: shimmer 4s infinite linear;
            will-change: transform;
        }

        /* Optimized pulse animation with fewer keyframes and longer duration */
        @keyframes pulse-slow {
            50% { opacity: 1; }
        }
        .animate-pulse-slow {
            opacity: 0.7;
            animation: pulse-slow 6s infinite ease-in-out;
        }

        /* Progress bar fill animation */
        @keyframes progress-fill {
            0% { width: 0%; }
            20% { width: 0%; } /* Hold at 0% briefly */
            90% { width: calc(var(--progress-percentage) * 1.05); } /* Slightly overshoot */
            100% { width: var(--progress-percentage); } /* Settle at exact percentage */
        }
        .animate-progress-fill {
            animation: progress-fill 2s cubic-bezier(0.25, 0.1, 0.25, 1) forwards;
            background-size: 200% 100%;
            background-position: 0 0;
        }

        /* Progress bar shine effect */
        @keyframes shimmer {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
        .animate-shimmer {
            animation: shimmer 3s infinite linear;
            animation-delay: 1.5s;
        }

        /* Number counter animation */
        @keyframes count-up {
            0% {
                content: "0";
                opacity: 0.7;
            }
            20% {
                content: "0";
                opacity: 1;
            }
            100% {
                content: attr(data-count);
                opacity: 1;
            }
        }
        .animate-count::after {
            content: attr(data-count);
            animation: count-up 2s forwards cubic-bezier(0.25, 0.1, 0.25, 1);
        }

        /* Selective hardware acceleration */
        .hw-accelerate {
            will-change: transform;
            transform: translateZ(0);
        }

        /* Reduce animation on mobile */
        @media (max-width: 768px) {
            .animate-pulse-slow {
                animation-duration: 8s;
            }
            .animate-shimmer {
                animation-duration: 6s;
            }
        }
    </style>

    <!-- Task and recipe approval notifications are now handled by global Livewire components -->
</x-layouts.app>