<?php

namespace App\Events;

use App\Models\User;
use App\Models\Challenge;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChallengeProgressUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $challenge;
    public $progress;
    public $isCompleted;

    /**
     * Create a new event instance.
     */
    public function __construct(User $user, Challenge $challenge, int $progress, bool $isCompleted = false)
    {
        $this->user = $user;
        $this->challenge = $challenge;
        $this->progress = $progress;
        $this->isCompleted = $isCompleted;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('user.' . $this->user->id),
            new Channel('challenge.' . $this->challenge->id),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'challenge.progress.updated';
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'challenge_id' => $this->challenge->id,
            'challenge_name' => $this->challenge->name,
            'progress' => $this->progress,
            'is_completed' => $this->isCompleted,
            'timestamp' => now()->toISOString(),
        ];
    }
}
