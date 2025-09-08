<?php

namespace DarkoMalogajski\FilamentRealtimeNotifications\Providers;

use Filament\Support\Facades\FilamentView;
use Illuminate\Support\ServiceProvider;

class FilamentRealtimeNotificationsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Load views
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'filament-realtime-notifications');

        // Register the realtime.js script in Filament admin
        FilamentView::registerRenderHook(
            'panels::head.end',
            function (): string {
                $userId = auth()->check() ? auth()->id() : 'null';
                $channel = config('filament-realtime-notifications.channel', 'user-notifications');
                $reverbHost = config('filament-realtime-notifications.reverb.host', 'localhost');
                $reverbPort = config('filament-realtime-notifications.reverb.port', '8080');
                $reverbScheme = config('filament-realtime-notifications.reverb.scheme', 'ws');
                $reverbKey = config('filament-realtime-notifications.reverb.app_key', 'app-key');

                return '
                    <meta name="user-id" content="' . $userId . '">
                    <meta name="notifications-channel" content="' . $channel . '">
                    <meta name="reverb-host" content="' . $reverbHost . '">
                    <meta name="reverb-port" content="' . $reverbPort . '">
                    <meta name="reverb-scheme" content="' . $reverbScheme . '">
                    <meta name="reverb-key" content="' . $reverbKey . '">
                    <script src="' . asset('vendor/filament-realtime-notifications/js/realtime.js') . '"></script>
                ';
            }
        );

        // Publish assets
        $this->publishes([
            __DIR__ . '/../../resources/js/realtime.js' => public_path('vendor/filament-realtime-notifications/js/realtime.js'),
        ], 'filament-realtime-notifications-assets');

        // Publish config
        $this->publishes([
            __DIR__ . '/../../config/filament-realtime-notifications.php' => config_path('filament-realtime-notifications.php'),
        ], 'filament-realtime-notifications-config');

        // Publish views (optional)
        $this->publishes([
            __DIR__ . '/../../resources/views' => resource_path('views/vendor/filament-realtime-notifications'),
        ], 'filament-realtime-notifications-views');
    }

    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/filament-realtime-notifications.php',
            'filament-realtime-notifications'
        );
    }
}