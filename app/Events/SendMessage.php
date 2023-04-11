<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $researcher_id;
    public $file;
    public $type;
    public $email;
    public $sender_type;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($message,$researcher_id,$file=NULL, $type = 'internal',$email = '', $sender_type = '')
    {
        $this->researcher_id = $researcher_id;
        $this->message = $message;
        $this->file = $file;
        $this->type = $type;
        $this->email = $email;
        $this->sender_type = $sender_type;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        if($this->type == 'internal'){
            $channel = new Channel('research-chat.'.$this->researcher_id);
        } elseif($this->type == 'support'){
            $channel = new Channel('research-chat.'.$this->email);
        }
        return $channel;
    }
    public function broadcastAs()
    {
        return 'research-chat-message';
    }
}
