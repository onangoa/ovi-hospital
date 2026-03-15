"use strict";

const CACHE_NAME = "offline-cache-v1";
const OFFLINE_URL = '/offline.html';

// List of URLs to precache
const filesToCache = [
    OFFLINE_URL,
    // Core pages
    '/dashboard',
    '/apsetting',
    '/general',
    '/profile/setting',
    '/profile/password',
    '/profile/view',
    // Hikvision pages
    '/hikvision',
    // Reports
    '/financial-reports',
    '/clinical-leaderboard',
    '/weekly-wellness-checks/report',
    '/therapy-reports',
    // Resource index pages
    '/account-headers',
    '/payments',
    '/hospital-departments',
    '/doctor-details',
    '/patient-details',
    '/doctor-assignments',
    '/patient-case-studies',
    '/prescriptions',
    '/lab-report-templates',
    '/lab-reports',
    '/cvi',
    '/care-plans',
    '/initial-evaluations',
    '/caregiver-daily-reports',
    '/lab-requests',
    '/ward-round-notes',
    '/weekly-wellness-checks',
    '/wards',
    '/medical-referrals',
    '/radiology-requests',
    '/drug-orders',
    '/nursing-cardexes',
    '/vital-signs',
    '/front-ends',
    '/contacts',
    '/sms-apis',
    '/sms-templates',
    '/sms-campaigns',
    '/email-templates',
    '/email-campaigns',
    '/insurances',
    '/invoices',
    '/roles',
    '/users',
    '/smtp-configurations',
    '/company',
    // Create forms
    '/account-headers/create',
    '/payments/create',
    '/hospital-departments/create',
    '/doctor-details/create',
    '/patient-details/create',
    '/doctor-assignments/create',
    '/patient-case-studies/create',
    '/prescriptions/create',
    '/lab-report-templates/create',
    '/lab-reports/create',
    '/cvi/create',
    '/care-plans/create',
    '/initial-evaluations/create',
    '/caregiver-daily-reports/create',
    '/lab-requests/create',
    '/ward-round-notes/create',
    '/weekly-wellness-checks/create',
    '/wards/create',
    '/medical-referrals/create',
    '/radiology-requests/create',
    '/drug-orders/create',
    '/nursing-cardexes/create',
    '/vital-signs/create',
    '/front-ends/create',
    '/contacts/create',
    '/sms-apis/create',
    '/sms-templates/create',
    '/sms-campaigns/create',
    '/email-templates/create',
    '/email-campaigns/create',
    '/insurances/create',
    '/invoices/create',
    '/roles/create',
    '/users/create',
    '/smtp-configurations/create',
    '/company/create',
    // Therapy forms
    '/individual-therapy/create',
    '/group-therapy/create',
    // Components
    '/components/vital-signs',
    '/vital-sign/clinical-forms'
];

self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then((cache) => {
                console.log('[ServiceWorker] Pre-caching files');
                return cache.addAll(filesToCache);
            })
            .catch((error) => {
                console.error('[ServiceWorker] Pre-cache failed:', error);
            })
    );
    // Skip waiting so the new service worker activates immediately
    self.skipWaiting();
});

self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames.map((cacheName) => {
                    if (cacheName !== CACHE_NAME) {
                        console.log('[ServiceWorker] Deleting old cache:', cacheName);
                        return caches.delete(cacheName);
                    }
                })
            );
        })
    );
    // Take control of the page immediately
    self.clients.claim();
});

self.addEventListener('fetch', (event) => {
    // Only handle GET requests
    if (event.request.method !== 'GET') {
        return;
    }

    if (event.request.mode === 'navigate') {
        // Navigation requests (HTML pages) → network-first, then cache, then offline fallback
        event.respondWith(
            fetch(event.request)
                .then((networkResponse) => {
                    // Optional: update cache with fresh version when online
                    if (networkResponse && networkResponse.status === 200) {
                        const responseToCache = networkResponse.clone();
                        caches.open(CACHE_NAME)
                            .then((cache) => {
                                cache.put(event.request, responseToCache);
                            });
                    }
                    return networkResponse;
                })
                .catch(() => {
                    // Offline → try cache first
                    return caches.match(event.request)
                        .then((cachedResponse) => {
                            if (cachedResponse) {
                                console.log('[ServiceWorker] Serving from cache:', event.request.url);
                                return cachedResponse;
                            }
                            // No cached page → show offline fallback
                            console.log('[ServiceWorker] Falling back to offline.html');
                            return caches.match(OFFLINE_URL);
                        });
                })
        );
    } else {
        // For all other requests (images, css, js, api, etc.) → cache-first, then network
        event.respondWith(
            caches.match(event.request)
                .then((cachedResponse) => {
                    if (cachedResponse) {
                        return cachedResponse;
                    }
                    return fetch(event.request)
                        .then((networkResponse) => {
                            // Optional: cache successful responses
                            if (networkResponse && networkResponse.status === 200) {
                                const responseToCache = networkResponse.clone();
                                caches.open(CACHE_NAME)
                                    .then((cache) => {
                                        cache.put(event.request, responseToCache);
                                    });
                            }
                            return networkResponse;
                        })
                        .catch(() => {
                            // Optional: you could add fallback images or other assets here
                            return new Response('Network unavailable', { status: 503 });
                        });
                })
        );
    }
});

// ────────────────────────────────────────────────
// IndexedDB setup for offline form submissions
// ────────────────────────────────────────────────

const DB_NAME = 'offline-queue';
const STORE_NAME = 'form-submissions';
const DB_VERSION = 1;

function openDB() {
    return new Promise((resolve, reject) => {
        const request = indexedDB.open(DB_NAME, DB_VERSION);
        request.onerror = () => reject(request.error);
        request.onsuccess = () => resolve(request.result);
        request.onupgradeneeded = (event) => {
            const db = event.target.result;
            if (!db.objectStoreNames.contains(STORE_NAME)) {
                db.createObjectStore(STORE_NAME, { autoIncrement: true });
            }
        };
    });
}

async function getQueuedSubmissions() {
    const db = await openDB();
    return new Promise((resolve, reject) => {
        const tx = db.transaction(STORE_NAME, 'readonly');
        const store = tx.objectStore(STORE_NAME);
        const request = store.getAllKeys();
        request.onsuccess = () => {
            const keys = request.result;
            const items = [];
            let pending = keys.length;
            
            if (pending === 0) {
                resolve([]);
                return;
            }
            
            keys.forEach(key => {
                const getRequest = store.get(key);
                getRequest.onsuccess = () => {
                    items.push({
                        id: key,
                        ...getRequest.result
                    });
                    pending--;
                    if (pending === 0) {
                        resolve(items);
                    }
                };
                getRequest.onerror = () => {
                    pending--;
                    if (pending === 0) {
                        resolve(items);
                    }
                };
            });
        };
        request.onerror = () => reject(request.error);
    });
}

async function clearSubmission(id) {
    const db = await openDB();
    return new Promise((resolve, reject) => {
        const tx = db.transaction(STORE_NAME, 'readwrite');
        const store = tx.objectStore(STORE_NAME);
        const request = store.delete(id);
        request.onsuccess = () => resolve();
        request.onerror = () => reject(request.error);
    });
}

// ────────────────────────────────────────────────
// Background Sync for offline form submissions
// ────────────────────────────────────────────────

self.addEventListener('sync', (event) => {
    // Handle all form sync events
    if (event.tag.startsWith('sync-')) {
        event.waitUntil(syncFormSubmissions());
    }
});

// Listen for messages from clients to trigger sync
self.addEventListener('message', (event) => {
    if (event.data && event.data.type === 'SYNC_FORMS') {
        event.waitUntil(
            isActuallyOnline().then(online => {
                if (!online) {
                    console.log('[SW] Not actually online, skipping sync');
                    return;
                }
                return syncFormSubmissions().then(() => {
                    // Notify all clients that sync is complete
                    self.clients.matchAll().then(clients => {
                        clients.forEach(client => {
                            client.postMessage({
                                type: 'SYNC_COMPLETE'
                            });
                        });
                    });
                });
            })
        );
    }
});

async function syncFormSubmissions() {
    try {
        const queued = await getQueuedSubmissions();
        console.log('[SW] Starting sync for', queued.length, 'submissions');

        let successCount = 0;
        let failCount = 0;

        for (const item of queued) {
            try {

                const response = await fetch(item.url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams(item.formData).toString(),
                    credentials: 'include',
                    redirect: 'manual' // important for Laravel 302 redirects
                });

                console.log('[SW] Response received:', response);

                // Laravel usually returns 302 or 303 after POST
                if (
                    response.ok ||
                    response.status === 302 ||
                    response.status === 303 ||
                    response.type === 'opaqueredirect'
                ) {

                    await clearSubmission(item.id);
                    successCount++;

                    console.log('[SW] Synced form submission successfully:', item.url);

                } else {

                    failCount++;
                    console.error('[SW] Sync failed with status:', response.status, 'for:', item.url);

                }

            } catch (err) {

                failCount++;
                console.error('[SW] Sync network error for:', item.url, err);

                // do not remove → retry next sync
            }
        }

        console.log(`[SW] Sync complete: ${successCount} succeeded, ${failCount} failed`);

    } catch (err) {
        console.error('[SW] Sync error:', err);
    }
}

/**
 * Check if we're actually online by making a simple request
 */
async function isActuallyOnline() {
    try {
        const response = await fetch('/assets/images/favicon.png', {
            method: 'HEAD',
            cache: 'no-cache'
        });
        return response.ok;
    } catch (err) {
        return false;
    }
}