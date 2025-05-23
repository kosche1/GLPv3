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
                    <p class="text-zinc-400 text-sm">Disclaimer</p>
                </div>
            </div>

            <!-- Main content card with landscape layout -->
            <div class="bg-zinc-800/50 border border-zinc-700/50 rounded-xl p-4 shadow-lg">
                <div class="prose prose-invert prose-emerald max-w-none prose-sm">
                    <!-- Section content in a landscape layout -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                        <div>
                            <h2 class="text-lg font-semibold text-emerald-300 mt-1 mb-2 flex items-center">
                                Educational Purpose
                            </h2>
                            <p class="text-xs">GameLearnPro is designed primarily for educational purposes. The content should not be considered as professional advice in any field.</p>
                        </div>

                        <div>
                            <h2 class="text-lg font-semibold text-emerald-300 mt-1 mb-2 flex items-center">
                                No Guarantees
                            </h2>
                            <p class="text-xs">We make no guarantees regarding the educational outcomes or results from using GameLearnPro. Learning progress depends on individual effort and engagement.</p>
                        </div>

                        <div>
                            <h2 class="text-lg font-semibold text-emerald-300 mt-1 mb-2 flex items-center">
                                Third-Party Content
                            </h2>
                            <p class="text-xs">GameLearnPro may include links to third-party websites or resources. We are not responsible for the availability, accuracy, or content of these external sources.</p>
                        </div>

                        <div>
                            <h2 class="text-lg font-semibold text-emerald-300 mt-1 mb-2 flex items-center">
                                Service Availability
                            </h2>
                            <p class="text-xs">GameLearnPro may experience downtime for maintenance, updates, or due to technical issues. We do not guarantee uninterrupted access to the platform.</p>
                        </div>

                        <div>
                            <h2 class="text-lg font-semibold text-emerald-300 mt-1 mb-2 flex items-center">
                                User Responsibility
                            </h2>
                            <p class="text-xs">Users are responsible for maintaining the security of their accounts, including keeping passwords confidential.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation buttons -->
            <div class="mt-6 text-center space-x-4">
                <a href="{{ route('terms') }}" class="inline-flex items-center px-4 py-2 bg-zinc-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-zinc-500 active:bg-zinc-700 focus:outline-none focus:border-zinc-700 focus:ring focus:ring-zinc-200 disabled:opacity-25 transition">
                    Back
                </a>
                <a href="{{ route('system-policy') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-500 active:bg-emerald-700 focus:outline-none focus:border-emerald-700 focus:ring focus:ring-emerald-200 disabled:opacity-25 transition">
                    Next
                </a>
            </div>
        </div>
    </div>
</x-layouts.guest>
