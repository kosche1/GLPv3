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

class FriendOnline implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;

    /**
     * Create a new event instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        // Get all friends of the user who came online
        $friendIds = $this->user->friends()->pluck('id')->toArray();
        
        $channels = [];
        
        // Broadcast to each friend's private channel
        foreach ($friendIds as $friendId) {
            $channels[] = new PrivateChannel('user.' . $friendId);
        }
        
        return $channels;
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'friend' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'initials' => $this->user->initials(),
                'level' => $this->user->getLevel(),
                'status' => 'online',
            ],
            'message' => "{$this->user->name} is now online",
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'friend.online';
    }
}
