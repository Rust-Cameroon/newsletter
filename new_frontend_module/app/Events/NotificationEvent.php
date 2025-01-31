<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class NotificationEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private mixed $type;

    private mixed $data;

    private mixed $userId;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($type, $data, $userId = '')
    {
        $this->type = $type;
        $this->data = $data;
        $this->userId = $userId;
    }

    public function broadcastOn()
    {
        return new Channel(Str::snake($this->type).'-notification'.$this->userId);
    }

    public function broadcastAs()
    {
        return 'notification-event';
    }

    public function broadcastWith()
    {
        return [
            'data' => $this->data,
        ];
    }
}
