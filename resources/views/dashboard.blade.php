<x-layouts.app>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl" id="app">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold text-white">Dashboard</h1>
            <a href="{{ route('learning') }}" class="flex flex-col items-center justify-center p-4 rounded-xl border-2 border-emerald-500 bg-emerald-500/10 transition-all duration-300 hover:scale-[1.02] hover:shadow-lg hover:shadow-emerald-900/50 hover:bg-emerald-500/20 group">
                <span class="text-lg font-semibold text-emerald-400 group-hover:text-emerald-300">Start Now</span>
                <!-- <span class="text-sm text-neutral-400 mt-1">Begin Learning</span> -->
            </a>
        </div>
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="flex flex-col justify-between p-6 rounded-xl border border-neutral-700 bg-neutral-800 transition-all duration-300 ease-in-out hover:scale-[1.02] hover:shadow-lg hover:shadow-neutral-900/50 hover:border-neutral-600 hover:bg-neutral-800/90">
                <div class="space-y-1">
                    <h3 class="text-sm font-medium text-neutral-400">Achievements</h3>
                    <p class="text-2xl font-semibold text-white">3.75</p>
                </div>
                <div class="inline-flex items-center text-sm font-medium text-green-400">
                    +0.15
                    <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
            </div>
            <div class="flex flex-col justify-between p-6 rounded-xl border border-neutral-700 bg-neutral-800 transition-all duration-300 ease-in-out hover:scale-[1.02] hover:shadow-lg hover:shadow-neutral-900/50 hover:border-neutral-600 hover:bg-neutral-800/90">
                <div class="space-y-1">
                    <h3 class="text-sm font-medium text-neutral-400">Attendance</h3>
                    <p class="text-2xl font-semibold text-white">95%</p>
                </div>
                <div class="inline-flex items-center text-sm font-medium text-green-400">
                    +2%
                    <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
            </div>
            <div class="flex flex-col justify-between p-6 rounded-xl border border-neutral-700 bg-neutral-800 transition-all duration-300 ease-in-out hover:scale-[1.02] hover:shadow-lg hover:shadow-neutral-900/50 hover:border-neutral-600 hover:bg-neutral-800/90">
                <div class="space-y-1">
                    <h3 class="text-sm font-medium text-neutral-400">Credits Completed</h3>
                    <p class="text-2xl font-semibold text-white">45/120</p>
                </div>
                <div class="text-sm font-medium text-neutral-400">
                    37.5% completed
                </div>
            </div>
        </div>

        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-700 bg-neutral-800 p-6" style="min-height: 400px; height: 500px;">
            <h3 class="text-sm font-medium text-neutral-400 mb-4">Course Performance</h3>
            <div class="flex flex-col gap-2 h-[calc(100%-2rem)]">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="text-xs text-neutral-400">Less</div>
                        <div class="flex items-center gap-1">
                            <div class="h-3 w-3 rounded-sm bg-neutral-700"></div>
                            <div class="h-3 w-3 rounded-sm bg-green-900"></div>
                            <div class="h-3 w-3 rounded-sm bg-green-700"></div>
                            <div class="h-3 w-3 rounded-sm bg-green-500"></div>
                            <div class="h-3 w-3 rounded-sm bg-green-300"></div>
                        </div>
                        <div class="text-xs text-neutral-400">More</div>
                    </div>
                    <div class="text-xs text-neutral-400">Learn how we count contributions</div>
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
                        monthsRow.className = 'flex text-xs text-neutral-400 mb-1';
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
                        daysCol.className = 'flex flex-col w-8 text-xs text-neutral-400 justify-between py-1';
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
                                if (activityLevel === 1) bgColor = 'bg-green-900';
                                if (activityLevel === 2) bgColor = 'bg-green-700';
                                if (activityLevel === 3) bgColor = 'bg-green-500';
                                if (activityLevel === 4) bgColor = 'bg-green-300';
                                
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
        
        <div class="grid gap-6 md:grid-cols-3">
            <div class="flex flex-col p-6 rounded-xl border border-neutral-700 bg-neutral-800 transition-all duration-300 ease-in-out hover:scale-[1.02] hover:shadow-lg hover:shadow-neutral-900/50 hover:border-neutral-600 hover:bg-neutral-800/90">
                <h3 class="text-sm font-medium text-neutral-400 mb-4">Upcoming Challenges</h3>
                <div class="bg-neutral-800 border border-neutral-700 overflow-hidden shadow-sm sm:rounded-lg transition-all duration-300 ease-in-out hover:scale-[1.01] hover:shadow-lg hover:shadow-neutral-700/20">
                    <div class="flex justify-between items-center px-6 py-4">
                        <div class="flex items-center">
                            <div class="mx-3">
                                <h3 class="text-lg font-medium text-gray-700 dark:text-gray-200">
                                    Math 101 - Problem Set
                                </h3>
                                <p class="text-gray-500 dark:text-gray-400">High Priority</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="h-6 w-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="w-full">
                                <div class="flex justify-between mb-2">
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-200">Time Remaining</span>
                                    <span class="text-sm font-medium text-red-500">Due Tomorrow</span>
                                </div>
                                <div class="relative h-2 bg-gray-200 rounded overflow-hidden dark:bg-gray-800">
                                    <div class="absolute left-0 top-0 h-full bg-red-500 w-[90%]"></div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 space-y-3">
                            <div class="flex items-center gap-3">
                                <div class="flex-shrink-0 w-6 h-6 rounded-full bg-orange-500 flex items-center justify-center text-white text-xs font-medium">H</div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-700 dark:text-gray-200">History Essay</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Due in 3 days</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-col p-6 rounded-xl border border-neutral-700 bg-neutral-800 transition-all duration-300 ease-in-out hover:scale-[1.02] hover:shadow-lg hover:shadow-neutral-900/50 hover:border-neutral-600 hover:bg-neutral-800/90">
                <h3 class="text-sm font-medium text-neutral-400 mb-4">Active Challenges</h3>
                <div class="bg-neutral-800 border border-neutral-700 overflow-hidden shadow-sm sm:rounded-lg transition-all duration-300 ease-in-out hover:scale-[1.01] hover:shadow-lg hover:shadow-neutral-700/20">
                    <div class="flex justify-between items-center px-6 py-4">
                        <div class="flex items-center">
                            <div class="mx-3">
                                <h3 class="text-lg font-medium text-gray-700 dark:text-gray-200">
                                    Data Structures Challenge
                                </h3>
                                <p class="text-gray-500 dark:text-gray-400">Advanced Level</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="h-6 w-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            <svg class="h-6 w-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="w-full">
                                <div class="flex justify-between mb-2">
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-200">Progress</span>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-200">75%</span>
                                </div>
                                <div class="relative h-2 bg-gray-200 rounded overflow-hidden dark:bg-gray-800">
                                    <div class="absolute left-0 top-0 h-full bg-emerald-500 w-3/4"></div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 flex justify-between items-center text-sm text-gray-500 dark:text-gray-400">
                            <span>Tasks Completed: 6/8</span>
                            <span>2 days left</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col p-6 rounded-xl border border-neutral-700 bg-neutral-800 transition-all duration-300 ease-in-out hover:scale-[1.02] hover:shadow-lg hover:shadow-neutral-900/50 hover:border-neutral-600 hover:bg-neutral-800/90">
                <h3 class="text-sm font-medium text-neutral-400 mb-4">Student Progress Overview</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="p-4 rounded-lg bg-blue-600/10 border border-blue-600/20">
                        <div class="flex items-center gap-3">
                            <svg class="h-5 w-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            <div>
                                <p class="text-sm text-neutral-400">Current GPA</p>
                                <p class="text-lg font-semibold text-white">3.85</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 rounded-lg bg-emerald-600/10 border border-emerald-600/20">
                        <div class="flex items-center gap-3">
                            <svg class="h-5 w-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                            <div>
                                <p class="text-sm text-neutral-400">Assignments</p>
                                <p class="text-lg font-semibold text-white">85%</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Quick Links Section -->
        <div class="grid gap-4 md:grid-cols-3 lg:grid-cols-6 mb-6">
            <a href="{{ route('courses') }}" class="flex items-center p-4 rounded-xl border border-neutral-700 bg-neutral-800 transition-all duration-300 hover:scale-[1.02] hover:shadow-lg hover:shadow-neutral-900/50 hover:border-neutral-600 hover:bg-neutral-800/90">
                <svg class="h-6 w-6 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                </svg>
                <span class="ml-3 text-sm font-medium text-neutral-400">Courses</span>
            </a>
            <a href="{{ route('learning-materials') }}" class="flex items-center p-4 rounded-xl border border-neutral-700 bg-neutral-800 transition-all duration-300 hover:scale-[1.02] hover:shadow-lg hover:shadow-neutral-900/50 hover:border-neutral-600 hover:bg-neutral-800/90">
                <svg class="h-6 w-6 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <span class="ml-3 text-sm font-medium text-neutral-400">Materials</span>
            </a>
            <a href="{{ route('assignments') }}" class="flex items-center p-4 rounded-xl border border-neutral-700 bg-neutral-800 transition-all duration-300 hover:scale-[1.02] hover:shadow-lg hover:shadow-neutral-900/50 hover:border-neutral-600 hover:bg-neutral-800/90">
                <svg class="h-6 w-6 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <span class="ml-3 text-sm font-medium text-neutral-400">Assignments</span>
            </a>
            <a href="{{ route('profile') }}" class="flex items-center p-4 rounded-xl border border-neutral-700 bg-neutral-800 transition-all duration-300 hover:scale-[1.02] hover:shadow-lg hover:shadow-neutral-900/50 hover:border-neutral-600 hover:bg-neutral-800/90">
                <svg class="h-6 w-6 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <span class="ml-3 text-sm font-medium text-neutral-400">Profile</span>
            </a>
            <a href="{{ route('schedule') }}" class="flex items-center p-4 rounded-xl border border-neutral-700 bg-neutral-800 transition-all duration-300 hover:scale-[1.02] hover:shadow-lg hover:shadow-neutral-900/50 hover:border-neutral-600 hover:bg-neutral-800/90">
                <svg class="h-6 w-6 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span class="ml-3 text-sm font-medium text-neutral-400">Schedule</span>
            </a>
            <a href="{{ route('grades') }}" class="flex items-center p-4 rounded-xl border border-neutral-700 bg-neutral-800 transition-all duration-300 hover:scale-[1.02] hover:shadow-lg hover:shadow-neutral-900/50 hover:border-neutral-600 hover:bg-neutral-800/90">
                <svg class="h-6 w-6 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                <span class="ml-3 text-sm font-medium text-neutral-400">Grades</span>
            </a>
        </div>
</x-layouts.app>