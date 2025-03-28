<x-layouts.app>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold text-white">Learning Portal</h1>
            <div class="flex gap-4">
                <a href="{{ route ('dashboard') }}" class="flex flex-col items-center justify-center p-4 rounded-xl border-2 border-emerald-500 bg-emerald-500/10 transition-all duration-300 hover:scale-[1.02] hover:shadow-lg hover:shadow-emerald-900/50 hover:bg-emerald-500/20 group">
                    <span class="text-lg font-semibold text-emerald-400 group-hover:text-emerald-300">Back</span>
                </a>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="p-6 bg-neutral-800 rounded-xl border border-neutral-700 shadow-lg">
    <div class="grid gap-6 md:grid-cols-2">
        <!-- Technology Category Dropdown -->
        <div>
            <label for="tech_category" class="text-sm font-medium text-white mb-2 block flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-emerald-400 h-4 w-4">
                    <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                </svg>
                <span>Technology Category</span>
            </label>
            <select id="tech_category" class="w-full bg-neutral-700 text-emerald-400 border border-neutral-600 rounded-lg p-3 focus:ring-emerald-500 focus:border-emerald-500 transition-all">
                <option value="">All Categories</option>
                @foreach($techCategories as $key => $category)
                    <option value="{{ $key }}">{{ str_replace('_', ' ', ucwords($category)) }}</option>
                @endforeach
            </select>
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
            <select id="programming_language" class="w-full bg-neutral-700 text-emerald-400 border border-neutral-600 rounded-lg p-3 focus:ring-emerald-500 focus:border-emerald-500 transition-all">
                <option value="">All Languages</option>
                <option value="PHP">PHP</option>
                <option value="JavaScript">JavaScript</option>
                <option value="Python">Python</option>
                <option value="Java">Java</option>
                <option value="C#">C#</option>
            </select>
        </div>
    </div>
</div>

        <!-- JavaScript for filtering -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const techCategorySelect = document.getElementById('tech_category');
                const programmingLanguageSelect = document.getElementById('programming_language');
                const challengeCards = document.querySelectorAll('#challenge-grid > div');
                
                // Function to filter challenges
                function filterChallenges() {
                    const selectedCategory = techCategorySelect.value;
                    const selectedLanguage = programmingLanguageSelect.value;
                    
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
                        } else {
                            card.style.display = 'none';
                        }
                    });
                }
                
                // Add event listeners
                techCategorySelect.addEventListener('change', filterChallenges);
                programmingLanguageSelect.addEventListener('change', filterChallenges);
                
                // Initial filter
                filterChallenges();
            });
        </script>

        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3" id="challenge-grid">
            <!-- Course Cards -->
            @foreach($challenges as $challenge)
            <div class="flex flex-col p-6 rounded-xl border border-neutral-700 bg-neutral-800 transition-all duration-300 ease-in-out hover:scale-[1.02] hover:shadow-lg hover:shadow-neutral-900/50 hover:border-neutral-600 hover:bg-neutral-800/90" data-category="{{ $challenge->category_id }}" data-language="{{ strtolower($challenge->programming_language) }}">
                <div class="space-y-4">
                    <div class="h-40 rounded-lg bg-emerald-500/10 flex items-center justify-center overflow-hidden">
                        @if($challenge->image)
                            <img src="{{ asset($challenge->image) }}" alt="{{ $challenge->name }}" class="object-cover w-full h-full">
                        @else
                            <svg class="w-16 h-16 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                        @endif
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-white">{{ $challenge->name }}</h3>
                        <p class="mt-2 text-sm text-neutral-400">{{ $challenge->description }}</p>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-emerald-400">{{ $challenge->difficulty_level }}</span>
                        <span class="text-sm font-medium text-emerald-400">{{ $challenge->programming_language }}</span>
                        <a href="{{ route('challenge', ['challenge' => $challenge]) }}" class="text-sm font-medium text-emerald-400 hover:text-emerald-300">Start →</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Learning Path Progress -->
        <div class="mt-8 p-6 rounded-xl border border-neutral-700 bg-neutral-800">
            <h2 class="text-lg font-semibold text-white mb-4">Your Learning Path</h2>
            <div class="space-y-4">
                <div class="flex items-center gap-4">
                    <div class="w-2 h-2 rounded-full {{ $progress > 0 ? 'bg-emerald-400' : 'bg-neutral-700' }}"></div>
                    <div class="flex-1">
                        <div class="h-2 rounded-full bg-neutral-700">
                            <div class="h-2 rounded-full bg-emerald-400" style="width: {{ $progress }}%"></div>
                        </div>
                    </div>
                    <span class="text-sm font-medium text-emerald-400">{{ $progress }}%</span>
                </div>
                <div class="grid grid-cols-4 gap-4 text-sm">
                    @php
                        $levels = ['Beginner', 'Intermediate', 'Advanced', 'Expert'];
                        $currentLevel = $completedLevels + 1;
                    @endphp

                    @foreach($levels as $index => $level)
                        <div class="text-center">
                            <div class="w-8 h-8 mx-auto mb-2 rounded-full {{ $index + 1 <= $completedLevels ? 'bg-emerald-500/10' : 'bg-neutral-700' }} flex items-center justify-center">
                                <span class="{{ $index + 1 <= $completedLevels ? 'text-emerald-400' : 'text-neutral-400' }}">{{ $index + 1 }}</span>
                            </div>
                            <span class="text-neutral-400">{{ $level }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>