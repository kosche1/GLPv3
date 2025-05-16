<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Carbon;

class UserActivityHistoryModal extends Component
{
    public $isOpen = false;
    public $userId = null;
    public $userName = '';
    public $userLevel = 1;
    public $userPoints = 0;
    public $activityHistory = [];
    public $loading = false;

    protected $listeners = ['openUserActivityModal' => 'openModal'];

    /**
     * Open the modal and load user activity history
     *
     * @param int $userId
     * @return void
     */
    public function openModal($userId)
    {
        $this->loading = true;
        $this->userId = $userId;
        $this->isOpen = true;
        $this->loadUserActivityHistory();
    }

    /**
     * Close the modal
     *
     * @return void
     */
    public function closeModal()
    {
        $this->isOpen = false;
        $this->userId = null;
        $this->userName = '';
        $this->userLevel = 1;
        $this->userPoints = 0;
        $this->activityHistory = [];
    }

    /**
     * Load user activity history
     *
     * @return void
     */
    protected function loadUserActivityHistory()
    {
        if (!$this->userId) {
            $this->loading = false;
            return;
        }

        try {
            $user = User::findOrFail($this->userId);
            $this->userName = $user->name;
            $this->userLevel = $user->getLevel();
            $this->userPoints = $user->getPoints();

            // Get experience history if available
            if (method_exists($user, 'experienceHistory')) {
                $this->activityHistory = $user->experienceHistory()
                    ->latest()
                    ->take(20)
                    ->get()
                    ->map(function ($entry) {
                        return [
                            'id' => $entry->id,
                            'points' => $entry->points,
                            'type' => $entry->type,
                            'reason' => $entry->reason,
                            'date' => Carbon::parse($entry->created_at)->format('M d, Y h:i A'),
                            'time_ago' => Carbon::parse($entry->created_at)->diffForHumans(),
                        ];
                    })
                    ->toArray();
            }
        } catch (\Exception $e) {
            // Handle error
            $this->activityHistory = [];
        }

        $this->loading = false;
    }

    public function render()
    {
        return view('livewire.user-activity-history-modal');
    }
}
