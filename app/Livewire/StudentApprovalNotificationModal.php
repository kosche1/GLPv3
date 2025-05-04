<?php

namespace App\Livewire;

use Livewire\Component;

class StudentApprovalNotificationModal extends Component
{
    public $isOpen = false;
    public $title = 'Task Approved!';
    public $message = '';
    public $submissionContent = '';
    public $feedback = '';
    public $pointsAwarded = 0;
    public $continueUrl = '';
    public $continueText = 'Continue Learning';

    public function mount()
    {
        // Empty mount method to ensure no parameters are required
    }

    protected $listeners = [
        'showApprovalNotification' => 'openModal',
    ];

    // For Livewire 3, we need to define listeners differently
    public function getListeners()
    {
        return [
            'showApprovalNotification' => 'openModal',
        ];
    }

    // Explicitly expose methods for Livewire 3
    protected function getPublicMethods()
    {
        return [
            'openModal',
            'closeModal',
        ];
    }

    public function openModal($data)
    {
        \Illuminate\Support\Facades\Log::info('StudentApprovalNotificationModal::openModal called', ['data' => $data]);

        // Handle both direct data and Livewire 3's { data: data } format
        if (is_array($data) && isset($data['data']) && is_array($data['data'])) {
            $data = $data['data'];
        }

        $this->title = $data['title'] ?? 'Task Approved!';
        $this->message = $data['message'] ?? '';
        $this->submissionContent = $data['submissionContent'] ?? '';
        $this->feedback = $data['feedback'] ?? '';
        $this->pointsAwarded = $data['pointsAwarded'] ?? 0;
        $this->continueUrl = $data['continueUrl'] ?? '';
        $this->continueText = $data['continueText'] ?? 'Continue Learning';
        $this->isOpen = true;

        \Illuminate\Support\Facades\Log::info('Modal should now be open', [
            'isOpen' => $this->isOpen,
            'title' => $this->title,
            'message' => $this->message,
            'pointsAwarded' => $this->pointsAwarded
        ]);
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function render()
    {
        return view('livewire.student-approval-notification-modal');
    }
}
