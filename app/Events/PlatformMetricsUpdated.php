<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PlatformMetricsUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $signupsToday;
    public $totalOpenTickets;
    public $mrr;

    public function __construct($signupsToday, $totalOpenTickets, $mrr)
    {
        $this->signupsToday = $signupsToday;
        $this->totalOpenTickets = $totalOpenTickets;
        $this->mrr = $mrr;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('platform.super-admin'),
        ];
    }
}
