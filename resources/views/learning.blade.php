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
                @foreach($subjectTypes as $subjectType)
                <!-- {{ $subjectType->name }} Card -->
                <div class="group flex flex-col rounded-xl border border-neutral-700 bg-linear-to-br from-neutral-800 to-neutral-900 overflow-hidden transition-all duration-300 hover:scale-[1.02] hover:shadow-lg hover:shadow-emerald-900/20 hover:border-emerald-500/30">
                    <!-- Top image banner section -->
                    @if($subjectType->image)
                        <!-- If there's an uploaded image, use it as a banner -->
                        <div class="h-48 w-full overflow-hidden relative">
                            <img src="{{ asset($subjectType->image) }}" alt="{{ $subjectType->name }}" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-b from-transparent to-neutral-900/80"></div>
                            <div class="absolute bottom-3 right-3 p-2 rounded-full bg-neutral-800/70 text-xs text-white">
                                {{ $subjectType->code }}
                            </div>
                        </div>
                    @else
                        <!-- If no image, use a colored background with icon -->
                        <div class="h-48 w-full overflow-hidden relative flex justify-center items-center" style="background-color: {{ $subjectType->color ?? '#10B981' }}">
                            @if($subjectType->icon)
                                <i class="{{ $subjectType->icon }} h-16 w-16 text-white opacity-80"></i>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-white opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            @endif
                            <div class="absolute bottom-3 right-3 p-2 rounded-full bg-neutral-800/70 text-xs text-white">
                                {{ $subjectType->code }}
                            </div>
                        </div>
                    @endif

                    <!-- Content section -->
                    <div class="p-5 flex flex-col grow">
                        <h3 class="text-lg font-semibold text-white group-hover:text-emerald-400 transition-colors duration-300 mb-2">{{ $subjectType->name }}</h3>
                        <p class="text-sm text-neutral-400 mb-4">{{ $subjectType->description }}</p>

                        <div class="mt-auto pt-4 border-t border-neutral-700">
                            <a href="{{ in_array($subjectType->code, ['core', 'applied', 'specialized']) ? route('subjects.'.$subjectType->code) : route('subjects.type', $subjectType->code) }}" class="inline-flex items-center justify-center w-full px-4 py-2.5 text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-500 rounded-lg transition-all duration-300 focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 focus:ring-offset-neutral-800">
                                View {{ $subjectType->name }}
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
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
                            <div class="h-full rounded-full bg-gradient-to-r from-emerald-500 to-emerald-400" style="width: {{ $progress }}%;"></div>
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