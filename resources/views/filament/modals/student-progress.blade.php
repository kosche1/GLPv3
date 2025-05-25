<div class="p-6 bg-gray-900 text-white">
    <div class="mb-6 bg-gray-900">
        <h3 class="text-xl font-semibold text-white">{{ $user->name }}</h3>
        <p class="text-sm text-gray-300">{{ $user->email }}</p>
        <div class="mt-2 flex items-center space-x-4">
            <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-blue-600 text-blue-100 rounded-full">
                {{ $user->getRoleNames()->first() ?? 'student' }}
            </span>
            <span class="text-sm text-gray-400">
                Joined: {{ $user->created_at->format('M j, Y') }}
            </span>
        </div>
    </div>

    <!-- Game Progress Summary -->
    <div class="bg-gray-800 rounded-lg border border-gray-700">
        <div class="px-4 py-3 border-b border-gray-700 bg-gray-750">
            <h4 class="text-sm font-medium text-white">Game Progress Summary</h4>
        </div>

        <div class="divide-y divide-gray-700 bg-gray-800">
            <!-- Typing Speed -->
            <div class="px-4 py-3 flex items-center justify-between bg-gray-800">
                <div class="flex items-center space-x-3">
                    <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                    <span class="text-sm font-medium text-white">Typing Speed</span>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-300">{{ $typingResults->count() }} attempts</span>
                    @if($typingResults->count() > 0)
                        <span class="text-sm font-medium text-blue-400">
                            Best: {{ $typingResults->max('wpm') }} WPM
                        </span>
                    @endif
                </div>
            </div>

            <!-- Equation Drop -->
            <div class="px-4 py-3 flex items-center justify-between bg-gray-800">
                <div class="flex items-center space-x-3">
                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                    <span class="text-sm font-medium text-white">Equation Drop</span>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-300">{{ $equationResults->count() }} attempts</span>
                    @if($equationResults->count() > 0)
                        <span class="text-sm font-medium text-green-400">
                            Best: {{ $equationResults->max('score') }} points
                        </span>
                    @endif
                </div>
            </div>

            <!-- Historical Maze -->
            <div class="px-4 py-3 flex items-center justify-between bg-gray-800">
                <div class="flex items-center space-x-3">
                    <div class="w-2 h-2 bg-yellow-500 rounded-full"></div>
                    <span class="text-sm font-medium text-white">Historical Maze</span>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-300">{{ $mazeResults->count() }} attempts</span>
                    @if($mazeResults->count() > 0)
                        <span class="text-sm font-medium text-yellow-400">
                            Best: {{ $mazeResults->max('score') }} points
                        </span>
                    @endif
                </div>
            </div>

            <!-- InvestSmart -->
            <div class="px-4 py-3 flex items-center justify-between bg-gray-800">
                <div class="flex items-center space-x-3">
                    <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                    <span class="text-sm font-medium text-white">InvestSmart</span>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-300">{{ $investResults->count() }} attempts</span>
                    @if($investResults->count() > 0)
                        <span class="text-sm font-medium text-red-400">
                            Best: ₱{{ number_format($investResults->max('total_value') ?? 0, 2) }}
                        </span>
                    @endif
                </div>
            </div>

            <!-- Recipe Builder -->
            <div class="px-4 py-3 flex items-center justify-between bg-gray-800">
                <div class="flex items-center space-x-3">
                    <div class="w-2 h-2 bg-purple-500 rounded-full"></div>
                    <span class="text-sm font-medium text-white">Recipe Builder</span>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-300">{{ $recipeResults->count() }} attempts</span>
                    @if($recipeResults->count() > 0)
                        <span class="text-sm font-medium text-purple-400">
                            Best: {{ $recipeResults->max('score') }} points
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if($typingResults->count() > 0 || $equationResults->count() > 0 || $mazeResults->count() > 0 || $investResults->count() > 0 || $recipeResults->count() > 0)
    <!-- Recent Activity -->
    <div class="mt-6 bg-gray-800 rounded-lg border border-gray-700">
        <div class="px-4 py-3 border-b border-gray-700 bg-gray-750">
            <h4 class="text-sm font-medium text-white">Recent Activity</h4>
        </div>

        <div class="max-h-64 overflow-y-auto bg-gray-800">
                @php
                    $allResults = collect();

                    // Add typing results
                    foreach($typingResults as $result) {
                        $allResults->push([
                            'type' => 'Typing Speed',
                            'color' => 'blue',
                            'score' => $result->wpm . ' WPM',
                            'details' => $result->accuracy . '% accuracy',
                            'status' => $result->approved ? 'Approved' : 'Pending',
                            'date' => $result->created_at,
                        ]);
                    }

                    // Add equation results
                    foreach($equationResults as $result) {
                        $allResults->push([
                            'type' => 'Equation Drop',
                            'color' => 'green',
                            'score' => $result->score . ' points',
                            'details' => ($result->accuracy_percentage ?? 0) . '% accuracy',
                            'status' => $result->completed ? 'Completed' : 'Incomplete',
                            'date' => $result->created_at,
                        ]);
                    }

                    // Add maze results
                    foreach($mazeResults as $result) {
                        $allResults->push([
                            'type' => 'Historical Maze',
                            'color' => 'yellow',
                            'score' => $result->score . ' points',
                            'details' => ($result->accuracy_percentage ?? 0) . '% accuracy',
                            'status' => $result->completed ? 'Completed' : 'Incomplete',
                            'date' => $result->created_at,
                        ]);
                    }

                    // Add invest results
                    foreach($investResults as $result) {
                        $allResults->push([
                            'type' => 'InvestSmart',
                            'color' => 'red',
                            'score' => '₱' . number_format($result->total_value ?? 0, 2),
                            'details' => (($result->total_return_percent ?? 0) >= 0 ? '+' : '') . ($result->total_return_percent ?? 0) . '% return',
                            'status' => ($result->total_return_percent ?? 0) >= 0 ? 'Profit' : 'Loss',
                            'date' => $result->created_at,
                        ]);
                    }

                    // Add recipe results
                    foreach($recipeResults as $result) {
                        $allResults->push([
                            'type' => 'Recipe Builder',
                            'color' => 'purple',
                            'score' => $result->score . ' points',
                            'details' => $result->name ?? 'Custom Recipe',
                            'status' => $result->points_awarded ? 'Approved' : 'Pending',
                            'date' => $result->created_at,
                        ]);
                    }

                    // Sort by date (newest first)
                    $allResults = $allResults->sortByDesc('date')->take(10);
                @endphp

                @foreach($allResults as $result)
                    <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-700 bg-gray-800">
                        <div class="flex items-center space-x-4">
                            <div class="w-3 h-3 bg-{{ $result['color'] }}-500 rounded-full"></div>
                            <div class="min-w-0 flex-1">
                                <div class="text-sm font-medium text-white">{{ $result['type'] }}</div>
                                <div class="text-xs text-gray-400 mt-1">{{ $result['details'] }}</div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-6 ml-4">
                            <div class="text-right">
                                <div class="text-sm font-medium text-{{ $result['color'] }}-400">{{ $result['score'] }}</div>
                                <div class="text-xs text-gray-400 mt-1">{{ $result['date']->format('M j') }}</div>
                            </div>
                            <span class="inline-flex items-center px-3 py-1 text-xs font-medium
                                @if($result['status'] === 'Approved' || $result['status'] === 'Completed' || $result['status'] === 'Profit')
                                    bg-green-600 text-green-100
                                @elseif($result['status'] === 'Pending')
                                    bg-yellow-600 text-yellow-100
                                @else
                                    bg-red-600 text-red-100
                                @endif
                                rounded-full whitespace-nowrap">
                                {{ $result['status'] }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>
