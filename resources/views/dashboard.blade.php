<x-layouts.app>
    <div class="flex h-full w-full flex-1 flex-col gap-8 bg-neutral-800 text-gray-100 p-6" id="app">

        {{-- Header --}}
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-medium text-gray-100">Your Progress Hub</h1>
            {{-- Maybe add a quick link to profile or settings here --}}
        </div>
        
        {{-- Gamified Hero Section --}}
        <div class="bg-neutral-800 border border-neutral-700 rounded-xl p-6 flex flex-col md:flex-row items-center gap-6 shadow-lg hover:shadow-neutral-900/50 transition-shadow duration-300">
            {{-- User Avatar/Initials --}}
            <div class="flex-shrink-0">
                <div class="w-20 h-20 bg-emerald-500 rounded-full flex items-center justify-center text-3xl font-bold text-neutral-900 ring-4 ring-emerald-500/30">
                    {{ auth()->user()->initials() }}
                </div>
            </div>

            {{-- User Info & Level Progress --}}
            <div class="flex-1 text-center md:text-left">
                <h2 class="text-3xl font-light mb-1">Welcome back, <span class="font-semibold text-emerald-400">{{ explode(' ', auth()->user()->name)[0] }}</span>!</h2>
                @php
                    $userLevel = auth()->user()->getLevel();
                    $userPoints = auth()->user()->getPoints();
                    $pointsForNextLevel = auth()->user()->nextLevelAt(); // Returns points needed for next level, or 0 if max level
                    $currentLevelPoints = $pointsForNextLevel > 0 ? \LevelUp\Experience\Models\Level::where('level', $userLevel)->value('next_level_experience') ?? 0 : $userPoints; // Approx points for current level start
                    $pointsInCurrentLevel = $userPoints - $currentLevelPoints;
                    $pointsNeededForLevel = $pointsForNextLevel - $currentLevelPoints;
                    $levelProgress = $pointsNeededForLevel > 0 ? ($pointsInCurrentLevel / $pointsNeededForLevel) * 100 : 100;
                    // Ensure progress doesn't exceed 100 if pointsNeededForLevel is 0 or negative (max level case)
                    $levelProgress = max(0, min(100, $levelProgress));
                @endphp
                <p class="text-gray-400 mb-3">You are currently Level <span class="font-bold text-emerald-300">{{ $userLevel }}</span></p>

                {{-- XP Progress Bar --}}
                <div class="w-full bg-neutral-700 rounded-full h-4 mb-1 overflow-hidden border border-neutral-600">
                    <div class="bg-gradient-to-r from-emerald-600 to-emerald-400 h-full rounded-full transition-all duration-500 ease-out" style="width: {{ $levelProgress }}%"></div>
                </div>
                <div class="flex justify-between text-xs text-gray-400">
                    <span>{{ number_format($userPoints) }} XP</span>
                    @if($pointsForNextLevel > 0)
                        <span>{{ number_format($pointsForNextLevel - $userPoints) }} XP to Level {{ $userLevel + 1 }}</span>
                    @else
                        <span>Max Level Reached!</span>
                    @endif
            </div>
        </div>
        
            {{-- Quick Stats/Highlights (Optional: Could be separate cards) --}}
            <div class="flex flex-col items-center md:items-end gap-2 text-sm mt-4 md:mt-0">
        @php
                    // Fetching data similar to the original code
            $achievement = \App\Models\StudentAchievement::getLatestScore(auth()->id());
            $score = $achievement ? number_format($achievement->score, 2) : '0.00';
            $attendancePercentage = \App\Models\StudentAttendance::getAttendancePercentage(auth()->id());
            $credits = \App\Models\StudentCredit::getCreditsInfo(auth()->id());
            $completionPercentage = $credits ? $credits->completion_percentage : 0;
        @endphp
                <div class="flex items-center gap-2 bg-neutral-700/50 px-3 py-1 rounded-full border border-neutral-600">
                    <svg class="h-4 w-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    <span class="text-gray-300">Achievement Score: <span class="font-semibold text-white">{{ $score }}</span></span>
                </div>
                 <div class="flex items-center gap-2 bg-neutral-700/50 px-3 py-1 rounded-full border border-neutral-600">
                    <svg class="h-4 w-4 text-blue-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                    <span class="text-gray-300">Attendance: <span class="font-semibold text-white">{{ $attendancePercentage }}%</span></span>
                </div>
                 <div class="flex items-center gap-2 bg-neutral-700/50 px-3 py-1 rounded-full border border-neutral-600">
                     <svg class="h-4 w-4 text-purple-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 16c1.255 0 2.443-.29 3.5-.804V4.804zm2 0v10.392c1.057.514 2.245.804 3.5.804 1.255 0 2.443-.29 3.5-.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804z"></path></svg>
                    <span class="text-gray-300">Credits: <span class="font-semibold text-white">{{ $completionPercentage }}%</span></span>
                </div>
            </div>
        </div>

        {{-- Main Action Button (Start Learning) --}}
        <div class="w-full max-w-3xl mx-auto">
             <div class="relative rounded-xl bg-neutral-800 border border-neutral-700 overflow-hidden">
                 <a href="{{ route('learning') }}"
                    class="block w-full p-6 text-center rounded-xl border-2 border-emerald-500 bg-emerald-500/10
                        transition-all duration-300 ease-out hover:scale-[1.03] hover:shadow-lg hover:shadow-emerald-900/50 hover:bg-emerald-500/20
                        focus:outline-none focus:ring-4 focus:ring-emerald-500/50 active:scale-[0.98]
                        group relative overflow-hidden">

                     {{-- Background effect --}}
                     <div class="absolute inset-0 bg-[radial-gradient(circle,_rgba(16,185,129,0.2)_0%,_rgba(0,0,0,0)_70%)] opacity-50 group-hover:opacity-75 transition-opacity duration-300"></div>

                     {{-- Text --}}
                     <span class="relative text-xl font-semibold text-emerald-400 group-hover:text-emerald-300 transition-colors duration-300 drop-shadow-[0_0_10px_rgba(16,185,129,0.8)] glow">
                     Continue Learning Journey
                     </span>
                 </a>
                </div>
                </div>

        {{-- Grid for Leaderboard, Achievements, Activity --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Leaderboard Section --}}
            <div class="lg:col-span-1 bg-neutral-800 border border-neutral-700 rounded-xl p-6 shadow-lg hover:shadow-neutral-900/50 transition-shadow duration-300">
                <h3 class="text-lg font-medium text-gray-200 mb-4 flex items-center gap-2">
                    <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                    Leaderboard
                </h3>
                {{-- Assume $leaderboardData is passed from controller --}}
                @isset($leaderboardData)
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-neutral-700">
                                <th class="pb-2 text-sm text-gray-400 font-medium">Rank</th>
                                <th class="pb-2 text-sm text-gray-400 font-medium">Student</th>
                                <th class="pb-2 text-sm text-gray-400 font-medium text-right">XP</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($leaderboardData as $index => $entry)
                                <tr class="border-b border-neutral-700 last:border-b-0">
                                    <td class="py-2 text-sm @if($index == 0) text-yellow-400 @elseif($index == 1) text-gray-300 @elseif($index == 2) text-orange-400 @else text-gray-400 @endif font-semibold">
                                        @if($index == 0) 🥇 @elseif($index == 1) 🥈 @elseif($index == 2) 🥉 @endif {{ $index + 1 }}
                                    </td>
                                    <td class="py-2 text-sm text-gray-200">{{ $entry->user->name }}</td>
                                    <td class="py-2 text-sm text-emerald-400 font-medium text-right">{{ number_format($entry->points) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-4 text-center text-gray-500">Leaderboard is empty.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                @else
                     <p class="text-gray-500 text-sm">Leaderboard data is currently unavailable.</p>
                     {{-- Placeholder Static Data --}}
                     <table class="w-full text-left border-collapse mt-4">
                         <thead> <tr class="border-b border-neutral-700"> <th class="pb-2 text-sm text-gray-400 font-medium">Rank</th> <th class="pb-2 text-sm text-gray-400 font-medium">Student</th> <th class="pb-2 text-sm text-gray-400 font-medium text-right">XP</th> </tr> </thead>
                         <tbody> <tr class="border-b border-neutral-700"> <td class="py-2 text-sm text-yellow-400 font-semibold">🥇 1</td> <td class="py-2 text-sm text-gray-200">John Doe</td> <td class="py-2 text-sm text-emerald-400 font-medium text-right">1500</td> </tr> <tr class="border-b border-neutral-700"> <td class="py-2 text-sm text-gray-300 font-semibold">🥈 2</td> <td class="py-2 text-sm text-gray-200">Jane Smith</td> <td class="py-2 text-sm text-emerald-400 font-medium text-right">1300</td> </tr> <tr> <td class="py-2 text-sm text-orange-400 font-semibold">🥉 3</td> <td class="py-2 text-sm text-gray-200">Alex Johnson</td> <td class="py-2 text-sm text-emerald-400 font-medium text-right">1100</td> </tr> </tbody>
                     </table>
                @endisset
            </div>

            {{-- Achievements/Badges Section --}}
            <div class="lg:col-span-2 bg-neutral-800 border border-neutral-700 rounded-xl p-6 shadow-lg hover:shadow-neutral-900/50 transition-shadow duration-300">
                <h3 class="text-lg font-medium text-gray-200 mb-4 flex items-center gap-2">
                    <svg class="h-5 w-5 text-purple-400" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path></svg>
                    Your Achievements
                </h3>
                {{-- Assume $userBadges is passed from controller (using badges() relation for example) --}}
                @isset($userBadges)
                    @if($userBadges->count() > 0)
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                            @foreach($userBadges as $badge)
                                <div class="flex flex-col items-center p-3 bg-neutral-700/50 border border-neutral-600 rounded-lg text-center transition-transform duration-200 hover:scale-105" title="{{ $badge->description }}">
                                    {{-- Assuming badge model has 'image_url' and 'name' --}}
                                    <img src="{{ $badge->image_url ?? 'https://via.placeholder.com/48/cccccc/888888?text=B' }}" class="w-12 h-12 mx-auto mb-2 object-contain" alt="{{ $badge->name }}">
                                    <p class="text-gray-300 text-xs font-medium line-clamp-2">{{ $badge->name }}</p>
                                    {{-- Optionally show earned date --}}
                                    {{-- <p class="text-gray-500 text-[10px]">{{ $badge->pivot->earned_at->format('M d, Y') }}</p> --}}
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-sm">No achievements earned yet. Keep learning!</p>
                    @endif
                @else
                     <p class="text-gray-500 text-sm">Achievements data is currently unavailable.</p>
                     {{-- Placeholder Static Data --}}
                     <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 mt-4">
                         <div class="flex flex-col items-center p-3 bg-neutral-700/50 border border-neutral-600 rounded-lg text-center transition-transform duration-200 hover:scale-105" title="Awarded for top performance"> <img src="https://cdn-icons-png.flaticon.com/128/1828/1828640.png" class="w-12 h-12 mx-auto mb-2 object-contain" alt="Top Performer"> <p class="text-gray-300 text-xs font-medium line-clamp-2">Top Performer</p> </div>
                         <div class="flex flex-col items-center p-3 bg-neutral-700/50 border border-neutral-600 rounded-lg text-center transition-transform duration-200 hover:scale-105" title="Completed 100 assignments"> <img src="https://cdn-icons-png.flaticon.com/128/599/599502.png" class="w-12 h-12 mx-auto mb-2 object-contain" alt="100 Assignments"> <p class="text-gray-300 text-xs font-medium line-clamp-2">Assignment Master</p> </div>
                         <div class="flex flex-col items-center p-3 bg-neutral-700/50 border border-neutral-600 rounded-lg text-center transition-transform duration-200 hover:scale-105" title="Maintained a 7-day study streak"> <img src="https://cdn-icons-png.flaticon.com/128/4436/4436481.png" class="w-12 h-12 mx-auto mb-2 object-contain" alt="7-Day Streak"> <p class="text-gray-300 text-xs font-medium line-clamp-2">Study Streak</p> </div>
                         {{-- Add more placeholders if needed --}}
                </div>
                @endisset
                 {{-- Link to view all achievements --}}
                 <div class="mt-4 text-right">
                     <a href="#" class="text-sm text-emerald-400 hover:text-emerald-300 hover:underline">View All Achievements &rarr;</a>
                </div>
            </div>
        </div>

        {{-- Activity Graph --}}
        {{-- NOTE: This still uses the placeholder JS. Needs backend data integration. --}}
        <div class="relative overflow-hidden rounded-xl border border-neutral-700 bg-neutral-800 p-6 shadow-lg hover:shadow-neutral-900/50 transition-shadow duration-300" style="min-height: 350px; height: 400px;">
            <h3 class="text-lg font-medium text-gray-200 mb-4 flex items-center gap-2">
                <svg class="h-5 w-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                Your Activity
            </h3>
            <div class="flex flex-col gap-2 h-[calc(100%-3rem)]">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="text-xs text-gray-400">Less</div>
                        <div class="flex items-center gap-1">
                            <div class="h-3 w-3 rounded-sm bg-neutral-700"></div>
                            <div class="h-3 w-3 rounded-sm bg-emerald-900"></div>
                            <div class="h-3 w-3 rounded-sm bg-emerald-700"></div>
                            <div class="h-3 w-3 rounded-sm bg-emerald-500"></div>
                            <div class="h-3 w-3 rounded-sm bg-emerald-300"></div>
                        </div>
                        <div class="text-xs text-gray-400">More</div>
                    </div>
                    {{-- <div class="text-xs text-gray-400">Learn how we count contributions</div> --}}
                </div>
                <div class="overflow-x-auto h-full">
                    <div class="contribution-calendar min-w-[700px] h-full">
                        {{-- The script below will populate this div --}}
                        <div id="contributionGraph" class="mt-2 w-full h-[calc(100%-0.5rem)]"></div>
                    </div>
                </div>
            </div>
            {{-- Keep the existing script for now, but ideally replace generateData() with data passed from PHP --}}
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // TODO: Replace generateData() with actual data fetched from the server
                    // Example: const graphData = @json($activityData ?? []);

                    // Configuration
                    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                    const days = ['S', 'M', 'T', 'W', 'T', 'F', 'S']; // Full week for standard contribution graph
                    
                    // Generate a year of data (Placeholder)
                    function generateData() {
                        const data = {};
                        const now = new Date();
                        const oneYearAgo = new Date(now);
                        oneYearAgo.setFullYear(now.getFullYear() - 1);

                        let currentDate = new Date(oneYearAgo);
                        while (currentDate <= now) {
                            const dateStr = currentDate.toISOString().split('T')[0];
                            // Simulate varying activity levels
                            const activityLevel = Math.random() < 0.7 ? 0 : Math.floor(Math.random() * 4) + 1; // 70% chance of no activity
                            data[dateStr] = activityLevel;
                            currentDate.setDate(currentDate.getDate() + 1);
                        }
                        return data;
                    }
                    
                    // Create the contribution graph (GitHub style)
                    function createContributionGraph() {
                        const graphContainer = document.getElementById('contributionGraph');
                        if (!graphContainer) return;

                        const graphData = generateData(); // Use generated data for now
                        graphContainer.innerHTML = ''; // Clear existing

                        const endDate = new Date();
                        const startDate = new Date();
                        startDate.setFullYear(endDate.getFullYear() - 1);
                        startDate.setDate(startDate.getDate() + (7 - startDate.getDay())); // Start on the first Sunday of the view

                        const weeks = {};
                        let currentDate = new Date(startDate);

                        // Group data by week (Sunday as start of week)
                        while (currentDate <= endDate) {
                            const weekStart = new Date(currentDate);
                            weekStart.setDate(currentDate.getDate() - currentDate.getDay());
                            const weekKey = weekStart.toISOString().split('T')[0];

                            if (!weeks[weekKey]) {
                                weeks[weekKey] = Array(7).fill(null); // 7 days per week
                            }

                            const dayOfWeek = currentDate.getDay();
                            const dateStr = currentDate.toISOString().split('T')[0];
                            weeks[weekKey][dayOfWeek] = {
                                date: dateStr,
                                level: graphData[dateStr] || 0
                            };

                            currentDate.setDate(currentDate.getDate() + 1);
                        }

                        // Create graph elements
                        const graphGrid = document.createElement('div');
                        graphGrid.className = 'flex gap-1 h-full items-end'; // Use items-end to align weeks

                        // Add Day Labels (Optional, can be implicit)
                        // const dayLabelCol = document.createElement('div');
                        // dayLabelCol.className = 'flex flex-col gap-1 mr-1 text-xs text-gray-500 justify-between h-[calc(7*1rem+6*0.25rem)]'; // Adjust height based on cell size + gap
                        // days.forEach(day => dayLabelCol.innerHTML += `<div class="h-4">${day}</div>`);
                        // graphGrid.appendChild(dayLabelCol);

                        // Add Month Labels (Above the grid)
                        const monthLabels = document.createElement('div');
                        monthLabels.className = 'flex justify-between text-xs text-gray-500 mb-1 px-[calc(1rem+0.25rem)]'; // Adjust padding based on cell size + gap
                        const monthPositions = {};
                        Object.keys(weeks).sort().forEach((weekKey, index) => {
                            const weekDate = new Date(weekKey);
                            const month = weekDate.getMonth();
                            if (index === 0 || new Date(Object.keys(weeks).sort()[index - 1]).getMonth() !== month) {
                                monthPositions[months[month]] = index;
                            }
                        });
                        // This part needs refinement to position month labels correctly above columns
                        // For simplicity, we might omit dynamic month labels here or use a library

                        // Add Week Columns
                        Object.keys(weeks).sort().forEach(weekKey => {
                            const weekCol = document.createElement('div');
                            weekCol.className = 'flex flex-col gap-1';
                            weeks[weekKey].forEach(dayData => {
                                const dayCell = document.createElement('div');
                                dayCell.className = 'h-4 w-4 rounded-sm'; // Cell size
                                if (dayData) {
                                    let bgColor = 'bg-neutral-700'; // Level 0
                                    if (dayData.level === 1) bgColor = 'bg-emerald-900';
                                    if (dayData.level === 2) bgColor = 'bg-emerald-700';
                                    if (dayData.level === 3) bgColor = 'bg-emerald-500';
                                    if (dayData.level >= 4) bgColor = 'bg-emerald-300'; // Level 4+
                                    dayCell.classList.add(bgColor);
                                    dayCell.title = `${dayData.date}: ${dayData.level} activities`;
                                } else {
                                    dayCell.classList.add('bg-transparent'); // Empty cell for days outside the range in a week
                                }
                                weekCol.appendChild(dayCell);
                            });
                            graphGrid.appendChild(weekCol);
                        });

                        // graphContainer.appendChild(monthLabels); // Add month labels if implemented
                        graphContainer.appendChild(graphGrid);
                    }
                    
                    createContributionGraph();
                });
            </script>
        </div>
        

        {{-- Quick Links/Actions --}}
        <div class="w-full">
             <h3 class="text-lg font-medium text-gray-200 mb-4 flex items-center gap-2">
                 <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                 Quick Actions
             </h3>
             <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                 <a href="{{ route('courses') }}" class="flex flex-col items-center justify-center p-4 rounded-xl border border-neutral-700 bg-neutral-800 transition-all duration-300 hover:bg-neutral-700/50 hover:border-emerald-600 hover:scale-[1.03] hover:shadow-lg hover:shadow-neutral-900/50 group">
                     <svg class="h-8 w-8 text-emerald-500 mb-2 group-hover:text-emerald-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/> </svg>
                     <span class="text-sm font-medium text-gray-300 group-hover:text-white transition-colors">View Courses</span>
                 </a>
                 <a href="{{ route('assignments') }}" class="flex flex-col items-center justify-center p-4 rounded-xl border border-neutral-700 bg-neutral-800 transition-all duration-300 hover:bg-neutral-700/50 hover:border-emerald-600 hover:scale-[1.03] hover:shadow-lg hover:shadow-neutral-900/50 group">
                     <svg class="h-8 w-8 text-emerald-500 mb-2 group-hover:text-emerald-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/> </svg>
                     <span class="text-sm font-medium text-gray-300 group-hover:text-white transition-colors">Assignments</span>
                 </a>
                 <a href="{{ route('grades') }}" class="flex flex-col items-center justify-center p-4 rounded-xl border border-neutral-700 bg-neutral-800 transition-all duration-300 hover:bg-neutral-700/50 hover:border-emerald-600 hover:scale-[1.03] hover:shadow-lg hover:shadow-neutral-900/50 group">
                     <svg class="h-8 w-8 text-emerald-500 mb-2 group-hover:text-emerald-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/> </svg>
                     <span class="text-sm font-medium text-gray-300 group-hover:text-white transition-colors">Check Grades</span>
                 </a>
                 <a href="{{ route('profile') }}" class="flex flex-col items-center justify-center p-4 rounded-xl border border-neutral-700 bg-neutral-800 transition-all duration-300 hover:bg-neutral-700/50 hover:border-emerald-600 hover:scale-[1.03] hover:shadow-lg hover:shadow-neutral-900/50 group">
                     <svg class="h-8 w-8 text-emerald-500 mb-2 group-hover:text-emerald-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/> </svg>
                     <span class="text-sm font-medium text-gray-300 group-hover:text-white transition-colors">Your Profile</span>
                 </a>
                 {{-- Add other relevant links like Schedule, Materials if needed --}}
            </div>
        </div>

        {{-- Removed old sections like Stats Cards (integrated above), Collaboration Tools, Recent Chats, old Badges, old Leaderboard --}}

    </div>
</x-layouts.app>

