<x-layouts.app>
    <div class="flex h-full w-full flex-1 flex-col gap-6 text-gray-100 p-6 border border-emerald-500/30 rounded-lg bg-linear-to-b from-neutral-900 to-neutral-800">
        <div class="max-w-4xl mx-auto w-full">
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
                    <li>
                        <a href="{{ route('help-center.category', $article->category) }}" class="hover:text-emerald-400 transition-colors">{{ $article->category->name }}</a>
                    </li>
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </li>
                    <li class="text-white">{{ $article->title }}</li>
                </ol>
            </nav>

            <!-- Article Header -->
            <div class="mb-8">
                <div class="flex items-center gap-2 mb-4">
                    <span class="px-3 py-1 rounded-full text-xs bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">
                        {{ $article->category->name }}
                    </span>
                    @if($article->is_featured)
                    <span class="px-3 py-1 rounded-full text-xs bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">
                        Featured
                    </span>
                    @endif
                </div>
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-4">{{ $article->title }}</h1>
                <div class="flex items-center gap-4 text-sm text-zinc-400">
                    <span class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        {{ $article->view_count }} views
                    </span>
                    <span class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Updated {{ $article->updated_at->diffForHumans() }}
                    </span>
                </div>
            </div>

            <!-- Article Content -->
            <div class="prose prose-invert prose-emerald max-w-none mb-8">
                <div class="p-6 rounded-xl border border-neutral-700 bg-neutral-800/50">
                    {!! $article->content !!}
                </div>
            </div>

            <!-- Helpful Voting -->
            <div class="mb-8 p-4 rounded-lg border border-neutral-700 bg-neutral-800/50">
                <h3 class="text-lg font-semibold text-white mb-4">Was this article helpful?</h3>
                <div class="flex items-center gap-4">
                    <button onclick="markHelpful('article', {{ $article->id }}, true)" class="flex items-center gap-2 px-4 py-2 bg-emerald-500/20 text-emerald-400 rounded-lg border border-emerald-500/30 hover:bg-emerald-500/30 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                        </svg>
                        Yes ({{ $article->helpful_count }})
                    </button>
                    <button onclick="markHelpful('article', {{ $article->id }}, false)" class="flex items-center gap-2 px-4 py-2 bg-red-500/20 text-red-400 rounded-lg border border-red-500/30 hover:bg-red-500/30 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018c.163 0 .326.02.485.06L17 4m-7 10v2a2 2 0 002 2h.095c.5 0 .905-.405.905-.905 0-.714.211-1.412.608-2.006L17 13V4m-7 10h2M17 4H19a2 2 0 012 2v6a2 2 0 01-2 2h-2.5" />
                        </svg>
                        No ({{ $article->not_helpful_count }})
                    </button>
                </div>
            </div>

            <!-- Related Articles -->
            @if($relatedArticles->isNotEmpty())
            <div class="mb-8">
                <h3 class="text-xl font-bold text-white mb-4">Related Articles</h3>
                <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($relatedArticles as $related)
                    <div class="p-4 rounded-lg border border-neutral-700 bg-neutral-800/50 hover:bg-neutral-800 transition-all duration-300">
                        <h4 class="font-semibold text-white mb-2">
                            <a href="{{ route('help-center.article', $related) }}" class="hover:text-emerald-400 transition-colors">
                                {{ $related->title }}
                            </a>
                        </h4>
                        <p class="text-zinc-400 text-sm">{{ $related->excerpt }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Back to Category -->
            <div class="text-center">
                <a href="{{ route('help-center.category', $article->category) }}" class="inline-flex items-center px-4 py-2 bg-neutral-700 hover:bg-neutral-600 text-white rounded-lg transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to {{ $article->category->name }}
                </a>
            </div>
        </div>
    </div>

    <script>
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
                    helpfulBtn.innerHTML = helpfulBtn.innerHTML.replace(/\(\d+\)/, `(${data.helpful_count})`);
                }
                if (notHelpfulBtn) {
                    notHelpfulBtn.innerHTML = notHelpfulBtn.innerHTML.replace(/\(\d+\)/, `(${data.not_helpful_count})`);
                }
                
                // Show a brief thank you message
                const messageDiv = document.createElement('div');
                messageDiv.className = 'text-sm text-emerald-400 mt-2';
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
