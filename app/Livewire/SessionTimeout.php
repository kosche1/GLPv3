<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class SessionTimeout extends Component
{
    public $showWarning = false;
    public $showLockModal = false;
    public $password = '';
    public $errorMessage = '';
    public $inactivityTimeout = 1790;
    public $warningTimeout = 10;

    public function mount()
    {
        // Initialize component with modals hidden
        $this->showWarning = false;
        $this->showLockModal = false;
        $this->password = '';
        $this->errorMessage = '';

        // Ensure modals are hidden on page refresh
        $this->dispatch('session-refreshed');
    }

    public function showWarningModal()
    {
        $this->showWarning = true;
    }

    public function hideWarningModal()
    {
        $this->showWarning = false;
    }

    public function lockSession()
    {
        $this->showWarning = false;
        $this->showLockModal = true;
        $this->dispatch('lock-session');
    }

    public function continueSession()
    {
        $this->showWarning = false;
        $this->dispatch('session-continued');
    }

    public function verifyPassword()
    {
        // Get the current user
        $user = Auth::user();

        if (!$user) {
            $this->errorMessage = 'User not authenticated.';
            \Illuminate\Support\Facades\Log::error('Session unlock failed: User not authenticated');
            return;
        }

        // Get the password from the input
        $password = $this->password;

        // Log the attempt (without the actual password)
        \Illuminate\Support\Facades\Log::info('Attempting to unlock session', [
            'user_id' => $user->id,
            'email' => $user->email,
            'has_password' => !empty($password),
        ]);

        // Check if password is empty
        if (empty($password)) {
            $this->errorMessage = 'Please enter your password.';
            \Illuminate\Support\Facades\Log::warning('Session unlock failed: Empty password');
            return;
        }

        // For security, create a new Auth attempt with the current credentials
        // This is the most reliable way to verify a password
        $credentials = [
            'email' => $user->email,
            'password' => $password,
        ];

        // Temporarily store the current user ID
        $currentUserId = $user->id;

        // Log out the current user
        Auth::logout();

        // Attempt to log in with the provided credentials
        $loginSuccessful = Auth::attempt($credentials);

        // Check if login was successful and if the same user was logged in
        if ($loginSuccessful && Auth::id() === $currentUserId) {
            \Illuminate\Support\Facades\Log::info('Session unlock successful', ['user_id' => $user->id]);

            // Clear the password field
            $this->password = '';
            $this->errorMessage = '';

            // Unlock the session
            $this->unlockSession();

            // Force a UI refresh
            $this->dispatch('refresh');
        } else {
            \Illuminate\Support\Facades\Log::warning('Session unlock failed: Invalid password', ['user_id' => $currentUserId]);

            // If login failed, log back in as the original user if possible
            if (!$loginSuccessful) {
                Auth::loginUsingId($currentUserId);
            }

            // Show error message
            $this->errorMessage = 'Incorrect password. Please try again.';
            $this->password = '';
        }
    }

    public function unlockSession()
    {
        // Log the unlock action
        \Illuminate\Support\Facades\Log::info('Unlocking session', [
            'user_id' => Auth::id(),
        ]);

        // Reset component state
        $this->showLockModal = false;
        $this->password = '';
        $this->errorMessage = '';

        // Dispatch events to update Alpine.js state
        $this->dispatch('session-unlocked');
        $this->dispatch('unlock-session');

        // Force a refresh of the component
        $this->dispatch('refresh');
    }

    public function logout()
    {
        // Clear session lock state
        $this->dispatch('clear-session-lock');

        // Get the current user before logging out
        $user = Auth::user();

        if ($user) {
            try {
                // Record the logout event in the audit trail
                \Illuminate\Support\Facades\Log::info('Recording logout from session timeout', [
                    'user_id' => $user->id,
                    'user_name' => $user->name
                ]);

                \App\Models\AuditTrail::recordLogout($user);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Error recording logout in session timeout', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }
        }

        Auth::logout();
        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.session-timeout');
    }
}
