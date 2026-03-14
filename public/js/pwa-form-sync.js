/**
 * PWA Form Sync - Client-side form submission handler for offline support
 * This file intercepts form submissions and handles them appropriately when offline
 */

// ────────────────────────────────────────────────
// IndexedDB setup for offline form submissions
// ────────────────────────────────────────────────

const DB_NAME1 = 'offline-queue';
const STORE_NAME1 = 'form-submissions';
const DB_VERSION1 = 1;

function openDB() {
    return new Promise((resolve, reject) => {
        const request = indexedDB.open(DB_NAME1, DB_VERSION1);
        request.onerror = () => reject(request.error);
        request.onsuccess = () => resolve(request.result);
        request.onupgradeneeded = (event) => {
            const db = event.target.result;
            if (!db.objectStoreNames.contains(STORE_NAME1)) {
                db.createObjectStore(STORE_NAME1, { autoIncrement: true });
            }
        };
    });
}

async function queueSubmission(url, formData) {
    const db = await openDB();
    return new Promise((resolve, reject) => {
        const tx = db.transaction(STORE_NAME1, 'readwrite');
        const store = tx.objectStore(STORE_NAME1);
        const request = store.add({
            url: url,
            formData: Object.fromEntries(formData),
            timestamp: Date.now()
        });
        request.onsuccess = () => resolve(request.result);
        request.onerror = () => reject(request.error);
    });
}

async function getQueuedSubmissions() {
    const db = await openDB();
    return new Promise((resolve, reject) => {
        const tx = db.transaction(STORE_NAME1, 'readonly');
        const store = tx.objectStore(STORE_NAME1);
        const request = store.getAll();
        request.onsuccess = () => resolve(request.result);
        request.onerror = () => reject(request.error);
    });
}

async function clearSubmission(id) {
    const db = await openDB();
    return new Promise((resolve, reject) => {
        const tx = db.transaction(STORE_NAME1, 'readwrite');
        const store = tx.objectStore(STORE_NAME1);
        const request = store.delete(id);
        request.onsuccess = () => resolve();
        request.onerror = () => reject(request.error);
    });
}

// ────────────────────────────────────────────────
// Form Submission Handler
// ────────────────────────────────────────────────

/**
 * Initialize form sync for all forms on the page
 */
function initializeFormSync() {
    // Get all forms on the page
    const forms = document.querySelectorAll('form[method="POST"]');
    
    forms.forEach(form => {
        // Skip forms that already have the pwa-form-sync class
        if (form.classList.contains('pwa-form-sync')) {
            return;
        }
        
        form.classList.add('pwa-form-sync');
        
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const formData = new FormData(form);
            const url = form.action || window.location.href;
            const isOnline = navigator.onLine;
            
            if (isOnline) {
                // Online → submit normally
                try {
                    const response = await fetch(url, {
                        method: 'POST',
                        body: formData,
                        credentials: 'include',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    
                    if (response.ok) {
                        // Check if response is JSON or HTML
                        const contentType = response.headers.get('content-type');
                        if (contentType && contentType.includes('application/json')) {
                            const data = await response.json();
                            if (data.redirect) {
                                window.location.href = data.redirect;
                            } else if (data.message) {
                                alert(data.message);
                                form.reset();
                            }
                        } else {
                            // HTML response - let it handle the redirect
                            const text = await response.text();
                            if (text.includes('<!DOCTYPE html>') || text.includes('<html')) {
                                // The response is a full HTML page, likely a redirect
                                document.open();
                                document.write(text);
                                document.close();
                            } else {
                                alert('Form submitted successfully!');
                                form.reset();
                            }
                        }
                    } else {
                        // If submission fails, queue it for offline
                        console.error('Form submission failed, queuing for sync:', response.status);
                        await handleOfflineSubmission(form, formData, url);
                    }
                } catch (err) {
                    // Network error → queue for offline
                    console.error('Network error, queuing for sync:', err.message);
                    await handleOfflineSubmission(form, formData, url);
                }
            } else {
                // Offline → queue + register sync
                await handleOfflineSubmission(form, formData, url);
            }
        });
    });
}

/**
 * Handle offline form submission
 */
async function handleOfflineSubmission(form, formData, url) {
    try {
        const submissionId = await queueSubmission(url, formData);
        
        // Register background sync
        if ('serviceWorker' in navigator && 'sync' in window.ServiceWorkerRegistration.prototype) {
            const registration = await navigator.serviceWorker.ready;
            await registration.sync.register('sync-form-submissions');
            console.log('Background sync registered for form submission');
        }
        
        // Show notification
        showOfflineNotification('Form saved offline! Will sync when you are back online.');
        form.reset();
        
        // Optional: redirect to list or show pending indicator
        const redirectUrl = form.dataset.redirect;
        if (redirectUrl) {
            window.location.href = redirectUrl;
        }
        
    } catch (err) {
        console.error('Failed to save offline:', err);
        showOfflineNotification('Failed to save form: ' + err.message, 'error');
    }
}

/**
 * Show offline notification
 */
function showOfflineNotification(message, type = 'info') {
    // Check if alertify is available
    if (typeof alertify !== 'undefined') {
        if (type === 'error') {
            alertify.error(message);
        } else {
            alertify.success(message);
        }
    } else if (typeof toastr !== 'undefined') {
        if (type === 'error') {
            toastr.error(message);
        } else {
            toastr.success(message);
        }
    } else {
        alert(message);
    }
}

/**
 * Check and display pending submissions count
 */
async function displayPendingCount() {
    try {
        const queued = await getQueuedSubmissions();
        if (queued.length > 0) {
            showOfflineNotification(`You have ${queued.length} pending form submission(s) that will sync when online.`, 'info');
        }
    } catch (err) {
        console.error('Failed to check pending submissions:', err);
    }
}

/**
 * Trigger manual sync of queued submissions
 */
async function triggerManualSync() {
    try {
        const queued = await getQueuedSubmissions();
        if (queued.length === 0) {
            console.log('No pending submissions to sync');
            return;
        }
        
        console.log(`Syncing ${queued.length} pending submissions...`);
        
        for (const item of queued) {
            try {
                const response = await fetch(item.url, {
                    method: 'POST',
                    headers: { 
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: new URLSearchParams(item.formData).toString(),
                    credentials: 'include',
                });
                
                if (response.ok) {
                    await clearSubmission(item.id || item.key);
                    console.log('[PWA] Synced form submission successfully:', item.url);
                } else {
                    console.error('[PWA] Sync failed, status:', response.status, 'for:', item.url);
                }
            } catch (err) {
                console.error('[PWA] Sync network error for:', item.url, err);
            }
        }
        
        // Check remaining submissions
        const remaining = await getQueuedSubmissions();
        if (remaining.length === 0) {
            showOfflineNotification('All pending forms have been synced successfully!', 'info');
        } else {
            showOfflineNotification(`${remaining.length} form(s) failed to sync. Will retry later.`, 'error');
        }
    } catch (err) {
        console.error('[PWA] Manual sync error:', err);
    }
}

// ────────────────────────────────────────────────
// Event Listeners
// ────────────────────────────────────────────────

// Initialize when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeFormSync);
} else {
    initializeFormSync();
}

// Listen for online events to show pending submissions
window.addEventListener('online', () => {
    console.log('Back online!');
    displayPendingCount();
    // Trigger manual sync when coming online
    triggerManualSync();
});

// Listen for offline events
window.addEventListener('offline', () => {
    console.log('You are now offline');
    showOfflineNotification('You are now offline. Forms will be saved and synced when you are back online.', 'info');
});

// Check for pending submissions on page load
window.addEventListener('load', displayPendingCount);

// ────────────────────────────────────────────────
// Export functions for manual use if needed
// ────────────────────────────────────────────────

window.PWAFormSync = {
    queueSubmission,
    getQueuedSubmissions,
    clearSubmission,
    initializeFormSync,
    displayPendingCount,
    triggerManualSync
};
