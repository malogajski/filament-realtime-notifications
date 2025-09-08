<?php

namespace DarkoMalogajski\FilamentRealtimeNotifications\Pages;

use DarkoMalogajski\FilamentRealtimeNotifications\Events\NotificationEvent;
use Filament\Actions\Action;
use Filament\Pages\Page;

class TestNotificationsPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-bell';
    
    protected static string $view = 'filament-realtime-notifications::pages.test-notifications';
    
    protected static ?string $navigationLabel = 'Test Notifications';
    
    protected static ?string $title = 'Real-time Notifications Test';
    
    protected static ?int $navigationSort = 999;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('test_success')
                ->label('Test Success')
                ->color('success')
                ->action(function () {
                    broadcast(new NotificationEvent(
                        'success',
                        'This is a success notification test!',
                        'test.success'
                    ));
                }),
                
            Action::make('test_info')
                ->label('Test Info')
                ->color('info')
                ->action(function () {
                    broadcast(new NotificationEvent(
                        'info',
                        'This is an info notification test!',
                        'test.info'
                    ));
                }),
                
            Action::make('test_warning')
                ->label('Test Warning')
                ->color('warning')
                ->action(function () {
                    broadcast(new NotificationEvent(
                        'warning',
                        'This is a warning notification test!',
                        'test.warning'
                    ));
                }),
                
            Action::make('test_danger')
                ->label('Test Danger')
                ->color('danger')
                ->action(function () {
                    broadcast(new NotificationEvent(
                        'danger',
                        'This is a danger notification test!',
                        'test.danger'
                    ));
                })
        ];
    }
}