<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth.card')] class extends Component {
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        Password::sendResetLink($this->only('email'));

        session()->flash('status', __('A reset link will be sent if the account exists.'));
    }
}; ?>

<div class="flex flex-col gap-6">
    <!-- Logo Animation -->
    <div class="text-center mb-4">
        <div class="flex justify-center">
            <div class="relative">
                <div class="absolute -inset-0.5 bg-linear-to-r from-emerald-500 to-blue-500 rounded-full blur-sm opacity-75 animate-pulse-slow"></div>
                <div class="relative w-16 h-16 bg-zinc-900 rounded-full flex items-center justify-center border-2 border-emerald-500/50">
                    <x-app-logo-icon class="h-10 w-10 text-emerald-400" />
                </div>
            </div>
        </div>
    </div>

    <x-auth-header title="Forgot password" description="Enter your email to receive a password reset link" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="sendPasswordResetLink" class="flex flex-col gap-6">
        <!-- Email Address -->
        <flux:input
            wire:model="email"
            label="{{ __('Email Address') }}"
            type="email"
            name="email"
            required
            autofocus
            placeholder="email@example.com"
        />

        <div class="flex items-center justify-end">
            <flux:button variant="primary" type="submit" class="w-full bg-linear-to-r from-emerald-500 to-blue-500 hover:from-emerald-600 hover:to-blue-600 transition-all duration-300">{{ __('Email password reset link') }}</flux:button>
        </div>
    </form>

    <div class="space-x-1 text-center text-sm text-zinc-400">
        Or, return to
        <flux:link href="{{ route('login') }}" class="text-emerald-400 hover:text-emerald-300 transition-colors duration-300">log in</flux:link>
    </div>

    <div class="text-center text-xs text-zinc-500 mt-4">
        <flux:link href="{{ route('terms') }}" class="text-zinc-400 hover:text-emerald-300 transition-colors duration-300">Terms & Conditions</flux:link>
    </div>
</div>
