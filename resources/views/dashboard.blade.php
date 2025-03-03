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

        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-700 bg-neutral-800 p-6">
            <h3 class="text-sm font-medium text-neutral-400 mb-4">Course Performance</h3>
            <div class="h-[600px]">
                <canvas id="coursePerformanceChart"></canvas>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                const ctx = document.getElementById('coursePerformanceChart');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                        datasets: [{
                            label: 'Math 101',
                            data: [85, 88, 82, 90, 85, 88, 86],
                            borderColor: 'rgb(59, 130, 246)',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            borderWidth: 3,
                            tension: 0.4,
                            fill: true,
                            pointBackgroundColor: 'rgb(59, 130, 246)',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6
                        }, {
                            label: 'History',
                            data: [78, 82, 85, 83, 86, 88, 84],
                            borderColor: 'rgb(139, 92, 246)',
                            backgroundColor: 'rgba(139, 92, 246, 0.1)',
                            borderWidth: 3,
                            tension: 0.4,
                            fill: true,
                            pointBackgroundColor: 'rgb(139, 92, 246)',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6
                        }, {
                            label: 'Physics',
                            data: [90, 85, 88, 92, 88, 90, 89],
                            borderColor: 'rgb(245, 158, 11)',
                            backgroundColor: 'rgba(245, 158, 11, 0.1)',
                            borderWidth: 3,
                            tension: 0.4,
                            fill: true,
                            pointBackgroundColor: 'rgb(245, 158, 11)',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        animation: {
                            duration: 1000,
                            easing: 'easeInOutQuart'
                        },
                        interaction: {
                            mode: 'index',
                            intersect: false
                        },
                        scales: {
                            y: {
                                type: 'category',
                                labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                                grid: {
                                    color: 'rgba(255, 255, 255, 0.05)',
                                    drawBorder: false
                                },
                                ticks: {
                                    color: '#9CA3AF',
                                    padding: 10,
                                    font: {
                                        size: 11
                                    }
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    color: '#9CA3AF',
                                    padding: 10,
                                    font: {
                                        size: 11
                                    }
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                labels: {
                                    color: '#9CA3AF',
                                    padding: 20,
                                    font: {
                                        size: 12,
                                        weight: '500'
                                    },
                                    usePointStyle: true,
                                    pointStyle: 'circle'
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(17, 24, 39, 0.9)',
                                titleColor: '#fff',
                                bodyColor: '#9CA3AF',
                                padding: 12,
                                borderColor: 'rgba(255, 255, 255, 0.1)',
                                borderWidth: 1,
                                displayColors: true,
                                usePointStyle: true,
                                titleFont: {
                                    size: 12,
                                    weight: '600'
                                },
                                bodyFont: {
                                    size: 11
                                },
                                callbacks: {
                                    label: function(context) {
                                        return context.dataset.label + ': ' + context.parsed.y + '%';
                                    }
                                }
                            }
                        }
                    }
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
