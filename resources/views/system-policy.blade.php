<x-layouts.guest>
    <div class="container mx-auto px-4 py-4">
        <!-- Centered landscape card layout -->
        <div class="max-w-7xl mx-auto">
            <!-- Header with logo and title -->
            <div class="flex items-center justify-center mb-6">
                <div class="relative mr-4">
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-emerald-500 to-blue-500 rounded-full blur-sm opacity-75 animate-pulse-slow"></div>
                    <div class="relative w-14 h-14 bg-zinc-900 rounded-full flex items-center justify-center border-2 border-emerald-500/50">
                        <x-app-logo-icon class="h-8 w-8 text-emerald-400" />
                    </div>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-emerald-400">GameLearnPro</h1>
                    <p class="text-zinc-400 text-sm">System Policy</p>
                </div>
            </div>

            <!-- Main content card with landscape layout -->
            <div class="bg-zinc-800/50 border border-zinc-700/50 rounded-xl p-4 shadow-lg">
                <div class="prose prose-invert prose-emerald max-w-none prose-sm">
                    <!-- Section content in a landscape layout -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                        <div>
                            <h2 class="text-lg font-semibold text-emerald-300 mt-1 mb-2 flex items-center">
                                System Requirements
                            </h2>
                            <p class="text-xs">GameLearnPro is designed to work on modern web browsers including Chrome, Firefox, Safari, and Edge. For optimal performance, we recommend using the latest version of your preferred browser.</p>
                        </div>

                        <div>
                            <h2 class="text-lg font-semibold text-emerald-300 mt-1 mb-2 flex items-center">
                                Data Storage
                            </h2>
                            <p class="text-xs">GameLearnPro stores user data including account information, learning progress, achievements, and submitted solutions. This data is stored securely and used to provide personalized learning experiences.</p>
                        </div>

                        <div>
                            <h2 class="text-lg font-semibold text-emerald-300 mt-1 mb-2 flex items-center">
                                Security Measures
                            </h2>
                            <p class="text-xs">We implement industry-standard security measures to protect user data, including encryption, secure authentication protocols, and regular security audits.</p>
                        </div>

                        <div>
                            <h2 class="text-lg font-semibold text-emerald-300 mt-1 mb-2 flex items-center">
                                System Monitoring
                            </h2>
                            <p class="text-xs">GameLearnPro monitors system usage to detect and prevent abuse, ensure fair play in gamified elements, and improve platform performance.</p>
                        </div>

                        <div>
                            <h2 class="text-lg font-semibold text-emerald-300 mt-1 mb-2 flex items-center">
                                Updates and Maintenance
                            </h2>
                            <p class="text-xs">The platform undergoes regular updates to improve functionality, add new features, and address security concerns. Updates may occasionally require temporary system downtime.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation buttons -->
            <div class="mt-6 text-center space-x-4">
                <a href="{{ route('disclaimer') }}" class="inline-flex items-center px-4 py-2 bg-zinc-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-zinc-500 active:bg-zinc-700 focus:outline-none focus:border-zinc-700 focus:ring focus:ring-zinc-200 disabled:opacity-25 transition">
                    Back
                </a>
                <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-500 active:bg-emerald-700 focus:outline-none focus:border-emerald-700 focus:ring focus:ring-emerald-200 disabled:opacity-25 transition">
                    Return to Login
                </a>
            </div>
        </div>
    </div>
</x-layouts.guest>
