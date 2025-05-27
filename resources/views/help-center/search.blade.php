<x-layouts.app>
    <div class="flex h-full w-full flex-1 flex-col gap-6 text-gray-100 p-6 border border-emerald-500/30 rounded-lg bg-linear-to-b from-neutral-900 to-neutral-800">
        <div class="max-w-7xl mx-auto w-full">
            <!-- Header Section -->
            <div class="text-center mb-8">
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-4">Search Results</h1>
                <p class="text-lg text-zinc-300">
                    @if($totalResults > 0)
                        Found {{ $totalResults }} result{{ $totalResults !== 1 ? 's' : '' }} for "{{ $query }}"
                    @else
                        No results found for "{{ $query }}"
                    @endif
                </p>
            </div>

            <!-- Search Bar -->
            <div class="mb-8">
                <div class="max-w-2xl mx-auto">
                    <form action="{{ route('help-center.search') }}" method="GET" class="relative">
                        <input type="text" name="query" placeholder="Search for help..." value="{{ $query }}" class="w-full px-4 py-3 rounded-lg border border-neutral-700 bg-neutral-800/80 text-white placeholder-neutral-400 focus:outline-hidden focus:ring-2 focus:ring-emerald-500/50 hover:border-neutral-600 transition-all duration-300 ease-in-out pl-12">
                        <div class="absolute left-3 top-3">
                            <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <button type="submit" class="absolute right-3 top-2 px-3 py-1 bg-emerald-500/20 text-emerald-400 rounded-md text-sm border border-emerald-500/30 hover:bg-emerald-500/30 transition-colors">
                            Search
                        </button>
                    </form>
                </div>
            </div>

            @if($totalResults > 0)
                <!-- Filter by Category -->
                @if($categories->isNotEmpty())
                <div class="mb-6">
                    <div class="flex flex-wrap gap-2 justify-center">
                        <a href="{{ route('help-center.search', ['query' => $query]) }}" 
                           class="px-3 py-1 rounded-full text-sm border transition-colors {{ !$category ? 'bg-emerald-500/20 text-emerald-400 border-emerald-500/30' : 'bg-neutral-800 border-neutral-700 text-neutral-300 hover:bg-neutral-700' }}">
                            All Categories
                        </a>
                        @foreach($categories as $cat)
                            <a href="{{ route('help-center.search', ['query' => $query, 'category' => $cat->slug]) }}" 
                               class="px-3 py-1 rounded-full text-sm border transition-colors {{ $category === $cat->slug ? 'bg-emerald-500/20 text-emerald-400 border-emerald-500/30' : 'bg-neutral-800 border-neutral-700 text-neutral-300 hover:bg-neutral-700' }}">
                                {{ $cat->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Articles Results -->
                @if($articles->isNotEmpty())
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-white mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Articles ({{ $articles->count() }})
                    </h2>
                    <div class="grid gap-4">
                        @foreach($articles as $article)
                        <div class="p-4 rounded-lg border border-neutral-700 bg-neutral-800/50 hover:bg-neutral-800 transition-all duration-300">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-white mb-2">
                                        <a href="{{ route('help-center.article', $article) }}" class="hover:text-emerald-400 transition-colors">
                                            {{ $article->title }}
                                        </a>
                                    </h3>
                                    <p class="text-zinc-400 text-sm mb-2">{{ $article->excerpt }}</p>
                                    <div class="flex items-center gap-4 text-xs text-zinc-500">
                                        <span class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                            </svg>
                                            {{ $article->category->name }}
                                        </span>
                                        <span class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            {{ $article->view_count }} views
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- FAQs Results -->
                @if($faqs->isNotEmpty())
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-white mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        FAQs ({{ $faqs->count() }})
                    </h2>
                    <div class="space-y-4">
                        @foreach($faqs as $faq)
                        <div class="border border-neutral-700 rounded-lg overflow-hidden">
                            <button class="w-full flex justify-between items-center p-4 bg-neutral-800 hover:bg-neutral-700 transition-colors text-left" onclick="toggleFaq('faq{{ $faq->id }}')">
                                <span class="font-medium text-white">{{ $faq->question }}</span>
                                <svg id="faq{{ $faq->id }}-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400 transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div id="faq{{ $faq->id }}" class="hidden p-4 bg-neutral-800/50 border-t border-neutral-700">
                                <div class="text-zinc-300 text-sm">
                                    {!! nl2br(e($faq->answer)) !!}
                                </div>
                                @if($faq->category)
                                <div class="mt-2 text-xs text-zinc-500">
                                    Category: {{ $faq->category->name }}
                                </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            @else
                <!-- No Results -->
                <div class="text-center py-12">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-zinc-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <h3 class="text-lg font-semibold text-white mb-2">No results found</h3>
                    <p class="text-zinc-400 mb-4">Try adjusting your search terms or browse our categories</p>
                    <a href="{{ route('help-center') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg transition-colors">
                        Back to Help Center
                    </a>
                </div>
            @endif
        </div>
    </div>

    <script>
        function toggleFaq(id) {
            const content = document.getElementById(id);
            const icon = document.getElementById(id + '-icon');
            
            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                icon.classList.add('rotate-180');
            } else {
                content.classList.add('hidden');
                icon.classList.remove('rotate-180');
            }
        }
    </script>
</x-layouts.app>
