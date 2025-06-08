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
        
        <!-- Content -->
        <div class="flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10">
            <div class="flex w-full max-w-md flex-col gap-6">
                <div class="flex flex-col gap-6">
                <div class="rounded-xl border border-white/20 bg-black/20 backdrop-blur-lg shadow-xl shadow-black/10 dark:shadow-white/10 text-stone-800 dark:text-white p-4">
                        <div class="px-10 py-8">{{ $slot }}</div>
                    </div>
                </div>
            </div>
        </div>
        @fluxScripts
    </body>
</html>
