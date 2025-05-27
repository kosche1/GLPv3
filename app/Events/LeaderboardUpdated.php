<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LeaderboardUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $leaderboardData;
    public $userRank;

    /**
     * Create a new event instance.
     */
    public function __construct(User $user, array $leaderboardData, ?int $userRank = null)
    {
        $this->user = $user;
        $this->leaderboardData = $leaderboardData;
        $this->userRank = $userRank;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('leaderboard'),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'leaderboard.updated';
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'user_points' => $this->user->getPoints(),
            'user_level' => $this->user->getLevel(),
            'user_rank' => $this->userRank,
            'leaderboard' => array_slice($this->leaderboardData, 0, 10), // Top 10
            'timestamp' => now()->toISOString(),
        ];
    }
}
