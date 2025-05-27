<x-layouts.app>
    <div class="flex h-full w-full flex-1 flex-col gap-6 text-gray-100 p-6 border border-emerald-500/30 rounded-lg bg-linear-to-b from-neutral-900 to-neutral-800">
        <div class="max-w-7xl mx-auto w-full">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-white mb-4">My Support Tickets</h1>
                <p class="text-zinc-300">View and manage all your support tickets</p>
            </div>

            <!-- Actions -->
            <div class="flex justify-between items-center mb-6">
                <div class="flex space-x-4">
                    <select id="statusFilter" class="px-3 py-2 rounded-lg bg-neutral-800 border border-neutral-700 text-white focus:outline-hidden focus:ring-2 focus:ring-emerald-500/50 text-sm">
                        <option value="">All Statuses</option>
                        <option value="open" {{ request('status') === 'open' ? 'selected' : '' }}>Open</option>
                        <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="resolved" {{ request('status') === 'resolved' ? 'selected' : '' }}>Resolved</option>
                        <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                </div>
                <a href="{{ route('technical-support') }}" class="px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg transition-colors">
                    Create New Ticket
                </a>
            </div>

            <!-- Tickets List -->
            <div class="space-y-4">
                @forelse($tickets as $ticket)
                    <div class="rounded-xl border border-neutral-700 bg-linear-to-br from-neutral-800 to-neutral-900 p-6 hover:border-emerald-500/30 transition-colors">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-white mb-2">{{ $ticket->subject }}</h3>
                                <p class="text-neutral-400 text-sm">Ticket #{{ $ticket->ticket_number }}</p>
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
                                <span class="inline-flex rounded-full {{ $statusColors[$ticket->status] ?? $statusColors['open'] }} px-2.5 py-0.5 text-xs font-medium">
                                    {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                </span>
                                <span class="inline-flex rounded-full {{ $priorityColors[$ticket->priority] ?? $priorityColors['medium'] }} px-2.5 py-0.5 text-xs font-medium">
                                    {{ ucfirst($ticket->priority) }}
                                </span>
                            </div>
                        </div>

                        <p class="text-neutral-300 mb-4">{{ Str::limit($ticket->description, 150) }}</p>

                        <div class="flex justify-between items-center">
                            <div class="text-sm text-neutral-400">
                                <span>Created {{ $ticket->created_at->diffForHumans() }}</span>
                                @if($ticket->updated_at != $ticket->created_at)
                                    <span class="mx-2">•</span>
                                    <span>Updated {{ $ticket->updated_at->diffForHumans() }}</span>
                                @endif
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('support-tickets.show', $ticket) }}" class="text-emerald-400 hover:text-emerald-300 transition-colors text-sm">
                                    View Details
                                </a>
                                @if($ticket->status === 'open')
                                    <span class="text-neutral-500">•</span>
                                    <a href="{{ route('support-tickets.edit', $ticket) }}" class="text-blue-400 hover:text-blue-300 transition-colors text-sm">
                                        Edit
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 mx-auto mb-4 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="text-xl font-medium text-white mb-2">No support tickets yet</h3>
                        <p class="text-neutral-400 mb-6">Create your first support ticket to get help with any issues.</p>
                        <a href="{{ route('technical-support') }}" class="px-6 py-3 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg transition-colors">
                            Create Support Ticket
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($tickets->hasPages())
                <div class="mt-8">
                    {{ $tickets->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- JavaScript for status filtering -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statusFilter = document.getElementById('statusFilter');

            statusFilter.addEventListener('change', function() {
                const selectedStatus = this.value;
                const url = new URL(window.location.href);

                if (selectedStatus) {
                    url.searchParams.set('status', selectedStatus);
                } else {
                    url.searchParams.delete('status');
                }

                // Remove page parameter to start from first page when filtering
                url.searchParams.delete('page');

                window.location.href = url.toString();
            });
        });
    </script>
</x-layouts.app>
