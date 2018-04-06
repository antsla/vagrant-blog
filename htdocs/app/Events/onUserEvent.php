<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class onUserEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $sType;
    public $oHandleUser;
    public $oException;

    public function __construct($sType, User $oHandleUser = null, $oException = null)
    {
        $this->sType = $sType;
        $this->oHandleUser = $oHandleUser;
        $this->oException = $oException;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
