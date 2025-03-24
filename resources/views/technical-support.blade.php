<x-layouts.app>
    <div class="min-h-screen bg-white dark:bg-neutral-800 p-8">
        <div class="max-w-7xl mx-auto">
            <!-- Header Section -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-zinc-900 dark:text-white mb-4">Technical Support</h1>
                <p class="text-lg text-zinc-600 dark:text-zinc-400">Get help with your technical issues</p>
            </div>

            <!-- Search Bar -->
            <div class="mb-10">
                <div class="max-w-2xl mx-auto relative">
                    <input type="text" id="searchInput" placeholder="Search for help..." class="w-full px-4 py-3 rounded-lg bg-zinc-50 dark:bg-neutral-800 border border-neutral-700 focus:outline-none focus:ring-2 focus:ring-blue-500 text-zinc-900 dark:text-white hover:border-neutral-600 transition-all duration-300" aria-label="Search for help">
                    <button class="absolute right-3 top-3 text-zinc-400" aria-label="Search">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                    <!-- Auto-suggestions -->
                    <div id="suggestions" class="hidden bg-white dark:bg-neutral-800 shadow-lg rounded-lg mt-2 absolute w-full z-10">
                        <!-- Suggestions will appear here dynamically -->
                    </div>
                </div>
            </div>

            <!-- Quick Help Categories -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
                <div class="p-6 rounded-xl bg-zinc-50 dark:bg-neutral-800 border border-neutral-700 hover:shadow-lg hover:shadow-neutral-900/50 hover:scale-[1.02] hover:border-neutral-600 hover:bg-neutral-800/90 transition-all duration-300 ease-in-out">
                    <div class="text-blue-500 mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-zinc-900 dark:text-white mb-2">Getting Started</h3>
                    <p class="text-zinc-600 dark:text-zinc-400">New to the platform? Learn the basics and get started quickly.</p>
                </div>

                <div class="p-6 rounded-xl bg-zinc-50 dark:bg-neutral-800 border border-neutral-700 hover:shadow-lg hover:shadow-neutral-900/50 hover:scale-[1.02] hover:border-neutral-600 hover:bg-neutral-800/90 transition-all duration-300 ease-in-out">
                    <div class="text-purple-500 mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-zinc-900 dark:text-white mb-2">Common Issues</h3>
                    <p class="text-zinc-600 dark:text-zinc-400">Find solutions to frequently reported problems and issues.</p>
                </div>

                <div class="p-6 rounded-xl bg-zinc-50 dark:bg-neutral-800 border border-neutral-700 hover:shadow-lg hover:shadow-neutral-900/50 hover:scale-[1.02] hover:border-neutral-600 hover:bg-neutral-800/90 transition-all duration-300 ease-in-out">
                    <div class="text-green-500 mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-zinc-900 dark:text-white mb-2">Quick Solutions</h3>
                    <p class="text-zinc-600 dark:text-zinc-400">Get instant fixes for common technical problems.</p>
                </div>
            </div>

            <!-- Support Ticket Form -->
            <div class="max-w-3xl mx-auto bg-zinc-50 dark:bg-neutral-800 rounded-xl border border-neutral-700 p-8">
                <h2 class="text-2xl font-bold text-zinc-900 dark:text-white mb-6">Create Support Ticket</h2>
                <form id="ticketForm" class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Subject</label>
                        <input type="text" id="subject" class="w-full px-4 py-2 rounded-lg bg-white dark:bg-neutral-800 border border-neutral-700 focus:outline-none focus:ring-2 focus:ring-blue-500 text-zinc-900 dark:text-white hover:border-neutral-600 transition-all duration-300" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Category</label>
                        <select id="category" class="w-full px-4 py-2 rounded-lg bg-white dark:bg-neutral-800 border border-neutral-700 focus:outline-none focus:ring-2 focus:ring-blue-500 text-zinc-900 dark:text-white hover:border-neutral-600 transition-all duration-300">
                            <option>Technical Issue</option>
                            <option>Account Problem</option>
                            <option>Feature Request</option>
                            <option>Other</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Description</label>
                        <textarea rows="4" id="description" class="w-full px-4 py-2 rounded-lg bg-white dark:bg-neutral-800 border border-neutral-700 focus:outline-none focus:ring-2 focus:ring-blue-500 text-zinc-900 dark:text-white hover:border-neutral-600 transition-all duration-300" required></textarea>
                    </div>

                    <div>
                        <button type="submit" class="w-full px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-lg transition duration-200">Submit Ticket</button>
                    </div>
                </form>
            </div>

            <!-- Toast Notification -->
            <div id="toast" class="fixed bottom-4 right-4 bg-blue-600 text-white px-6 py-3 rounded-lg shadow-md opacity-0 pointer-events-none transition-opacity duration-300">
                Your ticket has been submitted successfully!
            </div>
        </div>
    </div>

    <script>
        // Simple form validation
        document.getElementById('ticketForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const subject = document.getElementById('subject').value;
            const category = document.getElementById('category').value;
            const description = document.getElementById('description').value;

            if (subject && category && description) {
                document.getElementById('toast').classList.remove('opacity-0', 'pointer-events-none');
                document.getElementById('toast').classList.add('opacity-100', 'pointer-events-auto');
                setTimeout(() => {
                    document.getElementById('toast').classList.remove('opacity-100', 'pointer-events-auto');
                    document.getElementById('toast').classList.add('opacity-0', 'pointer-events-none');
                }, 3000);
            }
        });

        // Simple search input auto-suggestions
        const searchInput = document.getElementById('searchInput');
        const suggestions = document.getElementById('suggestions');

        searchInput.addEventListener('input', function () {
            const query = searchInput.value.trim();
            if (query.length > 2) {
                suggestions.classList.remove('hidden');
                suggestions.innerHTML = `<p class="p-2 text-zinc-700 dark:text-zinc-300">Searching for: <strong>${query}</strong></p>`;
            } else {
                suggestions.classList.add('hidden');
            }
        });
    </script>
</x-layouts.app>
