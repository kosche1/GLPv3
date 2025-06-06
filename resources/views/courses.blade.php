<x-layouts.app>
    <div class="flex h-full w-full flex-1 flex-col gap-6 text-gray-100 p-6 border border-emerald-500 rounded-lg">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                <h1 class="text-2xl font-bold text-white">My Courses</h1>
            </div>

            <!-- Search and Filter Section -->
            <div class="flex flex-col md:flex-row items-center gap-4">
                <!-- Search Input -->
                <div class="relative w-full md:w-auto">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input type="text" id="course-search" placeholder="Search courses..."
                        class="w-full md:min-w-[250px] rounded-lg border border-neutral-700 bg-neutral-800/80 pl-10 pr-4 py-2.5 text-sm text-white placeholder-neutral-400 focus:border-emerald-500/50 focus:outline-hidden focus:ring-1 focus:ring-emerald-500/30 transition-all duration-300 hover:border-neutral-600">
                </div>
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="p-5 bg-gradient-to-br from-neutral-800 to-neutral-900 rounded-xl border border-neutral-700 transition-all duration-300 hover:scale-[1.02] hover:shadow-lg hover:shadow-emerald-900/20 hover:border-emerald-500/30">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-emerald-500/10 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-white">Current Courses</h3>
                        <div class="flex items-end gap-2">
                            <p class="text-3xl font-bold text-white mt-1">{{ $challenges->where('status', 'active')->count() }}</p>
                            <p class="text-sm text-emerald-400 mb-1">Active</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-5 bg-gradient-to-br from-neutral-800 to-neutral-900 rounded-xl border border-neutral-700 transition-all duration-300 hover:scale-[1.02] hover:shadow-lg hover:shadow-emerald-900/20 hover:border-emerald-500/30">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-emerald-500/10 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-white">Average Grade</h3>
                        <div class="flex items-end gap-2">
                            <p class="text-3xl font-bold text-white mt-1">{{ number_format($challenges->avg('grade') ?? 0, 1) }}%</p>
                            <p class="text-sm text-emerald-400 mb-1">Overall</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-5 bg-gradient-to-br from-neutral-800 to-neutral-900 rounded-xl border border-neutral-700 transition-all duration-300 hover:scale-[1.02] hover:shadow-lg hover:shadow-emerald-900/20 hover:border-emerald-500/30">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-emerald-500/10 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-white">Completion Rate</h3>
                        <div class="flex items-end gap-2">
                            <p class="text-3xl font-bold text-white mt-1">{{ number_format($challenges->where('completed', true)->count() / max(1, $challenges->count()) * 100, 1) }}%</p>
                            <p class="text-sm text-emerald-400 mb-1">Progress</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Specialized Tracks Section -->
        <div class="mt-8">
            <div class="flex items-center gap-3 mb-4">
                <div class="p-2 bg-emerald-500/10 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg>
                </div>
                <h2 class="text-xl font-semibold text-white">Specialized Tracks</h2>
            </div>

            <div class="grid gap-5 md:grid-cols-3 lg:grid-cols-5">
                <!-- ABM Card -->
                <div class="group flex flex-col rounded-xl border border-neutral-700 bg-gradient-to-br from-neutral-800 to-neutral-900 overflow-hidden transition-all duration-300 hover:scale-[1.02] hover:shadow-lg hover:shadow-emerald-900/20 hover:border-emerald-500/30">
                    <div class="p-5 flex flex-col grow">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="p-2 bg-emerald-500/10 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-white group-hover:text-emerald-400 transition-colors duration-300">ABM</h3>
                        </div>

                        <p class="text-sm text-neutral-400 mb-4">Accountancy, Business, and Management track focuses on fundamental concepts of financial management, business operations, and corporate governance.</p>

                        <div class="mt-auto pt-4 border-t border-neutral-700">
                            <a href="{{ route('subjects.specialized.abm') }}" class="inline-flex items-center justify-center w-full px-4 py-2.5 text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-500 rounded-lg transition-all duration-300 focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 focus:ring-offset-neutral-800">
                                Explore ABM
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- HE Card -->
                <div class="group flex flex-col rounded-xl border border-neutral-700 bg-gradient-to-br from-neutral-800 to-neutral-900 overflow-hidden transition-all duration-300 hover:scale-[1.02] hover:shadow-lg hover:shadow-emerald-900/20 hover:border-emerald-500/30">
                    <div class="p-5 flex flex-col grow">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="p-2 bg-emerald-500/10 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-white group-hover:text-emerald-400 transition-colors duration-300">HE</h3>
                        </div>

                        <p class="text-sm text-neutral-400 mb-4">Home Economics track provides specialized training in hospitality, tourism, food and beverage services, and consumer education.</p>

                        <div class="mt-auto pt-4 border-t border-neutral-700">
                            <a href="{{ route('subjects.specialized.he') }}" class="inline-flex items-center justify-center w-full px-4 py-2.5 text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-500 rounded-lg transition-all duration-300 focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 focus:ring-offset-neutral-800">
                                Explore HE
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- HUMMS Card -->
                <div class="group flex flex-col rounded-xl border border-neutral-700 bg-gradient-to-br from-neutral-800 to-neutral-900 overflow-hidden transition-all duration-300 hover:scale-[1.02] hover:shadow-lg hover:shadow-emerald-900/20 hover:border-emerald-500/30">
                    <div class="p-5 flex flex-col grow">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="p-2 bg-emerald-500/10 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-white group-hover:text-emerald-400 transition-colors duration-300">HUMMS</h3>
                        </div>

                        <p class="text-sm text-neutral-400 mb-4">Humanities and Social Sciences track focuses on literature, philosophy, social sciences, and cultural studies for future social workers, educators, and legal professionals.</p>

                        <div class="mt-auto pt-4 border-t border-neutral-700">
                            <a href="{{ route('subjects.specialized.humms') }}" class="inline-flex items-center justify-center w-full px-4 py-2.5 text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-500 rounded-lg transition-all duration-300 focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 focus:ring-offset-neutral-800">
                                Explore HUMMS
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- STEM Card -->
                <div class="group flex flex-col rounded-xl border border-neutral-700 bg-gradient-to-br from-neutral-800 to-neutral-900 overflow-hidden transition-all duration-300 hover:scale-[1.02] hover:shadow-lg hover:shadow-emerald-900/20 hover:border-emerald-500/30">
                    <div class="p-5 flex flex-col grow">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="p-2 bg-emerald-500/10 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-white group-hover:text-emerald-400 transition-colors duration-300">STEM</h3>
                        </div>

                        <p class="text-sm text-neutral-400 mb-4">Science, Technology, Engineering, and Mathematics track prepares students for careers in research, engineering, healthcare, and advanced technology fields.</p>

                        <div class="mt-auto pt-4 border-t border-neutral-700">
                            <a href="{{ route('subjects.specialized.stem') }}" class="inline-flex items-center justify-center w-full px-4 py-2.5 text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-500 rounded-lg transition-all duration-300 focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 focus:ring-offset-neutral-800">
                                Explore STEM
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- ICT Card -->
                <div class="group flex flex-col rounded-xl border border-neutral-700 bg-gradient-to-br from-neutral-800 to-neutral-900 overflow-hidden transition-all duration-300 hover:scale-[1.02] hover:shadow-lg hover:shadow-emerald-900/20 hover:border-emerald-500/30">
                    <div class="p-5 flex flex-col grow">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="p-2 bg-emerald-500/10 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-white group-hover:text-emerald-400 transition-colors duration-300">ICT</h3>
                        </div>

                        <p class="text-sm text-neutral-400 mb-4">Information and Communications Technology track focuses on computer programming, systems development, networking, and digital media for future IT professionals.</p>

                        <div class="mt-auto pt-4 border-t border-neutral-700">
                            <a href="{{ route('subjects.specialized.ict') }}" class="inline-flex items-center justify-center w-full px-4 py-2.5 text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-500 rounded-lg transition-all duration-300 focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 focus:ring-offset-neutral-800">
                                Explore ICT
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- JavaScript for filtering and sorting courses -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('course-search');
            const statusFilter = document.getElementById('course-status-filter');
            const sortSelect = document.getElementById('course-sort');
            const categoryButtons = document.querySelectorAll('#category-filters button');
            const courseCards = document.querySelectorAll('.course-card');

            let activeCategory = 'all';

            // Function to filter and sort courses
            function filterAndSortCourses() {
                const searchTerm = searchInput.value.toLowerCase();
                const statusValue = statusFilter.value;
                const sortValue = sortSelect.value;

                // Filter courses
                courseCards.forEach(card => {
                    // Get course data for filtering
                    const courseName = card.dataset.name || '';
                    const courseStatus = card.dataset.status || '';
                    const courseCategory = card.dataset.category || '';
                    const courseDescription = card.querySelector('p')?.textContent.toLowerCase() || '';

                    // Check if course matches search, status, and category criteria
                    const matchesSearch = courseName.includes(searchTerm) || courseDescription.includes(searchTerm);
                    const matchesStatus = statusValue === 'all' || courseStatus === statusValue;
                    const matchesCategory = activeCategory === 'all' || courseCategory === activeCategory;

                    // Show or hide based on filters
                    if (matchesSearch && matchesStatus && matchesCategory) {
                        card.style.display = '';
                    } else {
                        card.style.display = 'none';
                    }
                });

                // Sort visible courses
                const visibleCards = Array.from(document.querySelectorAll('.course-card:not([style*="display: none"])'));

                // Sort based on selected criteria
                visibleCards.sort((a, b) => {
                    if (sortValue === 'name-asc' || sortValue === 'name-desc') {
                        const nameA = a.dataset.name || '';
                        const nameB = b.dataset.name || '';
                        return sortValue === 'name-asc' ? nameA.localeCompare(nameB) : nameB.localeCompare(nameA);
                    }
                    else if (sortValue === 'difficulty-asc' || sortValue === 'difficulty-desc') {
                        const difficultyMap = {
                            'beginner': 1,
                            'easy': 2,
                            'medium': 3,
                            'intermediate': 4,
                            'hard': 5,
                            'advanced': 6,
                            'expert': 7
                        };

                        const difficultyA = a.dataset.difficulty || '';
                        const difficultyB = b.dataset.difficulty || '';

                        const diffValueA = difficultyMap[difficultyA] || 0;
                        const diffValueB = difficultyMap[difficultyB] || 0;

                        return sortValue === 'difficulty-asc' ? diffValueA - diffValueB : diffValueB - diffValueA;
                    }
                    else if (sortValue === 'progress-asc' || sortValue === 'progress-desc') {
                        const progressA = parseInt(a.dataset.progress || '0');
                        const progressB = parseInt(b.dataset.progress || '0');
                        return sortValue === 'progress-asc' ? progressA - progressB : progressB - progressA;
                    }

                    return 0;
                });

                // Reorder the DOM elements based on sort
                const container = document.querySelector('.grid.gap-5');
                visibleCards.forEach(card => {
                    container.appendChild(card);
                });

                // Update empty state visibility
                const emptyState = document.querySelector('.col-span-1.md\\:col-span-2.lg\\:col-span-3');
                if (emptyState) {
                    if (visibleCards.length === 0) {
                        emptyState.style.display = '';
                    } else {
                        emptyState.style.display = 'none';
                    }
                }

                // Handle pagination visibility
                const paginationContainer = document.querySelector('.mt-8.flex.items-center.justify-center');
                if (paginationContainer) {
                    // Hide pagination when filtering/searching
                    if (searchTerm || statusValue !== 'all' || activeCategory !== 'all') {
                        paginationContainer.style.display = 'none';
                    } else {
                        paginationContainer.style.display = '';
                    }
                }
            }

            // Handle category button clicks
            categoryButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active class from all buttons
                    categoryButtons.forEach(btn => {
                        btn.classList.remove('bg-emerald-500/10', 'text-emerald-400', 'border-emerald-500/20');
                        btn.classList.add('bg-neutral-800', 'text-neutral-300', 'border-neutral-700');
                    });

                    // Add active class to clicked button
                    this.classList.remove('bg-neutral-800', 'text-neutral-300', 'border-neutral-700');
                    this.classList.add('bg-emerald-500/10', 'text-emerald-400', 'border-emerald-500/20');

                    // Update active category
                    activeCategory = this.dataset.category;

                    // Filter courses
                    filterAndSortCourses();
                });
            });

            // Add event listeners
            searchInput.addEventListener('input', filterAndSortCourses);
            statusFilter.addEventListener('change', filterAndSortCourses);
            sortSelect.addEventListener('change', filterAndSortCourses);

            // Initial filter and sort
            filterAndSortCourses();
        });
    </script>
</x-layouts.app>