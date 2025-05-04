<?php

namespace App\Livewire;

use Livewire\Component;

class ApprovalNotificationModal extends Component
{
    public bool $isOpen = false;
    public string $title = '';
    public string $message = '';
    public string $submissionContent = '';
    public string $feedback = '';
    public int $pointsAwarded = 0;
    public string $continueUrl = '';
    public string $continueText = 'Continue';
    
    protected $listeners = [
        'openApprovalModal' => 'openModal',
    ];
    
    public function openModal($data)
    {
        $this->title = $data['title'] ?? 'Approved!';
        $this->message = $data['message'] ?? '';
        $this->submissionContent = $data['submissionContent'] ?? '';
        $this->feedback = $data['feedback'] ?? '';
        $this->pointsAwarded = $data['pointsAwarded'] ?? 0;
        $this->continueUrl = $data['continueUrl'] ?? '';
        $this->continueText = $data['continueText'] ?? 'Continue';
        $this->isOpen = true;
    }
    
    public function closeModal()
    {
        $this->isOpen = false;
    }
    
    public function render()
    {
        return view('livewire.approval-notification-modal');
    }
}
