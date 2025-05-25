<div class="p-6">
    <div class="mb-4">
        <h4 class="text-lg font-semibold text-gray-900">{{ $user->name }}</h4>
        <p class="text-sm text-gray-600">Total Attempts: {{ $results->count() }}</p>
    </div>

    <div class="space-y-4 max-h-96 overflow-y-auto">
        @foreach($results as $result)
            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center space-x-4">
                        <div class="text-lg font-bold text-red-600">
                            ₱{{ number_format($result->total_value, 2) }}
                        </div>
                        <div class="text-sm {{ $result->total_return_percent >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $result->total_return_percent >= 0 ? '+' : '' }}{{ $result->total_return_percent }}% return
                        </div>
                    </div>
                    <div class="text-sm text-gray-500">
                        {{ $result->created_at->format('M j, Y g:i A') }}
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div class="text-gray-600">
                        Initial: ₱{{ number_format($result->initial_amount, 2) }}
                    </div>
                    <div class="text-gray-600">
                        Final: ₱{{ number_format($result->final_amount, 2) }}
                    </div>
                </div>

                @if($result->portfolio_data)
                    <div class="mt-3">
                        <h5 class="text-sm font-medium text-gray-700 mb-2">Portfolio Breakdown:</h5>
                        <div class="text-xs text-gray-600 bg-white p-2 rounded border">
                            @php
                                $portfolio = is_string($result->portfolio_data) ? json_decode($result->portfolio_data, true) : $result->portfolio_data;
                            @endphp
                            @if(is_array($portfolio))
                                @foreach($portfolio as $investment)
                                    <div class="flex justify-between py-1">
                                        <span>{{ $investment['name'] ?? 'Investment' }}</span>
                                        <span>₱{{ number_format($investment['amount'] ?? 0, 2) }}</span>
                                    </div>
                                @endforeach
                            @else
                                <span>Portfolio data not available</span>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>
