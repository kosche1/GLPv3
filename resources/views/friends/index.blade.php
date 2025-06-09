<x-layouts.app>
    <!-- Meta tags for real-time functionality -->
    <meta name="user-id" content="{{ auth()->id() }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="relative flex h-full w-full flex-1 flex-col gap-6 text-gray-100 p-6 border border-emerald-500 rounded-lg overflow-hidden backdrop-blur-sm">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6 relative">
            <div class="flex items-center gap-3">
                <div class="h-8 w-1 bg-gradient-to-b from-emerald-400 to-emerald-600 rounded-full"></div>
                <h1 class="text-2xl font-bold text-white tracking-tight">Friends Management</h1>
            </div>
            <div class="flex items-center gap-3">
                <!-- Add Friend Button -->
                <button onclick="openAddFriendModal()" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white rounded-lg transition-colors duration-200 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z" />
                    </svg>
                    Add Friend
                </button>

                <!-- Debug Button (remove in production) -->
                <button onclick="debugFriendStatus()" class="px-3 py-2 bg-gray-600 hover:bg-gray-500 text-white rounded-lg transition-colors duration-200 text-sm">
                    Debug Status
                </button>
            </div>
        </div>

        <!-- Friends Tabs -->
        <div x-data="{
            activeTab: 'online',
            onlineFriends: [],
            offlineFriends: [],
            allFriends: [],
            pendingRequests: { sent: [], received: [] },
            loading: false,
            
            init() {
                this.loadFriendsByStatus('online');
                this.loadPendingRequests();

                // Auto-refresh every 30 seconds
                setInterval(() => {
                    this.loadFriendsByStatus(this.activeTab);
                }, 30000);

                // Check for real-time messages every 5 seconds
                setInterval(() => {
                    this.checkRealTimeMessages();
                }, 5000);
            },
            
            switchTab(tab) {
                this.activeTab = tab;
                if (tab === 'pending') {
                    this.loadPendingRequests();
                } else {
                    this.loadFriendsByStatus(tab);
                }
            },
            
            async loadFriendsByStatus(status) {
                this.loading = true;
                try {
                    const response = await fetch(`/friends/by-status?status=${status}`);
                    const data = await response.json();
                    
                    if (status === 'online') {
                        this.onlineFriends = data.friends;
                    } else if (status === 'offline') {
                        this.offlineFriends = data.friends;
                    } else {
                        this.allFriends = data.friends;
                    }
                } catch (error) {
                    console.error('Error loading friends:', error);
                } finally {
                    this.loading = false;
                }
            },
            
            async loadPendingRequests() {
                this.loading = true;
                try {
                    const response = await fetch('/friends/pending');
                    const data = await response.json();
                    this.pendingRequests = {
                        sent: data.sent_requests,
                        received: data.received_requests
                    };
                } catch (error) {
                    console.error('Error loading pending requests:', error);
                } finally {
                    this.loading = false;
                }
            },

            async checkRealTimeMessages() {
                try {
                    const response = await fetch('/friends/messages');
                    const data = await response.json();

                    if (data.messages && data.messages.length > 0) {
                        data.messages.forEach(message => {
                            this.handleRealTimeMessage(message);
                        });
                    }
                } catch (error) {
                    console.error('Error checking real-time messages:', error);
                }
            },

            handleRealTimeMessage(message) {
                switch (message.event) {
                    case 'friend-status-update':
                        this.handleFriendStatusUpdate(message.data);
                        break;
                    case 'friend-request-received':
                        this.handleFriendRequestReceived(message.data);
                        break;
                    case 'friend-request-accepted':
                        this.handleFriendRequestAccepted(message.data);
                        break;
                }
            },

            handleFriendStatusUpdate(data) {
                // Refresh the current tab if it's online or all friends
                if (this.activeTab === 'online' || this.activeTab === 'all') {
                    this.loadFriendsByStatus(this.activeTab);
                }

                // Show notification
                showNotification(`${data.friend_name} is now ${data.status}`, 'info');
            },

            handleFriendRequestReceived(data) {
                // Refresh pending requests
                this.loadPendingRequests();

                // Show notification
                showNotification(`${data.sender_name} sent you a friend request`, 'info');
            },

            handleFriendRequestAccepted(data) {
                // Refresh pending requests and friends list
                this.loadPendingRequests();
                this.loadFriendsByStatus(this.activeTab);

                // Show notification
                showNotification(`${data.accepter_name} accepted your friend request`, 'success');
            }
        }" class="bg-neutral-800/50 backdrop-blur-sm rounded-2xl border border-neutral-700 shadow-xl overflow-hidden">
            
            <!-- Tab Navigation -->
            <div class="border-b border-neutral-700 bg-neutral-800/30">
                <nav class="flex space-x-8 px-6 py-4">
                    <button @click="switchTab('online')" 
                            :class="activeTab === 'online' ? 'border-emerald-500 text-emerald-400' : 'border-transparent text-gray-400 hover:text-gray-300'"
                            class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors duration-200 flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></div>
                        Online
                        <span x-show="onlineFriends.length > 0" x-text="onlineFriends.length" class="bg-emerald-500/20 text-emerald-400 text-xs rounded-full px-2 py-0.5"></span>
                    </button>
                    
                    <button @click="switchTab('offline')" 
                            :class="activeTab === 'offline' ? 'border-emerald-500 text-emerald-400' : 'border-transparent text-gray-400 hover:text-gray-300'"
                            class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors duration-200 flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-gray-400"></div>
                        Offline
                        <span x-show="offlineFriends.length > 0" x-text="offlineFriends.length" class="bg-gray-500/20 text-gray-400 text-xs rounded-full px-2 py-0.5"></span>
                    </button>
                    
                    <button @click="switchTab('all')" 
                            :class="activeTab === 'all' ? 'border-emerald-500 text-emerald-400' : 'border-transparent text-gray-400 hover:text-gray-300'"
                            class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors duration-200 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                        </svg>
                        All Friends
                        <span x-show="allFriends.length > 0" x-text="allFriends.length" class="bg-blue-500/20 text-blue-400 text-xs rounded-full px-2 py-0.5"></span>
                    </button>
                    
                    <button @click="switchTab('pending')" 
                            :class="activeTab === 'pending' ? 'border-emerald-500 text-emerald-400' : 'border-transparent text-gray-400 hover:text-gray-300'"
                            class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors duration-200 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                        </svg>
                        Pending
                        <span x-show="(pendingRequests.sent.length + pendingRequests.received.length) > 0" 
                              x-text="pendingRequests.sent.length + pendingRequests.received.length" 
                              class="bg-yellow-500/20 text-yellow-400 text-xs rounded-full px-2 py-0.5"></span>
                    </button>
                </nav>
            </div>

            <!-- Tab Content -->
            <div class="p-6">
                <!-- Loading State -->
                <div x-show="loading" class="text-center py-12">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-emerald-400 mx-auto mb-4"></div>
                    <p class="text-gray-400">Loading friends...</p>
                </div>

                <!-- Online Friends Tab -->
                <div x-show="activeTab === 'online' && !loading">
                    <div x-show="onlineFriends.length === 0" class="text-center py-12">
                        <div class="w-16 h-16 rounded-full bg-green-500/10 border border-green-500/20 flex items-center justify-center mx-auto mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-white mb-2">No friends online</h3>
                        <p class="text-gray-400">Your friends will appear here when they're active</p>
                    </div>
                    
                    <div x-show="onlineFriends.length > 0" class="space-y-3">
                        <template x-for="friend in onlineFriends" :key="friend.id">
                            <div class="flex items-center justify-between p-4 bg-neutral-700/20 rounded-lg border border-neutral-700/50 hover:bg-neutral-700/30 transition-colors cursor-pointer"
                                 @click="viewFriendProfile(friend.id)">
                                <div class="flex items-center gap-4">
                                    <div class="relative">
                                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-cyan-600 flex items-center justify-center text-sm font-bold text-white"
                                             x-text="friend.initials">
                                        </div>
                                        <div class="absolute -bottom-0.5 -right-0.5 w-4 h-4 rounded-full border-2 border-neutral-800 bg-green-400 animate-pulse"></div>
                                    </div>
                                    <div>
                                        <h4 class="text-white font-medium" x-text="friend.name"></h4>
                                        <p class="text-sm text-gray-400">Level <span x-text="friend.level"></span> • <span x-text="friend.points.toLocaleString()"></span> XP</p>
                                        <p class="text-xs text-green-400" x-text="friend.last_activity"></p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="flex items-center gap-2 text-green-400 text-sm">
                                        <div class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></div>
                                        Online
                                    </div>
                                    <p class="text-xs text-gray-500" x-text="friend.activity_time"></p>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Offline Friends Tab -->
                <div x-show="activeTab === 'offline' && !loading">
                    <div x-show="offlineFriends.length === 0" class="text-center py-12">
                        <div class="w-16 h-16 rounded-full bg-gray-500/10 border border-gray-500/20 flex items-center justify-center mx-auto mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-white mb-2">No offline friends</h3>
                        <p class="text-gray-400">Friends who haven't been active recently will appear here</p>
                    </div>

                    <div x-show="offlineFriends.length > 0" class="space-y-3">
                        <template x-for="friend in offlineFriends" :key="friend.id">
                            <div class="flex items-center justify-between p-4 bg-neutral-700/20 rounded-lg border border-neutral-700/50 hover:bg-neutral-700/30 transition-colors cursor-pointer"
                                 @click="viewFriendProfile(friend.id)">
                                <div class="flex items-center gap-4">
                                    <div class="relative">
                                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-gray-500 to-gray-600 flex items-center justify-center text-sm font-bold text-white"
                                             x-text="friend.initials">
                                        </div>
                                        <div class="absolute -bottom-0.5 -right-0.5 w-4 h-4 rounded-full border-2 border-neutral-800 bg-gray-400"></div>
                                    </div>
                                    <div>
                                        <h4 class="text-white font-medium" x-text="friend.name"></h4>
                                        <p class="text-sm text-gray-400">Level <span x-text="friend.level"></span> • <span x-text="friend.points.toLocaleString()"></span> XP</p>
                                        <p class="text-xs text-gray-500" x-text="friend.last_activity"></p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="flex items-center gap-2 text-gray-400 text-sm">
                                        <div class="w-2 h-2 rounded-full bg-gray-400"></div>
                                        Offline
                                    </div>
                                    <p class="text-xs text-gray-500" x-text="friend.activity_time"></p>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- All Friends Tab -->
                <div x-show="activeTab === 'all' && !loading">
                    <div x-show="allFriends.length === 0" class="text-center py-12">
                        <div class="w-16 h-16 rounded-full bg-blue-500/10 border border-blue-500/20 flex items-center justify-center mx-auto mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-white mb-2">No friends yet</h3>
                        <p class="text-gray-400">Start building your network by adding friends!</p>
                        <button onclick="openAddFriendModal()" class="mt-4 px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white rounded-lg transition-colors duration-200">
                            Add Your First Friend
                        </button>
                    </div>

                    <div x-show="allFriends.length > 0" class="space-y-3">
                        <template x-for="friend in allFriends" :key="friend.id">
                            <div class="flex items-center justify-between p-4 bg-neutral-700/20 rounded-lg border border-neutral-700/50 hover:bg-neutral-700/30 transition-colors cursor-pointer"
                                 @click="viewFriendProfile(friend.id)">
                                <div class="flex items-center gap-4">
                                    <div class="relative">
                                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-cyan-600 flex items-center justify-center text-sm font-bold text-white"
                                             x-text="friend.initials">
                                        </div>
                                        <div class="absolute -bottom-0.5 -right-0.5 w-4 h-4 rounded-full border-2 border-neutral-800"
                                             :class="{
                                                'bg-green-400 animate-pulse': friend.status === 'online',
                                                'bg-yellow-400': friend.status === 'active',
                                                'bg-gray-400': friend.status === 'away'
                                             }">
                                        </div>
                                    </div>
                                    <div>
                                        <h4 class="text-white font-medium" x-text="friend.name"></h4>
                                        <p class="text-sm text-gray-400">Level <span x-text="friend.level"></span> • <span x-text="friend.points.toLocaleString()"></span> XP</p>
                                        <p class="text-xs"
                                           :class="{
                                               'text-green-400': friend.status === 'online',
                                               'text-yellow-400': friend.status === 'active',
                                               'text-gray-500': friend.status === 'away'
                                           }"
                                           x-text="friend.last_activity">
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="flex items-center gap-2 text-sm"
                                         :class="{
                                             'text-green-400': friend.status === 'online',
                                             'text-yellow-400': friend.status === 'active',
                                             'text-gray-400': friend.status === 'away'
                                         }">
                                        <div class="w-2 h-2 rounded-full"
                                             :class="{
                                                 'bg-green-400 animate-pulse': friend.status === 'online',
                                                 'bg-yellow-400': friend.status === 'active',
                                                 'bg-gray-400': friend.status === 'away'
                                             }">
                                        </div>
                                        <span x-text="friend.status === 'online' ? 'Online' : friend.status === 'active' ? 'Active' : 'Offline'"></span>
                                    </div>
                                    <p class="text-xs text-gray-500" x-text="friend.activity_time"></p>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Pending Requests Tab -->
                <div x-show="activeTab === 'pending' && !loading">
                    <div x-show="pendingRequests.sent.length === 0 && pendingRequests.received.length === 0" class="text-center py-12">
                        <div class="w-16 h-16 rounded-full bg-yellow-500/10 border border-yellow-500/20 flex items-center justify-center mx-auto mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-white mb-2">No pending requests</h3>
                        <p class="text-gray-400">Friend requests you send or receive will appear here</p>
                    </div>

                    <!-- Received Requests -->
                    <div x-show="pendingRequests.received.length > 0" class="mb-6">
                        <h4 class="text-white font-medium mb-3 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Received Requests
                            <span x-text="pendingRequests.received.length" class="bg-green-500/20 text-green-400 text-xs rounded-full px-2 py-0.5"></span>
                        </h4>
                        <div class="space-y-3">
                            <template x-for="request in pendingRequests.received" :key="request.id">
                                <div class="flex items-center justify-between p-4 bg-neutral-700/20 rounded-lg border border-neutral-700/50">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center text-sm font-bold text-white"
                                             x-text="request.initials">
                                        </div>
                                        <div>
                                            <h4 class="text-white font-medium" x-text="request.name"></h4>
                                            <p class="text-sm text-gray-400">Level <span x-text="request.level"></span> • <span x-text="request.points.toLocaleString()"></span> XP</p>
                                            <p class="text-xs text-gray-500" x-text="request.created_at"></p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <button @click="acceptFriendRequest(request.id)" class="px-3 py-1.5 bg-green-600 hover:bg-green-500 text-white text-sm rounded-lg transition-colors duration-200">
                                            Accept
                                        </button>
                                        <button @click="declineFriendRequest(request.id)" class="px-3 py-1.5 bg-red-600 hover:bg-red-500 text-white text-sm rounded-lg transition-colors duration-200">
                                            Decline
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Sent Requests -->
                    <div x-show="pendingRequests.sent.length > 0">
                        <h4 class="text-white font-medium mb-3 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.293l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z" clip-rule="evenodd" />
                            </svg>
                            Sent Requests
                            <span x-text="pendingRequests.sent.length" class="bg-blue-500/20 text-blue-400 text-xs rounded-full px-2 py-0.5"></span>
                        </h4>
                        <div class="space-y-3">
                            <template x-for="request in pendingRequests.sent" :key="request.id">
                                <div class="flex items-center justify-between p-4 bg-neutral-700/20 rounded-lg border border-neutral-700/50">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-cyan-600 flex items-center justify-center text-sm font-bold text-white"
                                             x-text="request.initials">
                                        </div>
                                        <div>
                                            <h4 class="text-white font-medium" x-text="request.name"></h4>
                                            <p class="text-sm text-gray-400">Level <span x-text="request.level"></span> • <span x-text="request.points.toLocaleString()"></span> XP</p>
                                            <p class="text-xs text-gray-500" x-text="request.created_at"></p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm text-yellow-400 bg-yellow-500/10 px-3 py-1.5 rounded-lg">Pending</span>
                                        <button @click="cancelFriendRequest(request.id)" class="px-3 py-1.5 bg-gray-600 hover:bg-gray-500 text-white text-sm rounded-lg transition-colors duration-200">
                                            Cancel
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Friend Modal -->
    <div id="addFriendModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
        <div class="bg-neutral-800 rounded-2xl border border-neutral-700 shadow-xl max-w-md w-full max-h-[80vh] overflow-hidden">
            <div class="p-6 border-b border-neutral-700">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-bold text-white">Add Friend</h3>
                    <button onclick="closeAddFriendModal()" class="text-gray-400 hover:text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="p-6">
                <div class="mb-4">
                    <input type="text" id="friendSearchInput" placeholder="Search by name or email..."
                           class="w-full px-4 py-2 bg-neutral-700 border border-neutral-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-emerald-500"
                           oninput="searchUsers(this.value)">
                </div>
                <div id="searchResults" class="space-y-2 max-h-60 overflow-y-auto">
                    <p class="text-gray-400 text-center py-4">Start typing to search for friends...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Friend Profile Modal -->
    <div id="friendProfileModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
        <div class="bg-neutral-800 rounded-2xl border border-neutral-700 shadow-xl max-w-lg w-full max-h-[80vh] overflow-hidden">
            <div class="p-6 border-b border-neutral-700">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-bold text-white">Friend Profile</h3>
                    <button onclick="closeFriendProfileModal()" class="text-gray-400 hover:text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            <div id="friendProfileContent" class="p-6">
                <!-- Profile content will be loaded here -->
            </div>
        </div>
    </div>

    <!-- JavaScript for Friends Management -->
    <script>
        let searchTimeout;

        function openAddFriendModal() {
            document.getElementById('addFriendModal').classList.remove('hidden');
            document.getElementById('friendSearchInput').focus();
        }

        function closeAddFriendModal() {
            document.getElementById('addFriendModal').classList.add('hidden');
            document.getElementById('friendSearchInput').value = '';
            resetSearchResults();
        }

        function closeFriendProfileModal() {
            document.getElementById('friendProfileModal').classList.add('hidden');
        }

        function resetSearchResults() {
            document.getElementById('searchResults').innerHTML = '<p class="text-gray-400 text-center py-4">Start typing to search for friends...</p>';
        }

        function searchUsers(query) {
            clearTimeout(searchTimeout);

            if (query.length < 2) {
                resetSearchResults();
                return;
            }

            searchTimeout = setTimeout(() => {
                document.getElementById('searchResults').innerHTML = `
                    <div class="text-center py-4">
                        <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-emerald-400 mx-auto mb-2"></div>
                        <p class="text-gray-400">Searching...</p>
                    </div>
                `;

                fetch(`/friends/search?query=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        displaySearchResults(data.users);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        document.getElementById('searchResults').innerHTML = '<p class="text-red-400 text-center py-4">Error searching for users</p>';
                    });
            }, 300);
        }

        function displaySearchResults(users) {
            const container = document.getElementById('searchResults');

            if (users.length === 0) {
                container.innerHTML = '<p class="text-gray-400 text-center py-4">No users found</p>';
                return;
            }

            container.innerHTML = users.map(user => `
                <div class="flex items-center justify-between p-3 bg-neutral-700/20 rounded-lg border border-neutral-700/50 hover:bg-neutral-700/30 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-cyan-600 flex items-center justify-center text-sm font-bold text-white">
                            ${user.initials}
                        </div>
                        <div>
                            <p class="text-white font-medium">${user.name}</p>
                            <p class="text-xs text-gray-400">Level ${user.level} • ${user.points.toLocaleString()} XP</p>
                        </div>
                    </div>
                    <div>
                        ${user.is_friend ?
                            '<span class="text-green-400 text-sm">Friends</span>' :
                            user.request_sent ?
                                '<span class="text-yellow-400 text-sm">Pending</span>' :
                                user.request_received ?
                                    '<button onclick="acceptFriendRequest(' + user.id + ')" class="px-3 py-1 bg-green-600 hover:bg-green-500 text-white text-sm rounded transition-colors">Accept</button>' :
                                    '<button onclick="sendFriendRequest(' + user.id + ')" class="px-3 py-1 bg-emerald-600 hover:bg-emerald-500 text-white text-sm rounded transition-colors">Add</button>'
                        }
                    </div>
                </div>
            `).join('');
        }

        function sendFriendRequest(userId) {
            fetch('/friends/send-request', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ user_id: userId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                    // Refresh search results
                    const query = document.getElementById('friendSearchInput').value;
                    if (query.length >= 2) {
                        searchUsers(query);
                    }
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error sending friend request', 'error');
            });
        }

        function acceptFriendRequest(userId) {
            fetch('/friends/accept-request', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ user_id: userId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                    // Refresh current tab
                    location.reload();
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error accepting friend request', 'error');
            });
        }

        function declineFriendRequest(userId) {
            fetch('/friends/decline-request', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ user_id: userId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                    location.reload();
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error declining friend request', 'error');
            });
        }

        function cancelFriendRequest(userId) {
            fetch('/friends/cancel-request', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ user_id: userId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                    location.reload();
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error canceling friend request', 'error');
            });
        }

        function viewFriendProfile(userId) {
            fetch(`/friends/profile/${userId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        displayFriendProfile(data.friend);
                        document.getElementById('friendProfileModal').classList.remove('hidden');
                    } else {
                        showNotification(data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Error loading friend profile', 'error');
                });
        }

        function displayFriendProfile(friend) {
            document.getElementById('friendProfileContent').innerHTML = `
                <div class="text-center mb-6">
                    <div class="w-20 h-20 rounded-full bg-gradient-to-br from-blue-500 to-cyan-600 flex items-center justify-center text-xl font-bold text-white mx-auto mb-3">
                        ${friend.initials}
                    </div>
                    <h4 class="text-xl font-bold text-white">${friend.name}</h4>
                    <p class="text-gray-400">Level ${friend.level}</p>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="bg-neutral-700/20 rounded-lg p-4 text-center">
                        <p class="text-2xl font-bold text-emerald-400">${friend.points.toLocaleString()}</p>
                        <p class="text-sm text-gray-400">Experience Points</p>
                    </div>
                    <div class="bg-neutral-700/20 rounded-lg p-4 text-center">
                        <p class="text-2xl font-bold text-blue-400">${friend.level}</p>
                        <p class="text-sm text-gray-400">Current Level</p>
                    </div>
                </div>

                ${friend.bio ? `
                    <div class="mb-6">
                        <h5 class="text-white font-medium mb-2">About</h5>
                        <p class="text-gray-300 text-sm">${friend.bio}</p>
                    </div>
                ` : ''}

                ${friend.skills && friend.skills.length > 0 ? `
                    <div class="mb-6">
                        <h5 class="text-white font-medium mb-2">Skills</h5>
                        <div class="flex flex-wrap gap-2">
                            ${friend.skills.map(skill => `
                                <span class="px-2 py-1 bg-emerald-500/20 text-emerald-400 text-xs rounded-full">${skill}</span>
                            `).join('')}
                        </div>
                    </div>
                ` : ''}

                <div class="flex gap-3">
                    <button onclick="removeFriend(${friend.id})" class="flex-1 px-4 py-2 bg-red-600 hover:bg-red-500 text-white rounded-lg transition-colors duration-200">
                        Remove Friend
                    </button>
                    <button onclick="closeFriendProfileModal()" class="flex-1 px-4 py-2 bg-gray-600 hover:bg-gray-500 text-white rounded-lg transition-colors duration-200">
                        Close
                    </button>
                </div>
            `;
        }

        function removeFriend(userId) {
            if (!confirm('Are you sure you want to remove this friend?')) {
                return;
            }

            fetch('/friends/remove-friend', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ user_id: userId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                    closeFriendProfileModal();
                    location.reload();
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error removing friend', 'error');
            });
        }

        // Simple notification function (you can replace this with your existing notification system)
        function showNotification(message, type = 'info') {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg transition-all duration-300 transform translate-x-full ${
                type === 'success' ? 'bg-green-600 text-white' :
                type === 'error' ? 'bg-red-600 text-white' :
                'bg-blue-600 text-white'
            }`;
            notification.textContent = message;

            document.body.appendChild(notification);

            // Animate in
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
            }, 100);

            // Remove after 3 seconds
            setTimeout(() => {
                notification.classList.add('translate-x-full');
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 3000);
        }

        // Debug function to check friend status
        function debugFriendStatus() {
            fetch('/friends/debug-status')
                .then(response => response.json())
                .then(data => {
                    console.log('Debug Friend Status:', data);

                    // Show a summary in an alert
                    let summary = `Current User: ${data.current_user.name}\n`;
                    summary += `Last Activity: ${data.current_user.last_activity_human || 'Never'}\n\n`;
                    summary += `Friends (${data.debug_info.length}):\n`;

                    data.debug_info.forEach(friend => {
                        summary += `- ${friend.name}: ${friend.calculated_status} (${friend.minutes_ago || 'null'} min ago)\n`;
                    });

                    alert(summary);
                })
                .catch(error => {
                    console.error('Debug error:', error);
                    alert('Error loading debug info');
                });
        }
    </script>
</x-layouts.app>
