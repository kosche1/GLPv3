<style>
    .grid-bg {
        background-size: 50px 50px;
        background-image: 
            linear-gradient(to right, rgba(0, 255, 157, 0.05) 1px, transparent 1px),
            linear-gradient(to bottom, rgba(0, 255, 157, 0.05) 1px, transparent 1px);
    }
    .circuit-pattern {
        background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M10 10 H 90 V 90 H 10 L 10 10' fill='none' stroke='rgba(0, 255, 157, 0.1)' stroke-width='1'/%3E%3Cpath d='M30 30 H 70 V 70 H 30 L 30 30' fill='none' stroke='rgba(0, 255, 157, 0.1)' stroke-width='1'/%3E%3Cpath d='M10 50 H 30' fill='none' stroke='rgba(0, 255, 157, 0.1)' stroke-width='1'/%3E%3Cpath d='M70 50 H 90' fill='none' stroke='rgba(0, 255, 157, 0.1)' stroke-width='1'/%3E%3Cpath d='M50 10 V 30' fill='none' stroke='rgba(0, 255, 157, 0.1)' stroke-width='1'/%3E%3Cpath d='M50 70 V 90' fill='none' stroke='rgba(0, 255, 157, 0.1)' stroke-width='1'/%3E%3C/svg%3E");
        background-size: 50px 50px;
    }
</style>

<!-- Enhanced background elements -->
<div class="fixed inset-0 grid-bg opacity-30 z-0"></div>
<div class="fixed inset-0 circuit-pattern opacity-20 z-0"></div>

<!-- Animated background elements -->
<div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
    <!-- Glowing orbs -->
    <div class="absolute top-1/4 left-1/4 w-64 h-64 rounded-full bg-ghost-primary/5 blur-3xl animate-pulse-slow"></div>
    <div class="absolute bottom-1/3 right-1/3 w-96 h-96 rounded-full bg-ghost-secondary/5 blur-3xl animate-pulse-slow" style="animation-delay: 1s"></div>
    <div class="absolute top-2/3 left-1/2 w-48 h-48 rounded-full bg-ghost-primary/5 blur-3xl animate-pulse-slow" style="animation-delay: 2s"></div>
    
    <!-- Digital particles -->
    <div class="absolute w-1 h-1 bg-ghost-primary/30 rounded-full animate-drift-x" style="top: 15%"></div>
    <div class="absolute w-2 h-2 bg-ghost-primary/20 rounded-full animate-drift-x" style="top: 25%; animation-delay: 3s"></div>
    <div class="absolute w-1 h-1 bg-ghost-secondary/30 rounded-full animate-drift-x" style="top: 35%; animation-delay: 6s"></div>
    <div class="absolute w-2 h-2 bg-ghost-primary/20 rounded-full animate-drift-x" style="top: 45%; animation-delay: 9s"></div>
    <div class="absolute w-1 h-1 bg-ghost-secondary/30 rounded-full animate-drift-x" style="top: 55%; animation-delay: 12s"></div>
    <div class="absolute w-2 h-2 bg-ghost-primary/20 rounded-full animate-drift-x" style="top: 65%; animation-delay: 15s"></div>
    <div class="absolute w-1 h-1 bg-ghost-primary/30 rounded-full animate-drift-x" style="top: 75%; animation-delay: 18s"></div>
    <div class="absolute w-2 h-2 bg-ghost-secondary/20 rounded-full animate-drift-x" style="top: 85%; animation-delay: 21s"></div>
    
    <!-- Vertical particles -->
    <div class="absolute w-1 h-1 bg-ghost-primary/30 rounded-full animate-drift-y" style="left: 15%; animation-delay: 2s"></div>
    <div class="absolute w-2 h-2 bg-ghost-secondary/20 rounded-full animate-drift-y" style="left: 25%; animation-delay: 5s"></div>
    <div class="absolute w-1 h-1 bg-ghost-primary/30 rounded-full animate-drift-y" style="left: 35%; animation-delay: 8s"></div>
    <div class="absolute w-2 h-2 bg-ghost-secondary/20 rounded-full animate-drift-y" style="left: 45%; animation-delay: 11s"></div>
    <div class="absolute w-1 h-1 bg-ghost-primary/30 rounded-full animate-drift-y" style="left: 55%; animation-delay: 14s"></div>
    <div class="absolute w-2 h-2 bg-ghost-secondary/20 rounded-full animate-drift-y" style="left: 65%; animation-delay: 17s"></div>
    <div class="absolute w-1 h-1 bg-ghost-primary/30 rounded-full animate-drift-y" style="left: 75%; animation-delay: 20s"></div>
    <div class="absolute w-2 h-2 bg-ghost-secondary/20 rounded-full animate-drift-y" style="left: 85%; animation-delay: 23s"></div>
    
    <!-- Geometric shapes -->
    <div class="absolute w-32 h-32 border border-ghost-primary/10 rotate-45 animate-rotate-slow animate-pulse-opacity" style="top: 20%; left: 20%"></div>
    <div class="absolute w-48 h-48 border border-ghost-secondary/10 rounded-full animate-pulse-opacity" style="bottom: 20%; right: 20%; animation-delay: 2s"></div>
    <div class="absolute w-64 h-64 border border-ghost-primary/10 rotate-45 animate-rotate-slow animate-pulse-opacity" style="top: 60%; left: 60%; animation-delay: 4s"></div>
    
    <!-- Digital circuit lines -->
    <svg class="absolute inset-0 w-full h-full opacity-10" xmlns="http://www.w3.org/2000/svg">
        <line x1="0" y1="25%" x2="100%" y2="25%" stroke="#00ff9d" stroke-width="0.5" stroke-dasharray="10,15" />
        <line x1="0" y1="75%" x2="100%" y2="75%" stroke="#00ccb9" stroke-width="0.5" stroke-dasharray="10,15" />
        <line x1="25%" y1="0" x2="25%" y2="100%" stroke="#00ff9d" stroke-width="0.5" stroke-dasharray="10,15" />
        <line x1="75%" y1="0" x2="75%" y2="100%" stroke="#00ccb9" stroke-width="0.5" stroke-dasharray="10,15" />
    </svg>
</div>