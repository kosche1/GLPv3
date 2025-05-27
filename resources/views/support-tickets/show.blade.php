<x-layouts.app>
    <div class="flex h-full w-full flex-1 flex-col gap-6 text-gray-100 p-6 border border-emerald-500/30 rounded-lg bg-linear-to-b from-neutral-900 to-neutral-800">
        <div class="max-w-4xl mx-auto w-full">
            <!-- Header -->
            <div class="flex justify-between items-start mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-white mb-2">{{ $supportTicket->subject }}</h1>
                    <p class="text-neutral-400">Ticket #{{ $supportTicket->ticket_number }}</p>
                </div>
                <div class="flex items-center space-x-3">
                    @php
                        $statusColors = [
                            'open' => 'bg-blue-500/10 border-blue-500/20 text-blue-400',
                            'in_progress' => 'bg-amber-500/10 border-amber-500/20 text-amber-400',
                            'resolved' => 'bg-emerald-500/10 border-emerald-500/20 text-emerald-400',
                            'closed' => 'bg-gray-500/10 border-gray-500/20 text-gray-400',
                        ];
                        $priorityColors = [
                            'low' => 'bg-green-500/10 border-green-500/20 text-green-400',
                            'medium' => 'bg-yellow-500/10 border-yellow-500/20 text-yellow-400',
                            'high' => 'bg-red-500/10 border-red-500/20 text-red-400',
                        ];
                    @endphp
                    <span class="inline-flex rounded-full {{ $statusColors[$supportTicket->status] ?? $statusColors['open'] }} px-3 py-1 text-sm font-medium">
                        {{ ucfirst(str_replace('_', ' ', $supportTicket->status)) }}
                    </span>
                    <span class="inline-flex rounded-full {{ $priorityColors[$supportTicket->priority] ?? $priorityColors['medium'] }} px-3 py-1 text-sm font-medium">
                        {{ ucfirst($supportTicket->priority) }} Priority
                    </span>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-between items-center mb-6">
                <a href="{{ route('support-tickets.index') }}" class="text-emerald-400 hover:text-emerald-300 transition-colors flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Back to Tickets
                </a>
                @if($supportTicket->status === 'open')
                    <a href="{{ route('support-tickets.edit', $supportTicket) }}" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-colors">
                        Edit Ticket
                    </a>
                @endif
            </div>

            <!-- Ticket Details -->
            <div class="space-y-6">
                <!-- Description -->
                <div class="rounded-xl border border-neutral-700 bg-linear-to-br from-neutral-800 to-neutral-900 p-6">
                    <h2 class="text-xl font-semibold text-white mb-4">Description</h2>
                    <div class="prose prose-invert max-w-none">
                        <p class="text-neutral-300 whitespace-pre-wrap">{{ $supportTicket->description }}</p>
                    </div>
                </div>

                <!-- Ticket Information -->
                <div class="rounded-xl border border-neutral-700 bg-linear-to-br from-neutral-800 to-neutral-900 p-6">
                    <h2 class="text-xl font-semibold text-white mb-4">Ticket Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-neutral-400 mb-1">Category</label>
                            <p class="text-white">{{ ucfirst(str_replace('_', ' ', $supportTicket->category)) }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-neutral-400 mb-1">Priority</label>
                            <p class="text-white">{{ ucfirst($supportTicket->priority) }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-neutral-400 mb-1">Created</label>
                            <p class="text-white">{{ $supportTicket->created_at->format('M j, Y \a\t g:i A') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-neutral-400 mb-1">Last Updated</label>
                            <p class="text-white">{{ $supportTicket->updated_at->format('M j, Y \a\t g:i A') }}</p>
                        </div>
                        @if($supportTicket->assignedAdmin)
                            <div>
                                <label class="block text-sm font-medium text-neutral-400 mb-1">Assigned To</label>
                                <p class="text-white">{{ $supportTicket->assignedAdmin->name }}</p>
                            </div>
                        @endif
                        @if($supportTicket->resolved_at)
                            <div>
                                <label class="block text-sm font-medium text-neutral-400 mb-1">Resolved</label>
                                <p class="text-white">{{ $supportTicket->resolved_at->format('M j, Y \a\t g:i A') }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Attachments -->
                @if($supportTicket->attachments && count($supportTicket->attachments) > 0)
                    <div class="rounded-xl border border-neutral-700 bg-linear-to-br from-neutral-800 to-neutral-900 p-6">
                        <h2 class="text-xl font-semibold text-white mb-4">Attachments</h2>
                        <div class="space-y-3">
                            @foreach($supportTicket->attachments as $index => $attachment)
                                <div class="flex items-center justify-between p-3 bg-neutral-800/50 rounded-lg">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 mr-3 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                        </svg>
                                        <div>
                                            <p class="text-white font-medium">{{ $attachment['original_name'] }}</p>
                                            <p class="text-neutral-400 text-sm">{{ number_format($attachment['size'] / 1024, 2) }} KB</p>
                                        </div>
                                    </div>
                                    <a href="{{ route('support-tickets.download-attachment', [$supportTicket, $index]) }}" 
                                       class="text-emerald-400 hover:text-emerald-300 transition-colors">
                                        Download
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Resolution -->
                @if($supportTicket->resolution_notes)
                    <div class="rounded-xl border border-emerald-700 bg-linear-to-br from-emerald-900/20 to-emerald-800/20 p-6">
                        <h2 class="text-xl font-semibold text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Resolution
                        </h2>
                        <div class="prose prose-invert max-w-none">
                            <p class="text-neutral-300 whitespace-pre-wrap">{{ $supportTicket->resolution_notes }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app>
