<?php

namespace App\Livewire;

use App\Models\TypingTestResult;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class TypingTestApprovalModal extends Component
{
    public $showApprovalModal = false;
    public $approvedResult = null;
    public $pointsAwarded = 0;
    public $challengeTitle = '';
    public $feedback = '';
    public $wpm = 0;
    public $accuracy = 0;

    protected $listeners = ['checkForApprovedTypingTests'];

    public function mount()
    {
        $this->checkForApprovedTypingTests();
    }

    public function checkForApprovedTypingTests()
    {
        if (!Auth::check()) {
            return;
        }

        Log::info('Checking for approved typing test results');

        // Look for recently approved typing test results (in the last 30 minutes)
        $recentlyApproved = TypingTestResult::where('user_id', Auth::id())
            ->where('approved', true)
            ->where('points_awarded', true)
            ->where('approved_at', '>=', now()->subMinutes(30))
            ->where('notification_shown', false)
            ->with(['challenge', 'approver'])
            ->latest('approved_at')
            ->first();

        Log::info('Typing test query result', [
            'found_result' => $recentlyApproved ? 'yes' : 'no',
            'result_id' => $recentlyApproved?->id,
            'challenge_title' => $recentlyApproved?->challenge?->title,
            'user_id' => Auth::id(),
        ]);

        if ($recentlyApproved) {
            $this->approvedResult = $recentlyApproved;
            $this->pointsAwarded = $recentlyApproved->challenge?->points_reward ?? 0;
            $this->challengeTitle = $recentlyApproved->challenge?->title ?? 'Typing Test';
            $this->wpm = $recentlyApproved->wpm;
            $this->accuracy = $recentlyApproved->accuracy;
            $this->showApprovalModal = true;

            // Mark this approval as shown
            $recentlyApproved->update(['notification_shown' => true]);

            Log::info('Showing typing test approval modal', [
                'result_id' => $recentlyApproved->id,
                'user_id' => Auth::id(),
                'points' => $this->pointsAwarded,
                'challenge_title' => $this->challengeTitle
            ]);
        }
    }

    public function closeModal()
    {
        $this->showApprovalModal = false;
    }

    public function render()
    {
        return view('livewire.typing-test-approval-modal');
    }
}
