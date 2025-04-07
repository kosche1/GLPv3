<div class="grid gap-4 md:grid-cols-3">
    @foreach($stats as $stat)
    <div class="p-6 bg-white rounded-xl shadow-sm dark:bg-gray-800">
        <div class="flex items-center gap-4">
            <div class="p-2 rounded-lg bg-primary-50 dark:bg-primary-500/10">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] === 'heroicon-o-users' ? 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z' : ($stat['icon'] === 'heroicon-o-user-group' ? 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z' : 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z') }}" />
                </svg>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $stat['label'] }}</h3>
                <p class="text-3xl font-semibold text-gray-900 dark:text-white">{{ $stat['value'] }}</p>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $stat['description'] }}</p>
            </div>
        </div>
    </div>
    @endforeach
</div>
