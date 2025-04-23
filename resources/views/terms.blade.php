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

            <!-- Navigation tabs - horizontal -->
            <div class="flex flex-wrap justify-center gap-2 mb-6">
                <a href="#acceptance" class="px-3 py-1.5 rounded-lg bg-zinc-700/50 text-emerald-300 hover:bg-zinc-700 transition text-sm">1. Acceptance</a>
                <a href="#accounts" class="px-3 py-1.5 rounded-lg bg-zinc-700/50 text-emerald-300 hover:bg-zinc-700 transition text-sm">2. Accounts</a>
                <a href="#gamification" class="px-3 py-1.5 rounded-lg bg-zinc-700/50 text-emerald-300 hover:bg-zinc-700 transition text-sm">3. Gamification</a>
                <a href="#content" class="px-3 py-1.5 rounded-lg bg-zinc-700/50 text-emerald-300 hover:bg-zinc-700 transition text-sm">4. Content</a>
                <a href="#intellectual" class="px-3 py-1.5 rounded-lg bg-zinc-700/50 text-emerald-300 hover:bg-zinc-700 transition text-sm">5. IP</a>

                <a href="#termination" class="px-3 py-1.5 rounded-lg bg-zinc-700/50 text-emerald-300 hover:bg-zinc-700 transition text-sm">6. Termination</a>
                <a href="#liability" class="px-3 py-1.5 rounded-lg bg-zinc-700/50 text-emerald-300 hover:bg-zinc-700 transition text-sm">7. Liability</a>
                <a href="#changes" class="px-3 py-1.5 rounded-lg bg-zinc-700/50 text-emerald-300 hover:bg-zinc-700 transition text-sm">8. Changes</a>
            </div>

            <!-- Main content card with landscape layout -->
            <div class="bg-zinc-800/50 border border-zinc-700/50 rounded-xl p-6 shadow-lg overflow-y-auto max-h-[70vh]">
                <div class="prose prose-invert prose-emerald max-w-none">
                    <!-- Section content in a landscape layout -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                        <div>
                            <h2 id="acceptance" class="text-xl font-semibold text-emerald-300 mt-1 mb-3 flex items-center">
                                <span class="text-emerald-400 mr-2 font-bold">1</span>
                                Acceptance of Terms
                            </h2>
                            <p class="text-sm">By accessing and using GameLearnPro (GLP), you agree to be bound by these Terms and Conditions. GLP is an educational platform that combines learning with gamification elements to enhance the educational experience. These terms govern your use of our interactive learning challenges, gamified rewards system, and all other features of the platform.</p>
                        </div>

                        <div>
                            <h2 id="accounts" class="text-xl font-semibold text-emerald-300 mt-1 mb-3 flex items-center">
                                <span class="text-emerald-400 mr-2 font-bold">2</span>
                                User Accounts
                            </h2>
                            <p class="text-sm">When creating a GameLearnPro account, you must provide accurate information. Student accounts may be linked to educational institutions and may require verification. You are responsible for maintaining the confidentiality of your account credentials and for all activities that occur under your account.</p>
                            <p class="text-sm mt-2">Your GLP account tracks your learning progress, achievements, points, and rewards. This data is used to personalize your learning experience and provide appropriate challenges based on your skill level.</p>
                        </div>

                        <div>
                            <h2 id="gamification" class="text-xl font-semibold text-emerald-300 mt-1 mb-3 flex items-center">
                                <span class="text-emerald-400 mr-2 font-bold">3</span>
                                Gamification System
                            </h2>
                            <p class="text-sm">GameLearnPro features a comprehensive gamification system including points, badges, achievements, daily rewards, and level progression. These elements are designed to motivate learning and engagement.</p>
                            <p class="text-sm mt-2">Points earned through the platform may be converted to rewards according to our current policies. Eligibility for rewards may vary based on your geographic location and applicable laws.</p>
                        </div>

                        <div>
                            <h2 id="content" class="text-xl font-semibold text-emerald-300 mt-1 mb-3 flex items-center">
                                <span class="text-emerald-400 mr-2 font-bold">4</span>
                                Content & Conduct
                            </h2>
                            <p class="text-sm">GameLearnPro provides educational content, challenges, and interactive learning materials. When participating in forums, submitting solutions, or creating content within the platform, you must adhere to our community guidelines.</p>
                            <p class="text-sm mt-2">Prohibited conduct includes cheating on challenges, sharing solution code outside of permitted contexts, harassment of other users, and any attempt to manipulate the gamification system.</p>
                        </div>

                        <div>
                            <h2 id="intellectual" class="text-xl font-semibold text-emerald-300 mt-1 mb-3 flex items-center">
                                <span class="text-emerald-400 mr-2 font-bold">5</span>
                                Intellectual Property
                            </h2>
                            <p class="text-sm">All content provided through GameLearnPro, including challenges, learning materials, graphics, and software, is owned by GameLearnPro or its licensors and is protected by intellectual property laws.</p>
                            <p class="text-sm mt-2">Solutions you submit to challenges remain your intellectual property, but you grant GameLearnPro a license to use, store, and analyze your submissions for platform improvement and educational purposes.</p>
                        </div>



                        <div>
                            <h2 id="termination" class="text-xl font-semibold text-emerald-300 mt-1 mb-3 flex items-center">
                                <span class="text-emerald-400 mr-2 font-bold">6</span>
                                Termination
                            </h2>
                            <p class="text-sm">GameLearnPro may suspend or terminate your account for violations of these Terms, including cheating, inappropriate conduct, or other violations. Upon termination, you may lose access to your account, including any accumulated points, rewards, or achievements.</p>
                        </div>

                        <div class="md:col-span-2">
                            <h2 id="changes" class="text-xl font-semibold text-emerald-300 mt-1 mb-3 flex items-center">
                                <span class="text-emerald-400 mr-2 font-bold">7</span>
                                Changes to Terms
                            </h2>
                            <p class="text-sm">GameLearnPro may update these Terms at any time. For significant changes, we will provide notice through the platform or via email. Your continued use of GameLearnPro after such changes constitutes acceptance of the updated Terms.</p>
                        </div>

                        <div>
                            <h2 id="liability" class="text-xl font-semibold text-emerald-300 mt-1 mb-3 flex items-center">
                                <span class="text-emerald-400 mr-2 font-bold">8</span>
                                Limitation of Liability
                            </h2>
                            <p class="text-sm">GameLearnPro strives to provide accurate educational content, but makes no warranties about the completeness or reliability of the platform. We are not liable for any damages arising from your use of the service, including interruptions in service or loss of data.</p>
                        </div>
                    </div>
                </div>

            <!-- Return to login button -->
            <div class="mt-6 text-center">
                <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-500 active:bg-emerald-700 focus:outline-none focus:border-emerald-700 focus:ring focus:ring-emerald-200 disabled:opacity-25 transition">
                    Return to Login
                </a>
            </div>
        </div>
    </div>
</x-layouts.guest>