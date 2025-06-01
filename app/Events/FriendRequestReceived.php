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

class FriendRequestReceived implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $sender;
    public $recipient;
    public $friendship;

    /**
     * Create a new event instance.
     */
    public function __construct(User $sender, User $recipient, Friendship $friendship)
    {
        $this->sender = $sender;
        $this->recipient = $recipient;
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
            new PrivateChannel('user.' . $this->recipient->id),
        ];
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'sender' => [
                'id' => $this->sender->id,
                'name' => $this->sender->name,
                'initials' => $this->sender->initials(),
                'level' => $this->sender->getLevel(),
                'points' => $this->sender->getPoints(),
            ],
            'friendship_id' => $this->friendship->id,
            'message' => "{$this->sender->name} sent you a friend request!",
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'friend.request.received';
    }
}
