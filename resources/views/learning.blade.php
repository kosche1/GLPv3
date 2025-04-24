<x-layouts.app>
    <div class="flex h-full w-full flex-1 flex-col gap-6 text-gray-100 p-6 border border-emerald-500 rounded-lg">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-emerald-500/10 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-white">Learning Portal</h1>
            </div>
            <div class="flex gap-4">
                <a href="{{ route ('dashboard') }}" class="flex items-center gap-2 px-5 py-2.5 rounded-lg border border-emerald-500/30 bg-emerald-500/10 transition-all duration-300 hover:bg-emerald-500/20 hover:border-emerald-500/50 hover:shadow-lg hover:shadow-emerald-900/20 group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400 group-hover:text-emerald-300 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span class="text-base font-medium text-emerald-400 group-hover:text-emerald-300 transition-colors">Back to Dashboard</span>
                </a>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="p-6 bg-linear-to-br from-neutral-800 to-neutral-900 rounded-xl border border-neutral-700 shadow-lg">
            <div class="grid gap-6 md:grid-cols-2">
                <!-- Technology Category Dropdown -->
                <div>
                    <label for="tech_category" class="text-sm font-medium text-white mb-2 block flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-emerald-400 h-4 w-4">
                            <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                        </svg>
                        <span>Technology Category</span>
                    </label>
                    <div class="relative">
                        <select id="tech_category" class="w-full bg-neutral-700/80 text-white border border-neutral-600 rounded-lg p-3 appearance-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500 transition-all">
                            <option value="">All Categories</option>
                            @foreach($techCategories as $key => $category)
                                <option value="{{ $key }}">{{ str_replace('_', ' ', ucwords($category)) }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Programming Language Dropdown -->
                <div>
                    <label for="programming_language" class="text-sm font-medium text-white mb-2 block flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-emerald-400 h-4 w-4">
                            <polyline points="16 18 22 12 16 6"></polyline>
                            <polyline points="8 6 2 12 8 18"></polyline>
                        </svg>
                        <span>Programming Language</span>
                    </label>
                    <div class="relative">
                        <select id="programming_language" class="w-full bg-neutral-700/80 text-white border border-neutral-600 rounded-lg p-3 appearance-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500 transition-all">
                            <option value="">All Languages</option>
                            <option value="PHP">PHP</option>
                            <option value="JavaScript">JavaScript</option>
                            <option value="Python">Python</option>
                            <option value="Java">Java</option>
                            <option value="C#">C#</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Filter Tags -->
            <div class="mt-5 flex flex-wrap gap-2">
                <button class="bg-emerald-500/10 text-emerald-400 px-3 py-1.5 rounded-full text-xs font-medium border border-emerald-500/20 hover:bg-emerald-500/20 transition-all duration-300">
                    All Courses
                </button>
                <button class="bg-neutral-800 text-neutral-300 px-3 py-1.5 rounded-full text-xs font-medium border border-neutral-700 hover:bg-neutral-700/50 hover:text-white transition-all duration-300">
                    Beginner
                </button>
                <button class="bg-neutral-800 text-neutral-300 px-3 py-1.5 rounded-full text-xs font-medium border border-neutral-700 hover:bg-neutral-700/50 hover:text-white transition-all duration-300">
                    Intermediate
                </button>
                <button class="bg-neutral-800 text-neutral-300 px-3 py-1.5 rounded-full text-xs font-medium border border-neutral-700 hover:bg-neutral-700/50 hover:text-white transition-all duration-300">
                    Advanced
                </button>
                <button class="bg-neutral-800 text-neutral-300 px-3 py-1.5 rounded-full text-xs font-medium border border-neutral-700 hover:bg-neutral-700/50 hover:text-white transition-all duration-300">
                    Most Popular
                </button>
            </div>
        </div>

        <!-- Subject Categories Section -->
        <div class="mt-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="p-2 bg-emerald-500/10 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <h2 class="text-xl font-semibold text-white">Subject Categories</h2>
            </div>

            <div class="grid gap-5 md:grid-cols-3">
                <!-- Core Subjects Card -->
                <div class="group flex flex-col rounded-xl border border-neutral-700 bg-linear-to-br from-neutral-800 to-neutral-900 overflow-hidden transition-all duration-300 hover:scale-[1.02] hover:shadow-lg hover:shadow-emerald-900/20 hover:border-emerald-500/30">
                    <div class="p-5 flex flex-col grow">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="p-2 bg-emerald-500/10 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-white group-hover:text-emerald-400 transition-colors duration-300">Core Subjects</h3>
                        </div>

                        <p class="text-sm text-neutral-400 mb-4">Fundamental subjects that form the foundation of your education. These include Mathematics, Science, Language Arts, and Social Studies.</p>

                        <div class="mt-auto pt-4 border-t border-neutral-700">
                            <a href="{{ route('subjects.core') }}" class="inline-flex items-center justify-center w-full px-4 py-2.5 text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-500 rounded-lg transition-all duration-300 focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 focus:ring-offset-neutral-800">
                                View Core Subjects
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Applied Subjects Card -->
                <div class="group flex flex-col rounded-xl border border-neutral-700 bg-linear-to-br from-neutral-800 to-neutral-900 overflow-hidden transition-all duration-300 hover:scale-[1.02] hover:shadow-lg hover:shadow-emerald-900/20 hover:border-emerald-500/30">
                    <div class="p-5 flex flex-col grow">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="p-2 bg-emerald-500/10 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-white group-hover:text-emerald-400 transition-colors duration-300">Applied Subjects</h3>
                        </div>

                        <p class="text-sm text-neutral-400 mb-4">Practical subjects that apply theoretical knowledge to real-world scenarios. These include Computer Science, Engineering, Business Studies, and Health Sciences.</p>

                        <div class="mt-auto pt-4 border-t border-neutral-700">
                            <a href="{{ route('subjects.applied') }}" class="inline-flex items-center justify-center w-full px-4 py-2.5 text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-500 rounded-lg transition-all duration-300 focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 focus:ring-offset-neutral-800">
                                View Applied Subjects
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Specialized Subjects Card -->
                <div class="group flex flex-col rounded-xl border border-neutral-700 bg-linear-to-br from-neutral-800 to-neutral-900 overflow-hidden transition-all duration-300 hover:scale-[1.02] hover:shadow-lg hover:shadow-emerald-900/20 hover:border-emerald-500/30">
                    <div class="p-5 flex flex-col grow">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="p-2 bg-emerald-500/10 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-white group-hover:text-emerald-400 transition-colors duration-300">Specialized Subjects</h3>
                        </div>

                        <p class="text-sm text-neutral-400 mb-4">Advanced subjects that focus on specific areas of expertise. These include Artificial Intelligence, Data Science, Cybersecurity, and Advanced Mathematics.</p>

                        <div class="mt-auto pt-4 border-t border-neutral-700">
                            <a href="{{ route('subjects.specialized') }}" class="inline-flex items-center justify-center w-full px-4 py-2.5 text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-500 rounded-lg transition-all duration-300 focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 focus:ring-offset-neutral-800">
                                View Specialized Subjects
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- JavaScript for filtering -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const techCategorySelect = document.getElementById('tech_category');
                const programmingLanguageSelect = document.getElementById('programming_language');
                const challengeCards = document.querySelectorAll('#challenge-grid > div');
                const resultCount = document.getElementById('result-count');

                // Function to filter challenges
                function filterChallenges() {
                    const selectedCategory = techCategorySelect.value;
                    const selectedLanguage = programmingLanguageSelect.value;
                    let visibleCount = 0;

                    challengeCards.forEach(card => {
                        const cardCategory = card.dataset.category;
                        const cardLanguage = card.dataset.language;

                        // For category filtering:
                        // - If "All Categories" is selected (empty value), show all categories
                        // - Otherwise, show cards matching the selected category ID
                        const categoryMatch = selectedCategory === '' || cardCategory === selectedCategory;

                        // For language filtering:
                        // - If "All Languages" is selected (empty value), show all languages
                        // - Otherwise, show cards matching the selected language
                        const languageMatch = selectedLanguage === '' || cardLanguage === selectedLanguage.toLowerCase();

                        if (categoryMatch && languageMatch) {
                            card.style.display = 'flex';
                            visibleCount++;
                        } else {
                            card.style.display = 'none';
                        }
                    });

                    // Update result count
                    if (resultCount) {
                        resultCount.textContent = visibleCount;
                    }

                    // Show/hide empty state
                    const emptyState = document.getElementById('empty-results');
                    if (emptyState) {
                        if (visibleCount === 0) {
                            emptyState.classList.remove('hidden');
                        } else {
                            emptyState.classList.add('hidden');
                        }
                    }
                }

                // Add event listeners
                techCategorySelect.addEventListener('change', filterChallenges);
                programmingLanguageSelect.addEventListener('change', filterChallenges);

                // Initial filter
                filterChallenges();
            });
        </script>

        <!-- Results Header -->
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-2">
                <h2 class="text-xl font-semibold text-white">Available Courses</h2>
                <span class="bg-emerald-500/10 text-emerald-400 px-2.5 py-1 rounded-full text-xs font-medium">
                    <span id="result-count">{{ count($challenges) }}</span> results
                </span>
            </div>
            <!-- <div class="flex items-center gap-2">
                <span class="text-sm text-neutral-400">Sort by:</span>
                <select class="bg-neutral-800 text-white border border-neutral-700 rounded-lg px-3 py-1.5 text-sm focus:ring-emerald-500/30 focus:border-emerald-500 transition-all">
                    <option>Newest</option>
                    <option>Popularity</option>
                    <option>Rating</option>
                </select>
            </div> -->
        </div>

        <!-- Course Grid -->
        <div class="grid gap-5 md:grid-cols-2 lg:grid-cols-3" id="challenge-grid">
            <!-- Course Cards -->
            @foreach($challenges as $challenge)
            <div class="group flex flex-col rounded-xl border border-neutral-700 bg-linear-to-br from-neutral-800 to-neutral-900 overflow-hidden transition-all duration-300 hover:scale-[1.02] hover:shadow-lg hover:shadow-emerald-900/20 hover:border-emerald-500/30" data-category="{{ $challenge->category_id }}" data-language="{{ strtolower($challenge->programming_language) }}">
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

                    <!-- Language Badge -->
                    <div class="absolute top-3 right-3">
                        <span class="bg-neutral-800/90 text-emerald-400 text-xs font-medium px-2.5 py-1 rounded-full border border-emerald-500/20">
                            {{ $challenge->programming_language }}
                        </span>
                    </div>

                    <!-- Completed Badge -->
                    @if(in_array($challenge->id, $completedChallenges ?? []))
                    <div class="absolute top-3 left-3">
                        <span class="bg-emerald-500/90 text-white text-xs font-medium px-2.5 py-1 rounded-full border border-emerald-500/20 flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            Completed
                        </span>
                    </div>
                    @endif
                </div>

                <div class="p-5 flex flex-col grow">
                    <div class="grow space-y-3">
                        <div class="flex justify-between items-start">
                            <h3 class="text-lg font-semibold text-white group-hover:text-emerald-400 transition-colors duration-300">{{ $challenge->name }}</h3>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                {{ $challenge->difficulty_level }}
                            </span>
                        </div>

                        <p class="text-sm text-neutral-400 line-clamp-2">{{ $challenge->description }}</p>

                        <!-- Course Info -->
                        <div class="grid grid-cols-2 gap-2 mt-3">
                            <div class="flex items-center gap-1.5 text-xs text-neutral-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>{{ $challenge->duration ?? '4 weeks' }}</span>
                            </div>
                            <div class="flex items-center gap-1.5 text-xs text-neutral-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                                <span>{{ $challenge->rating ?? '4.8' }} ({{ $challenge->reviews ?? '24' }})</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-4 border-t border-neutral-700">
                        <a href="{{ route('challenge', ['challenge' => $challenge]) }}" class="inline-flex items-center justify-center w-full px-4 py-2.5 text-sm font-medium text-white {{ in_array($challenge->id, $completedChallenges ?? []) ? 'bg-blue-600 hover:bg-blue-500' : 'bg-emerald-600 hover:bg-emerald-500' }} rounded-lg transition-all duration-300 focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 focus:ring-offset-neutral-800">
                            @if(in_array($challenge->id, $completedChallenges ?? []))
                                View Course
                            @else
                                Start Challenge
                            @endif
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Empty Results State -->
        <div id="empty-results" class="hidden flex flex-col items-center justify-center p-10 bg-neutral-800/50 rounded-xl border border-neutral-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-neutral-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <h3 class="text-xl font-medium text-white mb-2">No courses found</h3>
            <p class="text-neutral-400 text-center mb-6">Try adjusting your filters to find more courses</p>
            <button onclick="document.getElementById('tech_category').value=''; document.getElementById('programming_language').value=''; filterChallenges();" class="flex items-center justify-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white font-medium py-2 px-4 rounded-lg transition-all duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                <span>Reset Filters</span>
            </button>
        </div>

        <!-- Learning Path Progress -->
        <div class="mt-4 p-6 bg-linear-to-br from-neutral-800 to-neutral-900 rounded-xl border border-neutral-700 shadow-lg">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-emerald-500/10 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h2 class="text-lg font-semibold text-white">Your Learning Path</h2>
                </div>
            </div>

            <div class="space-y-6">
                <div class="flex items-center gap-4">
                    <div class="w-2 h-2 rounded-full {{ $progress > 0 ? 'bg-emerald-400' : 'bg-neutral-700' }}"></div>
                    <div class="flex-1">
                        <div class="h-2.5 rounded-full bg-neutral-700 overflow-hidden">
                            <div class="h-full rounded-full bg-gradient-to-r from-emerald-500 to-emerald-400" style="width: {{ $progress }}%"></div>
                        </div>
                    </div>
                    <span class="text-sm font-medium text-emerald-400 min-w-[45px] text-right">{{ $progress }}%</span>
                </div>

                <div class="grid grid-cols-4 gap-4 text-sm">
                    @php
                        $levels = ['Beginner', 'Intermediate', 'Advanced', 'Expert'];
                        $currentLevel = $completedLevels + 1;
                    @endphp

                    @foreach($levels as $index => $level)
                        <div class="text-center">
                            <div class="w-10 h-10 mx-auto mb-2 rounded-full {{ $index + 1 <= $completedLevels ? 'bg-emerald-500/20 border-2 border-emerald-500' : ($index + 1 == $currentLevel ? 'bg-emerald-500/10 border-2 border-emerald-500/50' : 'bg-neutral-700/50 border-2 border-neutral-700') }} flex items-center justify-center transition-all duration-300">
                                @if($index + 1 < $currentLevel)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                @else
                                    <span class="{{ $index + 1 == $currentLevel ? 'text-emerald-400' : 'text-neutral-400' }}">{{ $index + 1 }}</span>
                                @endif
                            </div>
                            <span class="{{ $index + 1 <= $completedLevels ? 'text-emerald-400' : ($index + 1 == $currentLevel ? 'text-white' : 'text-neutral-400') }}">{{ $level }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>