<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserOnlineStatusUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;
    public $online;

    public function __construct($userId, $online)
    {
        $this->userId = $userId;
        $this->online = $online;
    }

    public function broadcastOn()
    {
        return new PresenceChannel('App.Models.User.'.$this->userId);
    }
}