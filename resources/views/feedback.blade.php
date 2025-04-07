<x-layouts.app>
    <div class="flex h-full w-full flex-1 flex-col gap-4 text-gray-100 p-6 border border-emerald-500 rounded-lg">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row justify-between items-center gap-3">
            <div class="flex items-center gap-2">
                <h1 class="text-2xl font-semibold text-white flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                    </svg>
                    Feedbacks
                </h1>
            </div>
        </div>

        <!-- Feedback Content -->
        <div class="space-y-3">
            @if(count($feedbackByChallenge) > 0)
                @foreach($feedbackByChallenge as $challengeId => $challenge)
                    <div class="p-4 bg-gradient-to-br from-neutral-800 to-neutral-900 rounded-lg border border-neutral-700 shadow-md">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="p-1.5 bg-blue-500/10 rounded-md">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path d="M12 14l9-5-9-5-9 5 9 5z" />
                                    <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                </svg>
                            </div>
                            <h2 class="text-base font-semibold text-white">{{ $challenge['challenge_name'] }}</h2>
                            <div class="ml-auto flex items-center gap-1.5">
                                <a href="{{ route('challenge', ['challenge' => $challengeId]) }}" class="text-xs text-emerald-400 hover:text-emerald-300 transition-colors flex items-center gap-1">
                                    <span>View Challenge</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                </a>
                                <button
                                    class="p-1 rounded-md bg-neutral-700 hover:bg-neutral-600 text-neutral-300 transition-colors"
                                    onclick="toggleChallenge('challenge-{{ $challengeId }}')"
                                    aria-label="Toggle challenge details"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 transform transition-transform duration-200 rotate-180" id="icon-challenge-{{ $challengeId }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="space-y-2" id="challenge-{{ $challengeId }}">
                            @foreach($challenge['items'] as $item)
                                <div class="p-3 {{ $item['is_correct'] ? 'bg-emerald-500/10 border-emerald-500/20' : 'bg-amber-500/10 border-amber-500/20' }} border rounded-md">
                                    <div class="flex flex-wrap items-center gap-1.5 mb-2">
                                        <h3 class="text-sm font-medium {{ $item['is_correct'] ? 'text-emerald-400' : 'text-amber-400' }}">{{ $item['task_name'] }}</h3>
                                        <div class="flex items-center gap-1.5 ml-auto">
                                            <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $item['is_correct'] ? 'bg-emerald-500/20 text-emerald-400' : 'bg-amber-500/20 text-amber-400' }}">
                                                {{ $item['is_correct'] ? 'Correct' : 'Needs Improvement' }}
                                            </span>
                                            <span class="px-2 py-0.5 rounded-full bg-blue-500/20 text-blue-400 text-xs font-medium">
                                                {{ $item['score'] }} pts
                                            </span>
                                        </div>
                                    </div>

                                    <div class="p-2 bg-neutral-800/50 rounded-md mb-2 text-sm">
                                        <p class="whitespace-pre-line">
                                            <span class="text-blue-400 font-medium">Comment:</span>
                                            <span class="text-neutral-300">{{ $item['feedback'] }}</span>
                                        </p>
                                    </div>

                                    <div class="flex flex-wrap items-center text-xs text-neutral-400 gap-2">
                                        <div class="flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-neutral-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span>{{ $item['evaluated_at'] ? $item['evaluated_at']->format('M d, Y - h:i A') : 'N/A' }}</span>
                                        </div>
                                        <div class="flex items-center gap-1 ml-auto">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-neutral-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            <span>Reviewed by: {{ $item['evaluator_name'] }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @else
                <div class="flex flex-col items-center justify-center p-6 bg-neutral-800/50 rounded-lg border border-neutral-700 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-neutral-600 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                    </svg>
                    <h3 class="text-lg font-medium text-white mb-2">No feedback yet</h3>
                    <p class="text-neutral-400 text-center mb-4 text-sm">Complete tasks to receive feedbacks!</p>
                    <a href="{{ route('learning') }}" class="flex items-center justify-center gap-1.5 bg-emerald-500 hover:bg-emerald-600 text-white font-medium py-1.5 px-3 rounded-md transition-all duration-300 text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <span>Browse Challenges</span>
                    </a>
                </div>
            @endif
        </div>
    </div>

    <script>
        function toggleChallenge(id) {
            const content = document.getElementById(id);
            const icon = document.getElementById('icon-' + id);

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

