<x-layouts.app>
    <div class="min-h-screen bg-[#36393F] flex flex-col md:flex-row">
        <!-- Sidebar -->
        <div class="w-full md:w-80 bg-[#2F3136] text-white flex flex-col border-r border-gray-700 transition-all duration-300">
            <div class="p-4 border-b border-gray-700 flex items-center justify-between">
                <h2 class="text-lg font-semibold">Messages</h2>
                <div class="flex items-center space-x-2">
                    <button class="p-2 rounded-full hover:bg-[#40444B] transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                        </svg>
                    </button>
                    <button class="p-2 rounded-full hover:bg-[#40444B] transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Search -->
            <div class="p-4 border-b border-gray-700">
                <div class="relative">
                    <input type="text" class="w-full bg-[#202225] text-gray-200 rounded-md py-2 pl-10 pr-4 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm" placeholder="Search conversations...">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 absolute left-3 top-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
            
            <!-- Filters -->
            <div class="px-4 py-2 border-b border-gray-700 flex space-x-2 overflow-x-auto scrollbar-thin scrollbar-thumb-gray-700">
                <button class="px-3 py-1 bg-blue-500 text-white text-xs rounded-full">All</button>
                <button class="px-3 py-1 bg-[#40444B] text-gray-300 text-xs rounded-full hover:bg-[#4f545c]">Unread</button>
                <button class="px-3 py-1 bg-[#40444B] text-gray-300 text-xs rounded-full hover:bg-[#4f545c]">Important</button>
                <button class="px-3 py-1 bg-[#40444B] text-gray-300 text-xs rounded-full hover:bg-[#4f545c]">Archived</button>
            </div>
            
            <div class="flex-1 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-700">
                <!-- Pinned Conversations -->
                <div class="px-4 pt-3 pb-1">
                    <p class="text-xs text-gray-400 uppercase font-semibold">Pinned</p>
                </div>
                
                <!-- Conversation Item (Active) -->
                <div class="p-3 mx-2 my-1 flex items-center space-x-3 bg-[#40444B] rounded-lg cursor-pointer">
                    <div class="relative">
                        <div class="h-10 w-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-medium">JD</div>
                        <div class="absolute bottom-0 right-0 h-3 w-3 rounded-full bg-green-500 border-2 border-[#2F3136]"></div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-center">
                            <p class="text-sm font-medium truncate">John Doe</p>
                            <p class="text-xs text-gray-400">10:35 AM</p>
                        </div>
                        <div class="flex items-center">
                            <p class="text-xs text-gray-400 truncate">I'm having some trouble with the project.</p>
                            <span class="ml-1 flex-shrink-0 h-5 w-5 bg-blue-500 rounded-full flex items-center justify-center text-xs text-white">3</span>
                        </div>
                    </div>
                </div>
                
                <!-- Regular Conversations -->
                <div class="px-4 pt-3 pb-1">
                    <p class="text-xs text-gray-400 uppercase font-semibold">Recent</p>
                </div>
                
                <!-- Another Conversation -->
                <div class="p-3 mx-2 my-1 flex items-center space-x-3 hover:bg-[#40444B] rounded-lg cursor-pointer transition-colors">
                    <div class="relative">
                        <div class="h-10 w-10 rounded-full bg-purple-600 flex items-center justify-center text-white font-medium">AS</div>
                        <div class="absolute bottom-0 right-0 h-3 w-3 rounded-full bg-gray-500 border-2 border-[#2F3136]"></div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-center">
                            <p class="text-sm font-medium truncate">Alice Smith</p>
                            <p class="text-xs text-gray-400">Yesterday</p>
                        </div>
                        <p class="text-xs text-gray-400 truncate">How's everything going?</p>
                    </div>
                </div>
                
                <!-- More Conversations -->
                <div class="p-3 mx-2 my-1 flex items-center space-x-3 hover:bg-[#40444B] rounded-lg cursor-pointer transition-colors">
                    <div class="relative">
                        <div class="h-10 w-10 rounded-full bg-green-600 flex items-center justify-center text-white font-medium">RJ</div>
                        <div class="absolute bottom-0 right-0 h-3 w-3 rounded-full bg-green-500 border-2 border-[#2F3136]"></div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-center">
                            <p class="text-sm font-medium truncate">Robert Johnson</p>
                            <p class="text-xs text-gray-400">Monday</p>
                        </div>
                        <p class="text-xs text-gray-400 truncate">Can you send me the design files?</p>
                    </div>
                </div>
                
                <div class="p-3 mx-2 my-1 flex items-center space-x-3 hover:bg-[#40444B] rounded-lg cursor-pointer transition-colors">
                    <div class="relative">
                        <div class="h-10 w-10 rounded-full bg-yellow-600 flex items-center justify-center text-white font-medium">EW</div>
                        <div class="absolute bottom-0 right-0 h-3 w-3 rounded-full bg-green-500 border-2 border-[#2F3136]"></div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-center">
                            <p class="text-sm font-medium truncate">Emma Wilson</p>
                            <p class="text-xs text-gray-400">Last week</p>
                        </div>
                        <p class="text-xs text-gray-400 truncate">Meeting at 3pm tomorrow?</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main Chat Window -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <div class="p-4 bg-[#2F3136] border-b border-gray-700 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="relative">
                        <div class="h-10 w-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-medium">JD</div>
                        <div class="absolute bottom-0 right-0 h-3 w-3 rounded-full bg-green-500 border-2 border-[#2F3136]"></div>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-white">John Doe</h2>
                        <p class="text-sm text-green-400 flex items-center">
                            Online
                        </p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <button class="p-2 rounded-full hover:bg-[#40444B] transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </button>
                    <button class="p-2 rounded-full hover:bg-[#40444B] transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                    </button>
                    <button class="p-2 rounded-full hover:bg-[#40444B] transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Date Divider -->
            <div class="flex items-center justify-center my-4">
                <div class="border-t border-gray-700 flex-grow"></div>
                <span class="px-3 text-xs text-gray-500 font-medium">Today</span>
                <div class="border-t border-gray-700 flex-grow"></div>
            </div>
            
            <!-- Messages -->
            <div class="flex-1 p-4 overflow-y-auto space-y-4 bg-[#36393F] scrollbar-thin scrollbar-thumb-gray-700">
                <!-- System Message -->
                <div class="flex justify-center">
                    <div class="bg-[#2F3136] text-gray-400 rounded-lg px-4 py-2 text-xs">
                        <p>You started a conversation with John Doe</p>
                    </div>
                </div>
                
                <!-- Outgoing Message -->
                <div class="flex justify-end">
                    <div class="max-w-[70%]">
                        <div class="flex items-end justify-end space-x-2">
                            <div class="bg-blue-500 text-white rounded-lg px-4 py-2 shadow-md">
                                <p class="text-sm">Hello! How can I help you today?</p>
                                <div class="flex justify-between items-center mt-1">
                                    <div class="flex space-x-1">
                                        <button class="text-xs text-gray-300 opacity-0 group-hover:opacity-100 hover:text-white transition-opacity">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </button>
                                    </div>
                                    <span class="text-xs text-gray-300 block">10:30 AM</span>
                                </div>
                            </div>
                        </div>
                        <div class="text-right mt-1">
                            <span class="text-xs text-gray-500">Seen</span>
                        </div>
                    </div>
                </div>
                
                <!-- Incoming Message -->
                <div class="flex space-x-3">
                    <div class="flex-shrink-0">
                        <div class="h-8 w-8 rounded-full bg-blue-600 flex items-center justify-center text-white font-medium text-xs">JD</div>
                    </div>
                    <div class="max-w-[70%]">
                        <p class="text-xs text-gray-400 mb-1">John Doe</p>
                        <div class="bg-gray-700 text-white rounded-lg px-4 py-2 shadow-md group">
                            <p class="text-sm">Hi! I'm having some trouble with the project.</p>
                            <div class="flex justify-between items-center mt-1">
                                <div class="flex space-x-1">
                                    <button class="text-xs text-gray-300 opacity-0 group-hover:opacity-100 hover:text-white transition-opacity">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </button>
                                </div>
                                <span class="text-xs text-gray-300 block">10:35 AM</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Incoming Message with Attachment -->
                <div class="flex space-x-3">
                    <div class="flex-shrink-0">
                        <div class="h-8 w-8 rounded-full bg-blue-600 flex items-center justify-center text-white font-medium text-xs">JD</div>
                    </div>
                    <div class="max-w-[70%]">
                        <div class="bg-gray-700 text-white rounded-lg px-4 py-2 shadow-md group">
                            <p class="text-sm mb-2">I'm getting this error when I try to run the application:</p>
                            <div class="bg-[#2F3136] p-3 rounded-md text-xs font-mono text-gray-300 mb-2 overflow-x-auto">
                                <code>Error: Cannot find module 'react-dom' <br>
                                at Function.Module._resolveFilename (node:internal/modules/cjs/loader:933:15)</code>
                            </div>
                            <div class="flex justify-between items-center mt-1">
                                <div class="flex space-x-1">
                                    <button class="text-xs text-gray-300 opacity-0 group-hover:opacity-100 hover:text-white transition-opacity">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </button>
                                </div>
                                <span class="text-xs text-gray-300 block">10:36 AM</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Outgoing Message with Reactions -->
                <div class="flex justify-end">
                    <div class="max-w-[70%]">
                        <div class="bg-blue-500 text-white rounded-lg px-4 py-2 shadow-md group">
                            <p class="text-sm">It looks like you need to install the dependencies. Try running <code class="bg-blue-600 px-1 rounded">npm install</code> first.</p>
                            <div class="flex justify-between items-center mt-1">
                                <div class="flex space-x-1">
                                    <button class="text-xs text-gray-300 opacity-0 group-hover:opacity-100 hover:text-white transition-opacity">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </button>
                                </div>
                                <span class="text-xs text-gray-300 block">10:38 AM</span>
                            </div>
                        </div>
                        <div class="flex space-x-1 mt-1 justify-end">
                            <div class="bg-[#2F3136] text-xs px-2 py-1 rounded-full flex items-center">
                                <span>👍</span>
                                <span class="ml-1 text-gray-300">1</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Typing Indicator -->
                <div class="flex space-x-3">
                    <div class="flex-shrink-0">
                        <div class="h-8 w-8 rounded-full bg-blue-600 flex items-center justify-center text-white font-medium text-xs">JD</div>
                    </div>
                    <div class="bg-gray-700 text-white rounded-lg px-4 py-2 shadow-md">
                        <div class="flex space-x-1">
                            <div class="h-2 w-2 bg-gray-500 rounded-full animate-bounce"></div>
                            <div class="h-2 w-2 bg-gray-500 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                            <div class="h-2 w-2 bg-gray-500 rounded-full animate-bounce" style="animation-delay: 0.4s"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Message Input -->
            <div class="p-4 bg-[#40444B] border-t border-gray-700">
                <div class="flex items-center mb-2">
                    <button class="p-2 rounded-full hover:bg-[#36393F] transition-colors mr-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                        </svg>
                    </button>
                    <div class="flex-1 relative">
                        <textarea 
                            class="w-full rounded-lg border border-gray-600 bg-gray-700 text-white px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none min-h-[40px] max-h-[120px]" 
                            placeholder="Type your message..."
                            rows="1"
                        ></textarea>
                        <div class="absolute right-2 bottom-2 flex space-x-2">
                            <button class="p-1 rounded-full hover:bg-[#36393F] transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </button>
                            <button class="p-1 rounded-full hover:bg-[#36393F] transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <button class="p-2 rounded-full bg-blue-500 hover:bg-blue-600 transition-colors ml-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" transform="rotate(90 12 12)" />
                        </svg>
                    </button>
                </div>
                <div class="text-xs text-gray-400">
                    Press Enter to send, Shift+Enter for new line
                </div>
            </div>
        </div>
        
        <!-- Info Panel (can be toggled) -->
        <div class="hidden md:block w-64 bg-[#2F3136] text-white border-l border-gray-700">
            <div class="p-4 border-b border-gray-700">
                <h3 class="text-lg font-semibold">Details</h3>
            </div>
            <div class="p-4">
                <div class="flex flex-col items-center mb-4">
                    <div class="h-20 w-20 rounded-full bg-blue-600 flex items-center justify-center text-white text-2xl font-medium mb-2">JD</div>
                    <h4 class="text-lg font-medium">John Doe</h4>
                    <p class="text-sm text-gray-400">Software Developer</p>
                    <div class="flex items-center mt-2">
                        <span class="h-2 w-2 rounded-full bg-green-400 mr-2"></span>
                        <span class="text-sm text-green-400">Online</span>
                    </div>
                </div>
                
                <div class="mb-4">
                    <h5 class="text-sm font-medium text-gray-400 mb-2">Contact Info</h5>
                    <div class="flex items-center mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span class="text-sm text-gray-300">john.doe@example.com</span>
                    </div>
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <span class="text-sm text-gray-300">+1 (555) 123-4567</span>
                    </div>
                </div>
                
                <div class="mb-4">
                    <h5 class="text-sm font-medium text-gray-400 mb-2">Shared Files</h5>
                    <div class="space-y-2">
                        <div class="p-2 bg-[#36393F] rounded-md flex items-center">
                            <div class="h-8 w-8 bg-blue-500 rounded-md flex items-center justify-center mr-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-medium text-white truncate">project_requirements.pdf</p>
                                <p class="text-xs text-gray-400">2.4 MB • Yesterday</p>
                            </div>
                            <button class="p-1 rounded-full hover:bg-[#40444B]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                            </button>
                        </div>
                        
                        <div class="p-2 bg-[#36393F] rounded-md flex items-center">
                            <div class="h-8 w-8 bg-green-500 rounded-md flex items-center justify-center mr-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-medium text-white truncate">data_analysis.xlsx</p>
                                <p class="text-xs text-gray-400">1.8 MB • Last week</p>
                            </div>
                            <button class="p-1 rounded-full hover:bg-[#40444B]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                
                <div>
                    <h5 class="text-sm font-medium text-gray-400 mb-2">Actions</h5>
                    <div class="space-y-2">
                        <button class="w-full py-2 bg-[#36393F] hover:bg-[#40444B] rounded-md text-sm text-gray-300 transition-colors flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                            </svg>
                            Block User
                        </button>
                        <button class="w-full py-2 bg-[#36393F] hover:bg-[#40444B] rounded-md text-sm text-gray-300 transition-colors flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            Report Issue
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>

