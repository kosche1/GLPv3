<x-layouts.app>
    <!-- Meta tags for real-time functionality -->
    <meta name="user-id" content="{{ auth()->id() }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
                <!-- Internet Connection Status -->
                <div x-data="{
                    isOnline: navigator.onLine,
                    init() {
                        // Listen for online/offline events
                        window.addEventListener('online', () => {
                            this.isOnline = true;
                        });
                        window.addEventListener('offline', () => {
                            this.isOnline = false;
                        });

                        // Check connectivity every 30 seconds
                        setInterval(() => {
                            this.checkConnection();
                        }, 30000);
                    },
                    checkConnection() {
                        // Simple connectivity check using fetch with timeout
                        const controller = new AbortController();
                        const timeoutId = setTimeout(() => controller.abort(), 5000);

                        fetch('/ping', {
                            method: 'HEAD',
                            signal: controller.signal,
                            cache: 'no-cache'
                        })
                        .then(() => {
                            clearTimeout(timeoutId);
                            this.isOnline = true;
                        })
                        .catch(() => {
                            clearTimeout(timeoutId);
                            this.isOnline = false;
                        });
                    }
                }" class="flex items-center gap-2 bg-neutral-800/50 px-3 py-1.5 rounded-full border border-neutral-700/50 shadow-lg backdrop-blur-sm">
                    <div class="connection-status">
                        <div x-show="isOnline" class="w-2 h-2 rounded-full bg-green-400"></div>
                        <div x-show="!isOnline" class="w-2 h-2 rounded-full bg-red-400 animate-pulse"></div>
                    </div>
                    <span x-show="isOnline" class="text-xs text-green-400">Connected</span>
                    <span x-show="!isOnline" class="text-xs text-red-400">Offline</span>
                </div>

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
                        <span x-show="getUnreadCount() > 0" x-text="getUnreadCount()" class="notification-badge absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center"></span>
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

            // --- Badges Data ---
            $userBadges = $user->badges()
                ->orderBy('user_badges.earned_at', 'desc')
                ->get();

            $showcasedBadges = $userBadges->where('pivot.is_showcased', true)->take(3);
            $recentBadges = $userBadges->take(6);

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

                <!-- Badges & Achievements Showcase -->
                <div class="rounded-2xl border border-neutral-800 bg-neutral-800/50 backdrop-blur-sm shadow-xl overflow-hidden relative group hover:border-neutral-700 transition-all duration-300">
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(168,85,247,0.1),transparent_70%)] opacity-70 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-purple-500/0 via-purple-500/5 to-purple-500/0 rounded-xl opacity-0 group-hover:opacity-100 blur-xl transition-opacity duration-500 group-hover:duration-200"></div>
                    <div class="absolute inset-0 -z-10 bg-[linear-gradient(to_right,rgba(168,85,247,0.01)_1px,transparent_1px),linear-gradient(to_bottom,rgba(168,85,247,0.01)_1px,transparent_1px)] bg-[size:20px_20px] opacity-10"></div>
                    <div class="p-6 h-full relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                                <div class="relative">
                                    <div class="absolute -inset-1 bg-purple-500/20 rounded-full blur-sm opacity-70"></div>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-400 relative" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-400">Badges & Achievements</span>
                            </h3>
                        </div>

                        @if((isset($userBadges) && $userBadges->isNotEmpty()) || (isset($userAchievements) && $userAchievements->isNotEmpty()))
                            <div class="grid grid-cols-2 gap-4">
                                <!-- Badges Section -->
                                <div class="space-y-3">
                                    <div class="flex items-center gap-2">
                                        <div class="w-2 h-2 rounded-full bg-blue-400"></div>
                                        <h4 class="text-sm font-semibold text-blue-400">Recent Badges</h4>
                                        @if(isset($userBadges) && $userBadges->count() > 3)
                                            <span class="text-xs text-gray-500 bg-neutral-800/60 px-2 py-0.5 rounded-full">+{{ $userBadges->count() - 3 }} more</span>
                                        @endif
                                    </div>
                                    @if(isset($userBadges) && $userBadges->isNotEmpty())
                                        <div class="grid grid-cols-3 gap-2">
                                            @foreach($userBadges->take(3) as $badge)
                                                <div
                                                    class="group relative rounded-lg bg-neutral-700/20 border border-neutral-700/50 p-3 hover:bg-neutral-700/30 hover:border-blue-500/30 transition-all duration-300 transform hover:scale-105 cursor-pointer"
                                                    title="{{ $badge->description }}"
                                                    x-data="{ showTooltip: false }"
                                                    @mouseenter="showTooltip = true"
                                                    @mouseleave="showTooltip = false"
                                                >
                                                    <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-lg"></div>
                                                    <div class="relative z-10 flex flex-col items-center">
                                                        @if($badge->image)
                                                            <img src="{{ asset($badge->image) }}" alt="{{ $badge->name }}" class="h-8 w-8 object-contain mb-1">
                                                        @else
                                                            <div class="h-8 w-8 rounded-full bg-gradient-to-br from-blue-500/20 to-cyan-500/20 border border-blue-500/30 flex items-center justify-center mb-1 group-hover:border-blue-500/50 transition-colors duration-300">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                                                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                                </svg>
                                                            </div>
                                                        @endif
                                                        <p class="text-xs text-gray-200 font-medium text-center leading-tight group-hover:text-blue-300 transition-colors duration-300">{{ Str::limit($badge->name, 12) }}</p>
                                                        @php
                                                            $rarityColors = [
                                                                1 => 'bg-gray-500/20 text-gray-400',
                                                                2 => 'bg-green-500/20 text-green-400',
                                                                3 => 'bg-blue-500/20 text-blue-400',
                                                                4 => 'bg-purple-500/20 text-purple-400',
                                                                5 => 'bg-yellow-500/20 text-yellow-400'
                                                            ];
                                                            $rarityNames = [1 => 'Common', 2 => 'Uncommon', 3 => 'Rare', 4 => 'Epic', 5 => 'Legendary'];
                                                        @endphp
                                                        <span class="text-[10px] px-1.5 py-0.5 rounded-full mt-1 {{ $rarityColors[$badge->rarity_level] ?? $rarityColors[1] }}">
                                                            {{ $rarityNames[$badge->rarity_level] ?? 'Common' }}
                                                        </span>
                                                    </div>

                                                    <!-- Tooltip -->
                                                    <div
                                                        x-show="showTooltip"
                                                        x-transition:enter="transition ease-out duration-200"
                                                        x-transition:enter-start="opacity-0 transform scale-95"
                                                        x-transition:enter-end="opacity-100 transform scale-100"
                                                        x-transition:leave="transition ease-in duration-150"
                                                        x-transition:leave-start="opacity-100 transform scale-100"
                                                        x-transition:leave-end="opacity-0 transform scale-95"
                                                        class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-neutral-900 text-white text-xs rounded-lg shadow-lg border border-neutral-700 whitespace-nowrap z-50"
                                                        style="display: none;"
                                                    >
                                                        {{ $badge->description }}
                                                        <div class="absolute top-full left-1/2 transform -translate-x-1/2 w-0 h-0 border-l-4 border-r-4 border-t-4 border-transparent border-t-neutral-900"></div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="text-center py-4">
                                            <div class="w-12 h-12 mx-auto rounded-full bg-blue-500/10 flex items-center justify-center mb-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <p class="text-xs text-gray-400">No badges yet</p>
                                        </div>
                                    @endif
                                </div>

                                <!-- Achievements Section -->
                                <div class="space-y-3">
                                    <div class="flex items-center gap-2">
                                        <div class="w-2 h-2 rounded-full bg-purple-400"></div>
                                        <h4 class="text-sm font-semibold text-purple-400">Recent Achievements</h4>
                                        @if(isset($userAchievements) && $userAchievements->count() > 3)
                                            <span class="text-xs text-gray-500 bg-neutral-800/60 px-2 py-0.5 rounded-full">+{{ $userAchievements->count() - 3 }} more</span>
                                        @endif
                                    </div>
                                    @if(isset($userAchievements) && $userAchievements->isNotEmpty())
                                        <div class="grid grid-cols-3 gap-2">
                                            @foreach($userAchievements->take(3) as $achievement)
                                                <div
                                                    class="group relative rounded-lg bg-neutral-700/20 border border-neutral-700/50 p-3 hover:bg-neutral-700/30 hover:border-purple-500/30 transition-all duration-300 transform hover:scale-105 cursor-pointer"
                                                    title="{{ $achievement->description }}"
                                                    x-data="{ showTooltip: false }"
                                                    @mouseenter="showTooltip = true"
                                                    @mouseleave="showTooltip = false"
                                                >
                                                    <div class="absolute inset-0 bg-gradient-to-br from-purple-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-lg"></div>
                                                    <div class="relative z-10 flex flex-col items-center">
                                                        @if($achievement->image)
                                                            <img src="{{ asset($achievement->image) }}" alt="{{ $achievement->name }}" class="h-8 w-8 object-contain mb-1">
                                                        @else
                                                            <div class="h-8 w-8 rounded-full bg-gradient-to-br from-purple-500/20 to-indigo-500/20 border border-purple-500/30 flex items-center justify-center mb-1 group-hover:border-purple-500/50 transition-colors duration-300">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-purple-400" viewBox="0 0 20 20" fill="currentColor">
                                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                                </svg>
                                                            </div>
                                                        @endif
                                                        <p class="text-xs text-gray-200 font-medium text-center leading-tight group-hover:text-purple-300 transition-colors duration-300">{{ Str::limit($achievement->name, 12) }}</p>
                                                        @if(isset($achievement->pivot) && isset($achievement->pivot->progress))
                                                            <div class="w-full mt-1">
                                                                <div class="w-full bg-neutral-800/80 rounded-full h-1 overflow-hidden">
                                                                    <div class="bg-gradient-to-r from-purple-500 to-indigo-500 h-1 rounded-full" style="width: {{ $achievement->pivot->progress }}%"></div>
                                                                </div>
                                                                <span class="text-[10px] text-purple-400 mt-0.5">{{ $achievement->pivot->progress }}%</span>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <!-- Tooltip -->
                                                    <div
                                                        x-show="showTooltip"
                                                        x-transition:enter="transition ease-out duration-200"
                                                        x-transition:enter-start="opacity-0 transform scale-95"
                                                        x-transition:enter-end="opacity-100 transform scale-100"
                                                        x-transition:leave="transition ease-in duration-150"
                                                        x-transition:leave-start="opacity-100 transform scale-100"
                                                        x-transition:leave-end="opacity-0 transform scale-95"
                                                        class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-neutral-900 text-white text-xs rounded-lg shadow-lg border border-neutral-700 whitespace-nowrap z-50"
                                                        style="display: none;"
                                                    >
                                                        {{ $achievement->description }}
                                                        <div class="absolute top-full left-1/2 transform -translate-x-1/2 w-0 h-0 border-l-4 border-r-4 border-t-4 border-transparent border-t-neutral-900"></div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="text-center py-4">
                                            <div class="w-12 h-12 mx-auto rounded-full bg-purple-500/10 flex items-center justify-center mb-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-400" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" />
                                                </svg>
                                            </div>
                                            <p class="text-xs text-gray-400">No achievements yet</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @else
                            <!-- Empty State -->
                            <div class="text-center py-8">
                                <div class="flex justify-center space-x-4 mb-4">
                                    <div class="w-16 h-16 rounded-full bg-blue-500/10 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="w-16 h-16 rounded-full bg-purple-500/10 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" />
                                        </svg>
                                    </div>
                                </div>
                                <p class="text-gray-400 text-sm mb-4">Complete challenges and level up to earn amazing badges and achievements</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Recent Activities -->
                <div class="rounded-2xl border border-neutral-800 bg-neutral-800/50 backdrop-blur-sm shadow-xl overflow-hidden relative group hover:border-neutral-700 transition-all duration-300">
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(16,185,129,0.15),transparent_70%)] opacity-70 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-emerald-500/0 via-emerald-500/5 to-emerald-500/0 rounded-xl opacity-0 group-hover:opacity-100 blur-xl transition-opacity duration-500 group-hover:duration-200"></div>
                    <div class="absolute inset-0 -z-10 bg-[linear-gradient(to_right,rgba(16,185,129,0.01)_1px,transparent_1px),linear-gradient(to_bottom,rgba(16,185,129,0.01)_1px,transparent_1px)] bg-[size:20px_20px] opacity-10"></div>
                    <div class="p-6 h-full relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                                <div class="relative">
                                    <div class="absolute -inset-1 bg-emerald-500/20 rounded-full blur-sm opacity-70"></div>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400 relative" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-teal-400">Recent Activities</span>
                            </h3>
                        </div>

                        @php
                            // Get recent activities for the current user
                            $recentActivities = collect();

                            // Get recent student answers (submissions)
                            $recentSubmissions = \App\Models\StudentAnswer::where('user_id', auth()->id())
                                ->with('task.challenge')
                                ->latest()
                                ->take(5)
                                ->get()
                                ->map(function($answer) {
                                    return (object)[
                                        'type' => 'submission',
                                        'title' => 'Submitted answer for: ' . ($answer->task->challenge->name ?? 'Unknown Challenge'),
                                        'description' => $answer->is_correct ? 'Correct answer' : 'Incorrect answer',
                                        'created_at' => $answer->created_at,
                                        'icon' => $answer->is_correct ? 'check-circle' : 'x-circle',
                                        'color' => $answer->is_correct ? 'emerald' : 'red'
                                    ];
                                });

                            // Get recent login activities
                            $recentLogins = \App\Models\StudentAttendance::where('user_id', auth()->id())
                                ->latest()
                                ->take(3)
                                ->get()
                                ->map(function($attendance) {
                                    return (object)[
                                        'type' => 'login',
                                        'title' => 'Logged in to the system',
                                        'description' => 'Login count: ' . $attendance->login_count,
                                        'created_at' => $attendance->date,
                                        'icon' => 'login',
                                        'color' => 'blue'
                                    ];
                                });

                            // Get recent experience gains
                            $recentExperience = \Illuminate\Support\Facades\DB::table('experience_audits')
                                ->where('user_id', auth()->id())
                                ->where('type', 'add')
                                ->where('points', '>', 0)
                                ->latest('created_at')
                                ->take(3)
                                ->get()
                                ->map(function($audit) {
                                    return (object)[
                                        'type' => 'experience',
                                        'title' => 'Gained experience points',
                                        'description' => '+' . $audit->points . ' XP - ' . ($audit->reason ?? 'Activity completed'),
                                        'created_at' => \Carbon\Carbon::parse($audit->created_at),
                                        'icon' => 'star',
                                        'color' => 'yellow'
                                    ];
                                });

                            // Combine and sort all activities
                            $recentActivities = $recentSubmissions
                                ->concat($recentLogins)
                                ->concat($recentExperience)
                                ->sortByDesc('created_at')
                                ->take(8);

                            // Calculate metrics for cards
                            $todayLogins = \App\Models\StudentAttendance::where('user_id', auth()->id())
                                ->whereDate('date', today())
                                ->sum('login_count');

                            $tasksThisWeek = \App\Models\StudentAnswer::where('user_id', auth()->id())
                                ->where('is_correct', true)
                                ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                                ->count();
                        @endphp

                        <!-- Activity Metrics Cards -->
                        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-6">
                            <!-- Current Level Card -->
                            <div class="bg-gradient-to-br from-emerald-500/10 to-emerald-600/5 border border-emerald-500/20 rounded-xl p-3 sm:p-4 hover:border-emerald-500/30 transition-all duration-300 group">
                                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-3">
                                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-emerald-500/20 border border-emerald-500/30 flex items-center justify-center group-hover:scale-105 transition-transform duration-300 flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 text-emerald-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-xs text-gray-400 font-medium truncate">Current Level</p>
                                        <p class="text-lg sm:text-xl font-bold text-white">{{ $currentLevel }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Today's Logins Card -->
                            <div class="bg-gradient-to-br from-blue-500/10 to-blue-600/5 border border-blue-500/20 rounded-xl p-3 sm:p-4 hover:border-blue-500/30 transition-all duration-300 group">
                                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-3">
                                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-blue-500/20 border border-blue-500/30 flex items-center justify-center group-hover:scale-105 transition-transform duration-300 flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M3 3a1 1 0 011 1v12a1 1 0 11-2 0V4a1 1 0 011-1zm7.707 3.293a1 1 0 010 1.414L9.414 9H17a1 1 0 110 2H9.414l1.293 1.293a1 1 0 01-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-xs text-gray-400 font-medium truncate">Today's Logins</p>
                                        <p class="text-lg sm:text-xl font-bold text-white">{{ $todayLogins }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Tasks This Week Card -->
                            <div class="bg-gradient-to-br from-purple-500/10 to-purple-600/5 border border-purple-500/20 rounded-xl p-3 sm:p-4 hover:border-purple-500/30 transition-all duration-300 group">
                                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-3">
                                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-purple-500/20 border border-purple-500/30 flex items-center justify-center group-hover:scale-105 transition-transform duration-300 flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 text-purple-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-xs text-gray-400 font-medium truncate">Tasks This Week</p>
                                        <p class="text-lg sm:text-xl font-bold text-white">{{ $tasksThisWeek }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Current Streak Card -->
                            <div class="bg-gradient-to-br from-orange-500/10 to-orange-600/5 border border-orange-500/20 rounded-xl p-3 sm:p-4 hover:border-orange-500/30 transition-all duration-300 group">
                                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-3">
                                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-orange-500/20 border border-orange-500/30 flex items-center justify-center group-hover:scale-105 transition-transform duration-300 flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 text-orange-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-xs text-gray-400 font-medium truncate">Current Streak</p>
                                        <p class="text-lg sm:text-xl font-bold text-white">{{ $currentLoginStreak }} <span class="text-sm text-gray-400">days</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Activities List -->
                        <div class="space-y-3">
                            @forelse($recentActivities as $activity)
                                <div class="flex items-start gap-3 p-3 rounded-xl bg-neutral-700/20 border border-neutral-700/50 hover:bg-neutral-700/30 hover:border-emerald-500/30 transition-all duration-200 group">
                                    <div class="flex-shrink-0 mt-0.5">
                                        @if($activity->icon === 'check-circle')
                                            <div class="w-8 h-8 rounded-full bg-emerald-500/20 border border-emerald-500/30 flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        @elseif($activity->icon === 'x-circle')
                                            <div class="w-8 h-8 rounded-full bg-red-500/20 border border-red-500/30 flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        @elseif($activity->icon === 'login')
                                            <div class="w-8 h-8 rounded-full bg-blue-500/20 border border-blue-500/30 flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M3 3a1 1 0 011 1v12a1 1 0 11-2 0V4a1 1 0 011-1zm7.707 3.293a1 1 0 010 1.414L9.414 9H17a1 1 0 110 2H9.414l1.293 1.293a1 1 0 01-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        @elseif($activity->icon === 'star')
                                            <div class="w-8 h-8 rounded-full bg-yellow-500/20 border border-yellow-500/30 flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                            </div>
                                        @else
                                            <div class="w-8 h-8 rounded-full bg-gray-500/20 border border-gray-500/30 flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-white group-hover:text-emerald-300 transition-colors duration-200">{{ $activity->title }}</p>
                                        <p class="text-xs text-gray-400 mt-0.5">{{ $activity->description }}</p>
                                        <p class="text-xs text-gray-500 mt-1">{{ $activity->created_at->setTimezone('Asia/Manila')->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <div class="w-16 h-16 mx-auto rounded-full bg-neutral-700/30 flex items-center justify-center mb-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <p class="text-gray-400 text-sm">No recent activities</p>
                                    <p class="text-gray-500 text-xs mt-1">Start learning to see your activities here!</p>
                                </div>
                            @endforelse


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

                <!-- Active Friends -->
                <div class="rounded-2xl border border-neutral-800 bg-neutral-800/50 backdrop-blur-sm shadow-xl overflow-hidden relative group hover:border-neutral-700 transition-all duration-300">
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(59,130,246,0.1),transparent_70%)] opacity-70 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-blue-500/0 via-blue-500/5 to-blue-500/0 rounded-xl opacity-0 group-hover:opacity-100 blur-xl transition-opacity duration-500 group-hover:duration-200"></div>
                    <div class="p-6 relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                                <div class="relative">
                                    <div class="absolute -inset-1 bg-blue-500/20 rounded-full blur-sm opacity-70"></div>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400 relative" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M7 4V2a1 1 0 011-1h4a1 1 0 011 1v2h4a1 1 0 110 2h-1v10a2 2 0 01-2 2H6a2 2 0 01-2-2V6H3a1 1 0 010-2h4zM9 3v1h2V3H9zm0 5a1 1 0 112 0v6a1 1 0 11-2 0V8z"/>
                                    </svg>
                                </div>
                                <span class="text-white bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-400">Friend Activity</span>
                            </h3>
                            <div class="flex items-center gap-2">
                                <button
                                    onclick="console.log('Add Friend button clicked'); openAddFriendModal();"
                                    class="text-sm text-blue-400 hover:text-blue-300 transition-colors flex items-center gap-1 bg-neutral-800/80 px-3 py-1 rounded-full border border-neutral-700/50 hover:bg-neutral-800 hover:border-blue-500/30 transition-all duration-300"
                                    id="addFriendButton"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"/>
                                    </svg>
                                    Add Friend
                                </button>
                                <!-- Debug button for testing -->
                                <button
                                    onclick="console.log('Debug button clicked'); alert('Button click works! Modal element exists: ' + !!document.getElementById('addFriendModal'));"
                                    class="text-xs text-gray-400 hover:text-gray-300 transition-colors px-2 py-1 rounded border border-gray-600/50"
                                    title="Debug button - click to test if JavaScript is working"
                                >
                                    🔧
                                </button>
                            </div>
                        </div>

                        <!-- Activity Filter Tabs -->
                        <div class="flex gap-1 mb-4 bg-neutral-800/50 rounded-lg p-1">
                            <button
                                onclick="filterActivities('all')"
                                class="activity-filter-btn active flex-1 text-xs py-2 px-3 rounded-md transition-all duration-200 text-blue-400 bg-blue-500/20 border border-blue-500/30"
                                data-filter="all"
                            >
                                All
                            </button>
                            <button
                                onclick="filterActivities('challenge_completed')"
                                class="activity-filter-btn flex-1 text-xs py-2 px-3 rounded-md transition-all duration-200 text-gray-400 hover:text-white hover:bg-neutral-700/50"
                                data-filter="challenge_completed"
                            >
                                🎓 Challenges
                            </button>
                            <button
                                onclick="filterActivities('level_up')"
                                class="activity-filter-btn flex-1 text-xs py-2 px-3 rounded-md transition-all duration-200 text-gray-400 hover:text-white hover:bg-neutral-700/50"
                                data-filter="level_up"
                            >
                                ⭐ Levels
                            </button>
                            <button
                                onclick="filterActivities('achievement_unlocked')"
                                class="activity-filter-btn flex-1 text-xs py-2 px-3 rounded-md transition-all duration-200 text-gray-400 hover:text-white hover:bg-neutral-700/50"
                                data-filter="achievement_unlocked"
                            >
                                🏆 Achievements
                            </button>
                        </div>

                        <!-- Activity Feed Container -->
                        <div id="activityFeedContainer" class="space-y-3 max-h-96 overflow-y-auto">
                            <!-- Activities will be loaded here -->
                            <div id="activityFeedLoading" class="text-center py-6">
                                <div class="w-8 h-8 mx-auto border-2 border-blue-400 border-t-transparent rounded-full animate-spin mb-3"></div>
                                <p class="text-gray-400 text-sm">Loading friend activities...</p>
                            </div>
                        </div>

                        <!-- Load More Button -->
                        <div id="loadMoreContainer" class="mt-4 pt-3 border-t border-neutral-700/50 text-center hidden">
                            <button
                                onclick="loadMoreActivities()"
                                id="loadMoreBtn"
                                class="text-xs text-blue-400 hover:text-blue-300 transition-colors"
                            >
                                Load More Activities
                            </button>
                        </div>

                        <!-- Empty State -->
                        <div id="emptyActivityState" class="text-center py-6 hidden">
                            <div class="w-16 h-16 mx-auto rounded-full bg-blue-500/10 flex items-center justify-center mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M7 4V2a1 1 0 011-1h4a1 1 0 011 1v2h4a1 1 0 110 2h-1v10a2 2 0 01-2 2H6a2 2 0 01-2-2V6H3a1 1 0 010-2h4zM9 3v1h2V3H9zm0 5a1 1 0 112 0v6a1 1 0 11-2 0V8z"/>
                                </svg>
                            </div>
                            <p class="text-gray-400 text-sm mb-2">No friend activities yet</p>
                            <p class="text-gray-500 text-xs">Add friends to see their learning activities here!</p>
                        </div>
                    </div>
                </div>

                <!-- Leaderboard -->
                <div class="leaderboard-container rounded-2xl border border-neutral-800 bg-neutral-800/50 backdrop-blur-sm shadow-xl overflow-hidden relative group hover:border-neutral-700 transition-all duration-300">
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
                                    data-user-id="{{ $entry->user->id }}"
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
            </div>
        </div>
    </div>

    <!-- Activity graph is now server-side rendered -->

    <!-- Real-time Dashboard Integration -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize real-time features when the manager is ready
            if (window.realTimeManager) {
                initializeDashboardRealTime();
            } else {
                // Wait for real-time manager to load
                setTimeout(() => {
                    if (window.realTimeManager) {
                        initializeDashboardRealTime();
                    }
                }, 1000);
            }
        });

        function initializeDashboardRealTime() {
            const rtm = window.realTimeManager;

            // Handle real-time notifications
            rtm.onNotification((data) => {
                console.log('Dashboard received notification:', data);

                // Show toast notification
                showToastNotification(data);

                // Update notification UI if Alpine.js component exists
                updateNotificationDropdown(data);
            });

            // Handle leaderboard updates
            rtm.onLeaderboardUpdate((data) => {
                console.log('Dashboard received leaderboard update:', data);
                updateLeaderboardDisplay(data);
            });

            // Handle activity updates
            rtm.onActivity((data) => {
                console.log('Dashboard received activity update:', data);
                updateActivityDisplay(data);
            });

            // Handle challenge progress updates
            rtm.onChallengeProgress((data) => {
                console.log('Dashboard received challenge progress:', data);
                updateChallengeProgress(data);
            });
        }

        function showToastNotification(data) {
            // Create toast notification element
            const toast = document.createElement('div');
            toast.className = 'fixed top-4 right-4 z-50 max-w-sm bg-neutral-800 border border-emerald-500/30 rounded-lg shadow-xl p-4 transform translate-x-full transition-transform duration-300';
            toast.innerHTML = `
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0">
                        ${getNotificationIcon(data.type)}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-white">${data.title || 'Notification'}</p>
                        <p class="text-sm text-gray-300 mt-1">${data.message}</p>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="flex-shrink-0 text-gray-400 hover:text-white">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            `;

            document.body.appendChild(toast);

            // Animate in
            setTimeout(() => {
                toast.classList.remove('translate-x-full');
            }, 100);

            // Auto remove after 5 seconds
            setTimeout(() => {
                toast.classList.add('translate-x-full');
                setTimeout(() => toast.remove(), 300);
            }, 5000);
        }

        function getNotificationIcon(type) {
            const icons = {
                'achievement': '<div class="w-6 h-6 rounded-full bg-blue-500/20 border border-blue-500/30 flex items-center justify-center text-blue-400">🏆</div>',
                'level_up': '<div class="w-6 h-6 rounded-full bg-emerald-500/20 border border-emerald-500/30 flex items-center justify-center text-emerald-400">⬆️</div>',
                'challenge': '<div class="w-6 h-6 rounded-full bg-orange-500/20 border border-orange-500/30 flex items-center justify-center text-orange-400">⚡</div>',
                'system': '<div class="w-6 h-6 rounded-full bg-gray-500/20 border border-gray-500/30 flex items-center justify-center text-gray-400">ℹ️</div>',
            };
            return icons[type] || icons['system'];
        }

        function updateNotificationDropdown(data) {
            // This would integrate with Alpine.js notification component
            const notificationContainer = document.querySelector('[x-data*="notifications"]');
            if (notificationContainer && window.Alpine) {
                const alpineData = window.Alpine.$data(notificationContainer);
                if (alpineData && alpineData.notifications) {
                    alpineData.notifications.unshift(data);
                }
            }
        }

        function updateLeaderboardDisplay(data) {
            // Update leaderboard entries with animation
            if (data.leaderboard) {
                data.leaderboard.forEach((entry, index) => {
                    const element = document.querySelector(`[data-user-id="${entry.user_id}"]`);
                    if (element) {
                        // Add update animation
                        element.classList.add('rank-updated');
                        setTimeout(() => element.classList.remove('rank-updated'), 1000);

                        // Update rank if changed
                        const rankElement = element.querySelector('.font-bold');
                        if (rankElement && rankElement.textContent !== (index + 1).toString()) {
                            rankElement.textContent = index + 1;
                        }
                    }
                });
            }
        }

        function updateActivityDisplay(data) {
            // Update activity graph or feed
            console.log('Updating activity display:', data);
        }

        function updateChallengeProgress(data) {
            // Update challenge progress bars
            const challengeElement = document.querySelector(`[data-challenge-id="${data.challenge_id}"]`);
            if (challengeElement) {
                const progressBar = challengeElement.querySelector('.progress-bar, [style*="width"]');
                if (progressBar) {
                    progressBar.style.width = `${data.progress}%`;
                    progressBar.classList.add('progress-updated');
                    setTimeout(() => progressBar.classList.remove('progress-updated'), 1000);
                }
            }
        }

        // Connection status updates
        function updateConnectionStatus(status) {
            const statusElement = document.querySelector('.connection-status');
            const statusText = statusElement?.nextElementSibling;

            if (statusElement && statusText) {
                statusElement.className = `connection-status ${status}`;

                const statusTexts = {
                    'connected': 'Connected',
                    'disconnected': 'Disconnected',
                    'connecting': 'Connecting...',
                    'error': 'Connection Error'
                };

                statusText.textContent = statusTexts[status] || 'Unknown';
            }
        }

        // Listen for connection status changes
        if (window.Echo) {
            window.Echo.connector.pusher.connection.bind('connected', () => {
                updateConnectionStatus('connected');
            });

            window.Echo.connector.pusher.connection.bind('disconnected', () => {
                updateConnectionStatus('disconnected');
            });

            window.Echo.connector.pusher.connection.bind('connecting', () => {
                updateConnectionStatus('connecting');
            });

            window.Echo.connector.pusher.connection.bind('error', () => {
                updateConnectionStatus('error');
            });
        }
    </script>

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

    <!-- Add Friend Modal -->
    <div id="addFriendModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
        <div class="bg-neutral-800 rounded-2xl border border-neutral-700 shadow-xl max-w-md w-full max-h-[80vh] overflow-hidden">
            <div class="p-6 border-b border-neutral-700">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-bold text-white">Add Friend</h3>
                    <button onclick="closeAddFriendModal()" class="text-gray-400 hover:text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="p-6">
                <div class="mb-4">
                    <input
                        type="text"
                        id="friendSearchInput"
                        placeholder="Search for users by name..."
                        class="w-full px-4 py-2 bg-neutral-700 border border-neutral-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-blue-500 transition-colors"
                        oninput="searchUsers(this.value)"
                    >
                </div>
                <div id="searchResults" class="space-y-2 max-h-60 overflow-y-auto">
                    <div class="text-center text-gray-400 py-4">
                        <p>Start typing to search for users...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Friend Profile Modal -->
    <div id="friendProfileModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
        <div class="bg-neutral-800 rounded-2xl border border-neutral-700 shadow-xl max-w-md w-full">
            <div class="p-6 border-b border-neutral-700">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-bold text-white">Friend Profile</h3>
                    <button onclick="closeFriendProfileModal()" class="text-gray-400 hover:text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            <div id="friendProfileContent" class="p-6">
                <!-- Profile content will be loaded here -->
            </div>
        </div>
    </div>

    <!-- Friends JavaScript -->
    <script>
        let searchTimeout;
        let currentActivityPage = 1;
        let currentActivityFilter = 'all';
        let isLoadingActivities = false;
        let hasMoreActivities = true;

        function openAddFriendModal() {
            console.log('Opening add friend modal...');
            const modal = document.getElementById('addFriendModal');
            const searchInput = document.getElementById('friendSearchInput');

            if (!modal) {
                console.error('Add friend modal not found!');
                showNotification('Error: Modal not found', 'error');
                return;
            }

            if (!searchInput) {
                console.error('Friend search input not found!');
                showNotification('Error: Search input not found', 'error');
                return;
            }

            modal.classList.remove('hidden');
            setTimeout(() => {
                searchInput.focus();
            }, 100);
            console.log('Add friend modal opened successfully');
        }

        function closeAddFriendModal() {
            document.getElementById('addFriendModal').classList.add('hidden');
            document.getElementById('friendSearchInput').value = '';
            document.getElementById('searchResults').innerHTML = '<div class="text-center text-gray-400 py-4"><p>Start typing to search for users...</p></div>';
        }

        function searchUsers(query) {
            clearTimeout(searchTimeout);

            if (query.length < 2) {
                document.getElementById('searchResults').innerHTML = '<div class="text-center text-gray-400 py-4"><p>Start typing to search for users...</p></div>';
                return;
            }

            searchTimeout = setTimeout(() => {
                fetch(`/friends/search?query=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        displaySearchResults(data.users);
                    })
                    .catch(error => {
                        console.error('Search error:', error);
                        document.getElementById('searchResults').innerHTML = '<div class="text-center text-red-400 py-4"><p>Error searching users</p></div>';
                    });
            }, 300);
        }

        function displaySearchResults(users) {
            const resultsContainer = document.getElementById('searchResults');

            if (users.length === 0) {
                resultsContainer.innerHTML = '<div class="text-center text-gray-400 py-4"><p>No users found</p></div>';
                return;
            }

            resultsContainer.innerHTML = users.map(user => `
                <div class="flex items-center justify-between p-3 bg-neutral-700/20 rounded-lg border border-neutral-700/50 hover:bg-neutral-700/30 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-cyan-600 flex items-center justify-center text-sm font-bold text-white">
                            ${user.initials}
                        </div>
                        <div>
                            <p class="font-medium text-white">${user.name}</p>
                            <p class="text-xs text-gray-400">Level ${user.level} • ${user.points.toLocaleString()} XP</p>
                        </div>
                    </div>
                    <div>
                        ${user.is_friend ?
                            '<span class="text-xs text-green-400 bg-green-500/20 px-2 py-1 rounded-full">Friends</span>' :
                            user.request_sent ?
                                '<span class="text-xs text-yellow-400 bg-yellow-500/20 px-2 py-1 rounded-full">Pending</span>' :
                                user.request_received ?
                                    '<button onclick="acceptFriendRequest(${user.id})" class="text-xs text-blue-400 bg-blue-500/20 px-2 py-1 rounded-full hover:bg-blue-500/30 transition-colors">Accept</button>' :
                                    '<button onclick="sendFriendRequest(${user.id})" class="text-xs text-blue-400 bg-blue-500/20 px-2 py-1 rounded-full hover:bg-blue-500/30 transition-colors">Add Friend</button>'
                        }
                    </div>
                </div>
            `).join('');
        }

        function sendFriendRequest(userId) {
            console.log('Sending friend request to user ID:', userId);

            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (!csrfToken) {
                console.error('CSRF token not found!');
                showNotification('Error: Security token missing', 'error');
                return;
            }

            // Disable the button to prevent double-clicks
            const button = event.target;
            const originalText = button.textContent;
            button.disabled = true;
            button.textContent = 'Sending...';

            fetch('/friends/send-request', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken.getAttribute('content')
                },
                body: JSON.stringify({ user_id: userId })
            })
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                if (data.success) {
                    showNotification('Friend request sent!', 'success');
                    // Refresh search results
                    const query = document.getElementById('friendSearchInput').value;
                    if (query.length >= 2) {
                        searchUsers(query);
                    }
                } else {
                    showNotification(data.message || 'Failed to send friend request', 'error');
                }
            })
            .catch(error => {
                console.error('Error sending friend request:', error);
                showNotification('Error sending friend request: ' + error.message, 'error');
            })
            .finally(() => {
                // Re-enable the button
                button.disabled = false;
                button.textContent = originalText;
            });
        }

        function acceptFriendRequest(userId) {
            fetch('/friends/accept-request', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ user_id: userId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Friend request accepted!', 'success');
                    // Refresh search results and active friends
                    const query = document.getElementById('friendSearchInput').value;
                    if (query.length >= 2) {
                        searchUsers(query);
                    }
                    refreshActiveFriends();
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error accepting friend request', 'error');
            });
        }

        function viewFriendProfile(userId) {
            fetch(`/friends/profile/${userId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        displayFriendProfile(data.friend);
                        document.getElementById('friendProfileModal').classList.remove('hidden');
                    } else {
                        showNotification(data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Error loading friend profile', 'error');
                });
        }

        function displayFriendProfile(friend) {
            document.getElementById('friendProfileContent').innerHTML = `
                <div class="text-center mb-6">
                    <div class="w-20 h-20 rounded-full bg-gradient-to-br from-blue-500 to-cyan-600 flex items-center justify-center text-xl font-bold text-white mx-auto mb-3">
                        ${friend.initials}
                    </div>
                    <h4 class="text-xl font-bold text-white">${friend.name}</h4>
                    <p class="text-gray-400">Level ${friend.level}</p>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="bg-neutral-700/20 rounded-lg p-3 text-center">
                        <p class="text-2xl font-bold text-blue-400">${friend.points.toLocaleString()}</p>
                        <p class="text-xs text-gray-400">Experience Points</p>
                    </div>
                    <div class="bg-neutral-700/20 rounded-lg p-3 text-center">
                        <p class="text-2xl font-bold text-purple-400">${friend.badges_count}</p>
                        <p class="text-xs text-gray-400">Badges Earned</p>
                    </div>
                    <div class="bg-neutral-700/20 rounded-lg p-3 text-center">
                        <p class="text-2xl font-bold text-green-400">${friend.achievements_count}</p>
                        <p class="text-xs text-gray-400">Achievements</p>
                    </div>
                    <div class="bg-neutral-700/20 rounded-lg p-3 text-center">
                        <p class="text-2xl font-bold text-orange-400">${friend.challenges_completed}</p>
                        <p class="text-xs text-gray-400">Challenges Done</p>
                    </div>
                </div>

                ${friend.last_activity_at ? `
                    <div class="bg-neutral-700/20 rounded-lg p-3">
                        <p class="text-sm text-gray-400">Last seen: ${friend.last_activity_at}</p>
                    </div>
                ` : ''}
            `;
        }

        function closeFriendProfileModal() {
            document.getElementById('friendProfileModal').classList.add('hidden');
        }

        // Activity Feed Functions
        function loadActivityFeed(page = 1, filter = 'all', append = false) {
            if (isLoadingActivities) return;

            isLoadingActivities = true;

            if (!append) {
                document.getElementById('activityFeedLoading').classList.remove('hidden');
                document.getElementById('emptyActivityState').classList.add('hidden');
            }

            fetch(`/friends/activities/dashboard?page=${page}&filters=${filter}`)
                .then(response => response.json())
                .then(data => {
                    displayActivityFeed(data.activities, append);

                    if (!append) {
                        document.getElementById('activityFeedLoading').classList.add('hidden');
                    }

                    // Show empty state if no activities
                    if (data.activities.length === 0 && !append) {
                        document.getElementById('emptyActivityState').classList.remove('hidden');
                        document.getElementById('loadMoreContainer').classList.add('hidden');
                    } else {
                        document.getElementById('emptyActivityState').classList.add('hidden');

                        // Show/hide load more button
                        if (data.pagination && data.pagination.has_more) {
                            document.getElementById('loadMoreContainer').classList.remove('hidden');
                            hasMoreActivities = true;
                        } else {
                            document.getElementById('loadMoreContainer').classList.add('hidden');
                            hasMoreActivities = false;
                        }
                    }
                })
                .catch(error => {
                    console.error('Error loading activity feed:', error);
                    document.getElementById('activityFeedLoading').classList.add('hidden');
                    showNotification('Error loading activity feed', 'error');
                })
                .finally(() => {
                    isLoadingActivities = false;
                });
        }

        function displayActivityFeed(activities, append = false) {
            const container = document.getElementById('activityFeedContainer');

            if (!append) {
                container.innerHTML = '';
            }

            activities.forEach(activity => {
                const activityElement = createActivityElement(activity);
                container.appendChild(activityElement);

                // Animate in
                setTimeout(() => {
                    activityElement.style.opacity = '1';
                    activityElement.style.transform = 'translateY(0)';
                }, 100);
            });
        }

        function createActivityElement(activity) {
            const element = document.createElement('div');
            element.className = 'activity-item opacity-0 transform translate-y-4 transition-all duration-300';
            element.style.opacity = '0';
            element.style.transform = 'translateY(16px)';

            const colorClasses = {
                'blue': 'border-blue-500/30 bg-blue-500/10',
                'yellow': 'border-yellow-500/30 bg-yellow-500/10',
                'purple': 'border-purple-500/30 bg-purple-500/10',
                'green': 'border-green-500/30 bg-green-500/10',
                'red': 'border-red-500/30 bg-red-500/10',
                'orange': 'border-orange-500/30 bg-orange-500/10',
                'cyan': 'border-cyan-500/30 bg-cyan-500/10',
                'emerald': 'border-emerald-500/30 bg-emerald-500/10',
                'pink': 'border-pink-500/30 bg-pink-500/10',
                'gray': 'border-gray-500/30 bg-gray-500/10'
            };

            const colorClass = colorClasses[activity.color] || colorClasses['gray'];

            element.innerHTML = `
                <div class="flex items-start p-3 rounded-xl bg-neutral-700/20 border border-neutral-700/50 hover:bg-neutral-700/30 hover:border-blue-500/30 transition-all duration-300 group relative overflow-hidden">
                    <div class="absolute inset-0 bg-[linear-gradient(45deg,rgba(255,255,255,0)_25%,rgba(255,255,255,0.05)_50%,rgba(255,255,255,0)_75%)] bg-[length:250%_250%] opacity-0 group-hover:opacity-100 group-hover:animate-shimmer"></div>

                    <!-- User Avatar -->
                    <div class="relative flex-shrink-0 mr-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-cyan-600 flex items-center justify-center text-sm font-bold text-white shadow-lg overflow-hidden group-hover:scale-105 transition-transform duration-300 cursor-pointer"
                             onclick="viewFriendProfile(${activity.user.id})">
                            <div class="absolute inset-0 bg-[radial-gradient(circle_at_60%_35%,rgba(255,255,255,0.25),transparent_50%)] opacity-70"></div>
                            <div class="relative z-10">${activity.user.initials}</div>
                        </div>

                        <!-- Activity Type Badge -->
                        <div class="absolute -bottom-1 -right-1 w-6 h-6 rounded-full border-2 border-neutral-800 ${colorClass} flex items-center justify-center text-xs">
                            ${activity.icon}
                        </div>
                    </div>

                    <!-- Activity Content -->
                    <div class="flex-grow relative z-10 min-w-0">
                        <div class="flex justify-between items-start mb-1">
                            <div class="min-w-0 flex-1">
                                <p class="text-sm text-gray-100 group-hover:text-white transition-colors duration-300">
                                    <span class="font-medium cursor-pointer hover:text-blue-400" onclick="viewFriendProfile(${activity.user.id})">${activity.user.name}</span>
                                    <span class="text-gray-400">${getActivityAction(activity.type)}</span>
                                    <span class="font-medium text-white">${getActivityTarget(activity)}</span>
                                </p>
                                ${activity.description ? `<p class="text-xs text-gray-400 mt-0.5">${activity.description}</p>` : ''}
                                <div class="flex items-center gap-3 mt-1">
                                    <span class="text-xs text-gray-500">${activity.time_ago}</span>
                                    ${activity.points_earned > 0 ? `
                                        <span class="text-xs text-blue-400 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                            +${activity.points_earned}
                                        </span>
                                    ` : ''}
                                </div>
                            </div>

                            <!-- Like Button -->
                            <div class="flex items-center gap-1 ml-2">
                                <button
                                    onclick="likeActivity(${activity.id}, this)"
                                    class="like-btn flex items-center gap-1 px-2 py-1 rounded-full text-xs transition-all duration-200 ${activity.is_liked ? 'text-red-400 bg-red-500/20' : 'text-gray-400 hover:text-red-400 hover:bg-red-500/10'}"
                                >
                                    <svg class="w-3 h-3" fill="${activity.is_liked ? 'currentColor' : 'none'}" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                    </svg>
                                    <span class="likes-count">${activity.likes_count}</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            return element;
        }

        function getActivityAction(type) {
            const actions = {
                'challenge_completed': ' completed ',
                'badge_earned': ' earned ',
                'level_up': ' reached ',
                'achievement_unlocked': ' unlocked ',
                'streak_milestone': ' achieved ',
                'points_milestone': ' reached ',
                'task_completed': ' completed '
            };
            return actions[type] || ' did ';
        }

        function getActivityTarget(activity) {
            switch(activity.type) {
                case 'challenge_completed':
                    return activity.data.challenge_name || activity.title;
                case 'badge_earned':
                    return `the "${activity.data.badge_name}" badge`;
                case 'level_up':
                    return `Level ${activity.data.new_level}`;
                case 'achievement_unlocked':
                    return `"${activity.data.achievement_name}"`;
                case 'streak_milestone':
                    return `${activity.data.streak_days}-day streak`;
                case 'points_milestone':
                    return `${activity.data.milestone} points milestone`;
                default:
                    return activity.title;
            }
        }

        function filterActivities(filter) {
            // Update filter buttons
            document.querySelectorAll('.activity-filter-btn').forEach(btn => {
                btn.classList.remove('active', 'text-blue-400', 'bg-blue-500/20', 'border', 'border-blue-500/30');
                btn.classList.add('text-gray-400');
            });

            const activeBtn = document.querySelector(`[data-filter="${filter}"]`);
            if (activeBtn) {
                activeBtn.classList.add('active', 'text-blue-400', 'bg-blue-500/20', 'border', 'border-blue-500/30');
                activeBtn.classList.remove('text-gray-400');
            }

            // Reset pagination and load new activities
            currentActivityFilter = filter;
            currentActivityPage = 1;
            hasMoreActivities = true;
            loadActivityFeed(1, filter, false);
        }

        function loadMoreActivities() {
            if (!hasMoreActivities || isLoadingActivities) return;

            currentActivityPage++;
            loadActivityFeed(currentActivityPage, currentActivityFilter, true);
        }

        function likeActivity(activityId, button) {
            fetch('/friends/activities/like', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ activity_id: activityId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update like button state
                    const likesCount = button.querySelector('.likes-count');
                    const heart = button.querySelector('svg');

                    if (data.liked) {
                        button.classList.add('text-red-400', 'bg-red-500/20');
                        button.classList.remove('text-gray-400');
                        heart.setAttribute('fill', 'currentColor');
                    } else {
                        button.classList.remove('text-red-400', 'bg-red-500/20');
                        button.classList.add('text-gray-400');
                        heart.setAttribute('fill', 'none');
                    }

                    likesCount.textContent = data.likes_count;

                    // Add animation
                    button.style.transform = 'scale(1.2)';
                    setTimeout(() => {
                        button.style.transform = 'scale(1)';
                    }, 150);
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error liking activity:', error);
                showNotification('Error liking activity', 'error');
            });
        }

        function showNotification(message, type = 'info') {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 max-w-sm bg-neutral-800 border rounded-lg shadow-xl p-4 transform translate-x-full transition-transform duration-300 ${
                type === 'success' ? 'border-green-500/30' :
                type === 'error' ? 'border-red-500/30' :
                'border-blue-500/30'
            }`;

            notification.innerHTML = `
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0">
                        ${type === 'success' ?
                            '<div class="w-6 h-6 rounded-full bg-green-500/20 border border-green-500/30 flex items-center justify-center text-green-400">✓</div>' :
                            type === 'error' ?
                                '<div class="w-6 h-6 rounded-full bg-red-500/20 border border-red-500/30 flex items-center justify-center text-red-400">✕</div>' :
                                '<div class="w-6 h-6 rounded-full bg-blue-500/20 border border-blue-500/30 flex items-center justify-center text-blue-400">ℹ</div>'
                        }
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-white">${message}</p>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="flex-shrink-0 text-gray-400 hover:text-white">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            `;

            document.body.appendChild(notification);

            // Animate in
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
            }, 100);

            // Auto remove after 5 seconds
            setTimeout(() => {
                notification.classList.add('translate-x-full');
                setTimeout(() => notification.remove(), 300);
            }, 5000);
        }

        // Real-time Notifications Setup
        function setupRealTimeNotifications() {
            if (typeof window.Echo !== 'undefined') {
                const userId = {{ auth()->id() }};

                // Listen for friend request notifications
                window.Echo.private(`user.${userId}`)
                    .listen('.friend.request.received', (data) => {
                        showFriendRequestNotification(data);
                    })
                    .listen('.friend.request.accepted', (data) => {
                        showNotification(data.message, 'success');
                        // Refresh activity feed to show new friend's activities
                        loadActivityFeed(1, currentActivityFilter, false);
                    })
                    .listen('.friend.online', (data) => {
                        showNotification(data.message, 'info');
                        updateFriendStatus(data.friend.id, 'online');
                    })
                    .listen('.friend.activity.created', (data) => {
                        addNewActivityToFeed(data.activity, data.user);
                    });
            }
        }

        function showFriendRequestNotification(data) {
            const notification = document.createElement('div');
            notification.className = 'fixed top-4 right-4 z-50 max-w-sm bg-neutral-800 border border-blue-500/30 rounded-lg shadow-xl p-4 transform translate-x-full transition-transform duration-300';

            notification.innerHTML = `
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-cyan-600 flex items-center justify-center text-sm font-bold text-white">
                        ${data.sender.initials}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-white">${data.message}</p>
                        <div class="flex gap-2 mt-2">
                            <button onclick="acceptFriendRequestFromNotification(${data.sender.id}, this.parentElement.parentElement.parentElement)"
                                    class="text-xs bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-full transition-colors">
                                Accept
                            </button>
                            <button onclick="declineFriendRequestFromNotification(${data.sender.id}, this.parentElement.parentElement.parentElement)"
                                    class="text-xs bg-neutral-700 hover:bg-neutral-600 text-white px-3 py-1 rounded-full transition-colors">
                                Decline
                            </button>
                        </div>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="text-gray-400 hover:text-white">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            `;

            document.body.appendChild(notification);

            // Animate in
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
            }, 100);

            // Auto remove after 10 seconds if no action taken
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.classList.add('translate-x-full');
                    setTimeout(() => notification.remove(), 300);
                }
            }, 10000);
        }

        function acceptFriendRequestFromNotification(userId, notificationElement) {
            acceptFriendRequest(userId);
            notificationElement.remove();
        }

        function declineFriendRequestFromNotification(userId, notificationElement) {
            fetch('/friends/decline-request', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ user_id: userId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Friend request declined', 'info');
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error declining friend request', 'error');
            });

            notificationElement.remove();
        }

        function addNewActivityToFeed(activity, user) {
            // Only add if we're showing all activities or the specific type
            if (currentActivityFilter === 'all' || currentActivityFilter === activity.type) {
                const container = document.getElementById('activityFeedContainer');
                const activityData = {
                    id: activity.id,
                    type: activity.type,
                    title: activity.title,
                    description: activity.description,
                    data: activity.data,
                    points_earned: activity.points_earned,
                    icon: activity.icon,
                    color: activity.color,
                    time_ago: activity.time_ago,
                    likes_count: 0,
                    is_liked: false,
                    user: user
                };

                const activityElement = createActivityElement(activityData);

                // Add to top of feed with animation
                if (container.firstChild) {
                    container.insertBefore(activityElement, container.firstChild);
                } else {
                    container.appendChild(activityElement);
                    // Hide empty state if it was showing
                    document.getElementById('emptyActivityState').classList.add('hidden');
                }

                // Animate in
                setTimeout(() => {
                    activityElement.style.opacity = '1';
                    activityElement.style.transform = 'translateY(0)';
                }, 100);

                // Show a subtle notification
                showNotification(`${user.name} ${getActivityAction(activity.type)}${getActivityTarget(activityData)}`, 'info');
            }
        }

        function updateFriendStatus(friendId, status) {
            // Update friend status indicators if they exist
            const friendElements = document.querySelectorAll(`[data-friend-id="${friendId}"]`);
            friendElements.forEach(element => {
                const statusDot = element.querySelector('.status-indicator');
                if (statusDot) {
                    statusDot.className = `status-indicator ${status}`;
                    if (status === 'online') {
                        statusDot.classList.add('animate-pulse');
                    }
                }
            });
        }

        // Initialize everything when page loads
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Dashboard DOM loaded, initializing...');

            // Verify critical elements exist
            const addFriendModal = document.getElementById('addFriendModal');
            const addFriendButton = document.getElementById('addFriendButton');
            const friendSearchInput = document.getElementById('friendSearchInput');
            const searchResults = document.getElementById('searchResults');

            console.log('Friend modal exists:', !!addFriendModal);
            console.log('Add friend button exists:', !!addFriendButton);
            console.log('Friend search input exists:', !!friendSearchInput);
            console.log('Search results container exists:', !!searchResults);

            if (!addFriendModal) {
                console.error('CRITICAL: Add friend modal not found in DOM!');
            }
            if (!addFriendButton) {
                console.error('CRITICAL: Add friend button not found in DOM!');
            }

            // Load initial activity feed
            loadActivityFeed(1, 'all', false);

            // Setup real-time notifications
            setupRealTimeNotifications();

            console.log('Dashboard initialization complete');
        });

        // Close modals when clicking outside
        document.addEventListener('click', function(event) {
            const addFriendModal = document.getElementById('addFriendModal');
            const friendProfileModal = document.getElementById('friendProfileModal');

            if (event.target === addFriendModal) {
                closeAddFriendModal();
            }

            if (event.target === friendProfileModal) {
                closeFriendProfileModal();
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

        /* Real-time connection status styles */
        .connection-status.connected .w-2 {
            background-color: #10b981; /* emerald-500 */
            animation: none;
        }
        .connection-status.disconnected .w-2 {
            background-color: #ef4444; /* red-500 */
            animation: pulse 2s infinite;
        }
        .connection-status.error .w-2 {
            background-color: #f59e0b; /* amber-500 */
            animation: pulse 1s infinite;
        }

        /* Real-time update animations */
        .rank-updated {
            animation: rankUpdate 1s ease-in-out;
        }
        @keyframes rankUpdate {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); background-color: rgba(16, 185, 129, 0.2); }
            100% { transform: scale(1); }
        }

        .progress-updated {
            animation: progressUpdate 1s ease-in-out;
        }
        @keyframes progressUpdate {
            0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
            70% { box-shadow: 0 0 0 10px rgba(16, 185, 129, 0); }
            100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }

        /* Notification animations */
        .notification-new {
            animation: notificationPulse 2s ease-in-out;
        }
        @keyframes notificationPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }
    </style>

    <!-- Task and recipe approval notifications are now handled by global Livewire components -->
</x-layouts.app>
