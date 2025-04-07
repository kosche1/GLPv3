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

                <!-- Filter Dropdown -->
                <div class="w-full md:w-auto">
                    <div class="relative">
                        <select id="course-status-filter" class="w-full rounded-lg border border-neutral-700 bg-neutral-800/80 px-4 py-2.5 text-sm text-white appearance-none focus:border-emerald-500/50 focus:outline-hidden focus:ring-1 focus:ring-emerald-500/30 transition-all duration-300 hover:border-neutral-600">
                            <option value="all">Courses</option>
                            <option value="active">Active</option>
                            <option value="completed">Completed</option>
                            <option value="upcoming">Upcoming</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Sort Dropdown -->
                <div class="w-full md:w-auto">
                    <div class="relative">
                        <select id="course-sort" class="w-full rounded-lg border border-neutral-700/50 bg-neutral-800/50 px-4 py-2.5 text-sm text-white appearance-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/30 focus:outline-hidden transition-all duration-300 hover:border-neutral-600">
                            <option value="name-asc">Name (A-Z)</option>
                            <option value="name-desc">Name (Z-A)</option>
                            <option value="difficulty-asc">Difficulty (Easy to Hard)</option>
                            <option value="difficulty-desc">Difficulty (Hard to Easy)</option>
                            <option value="progress-asc">Progress (Low to High)</option>
                            <option value="progress-desc">Progress (High to Low)</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
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

        <!-- Course Categories -->
        <div class="flex flex-wrap gap-2 py-2" id="category-filters">
            <button
                data-category="all"
                class="bg-emerald-500/10 text-emerald-400 border-emerald-500/20 px-4 py-1.5 rounded-full text-sm font-medium border transition-all duration-300">
                All Categories
            </button>
            @foreach($techCategories as $key => $category)
                <button
                    data-category="{{ $key }}"
                    class="bg-neutral-800 text-neutral-300 border-neutral-700 hover:bg-neutral-700/50 hover:text-white px-4 py-1.5 rounded-full text-sm font-medium border transition-all duration-300">
                    {{ str_replace('_', ' ', ucwords($category)) }}
                </button>
            @endforeach
        </div>

        <!-- Course Cards -->
        <div class="grid gap-5 md:grid-cols-2 lg:grid-cols-3">
            @foreach($challenges as $challenge)
            <div class="course-card group flex flex-col rounded-xl border border-neutral-700 bg-gradient-to-br from-neutral-800 to-neutral-900 overflow-hidden transition-all duration-300 hover:scale-[1.02] hover:shadow-lg hover:shadow-emerald-900/20 hover:border-emerald-500/30"
                 data-name="{{ strtolower($challenge->name) }}"
                 data-status="{{ $challenge->status ?? 'available' }}"
                 data-category="{{ $challenge->category_id ?? '' }}"
                 data-difficulty="{{ strtolower($challenge->difficulty_level) }}"
                 data-progress="{{ $challenge->progress ?? '0' }}">
                <div class="h-44 overflow-hidden relative">
                    @if($challenge->image)
                        <img src="{{ asset($challenge->image) }}" alt="{{ $challenge->name }}" class="object-cover w-full h-full transition-transform duration-500 group-hover:scale-110">
                    @else
                        <div class="w-full h-full bg-emerald-500/10 flex items-center justify-center">
                            <svg class="w-16 h-16 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                        </div>
                    @endif

                    <!-- Status Badge -->
                    <div class="absolute top-3 right-3">
                        @if($challenge->status == 'active')
                            <span class="bg-emerald-500/90 text-white text-xs font-medium px-2.5 py-1 rounded-full">Active</span>
                        @elseif($challenge->status == 'completed')
                            <span class="bg-blue-500/90 text-white text-xs font-medium px-2.5 py-1 rounded-full">Completed</span>
                        @else
                            <span class="bg-amber-500/90 text-white text-xs font-medium px-2.5 py-1 rounded-full">Available</span>
                        @endif
                    </div>
                </div>

                <div class="p-5 flex flex-col grow">
                    <div class="grow space-y-3">
                        <div class="flex justify-between items-start">
                            <h3 class="text-lg font-semibold text-white group-hover:text-emerald-400 transition-colors duration-300">{{ $challenge->name }}</h3>
                            <span class="text-xs font-medium text-neutral-400">{{ $challenge->duration ?? '8 weeks' }}</span>
                        </div>

                        <p class="text-sm text-neutral-400 line-clamp-2">{{ $challenge->description }}</p>

                        <!-- Progress Bar for Active Courses -->
                        @if($challenge->status == 'active')
                        <div class="mt-3">
                            <div class="flex justify-between text-xs mb-1">
                                <span class="text-neutral-400">Progress</span>
                                <span class="text-emerald-400">{{ $challenge->progress ?? '45' }}%</span>
                            </div>
                            <div class="w-full bg-neutral-700 rounded-full h-1.5">
                                <div class="bg-emerald-500 h-1.5 rounded-full" style="width: {{ $challenge->progress ?? '45' }}%"></div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="flex justify-between items-center mt-4 pt-4 border-t border-neutral-700">
                        <div class="flex items-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                {{ $challenge->difficulty_level }}
                            </span>
                        </div>
                        <a href="{{ route('challenge', ['challenge' => $challenge]) }}" class="inline-flex items-center text-sm font-medium text-emerald-400 hover:text-emerald-300 transition-colors duration-300">
                            <span>Continue</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach

            <!-- Empty State -->
            @if(count($challenges) == 0)
            <div class="col-span-1 md:col-span-2 lg:col-span-3 flex flex-col items-center justify-center p-10 bg-neutral-800/50 rounded-xl border border-neutral-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-neutral-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                <h3 class="text-xl font-medium text-white mb-2">No courses found</h3>
                <p class="text-neutral-400 text-center mb-6">You haven't enrolled in any courses yet.</p>
                <button class="flex items-center justify-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white font-medium py-2 px-4 rounded-lg transition-all duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Browse Courses</span>
                </button>
            </div>
            @endif
        </div>

        <!-- Pagination -->
        @if($challenges instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="mt-8 flex items-center justify-center">
            {{ $challenges->links() }}
        </div>
        @endif
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