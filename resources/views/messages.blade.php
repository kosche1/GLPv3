<x-layouts.app>
    <div class="min-h-screen bg-[#36393F] flex">
        <!-- Sidebar -->
        <div class="w-64 bg-[#2F3136] text-white flex flex-col border-r border-gray-700">
            <div class="p-4 border-b border-gray-700">
                <h2 class="text-lg font-semibold">Messages</h2>
            </div>
            <div class="flex-1 overflow-y-auto">
                <!-- Conversation Item -->
                <div class="p-4 flex items-center space-x-3 hover:bg-[#40444B] cursor-pointer">
                    <div class="h-10 w-10 rounded-full bg-gray-600 flex items-center justify-center text-white font-medium">JD</div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium truncate">John Doe</p>
                        <p class="text-xs text-gray-400 truncate">Latest message preview...</p>
                    </div>
                </div>
                <!-- Another Conversation -->
                <div class="p-4 flex items-center space-x-3 hover:bg-[#40444B] cursor-pointer">
                    <div class="h-10 w-10 rounded-full bg-gray-600 flex items-center justify-center text-white font-medium">AS</div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium truncate">Alice Smith</p>
                        <p class="text-xs text-gray-400 truncate">How's everything going?</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main Chat Window -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <div class="p-4 bg-[#2F3136] border-b border-gray-700 flex items-center space-x-3">
                <div class="h-10 w-10 rounded-full bg-gray-600 flex items-center justify-center text-white font-medium">JD</div>
                <div>
                    <h2 class="text-lg font-semibold text-white">John Doe</h2>
                    <p class="text-sm text-gray-400">Online</p>
                </div>
            </div>
            
            <!-- Messages -->
            <div class="flex-1 p-3 overflow-y-auto space-y-4 bg-[#36393F]">
                <div class="flex justify-end">
                    <div class="bg-blue-500 text-white rounded-lg px-4 py-2 max-w-[70%] shadow-md">
                        <p class="text-sm">Hello! How can I help you today?</p>
                        <span class="text-xs text-gray-300 mt-1 block text-right">10:30 AM</span>
                    </div>
                </div>
                <div class="flex justify-start">
                    <div class="bg-gray-700 text-white rounded-lg px-4 py-2 max-w-[70%] shadow-md">
                        <p class="text-sm">Hi! I'm having some trouble with the project.</p>
                        <span class="text-xs text-gray-300 mt-1 block text-right">10:35 AM</span>
                    </div>
                </div>
            </div>
            
            <!-- Message Input -->
            <div class="p-4 bg-[#40444B] border-t border-gray-700">
                <form class="flex space-x-4">
                    <input type="text" class="flex-1 rounded-lg border border-gray-600 bg-gray-700 text-white px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Type your message...">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 focus:outline-none">Send</button>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>
