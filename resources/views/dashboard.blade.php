<x-layouts.app>
    <div class="flex h-full w-full flex-1 flex-col gap-6 bg-neutral-800 text-gray-100 p-6" id="app">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-medium text-gray-100">Gamified Dashboard</h1>
            {{-- Optional: Display current XP/Level briefly here --}}
        </div>
        
        <!-- User Profile & Progress + Quick Stats -->
        @php
            $user = auth()->user();
            $currentLevel = $user->getLevel();
            $currentPoints = $user->getPoints();

            // --- XP Progress Calculation ---
            // This part assumes how level thresholds are stored/retrieved.
            // You might need to adjust this based on your Level-up setup or add helper methods to User model.
            $levels = \LevelUp\Experience\Models\Level::orderBy('level')->get();
            // Points needed to *start* the current level (threshold of the previous level)
            $previousLevelThreshold = $levels->where('level', '<', $currentLevel)->sortByDesc('level')->first()?->next_level_experience ?? 0;
            // Points needed to *reach* the next level
            $pointsForNextLevel = $levels->firstWhere('level', $currentLevel + 1)?->next_level_experience ?? $currentPoints; // Handle level cap scenario

            $xpInCurrentLevel = $currentPoints - $previousLevelThreshold;
            $xpNeededForLevel = $pointsForNextLevel - $previousLevelThreshold;
            // Avoid division by zero if already at max level or data issue
            $progressPercentage = ($xpNeededForLevel > 0) ? round(($xpInCurrentLevel / $xpNeededForLevel) * 100) : 100;
            $xpToNextLevel = max(0, $pointsForNextLevel - $currentPoints);
            // --- End XP Progress Calculation ---


            // --- Stats Data (Existing) ---
            $achievement = \App\Models\StudentAchievement::getLatestScore($user->id);
            $score = $achievement ? number_format($achievement->score, 2) : '0.00';
            $scoreChange = $achievement ? $achievement->score_change : 0;
            
            $attendancePercentage = \App\Models\StudentAttendance::getAttendancePercentage($user->id);
            $attendanceChange = \App\Models\StudentAttendance::getAttendanceChange($user->id);
            
            $credits = \App\Models\StudentCredit::getCreditsInfo($user->id);
            $creditsCompleted = $credits ? $credits->credits_completed : 0;
            $creditsRequired = $credits ? ($credits->credits_required ?: 120) : 120; // Ensure credits_required has a fallback
            $completionPercentage = $credits ? $credits->completion_percentage : 0;
            // --- End Stats Data ---


            // --- Leaderboard Data (Placeholder - Requires Level-up Leaderboard Service) ---
            // Replace with actual call like: $leaderboard = \LevelUp\Experience\Services\Leaderboard::generate(5);
            // Replace with actual call like: $userRank = \LevelUp\Experience\Services\Leaderboard::getUserRank($user->id);
            $leaderboardData = collect([ // Placeholder Data Structure
                (object)['user' => (object)['id' => 1, 'name' => 'John Doe'], 'experience' => (object)['level_id' => 5, 'experience_points' => 1500]],
                (object)['user' => (object)['id' => 2, 'name' => 'Jane Smith'], 'experience' => (object)['level_id' => 4, 'experience_points' => 1300]],
                (object)['user' => (object)['id' => $user->id, 'name' => $user->name], 'experience' => (object)['level_id' => $currentLevel, 'experience_points' => $currentPoints]],
                (object)['user' => (object)['id' => 3, 'name' => 'Alex Johnson'], 'experience' => (object)['level_id' => 3, 'experience_points' => 1100]],
                (object)['user' => (object)['id' => 4, 'name' => 'Sam Wilson'], 'experience' => (object)['level_id' => 3, 'experience_points' => 1050]],
                (object)['user' => (object)['id' => 5, 'name' => 'Chris Evans'], 'experience' => (object)['level_id' => 2, 'experience_points' => 900]],
            ])->sortByDesc('experience.experience_points')->values();
            $userRank = $leaderboardData->search(fn($item) => $item->user->id === $user->id);
            $userRank = ($userRank !== false) ? $userRank + 1 : null; // Get 1-based rank
            // --- End Leaderboard Data ---


            // --- Achievements/Badges Data ---
            // Use getUserAchievements() or badges() depending on your setup. Limit for display.
            $userAchievements = $user->getUserAchievements()->take(4); // Example: Get first 4
            // --- End Achievements Data ---


            // --- Challenges Data ---
            $activeChallenges = $user->getActiveChallenges()->take(3); // Example: Get first 3 active
            // --- End Challenges Data ---

        @endphp

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
            <!-- Profile Card -->
            <div class="lg:col-span-2 p-6 rounded-xl border border-neutral-700 bg-neutral-800 flex flex-col justify-between shadow-lg hover:border-neutral-600 transition-colors duration-300">
                <div class="flex items-center gap-4 mb-4">
                    {{-- Avatar Placeholder --}}
                    <div class="w-16 h-16 rounded-full bg-gradient-to-br from-emerald-500 to-green-600 flex items-center justify-center text-2xl font-bold text-white shadow-md">
                        {{ $user->initials() }}
                    </div>
                    <div>
                        <h2 class="text-2xl font-semibold text-gray-100">Welcome back, {{ explode(' ', $user->name)[0] }}!</h2>
                        <p class="text-gray-400">You're doing great! Keep pushing forward.</p>
                </div>
                </div>
                <div>
                    <div class="flex justify-between items-end mb-1">
                        <span class="text-sm font-medium text-emerald-400">Level {{ $currentLevel }}</span>
                        <span class="text-xs text-gray-400">{{ number_format($currentPoints) }} / {{ number_format($pointsForNextLevel) }} XP</span>
            </div>
                    <div class="w-full bg-neutral-700 rounded-full h-3 overflow-hidden">
                        <div class="bg-gradient-to-r from-emerald-500 to-green-500 h-3 rounded-full transition-all duration-500 ease-out" style="width: {{ $progressPercentage }}%"></div>
                </div>
                    <p class="text-right text-xs text-gray-400 mt-1">
                        {{ number_format($xpToNextLevel) }} XP to Level {{ $currentLevel + 1 }}
                    </p>
                </div>
            </div>

            <!-- Quick Stats Card -->
            <div class="p-6 rounded-xl border border-neutral-700 bg-neutral-800 flex flex-col justify-center shadow-lg hover:border-neutral-600 transition-colors duration-300">
                 <h3 class="text-lg font-medium text-gray-200 mb-4">Quick Stats</h3>
                 <div class="space-y-3">
                     <div class="flex justify-between items-center">
                         <span class="text-sm text-gray-400 flex items-center gap-1.5">
                             <svg class="h-4 w-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                             Achievement Score
                         </span>
                         <span class="text-sm font-semibold text-white">{{ $score }}
                             <span class="text-xs {{ $scoreChange >= 0 ? 'text-green-400' : 'text-red-400' }}">({{ $scoreChange >= 0 ? '+' : '' }}{{ number_format($scoreChange, 2) }})</span>
                         </span>
                     </div>
                     <div class="flex justify-between items-center">
                         <span class="text-sm text-gray-400 flex items-center gap-1.5">
                             <svg class="h-4 w-4 text-blue-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                             Attendance
                         </span>
                         <span class="text-sm font-semibold text-white">{{ $attendancePercentage }}%
                             <span class="text-xs {{ $attendanceChange >= 0 ? 'text-green-400' : 'text-red-400' }}">({{ $attendanceChange >= 0 ? '+' : '' }}{{ $attendanceChange }}%)</span>
                         </span>
                     </div>
                     <div class="flex justify-between items-center">
                         <span class="text-sm text-gray-400 flex items-center gap-1.5">
                             <svg class="h-4 w-4 text-purple-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 16c1.255 0 2.443-.29 3.5-.804V4.804zM14.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 0114.5 16c1.255 0 2.443-.29 3.5-.804v-10A7.968 7.968 0 0014.5 4z"></path></svg>
                             Credits
                         </span>
                         <span class="text-sm font-semibold text-white">{{ $creditsCompleted }}/{{ $creditsRequired }} ({{ $completionPercentage }}%)</span>
                </div>
                </div>
            </div>
        </div>

        <!-- Welcome Section -->
        <div class="flex flex-col items-center justify-center mb-10 text-center">
            <div class="flex items-center gap-2 mb-2">
                <svg class="h-6 w-6 text-orange-400" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 17.75L5.82802 20.995L7.00702 14.122L2.00702 9.25495L8.90702 8.25495L11.993 2.00195L15.079 8.25495L21.979 9.25495L16.979 14.122L18.158 20.995L12 17.75Z" fill="currentColor"/>
                </svg>
                <h2 class="text-4xl font-light">Welcome back, {{ explode(' ', auth()->user()->name)[0]}}!</h2>
            </div>
            <p class="text-gray-400 mb-8">Track your progress and continue your learning journey</p>
            
            <!-- Main Action Button -->
            <div class="w-full max-w-3xl mx-auto mb-8">
                <div class="relative rounded-xl bg-neutral-800 border border-neutral-700 overflow-hidden">
                    <a href="{{ route('learning') }}" 
                        class="block w-full p-6 text-center rounded-xl border-2 border-emerald-500 bg-emerald-500/10 
                            transition-all duration-300 ease-out hover:scale-[1.03] hover:shadow-emerald-900/50 hover:bg-emerald-500/20 
                            focus:outline-none focus:ring-4 focus:ring-emerald-500/50 active:scale-[0.98] 
                            animate-pulse group relative overflow-hidden">
                        
                        <!-- Background effect -->
                        <div class="absolute inset-0 bg-[radial-gradient(circle,_rgba(16,185,129,0.2)_0%,_rgba(0,0,0,0)_70%)] opacity-50 group-hover:opacity-75 transition-opacity duration-300"></div>

                        <!-- Text -->
                        <span class="relative text-xl font-semibold text-emerald-400 group-hover:text-emerald-300 transition-colors duration-300 drop-shadow-[0_0_10px_rgba(16,185,129,0.8)] glow">
                        Start Now
                        </span>
                    </a>
                </div>
            </div>


            <!-- Collaboration Tools (Claude-style) -->
            <div class="w-full max-w-3xl mx-auto mb-6">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm text-gray-400">Collaborate with your learning resources</span>
                </div>
                
                <!-- Quick Action Buttons (Claude-style) -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                    <a href="{{ route('courses') }}" class="flex items-center justify-center py-3 px-4 rounded-lg bg-neutral-800 border border-neutral-700 hover:bg-neutral-800/90 hover:border-neutral-600 hover:scale-[1.02] hover:shadow-lg hover:shadow-neutral-900/50 transition-colors">
                        <span class="text-gray-200">View Courses</span>
                    </a>
                    <a href="{{ route('assignments') }}" class="flex items-center justify-center py-3 px-4 rounded-lg bg-neutral-800 border border-neutral-700 hover:bg-neutral-800/90 hover:border-neutral-600 hover:scale-[1.02] hover:shadow-lg hover:shadow-neutral-900/50 transition-colors">
                        <span class="text-gray-200">Complete Assignments</span>
                    </a>
                    <a href="{{ route('grades') }}" class="flex items-center justify-center py-3 px-4 rounded-lg bg-neutral-800 border border-neutral-700 hover:bg-neutral-800/90 hover:border-neutral-600 hover:scale-[1.02] hover:shadow-lg hover:shadow-neutral-900/50 transition-colors">
                        <span class="text-gray-200">Check Grades</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column (Activity/Challenges/Actions) -->
            <div class="lg:col-span-2 space-y-6">
        <!-- Activity Graph -->
                <div class="relative overflow-hidden rounded-xl border border-neutral-700 bg-neutral-800 p-6 shadow-lg" style="min-height: 350px; height: 400px;">
                    <h3 class="text-lg font-medium text-gray-200 mb-4">Your Activity</h3>
            <div class="flex flex-col gap-2 h-[calc(100%-2rem)]">
                <div class="flex items-center justify-between">
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
                            <div class="text-xs text-gray-400">Contribution data (demo)</div> {{-- Label indicating demo data --}}
                </div>
                <div class="overflow-x-auto h-full">
                            <div class="contribution-calendar min-w-[700px] h-full">
                        <div id="contributionGraph" class="mt-2 w-full h-[calc(100%-0.5rem)]"></div>
                    </div>
                </div>
            </div>
                    {{-- Keep the existing script tag, but add a note --}}
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
        </div>
        
                <!-- Active Challenges -->
                <div class="p-6 rounded-xl border border-neutral-700 bg-neutral-800 shadow-lg hover:border-neutral-600 transition-colors duration-300">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-200 flex items-center gap-2">
                            <svg class="h-5 w-5 text-orange-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd"></path><path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0010 15c-2.796 0-5.487-.46-8-1.308z"></path></svg>
                            Active Challenges
                        </h3>
                        {{-- Assuming a route named 'challenges.index' or similar exists --}}
                        <a href="{{ route('learning',) }}" class="text-sm text-emerald-400 hover:text-emerald-300 transition-colors">View All</a>
                    </div>
                    @if($activeChallenges->isNotEmpty())
                        <div class="space-y-4">
                            @foreach($activeChallenges as $challenge)
                                <div class="border-b border-neutral-700 pb-4 last:border-b-0 last:pb-0">
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="font-medium text-gray-100">{{ $challenge->name }}</span>
                                        <span class="text-xs font-semibold {{ ($challenge->pivot->progress ?? 0) >= 100 ? 'text-green-400' : 'text-gray-400' }}">
                                            {{ $challenge->pivot->progress ?? 0 }}% Complete
                                        </span>
                                    </div>
                                    <div class="w-full bg-neutral-700 rounded-full h-2 overflow-hidden">
                                        <div class="bg-gradient-to-r from-orange-500 to-yellow-500 h-2 rounded-full transition-all duration-300" style="width: {{ $challenge->pivot->progress ?? 0 }}%"></div>
                                    </div>
                                    @if($challenge->description)
                                        <p class="text-xs text-gray-400 mt-1.5">{{ Str::limit($challenge->description, 100) }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-400 text-sm">There are {{ \App\Models\Challenge::count() }} total challenges available!</p>
                        <a href="{{ route('learning') }}" class="mt-2 inline-block px-3 py-1 text-sm bg-emerald-600 hover:bg-emerald-500 rounded-md text-white transition-colors">Explore Challenges</a>
                    @endif
                </div>

                <!-- Quick Actions -->
                 {{-- <div class="p-6 rounded-xl border border-neutral-700 bg-neutral-800 shadow-lg">
                     <h3 class="text-lg font-medium text-gray-200 mb-4">Quick Actions</h3>
                     <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                         <a href="{{ route('learning') }}" class="flex flex-col items-center justify-center py-3 px-2 rounded-lg bg-neutral-700/50 hover:bg-neutral-700 transition-all duration-200 text-center group transform hover:scale-105">
                             <svg class="h-6 w-6 text-emerald-400 mb-1 group-hover:text-emerald-300 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                             <span class="text-xs text-gray-200 group-hover:text-white transition-colors">Start Learning</span>
                         </a>
                         <a href="{{ route('courses') }}" class="flex flex-col items-center justify-center py-3 px-2 rounded-lg bg-neutral-700/50 hover:bg-neutral-700 transition-all duration-200 text-center group transform hover:scale-105">
                             <svg class="h-6 w-6 text-gray-400 mb-1 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                             <span class="text-xs text-gray-200 group-hover:text-white transition-colors">Courses</span>
                         </a>
                         <a href="{{ route('assignments') }}" class="flex flex-col items-center justify-center py-3 px-2 rounded-lg bg-neutral-700/50 hover:bg-neutral-700 transition-all duration-200 text-center group transform hover:scale-105">
                             <svg class="h-6 w-6 text-gray-400 mb-1 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                             <span class="text-xs text-gray-200 group-hover:text-white transition-colors">Assignments</span>
                         </a>
                         <a href="{{ route('grades') }}" class="flex flex-col items-center justify-center py-3 px-2 rounded-lg bg-neutral-700/50 hover:bg-neutral-700 transition-all duration-200 text-center group transform hover:scale-105">
                             <svg class="h-6 w-6 text-gray-400 mb-1 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                             <span class="text-xs text-gray-200 group-hover:text-white transition-colors">Grades</span>
                         </a>
                         <a href="{{ route('profile') }}" class="flex flex-col items-center justify-center py-3 px-2 rounded-lg bg-neutral-700/50 hover:bg-neutral-700 transition-all duration-200 text-center group transform hover:scale-105">
                             <svg class="h-6 w-6 text-gray-400 mb-1 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                             <span class="text-xs text-gray-200 group-hover:text-white transition-colors">Profile</span>
                         </a>
                         <a href="{{ route('schedule') }}" class="flex flex-col items-center justify-center py-3 px-2 rounded-lg bg-neutral-700/50 hover:bg-neutral-700 transition-all duration-200 text-center group transform hover:scale-105">
                             <svg class="h-6 w-6 text-gray-400 mb-1 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                             <span class="text-xs text-gray-200 group-hover:text-white transition-colors">Schedule</span>
                         </a>
                     </div>
                 </div> --}}
            </div>

            <!-- Right Column (Leaderboard/Achievements) -->
            <div class="space-y-6">
                <!-- Leaderboard -->
                <div class="p-6 rounded-xl border border-neutral-700 bg-neutral-800 shadow-lg">
                    <h3 class="text-lg font-medium text-gray-200 mb-4 flex items-center gap-2">
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                        Leaderboard
                    </h3>
                    <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-neutral-700">
                                <th class="pb-2 text-xs text-gray-400 font-medium uppercase tracking-wider">Rank</th>
                                <th class="pb-2 text-xs text-gray-400 font-medium uppercase tracking-wider">Student</th>
                                <th class="pb-2 text-xs text-gray-400 font-medium uppercase tracking-wider text-right">XP</th>
                        </tr>
                    </thead>
                    <tbody>
                            @forelse($leaderboardData->take(5) as $index => $entry) {{-- Show top 5 --}}
                                @php $rank = $index + 1; @endphp
                                <tr class="border-b border-neutral-700/50 last:border-b-0 {{ $entry->user->id === $user->id ? 'bg-emerald-500/10' : '' }}">
                                    <td class="py-2.5 font-semibold w-12">
                                        @if($rank == 1) <span class="text-yellow-400">🥇 #{{ $rank }}</span>
                                        @elseif($rank == 2) <span class="text-gray-300">🥈 #{{ $rank }}</span>
                                        @elseif($rank == 3) <span class="text-orange-400">🥉 #{{ $rank }}</span>
                                        @else <span class="text-gray-400">#{{ $rank }}</span>
                                        @endif
                                    </td>
                                    <td class="py-2.5 text-gray-100 truncate pr-2">{{ $entry->user->name }}</td>
                                    <td class="py-2.5 text-gray-300 text-right font-mono">{{ number_format($entry->experience->experience_points ?? 0) }}</td>
                        </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-4 text-center text-gray-400 text-sm">Leaderboard data is currently unavailable.</td>
                        </tr>
                            @endforelse
                            {{-- Add user's rank if not in top 5 --}}
                            @if($userRank && $userRank > 5)
                                <tr class="border-t border-dashed border-neutral-600 bg-emerald-500/10">
                                    <td class="pt-2.5 font-semibold text-gray-400">#{{ $userRank }}</td>
                                    <td class="pt-2.5 text-gray-100 truncate pr-2">{{ $user->name }}</td>
                                    <td class="pt-2.5 text-gray-300 text-right font-mono">{{ number_format($currentPoints) }}</td>
                        </tr>
                            @endif
                    </tbody>
                </table>
                     {{-- Add note about leaderboard source --}}
                    <p class="text-xs text-gray-500 mt-3 italic">Leaderboard data based on XP earned. (Placeholder)</p>
                </div>

                <!-- Achievements Showcase -->
                <div class="p-6 rounded-xl border border-neutral-700 bg-neutral-800 shadow-lg">
                     <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-200 flex items-center gap-2">
                            <svg class="h-5 w-5 text-purple-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 2a.75.75 0 01.75.75v.94l.622-.36a.75.75 0 01.756 1.3l-.622.36v.94l.622.36a.75.75 0 01-.756 1.3l-.622-.36v.94a.75.75 0 01-1.5 0v-.94l-.622.36a.75.75 0 01-.756-1.3l.622-.36v-.94l-.622-.36a.75.75 0 01.756-1.3l.622.36v-.94A.75.75 0 0110 2zM5.01 3.77a.75.75 0 01.75-.75h.94l.36-.622a.75.75 0 011.3.756l-.36.622h.94l.36.622a.75.75 0 01-.756 1.3l-.36-.622h-.94l-.36.622a.75.75 0 01-1.3-.756l.36-.622h-.94a.75.75 0 01-.75-.75zm10.981 1.03a.75.75 0 01.75-.75h.94l.36-.622a.75.75 0 011.3.756l-.36.622h.94l.36.622a.75.75 0 01-.756 1.3l-.36-.622h-.94l-.36.622a.75.75 0 01-1.3-.756l.36-.622h-.94a.75.75 0 01-.75-.75zm-10.98 8.41a.75.75 0 01.75-.75h.94l.36-.622a.75.75 0 011.3.756l-.36.622h.94l.36.622a.75.75 0 01-.756 1.3l-.36-.622h-.94l-.36.622a.75.75 0 01-1.3-.756l.36-.622h-.94a.75.75 0 01-.75-.75zm10.98 1.03a.75.75 0 01.75-.75h.94l.36-.622a.75.75 0 011.3.756l-.36.622h.94l.36.622a.75.75 0 01-.756 1.3l-.36-.622h-.94l-.36.622a.75.75 0 01-1.3-.756l.36-.622h-.94a.75.75 0 01-.75-.75zM10 5.5a4.5 4.5 0 100 9 4.5 4.5 0 000-9zM6.5 10a3.5 3.5 0 117 0 3.5 3.5 0 01-7 0z" clip-rule="evenodd"></path></svg>
                            Achievements
                        </h3>
                        {{-- Assuming a route for all achievements exists --}}
                        <a href="#" class="text-sm text-emerald-400 hover:text-emerald-300 transition-colors">View All</a>
                    </div>
                    @if($userAchievements->isNotEmpty())
                        <div class="grid grid-cols-2 gap-4">
                             @foreach($userAchievements as $achievement)
                                <div class="flex flex-col items-center p-3 bg-neutral-700/50 rounded-lg text-center transition-transform transform hover:scale-105" title="{{ $achievement->description }}">
                                    {{-- Placeholder Icon - Replace with $achievement->image if available --}}
                                    @if($achievement->image)
                                        <img src="{{ $achievement->image }}" alt="{{ $achievement->name }}" class="h-10 w-10 mb-1 object-contain">
                                    @else
                                        {{-- Default placeholder --}}
                                        <svg class="h-10 w-10 text-yellow-400 mb-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                    @endif
                                    <p class="text-xs text-gray-200 font-medium leading-tight">{{ $achievement->name }}</p>
                                    {{-- Add progress if applicable and not 100% --}}
                                    {{-- @if(isset($achievement->pivot->progress) && $achievement->pivot->progress < 100)
                                        <span class="text-[10px] text-gray-400">({{ $achievement->pivot->progress }}%)</span>
                                    @endif --}}
                </div>
                            @endforeach
                </div>
                    @else
                        <p class="text-gray-400 text-sm">No achievements earned yet. Keep learning and complete challenges!</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Remove Old Sections --}}
        {{-- Removed Welcome Section, Old Stats Cards, Old Leaderboard, Old Badges, Recent Chats, Old Quick Links --}}

    </div>
</x-layouts.app>

