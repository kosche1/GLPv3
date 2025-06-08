<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
        <style>
            /* Discord-inspired design with green theme */
            :root {
                --discord-green: #00D26A;
                --discord-green-dark: #00B359;
                --discord-green-light: #4AE54A;
                --discord-green-darker: #0A5D2C;
                --discord-bg: #0F0F23;
                --discord-bg-light: #1A1A2E;
                --discord-text: #FFFFFF;
                --discord-text-muted: #B9BBBE;
            }

            body {
                background: linear-gradient(135deg, var(--discord-bg) 0%, #16213E 100%);
                overflow-x: hidden;
            }

            /* Floating decorative elements */
            .floating-stars {
                position: absolute;
                width: 100%;
                height: 100%;
                overflow: hidden;
                pointer-events: none;
            }

            .star {
                position: absolute;
                background: var(--discord-green);
                clip-path: polygon(50% 0%, 61% 35%, 98% 35%, 68% 57%, 79% 91%, 50% 70%, 21% 91%, 32% 57%, 2% 35%, 39% 35%);
                animation: twinkle 3s infinite ease-in-out;
            }

            .star-1 { width: 20px; height: 20px; top: 10%; left: 10%; animation-delay: 0s; }
            .star-2 { width: 15px; height: 15px; top: 20%; right: 15%; animation-delay: 1s; }
            .star-3 { width: 25px; height: 25px; top: 60%; left: 5%; animation-delay: 2s; }
            .star-4 { width: 18px; height: 18px; bottom: 20%; right: 10%; animation-delay: 0.5s; }
            .star-5 { width: 22px; height: 22px; top: 40%; right: 25%; animation-delay: 1.5s; }

            @keyframes twinkle {
                0%, 100% { opacity: 0.3; transform: scale(1) rotate(0deg); }
                50% { opacity: 1; transform: scale(1.2) rotate(180deg); }
            }

            @keyframes float {
                0% { transform: translateY(0px) rotate(0deg); }
                33% { transform: translateY(-20px) rotate(5deg); }
                66% { transform: translateY(-10px) rotate(-5deg); }
                100% { transform: translateY(0px) rotate(0deg); }
            }

            .animate-float {
                animation: float 6s ease-in-out infinite;
            }

            .animation-delay-2000 { animation-delay: 2s; }
            .animation-delay-4000 { animation-delay: 4s; }

            /* Curved section dividers */
            .curve-divider {
                position: absolute;
                bottom: 0;
                left: 0;
                width: 100%;
                overflow: hidden;
                line-height: 0;
                transform: rotate(180deg);
            }

            .curve-divider svg {
                position: relative;
                display: block;
                width: calc(100% + 1.3px);
                height: 60px;
            }

            .curve-divider .shape-fill {
                fill: var(--discord-green);
                opacity: 0.1;
            }

            /* Discord-style buttons */
            .discord-btn {
                background: var(--discord-green);
                color: white;
                font-weight: 600;
                padding: 16px 32px;
                border-radius: 28px;
                font-size: 16px;
                transition: all 0.2s ease;
                box-shadow: 0 8px 15px rgba(0, 210, 106, 0.2);
            }

            .discord-btn:hover {
                background: var(--discord-green-dark);
                transform: translateY(-2px);
                box-shadow: 0 12px 25px rgba(0, 210, 106, 0.3);
            }

            .discord-btn-outline {
                background: transparent;
                color: var(--discord-green);
                border: 2px solid var(--discord-green);
                font-weight: 600;
                padding: 14px 30px;
                border-radius: 28px;
                font-size: 16px;
                transition: all 0.2s ease;
            }

            .discord-btn-outline:hover {
                background: var(--discord-green);
                color: white;
                transform: translateY(-2px);
            }

            /* Scroll animations */
            .animate-on-scroll {
                opacity: 0;
                transform: translateY(30px);
                transition: opacity 0.8s ease-out, transform 0.8s ease-out;
            }

            .animate-fade-in {
                opacity: 1;
                transform: translateY(0);
            }

            /* Staggered animations */
            .stagger-children > *:nth-child(1) { transition-delay: 0.1s; }
            .stagger-children > *:nth-child(2) { transition-delay: 0.2s; }
            .stagger-children > *:nth-child(3) { transition-delay: 0.3s; }
            .stagger-children > *:nth-child(4) { transition-delay: 0.4s; }
            .stagger-children > *:nth-child(5) { transition-delay: 0.5s; }

            /* Character illustrations placeholder */
            .character-blob {
                width: 120px;
                height: 120px;
                background: linear-gradient(135deg, var(--discord-green), var(--discord-green-light));
                border-radius: 50% 40% 60% 30%;
                position: relative;
                animation: float 4s ease-in-out infinite;
            }

            .character-blob::before {
                content: '';
                position: absolute;
                top: 20%;
                left: 20%;
                width: 20px;
                height: 20px;
                background: white;
                border-radius: 50%;
                box-shadow: 30px 0 0 white, 15px 25px 0 #333;
            }

            /* Playful text styles */
            .discord-heading {
                font-size: clamp(2.5rem, 8vw, 5rem);
                font-weight: 800;
                line-height: 1.1;
                background: linear-gradient(135deg, var(--discord-green), var(--discord-green-light));
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            .discord-subheading {
                font-size: clamp(1.2rem, 4vw, 1.8rem);
                font-weight: 600;
                color: var(--discord-text-muted);
                line-height: 1.4;
            }

            /* Scrolling animation */
            @keyframes scroll {
                0% { transform: translateX(0); }
                100% { transform: translateX(-50%); }
            }

            .animate-scroll {
                animation: scroll 20s linear infinite;
            }

            /* Line clamp utility */
            .line-clamp-2 {
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }
        </style>
    </head>
    <body class="min-h-screen antialiased">
        <!-- Loading Screen -->
        <x-loading-screen />

        <!-- Floating Stars Background -->
        <div class="floating-stars">
            <div class="star star-1"></div>
            <div class="star star-2"></div>
            <div class="star star-3"></div>
            <div class="star star-4"></div>
            <div class="star star-5"></div>
        </div>

        <!-- Navigation -->
        <nav class="fixed top-0 left-0 right-0 z-50 bg-black/20 backdrop-blur-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-20">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-green-400 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                            <x-app-logo-icon class="h-6 w-6 text-white" />
                        </div>
                        <span class="text-white font-bold text-xl">GLP</span>
                    </div>

                    <div class="hidden md:flex items-center gap-8">
                        <!-- Navigation Links -->
                        <a href="#features" class="text-gray-300 hover:text-white transition-colors font-medium">Features</a>
                        <a href="#how-it-works" class="text-gray-300 hover:text-white transition-colors font-medium">How It Works</a>
                        <a href="#courses" class="text-gray-300 hover:text-white transition-colors font-medium">Courses</a>
                    </div>

                    <div class="flex items-center gap-4">
                        <!-- CTA Buttons -->
                        @auth
                            <a href="{{ route('dashboard') }}" class="discord-btn flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="discord-btn-outline">
                                Login
                            </a>
                            <a href="{{ route('register') }}" class="discord-btn">
                                Get Started
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="relative min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8 pt-20">
            <!-- Floating Characters -->
            <div class="absolute top-32 left-10 character-blob animate-float animation-delay-2000 hidden lg:block"></div>
            <div class="absolute top-40 right-16 character-blob animate-float animation-delay-4000 hidden lg:block"></div>
            <div class="absolute bottom-32 left-20 character-blob animate-float hidden lg:block"></div>

            <div class="max-w-6xl mx-auto text-center relative z-10">
                <!-- Main Headline -->
                <div class="animate-on-scroll">
                    <h1 class="discord-heading mb-6">
                        Learning that's all
                        <br>
                        <span class="relative">
                            fun & games
                            <svg class="absolute -bottom-2 left-0 w-full h-4" viewBox="0 0 400 20" fill="none">
                                <path d="M0 15 Q100 5 200 15 T400 15" stroke="var(--discord-green)" stroke-width="4" fill="none" stroke-linecap="round"/>
                            </svg>
                        </span>
                    </h1>
                </div>

                <!-- Subtitle -->
                <div class="animate-on-scroll">
                    <p class="discord-subheading max-w-3xl mx-auto mb-8">
                        GLP is great for mastering skills and chilling with challenges, or even building a worldwide learning community.
                        Customize your own space to learn, play, and level up.
                    </p>
                </div>

                <!-- CTA Buttons -->
                <div class="animate-on-scroll flex flex-col sm:flex-row gap-4 justify-center items-center mb-12">
                    @auth
                        <a href="{{ route('dashboard') }}" class="discord-btn text-lg px-8 py-4">
                            Open Dashboard
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="discord-btn text-lg px-8 py-4">
                            Start Learning for Free
                        </a>
                        <a href="{{ route('login') }}" class="discord-btn-outline text-lg px-8 py-4">
                            Open GLP in your browser
                        </a>
                    @endauth
                </div>

                <!-- Stats Section -->
                <div class="animate-on-scroll">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-4xl mx-auto">
                        <div class="text-center">
                            <div class="text-3xl md:text-4xl font-bold text-white mb-2">{{ number_format($stats['users']) }}+</div>
                            <div class="text-gray-400 font-medium">Active Learners</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl md:text-4xl font-bold text-white mb-2">{{ number_format($stats['courses']) }}+</div>
                            <div class="text-gray-400 font-medium">Courses</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl md:text-4xl font-bold text-white mb-2">{{ number_format($stats['completedTasks']) }}+</div>
                            <div class="text-gray-400 font-medium">Tasks Completed</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl md:text-4xl font-bold text-white mb-2">{{ number_format($stats['achievements']) }}+</div>
                            <div class="text-gray-400 font-medium">Achievements</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Curve Divider -->
            <div class="curve-divider">
                <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                    <path d="M985.66,92.83C906.67,72,823.78,31,743.84,14.19c-82.26-17.34-168.06-16.33-250.45.39-57.84,11.73-114,31.07-172,41.86A600.21,600.21,0,0,1,0,27.35V120H1200V95.8C1132.19,118.92,1055.71,111.31,985.66,92.83Z" class="shape-fill"></path>
                </svg>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="py-20 px-4 sm:px-6 lg:px-8 relative">
            <!-- Feature 1: Interactive Challenges -->
            <div class="max-w-7xl mx-auto mb-32">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div class="animate-on-scroll">
                        <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
                            Make your learning more fun
                        </h2>
                        <p class="text-xl text-gray-300 mb-8 leading-relaxed">
                            Use interactive challenges, gamified quests, leaderboards and more to add excitement to your learning journey.
                            Set your goals and track custom progress to show up in your learning path your way.
                        </p>
                    </div>
                    <div class="animate-on-scroll relative">
                        <!-- Placeholder for illustration -->
                        <div class="bg-gradient-to-br from-green-400/20 to-green-600/20 rounded-3xl p-8 h-80 flex items-center justify-center border border-green-500/20">
                            <div class="text-center">
                                <div class="w-24 h-24 bg-green-500 rounded-full mx-auto mb-4 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                    </svg>
                                </div>
                                <p class="text-white font-semibold">Interactive Learning</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Feature 2: Progress Tracking -->
            <div class="max-w-7xl mx-auto mb-32">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div class="animate-on-scroll lg:order-2">
                        <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
                            Track like you're in the same class
                        </h2>
                        <p class="text-xl text-gray-300 mb-8 leading-relaxed">
                            High quality progress tracking and low latency feedback makes it feel like you're studying with friends
                            while completing challenges, watching tutorials, reviewing notes, or idk doing homework or something.
                        </p>
                    </div>
                    <div class="animate-on-scroll lg:order-1 relative">
                        <!-- Placeholder for illustration -->
                        <div class="bg-gradient-to-br from-blue-400/20 to-purple-600/20 rounded-3xl p-8 h-80 flex items-center justify-center border border-blue-500/20">
                            <div class="text-center">
                                <div class="w-24 h-24 bg-blue-500 rounded-full mx-auto mb-4 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                </div>
                                <p class="text-white font-semibold">Progress Tracking</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Feature 3: Community Learning -->
            <div class="max-w-7xl mx-auto mb-32">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div class="animate-on-scroll">
                        <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
                            Join when you're ready, no need to wait
                        </h2>
                        <p class="text-xl text-gray-300 mb-8 leading-relaxed">
                            Easily hop in and out of study sessions or group challenges without having to schedule or invite anyone,
                            so your learning community lasts before, during, and after your study session.
                        </p>
                    </div>
                    <div class="animate-on-scroll relative">
                        <!-- Placeholder for illustration -->
                        <div class="bg-gradient-to-br from-purple-400/20 to-pink-600/20 rounded-3xl p-8 h-80 flex items-center justify-center border border-purple-500/20">
                            <div class="text-center">
                                <div class="w-24 h-24 bg-purple-500 rounded-full mx-auto mb-4 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <p class="text-white font-semibold">Community Learning</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Subjects Section -->
        <section class="py-20 px-4 sm:px-6 lg:px-8 bg-gradient-to-b from-transparent to-green-900/10">
            <div class="max-w-6xl mx-auto text-center">
                <div class="animate-on-scroll mb-16">
                    <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
                        See what subjects are around to learn
                    </h2>
                    <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                        See what's available, from programming to business, or just browse around.
                        For supported tracks, you can see what modules or specializations are available and directly jump in.
                    </p>
                </div>
                <br>

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6 animate-on-scroll stagger-children">
                    @foreach($technologies as $tech)
                    <div class="group bg-gray-800/50 backdrop-blur-sm rounded-2xl p-6 border border-gray-700/50 hover:border-green-500/50 transition-all duration-300 hover:transform hover:scale-105">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-{{ $tech['color'] }}-400/20 to-{{ $tech['color'] }}-600/20 flex items-center justify-center mb-4 group-hover:from-{{ $tech['color'] }}-400/30 group-hover:to-{{ $tech['color'] }}-600/30 transition-all">
                            @if($tech['icon'] == 'stem')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-{{ $tech['color'] }}-400" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 100-16 8 8 0 000 16zm1-8h4v2h-6V7h2v5z"/>
                            </svg>
                            @elseif($tech['icon'] == 'abm')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-{{ $tech['color'] }}-400" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M3 6l9 4v12l-9-4V6zm2-2v17l10 5V9L5 4zm14 2l-3 1.5v2.5l3-1.5V6zM5 4v2l4 2v-2L5 4zm14 6l-3 1.5v2.5l3-1.5V10zm-3 4.5V17l3-1.5v-2.5L16 14.5zM18 2L5 9l13 7V2zm-4 8l-9-4.5v9L14 19V10z"/>
                            </svg>
                            @elseif($tech['icon'] == 'humms')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-{{ $tech['color'] }}-400" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M21 8v12.993A1 1 0 0120.007 22H3.993A.993.993 0 013 21.008V2.992C3 2.455 3.449 2 4.002 2h10.995L21 8zm-2 1h-5V4H5v16h14V9zM8 7h3v2H8V7zm0 4h8v2H8v-2zm0 4h8v2H8v-2z"/>
                            </svg>
                            @elseif($tech['icon'] == 'he')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-{{ $tech['color'] }}-400" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M19 19V4h-4V3H5v16H3v2h12v-2h-3v-9h7v9h-2zm-6 0H7V5h6v14zm-3-8h-2v-2h2v2z"/>
                            </svg>
                            @elseif($tech['icon'] == 'ict')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-{{ $tech['color'] }}-400" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M4 3h16a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1zm1 2v14h14V5H5zm6.003 11L6 10.5l1-1 4 3.5 4-3.5 1 1-5 4.5z"/>
                            </svg>
                            @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-{{ $tech['color'] }}-400" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M4 3h16a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1zm1 2v14h14V5H5zm2 2h10v2H7V7zm0 4h10v2H7v-2zm0 4h5v2H7v-2z"/>
                            </svg>
                            @endif
                        </div>
                        <h3 class="text-white font-semibold text-center mb-1">{{ $tech['name'] }}</h3>
                        <p class="text-{{ $tech['color'] }}-400 text-sm text-center">{{ $tech['strand'] }} Track</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        <br>

        <!-- Featured Courses -->
        <section id="courses" class="py-20 px-4 sm:px-6 lg:px-8">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-16 animate-on-scroll">
                    <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
                        Always have something to learn together
                    </h2>
                    <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                        Watch tutorials, complete built-in challenges, listen to podcasts, or just scroll together and share knowledge.
                        Seamlessly learn, practice, review, and grow, all in one learning platform.
                    </p>
                </div>
                <br>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 animate-on-scroll stagger-children">
                    @foreach($challenges as $challenge)
                    <div class="group bg-gray-800/50 backdrop-blur-sm rounded-2xl overflow-hidden border border-gray-700/50 hover:border-green-500/50 transition-all duration-300 hover:transform hover:scale-105">
                        <div class="aspect-video bg-gray-900 relative overflow-hidden">
                            @if($challenge->image)
                                <img src="{{ asset($challenge->image) }}" alt="{{ $challenge->name }}" class="object-cover w-full h-full group-hover:scale-110 transition-transform duration-300"/>
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-green-500/20 to-blue-500/20 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                    </svg>
                                </div>
                            @endif
                            <div class="absolute top-3 right-3 bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full">{{ $challenge->difficulty_level }}</div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-white mb-3 group-hover:text-green-400 transition-colors">{{ $challenge->name }}</h3>
                            <p class="text-gray-400 text-sm mb-4 line-clamp-2">{{ $challenge->description }}</p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <span class="text-green-400 font-semibold">{{ $challenge->points_reward }} Points</span>
                                    <span class="text-xs px-2 py-1 rounded-full bg-blue-500/20 text-blue-400 font-medium">{{ $challenge->programming_language }}</span>
                                </div>
                                <div class="text-yellow-400 text-sm font-medium">★ 5.0</div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

            <!-- Testimonials -->
            <!-- <div id="testimonials" class="max-w-4xl w-full mb-20">
                <h2 class="text-3xl font-bold text-white mb-8 text-center">What Our Students Say</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6"> -->
                    <!-- Testimonial 1 -->
                    <!-- <div class="p-6 rounded-xl border border-neutral-700 bg-linear-to-br from-neutral-800 to-neutral-900 transition-all duration-300 hover:border-emerald-500/30">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 rounded-full bg-emerald-500/20 flex items-center justify-center mr-4 text-emerald-400 font-bold">JS</div>
                            <div>
                                <h4 class="text-white font-medium">John Smith</h4>
                                <p class="text-neutral-400 text-sm">Computer Science Student</p>
                            </div>
                        </div>
                        <p class="text-neutral-300 italic">"The gamified approach to learning programming has completely transformed how I study. The challenges are engaging and the reward system keeps me motivated."</p>
                        <div class="mt-4 text-emerald-400">★★★★★</div>
                    </div> -->

                    <!-- Testimonial 2 -->
                    <!-- <div class="p-6 rounded-xl border border-neutral-700 bg-linear-to-br from-neutral-800 to-neutral-900 transition-all duration-300 hover:border-emerald-500/30">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 rounded-full bg-emerald-500/20 flex items-center justify-center mr-4 text-emerald-400 font-bold">AR</div>
                            <div>
                                <h4 class="text-white font-medium">Amanda Rodriguez</h4>
                                <p class="text-neutral-400 text-sm">Web Development Student</p>
                            </div>
                        </div>
                        <p class="text-neutral-300 italic">"I've tried many learning platforms, but GLP stands out with its interactive challenges and supportive community. I've improved my skills faster than I thought possible."</p>
                        <div class="mt-4 text-emerald-400">★★★★★</div>
                    </div> -->
                <!-- </div>
            </div> -->

        <!-- Final CTA Section -->
        <section class="py-20 px-4 sm:px-6 lg:px-8 relative">
            <!-- Floating decorative elements -->
            <div class="absolute top-10 left-10 character-blob animate-float animation-delay-2000 hidden lg:block opacity-30"></div>
            <div class="absolute bottom-10 right-10 character-blob animate-float animation-delay-4000 hidden lg:block opacity-30"></div>
            <br>

            <div class="max-w-4xl mx-auto text-center">
                <div class="animate-on-scroll mb-12">
                    <h2 class="text-5xl md:text-6xl font-bold text-white mb-6">
                        You can't scroll anymore.
                        <br>
                        <span class="text-green-400">Better go learn.</span>
                    </h2>
                </div>

                <div class="animate-on-scroll">
                    @auth
                        <a href="{{ route('dashboard') }}" class="discord-btn text-xl px-12 py-6 inline-block">
                            Open Dashboard
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="discord-btn text-xl px-12 py-6 inline-block">
                            Start Learning for Free
                        </a>
                    @endauth
                </div>
                <br>

                <!-- Floating stars around CTA -->
                <div class="relative mt-16">
                    <div class="star absolute -top-8 -left-8 w-6 h-6"></div>
                    <div class="star absolute -top-4 right-12 w-4 h-4"></div>
                    <div class="star absolute -bottom-6 left-16 w-5 h-5"></div>
                    <div class="star absolute -bottom-8 -right-4 w-7 h-7"></div>
                </div>
            </div>
        </section>
        <br>


            {{-- <!-- Newsletter -->
            <div class="w-full max-w-4xl mb-20">
                <div class="p-8 rounded-2xl bg-linear-to-r from-emerald-500/10 to-blue-500/10 border border-emerald-500/20">
                    <h3 class="text-2xl font-bold text-white mb-4 text-center">Stay Updated</h3>
                    <p class="text-neutral-400 text-center mb-6">Subscribe to our newsletter for the latest courses, challenges, and learning tips.</p>
                    <form class="flex flex-col sm:flex-row gap-4 max-w-xl mx-auto">
                        <input type="email" placeholder="Enter your email" class="flex-1 px-4 py-3 rounded-xl bg-white/5 border border-neutral-700 text-white placeholder-neutral-500 focus:outline-hidden focus:border-emerald-500"/>
                        <button type="submit" class="px-6 py-3 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white font-semibold transition-colors">Subscribe</button>
                    </form>
                </div>
            </div> --}}

        <!-- Footer -->
        <footer class="py-16 px-4 sm:px-6 lg:px-8 bg-black/20 border-t border-gray-800/50">
            <br>
            <div class="max-w-6xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
                    <div>
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-8 h-8 bg-gradient-to-br from-green-400 to-green-600 rounded-lg flex items-center justify-center">
                                <x-app-logo-icon class="h-5 w-5 text-white" />
                            </div>
                            <span class="text-white font-bold text-lg">GLP</span>
                        </div>
                        <p class="text-gray-400 text-sm leading-relaxed">
                            Empowering learners through interactive and gamified education.
                            Join the future of learning today.
                        </p>
                    </div>

                    <div>
                        <h4 class="text-white font-semibold mb-4">Product</h4>
                        <ul class="space-y-3 text-sm">
                            <li><a href="#features" class="text-gray-400 hover:text-green-400 transition-colors">Features</a></li>
                            <li><a href="#courses" class="text-gray-400 hover:text-green-400 transition-colors">Courses</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-green-400 transition-colors">Challenges</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-green-400 transition-colors">Leaderboard</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="text-white font-semibold mb-4">Resources</h4>
                        <ul class="space-y-3 text-sm">
                            <li><a href="#" class="text-gray-400 hover:text-green-400 transition-colors">Documentation</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-green-400 transition-colors">Help Center</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-green-400 transition-colors">Community</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-green-400 transition-colors">Blog</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="text-white font-semibold mb-4">Connect</h4>
                        <div class="flex space-x-4 mb-4">
                            <a href="#" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center text-gray-400 hover:text-green-400 hover:bg-gray-700 transition-all">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"></path>
                                </svg>
                            </a>
                            <a href="#" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center text-gray-400 hover:text-green-400 hover:bg-gray-700 transition-all">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"></path>
                                </svg>
                            </a>
                            <a href="#" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center text-gray-400 hover:text-green-400 hover:bg-gray-700 transition-all">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-800/50 pt-8 text-center">
                    <p class="text-gray-500 text-sm">
                        &copy; {{ date('Y') }} Gamified Learning Platform. All rights reserved.
                    </p>
                </div>
            </div>
        </footer>


        @fluxScripts
        <script>
            // Smooth scroll for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                });
            });

            // Fallback to ensure loading screen disappears
            window.addEventListener('load', function() {
                setTimeout(function() {
                    const loadingScreen = document.getElementById('loading-screen');
                    if (loadingScreen) {
                        loadingScreen.style.opacity = '0';
                        setTimeout(function() {
                            loadingScreen.style.display = 'none';
                        }, 500);
                    }
                }, 300);
            });

            // Scroll animations
            document.addEventListener('DOMContentLoaded', function() {
                const animatedElements = document.querySelectorAll('.animate-on-scroll');

                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('animate-fade-in');
                            observer.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.1
                });

                animatedElements.forEach(element => {
                    observer.observe(element);
                });
            });
        </script>
    </body>
</html>