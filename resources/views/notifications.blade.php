<x-layouts.app>
    <!-- <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl"> -->
    <div class="flex h-full w-full flex-1 flex-col gap-6 text-gray-100 p-6 border border-emerald-500 rounded-lg" id="app">
        <div class="mx-auto w-full max-w-7xl p-4 md:p-8">
            <!-- Flash Messages -->
            @if(session('success'))
                <div class="mb-4 rounded-lg bg-emerald-900/20 p-4 border border-emerald-600">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <p class="text-emerald-400">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- Header Section -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">{{ __('Notifications') }}</h1>
                </div>

                <!-- Mark All as Read Button -->
                <form action="{{ route('notifications.read-all') }}" method="POST" class="hidden md:block">
                    @csrf
                    <button type="submit" class="rounded-lg border border-emerald-600 bg-emerald-700/20 px-4 py-2 text-sm font-medium text-emerald-400 hover:bg-emerald-700/30 transition-colors">
                        Mark All as Read
                    </button>
                </form>

                <!-- Search and Filter Section -->
                <div class="flex flex-col md:flex-row items-center gap-4">
                    <!-- Search Input -->
                    <div class="relative w-full md:w-auto">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" placeholder="Search notifications..."
                            class="w-full md:min-w-[250px] rounded-lg border border-neutral-700 bg-neutral-800 pl-10 pr-4 py-2 text-sm text-white placeholder-neutral-400 focus:border-neutral-600 focus:outline-hidden transition-all duration-300 hover:border-neutral-600">
                    </div>

                    <!-- Filter Dropdowns -->
                    <div class="flex flex-col md:flex-row gap-2">
                        <!-- Status Filter -->
                        <form method="GET" action="{{ route('notifications') }}" class="flex flex-col md:flex-row gap-2">
                            <select name="status" class="w-full md:w-auto rounded-lg border border-neutral-700 bg-neutral-800 px-4 py-2 text-sm text-white focus:border-neutral-600 focus:outline-hidden transition-all duration-300 hover:border-neutral-600"
                                    onchange="this.form.submit()">
                                <option value="all" {{ request('status') == 'all' || !request('status') ? 'selected' : '' }}>All Status</option>
                                <option value="unread" {{ request('status') == 'unread' ? 'selected' : '' }}>Unread</option>
                                <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Read</option>
                            </select>

                            <!-- Type Filter -->
                            <select name="type" class="w-full md:w-auto rounded-lg border border-neutral-700 bg-neutral-800 px-4 py-2 text-sm text-white focus:border-neutral-600 focus:outline-hidden transition-all duration-300 hover:border-neutral-600"
                                    onchange="this.form.submit()">
                                <option value="all" {{ request('type') == 'all' || !request('type') ? 'selected' : '' }}>All Types</option>
                                @foreach($types as $type)
                                    <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                                @endforeach
                            </select>

                            <!-- Hidden inputs to preserve other query parameters -->
                            @foreach(request()->except(['status', 'type', 'page']) as $key => $value)
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endforeach
                        </form>
                    </div>
                </div>
            </div>

            <!-- Notifications List -->
            <div class="mt-8 space-y-4">
                @if($notifications->isEmpty())
                    <div class="rounded-xl border border-neutral-700 bg-neutral-800 p-6 text-center">
                        <p class="text-neutral-400">No notifications yet</p>
                    </div>
                @else
                    @foreach($notifications as $notification)
                    <div class="rounded-xl border {{ $notification->read ? 'border-neutral-700' : 'border-emerald-700' }} bg-neutral-800 p-6 transition-all duration-300 hover:shadow-lg hover:shadow-neutral-900/50 hover:border-neutral-600 hover:bg-neutral-800/90">
                        <div class="mb-4 flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <span class="h-2.5 w-2.5 rounded-full {{ $notification->read ? 'bg-neutral-500' : 'bg-emerald-500' }}"></span>
                                <div class="flex items-center gap-2">
                                    @if($notification->type === 'achievement')
                                        <div class="h-6 w-6 rounded-full bg-blue-500/20 border border-blue-500/30 flex items-center justify-center text-blue-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    @elseif($notification->type === 'challenge')
                                        <div class="h-6 w-6 rounded-full bg-orange-500/20 border border-orange-500/30 flex items-center justify-center text-orange-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    @elseif($notification->type === 'grade')
                                        <div class="h-6 w-6 rounded-full bg-purple-500/20 border border-purple-500/30 flex items-center justify-center text-purple-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm9.707 5.707a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    @else
                                        <div class="h-6 w-6 rounded-full bg-gray-500/20 border border-gray-500/30 flex items-center justify-center text-gray-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    @endif
                                    <span class="text-base font-medium text-white">{{ ucfirst($notification->type) }}</span>
                                </div>
                            </div>
                            <span class="text-sm text-neutral-400">{{ $notification->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="mb-4 text-sm text-neutral-300 leading-relaxed">{{ $notification->message }}</p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <span class="inline-flex items-center rounded-full border border-neutral-700 px-2.5 py-0.5 text-xs font-medium {{ $notification->read ? 'text-neutral-400' : 'text-emerald-400' }}">
                                    {{ $notification->read ? 'Read' : 'Unread' }}
                                </span>
                            </div>
                            <div class="flex gap-2">
                                @if(!$notification->read)
                                    <form action="{{ route('notifications.read', $notification->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center text-sm font-medium text-emerald-400 hover:text-emerald-300 transition-colors">
                                            Mark as read
                                            <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </button>
                                    </form>
                                @endif

                                @if($notification->link)
                                    <a href="{{ $notification->link }}" class="inline-flex items-center text-sm font-medium text-emerald-400 hover:text-emerald-300 transition-colors ml-2">
                                        View Details
                                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>

            <!-- Pagination -->
            <div class="mt-8 flex items-center justify-center">
                {{ $notifications->links() }}
            </div>


        </div>
    </div>
</x-layouts.app>