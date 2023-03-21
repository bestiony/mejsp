<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SupportChatEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $email;
    public $message;

    public function __construct($email,$message)
    {
        $this->email = $email;
        $this->message  = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('support-chat.'.$this->email);
    }
    public function broadcastAs()
    {
        return 'support-chat-message';
    }
}
