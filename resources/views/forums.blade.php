<x-layouts.app>
    <div class="min-h-screen bg-neutral-800 p-6">
        <div class="max-w-7xl mx-auto">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-semibold text-white flex items-center gap-2">
                    <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    Forums
                </h1>
                <div class="flex space-x-4">
                    <select class="bg-neutral-900 border border-neutral-700 rounded-lg px-4 py-2 text-sm text-white">
                        <option>Sort by: Hot</option>
                        <option>Sort by: New</option>
                        <option>Sort by: Top</option>
                    </select>
                    <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm transition-all duration-300 ease-in-out hover:scale-[1.02]">New Post</button>
                </div>
            </div>
            
            <div class="mt-6 space-y-4">
                <!-- Forum Post -->
                <div class="bg-neutral-800 border border-neutral-700 overflow-hidden shadow-sm sm:rounded-lg transition-all duration-300 ease-in-out hover:scale-[1.01] hover:shadow-lg hover:shadow-neutral-700/20">
                    <div class="p-6">
                        <!-- Post Header -->
                        <div class="flex items-center space-x-3 mb-4">
                            <div class="h-10 w-10 rounded-full bg-neutral-700 flex items-center justify-center text-white font-medium">JD</div>
                            <div>
                                <p class="text-sm font-medium text-white">Posted by u/johndoe</p>
                                <p class="text-xs text-neutral-400">2 hours ago</p>
                            </div>
                        </div>
                        
                        <!-- Post Content -->
                        <h2 class="text-xl font-semibold text-white mb-2">Welcome to our new forum!</h2>
                        <p class="text-neutral-300 mb-4">This is an example post to demonstrate the new Reddit-style forum layout.</p>
                        
                        <!-- Post Actions -->
                        <div class="flex items-center space-x-4 text-sm text-neutral-400">
                            <div class="flex items-center space-x-2">
                                <button class="hover:text-indigo-400 transition-colors duration-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                    </svg>
                                </button>
                                <span>42</span>
                                <button class="hover:text-indigo-400 transition-colors duration-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                            </div>
                            <button class="flex items-center space-x-1 hover:text-indigo-400 transition-colors duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                                <span>12 Comments</span>
                            </button>
                            <button class="flex items-center space-x-1 hover:text-indigo-400 transition-colors duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                                </svg>
                                <span>Share</span>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Comments Section -->
                    <div class="border-t border-neutral-700">
                        <div class="p-6 space-y-6">
                            <!-- Comment Input -->
                            <div class="flex space-x-4">
                                <div class="h-10 w-10 rounded-full bg-neutral-700 flex items-center justify-center text-white font-medium">ME</div>
                                <div class="flex-1">
                                    <textarea class="w-full px-3 py-2 text-sm text-white bg-neutral-800 border border-neutral-700 rounded-lg focus:outline-none focus:border-indigo-500 focus:ring focus:ring-indigo-500/20 transition-all duration-300" rows="3" placeholder="What are your thoughts?"></textarea>
                                    <button class="mt-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm transition-all duration-300 ease-in-out hover:scale-[1.02] hover:shadow-lg hover:shadow-indigo-600/20">Comment</button>
                                </div>
                            </div>
                            
                            <!-- Comment Thread -->
                            <div class="space-y-4">
                                <!-- Parent Comment -->
                                <div class="flex space-x-4">
                                    <div class="h-10 w-10 rounded-full bg-neutral-700 flex items-center justify-center text-white font-medium">AS</div>
                                    <div class="flex-1">
                                        <div class="bg-neutral-800 border border-neutral-700 rounded-lg p-4 hover:border-neutral-600 transition-all duration-300">
                                            <div class="flex items-center space-x-2 mb-2">
                                                <span class="font-medium text-white">Alice Smith</span>
                                                <span class="text-xs text-neutral-400">1 hour ago</span>
                                            </div>
                                            <p class="text-neutral-300">This is a great initiative! Looking forward to engaging with everyone here.</p>
                                            <div class="mt-2 flex items-center space-x-4 text-sm text-neutral-400">
                                                <div class="flex items-center space-x-2">
                                                    <button class="hover:text-indigo-400 transition-colors duration-300">↑</button>
                                                    <span>24</span>
                                                    <button class="hover:text-indigo-400 transition-colors duration-300">↓</button>
                                                </div>
                                                <button class="hover:text-indigo-400 transition-colors duration-300">Reply</button>
                                            </div>
                                        </div>
                                        
                                        <!-- Nested Comment -->
                                        <div class="mt-4 ml-8">
                                            <div class="flex space-x-4">
                                                <div class="h-10 w-10 rounded-full bg-neutral-700 flex items-center justify-center text-white font-medium">BW</div>
                                                <div class="flex-1">
                                                    <div class="bg-neutral-800 border border-neutral-700 rounded-lg p-4 hover:border-neutral-600 transition-all duration-300">
                                                        <div class="flex items-center space-x-2 mb-2">
                                                            <span class="font-medium text-white">Bob Wilson</span>
                                                            <span class="text-xs text-neutral-400">30 minutes ago</span>
                                                        </div>
                                                        <p class="text-neutral-300">Totally agree with you Alice! Can't wait to see this community grow.</p>
                                                        <div class="mt-2 flex items-center space-x-4 text-sm text-neutral-400">
                                                            <div class="flex items-center space-x-2">
                                                                <button class="hover:text-indigo-400 transition-colors duration-300">↑</button>
                                                                <span>12</span>
                                                                <button class="hover:text-indigo-400 transition-colors duration-300">↓</button>
                                                            </div>
                                                            <button class="hover:text-indigo-400 transition-colors duration-300">Reply</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>