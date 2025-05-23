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
                    <p class="text-zinc-400 text-sm">Terms & Conditions</p>
                </div>
            </div>



            <!-- Main content card with landscape layout -->
            <div class="bg-zinc-800/50 border border-zinc-700/50 rounded-xl p-4 shadow-lg">
                <div class="prose prose-invert prose-emerald max-w-none prose-sm">
                    <!-- Section content in a landscape layout -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                        <div>
                            <h2 id="acceptance" class="text-lg font-semibold text-emerald-300 mt-1 mb-2 flex items-center">
                                <span class="text-emerald-400 mr-2 font-bold">1</span>
                                Acceptance of Terms
                            </h2>
                            <p class="text-xs">By accessing and using GameLearnPro (GLP), you agree to be bound by these Terms and Conditions. GLP is an educational platform that combines learning with gamification elements to enhance the educational experience.</p>
                        </div>

                        <div>
                            <h2 id="accounts" class="text-lg font-semibold text-emerald-300 mt-1 mb-2 flex items-center">
                                <span class="text-emerald-400 mr-2 font-bold">2</span>
                                User Accounts
                            </h2>
                            <p class="text-xs">When creating a GameLearnPro account, you must provide accurate information. Student accounts may be linked to educational institutions and may require verification. You are responsible for maintaining the confidentiality of your account credentials.</p>
                        </div>

                        <div>
                            <h2 id="gamification" class="text-lg font-semibold text-emerald-300 mt-1 mb-2 flex items-center">
                                <span class="text-emerald-400 mr-2 font-bold">3</span>
                                Gamification System
                            </h2>
                            <p class="text-xs">GameLearnPro features a comprehensive gamification system including points, badges, achievements, daily rewards, and level progression. These elements are designed to motivate learning and engagement.</p>
                        </div>

                        <div>
                            <h2 id="content" class="text-lg font-semibold text-emerald-300 mt-1 mb-2 flex items-center">
                                <span class="text-emerald-400 mr-2 font-bold">4</span>
                                Content & Conduct
                            </h2>
                            <p class="text-xs">GameLearnPro provides educational content, challenges, and interactive learning materials. When participating in forums, submitting solutions, or creating content within the platform, you must adhere to our community guidelines.</p>
                        </div>

                        <div>
                            <h2 id="intellectual" class="text-lg font-semibold text-emerald-300 mt-1 mb-2 flex items-center">
                                <span class="text-emerald-400 mr-2 font-bold">5</span>
                                Intellectual Property
                            </h2>
                            <p class="text-xs">All content provided through GameLearnPro, including challenges, learning materials, graphics, and software, is owned by GameLearnPro or its licensors and is protected by intellectual property laws.</p>
                        </div>



                        <div>
                            <h2 id="termination" class="text-lg font-semibold text-emerald-300 mt-1 mb-2 flex items-center">
                                <span class="text-emerald-400 mr-2 font-bold">6</span>
                                Termination
                            </h2>
                            <p class="text-xs">GameLearnPro may suspend or terminate your account for violations of these Terms, including cheating, inappropriate conduct, or other violations.</p>
                        </div>

                        <div>
                            <h2 id="changes" class="text-lg font-semibold text-emerald-300 mt-1 mb-2 flex items-center">
                                <span class="text-emerald-400 mr-2 font-bold">7</span>
                                Changes to Terms
                            </h2>
                            <p class="text-xs">GameLearnPro may update these Terms at any time. For significant changes, we will provide notice through the platform or via email.</p>
                        </div>

                        <div>
                            <h2 id="liability" class="text-lg font-semibold text-emerald-300 mt-1 mb-2 flex items-center">
                                <span class="text-emerald-400 mr-2 font-bold">8</span>
                                Limitation of Liability
                            </h2>
                            <p class="text-xs">GameLearnPro strives to provide accurate educational content, but makes no warranties about the completeness or reliability of the platform.</p>
                        </div>
                    </div>
                </div>

            <!-- Navigation buttons -->
            <div class="mt-6 text-center space-x-4">
                <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 bg-zinc-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-zinc-500 active:bg-zinc-700 focus:outline-none focus:border-zinc-700 focus:ring focus:ring-zinc-200 disabled:opacity-25 transition">
                    Back
                </a>
                <a href="{{ route('disclaimer') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-500 active:bg-emerald-700 focus:outline-none focus:border-emerald-700 focus:ring focus:ring-emerald-200 disabled:opacity-25 transition">
                    Next
                </a>
            </div>
        </div>
    </div>
</x-layouts.guest>