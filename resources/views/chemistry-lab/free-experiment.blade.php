<x-layouts.app>
    @include('partials.head')
    {{-- ... style and animated background divs ... --}}
    <div class="flex h-full w-full flex-1 flex-col gap-6 text-gray-100 p-6 border border-emerald-500 rounded-lg">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-emerald-500/10 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-white">Free Experiment Mode</h1>
            </div>
            <div class="flex gap-4">
                <a href="{{ route('subjects.specialized.stem.chemistry-lab') }}" class="flex items-center gap-2 px-5 py-2.5 rounded-lg border border-emerald-500/30 bg-emerald-500/10 transition-all duration-300 hover:bg-emerald-500/20 hover:border-emerald-500/50 hover:shadow-lg hover:shadow-emerald-900/20 group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400 group-hover:text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                    </svg>
                    <span>Back to Chemistry Lab</span>
                </a>
            </div>
        </div>

        <!-- Lab Interface -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 flex-1">
            <!-- Left Panel: Chemicals and Equipment -->
            <div class="bg-neutral-800 rounded-xl border border-neutral-700 p-4 shadow-lg h-full">
                <h2 class="text-lg font-semibold text-white mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    Chemicals & Equipment
                </h2>

                <!-- Tabs for Chemicals and Equipment -->
                <div class="mb-4 border-b border-neutral-700">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="labTabs" role="tablist">
                        <li class="mr-2" role="presentation">
                            <button class="inline-block p-4 border-b-2 rounded-t-lg border-emerald-500 text-emerald-400 active" id="chemicals-tab" data-tab="chemicals" type="button" role="tab" aria-controls="chemicals" aria-selected="true">Chemicals</button>
                        </li>
                        <li class="mr-2" role="presentation">
                            <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-300 hover:border-gray-300" id="equipment-tab" data-tab="equipment" type="button" role="tab" aria-controls="equipment" aria-selected="false">Equipment</button>
                        </li>
                    </ul>
                </div>

                <!-- Chemicals Tab Content -->
                <div class="tab-content active" id="chemicals-content">
                    <div class="grid grid-cols-2 gap-2">
                        <div class="chemical-item p-2 bg-neutral-700 rounded-lg cursor-pointer hover:bg-neutral-600 transition-colors" data-chemical="water">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center mr-2">
                                    <span class="text-xs font-bold text-black">H₂O</span>
                                </div>
                                <span class="text-sm">Water</span>
                            </div>
                        </div>
                        <div class="chemical-item p-2 bg-neutral-700 rounded-lg cursor-pointer hover:bg-neutral-600 transition-colors" data-chemical="hcl">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-yellow-500 flex items-center justify-center mr-2">
                                    <span class="text-xs font-bold text-black">HCl</span>
                                </div>
                                <span class="text-sm">Hydrochloric Acid</span>
                            </div>
                        </div>
                        <div class="chemical-item p-2 bg-neutral-700 rounded-lg cursor-pointer hover:bg-neutral-600 transition-colors" data-chemical="naoh">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-purple-500 flex items-center justify-center mr-2">
                                    <span class="text-xs font-bold text-black">NaOH</span>
                                </div>
                                <span class="text-sm">Sodium Hydroxide</span>
                            </div>
                        </div>
                        <div class="chemical-item p-2 bg-neutral-700 rounded-lg cursor-pointer hover:bg-neutral-600 transition-colors" data-chemical="phenolphthalein">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-pink-300 flex items-center justify-center mr-2">
                                    <span class="text-xs font-bold text-black">Ph</span>
                                </div>
                                <span class="text-sm">Phenolphthalein</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Equipment Tab Content -->
                <div class="tab-content hidden" id="equipment-content">
                    <div class="grid grid-cols-2 gap-2">
                        <div class="equipment-item p-2 bg-neutral-700 rounded-lg cursor-pointer hover:bg-neutral-600 transition-colors" data-equipment="beaker">
                            <div class="flex items-center">
                                <svg class="w-8 h-8 mr-2 text-gray-300" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 3H17V7C17 7 17 13 12 13C7 13 7 7 7 7V3Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M5 21H19V19C19 17 17 15 12 15C7 15 5 17 5 19V21Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span class="text-sm">Beaker</span>
                            </div>
                        </div>
                        <div class="equipment-item p-2 bg-neutral-700 rounded-lg cursor-pointer hover:bg-neutral-600 transition-colors" data-equipment="test-tube">
                            <div class="flex items-center">
                                <svg class="w-8 h-8 mr-2 text-gray-300" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9 3H15V8C15 8 15 16 12 16C9 16 9 8 9 8V3Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M7 21H17V19C17 18 15 17 12 17C9 17 7 18 7 19V21Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span class="text-sm">Test Tube</span>
                            </div>
                        </div>
                        <div class="equipment-item p-2 bg-neutral-700 rounded-lg cursor-pointer hover:bg-neutral-600 transition-colors" data-equipment="bunsen-burner">
                            <div class="flex items-center">
                                <svg class="w-8 h-8 mr-2 text-gray-300" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 3V7M12 21V17M12 17C10.3431 17 9 15.6569 9 14C9 12.3431 10.3431 11 12 11C13.6569 11 15 12.3431 15 14C15 15.6569 13.6569 17 12 17Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M7 21H17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span class="text-sm">Bunsen Burner</span>
                            </div>
                        </div>
                        <div class="equipment-item p-2 bg-neutral-700 rounded-lg cursor-pointer hover:bg-neutral-600 transition-colors" data-equipment="pipette">
                            <div class="flex items-center">
                                <svg class="w-8 h-8 mr-2 text-gray-300" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 3V7M12 21V17M12 7V17M8 7H16M9 21H15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span class="text-sm">Pipette</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Middle Panel: Lab Bench -->
            <div class="lg:col-span-2 bg-neutral-800 rounded-xl border border-neutral-700 p-4 shadow-lg h-full flex flex-col">
                <h2 class="text-lg font-semibold text-white mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Lab Bench
                </h2>

                <div class="lab-bench flex-1 bg-neutral-700 rounded-lg relative">
                    <!-- This is where the interactive lab bench will be rendered -->
                    <div class="absolute inset-0 flex items-center justify-center" id="lab-bench-placeholder">
                        <p class="text-neutral-400">Drag chemicals and equipment here to start experimenting</p>
                    </div>

                    <!-- p5.js sketch container -->
                    <div id="p5-container" class="absolute inset-0 z-10"></div>

                    <!-- Original lab bench content (will be hidden when p5.js is active) -->
                    <div id="original-lab-bench" class="absolute inset-0 z-5"></div>
                </div>

                <div class="mt-4 grid grid-cols-2 gap-4">
                    <div class="col-span-2 bg-neutral-700 rounded-lg p-3 mb-2 flex items-center justify-between">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            <span class="text-white font-medium">Score:</span>
                        </div>
                        <span id="score-display" class="text-xl font-bold text-emerald-400">0</span>
                    </div>

                    <button id="reset-bench" class="px-4 py-2 bg-red-600 hover:bg-red-500 text-white rounded-lg transition-colors flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Reset Bench
                    </button>
                    <button id="heat-bench" class="px-4 py-2 bg-orange-600 hover:bg-orange-500 text-white rounded-lg transition-colors flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z" />
                        </svg>
                        Heat Bench
                    </button>
                    <button id="view-molecular" class="px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded-lg transition-colors flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 3l-6 6m0 0V4m0 5h5M5 3a2 2 0 00-2 2v1c0 8.284 6.716 15 15 15h1a2 2 0 002-2v-3.28a1 1 0 00-.684-.948l-4.493-1.498a1 1 0 00-1.21.502l-1.13 2.257a11.042 11.042 0 01-5.516-5.517l2.257-1.128a1 1 0 00.502-1.21L9.228 3.683A1 1 0 008.279 3H5z" />
                        </svg>
                        View Molecular Structure
                    </button>
                    <button id="show-results" class="col-span-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white rounded-lg transition-colors flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Show Results
                    </button>
                </div>
            </div>
        </div>

        <!-- Molecular Viewer Section -->
        <div class="bg-neutral-800 rounded-xl border border-neutral-700 p-4 shadow-lg hidden" id="molecular-viewer-section">
            <h2 class="text-lg font-semibold text-white mb-4 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 3l-6 6m0 0V4m0 5h5M5 3a2 2 0 00-2 2v1c0 8.284 6.716 15 15 15h1a2 2 0 002-2v-3.28a1 1 0 00-.684-.948l-4.493-1.498a1 1 0 00-1.21.502l-1.13 2.257a11.042 11.042 0 01-5.516-5.517l2.257-1.128a1 1 0 00.502-1.21L9.228 3.683A1 1 0 008.279 3H5z" />
                </svg>
                Molecular View
            </h2>

            <div class="h-64 bg-black rounded-lg" id="molecular-viewer" style="width: 100%; height: 100%; min-height: 300px;">
                <!-- Vue.js molecular viewer will be mounted here -->
            </div>
        </div>
    </div>

    <!-- Include Matter.js for physics -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/matter-js/0.19.0/matter.min.js"></script>

    <!-- Include p5.js for better visualization -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/1.6.0/p5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/1.6.0/addons/p5.sound.min.js"></script>

    <!-- Include Vue.js and Chemistry Lab App -->
    @vite('resources/js/chemistry-lab-app.js')

    <!-- Include Chemistry Lab JavaScript for drag and drop functionality -->
    <script src="{{ asset('js/chemistry-lab.js') }}"></script>

    <!-- Include Chemistry Lab Drag and Drop Fix -->
    <link href="{{ asset('css/chemistry-lab-drag-fix.css') }}" rel="stylesheet">
    <script src="{{ asset('js/chemistry-lab-drag-fix.js') }}"></script>

    <!-- Include Chemistry Lab Pour Functionality -->
    <script src="{{ asset('js/chemistry-lab-pour.js') }}"></script>

    <!-- Include Direct Drag and Drop Functionality -->
    <link href="{{ asset('css/chemistry-lab-direct-drag.css') }}" rel="stylesheet">
    <script src="{{ asset('js/chemistry-lab-direct-drag.js') }}"></script>

    <!-- Include p5.js Chemistry Lab Visualization -->
    <script src="{{ asset('js/chemistry-lab-p5.js') }}"></script>

    {{-- <!-- Add CSS animations --> --}}
    {{-- <link href="{{ asset('css/animations.css') }}" rel="stylesheet"> --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize the p5.js lab visualization
            console.log('DOMContentLoaded: Attempting to initialize p5.js sketch.');
            if (typeof initP5Lab === 'function') {
                console.log('initP5Lab function found. Calling initP5Lab(\'p5-container\').');
                initP5Lab('p5-container');
            } else {
                console.error('initP5Lab function not found on DOMContentLoaded. p5.js sketch will not be initialized.');
            }
        });
    </script>
</x-layouts.app>
