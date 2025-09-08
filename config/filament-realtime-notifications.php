<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Broadcast Channel
    |--------------------------------------------------------------------------
    |
    | The channel name used for broadcasting notifications.
    | This should match the channel your JavaScript listens to.
    |
    */
    'channel' => env('FILAMENT_NOTIFICATIONS_CHANNEL', 'user-notifications'),

    /*
    |--------------------------------------------------------------------------
    | Reverb Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for Laravel Reverb WebSocket server.
    | These values are used by the JavaScript client.
    |
    */
    'reverb' => [
        'host' => env('REVERB_HOST', 'localhost'),
        'port' => env('REVERB_PORT', 8080),
        'scheme' => env('REVERB_SCHEME', 'ws'),
        'app_key' => env('REVERB_APP_KEY'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Notification Types
    |--------------------------------------------------------------------------
    |
    | Available notification types and their corresponding colors and icons.
    |
    */
    'types' => [
        'success' => [
            'color' => '#10b981',
            'icon' => '✓',
        ],
        'info' => [
            'color' => '#3b82f6',
            'icon' => 'ℹ',
        ],
        'warning' => [
            'color' => '#f59e0b',
            'icon' => '⚠',
        ],
        'danger' => [
            'color' => '#ef4444',
            'icon' => '✕',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Toast Settings
    |--------------------------------------------------------------------------
    |
    | Configuration for toast notification appearance and behavior.
    |
    */
    'toast' => [
        'duration' => 5000, // milliseconds
        'position' => 'top-right',
        'max_width' => '384px',
        'min_width' => '320px',
    ],
];