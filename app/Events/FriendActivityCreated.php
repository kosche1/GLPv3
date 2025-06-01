<?php

namespace App\Events;

use App\Models\User;
use App\Models\FriendActivity;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FriendActivityCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $friendActivity;
    public $user;

    /**
     * Create a new event instance.
     */
    public function __construct(FriendActivity $friendActivity)
    {
        $this->friendActivity = $friendActivity;
        $this->user = $friendActivity->user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        // Get all friends of the user who created the activity
        $friendIds = $this->user->friends()->pluck('id')->toArray();
        
        $channels = [];
        
        // Broadcast to each friend's private channel
        foreach ($friendIds as $friendId) {
            $channels[] = new PrivateChannel('user.' . $friendId);
        }
        
        // Also broadcast to public activity feed
        $channels[] = new Channel('activity-feed');
        
        return $channels;
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'activity' => [
                'id' => $this->friendActivity->id,
                'type' => $this->friendActivity->activity_type,
                'title' => $this->friendActivity->activity_title,
                'description' => $this->friendActivity->activity_description,
                'data' => $this->friendActivity->activity_data,
                'points_earned' => $this->friendActivity->points_earned,
                'icon' => $this->friendActivity->icon,
                'color' => $this->friendActivity->color,
                'time_ago' => $this->friendActivity->created_at->diffForHumans(),
                'created_at' => $this->friendActivity->created_at->toISOString(),
            ],
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'initials' => $this->user->initials(),
                'level' => $this->user->getLevel(),
                'points' => $this->user->getPoints(),
            ]
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'friend.activity.created';
    }
}
