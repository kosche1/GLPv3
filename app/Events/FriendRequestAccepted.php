<?php

namespace App\Events;

use App\Models\User;
use App\Models\Friendship;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FriendRequestAccepted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $accepter;
    public $requester;
    public $friendship;

    /**
     * Create a new event instance.
     */
    public function __construct(User $accepter, User $requester, Friendship $friendship)
    {
        $this->accepter = $accepter;
        $this->requester = $requester;
        $this->friendship = $friendship;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('user.' . $this->requester->id),
        ];
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'friend' => [
                'id' => $this->accepter->id,
                'name' => $this->accepter->name,
                'initials' => $this->accepter->initials(),
                'level' => $this->accepter->getLevel(),
                'points' => $this->accepter->getPoints(),
            ],
            'message' => "{$this->accepter->name} accepted your friend request!",
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'friend.request.accepted';
    }
}
