// EchoReverb Real-time Notifications

// Filament-style toast notification
function showFilamentToast(title, message, type = 'success') {

    // Remove existing toasts
    const existing = document.querySelectorAll('.filament-notification');
    existing.forEach(toast => toast.remove());

    const colors = {
        success: { bg: '#10b981', border: '#10b981', icon: '✓' },
        info: { bg: '#3b82f6', border: '#3b82f6', icon: 'ℹ' },
        warning: { bg: '#f59e0b', border: '#f59e0b', icon: '⚠' },
        danger: { bg: '#ef4444', border: '#ef4444', icon: '✕' }
    };

    const color = colors[type] || colors.success;

    // Check if dark mode - Filament way
    const isDark = document.documentElement.classList.contains('dark');

    // Authentic Filament colors
    const bgColor = isDark ? '#111827' : 'white';  // bg-gray-900 / bg-white
    const titleColor = isDark ? 'white' : '#111827';  // text-white / text-gray-900
    const messageColor = isDark ? '#d1d5dc' : '#374151';  // text-gray-700 for both

    const toast = document.createElement('div');
    toast.className = 'filament-notification';
    toast.style.cssText = `
        position: fixed !important;
        top: 24px !important;
        right: 24px !important;
        background: ${bgColor} !important;
        color: ${titleColor} !important;
        padding: 16px !important;
        border-radius: 12px !important;
        border: 1px solid ${isDark ? '#374151' : '#e5e7eb'} !important;
        box-shadow: ${isDark ? '0 10px 15px -3px rgba(0, 0, 0, 0.3)' : '0 10px 15px -3px rgba(0, 0, 0, 0.1)'} !important;
        z-index: 999999 !important;
        max-width: 384px !important;
        min-width: 320px !important;
        font-family: 'Figtree', ui-sans-serif, system-ui, sans-serif !important;
        transform: translateX(100%) !important;
        opacity: 0 !important;
        transition: all 0.3s ease !important;
    `;

    toast.innerHTML = `
        <div style="display: flex; align-items: flex-start; gap: 12px;">
            <div style="
                background: ${color.bg};
                border-radius: 50%;
                padding: 6px;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
                width: 32px;
                height: 32px;
                color: white;
                font-weight: bold;
            ">${color.icon}</div>
            <div style="flex: 1; min-width: 0; padding-top: 2px;">
                <div style="font-weight: 600; font-size: 14px; line-height: 1.4; color: ${titleColor}; margin-bottom: 4px;">
                    ${title}
                </div>
                <div style="font-size: 14px; line-height: 1.5; color: ${messageColor};">
                    ${message}
                </div>
            </div>
            <button onclick="this.parentElement.parentElement.remove()" style="
                background: none;
                border: none;
                color: #9ca3af;
                cursor: pointer;
                padding: 4px;
                font-size: 14px;
                width: 20px;
                height: 20px;
                display: flex;
                align-items: center;
                justify-content: center;
            ">×</button>
        </div>
    `;

    document.body.appendChild(toast);

    // Animate in
    setTimeout(() => {
        toast.style.transform = 'translateX(0)';
        toast.style.opacity = '1';
    }, 100);

    // Auto remove
    setTimeout(() => {
        toast.style.transform = 'translateX(100%)';
        toast.style.opacity = '0';
        setTimeout(() => toast.remove(), 300);
    }, 5000);
}

document.addEventListener('DOMContentLoaded', function() {
    if (window.location.pathname.startsWith('/admin')) {
        // Get configuration from meta tags
        const reverbHost = document.querySelector('meta[name="reverb-host"]')?.content || 'localhost';
        const reverbPort = document.querySelector('meta[name="reverb-port"]')?.content || '8080';
        const reverbScheme = document.querySelector('meta[name="reverb-scheme"]')?.content || 'ws';
        const reverbKey = document.querySelector('meta[name="reverb-key"]')?.content || 'app-key';
        const channel = document.querySelector('meta[name="notifications-channel"]')?.content || 'user-notifications';

        // WebSocket connection with configurable settings
        const wsUrl = `${reverbScheme === 'wss' ? 'wss' : 'ws'}://${reverbHost}:${reverbPort}/app/${reverbKey}?protocol=7&client=js&version=8.2.0`;
        const ws = new WebSocket(wsUrl);

        ws.onopen = function() {
            // Subscribe to configurable channel
            const subscribeMessage = {
                event: "pusher:subscribe",
                data: { channel: channel }
            };
            ws.send(JSON.stringify(subscribeMessage));
        };

        ws.onmessage = function(event) {
            const data = JSON.parse(event.data);

            // Handle any custom event (ignore pusher internal events)
            if (data.event && !data.event.startsWith('pusher')) {
                try {
                    const notification = JSON.parse(data.data);

                    // Check if notification has required format
                    if (notification.type && notification.message) {
                        showFilamentToast('Notification', notification.message, notification.type);
                    }
                } catch (e) {
                    console.error('Error parsing notification data:', e);
                }
            }
        };

        ws.onerror = function(error) {
            console.error("REALTIME: WebSocket error:", error);
        };

        ws.onclose = function(event) {
            console.log("REALTIME: WebSocket closed:", event.code, event.reason);
        };
    }
});
