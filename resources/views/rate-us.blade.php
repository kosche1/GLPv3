<x-layouts.app>
    <div class="flex h-full w-full flex-1 flex-col gap-6 text-gray-100 p-6 border border-emerald-500/30 rounded-lg bg-linear-to-b from-neutral-900 to-neutral-800">
        <div class="max-w-7xl mx-auto w-full">
            <!-- Header Section with Animated Gradient -->
            <div class="text-center mb-12 relative">
                <div class="absolute inset-0 bg-linear-to-r from-blue-500/10 via-purple-500/10 to-emerald-500/10 rounded-xl blur-xl opacity-50"></div>
                <div class="relative">
                    <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Rate Us</h1>
                    <p class="text-lg text-zinc-300 max-w-3xl mx-auto">Your feedback helps us improve our platform and services</p>
                </div>
            </div>

            <!-- Rating Form Section -->
            <div class="max-w-3xl mx-auto rounded-xl border border-neutral-700 bg-linear-to-br from-neutral-800 to-neutral-900 p-8 mb-12 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl -mr-32 -mt-32 pointer-events-none"></div>
                <div class="relative z-10">
                    <h2 class="text-2xl font-bold text-white mb-6 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                        Share Your Experience
                    </h2>

                    @if(session('success'))
                        <div class="mb-6 p-4 rounded-lg bg-emerald-500/20 border border-emerald-500/30 text-emerald-300">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($existingRating)
                        <div class="mb-6 p-4 rounded-lg bg-blue-500/20 border border-blue-500/30 text-blue-300">
                            <div class="flex items-center mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <strong>Your Previous Rating</strong>
                            </div>
                            <p>You rated us {{ $existingRating->rating }}/5 stars on {{ $existingRating->created_at->format('M j, Y') }}.</p>
                            @if($existingRating->feedback)
                                <p class="mt-2 text-sm">Your feedback: "{{ $existingRating->feedback }}"</p>
                            @endif
                            <p class="mt-2 text-sm">You can update your rating below.</p>
                        </div>
                    @endif

                    <form action="{{ route('rate-us.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Star Rating -->
                        <div>
                            <label class="block text-white font-medium mb-4">How would you rate your experience?</label>
                            <div class="flex items-center justify-center space-x-2">
                                <div class="flex space-x-1">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <label for="star-{{ $i }}" class="cursor-pointer">
                                            <input type="radio" id="star-{{ $i }}" name="rating" value="{{ $i }}" class="sr-only peer" required
                                                @if($existingRating && $existingRating->rating == $i) checked @endif>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-neutral-500 peer-checked:text-yellow-400 hover:text-yellow-300 transition-colors" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                            </svg>
                                        </label>
                                    @endfor
                                </div>
                            </div>
                            @error('rating')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Feedback Text Area -->
                        <div>
                            <label for="feedback" class="block text-white font-medium mb-2">Tell us more about your experience (optional)</label>
                            <textarea id="feedback" name="feedback" rows="5" class="w-full px-4 py-3 rounded-lg border border-neutral-700 bg-neutral-800/80 text-white placeholder-neutral-400 focus:outline-hidden focus:ring-2 focus:ring-emerald-500/50 hover:border-neutral-600 transition-all duration-300" placeholder="Share your thoughts, suggestions, or any issues you encountered...">{{ $existingRating ? $existingRating->feedback : old('feedback') }}</textarea>
                            @error('feedback')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-center">
                            <button type="submit" class="px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg transition-colors duration-300 focus:outline-hidden focus:ring-2 focus:ring-emerald-500/50 focus:ring-offset-2 focus:ring-offset-neutral-800">
                                {{ $existingRating ? 'Update Feedback' : 'Submit Feedback' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Why Your Feedback Matters Section -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-white mb-6 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Why Your Feedback Matters
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="p-5 rounded-xl border border-neutral-700 bg-neutral-800/50 hover:bg-neutral-800 transition-all duration-300">
                        <div class="p-3 rounded-full bg-emerald-500/10 border border-emerald-500/20 mb-4 w-14 h-14 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-white mb-3">Improve Our Platform</h3>
                        <p class="text-zinc-300 text-sm">
                            Your feedback helps us identify areas where we can enhance our platform to better serve your needs and provide a more intuitive experience.
                        </p>
                    </div>

                    <div class="p-5 rounded-xl border border-neutral-700 bg-neutral-800/50 hover:bg-neutral-800 transition-all duration-300">
                        <div class="p-3 rounded-full bg-blue-500/10 border border-blue-500/20 mb-4 w-14 h-14 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-white mb-3">Shape Future Features</h3>
                        <p class="text-zinc-300 text-sm">
                            We use your suggestions to prioritize new features and enhancements, ensuring our development roadmap aligns with what matters most to our users.
                        </p>
                    </div>

                    <div class="p-5 rounded-xl border border-neutral-700 bg-neutral-800/50 hover:bg-neutral-800 transition-all duration-300">
                        <div class="p-3 rounded-full bg-purple-500/10 border border-purple-500/20 mb-4 w-14 h-14 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-white mb-3">Address Issues Quickly</h3>
                        <p class="text-zinc-300 text-sm">
                            Your reports help us identify and fix problems faster, ensuring a smoother experience for everyone using our platform.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Star Rating -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('input[name="rating"]');

            // Function to update star display
            function updateStars(rating) {
                stars.forEach((star, index) => {
                    const svg = star.parentElement.querySelector('svg');
                    if (index < rating) {
                        svg.classList.remove('text-neutral-500');
                        svg.classList.add('text-yellow-400');
                    } else {
                        svg.classList.remove('text-yellow-400');
                        svg.classList.add('text-neutral-500');
                    }
                });
            }

            // Initialize stars based on existing rating
            @if($existingRating)
                updateStars({{ $existingRating->rating }});
            @endif

            stars.forEach(star => {
                star.addEventListener('change', function() {
                    const rating = parseInt(this.value);
                    updateStars(rating);
                });
            });
        });
    </script>
</x-layouts.app>
