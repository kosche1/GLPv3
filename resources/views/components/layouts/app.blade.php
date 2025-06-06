<x-layouts.app.sidebar>
    @include('partials.head')
        <style>
            .hero-pattern {
                background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M54.627 0l.83.828-1.415 1.415L51.8 0h2.827zM5.373 0l-.83.828L5.96 2.243 8.2 0H5.374zM48.97 0l3.657 3.657-1.414 1.414L46.143 0h2.828zM11.03 0L7.372 3.657 8.787 5.07 13.857 0H11.03zm32.284 0L49.8 6.485 48.384 7.9l-7.9-7.9h2.83zM16.686 0L10.2 6.485 11.616 7.9l7.9-7.9h-2.83zm20.97 0l9.315 9.314-1.414 1.414L34.828 0h2.83zM22.344 0L13.03 9.314l1.414 1.414L25.172 0h-2.83zM32 0l12.142 12.142-1.414 1.414L30 .828 17.272 13.556l-1.414-1.414L28 0h4zM.284 0l28 28-1.414 1.414L0 2.544v2.83L26.272 32l-1.414 1.414-28-28V0h3.428zM60 0v3.428L32 32l-1.414-1.414L56.97 3.428V0h3.03z' fill='rgba(0, 255, 157, 0.05)' fill-rule='evenodd'/%3E%3C/svg%3E");
            }
        </style>

        <!-- Animated Background -->
        <div class="fixed inset-0 hero-pattern opacity-30 -z-10"></div>
        <div class="fixed inset-0 overflow-hidden pointer-events-none -z-10">
            <!-- Glowing orbs -->
            <div class="absolute top-1/4 left-1/4 w-64 h-64 rounded-full bg-emerald-500/10 filter blur-3xl animate-pulse-slow"></div>
            <div class="absolute bottom-1/3 right-1/3 w-96 h-96 rounded-full bg-blue-500/10 filter blur-3xl animate-pulse-slow animation-delay-1000"></div>
            <div class="absolute top-2/3 left-1/2 w-72 h-72 rounded-full bg-purple-500/10 filter blur-3xl animate-pulse-slow animation-delay-2000"></div>
        </div>
    <flux:main>
        {{ $slot }}
    </flux:main>

    @livewire('AiWidget')
    @auth
        @livewire('session-timeout')
        @livewire('welcome-modals')
        @livewire('recipe-approval-modal')
        @livewire('task-approval-notification-modal')
        @livewire('typing-test-approval-modal')
        @livewire('user-activity-history-modal')
    @endauth
</x-layouts.app.sidebar>
