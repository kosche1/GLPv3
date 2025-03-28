<x-layouts.app>
    <!-- <div class="min-h-screen p-8 bg-white dark:bg-neutral-800"> -->
    <div class="flex h-full w-full flex-1 flex-col gap-6 text-gray-100 p-6 border border-emerald-500 rounded-lg" id="app">
        <div class="max-w-7xl mx-auto">
            <!-- Header Section -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-zinc-900 dark:text-white mb-4">Help Center</h1>
                <p class="text-lg text-zinc-600 dark:text-zinc-400">Find answers to your questions and learn how to make the most of our platform</p>
            </div>

            <!-- Search Section -->
            <div class="mb-12">
                <div class="max-w-2xl mx-auto">
                    <div class="relative">
                        <input type="text" placeholder="Search for help..." class="w-full px-4 py-3 rounded-lg border border-neutral-700 bg-neutral-800 text-white placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-blue-500 hover:border-neutral-600 transition-all duration-300 ease-in-out">
                        <div class="absolute right-3 top-3">
                            <svg class="w-6 h-6 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                <div class="p-6 rounded-xl border border-neutral-700 bg-neutral-800 transition-all duration-300 ease-in-out hover:scale-[1.02] hover:shadow-lg hover:shadow-neutral-900/50 hover:border-neutral-600 hover:bg-neutral-800/90">
                    <div class="flex items-center mb-4">
                        <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <h2 class="ml-3 text-xl font-semibold text-zinc-900 dark:text-white">Getting Started</h2>
                    </div>
                    <p class="text-zinc-600 dark:text-zinc-400">Learn the basics and get up to speed with our platform features</p>
                </div>

                <div class="p-6 rounded-xl border border-neutral-700 bg-neutral-800 transition-all duration-300 ease-in-out hover:scale-[1.02] hover:shadow-lg hover:shadow-neutral-900/50 hover:border-neutral-600 hover:bg-neutral-800/90">
                    <div class="flex items-center mb-4">
                        <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h2 class="ml-3 text-xl font-semibold text-zinc-900 dark:text-white">FAQs</h2>
                    </div>
                    <p class="text-zinc-600 dark:text-zinc-400">Find answers to commonly asked questions about our services</p>
                </div>

                <div class="p-6 rounded-xl border border-neutral-700 bg-neutral-800 transition-all duration-300 ease-in-out hover:scale-[1.02] hover:shadow-lg hover:shadow-neutral-900/50 hover:border-neutral-600 hover:bg-neutral-800/90">
                    <div class="flex items-center mb-4">
                        <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h2 class="ml-3 text-xl font-semibold text-zinc-900 dark:text-white">Technical Support</h2>
                    </div>
                    <p class="text-zinc-600 dark:text-zinc-400">Get technical assistance and troubleshooting help</p>
                </div>
            </div>

            <!-- Popular Topics -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-zinc-900 dark:text-white mb-6">Popular Topics</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="p-6 rounded-xl border border-neutral-700 bg-neutral-800 transition-all duration-300 ease-in-out hover:scale-[1.02] hover:shadow-lg hover:shadow-neutral-900/50 hover:border-neutral-600 hover:bg-neutral-800/90">
                        <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Account Management</h3>
                        <ul class="space-y-3">
                            <li><a href="#" class="text-blue-500 hover:text-blue-600 dark:hover:text-blue-400">How to reset your password</a></li>
                            <li><a href="#" class="text-blue-500 hover:text-blue-600 dark:hover:text-blue-400">Updating your profile information</a></li>
                            <li><a href="#" class="text-blue-500 hover:text-blue-600 dark:hover:text-blue-400">Managing notification settings</a></li>
                        </ul>
                    </div>

                    <div class="p-6 rounded-xl border border-neutral-700 bg-neutral-800 transition-all duration-300 ease-in-out hover:scale-[1.02] hover:shadow-lg hover:shadow-neutral-900/50 hover:border-neutral-600 hover:bg-neutral-800/90">
                        <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Course Access</h3>
                        <ul class="space-y-3">
                            <li><a href="#" class="text-blue-500 hover:text-blue-600 dark:hover:text-blue-400">Accessing course materials</a></li>
                            <li><a href="#" class="text-blue-500 hover:text-blue-600 dark:hover:text-blue-400">Submitting assignments</a></li>
                            <li><a href="#" class="text-blue-500 hover:text-blue-600 dark:hover:text-blue-400">Viewing grades and feedback</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Contact Support -->
            <div class="text-center">
                <h2 class="text-2xl font-bold text-zinc-900 dark:text-white mb-4">Still Need Help?</h2>
                <p class="text-zinc-600 dark:text-zinc-400 mb-6">Our support team is available 24/7 to assist you</p>
                <a href="#" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Contact Support
                </a>
            </div>
        </div>
    </div>]
</x-layouts.app>