<x-filament::page>
    <div class="space-y-6">
        <div class="p-6 bg-white rounded-xl shadow">
            <h2 class="text-xl font-bold tracking-tight mb-4">Challenge Details</h2>

            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2 mb-6">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Name</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $challenge->name }}</dd>
                </div>

                <div>
                    <dt class="text-sm font-medium text-gray-500">Difficulty</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($challenge->difficulty_level) }}</dd>
                </div>

                <div>
                    <dt class="text-sm font-medium text-gray-500">Points Reward</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $challenge->points_reward }}</dd>
                </div>

                <div>
                    <dt class="text-sm font-medium text-gray-500">Duration</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        {{ $challenge->start_date->format('M d, Y') }} -
                        {{ $challenge->end_date ? $challenge->end_date->format('M d, Y') : 'Ongoing' }}
                    </dd>
                </div>

                <div class="sm:col-span-2">
                    <dt class="text-sm font-medium text-gray-500">Description</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $challenge->description }}</dd>
                </div>
            </dl>

            <div class="flex space-x-4">
                <a href="{{ ChallengeResource::getUrl('edit', ['record' => $challenge]) }}"
                class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                    <x-heroicon-o-pencil class="-ml-1 mr-2 h-5 w-5 text-gray-400" />
                                    Edit Challenge
                                </a>

                                <a href="{{ ChallengeResource::getUrl('index') }}"
                                   class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                    <x-heroicon-o-arrow-left class="-ml-1 mr-2 h-5 w-5 text-gray-400" />
                                    Back to Challenges
                                </a>
                            </div>
                        </div>

                        <div class="p-6 bg-white rounded-xl shadow">
                            <h2 class="text-xl font-bold tracking-tight mb-4">Challenge Participants</h2>

                            <div class="flex justify-between items-center mb-4">
                                <div class="text-sm text-gray-500">
                                    Total Participants: {{ $challenge->users->count() }}
                                </div>

                                <div class="flex space-x-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        {{ $challenge->users->where('pivot.status', 'completed')->count() }} Completed
                                    </span>

                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        {{ $challenge->users->where('pivot.status', 'in_progress')->count() }} In Progress
                                    </span>

                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ $challenge->users->where('pivot.status', 'enrolled')->count() }} Enrolled
                                    </span>

                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        {{ $challenge->users->where('pivot.status', 'failed')->count() }} Failed
                                    </span>
                                </div>
                            </div>

                            {{ $this->table }}
                        </div>
                    </div>
</x-filament::page>
