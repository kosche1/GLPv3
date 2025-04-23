<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
        <style>
            .hero-pattern {
                background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23202020' fill-opacity='0.4'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            }
        </style>
    </head>
    <body class="min-h-screen bg-zinc-900 antialiased">
        <!-- Animated Background -->
        <div class="fixed inset-0 hero-pattern opacity-30 -z-10"></div>
        <div class="fixed inset-0 overflow-hidden pointer-events-none -z-10">
            <!-- Glowing orbs -->
            <div class="absolute top-1/4 left-1/4 w-64 h-64 rounded-full bg-emerald-500/10 filter blur-3xl animate-pulse-slow"></div>
            <div class="absolute bottom-1/3 right-1/3 w-96 h-96 rounded-full bg-blue-500/10 filter blur-3xl animate-pulse-slow animation-delay-1000"></div>
            <div class="absolute top-2/3 left-1/2 w-72 h-72 rounded-full bg-purple-500/10 filter blur-3xl animate-pulse-slow animation-delay-2000"></div>
        </div>



        <!-- Main content -->
        <main class="pt-12">
            {{ $slot }}
        </main>

        @fluxScripts
    </body>
</html>
