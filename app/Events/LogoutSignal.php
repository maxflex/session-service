<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class LogoutSignal implements ShouldBroadcast
{
    use SerializesModels;

    public $user_id;
    public $action;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user_id, $action)
    {
        $this->user_id = $user_id;
        $this->action = $action;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return 'session.' . $this->user_id;
    }

    public function broadcastWith()
    {
        return ['action' => $this->action];
    }
}
