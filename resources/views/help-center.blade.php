<x-layouts.app>
    <div class="flex h-full w-full flex-1 flex-col gap-6 text-gray-100 p-6 border border-emerald-500/30 rounded-lg bg-linear-to-b from-neutral-900 to-neutral-800">
        <div class="max-w-7xl mx-auto w-full">
            <!-- Header Section with Animated Gradient -->
            <div class="text-center mb-12 relative">
                <div class="absolute inset-0 bg-linear-to-r from-blue-500/10 via-purple-500/10 to-emerald-500/10 rounded-xl blur-xl opacity-50"></div>
                <div class="relative">
                    <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Help Center</h1>
                    <p class="text-lg text-zinc-300 max-w-3xl mx-auto">Find answers to your questions and learn how to make the most of our platform</p>
                </div>
            </div>

            <!-- Enhanced Search Section with Suggested Searches -->
            <div class="mb-12">
                <div class="max-w-2xl mx-auto">
                    <div class="relative">
                        <input type="text" placeholder="Search for help..." class="w-full px-4 py-3 rounded-lg border border-neutral-700 bg-neutral-800/80 text-white placeholder-neutral-400 focus:outline-hidden focus:ring-2 focus:ring-emerald-500/50 hover:border-neutral-600 transition-all duration-300 ease-in-out pl-12">
                        <div class="absolute left-3 top-3">
                            <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <button class="absolute right-3 top-2 px-3 py-1 bg-emerald-500/20 text-emerald-400 rounded-md text-sm border border-emerald-500/30 hover:bg-emerald-500/30 transition-colors">
                            Search
                        </button>
                    </div>
                    
                    <!-- Suggested Searches -->
                    <div class="mt-3 flex flex-wrap gap-2 justify-center">
                        <span class="text-xs text-neutral-400">Popular searches:</span>
                        <a href="#" class="text-xs px-3 py-1 rounded-full bg-neutral-800 border border-neutral-700 text-neutral-300 hover:bg-neutral-700 transition-colors">password reset</a>
                        <a href="#" class="text-xs px-3 py-1 rounded-full bg-neutral-800 border border-neutral-700 text-neutral-300 hover:bg-neutral-700 transition-colors">course access</a>
                        <a href="#" class="text-xs px-3 py-1 rounded-full bg-neutral-800 border border-neutral-700 text-neutral-300 hover:bg-neutral-700 transition-colors">payment issues</a>
                        <a href="#" class="text-xs px-3 py-1 rounded-full bg-neutral-800 border border-neutral-700 text-neutral-300 hover:bg-neutral-700 transition-colors">mobile app</a>
                    </div>
                </div>
            </div>

            <!-- Quick Links with Improved Design -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                <div class="p-6 rounded-xl border border-neutral-700 bg-linear-to-br from-neutral-800 to-neutral-900 transition-all duration-300 ease-in-out hover:scale-[1.02] hover:shadow-lg hover:shadow-emerald-900/20 hover:border-emerald-500/30">
                    <div class="flex items-center mb-4">
                        <div class="p-3 rounded-lg bg-emerald-500/10 border border-emerald-500/20">
                            <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <h2 class="ml-3 text-xl font-semibold text-white">Getting Started</h2>
                    </div>
                    <p class="text-zinc-400 mb-4">Learn the basics and get up to speed with our platform features</p>
                    <a href="#" class="text-emerald-400 hover:text-emerald-300 transition-colors text-sm flex items-center">
                        <span>View guides</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>

                <div class="p-6 rounded-xl border border-neutral-700 bg-linear-to-br from-neutral-800 to-neutral-900 transition-all duration-300 ease-in-out hover:scale-[1.02] hover:shadow-lg hover:shadow-emerald-900/20 hover:border-emerald-500/30">
                    <div class="flex items-center mb-4">
                        <div class="p-3 rounded-lg bg-blue-500/10 border border-blue-500/20">
                            <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h2 class="ml-3 text-xl font-semibold text-white">FAQs</h2>
                    </div>
                    <p class="text-zinc-400 mb-4">Find answers to commonly asked questions about our services</p>
                    <a href="#" class="text-blue-400 hover:text-blue-300 transition-colors text-sm flex items-center">
                        <span>Browse FAQs</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>

                <div class="p-6 rounded-xl border border-neutral-700 bg-linear-to-br from-neutral-800 to-neutral-900 transition-all duration-300 ease-in-out hover:scale-[1.02] hover:shadow-lg hover:shadow-emerald-900/20 hover:border-emerald-500/30">
                    <div class="flex items-center mb-4">
                        <div class="p-3 rounded-lg bg-purple-500/10 border border-purple-500/20">
                            <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h2 class="ml-3 text-xl font-semibold text-white">Technical Support</h2>
                    </div>
                    <p class="text-zinc-400 mb-4">Get technical assistance and troubleshooting help</p>
                    <a href="#" class="text-purple-400 hover:text-purple-300 transition-colors text-sm flex items-center">
                        <span>Get support</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Knowledge Base Section -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-white mb-6 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    Knowledge Base
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="p-5 rounded-xl border border-neutral-700 bg-neutral-800/50 hover:bg-neutral-800 transition-all duration-300">
                        <h3 class="text-lg font-semibold text-white mb-3">Getting Started</h3>
                        <ul class="space-y-2">
                            <li>
                                <a href="#" class="text-zinc-300 hover:text-emerald-400 transition-colors flex items-center text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                    Platform overview
                                </a>
                            </li>
                            <li>
                                <a href="#" class="text-zinc-300 hover:text-emerald-400 transition-colors flex items-center text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                    Creating your account
                                </a>
                            </li>
                            <li>
                                <a href="#" class="text-zinc-300 hover:text-emerald-400 transition-colors flex items-center text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                    Navigating the dashboard
                                </a>
                            </li>
                            <li>
                                <a href="#" class="text-zinc-300 hover:text-emerald-400 transition-colors flex items-center text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                    Setting up your profile
                                </a>
                            </li>
                        </ul>
                        <a href="#" class="mt-4 inline-block text-xs text-emerald-400 hover:text-emerald-300">View all articles →</a>
                    </div>
                    
                    <div class="p-5 rounded-xl border border-neutral-700 bg-neutral-800/50 hover:bg-neutral-800 transition-all duration-300">
                        <h3 class="text-lg font-semibold text-white mb-3">Account Management</h3>
                        <ul class="space-y-2">
                            <li>
                                <a href="#" class="text-zinc-300 hover:text-emerald-400 transition-colors flex items-center text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                    How to reset your password
                                </a>
                            </li>
                            <li>
                                <a href="#" class="text-zinc-300 hover:text-emerald-400 transition-colors flex items-center text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                    Updating your profile information
                                </a>
                            </li>
                            <li>
                                <a href="#" class="text-zinc-300 hover:text-emerald-400 transition-colors flex items-center text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                    Managing notification settings
                                </a>
                            </li>
                            <li>
                                <a href="#" class="text-zinc-300 hover:text-emerald-400 transition-colors flex items-center text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                    Two-factor authentication
                                </a>
                            </li>
                        </ul>
                        <a href="#" class="mt-4 inline-block text-xs text-emerald-400 hover:text-emerald-300">View all articles →</a>
                    </div>
                    
                    <div class="p-5 rounded-xl border border-neutral-700 bg-neutral-800/50 hover:bg-neutral-800 transition-all duration-300">
                        <h3 class="text-lg font-semibold text-white mb-3">Course Access</h3>
                        <ul class="space-y-2">
                            <li>
                                <a href="#" class="text-zinc-300 hover:text-emerald-400 transition-colors flex items-center text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                    Accessing course materials
                                </a>
                            </li>
                            <li>
                                <a href="#" class="text-zinc-300 hover:text-emerald-400 transition-colors flex items-center text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                    Submitting assignments
                                </a>
                            </li>
                            <li>
                                <a href="#" class="text-zinc-300 hover:text-emerald-400 transition-colors flex items-center text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                    Viewing grades and feedback
                                </a>
                            </li>
                            <li>
                                <a href="#" class="text-zinc-300 hover:text-emerald-400 transition-colors flex items-center text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                    Downloading course certificates
                                </a>
                            </li>
                        </ul>
                        <a href="#" class="mt-4 inline-block text-xs text-emerald-400 hover:text-emerald-300">View all articles →</a>
                    </div>
                </div>
            </div>

            <!-- FAQ Accordion Section -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-white mb-6 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Frequently Asked Questions
                </h2>
                
                <div class="space-y-4">
                    <!-- FAQ Item 1 -->
                    <div class="border border-neutral-700 rounded-lg overflow-hidden">
                        <button class="w-full flex justify-between items-center p-4 bg-neutral-800 hover:bg-neutral-700 transition-colors text-left" onclick="toggleFaq('faq1')">
                            <span class="font-medium text-white">How do I reset my password?</span>
                            <svg id="faq1-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400 transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div id="faq1" class="hidden p-4 bg-neutral-800/50 border-t border-neutral-700">
                            <p class="text-zinc-300 text-sm">
                                To reset your password, click on the "Forgot Password" link on the login page. Enter your email address, and we'll send you a password reset link. Follow the instructions in the email to create a new password.
                            </p>
                        </div>
                    </div>
                    
                    <!-- FAQ Item 2 -->
                    <div class="border border-neutral-700 rounded-lg overflow-hidden">
                        <button class="w-full flex justify-between items-center p-4 bg-neutral-800 hover:bg-neutral-700 transition-colors text-left" onclick="toggleFaq('faq2')">
                            <span class="font-medium text-white">How do I access my course materials?</span>
                            <svg id="faq2-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400 transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div id="faq2" class="hidden p-4 bg-neutral-800/50 border-t border-neutral-700">
                            <p class="text-zinc-300 text-sm">
                                After logging in, navigate to the "My Courses" section in your dashboard. Click on the course you want to access, and you'll be taken to the course homepage where you can find all materials, lectures, assignments, and resources for that course.
                            </p>
                        </div>
                    </div>
                    
                    <!-- FAQ Item 3 -->
                    <div class="border border-neutral-700 rounded-lg overflow-hidden">
                        <button class="w-full flex justify-between items-center p-4 bg-neutral-800 hover:bg-neutral-700 transition-colors text-left" onclick="toggleFaq('faq3')">
                            <span class="font-medium text-white">How do I submit assignments?</span>
                            <svg id="faq3-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400 transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div id="faq3" class="hidden p-4 bg-neutral-800/50 border-t border-neutral-700">
                            <p class="text-zinc-300 text-sm">
                                To submit an assignment, go to the specific course page, find the assignment section, and click on the assignment you want to submit. You'll see a "Submit Assignment" button where you can upload your files or type your answers, depending on the assignment type.
                            </p>
                        </div>
                    </div>
                    
                    <!-- FAQ Item 4 -->
                    <div class="border border-neutral-700 rounded-lg overflow-hidden">
                        <button class="w-full flex justify-between items-center p-4 bg-neutral-800 hover:bg-neutral-700 transition-colors text-left" onclick="toggleFaq('faq4')">
                            <span class="font-medium text-white">How do I get a certificate for completed courses?</span>
                            <svg id="faq4-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400 transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div id="faq4" class="hidden p-4 bg-neutral-800/50 border-t border-neutral-700">
                            <p class="text-zinc-300 text-sm">
                                Once you've completed all the required components of a course (lectures, assignments, quizzes, etc.), a certificate will automatically be generated. You can access and download your certificates from the "Achievements" or "Certificates" section in your profile.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Community Support Section -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-white mb-6 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Community Support
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="p-6 rounded-xl border border-neutral-700 bg-linear-to-br from-neutral-800 to-neutral-900 transition-all duration-300 ease-in-out hover:border-emerald-500/30">
                        <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                            </svg>
                            Discussion Forums
                        </h3>
                        <p class="text-zinc-400 mb-4">Join our active community forums to ask questions, share knowledge, and connect with fellow learners.</p>
                        <a href="#" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-hidden focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors">
                            Browse Forums
                        </a>
                    </div>
                    
                    <div class="p-6 rounded-xl border border-neutral-700 bg-linear-to-br from-neutral-800 to-neutral-900 transition-all duration-300 ease-in-out hover:border-emerald-500/30">
                        <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                            Live Webinars
                        </h3>
                        <p class="text-zinc-400 mb-4">Attend our regular live webinars where instructors answer questions and provide additional guidance.</p>
                        <a href="#" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-hidden focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors">
                            View Schedule
                        </a>
                    </div>
                </div>
            </div>

            <!-- Enhanced Contact Support Section -->
            <div class="rounded-xl border border-neutral-700 bg-linear-to-br from-neutral-800 to-neutral-900 p-8 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl -mr-32 -mt-32 pointer-events-none"></div>
                <div class="relative z-10">
                    <div class="text-center mb-8">
                        <h2 class="text-2xl font-bold text-white mb-4">Still Need Help?</h2>
                        <p class="text-zinc-400 max-w-2xl mx-auto">Our support team is available 24/7 to assist you with any questions or issues you may have.</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <a href="#" class="p-5 rounded-xl border border-neutral-700 bg-neutral-800/50 hover:bg-neutral-800 transition-all duration-300 flex flex-col items-center text-center group">
                            <div class="p-3 rounded-full bg-emerald-500/10 border border-emerald-500/20 mb-4 group-hover:bg-emerald-500/20 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-white mb-2">Email Support</h3>
                            <p class="text-zinc-400 text-sm mb-3">Send us an email and we'll respond within 24 hours</p>
                            <span class="text-emerald-400 text-sm">support@example.com</span>
                        </a>
                        
                        <a href="#" class="p-5 rounded-xl border border-neutral-700 bg-neutral-800/50 hover:bg-neutral-800 transition-all duration-300 flex flex-col items-center text-center group">
                            <div class="p-3 rounded-full bg-blue-500/10 border border-blue-500/20 mb-4 group-hover:bg-blue-500/20 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-white mb-2">Live Chat</h3>
                            <p class="text-zinc-400 text-sm mb-3">Chat with our support team in real-time</p>
                            <span class="text-blue-400 text-sm">Available 24/7</span>
                        </a>
                        
                        <a href="#" class="p-5 rounded-xl border border-neutral-700 bg-neutral-800/50 hover:bg-neutral-800 transition-all duration-300 flex flex-col items-center text-center group">
                            <div class="p-3 rounded-full bg-purple-500/10 border border-purple-500/20 mb-4 group-hover:bg-purple-500/20 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-white mb-2">Phone Support</h3>
                            <p class="text-zinc-400 text-sm mb-3">Call us for immediate assistance</p>
                            <span class="text-purple-400 text-sm">+1 (555) 123-4567</span>
                        </a>
                    </div>
                    
                    <!-- Floating Chat Button -->
                    <div class="fixed bottom-6 right-6 z-50">
                        <button class="w-14 h-14 rounded-full bg-emerald-500 hover:bg-emerald-600 text-white flex items-center justify-center shadow-lg hover:shadow-emerald-500/30 transition-all duration-300 group">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                            </svg>
                            <span class="absolute right-full mr-3 bg-neutral-800 text-white text-sm px-3 py-1.5 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">Chat with us</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- JavaScript for FAQ Accordion -->
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

