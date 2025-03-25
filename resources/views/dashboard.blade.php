<x-layouts.app>
    <div class="flex h-full w-full flex-1 flex-col gap-6 bg-neutral-800 text-gray-100 p-6" id="app">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-medium text-gray-100">Student's Dashboard</h1>
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
        
        <!-- Stats Cards -->
        <div class="grid auto-rows-min gap-4 md:grid-cols-3 mb-8">
            <div class="flex flex-col justify-between p-6 rounded-xl border border-neutral-700 bg-neutral-800 transition-all duration-300 hover:bg-neutral-800/90 hover:border-neutral-600 hover:scale-[1.02] hover:shadow-lg hover:shadow-neutral-900/50">
                <div class="space-y-1">
                    <h3 class="text-sm font-medium text-gray-400">Achievements</h3>
                    <p class="text-2xl font-semibold text-white">3.75</p>
                </div>
                <div class="inline-flex items-center text-sm font-medium text-green-400">
                    +0.15
                    <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
            </div>
            <div class="flex flex-col justify-between p-6 rounded-xl border border-neutral-700 bg-neutral-800 transition-all duration-300 hover:bg-neutral-800/90 hover:border-neutral-600 hover:scale-[1.02] hover:shadow-lg hover:shadow-neutral-900/50">
                <div class="space-y-1">
                    <h3 class="text-sm font-medium text-gray-400">Attendance</h3>
                    <p class="text-2xl font-semibold text-white">95%</p>
                </div>
                <div class="inline-flex items-center text-sm font-medium text-green-400">
                    +2%
                    <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
            </div>
            <div class="flex flex-col justify-between p-6 rounded-xl border border-neutral-700 bg-neutral-800 transition-all duration-300 hover:bg-neutral-800/90 hover:border-neutral-600 hover:scale-[1.02] hover:shadow-lg hover:shadow-neutral-900/50">
                <div class="space-y-1">
                    <h3 class="text-sm font-medium text-gray-400">Credits Completed</h3>
                    <p class="text-2xl font-semibold text-white">45/120</p>
                </div>
                <div class="text-sm font-medium text-gray-400">
                    37.5% completed
                </div>
            </div>
        </div>

        
        <!-- Activity Graph -->
        <div class="relative overflow-hidden rounded-xl border border-neutral-700 bg-neutral-800 p-6 mb-8" style="min-height: 400px; height: 500px;">
            <h3 class="text-sm font-medium text-gray-400 mb-4">Course Performance</h3>
            <div class="flex flex-col gap-2 h-[calc(100%-2rem)]">
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
                    <div class="text-xs text-gray-400">Learn how we count contributions</div>
                </div>
                <div class="overflow-x-auto h-full">
                    <div class="contribution-calendar min-w-[800px] h-full">
                        <div id="contributionGraph" class="mt-2 w-full h-[calc(100%-0.5rem)]"></div>
                    </div>
                </div>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    console.log('DOM Content Loaded');
                    // Configuration
                    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                    const days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'];
                    
                    // Generate a year of data (for demo purposes)
                    function generateData() {
                        console.log('Generating data');
                        const data = {};
                        const now = new Date();
                        const currentYear = now.getFullYear();
                        
                        // Start from 12 months ago
                        const startDate = new Date(now);
                        startDate.setMonth(now.getMonth() - 11);
                        startDate.setDate(1);
                        
                        // Generate random activity data for each day
                        let currentDate = new Date(startDate);
                        while (currentDate <= now) {
                            const dateStr = currentDate.toISOString().split('T')[0];
                            const randomActivity = Math.floor(Math.random() * 5);
                            data[dateStr] = randomActivity;
                            currentDate.setDate(currentDate.getDate() + 1);
                        }
                        
                        return data;
                    }
                    
                    // Create the contribution graph
                    function createContributionGraph() {
                        console.log('Creating contribution graph');
                        const graphContainer = document.getElementById('contributionGraph');
                        
                        if (!graphContainer) {
                            console.error('Graph container not found!');
                            return;
                        }
                        
                        const graphData = generateData();
                        
                        // Clear existing content
                        graphContainer.innerHTML = '';
                        
                        // Create month labels
                        const monthsRow = document.createElement('div');
                        monthsRow.className = 'flex text-xs text-gray-500 mb-1';
                        monthsRow.innerHTML = '<div class="w-8"></div>';
                        
                        // Get the start and end dates
                        const dates = Object.keys(graphData).sort();
                        const startDate = new Date(dates[0]);
                        const endDate = new Date(dates[dates.length - 1]);
                        
                        // Add month labels
                        let currentMonth = startDate.getMonth();
                        for (let m = 0; m < 12; m++) {
                            const monthIndex = (startDate.getMonth() + m) % 12;
                            const monthWidth = m === 11 ? 'flex-1' : 'w-[60px]';
                            monthsRow.innerHTML += `<div class="${monthWidth} text-center">${months[monthIndex]}</div>`;
                        }
                        
                        graphContainer.appendChild(monthsRow);
                        
                        // Create the grid
                        const grid = document.createElement('div');
                        grid.className = 'flex h-full';
                        
                        // Create day labels column
                        const daysCol = document.createElement('div');
                        daysCol.className = 'flex flex-col w-8 text-xs text-gray-500 justify-between py-1';
                        daysCol.innerHTML = days.map(day => `<div class="h-4">${day}</div>`).join('');
                        
                        grid.appendChild(daysCol);
                        
                        // Create the weeks container
                        const weeksContainer = document.createElement('div');
                        weeksContainer.className = 'flex flex-1 gap-1';
                        
                        // Calculate number of weeks
                        const millisecondsPerWeek = 7 * 24 * 60 * 60 * 1000;
                        const totalWeeks = Math.ceil((endDate - startDate) / millisecondsPerWeek);
                        
                        // Create week columns
                        for (let week = 0; week < totalWeeks; week++) {
                            const weekCol = document.createElement('div');
                            weekCol.className = 'flex flex-col gap-1 w-4';
                            
                            for (let day = 0; day < 5; day++) {
                                const currentDate = new Date(startDate);
                                currentDate.setDate(startDate.getDate() + (week * 7) + day);
                                
                                if (currentDate > new Date()) {
                                    weekCol.innerHTML += '<div class="h-4 w-4"></div>';
                                    continue;
                                }
                                
                                const dateStr = currentDate.toISOString().split('T')[0];
                                const activityLevel = graphData[dateStr] || 0;
                                
                                let bgColor = 'bg-neutral-700';
                                if (activityLevel === 1) bgColor = 'bg-emerald-900';
                                if (activityLevel === 2) bgColor = 'bg-emerald-700';
                                if (activityLevel === 3) bgColor = 'bg-emerald-500';
                                if (activityLevel === 4) bgColor = 'bg-emerald-300';
                                
                                weekCol.innerHTML += `
                                    <div class="h-4 w-4 rounded-sm ${bgColor}" 
                                         title="${currentDate.toDateString()}: ${activityLevel} contributions">
                                    </div>`;
                            }
                            
                            weeksContainer.appendChild(weekCol);
                        }
                        
                        grid.appendChild(weeksContainer);
                        graphContainer.appendChild(grid);
                        console.log('Graph creation completed');
                    }
                    
                    createContributionGraph();
                });
            </script>
        </div>
        
        <!-- Leaderboard Section -->
        <div class="w-full max-w-3xl mx-auto mb-8">
            <h3 class="text-lg font-medium text-gray-200 mb-4">Leaderboard</h3>
            <div class="bg-neutral-800 border border-neutral-700 rounded-xl p-6">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-neutral-700">
                            <th class="pb-2 text-gray-400">Rank</th>
                            <th class="pb-2 text-gray-400">Student</th>
                            <th class="pb-2 text-gray-400">XP</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b border-neutral-700">
                            <td class="py-2 text-emerald-400">🥇 1</td>
                            <td class="py-2">John Doe</td>
                            <td class="py-2 text-green-400">1500 XP</td>
                        </tr>
                        <tr class="border-b border-neutral-700">
                            <td class="py-2 text-yellow-400">🥈 2</td>
                            <td class="py-2">Jane Smith</td>
                            <td class="py-2 text-green-400">1300 XP</td>
                        </tr>
                        <tr class="border-b border-neutral-700">
                            <td class="py-2 text-gray-400">🥉 3</td>
                            <td class="py-2">Alex Johnson</td>
                            <td class="py-2 text-green-400">1100 XP</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Badges Section -->
        <div class="w-full max-w-3xl mx-auto mb-8">
            <h3 class="text-lg font-medium text-gray-200 mb-4">Badges Earned</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="p-4 bg-neutral-800 border border-neutral-700 rounded-xl text-center">
                    <img src="https://cdn-icons-png.flaticon.com/128/1828/1828640.png" class="w-12 mx-auto mb-2" alt="Achievement">
                    <p class="text-gray-200 text-sm">Top Performer</p>
                </div>
                <div class="p-4 bg-neutral-800 border border-neutral-700 rounded-xl text-center">
                    <img src="https://cdn-icons-png.flaticon.com/128/599/599502.png" class="w-12 mx-auto mb-2" alt="Assignment Completed">
                    <p class="text-gray-200 text-sm">100 Assignments</p>
                </div>
                <div class="p-4 bg-neutral-800 border border-neutral-700 rounded-xl text-center">
                    <img src="https://cdn-icons-png.flaticon.com/128/4436/4436481.png" class="w-12 mx-auto mb-2" alt="Study Streak">
                    <p class="text-gray-200 text-sm">7-Day Streak</p>
                </div>
                <div class="p-4 bg-neutral-800 border border-neutral-700 rounded-xl text-center">
                    <img src="https://cdn-icons-png.flaticon.com/128/3106/3106776.png" class="w-12 mx-auto mb-2" alt="Collaborator">
                    <p class="text-gray-200 text-sm">Collaboration King</p>
                </div>
            </div>
        </div>

        
        <!-- Recent Chats Section (Claude-style) -->
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-200">Your recent activities</h3>
            </div>
            <a href="#" class="text-sm text-gray-400 hover:text-gray-300 flex items-center">
                View all
                <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
        
        <!-- Quick Links Section -->
        <div class="grid gap-4 md:grid-cols-3 lg:grid-cols-6 mb-6">
            <a href="{{ route('courses') }}" class="flex items-center p-4 rounded-xl border border-neutral-700 bg-neutral-800 transition-all duration-300 hover:bg-neutral-800/90 hover:border-neutral-600 hover:scale-[1.02] hover:shadow-lg hover:shadow-neutral-900/50">
                <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-li  viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                </svg>
                <span class="ml-3 text-sm font-medium text-gray-400">Courses</span>
            </a>
            <a href="{{ route('learning-materials') }}" class="flex items-center p-4 rounded-xl border border-neutral-700 bg-neutral-800 transition-all duration-300 hover:bg-neutral-800/90 hover:border-neutral-600 hover:scale-[1.02] hover:shadow-lg hover:shadow-neutral-900/50">
                <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <span class="ml-3 text-sm font-medium text-gray-400">Materials</span>
            </a>
            <a href="{{ route('assignments') }}" class="flex items-center p-4 rounded-xl border border-neutral-700 bg-neutral-800 transition-all duration-300 hover:bg-neutral-800/90 hover:border-neutral-600 hover:scale-[1.02] hover:shadow-lg hover:shadow-neutral-900/50">
                <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <span class="ml-3 text-sm font-medium text-gray-400">Assignments</span>
            </a>
            <a href="{{ route('profile') }}" class="flex items-center p-4 rounded-xl border border-neutral-700 bg-neutral-800 transition-all duration-300 hover:bg-neutral-800/90 hover:border-neutral-600 hover:scale-[1.02] hover:shadow-lg hover:shadow-neutral-900/50">
                <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <span class="ml-3 text-sm font-medium text-gray-400">Profile</span>
            </a>
            <a href="{{ route('schedule') }}" class="flex items-center p-4 rounded-xl border border-neutral-700 bg-neutral-800 transition-all duration-300 hover:bg-neutral-800/90 hover:border-neutral-600 hover:scale-[1.02] hover:shadow-lg hover:shadow-neutral-900/50">
                <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span class="ml-3 text-sm font-medium text-gray-400">Schedule</span>
            </a>
            <a href="{{ route('grades') }}" class="flex items-center p-4 rounded-xl border border-neutral-700 bg-neutral-800 transition-all duration-300 hover:bg-neutral-800/90 hover:border-neutral-600 hover:scale-[1.02] hover:shadow-lg hover:shadow-neutral-900/50">
                <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                <span class="ml-3 text-sm font-medium text-gray-400">Grades</span>
            </a>
        </div>
    </div>
</x-layouts.app>

