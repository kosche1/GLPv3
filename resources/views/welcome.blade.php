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
                        <a href="#testimonials" class="text-neutral-400 hover:text-white transition-colors">Testimonials</a>

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

            <!-- Technologies Section -->
            <div class="w-full max-w-6xl mb-20">
                <h2 class="text-3xl font-bold text-white mb-8 text-center">Technologies We Teach</h2>

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
                    @foreach($technologies as $tech)
                    <!-- Technology: {{ $tech['name'] }} -->
                    <div class="flex flex-col items-center p-4 rounded-xl border border-neutral-700 bg-neutral-800/50 hover:border-{{ $tech['color'] }}-500/30 hover:bg-neutral-800 transition-all duration-300 group">
                        <div class="w-16 h-16 rounded-full bg-{{ $tech['color'] }}-500/10 flex items-center justify-center mb-3 group-hover:bg-{{ $tech['color'] }}-500/20 transition-colors">
                            @if($tech['icon'] == 'javascript')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-{{ $tech['color'] }}-400" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M0 0h24v24H0V0zm22.034 18.276c-.175-1.095-.888-2.015-3.003-2.873-.736-.345-1.554-.585-1.797-1.14-.091-.33-.105-.51-.046-.705.15-.646.915-.84 1.515-.66.39.12.75.42.976.9 1.034-.676 1.034-.676 1.755-1.125-.27-.42-.404-.601-.586-.78-.63-.705-1.469-1.065-2.834-1.034l-.705.089c-.676.165-1.32.525-1.71 1.005-1.14 1.291-.811 3.541.569 4.471 1.365 1.02 3.361 1.244 3.616 2.205.24 1.17-.87 1.545-1.966 1.41-.811-.18-1.26-.586-1.755-1.336l-1.83 1.051c.21.48.45.689.81 1.109 1.74 1.756 6.09 1.666 6.871-1.004.029-.09.24-.705.074-1.65l.046.067zm-8.983-7.245h-2.248c0 1.938-.009 3.864-.009 5.805 0 1.232.063 2.363-.138 2.711-.33.689-1.18.601-1.566.48-.396-.196-.597-.466-.83-.855-.063-.105-.11-.196-.127-.196l-1.825 1.125c.305.63.75 1.172 1.324 1.517.855.51 2.004.675 3.207.405.783-.226 1.458-.691 1.811-1.411.51-.93.402-2.07.397-3.346.012-2.054 0-4.109 0-6.179l.004-.056z"/>
                            </svg>
                            @elseif($tech['icon'] == 'python')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-{{ $tech['color'] }}-400" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M14.25.18l.9.2.73.26.59.3.45.32.34.34.25.34.16.33.1.3.04.26.02.2-.01.13V8.5l-.05.63-.13.55-.21.46-.26.38-.3.31-.33.25-.35.19-.35.14-.33.1-.3.07-.26.04-.21.02H8.77l-.69.05-.59.14-.5.22-.41.27-.33.32-.27.35-.2.36-.15.37-.1.35-.07.32-.04.27-.02.21v3.06H3.17l-.21-.03-.28-.07-.32-.12-.35-.18-.36-.26-.36-.36-.35-.46-.32-.59-.28-.73-.21-.88-.14-1.05-.05-1.23.06-1.22.16-1.04.24-.87.32-.71.36-.57.4-.44.42-.33.42-.24.4-.16.36-.1.32-.05.24-.01h.16l.06.01h8.16v-.83H6.18l-.01-2.75-.02-.37.05-.34.11-.31.17-.28.25-.26.31-.23.38-.2.44-.18.51-.15.58-.12.64-.1.71-.06.77-.04.84-.02 1.27.05zm-6.3 1.98l-.23.33-.08.41.08.41.23.34.33.22.41.09.41-.09.33-.22.23-.34.08-.41-.08-.41-.23-.33-.33-.22-.41-.09-.41.09zm13.09 3.95l.28.06.32.12.35.18.36.27.36.35.35.47.32.59.28.73.21.88.14 1.04.05 1.23-.06 1.23-.16 1.04-.24.86-.32.71-.36.57-.4.45-.42.33-.42.24-.4.16-.36.09-.32.05-.24.02-.16-.01h-8.22v.82h5.84l.01 2.76.02.36-.05.34-.11.31-.17.29-.25.25-.31.24-.38.2-.44.17-.51.15-.58.13-.64.09-.71.07-.77.04-.84.01-1.27-.04-1.07-.14-.9-.2-.73-.25-.59-.3-.45-.33-.34-.34-.25-.34-.16-.33-.1-.3-.04-.25-.02-.2.01-.13v-5.34l.05-.64.13-.54.21-.46.26-.38.3-.32.33-.24.35-.2.35-.14.33-.1.3-.06.26-.04.21-.02.13-.01h5.84l.69-.05.59-.14.5-.21.41-.28.33-.32.27-.35.2-.36.15-.36.1-.35.07-.32.04-.28.02-.21V6.07h2.09l.14.01zm-6.47 14.25l-.23.33-.08.41.08.41.23.33.33.23.41.08.41-.08.33-.23.23-.33.08-.41-.08-.41-.23-.33-.33-.23-.41-.08-.41.08z"/>
                            </svg>
                            @elseif($tech['icon'] == 'java')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-{{ $tech['color'] }}-400" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M8.851 18.56s-.917.534.653.714c1.902.218 2.874.187 4.969-.211 0 0 .552.346 1.321.646-4.699 2.013-10.633-.118-6.943-1.149M8.276 15.933s-1.028.761.542.924c2.032.209 3.636.227 6.413-.308 0 0 .384.389.987.602-5.679 1.661-12.007.13-7.942-1.218M13.116 11.475c1.158 1.333-.304 2.533-.304 2.533s2.939-1.518 1.589-3.418c-1.261-1.772-2.228-2.652 3.007-5.688 0-.001-8.216 2.051-4.292 6.573M19.33 20.504s.679.559-.747.991c-2.712.822-11.288 1.069-13.669.033-.856-.373.75-.89 1.254-.998.527-.114.828-.93.828-.93-3.514 1.582-5.979 2.225-3.842 3.183 5.819 2.615 14.944 1.408 16.176-2.278M9.292 13.21s-2.807.671-3.556.671c-5.111 0-2.226-2.873-.881-3.063.452-.065.732-.098 1.321-.098-1.489-.527-2.607 1.118-1.12 1.603.787.257 2.427.402 4.236-.113M17.127 17.208c4.949-2.572 2.659-5.054 1.063-4.717-.393.081-.561.143-.561.143s.144-.226.42-.323c3.136-1.103 5.546 3.28-1.019 5.02 0 .001.076-.067.097-.123M13.789 0s2.74 2.736-2.598 6.947c-4.275 3.373-3.199 5.293 0 7.75-5.16-4.667-8.96-8.788-6.417-12.636C7.703-.529 11.996.787 13.789 0M9.346 25.146c4.27.271 10.823-.15 10.974-2.145 0 0-.299.756-3.525 1.357-3.644.677-8.142.598-10.809.164 0 0 .547.453 3.36.624"/>
                            </svg>
                            @elseif($tech['icon'] == 'csharp')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-{{ $tech['color'] }}-400" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M11.5 15.97l.41 2.44c-.26.14-.68.27-1.24.39-.57.13-1.24.2-2.01.2-2.21-.04-3.87-.7-4.98-1.96C2.56 15.77 2 14.16 2 12.21c.05-2.31.72-4.08 2-5.32C5.32 5.64 6.96 5 8.94 5c.75 0 1.4.07 1.94.19s.94.25 1.2.4l-.58 2.49-1.06-.34c-.4-.1-.86-.15-1.39-.15-1.16-.01-2.12.36-2.87 1.1-.76.73-1.15 1.85-1.18 3.34 0 1.36.37 2.42 1.08 3.2.71.77 1.71 1.17 2.99 1.18l1.33-.12c.43-.08.79-.19 1.1-.32M13.89 19l.61-4H13l.34-2h1.5l.32-2h-1.5L14 9h1.5l.61-4h2l-.61 4h1l.61-4h2l-.61 4H22l-.34 2h-1.5l-.32 2h1.5L21 15h-1.5l-.61 4h-2l.61-4h-1l-.61 4h-2m2.95-6h1l.32-2h-1l-.32 2z"/>
                            </svg>
                            @elseif($tech['icon'] == 'php')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-{{ $tech['color'] }}-400" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 6.453v-.008c-1.826 0-3.418.217-4.847.599-.728.195-1.391.437-1.955.718-.564.282-1.072.618-1.401 1.004-.33.386-.497.796-.497 1.23 0 .435.167.845.497 1.23.329.386.837.722 1.401 1.004.564.281 1.227.523 1.955.718 1.429.382 3.021.599 4.847.599 1.826 0 3.418-.217 4.847-.599.728-.195 1.391-.437 1.955-.718.564-.282 1.072-.618 1.401-1.004.33-.385.497-.795.497-1.23 0-.434-.167-.844-.497-1.23-.329-.386-.837-.722-1.401-1.004-.564-.281-1.227-.523-1.955-.718-1.429-.382-3.021-.599-4.847-.599zM5.953 12.264c-.18.062-.35.129-.51.2-.564.282-1.072.618-1.401 1.004-.33.386-.497.796-.497 1.23 0 .435.167.845.497 1.23.329.386.837.722 1.401 1.004.564.281 1.227.523 1.955.718 1.429.382 3.021.599 4.847.599 1.826 0 3.418-.217 4.847-.599.728-.195 1.391-.437 1.955-.718.564-.282 1.072-.618 1.401-1.004.33-.385.497-.795.497-1.23 0-.434-.167-.844-.497-1.23-.329-.386-.837-.722-1.401-1.004-.16-.071-.33-.138-.51-.2.006.037.01.074.01.112 0 .434-.167.844-.497 1.23-.329.386-.837.722-1.401 1.004-.564.281-1.227.523-1.955.718-1.429.382-3.021.599-4.847.599-1.826 0-3.418-.217-4.847-.599-.728-.195-1.391-.437-1.955-.718-.564-.282-1.072-.618-1.401-1.004-.33-.386-.497-.796-.497-1.23 0-.038.004-.075.01-.112zM5.953 16.264c-.18.062-.35.129-.51.2-.564.282-1.072.618-1.401 1.004-.33.386-.497.796-.497 1.23 0 .435.167.845.497 1.23.329.386.837.722 1.401 1.004.564.281 1.227.523 1.955.718 1.429.382 3.021.599 4.847.599 1.826 0 3.418-.217 4.847-.599.728-.195 1.391-.437 1.955-.718.564-.282 1.072-.618 1.401-1.004.33-.385.497-.795.497-1.23 0-.434-.167-.844-.497-1.23-.329-.386-.837-.722-1.401-1.004-.16-.071-.33-.138-.51-.2.006.037.01.074.01.112 0 .434-.167.844-.497 1.23-.329.386-.837.722-1.401 1.004-.564.281-1.227.523-1.955.718-1.429.382-3.021.599-4.847.599-1.826 0-3.418-.217-4.847-.599-.728-.195-1.391-.437-1.955-.718-.564-.282-1.072-.618-1.401-1.004-.33-.386-.497-.796-.497-1.23 0-.038.004-.075.01-.112zM7.053 3.106c-1.543.412-2.889.981-3.962 1.682-.537.35-1.003.744-1.335 1.177-.332.433-.5.9-.5 1.381v10.308c0 .481.168.948.5 1.381.332.433.798.827 1.335 1.177 1.073.701 2.419 1.27 3.962 1.682 1.543.412 3.262.646 5.053.646 1.791 0 3.51-.234 5.053-.646 1.543-.412 2.889-.981 3.962-1.682.537-.35 1.003-.744 1.335-1.177.332-.433.5-.9.5-1.381V7.346c0-.481-.168-.948-.5-1.381-.332-.433-.798-.827-1.335-1.177-1.073-.701-2.419-1.27-3.962-1.682-1.543-.412-3.262-.646-5.053-.646-1.791 0-3.51.234-5.053.646zm0 1.026c1.487-.397 3.133-.622 4.841-.622 1.708 0 3.354.225 4.841.622 1.487.397 2.74.935 3.68 1.554.47.309.84.635 1.077.942.237.307.35.603.35.872v10.308c0 .269-.113.565-.35.872-.237.307-.607.633-1.077.942-.94.619-2.193 1.157-3.68 1.554-1.487.397-3.133.622-4.841.622-1.708 0-3.354-.225-4.841-.622-1.487-.397-2.74-.935-3.68-1.554-.47-.309-.84-.635-1.077-.942-.237-.307-.35-.603-.35-.872V7.5c0-.269.113-.565.35-.872.237-.307.607-.633 1.077-.942.94-.619 2.193-1.157 3.68-1.554z"/>
                            </svg>
                            @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-{{ $tech['color'] }}-400" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M4 3h16a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1zm1 2v14h14V5H5zm2 2h10v2H7V7zm0 4h10v2H7v-2zm0 4h5v2H7v-2z"/>
                            </svg>
                            @endif
                        </div>
                        <span class="text-white font-medium text-center">{{ $tech['name'] }}</span>
                        <span class="text-xs text-{{ $tech['color'] }}-400 mt-1">{{ $tech['count'] }} courses</span>
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
            <div id="testimonials" class="max-w-4xl w-full mb-20">
                <h2 class="text-3xl font-bold text-white mb-8 text-center">What Our Students Say</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Testimonial 1 -->
                    <div class="p-6 rounded-xl border border-neutral-700 bg-linear-to-br from-neutral-800 to-neutral-900 transition-all duration-300 hover:border-emerald-500/30">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 rounded-full bg-emerald-500/20 flex items-center justify-center mr-4 text-emerald-400 font-bold">JS</div>
                            <div>
                                <h4 class="text-white font-medium">John Smith</h4>
                                <p class="text-neutral-400 text-sm">Computer Science Student</p>
                            </div>
                        </div>
                        <p class="text-neutral-300 italic">"The gamified approach to learning programming has completely transformed how I study. The challenges are engaging and the reward system keeps me motivated."</p>
                        <div class="mt-4 text-emerald-400">★★★★★</div>
                    </div>

                    <!-- Testimonial 2 -->
                    <div class="p-6 rounded-xl border border-neutral-700 bg-linear-to-br from-neutral-800 to-neutral-900 transition-all duration-300 hover:border-emerald-500/30">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 rounded-full bg-emerald-500/20 flex items-center justify-center mr-4 text-emerald-400 font-bold">AR</div>
                            <div>
                                <h4 class="text-white font-medium">Amanda Rodriguez</h4>
                                <p class="text-neutral-400 text-sm">Web Development Student</p>
                            </div>
                        </div>
                        <p class="text-neutral-300 italic">"I've tried many learning platforms, but GLP stands out with its interactive challenges and supportive community. I've improved my skills faster than I thought possible."</p>
                        <div class="mt-4 text-emerald-400">★★★★★</div>
                    </div>
                </div>
            </div>

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

            <!-- Newsletter -->
            <div class="w-full max-w-4xl mb-20">
                <div class="p-8 rounded-2xl bg-linear-to-r from-emerald-500/10 to-blue-500/10 border border-emerald-500/20">
                    <h3 class="text-2xl font-bold text-white mb-4 text-center">Stay Updated</h3>
                    <p class="text-neutral-400 text-center mb-6">Subscribe to our newsletter for the latest courses, challenges, and learning tips.</p>
                    <form class="flex flex-col sm:flex-row gap-4 max-w-xl mx-auto">
                        <input type="email" placeholder="Enter your email" class="flex-1 px-4 py-3 rounded-xl bg-white/5 border border-neutral-700 text-white placeholder-neutral-500 focus:outline-hidden focus:border-emerald-500"/>
                        <button type="submit" class="px-6 py-3 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white font-semibold transition-colors">Subscribe</button>
                    </form>
                </div>
            </div>

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