/**
 * PWA Service Worker Update Handler
 * Automatically handles service worker updates and page reloads
 */

(function() {
    'use strict';

    // Check if service workers are supported
    if (!('serviceWorker' in navigator)) {
        console.log('[PWA Update Handler] Service workers are not supported in this browser');
        return;
    }

    let newWorker = null;
    let refreshing = false;

    // Register service worker
    navigator.serviceWorker.register('/sw.js')
        .then((registration) => {
            console.log('[PWA Update Handler] Service Worker registered with scope:', registration.scope);

            // Check for updates immediately
            registration.update();

            // Listen for service worker updates
            registration.addEventListener('updatefound', () => {
                const installingWorker = registration.installing;

                if (!installingWorker) {
                    return;
                }

                installingWorker.addEventListener('statechange', () => {
                    console.log('[PWA Update Handler] Service Worker state:', installingWorker.state);

                    if (installingWorker.state === 'installed' && navigator.serviceWorker.controller) {
                        // New service worker is available but waiting
                        console.log('[PWA Update Handler] New service worker available');
                        newWorker = installingWorker;

                        // Notify the user about the update
                        showUpdateNotification();
                    }
                });
            });

            // Listen for controller changes (when the new service worker takes control)
            navigator.serviceWorker.addEventListener('controllerchange', () => {
                if (!refreshing) {
                    console.log('[PWA Update Handler] Controller changed, reloading page...');
                    refreshing = true;
                    window.location.reload();
                }
            });

            // Listen for messages from the service worker
            navigator.serviceWorker.addEventListener('message', (event) => {
                const { type, version } = event.data;

                if (type === 'SW_UPDATE_AVAILABLE') {
                    console.log('[PWA Update Handler] Service worker update available, version:', version);
                    showUpdateNotification(version);
                } else if (type === 'SW_ACTIVATED') {
                    console.log('[PWA Update Handler] Service worker activated, version:', version);
                    // The new service worker has been activated, reload the page
                    if (!refreshing) {
                        refreshing = true;
                        window.location.reload();
                    }
                } else if (type === 'SYNC_COMPLETE') {
                    console.log('[PWA Update Handler] Sync completed');
                }
            });

            // Periodically check for updates (every 30 minutes)
            setInterval(() => {
                registration.update();
            }, 30 * 60 * 1000);

        })
        .catch((error) => {
            console.error('[PWA Update Handler] Service Worker registration failed:', error);
        });

    /**
     * Show update notification to the user
     * @param {string} version - The new service worker version
     */
    function showUpdateNotification(version) {
        // Create notification element if it doesn't exist
        let notification = document.getElementById('pwa-update-notification');

        if (!notification) {
            notification = document.createElement('div');
            notification.id = 'pwa-update-notification';
            notification.style.cssText = `
                position: fixed;
                bottom: 20px;
                right: 20px;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                padding: 16px 24px;
                border-radius: 8px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                z-index: 9999;
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
                max-width: 400px;
                animation: slideIn 0.3s ease-out;
            `;

            document.body.appendChild(notification);
        }

        notification.innerHTML = `
            <div style="display: flex; align-items: center; gap: 12px;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/>
                    <path d="M3 3v5h5"/>
                    <path d="M3 12a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L21 16"/>
                    <path d="M16 21h5v-5"/>
                </svg>
                <div>
                    <div style="font-weight: 600; margin-bottom: 4px;">Update Available</div>
                    <div style="font-size: 14px; opacity: 0.9;">A new version is ready. Refresh to update.</div>
                </div>
                <button id="pwa-update-btn" style="
                    background: white;
                    color: #667eea;
                    border: none;
                    padding: 8px 16px;
                    border-radius: 4px;
                    font-weight: 600;
                    cursor: pointer;
                    white-space: nowrap;
                ">Refresh</button>
            </div>
        `;

        // Add animation styles
        if (!document.getElementById('pwa-update-styles')) {
            const style = document.createElement('style');
            style.id = 'pwa-update-styles';
            style.textContent = `
                @keyframes slideIn {
                    from {
                        transform: translateX(100%);
                        opacity: 0;
                    }
                    to {
                        transform: translateX(0);
                        opacity: 1;
                    }
                }
                @keyframes slideOut {
                    from {
                        transform: translateX(0);
                        opacity: 1;
                    }
                    to {
                        transform: translateX(100%);
                        opacity: 0;
                    }
                }
            `;
            document.head.appendChild(style);
        }

        // Add click handler to refresh button
        const refreshBtn = document.getElementById('pwa-update-btn');
        if (refreshBtn) {
            refreshBtn.addEventListener('click', () => {
                applyUpdate();
            });
        }

        // Auto-apply update after 30 seconds if user doesn't respond
        setTimeout(() => {
            if (notification && notification.parentNode) {
                applyUpdate();
            }
        }, 30000);
    }

    /**
     * Apply the service worker update
     */
    function applyUpdate() {
        console.log('[PWA Update Handler] Applying update...');

        // Tell the new service worker to skip waiting
        if (newWorker) {
            newWorker.postMessage({ type: 'SKIP_WAITING' });
        } else {
            // If we don't have a reference to the new worker, try to get it
            navigator.serviceWorker.getRegistration().then((registration) => {
                if (registration && registration.waiting) {
                    registration.waiting.postMessage({ type: 'SKIP_WAITING' });
                } else {
                    // Fallback: just reload the page
                    console.log('[PWA Update Handler] No waiting worker, reloading page...');
                    window.location.reload();
                }
            });
        }

        // Hide notification with animation
        const notification = document.getElementById('pwa-update-notification');
        if (notification) {
            notification.style.animation = 'slideOut 0.3s ease-out';
            setTimeout(() => {
                if (notification && notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        }
    }

    /**
     * Force check for service worker updates
     * Can be called manually if needed
     */
    window.forceSWUpdate = function() {
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.getRegistration().then((registration) => {
                if (registration) {
                    console.log('[PWA Update Handler] Forcing update check...');
                    registration.update();
                }
            });
        }
    };

    console.log('[PWA Update Handler] Initialized');

})();
