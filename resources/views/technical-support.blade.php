<x-layouts.app>
    <div class="flex h-full w-full flex-1 flex-col gap-6 text-gray-100 p-6 border border-emerald-500/30 rounded-lg bg-linear-to-b from-neutral-900 to-neutral-800">

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 px-4 py-3 rounded-lg mb-6">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-500/10 border border-red-500/30 text-red-400 px-4 py-3 rounded-lg mb-6">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    {{ session('error') }}
                </div>
            </div>
        @endif
        <div class="max-w-7xl mx-auto w-full">
            <!-- Enhanced Header Section with Animated Gradient -->
            <div class="text-center mb-12 relative">
                <div class="absolute inset-0 bg-linear-to-r from-blue-500/10 via-purple-500/10 to-emerald-500/10 rounded-xl blur-xl opacity-50"></div>
                <div class="relative">
                    <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Technical Support</h1>
                    <p class="text-lg text-zinc-300 max-w-3xl mx-auto">Get expert help with your technical issues and questions</p>
                </div>
            </div>

            <!-- Enhanced Search Bar with Suggested Searches -->
            <div class="mb-10">
                <div class="max-w-2xl mx-auto relative">
                    <input type="text" id="searchInput" placeholder="Describe your technical issue..." class="w-full px-4 py-3 pl-12 rounded-lg bg-neutral-800/80 border border-neutral-700 focus:outline-hidden focus:ring-2 focus:ring-emerald-500/50 text-white hover:border-neutral-600 transition-all duration-300" aria-label="Search for help">
                    <div class="absolute left-3 top-3">
                        <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <button class="absolute right-3 top-2 px-3 py-1 bg-emerald-500/20 text-emerald-400 rounded-md text-sm border border-emerald-500/30 hover:bg-emerald-500/30 transition-colors">
                        Search
                    </button>

                    <!-- Auto-suggestions with Enhanced Design -->
                    <div id="suggestions" class="hidden bg-neutral-800 border border-neutral-700 shadow-lg rounded-lg mt-2 absolute w-full z-10 overflow-hidden">
                        <!-- Suggestions will appear here dynamically -->
                    </div>

                    <!-- Suggested Searches -->
                    <div class="mt-3 flex flex-wrap gap-2 justify-center">
                        <span class="text-xs text-neutral-400">Popular searches:</span>
                        <a href="#" class="text-xs px-3 py-1 rounded-full bg-neutral-800 border border-neutral-700 text-neutral-300 hover:bg-neutral-700 transition-colors">login issues</a>
                        <a href="#" class="text-xs px-3 py-1 rounded-full bg-neutral-800 border border-neutral-700 text-neutral-300 hover:bg-neutral-700 transition-colors">video playback</a>
                        <a href="#" class="text-xs px-3 py-1 rounded-full bg-neutral-800 border border-neutral-700 text-neutral-300 hover:bg-neutral-700 transition-colors">payment error</a>
                        <a href="#" class="text-xs px-3 py-1 rounded-full bg-neutral-800 border border-neutral-700 text-neutral-300 hover:bg-neutral-700 transition-colors">mobile app</a>
                    </div>
                </div>
            </div>

            <!-- Support Options Section -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-white mb-6 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    Support Options
                </h2>

                <!-- Enhanced Quick Help Categories -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="p-6 rounded-xl border border-neutral-700 bg-linear-to-br from-neutral-800 to-neutral-900 transition-all duration-300 ease-in-out hover:scale-[1.02] hover:shadow-lg hover:shadow-emerald-900/20 hover:border-emerald-500/30">
                        <div class="p-3 rounded-lg bg-blue-500/10 border border-blue-500/20 inline-block mb-4">
                            <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-white mb-2">Getting Started</h3>
                        <p class="text-zinc-400 mb-4">New to the platform? Learn the basics and get started quickly.</p>
                        <a href="#" class="text-blue-400 hover:text-blue-300 transition-colors text-sm flex items-center">
                            <span>View guides</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>

                    <div class="p-6 rounded-xl border border-neutral-700 bg-linear-to-br from-neutral-800 to-neutral-900 transition-all duration-300 ease-in-out hover:scale-[1.02] hover:shadow-lg hover:shadow-emerald-900/20 hover:border-emerald-500/30">
                        <div class="p-3 rounded-lg bg-purple-500/10 border border-purple-500/20 inline-block mb-4">
                            <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-white mb-2">Common Issues</h3>
                        <p class="text-zinc-400 mb-4">Find solutions to frequently reported problems and issues.</p>
                        <a href="#" class="text-purple-400 hover:text-purple-300 transition-colors text-sm flex items-center">
                            <span>Browse solutions</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>

                    <div class="p-6 rounded-xl border border-neutral-700 bg-linear-to-br from-neutral-800 to-neutral-900 transition-all duration-300 ease-in-out hover:scale-[1.02] hover:shadow-lg hover:shadow-emerald-900/20 hover:border-emerald-500/30">
                        <div class="p-3 rounded-lg bg-emerald-500/10 border border-emerald-500/20 inline-block mb-4">
                            <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-white mb-2">Quick Solutions</h3>
                        <p class="text-zinc-400 mb-4">Get instant fixes for common technical problems.</p>
                        <a href="#" class="text-emerald-400 hover:text-emerald-300 transition-colors text-sm flex items-center">
                            <span>View quick fixes</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Ticket Status Tracker -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-white mb-6 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Your Support Tickets
                </h2>

                <div class="rounded-xl border border-neutral-700 bg-linear-to-br from-neutral-800 to-neutral-900 p-6 mb-8">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                        <h3 class="text-lg font-semibold text-white">Recent Tickets</h3>
                        <div class="mt-3 md:mt-0">
                            <select class="px-3 py-2 rounded-lg bg-neutral-800 border border-neutral-700 text-white focus:outline-hidden focus:ring-2 focus:ring-emerald-500/50 text-sm">
                                <option>All Tickets</option>
                                <option>Open</option>
                                <option>In Progress</option>
                                <option>Resolved</option>
                            </select>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-b border-neutral-700 text-sm">
                                    <th class="px-4 py-3 text-left font-medium text-neutral-400">Ticket ID</th>
                                    <th class="px-4 py-3 text-left font-medium text-neutral-400">Subject</th>
                                    <th class="px-4 py-3 text-left font-medium text-neutral-400">Status</th>
                                    <th class="px-4 py-3 text-left font-medium text-neutral-400">Last Updated</th>
                                    <th class="px-4 py-3 text-left font-medium text-neutral-400">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-neutral-700">
                                @php
                                    $userTickets = \App\Models\SupportTicket::where('user_id', auth()->id())
                                        ->orderBy('created_at', 'desc')
                                        ->limit(5)
                                        ->get();
                                @endphp

                                @forelse($userTickets as $ticket)
                                    <tr class="text-sm hover:bg-neutral-700/30 transition-colors">
                                        <td class="px-4 py-3 text-white">#{{ $ticket->ticket_number }}</td>
                                        <td class="px-4 py-3 text-white">{{ Str::limit($ticket->subject, 40) }}</td>
                                        <td class="px-4 py-3">
                                            @php
                                                $statusColors = [
                                                    'open' => 'bg-blue-500/10 border-blue-500/20 text-blue-400',
                                                    'in_progress' => 'bg-amber-500/10 border-amber-500/20 text-amber-400',
                                                    'resolved' => 'bg-emerald-500/10 border-emerald-500/20 text-emerald-400',
                                                    'closed' => 'bg-gray-500/10 border-gray-500/20 text-gray-400',
                                                ];
                                            @endphp
                                            <span class="inline-flex rounded-full {{ $statusColors[$ticket->status] ?? $statusColors['open'] }} px-2.5 py-0.5 text-xs font-medium">
                                                {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-neutral-400">{{ $ticket->updated_at->diffForHumans() }}</td>
                                        <td class="px-4 py-3">
                                            <a href="{{ route('support-tickets.show', $ticket) }}" class="text-emerald-400 hover:text-emerald-300 transition-colors">View</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-8 text-center text-neutral-400">
                                            <div class="flex flex-col items-center">
                                                <svg class="w-12 h-12 mb-4 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                <p class="text-lg font-medium mb-2">No support tickets yet</p>
                                                <p class="text-sm">Create your first support ticket below to get help with any issues.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($userTickets->count() > 0)
                        <div class="mt-4 text-center">
                            <a href="{{ route('support-tickets.index') }}" class="text-emerald-400 hover:text-emerald-300 transition-colors text-sm">
                                View all tickets →
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Enhanced Support Ticket Form -->
            <div class="max-w-3xl mx-auto rounded-xl border border-neutral-700 bg-linear-to-br from-neutral-800 to-neutral-900 p-8 mb-12 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl -mr-32 -mt-32 pointer-events-none"></div>
                <div class="relative z-10">
                    <h2 class="text-2xl font-bold text-white mb-6 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                        </svg>
                        Create Support Ticket
                    </h2>
                    <form id="ticketForm" action="{{ route('support-tickets.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="subject" class="block text-sm font-medium text-zinc-300 mb-2">Subject</label>
                                <input type="text" id="subject" name="subject" value="{{ old('subject') }}" class="w-full px-4 py-2 rounded-lg bg-neutral-800 border border-neutral-700 focus:outline-hidden focus:ring-2 focus:ring-emerald-500/50 text-white hover:border-neutral-600 transition-all duration-300" required>
                                @error('subject')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="category" class="block text-sm font-medium text-zinc-300 mb-2">Category</label>
                                <select id="category" name="category" class="w-full px-4 py-2 rounded-lg bg-neutral-800 border border-neutral-700 focus:outline-hidden focus:ring-2 focus:ring-emerald-500/50 text-white hover:border-neutral-600 transition-all duration-300" required>
                                    <option value="">Select a category</option>
                                    <option value="technical_issue" {{ old('category') == 'technical_issue' ? 'selected' : '' }}>Technical Issue</option>
                                    <option value="account_problem" {{ old('category') == 'account_problem' ? 'selected' : '' }}>Account Problem</option>
                                    <option value="billing_question" {{ old('category') == 'billing_question' ? 'selected' : '' }}>Billing Question</option>
                                    <option value="course_access" {{ old('category') == 'course_access' ? 'selected' : '' }}>Course Access</option>
                                    <option value="feature_request" {{ old('category') == 'feature_request' ? 'selected' : '' }}>Feature Request</option>
                                    <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('category')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="priority" class="block text-sm font-medium text-zinc-300 mb-2">Priority</label>
                            <div class="flex space-x-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="priority" value="low" class="text-emerald-500 focus:ring-emerald-500/50" {{ old('priority', 'medium') == 'low' ? 'checked' : '' }}>
                                    <span class="ml-2 text-zinc-300">Low</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="priority" value="medium" class="text-emerald-500 focus:ring-emerald-500/50" {{ old('priority', 'medium') == 'medium' ? 'checked' : '' }}>
                                    <span class="ml-2 text-zinc-300">Medium</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="priority" value="high" class="text-emerald-500 focus:ring-emerald-500/50" {{ old('priority', 'medium') == 'high' ? 'checked' : '' }}>
                                    <span class="ml-2 text-zinc-300">High</span>
                                </label>
                            </div>
                            @error('priority')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-zinc-300 mb-2">Description</label>
                            <textarea rows="4" id="description" name="description" class="w-full px-4 py-2 rounded-lg bg-neutral-800 border border-neutral-700 focus:outline-hidden focus:ring-2 focus:ring-emerald-500/50 text-white hover:border-neutral-600 transition-all duration-300" required placeholder="Please describe your issue in detail...">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-zinc-300 mb-2">Attachments</label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-neutral-700 border-dashed rounded-lg hover:border-neutral-600 transition-colors">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-neutral-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-neutral-400">
                                        <label for="file-upload" class="relative cursor-pointer rounded-md font-medium text-emerald-400 hover:text-emerald-300 focus-within:outline-hidden">
                                            <span>Upload files</span>
                                            <input id="file-upload" name="attachments[]" type="file" class="sr-only" multiple accept=".png,.jpg,.jpeg,.gif,.pdf,.doc,.docx">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-neutral-400">
                                        PNG, JPG, GIF, PDF up to 10MB
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <input id="notify" name="notify_on_update" type="checkbox" value="1" class="h-4 w-4 text-emerald-500 focus:ring-emerald-500/50 border-neutral-700 rounded-sm" {{ old('notify_on_update') ? 'checked' : '' }}>
                            <label for="notify" class="ml-2 block text-sm text-zinc-300">
                                Notify me when my ticket is updated
                            </label>
                        </div>

                        <div>
                            <button type="submit" class="w-full px-6 py-3 bg-linear-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white font-medium rounded-lg transition duration-200 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                </svg>
                                Submit Ticket
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- FAQ Section -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-white mb-6 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Frequently Asked Technical Questions
                </h2>

                <div class="space-y-4">
                    <!-- FAQ Item 1 -->
                    <div class="border border-neutral-700 rounded-lg overflow-hidden">
                        <button class="w-full flex justify-between items-center p-4 bg-neutral-800 hover:bg-neutral-700 transition-colors text-left" onclick="toggleFaq('faq1')">
                            <span class="font-medium text-white">Why is my video not playing correctly?</span>
                            <svg id="faq1-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400 transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div id="faq1" class="hidden p-4 bg-neutral-800/50 border-t border-neutral-700">
                            <p class="text-zinc-300 text-sm">
                                If your video isn't playing correctly, try these steps:
                            </p>
                            <ul class="list-disc pl-5 mt-2 text-zinc-300 text-sm space-y-1">
                                <li>Check your internet connection</li>
                                <li>Clear your browser cache and cookies</li>
                                <li>Try a different browser</li>
                                <li>Disable any ad-blockers or extensions</li>
                                <li>Update your browser to the latest version</li>
                            </ul>
                            <p class="text-zinc-300 text-sm mt-2">
                                If the issue persists, please submit a support ticket with details about your device and browser.
                            </p>
                        </div>
                    </div>

                    <!-- FAQ Item 2 -->
                    <div class="border border-neutral-700 rounded-lg overflow-hidden">
                        <button class="w-full flex justify-between items-center p-4 bg-neutral-800 hover:bg-neutral-700 transition-colors text-left" onclick="toggleFaq('faq2')">
                            <span class="font-medium text-white">How do I reset my password?</span>
                            <svg id="faq2-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400 transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div id="faq2" class="hidden p-4 bg-neutral-800/50 border-t border-neutral-700">
                            <p class="text-zinc-300 text-sm">
                                To reset your password:
                            </p>
                            <ol class="list-decimal pl-5 mt-2 text-zinc-300 text-sm space-y-1">
                                <li>Click on the "Forgot Password" link on the login page</li>
                                <li>Enter the email address associated with your account</li>
                                <li>Check your email for a password reset link</li>
                                <li>Click the link and follow the instructions to create a new password</li>
                            </ol>
                            <p class="text-zinc-300 text-sm mt-2">
                                If you don't receive the email, check your spam folder or try again after a few minutes.
                            </p>
                        </div>
                    </div>

                    <!-- FAQ Item 3 -->
                    <div class="border border-neutral-700 rounded-lg overflow-hidden">
                        <button class="w-full flex justify-between items-center p-4 bg-neutral-800 hover:bg-neutral-700 transition-colors text-left" onclick="toggleFaq('faq3')">
                            <span class="font-medium text-white">Why am I having trouble accessing my course?</span>
                            <svg id="faq3-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400 transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div id="faq3" class="hidden p-4 bg-neutral-800/50 border-t border-neutral-700">
                            <p class="text-zinc-300 text-sm">
                                If you're having trouble accessing your course, it could be due to:
                            </p>
                            <ul class="list-disc pl-5 mt-2 text-zinc-300 text-sm space-y-1">
                                <li>Enrollment issues - check if your payment was processed successfully</li>
                                <li>Course availability - some courses have specific start and end dates</li>
                                <li>Browser compatibility - try using Chrome, Firefox, or Safari</li>
                                <li>Account permissions - ensure your account has the correct access level</li>
                            </ul>
                            <p class="text-zinc-300 text-sm mt-2">
                                If you've verified these issues and still can't access your course, please contact support with your order number and course name.
                            </p>
                        </div>
                    </div>

                    <!-- FAQ Item 4 -->
                    <div class="border border-neutral-700 rounded-lg overflow-hidden">
                        <button class="w-full flex justify-between items-center p-4 bg-neutral-800 hover:bg-neutral-700 transition-colors text-left" onclick="toggleFaq('faq4')">
                            <span class="font-medium text-white">How do I download course materials for offline viewing?</span>
                            <svg id="faq4-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400 transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div id="faq4" class="hidden p-4 bg-neutral-800/50 border-t border-neutral-700">
                            <p class="text-zinc-300 text-sm">
                                To download course materials for offline viewing:
                            </p>
                            <ol class="list-decimal pl-5 mt-2 text-zinc-300 text-sm space-y-1">
                                <li>Navigate to your course page</li>
                                <li>Look for the "Resources" or "Materials" section</li>
                                <li>Click on the download icon next to each resource</li>
                                <li>For videos, use the "Download for Offline" button when available</li>
                            </ol>
                            <p class="text-zinc-300 text-sm mt-2">
                                Note that not all materials may be available for download due to copyright restrictions.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Options -->
            <div class="rounded-xl border border-neutral-700 bg-linear-to-br from-neutral-800 to-neutral-900 p-8 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl -mr-32 -mt-32 pointer-events-none"></div>
                <div class="relative z-10">
                    <div class="text-center mb-8">
                        <h2 class="text-2xl font-bold text-white mb-4">Need Immediate Help?</h2>
                        <p class="text-zinc-400 max-w-2xl mx-auto">Our technical support team is available to assist you with any urgent issues</p>
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
                            <span class="text-emerald-400 text-sm">techsupport@example.com</span>
                        </a>

                        <a href="#" class="p-5 rounded-xl border border-neutral-700 bg-neutral-800/50 hover:bg-neutral-800 transition-all duration-300 flex flex-col items-center text-center group">
                            <div class="p-3 rounded-full bg-blue-500/10 border border-blue-500/20 mb-4 group-hover:bg-blue-500/20 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-white mb-2">Live Chat</h3>
                            <p class="text-zinc-400 text-sm mb-3">Chat with our technical support team in real-time</p>
                            <span class="text-blue-400 text-sm">Available 24/7</span>
                        </a>

                        <a href="#" class="p-5 rounded-xl border border-neutral-700 bg-neutral-800/50 hover:bg-neutral-800 transition-all duration-300 flex flex-col items-center text-center group">
                            <div class="p-3 rounded-full bg-purple-500/10 border border-purple-500/20 mb-4 group-hover:bg-purple-500/20 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-white mb-2">Phone Support</h3>
                            <p class="text-zinc-400 text-sm mb-3">Call us for immediate technical assistance</p>
                            <span class="text-purple-400 text-sm">+1 (555) 123-4567</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Enhanced Toast Notification -->
            <div id="toast" class="fixed bottom-4 right-4 bg-linear-to-r from-emerald-500 to-emerald-600 text-white px-6 py-3 rounded-lg shadow-lg opacity-0 pointer-events-none transition-opacity duration-300 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span>Your ticket has been submitted successfully!</span>
            </div>

            <!-- Floating Chat Button -->
            <div class="fixed bottom-6 right-6 z-50">
                <button class="w-14 h-14 rounded-full bg-emerald-500 hover:bg-emerald-600 text-white flex items-center justify-center shadow-lg hover:shadow-emerald-500/30 transition-all duration-300 group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                    <span class="absolute right-full mr-3 bg-neutral-800 text-white text-sm px-3 py-1.5 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">Technical Chat Support</span>
                </button>
            </div>
        </div>
    </div>

    <script>
        // Form submission handling is now done server-side
        // Keep the form validation for better UX
        document.getElementById('ticketForm').addEventListener('submit', function (e) {
            const subject = document.getElementById('subject').value.trim();
            const category = document.getElementById('category').value;
            const description = document.getElementById('description').value.trim();

            if (!subject || !category || !description) {
                e.preventDefault();
                alert('Please fill in all required fields.');
                return false;
            }
        });

        // Enhanced search input auto-suggestions
        const searchInput = document.getElementById('searchInput');
        const suggestions = document.getElementById('suggestions');

        searchInput.addEventListener('input', function () {
            const query = searchInput.value.trim();
            if (query.length > 2) {
                suggestions.classList.remove('hidden');

                // Mock suggestions based on input
                const mockSuggestions = [
                    `"${query}" in video playback issues`,
                    `"${query}" in account settings`,
                    `"${query}" in payment problems`,
                    `"${query}" in course access`
                ];

                let suggestionsHTML = '';
                mockSuggestions.forEach(suggestion => {
                    suggestionsHTML += `<div class="p-3 hover:bg-neutral-700 cursor-pointer transition-colors">${suggestion}</div>`;
                });

                suggestions.innerHTML = suggestionsHTML;
            } else {
                suggestions.classList.add('hidden');
            }
        });

        // Close suggestions when clicking outside
        document.addEventListener('click', function(e) {
            if (e.target !== searchInput && e.target !== suggestions) {
                suggestions.classList.add('hidden');
            }
        });

        // FAQ Accordion functionality
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

