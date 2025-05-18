<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
        <style>
            .hero-pattern {
                background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M54.627 0l.83.828-1.415 1.415L51.8 0h2.827zM5.373 0l-.83.828L5.96 2.243 8.2 0H5.374zM48.97 0l3.657 3.657-1.414 1.414L46.143 0h2.828zM11.03 0L7.372 3.657 8.787 5.07 13.857 0H11.03zm32.284 0L49.8 6.485 48.384 7.9l-7.9-7.9h2.83zM16.686 0L10.2 6.485 11.616 7.9l7.9-7.9h-2.83zm20.97 0l9.315 9.314-1.414 1.414L34.828 0h2.83zM22.344 0L13.03 9.314l1.414 1.414L25.172 0h-2.83zM32 0l12.142 12.142-1.414 1.414L30 .828 17.272 13.556l-1.414-1.414L28 0h4zM.284 0l28 28-1.414 1.414L0 2.544v2.83L26.272 32l-1.414 1.414-28-28V0h3.428zM60 0v3.428L32 32l-1.414-1.414L56.97 3.428V0h3.03z' fill='rgba(0, 255, 157, 0.05)' fill-rule='evenodd'/%3E%3C/svg%3E");
            }
            @keyframes float {
                0% { transform: translateY(0px); }
                50% { transform: translateY(-20px); }
                100% { transform: translateY(0px); }
            }
            .animate-float {
                animation: float 6s ease-in-out infinite;
            }
            .animation-delay-2000 {
                animation-delay: 2s;
            }
            .animation-delay-4000 {
                animation-delay: 4s;
            }
        </style>
    </head>
    <body class="min-h-screen bg-zinc-900 antialiased">
        <!-- Loading Screen -->
        <x-loading-screen />

        <!-- Animated Background -->
        <!-- <div class="fixed inset-0 hero-pattern opacity-30 z-0"></div>
        <div class="fixed inset-0 overflow-hidden pointer-events-none z-0"> -->
            <!-- Glowing orbs -->
            <!-- <div class="absolute top-1/4 left-1/4 w-64 h-64 rounded-full bg-emerald-500/10 filter blur-3xl animate-pulse-slow"></div>
            <div class="absolute bottom-1/3 right-1/3 w-96 h-96 rounded-full bg-blue-500/10 filter blur-3xl animate-pulse-slow animation-delay-2000"></div>
            <div class="absolute top-2/3 left-1/2 w-72 h-72 rounded-full bg-purple-500/10 filter blur-3xl animate-pulse-slow animation-delay-4000"></div>
        </div> -->

        <!-- Navigation -->
        <nav class="fixed top-0 left-0 right-0 z-50 bg-zinc-900/80 backdrop-blur-lg border-b border-neutral-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-emerald-500/20 rounded-lg flex items-center justify-center">
                            <x-app-logo-icon class="h-5 w-5 text-emerald-400" />
                        </div>
                        <span class="text-white font-semibold">Gamified Learning Platform</span>
                    </div>
                    <div class="flex items-center gap-5">
                        <!-- Navigation Links -->
                        <a href="#features" class="text-neutral-400 hover:text-white transition-colors">Features</a>
                        <a href="#how-it-works" class="text-neutral-400 hover:text-white transition-colors">How It Works</a>
                        <a href="#courses" class="text-neutral-400 hover:text-white transition-colors">Courses</a>
                        <!-- <a href="#testimonials" class="text-neutral-400 hover:text-white transition-colors">Testimonials</a> -->

                        <!-- CTA Buttons -->
                        @auth
                            <a href="{{ route('dashboard') }}" class="px-5 py-1.5 text-sm rounded-lg bg-emerald-500 hover:bg-emerald-600 text-white font-semibold text-center transition-colors duration-300 flex items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="px-5 py-1.5 text-sm rounded-lg border-2 border-emerald-500 bg-emerald-500 text-white font-semibold text-center transition-all duration-300 hover:bg-emerald-600 shadow-lg flex items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                </svg>
                                Login
                            </a>

                            <a href="{{ route('register') }}" class="px-5 py-1.5 text-sm rounded-lg border-2 border-emerald-500 bg-emerald-500 text-white font-semibold text-center transition-all duration-300 hover:bg-emerald-600 shadow-md flex items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                                Register
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="relative min-h-screen flex flex-col items-center justify-center p-4 sm:p-8 z-10">
            <!-- Logo and Header -->
            <div class="text-center mb-8 pt-20">
                <div class="flex justify-center mb-4">
                    <div class="relative animate-float">
                        <div class="absolute -inset-0.5 bg-linear-to-r from-emerald-500 to-blue-500 rounded-full blur-sm opacity-75 animate-pulse-slow"></div>
                        <div class="relative w-24 h-24 bg-zinc-900 rounded-full flex items-center justify-center border-2 border-emerald-500/50">
                            <x-app-logo-icon class="h-14 w-14 text-emerald-400" />
                        </div>
                    </div>
                </div>
                <h1 class="text-4xl sm:text-6xl font-bold text-white mb-4">Transform Your Learning with <span class="text-transparent bg-clip-text bg-linear-to-r from-emerald-400 to-blue-500">GLP</span></h1>

                <div class="flex flex-col md:flex-row justify-center gap-6 mb-6 max-w-4xl mx-auto">
                    <div class="bg-zinc-800/50 p-4 rounded-xl border border-emerald-500/30 flex-1">
                        <h3 class="text-xl font-bold text-emerald-400 mb-1"><span class="text-2xl">G</span>ame</h3>
                        <p class="text-neutral-300">Complete challenges, earn points, and unlock achievements as you progress through interactive learning paths.</p>
                    </div>
                    <div class="bg-zinc-800/50 p-4 rounded-xl border border-blue-500/30 flex-1">
                        <h3 class="text-xl font-bold text-blue-400 mb-1"><span class="text-2xl">L</span>earn</h3>
                        <p class="text-neutral-300">Gain valuable knowledge and practical skills through our expertly crafted courses and real-world projects.</p>
                    </div>
                    <div class="bg-zinc-800/50 p-4 rounded-xl border border-purple-500/30 flex-1">
                        <h3 class="text-xl font-bold text-purple-400 mb-1"><span class="text-2xl">P</span>ro</h3>
                        <p class="text-neutral-300">Become a professional with industry-relevant expertise that employers value and recognize.</p>
                    </div>
                </div>

                <p class="text-xl text-neutral-400 max-w-2xl mx-auto mb-4">Master new skills through gamified challenges, earn rewards, and track your progress in a fun, engaging environment.</p>
                <p class="text-lg text-emerald-400 font-medium max-w-2xl mx-auto mb-8">Join thousands of learners who've leveled up their skills with our platform.</p>
                <div class="flex flex-wrap justify-center gap-8 text-center">
                    <div class="bg-zinc-800/50 p-6 rounded-xl border border-neutral-700">
                        <div class="text-3xl font-bold text-emerald-400 mb-2">{{ number_format($stats['users']) }}+</div>
                        <div class="text-neutral-400">Active Learners</div>
                    </div>
                    <div class="bg-zinc-800/50 p-6 rounded-xl border border-neutral-700">
                        <div class="text-3xl font-bold text-blue-400 mb-2">{{ number_format($stats['courses']) }}+</div>
                        <div class="text-neutral-400">Courses</div>
                    </div>
                    <div class="bg-zinc-800/50 p-6 rounded-xl border border-neutral-700">
                        <div class="text-3xl font-bold text-purple-400 mb-2">{{ number_format($stats['completedTasks']) }}+</div>
                        <div class="text-neutral-400">Tasks Completed</div>
                    </div>
                    <div class="bg-zinc-800/50 p-6 rounded-xl border border-neutral-700">
                        <div class="text-3xl font-bold text-amber-400 mb-2">{{ number_format($stats['achievements']) }}+</div>
                        <div class="text-neutral-400">Achievements Earned</div>
                    </div>
                </div>
            </div>

            <!-- How It Works Section -->
            <div id="how-it-works" class="w-full max-w-6xl mb-20">
                <h2 class="text-3xl font-bold text-white mb-8 text-center">How It Works</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($learningPaths as $path)
                    <!-- Step {{ $path['step'] }} -->
                    <div class="relative flex flex-col items-center text-center">
                        <div class="absolute -z-10 top-0 left-1/2 transform -translate-x-1/2 w-12 h-12 rounded-full bg-emerald-500/20 blur-xl"></div>
                        <div class="w-16 h-16 rounded-full bg-emerald-500/10 border border-emerald-500/30 flex items-center justify-center mb-4">
                            <span class="text-2xl font-bold text-emerald-400">{{ $path['step'] }}</span>
                        </div>
                        <h3 class="text-xl font-semibold text-white mb-2">{{ $path['title'] }}</h3>
                        <p class="text-neutral-400">{{ $path['description'] }}</p>
                        <!-- Connector line (visible only on desktop) -->
                        @if($path['step'] < count($learningPaths))
                        <div class="hidden md:block absolute top-8 left-[calc(50%+3rem)] w-[calc(100%-6rem)] h-0.5 bg-gradient-to-r from-emerald-500/50 to-transparent"></div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Features Grid -->
            <div id="features" class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-6xl w-full mb-20">
                <!-- Feature Card 1 -->
                <div class="group p-6 rounded-xl border border-neutral-700 bg-linear-to-br from-neutral-800 to-neutral-900 transition-all duration-300 hover:scale-[1.02] hover:shadow-lg hover:shadow-emerald-900/20 hover:border-emerald-500/30">
                    <div class="p-3 bg-emerald-500/10 rounded-lg w-14 h-14 flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white group-hover:text-emerald-400 transition-colors duration-300">Interactive Challenges</h3>
                    <p class="text-neutral-400 mt-2">Engage with hands-on coding challenges designed to test and improve your skills in a fun, gamified environment.</p>
                </div>

                <!-- Feature Card 2 -->
                <div class="group p-6 rounded-xl border border-neutral-700 bg-linear-to-br from-neutral-800 to-neutral-900 transition-all duration-300 hover:scale-[1.02] hover:shadow-lg hover:shadow-emerald-900/20 hover:border-emerald-500/30">
                    <div class="p-3 bg-emerald-500/10 rounded-lg w-14 h-14 flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white group-hover:text-emerald-400 transition-colors duration-300">Comprehensive Courses</h3>
                    <p class="text-neutral-400 mt-2">Access a wide range of structured learning materials and courses to build your knowledge from beginner to advanced.</p>
                </div>

                <!-- Feature Card 3 -->
                <div class="group p-6 rounded-xl border border-neutral-700 bg-linear-to-br from-neutral-800 to-neutral-900 transition-all duration-300 hover:scale-[1.02] hover:shadow-lg hover:shadow-emerald-900/20 hover:border-emerald-500/30">
                    <div class="p-3 bg-emerald-500/10 rounded-lg w-14 h-14 flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white group-hover:text-emerald-400 transition-colors duration-300">Rewards & Achievements</h3>
                    <p class="text-neutral-400 mt-2">Earn points, badges, and level up as you complete challenges and courses, tracking your progress along the way.</p>
                </div>
            </div>

            <!-- Subjects we teach Section -->
            <div class="w-full max-w-6xl mb-20">
                <h2 class="text-3xl font-bold text-white mb-8 text-center">Subjects We Teach</h2>

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
                    @foreach($technologies as $tech)
                    <!-- Subject: {{ $tech['name'] }} from {{ $tech['strand'] }} -->
                    <div class="flex flex-col items-center p-4 rounded-xl border border-neutral-700 bg-neutral-800/50 hover:border-{{ $tech['color'] }}-500/30 hover:bg-neutral-800 transition-all duration-300 group">
                        <div class="w-16 h-16 rounded-full bg-{{ $tech['color'] }}-500/10 flex items-center justify-center mb-3 group-hover:bg-{{ $tech['color'] }}-500/20 transition-colors">
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
                        <span class="text-white font-medium text-center">{{ $tech['name'] }}</span>
                        <span class="text-xs text-{{ $tech['color'] }}-400 mt-1">{{ $tech['strand'] }} Track</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Featured Courses -->
            <div id="courses" class="w-full max-w-6xl mb-20">
                <h2 class="text-3xl font-bold text-white mb-8 text-center">Featured Courses</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($challenges as $challenge)
                    <div class="group bg-zinc-800 rounded-xl overflow-hidden border border-neutral-700 transition-all duration-300 hover:border-emerald-500/30">
                        <div class="aspect-video bg-neutral-900 relative overflow-hidden">
                            @if($challenge->image)
                                <img src="{{ asset($challenge->image) }}" alt="{{ $challenge->name }}" class="object-cover w-full h-full group-hover:scale-110 transition-transform duration-300"/>
                            @else
                                <div class="w-full h-full bg-emerald-500/10 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                    </svg>
                                </div>
                            @endif
                            <div class="absolute top-2 right-2 bg-amber-500/90 text-white text-xs font-medium px-2.5 py-1 rounded-full">{{ $challenge->difficulty_level }}</div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-white mb-2">{{ $challenge->name }}</h3>
                            <p class="text-neutral-400 text-sm mb-4">{{ $challenge->description }}</p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="text-emerald-400">{{ $challenge->points_reward }} Points</span>
                                    <span class="text-xs px-2 py-1 rounded-full bg-blue-500/10 text-blue-400">{{ $challenge->programming_language }}</span>
                                </div>
                                <div class="text-emerald-400">5.0 ★★★★★</div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

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

            <!-- CTA Banner -->
            <div class="w-full max-w-6xl mb-20">
                <div class="p-8 md:p-12 rounded-2xl bg-gradient-to-r from-emerald-500/20 to-blue-500/20 border border-emerald-500/30 relative overflow-hidden">
                    <!-- Background elements -->
                    <div class="absolute -top-24 -right-24 w-48 h-48 rounded-full bg-emerald-500/10 blur-3xl"></div>
                    <div class="absolute -bottom-24 -left-24 w-48 h-48 rounded-full bg-blue-500/10 blur-3xl"></div>

                    <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
                        <div class="text-center md:text-left">
                            <h3 class="text-2xl md:text-3xl font-bold text-white mb-2">Ready to Start Learning?</h3>
                            <p class="text-neutral-300 max-w-xl">Join {{ number_format($stats['users']) }}+ students who are already enhancing their skills through our gamified learning platform.</p>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="{{ route('register') }}" class="px-8 py-3 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white font-semibold text-center transition-colors shadow-lg shadow-emerald-500/20 flex items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 0L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Register Now
                            </a>
                            <a href="#courses" class="px-8 py-3 rounded-xl border-2 border-emerald-500 text-emerald-400 hover:bg-emerald-500 hover:text-white font-semibold text-center transition-all duration-300 flex items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Learn More
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            

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
            <div class="w-full max-w-6xl border-t border-neutral-800 pt-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                    <div>
                        <h4 class="text-white font-semibold mb-4">About GLP</h4>
                        <p class="text-neutral-400 text-sm">Empowering learners through interactive and gamified education.</p>
                    </div>
                    <div>
                        <h4 class="text-white font-semibold mb-4">Quick Links</h4>
                        <ul class="space-y-2 text-sm">
                            <li><a href="#" class="text-neutral-400 hover:text-emerald-400">Home</a></li>
                            <li><a href="#features" class="text-neutral-400 hover:text-emerald-400">Features</a></li>
                            <li><a href="#courses" class="text-neutral-400 hover:text-emerald-400">Courses</a></li>
                            <li><a href="#testimonials" class="text-neutral-400 hover:text-emerald-400">Testimonials</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-white font-semibold mb-4">Resources</h4>
                        <ul class="space-y-2 text-sm">
                            <li><a href="#" class="text-neutral-400 hover:text-emerald-400">Documentation</a></li>
                            <li><a href="#" class="text-neutral-400 hover:text-emerald-400">Blog</a></li>
                            <li><a href="#" class="text-neutral-400 hover:text-emerald-400">Support</a></li>
                            <li><a href="#" class="text-neutral-400 hover:text-emerald-400">FAQ</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-white font-semibold mb-4">Connect</h4>
                        <div class="flex space-x-4">
                            <a href="#" class="text-neutral-400 hover:text-emerald-400">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"></path>
                                </svg>
                            </a>
                            <a href="#" class="text-neutral-400 hover:text-emerald-400">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"></path>
                                </svg>
                            </a>
                            <a href="#" class="text-neutral-400 hover:text-emerald-400">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10c5.51 0 10-4.48 10-10S17.51 2 12 2zm6.605 4.61a8.502 8.502 0 011.93 5.314c-.281-.054-3.101-.629-5.943-.271-.065-.141-.12-.293-.184-.445a25.416 25.416 0 00-.564-1.236c3.145-1.28 4.577-3.124 4.761-3.362zM12 3.475c2.17 0 4.154.813 5.662 2.148-.152.216-1.443 1.941-4.48 3.08-1.399-2.57-2.95-4.675-3.189-5A8.687 8.687 0 0112 3.475zm-3.633.803a53.896 53.896 0 013.167 4.935c-3.992 1.063-7.517 1.04-7.896 1.04a8.581 8.581 0 014.729-5.975zM3.453 12.01v-.26c.37.01 4.512.065 8.775-1.215.25.477.477.965.694 1.453-.109.033-.228.065-.336.098-4.404 1.42-6.747 5.303-6.942 5.629a8.522 8.522 0 01-2.19-5.705zM12 20.547a8.482 8.482 0 01-5.239-1.8c.152-.315 1.888-3.656 6.703-5.337.022-.01.033-.01.054-.022a35.318 35.318 0 011.823 6.475 8.4 8.4 0 01-3.341.684zm4.761-1.465c-.086-.52-.542-3.015-1.659-6.084 2.679-.423 5.022.271 5.314.369a8.468 8.468 0 01-3.655 5.715z" clip-rule="evenodd"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="text-center text-neutral-500 text-sm border-t border-neutral-800 pt-8">
                    <p>&copy; {{ date('Y') }} Gamified Learning Platform. All rights reserved.</p>
                </div>
            </div>
        </div>


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
        </script>
    </body>
</html>