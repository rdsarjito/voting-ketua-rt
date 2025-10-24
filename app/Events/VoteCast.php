<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Vote;
use App\Models\User;

class VoteCast implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $vote;
    public $user;
    public $candidate;

    /**
     * Create a new event instance.
     */
    public function __construct(Vote $vote, User $user)
    {
        $this->vote = $vote;
        $this->user = $user;
        $this->candidate = $vote->candidate;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('voting-updates'),
            new PrivateChannel('admin-notifications'),
        ];
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'vote_id' => $this->vote->id,
            'user_name' => $this->user->name,
            'candidate_name' => $this->candidate->name,
            'category_name' => $this->vote->category->name,
            'timestamp' => $this->vote->created_at->toISOString(),
            'message' => "{$this->user->name} memilih {$this->candidate->name} untuk {$this->vote->category->name}",
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'vote.cast';
    }
}
