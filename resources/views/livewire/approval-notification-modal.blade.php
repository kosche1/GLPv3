<div>
    @if($isOpen)
    <div
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm"
        x-data
        x-init="$el.classList.add('opacity-0'); setTimeout(() => { $el.classList.replace('opacity-0', 'opacity-100'); }, 100)"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    >
        <div 
            class="relative w-full max-w-md p-6 mx-auto bg-gray-900 rounded-xl shadow-xl"
            x-data
            x-init="$el.classList.add('scale-95', 'opacity-0'); setTimeout(() => { $el.classList.replace('scale-95', 'scale-100'); $el.classList.replace('opacity-0', 'opacity-100'); }, 150)"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="scale-95 opacity-0"
            x-transition:enter-end="scale-100 opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="scale-100 opacity-100"
            x-transition:leave-end="scale-95 opacity-0"
        >
            <!-- Close button -->
            <button 
                wire:click="closeModal" 
                class="absolute top-3 right-3 text-gray-400 hover:text-white transition-colors"
                aria-label="Close"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            
            <!-- Success icon -->
            <div class="flex justify-center mb-4">
                <div class="rounded-full bg-green-500/20 p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>
            
            <!-- Title -->
            <h2 class="text-xl font-bold text-center text-white mb-2">{{ $title }}</h2>
            
            <!-- Message -->
            <p class="text-gray-300 text-center mb-4">{{ $message }}</p>
            
            @if($submissionContent)
            <!-- Submission content -->
            <div class="mb-4">
                <h3 class="text-green-400 text-sm font-medium mb-1">Submitted Content:</h3>
                <div class="bg-gray-800 rounded p-3 text-gray-300 text-sm">
                    {{ $submissionContent }}
                </div>
            </div>
            @endif
            
            @if($feedback)
            <!-- Teacher feedback -->
            <div class="mb-4">
                <h3 class="text-green-400 text-sm font-medium mb-1">Teacher Feedback:</h3>
                <div class="bg-gray-800 rounded p-3 text-gray-300 text-sm">
                    {{ $feedback }}
                </div>
            </div>
            @endif
            
            @if($pointsAwarded > 0)
            <!-- Points awarded -->
            <div class="flex items-center justify-center mb-4">
                <div class="bg-green-500/20 rounded-full px-4 py-1 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-green-500 font-bold">{{ $pointsAwarded }} points awarded!</span>
                </div>
            </div>
            @endif
            
            <!-- Continue button -->
            <div class="mt-6">
                @if($continueUrl)
                <a 
                    href="{{ $continueUrl }}" 
                    class="w-full inline-flex justify-center items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors"
                >
                    {{ $continueText }}
                </a>
                @else
                <button 
                    wire:click="closeModal" 
                    class="w-full inline-flex justify-center items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors"
                >
                    {{ $continueText }}
                </button>
                @endif
            </div>
            
            <!-- Check for more approvals text -->
            <div class="text-center mt-2">
                <span class="text-xs text-gray-500">Check for approved tasks</span>
            </div>
        </div>
    </div>
    @endif
</div>
