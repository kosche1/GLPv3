<x-layouts.app>
    <div class="flex h-full w-full flex-1 flex-col gap-6 text-gray-100 p-6 border border-emerald-500/30 rounded-lg bg-linear-to-b from-neutral-900 to-neutral-800">
        <div class="max-w-7xl mx-auto w-full">
            <!-- Breadcrumb -->
            <nav class="mb-6">
                <ol class="flex items-center space-x-2 text-sm text-zinc-400">
                    <li>
                        <a href="{{ route('help-center') }}" class="hover:text-emerald-400 transition-colors">Help Center</a>
                    </li>
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </li>
                    <li class="text-white">{{ $category->name }}</li>
                </ol>
            </nav>

            <!-- Category Header -->
            <div class="text-center mb-12">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full mb-4" style="background-color: {{ $category->color }}20; border: 1px solid {{ $category->color }}30;">
                    @if($category->icon)
                        <svg class="w-8 h-8" style="color: {{ $category->color }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <!-- Icon would be dynamically loaded based on $category->icon -->
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    @endif
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">{{ $category->name }}</h1>
                @if($category->description)
                    <p class="text-lg text-zinc-300 max-w-3xl mx-auto">{{ $category->description }}</p>
                @endif
            </div>

            <!-- Search within Category -->
            <div class="mb-8">
                <div class="max-w-2xl mx-auto">
                    <form action="{{ route('help-center.search') }}" method="GET" class="relative">
                        <input type="hidden" name="category" value="{{ $category->slug }}">
                        <input type="text" name="query" placeholder="Search in {{ $category->name }}..." class="w-full px-4 py-3 rounded-lg border border-neutral-700 bg-neutral-800/80 text-white placeholder-neutral-400 focus:outline-hidden focus:ring-2 focus:ring-emerald-500/50 hover:border-neutral-600 transition-all duration-300 ease-in-out pl-12">
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

            <!-- FAQs Section -->
            @if($faqs->isNotEmpty())
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-white mb-6 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Frequently Asked Questions
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
                            <div class="mt-4 flex items-center gap-4">
                                <span class="text-xs text-zinc-400">Was this helpful?</span>
                                <button onclick="markHelpful('faq', {{ $faq->id }}, true)" class="text-xs text-emerald-400 hover:text-emerald-300 transition-colors">
                                    👍 Yes ({{ $faq->helpful_count }})
                                </button>
                                <button onclick="markHelpful('faq', {{ $faq->id }}, false)" class="text-xs text-red-400 hover:text-red-300 transition-colors">
                                    👎 No ({{ $faq->not_helpful_count }})
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Articles Section -->
            @if($articles->isNotEmpty())
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-white mb-6 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Articles
                </h2>
                
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($articles as $article)
                    <div class="p-6 rounded-xl border border-neutral-700 bg-neutral-800/50 hover:bg-neutral-800 transition-all duration-300 group">
                        <div class="flex items-start justify-between mb-3">
                            <h3 class="text-lg font-semibold text-white group-hover:text-emerald-400 transition-colors">
                                <a href="{{ route('help-center.article', $article) }}">
                                    {{ $article->title }}
                                </a>
                            </h3>
                            @if($article->is_featured)
                            <span class="px-2 py-1 rounded-full text-xs bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">
                                Featured
                            </span>
                            @endif
                        </div>
                        <p class="text-zinc-400 text-sm mb-4">{{ $article->excerpt }}</p>
                        <div class="flex items-center justify-between text-xs text-zinc-500">
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                {{ $article->view_count }} views
                            </span>
                            <a href="{{ route('help-center.article', $article) }}" class="text-emerald-400 hover:text-emerald-300 transition-colors">
                                Read more →
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($articles->hasPages())
                <div class="mt-8">
                    {{ $articles->links() }}
                </div>
                @endif
            </div>
            @else
            <div class="text-center py-12">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-zinc-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="text-lg font-semibold text-white mb-2">No articles available</h3>
                <p class="text-zinc-400 mb-4">Check back later for new content in this category</p>
            </div>
            @endif

            <!-- Back to Help Center -->
            <div class="text-center">
                <a href="{{ route('help-center') }}" class="inline-flex items-center px-4 py-2 bg-neutral-700 hover:bg-neutral-600 text-white rounded-lg transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Help Center
                </a>
            </div>
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

        function markHelpful(type, id, helpful) {
            fetch('{{ route("help-center.mark-helpful") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    type: type,
                    id: id,
                    helpful: helpful
                })
            })
            .then(response => response.json())
            .then(data => {
                // Update the counts in the UI
                const helpfulBtn = document.querySelector(`button[onclick="markHelpful('${type}', ${id}, true)"]`);
                const notHelpfulBtn = document.querySelector(`button[onclick="markHelpful('${type}', ${id}, false)"]`);
                
                if (helpfulBtn) {
                    helpfulBtn.innerHTML = `👍 Yes (${data.helpful_count})`;
                }
                if (notHelpfulBtn) {
                    notHelpfulBtn.innerHTML = `👎 No (${data.not_helpful_count})`;
                }
                
                // Show a brief thank you message
                const messageDiv = document.createElement('div');
                messageDiv.className = 'text-xs text-emerald-400 mt-2';
                messageDiv.textContent = 'Thank you for your feedback!';
                
                const container = helpful ? helpfulBtn.parentNode : notHelpfulBtn.parentNode;
                container.appendChild(messageDiv);
                
                setTimeout(() => {
                    messageDiv.remove();
                }, 3000);
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    </script>
</x-layouts.app>
