<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Category;

class VotingPeriodChanged implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $category;
    public $action;

    /**
     * Create a new event instance.
     */
    public function __construct(Category $category, string $action)
    {
        $this->category = $category;
        $this->action = $action;
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
        ];
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'category_id' => $this->category->id,
            'category_name' => $this->category->name,
            'action' => $this->action,
            'is_active' => $this->category->is_active,
            'voting_start' => $this->category->voting_start?->toISOString(),
            'voting_end' => $this->category->voting_end?->toISOString(),
            'timestamp' => now()->toISOString(),
            'message' => "Periode voting {$this->category->name} {$this->action}",
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'voting.period.changed';
    }
}
