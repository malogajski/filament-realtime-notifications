<x-filament-panels::page>
    <div class="space-y-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                Real-time Notifications Test
            </h2>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                Click the buttons above to test different types of notifications. 
                Open this page in multiple browser tabs to see real-time broadcasting in action!
            </p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="border border-green-200 dark:border-green-800 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center text-white text-sm font-medium mr-3">
                            ✓
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-900 dark:text-white">Success</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Green notification with checkmark</p>
                        </div>
                    </div>
                </div>
                
                <div class="border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white text-sm font-medium mr-3">
                            ℹ
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-900 dark:text-white">Info</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Blue notification with info icon</p>
                        </div>
                    </div>
                </div>
                
                <div class="border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center text-white text-sm font-medium mr-3">
                            ⚠
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-900 dark:text-white">Warning</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Yellow notification with warning icon</p>
                        </div>
                    </div>
                </div>
                
                <div class="border border-red-200 dark:border-red-800 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center text-white text-sm font-medium mr-3">
                            ✕
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-900 dark:text-white">Danger</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Red notification with X icon</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                How to use in your code
            </h3>
            <div class="space-y-4">
                <div>
                    <h4 class="font-medium text-gray-900 dark:text-white">Option 1: Using the NotificationEvent</h4>
                    <pre class="mt-2 p-4 bg-gray-100 dark:bg-gray-900 rounded text-sm overflow-x-auto"><code>use DarkoMalogajski\FilamentRealtimeNotifications\Events\NotificationEvent;

broadcast(new NotificationEvent('success', 'Your message here', 'custom.event.name'));</code></pre>
                </div>
                
                <div>
                    <h4 class="font-medium text-gray-900 dark:text-white">Option 2: Create your own event</h4>
                    <pre class="mt-2 p-4 bg-gray-100 dark:bg-gray-900 rounded text-sm overflow-x-auto"><code>class PostCreatedEvent implements ShouldBroadcast 
{
    public function broadcastAs(): string { 
        return 'post.created'; 
    }
    
    public function broadcastWith(): array {
        return [
            'type' => 'success',
            'message' => 'New post has been created!'
        ];
    }
}</code></pre>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>