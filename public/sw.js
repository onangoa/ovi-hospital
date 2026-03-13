"use strict";

const CACHE_NAME = "offline-cache-v1";
const OFFLINE_URL = '/offline.html';

// List of URLs to precache
const filesToCache = [
    OFFLINE_URL,
    'https://ovihospital.co.ke/doctor-details',
    '/doctor-details/create'                         // trailing slash variant if needed
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