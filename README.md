# Filament Real-time Notifications

Real-time toast notifications for Filament admin panel using Laravel Reverb and WebSockets.

## Features

- 🔴 **Real-time notifications** - Instant toast notifications across all admin panel sessions
- 🎨 **Filament-style design** - Native look and feel with dark/light mode support  
- 🔧 **Multiple notification types** - Success, Info, Warning, Danger
- 📱 **Responsive** - Works on all screen sizes
- ⚙️ **Configurable** - Customizable colors, icons, and behavior
- 🧪 **Test page included** - Built-in testing interface

## Installation

Install the package via Composer:

```bash
composer require darkomalogajski/filament-realtime-notifications
```

Publish the assets:

```bash
php artisan vendor:publish --tag=filament-realtime-notifications-assets
```

Optionally, publish the config file:

```bash
php artisan vendor:publish --tag=filament-realtime-notifications-config
```

## Configuration

### 1. Laravel Reverb Setup

Make sure Laravel Reverb is configured in your `.env`:

```env
BROADCAST_CONNECTION=reverb
REVERB_APP_ID=your-app-id
REVERB_APP_KEY=your-app-key
REVERB_APP_SECRET=your-app-secret
REVERB_HOST="your-domain.test"
REVERB_PORT=8080
REVERB_SCHEME=wss
```

### 2. Start Reverb Server

```bash
php artisan reverb:start
```

## Usage

### Option 1: Using the NotificationEvent

```php
use DarkoMalogajski\FilamentRealtimeNotifications\Events\NotificationEvent;

// Success notification
broadcast(new NotificationEvent('success', 'Operation completed successfully!'));

// Error notification  
broadcast(new NotificationEvent('danger', 'Something went wrong!'));

// Info notification
broadcast(new NotificationEvent('info', 'Here is some important information.'));

// Warning notification
broadcast(new NotificationEvent('warning', 'Please pay attention to this.'));
```

### Option 2: Create Custom Events

```php
<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PostCreatedEvent implements ShouldBroadcast
{
    public function __construct(public $post) {}

    public function broadcastOn(): array
    {
        return [new Channel('user-notifications')];
    }

    public function broadcastAs(): string
    {
        return 'post.created';
    }

    public function broadcastWith(): array
    {
        return [
            'type' => 'success',
            'message' => "New post '{$this->post->title}' has been created!"
        ];
    }
}
```

### Usage Examples

```php
// In Controllers
public function store(Request $request)
{
    // ... save logic ...
    broadcast(new NotificationEvent('success', 'Record saved successfully!'));
    return response()->json(['status' => 'success']);
}

// In Jobs
public function handle()
{
    try {
        // ... job logic ...
        broadcast(new NotificationEvent('success', 'Job completed successfully!'));
    } catch (Exception $e) {
        broadcast(new NotificationEvent('danger', 'Job failed: ' . $e->getMessage()));
    }
}

// In Model Observers
class ProductObserver
{
    public function created(Product $product)
    {
        broadcast(new NotificationEvent('success', "Product '{$product->name}' created!"));
    }
}
```

## Testing

The package includes a test page accessible in your Filament admin panel:

1. Navigate to "Test Notifications" in your admin panel
2. Click the test buttons to see different notification types
3. Open multiple browser tabs to test real-time functionality

## Configuration Options

The config file allows you to customize:

- **Channel name** - WebSocket channel for broadcasting
- **Notification types** - Colors and icons for each type  
- **Toast settings** - Duration, position, and sizing
- **Reverb settings** - WebSocket connection details

## Requirements

- PHP 8.1+
- Laravel 10.0+ or 11.0+
- Filament 3.0+
- Laravel Reverb

## Notification Types

| Type | Color | Icon | Usage |
|------|-------|------|-------|
| `success` | Green | ✓ | Successful operations |
| `info` | Blue | ℹ | General information |
| `warning` | Yellow | ⚠ | Warnings and alerts |
| `danger` | Red | ✕ | Errors and failures |

## Important Notes

1. **Channel**: Configurable via config file (defaults to `user-notifications`)
2. **Data Format**: Events must return `type` and `message` in `broadcastWith()`
3. **Event Names**: Any custom event name is supported
4. **Queue Support**: Events can be queued for better performance
5. **Reverb Settings**: All WebSocket connection details are configurable

## License

MIT License. See LICENSE file for details.
