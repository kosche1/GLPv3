<x-layouts.app>

    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
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
        
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="flex flex-col p-6 rounded-xl border border-neutral-700 bg-neutral-800 transition-all duration-300 ease-in-out hover:scale-[1.02] hover:shadow-lg hover:shadow-neutral-900/50 hover:border-neutral-600 hover:bg-neutral-800/90">
                <h3 class="text-sm font-medium text-neutral-400 mb-4">Upcoming Assignments</h3>
                <div class="space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="flex-shrink-0 w-6 h-6 rounded-full bg-red-500 flex items-center justify-center text-white text-xs font-medium">!</div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-white">Math 101 - Problem Set</p>
                            <p class="text-xs text-neutral-400">Due: Tomorrow</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="flex-shrink-0 w-6 h-6 rounded-full bg-orange-500 flex items-center justify-center text-white text-xs font-medium">0</div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-white">History Essay</p>
                            <p class="text-xs text-neutral-400">Due: 3 days</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="flex-shrink-0 w-6 h-6 rounded-full bg-blue-500 flex items-center justify-center text-white text-xs font-medium">P</div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-white">Physics Lab Report</p>
                            <p class="text-xs text-neutral-400">Due: 1 week</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-col p-6 rounded-xl border border-neutral-700 bg-neutral-800 transition-all duration-300 ease-in-out hover:scale-[1.02] hover:shadow-lg hover:shadow-neutral-900/50 hover:border-neutral-600 hover:bg-neutral-800/90">
                <h3 class="text-sm font-medium text-neutral-400 mb-4">Class Schedule (Today)</h3>
                <div class="space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="flex-shrink-0 w-6 h-6 rounded-full bg-emerald-500 flex items-center justify-center text-white text-xs font-medium">09</div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-white">9:00 AM - Math 101</p>
                            <p class="text-xs text-neutral-400">Room 201</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="flex-shrink-0 w-6 h-6 rounded-full bg-violet-500 flex items-center justify-center text-white text-xs font-medium">11</div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-white">11:00 AM - History</p>
                            <p class="text-xs text-neutral-400">Room 305</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="flex-shrink-0 w-6 h-6 rounded-full bg-amber-500 flex items-center justify-center text-white text-xs font-medium">02</div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-white">2:00 PM - Physics Lab</p>
                            <p class="text-xs text-neutral-400">Room 102</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-col p-6 rounded-xl border border-neutral-700 bg-neutral-800 transition-all duration-300 ease-in-out hover:scale-[1.02] hover:shadow-lg hover:shadow-neutral-900/50 hover:border-neutral-600 hover:bg-neutral-800/90">
                <h3 class="text-sm font-medium text-neutral-400 mb-4">Quick Links</h3>
                <div class="flex flex-col gap-2">
                    <a href="#" class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium text-center transition-colors inline-flex items-center gap-2">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        Access Online Library
                    </a>
                    <a href="#" class="w-full px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-medium text-center transition-colors inline-flex items-center gap-2">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                        </svg>
                        Contact Advisor
                    </a>
                    <a href="#" class="w-full px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-lg text-sm font-medium text-center transition-colors inline-flex items-center gap-2">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        View Exam Schedule
                    </a>
                </div>
            </div>
        </div>

</x-layouts.app>
