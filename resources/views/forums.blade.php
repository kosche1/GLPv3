<x-layouts.app>
    <div class="flex h-full w-full flex-1 flex-col gap-6 text-gray-100 p-6 border border-emerald-500 rounded-lg">
            <div class="flex justify-between items-center mb-6">
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
                    <button class="bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded-lg text-sm transition-all duration-300 ease-in-out hover:scale-[1.02] flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        New Post
                    </button>
                </div>
            </div>
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
                <div class="relative w-full md:w-1/2">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input type="text" placeholder="Search forums..." 
                        class="w-full rounded-lg border border-neutral-700 bg-neutral-800 pl-10 pr-4 py-2 text-sm text-white placeholder-neutral-400 focus:border-emerald-500/30 focus:outline-none transition-all duration-300 hover:border-neutral-600">
                </div>
                <div class="flex flex-wrap gap-2">
                    <button class="px-3 py-1 text-xs rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 hover:bg-emerald-500/20 transition-colors">All Topics</button>
                    <button class="px-3 py-1 text-xs rounded-full bg-neutral-800 text-neutral-400 border border-neutral-700 hover:bg-neutral-700 transition-colors">Announcements</button>
                    <button class="px-3 py-1 text-xs rounded-full bg-neutral-800 text-neutral-400 border border-neutral-700 hover:bg-neutral-700 transition-colors">Questions</button>
                    <button class="px-3 py-1 text-xs rounded-full bg-neutral-800 text-neutral-400 border border-neutral-700 hover:bg-neutral-700 transition-colors">Discussions</button>
                    <button class="px-3 py-1 text-xs rounded-full bg-neutral-800 text-neutral-400 border border-neutral-700 hover:bg-neutral-700 transition-colors">Resources</button>
                </div>
            </div>
            
            <div class="mt-6 space-y-4">
                <!-- Forum Post -->
                <div class="bg-gradient-to-br from-neutral-800 to-neutral-900 border border-neutral-700 overflow-hidden shadow-sm rounded-xl transition-all duration-300 ease-in-out ">
                    <div class="p-6">
                        <!-- Post Header -->
                        <div class="flex items-center space-x-3 mb-4">
                            <div class="flex items-center space-x-3 mb-4">
                                <div class="h-10 w-10 rounded-full bg-emerald-500/20 border border-emerald-500/30 flex items-center justify-center text-emerald-400 font-medium">JD</div>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-white">Posted by u/johndoe</p>
                                <p class="text-xs text-neutral-400">2 hours ago</p>
                                <span class="ml-2 px-2 py-0.5 text-xs rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Announcement</span>
                            </div>
                        </div>
                        
                        <!-- Post Content -->
                        <h2 class="text-xl font-semibold text-white mb-2">Welcome to our new forum!</h2>
                        <p class="text-neutral-300 mb-4">This is an example post to demonstrate the new Reddit-style forum layout.</p>
                        
                        <!-- Post Actions -->
                        <div class="flex items-center space-x-4 text-sm text-neutral-400">
                            <div class="flex items-center space-x-2">
                                <button class="hover:text-emerald-400 transition-colors duration-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                    </svg>
                                </button>
                                <span>42</span>
                                <button class="hover:text-emerald-400 transition-colors duration-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                            </div>
                            <button class="flex items-center space-x-1 hover:text-emerald-400 transition-colors duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                                <span>12 Comments</span>
                            </button>
                            <button class="flex items-center space-x-1 hover:text-emerald-400 transition-colors duration-300">
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
                                    <button class="mt-2 bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded-lg text-sm transition-all duration-300 ease-in-out hover:scale-[1.02] hover:shadow-lg hover:shadow-emerald-600/20">Comment</button>
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
                                                    <button class="hover:text-emerald-400 transition-colors duration-300">↑</button>
                                                    <span>24</span>
                                                    <button class="hover:text-emerald-400 transition-colors duration-300">↓</button>
                                                </div>
                                                <button class="hover:text-emerald-400 transition-colors duration-300">Reply</button>
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
                                                                <button class="hover:text-emerald-400 transition-colors duration-300">↑</button>
                                                                <span>12</span>
                                                                <button class="hover:text-emerald-400 transition-colors duration-300">↓</button>
                                                            </div>
                                                            <button class="hover:text-emerald-400 transition-colors duration-300">Reply</button>
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
            <div class="mt-8">
                <h2 class="text-xl font-semibold text-white mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                    Trending Topics
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="p-4 rounded-xl border border-neutral-700 bg-gradient-to-br from-neutral-800 to-neutral-900 transition-all duration-300 hover:border-emerald-500/30 hover:shadow-lg">
                        <div class="flex justify-between items-start mb-2">
                            <span class="px-2 py-0.5 text-xs rounded-full bg-blue-500/10 text-blue-400 border border-blue-500/20">Question</span>
                            <span class="text-xs text-neutral-400">3 hours ago</span>
                        </div>
                        <h3 class="text-white font-medium mb-1">How to implement authentication in Laravel?</h3>
                        <p class="text-neutral-400 text-sm mb-2 line-clamp-2">I'm trying to set up authentication in my Laravel project but I'm running into some issues...</p>
                        <div class="flex justify-between items-center text-xs text-neutral-400">
                            <span>Posted by u/developer123</span>
                            <span>24 comments</span>
                        </div>
                    </div>
                    <div class="p-4 rounded-xl border border-neutral-700 bg-gradient-to-br from-neutral-800 to-neutral-900 transition-all duration-300 hover:border-emerald-500/30 hover:shadow-lg">
                        <div class="flex justify-between items-start mb-2">
                            <span class="px-2 py-0.5 text-xs rounded-full bg-purple-500/10 text-purple-400 border border-purple-500/20">Discussion</span>
                            <span class="text-xs text-neutral-400">5 hours ago</span>
                        </div>
                        <h3 class="text-white font-medium mb-1">What's your favorite CSS framework?</h3>
                        <p class="text-neutral-400 text-sm mb-2 line-clamp-2">I've been using Tailwind CSS for a while now, but I'm curious what others are using...</p>
                        <div class="flex justify-between items-center text-xs text-neutral-400">
                            <span>Posted by u/designlover</span>
                            <span>42 comments</span>
                        </div>
                    </div>
                    <div class="p-4 rounded-xl border border-neutral-700 bg-gradient-to-br from-neutral-800 to-neutral-900 transition-all duration-300 hover:border-emerald-500/30 hover:shadow-lg">
                        <div class="flex justify-between items-start mb-2">
                            <span class="px-2 py-0.5 text-xs rounded-full bg-amber-500/10 text-amber-400 border border-amber-500/20">Resource</span>
                            <span class="text-xs text-neutral-400">1 day ago</span>
                        </div>
                        <h3 class="text-white font-medium mb-1">Free resources for learning JavaScript in 2025</h3>
                        <p class="text-neutral-400 text-sm mb-2 line-clamp-2">I've compiled a list of the best free resources for learning JavaScript in 2025...</p>
                        <div class="flex justify-between items-center text-xs text-neutral-400">
                            <span>Posted by u/jsmaster</span>
                            <span>18 comments</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</x-layouts.app>