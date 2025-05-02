<?php

namespace App\Livewire;

use App\Models\StudentAnswer;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\Log;

class TaskApprovalModal extends Component
{
    public $showApprovalModal = false;
    public $approvedTask = null;
    public $pointsAwarded = 0;
    public $taskName = '';
    public $feedback = '';
    public $submittedText = '';

    protected $listeners = ['checkForApprovedTasks' => 'checkForApprovedTasks'];

    public function mount()
    {
        $this->checkForApprovedTasks();
    }

    public function checkForApprovedTasks()
    {
        if (!Auth::check()) {
            return;
        }

        Log::info('Checking for approved tasks');

        // Look for recently approved tasks (in the last 30 minutes)
        $recentlyApproved = StudentAnswer::where('user_id', Auth::id())
            ->where('status', 'evaluated')
            ->where('is_correct', true)
            ->where('evaluated_at', '>=', now()->subMinutes(30))
            ->where(function($query) {
                $query->whereNull('notification_shown')
                      ->orWhere('notification_shown', false);
            })
            ->with('task')
            ->latest('evaluated_at')
            ->first();

        Log::info('Query result', [
            'found_task' => $recentlyApproved ? 'yes' : 'no',
            'task_id' => $recentlyApproved?->task_id,
            'user_id' => Auth::id(),
        ]);

        if ($recentlyApproved && $recentlyApproved->task) {
            $this->approvedTask = $recentlyApproved;
            $this->pointsAwarded = $recentlyApproved->task->points_reward ?? 0;
            $this->taskName = $recentlyApproved->task->name ?? 'Task';
            $this->feedback = $recentlyApproved->feedback ?? '';
            $this->submittedText = $recentlyApproved->submitted_text ?? '';
            $this->showApprovalModal = true;

            // Mark this approval as shown
            $recentlyApproved->update(['notification_shown' => true]);

            Log::info('Showing task approval modal', [
                'task_id' => $recentlyApproved->task_id,
                'user_id' => Auth::id(),
                'points' => $this->pointsAwarded,
                'task_name' => $this->taskName
            ]);
        }
    }

    public function closeModal()
    {
        $this->showApprovalModal = false;
    }

    public function render()
    {
        return view('livewire.task-approval-modal');
    }
}
