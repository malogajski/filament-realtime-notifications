<?php

namespace DarkoMalogajski\FilamentRealtimeNotifications\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificationEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public $type = 'success',    // success, info, warning, danger
        public $message = 'Default notification message',
        public $eventName = 'notification.sent'
    ) {}

    public function broadcastOn(): array
    {
        return [
            new Channel(config('filament-realtime-notifications.channel', 'user-notifications')),
        ];
    }

    public function broadcastAs(): string
    {
        return $this->eventName;
    }

    public function broadcastWith(): array
    {
        return [
            'type' => $this->type,
            'message' => $this->message,
            'timestamp' => now()->toISOString(),
        ];
    }
}