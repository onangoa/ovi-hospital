"use strict";

const CACHE_NAME = "offline-cache-v1";
const OFFLINE_URL = "/offline.html";

// Files to precache
const filesToCache = [
    OFFLINE_URL,
    "/dashboard",
    "/wards"
];


// ─────────────────────────────────────────────
// INSTALL
// ─────────────────────────────────────────────

self.addEventListener("install", (event) => {

    event.waitUntil(
        caches.open(CACHE_NAME)
            .then((cache) => {
                console.log("[SW] Pre-caching files");
                return cache.addAll(filesToCache);
            })
    );

    self.skipWaiting();

});


// ─────────────────────────────────────────────
// ACTIVATE
// ─────────────────────────────────────────────

self.addEventListener("activate", (event) => {

    event.waitUntil(

        caches.keys().then((names) => {

            return Promise.all(
                names.map((name) => {

                    if (name !== CACHE_NAME) {
                        console.log("[SW] Removing old cache:", name);
                        return caches.delete(name);
                    }

                })
            );

        })

    );

    self.clients.claim();

});


// ─────────────────────────────────────────────
// FETCH HANDLER
// ─────────────────────────────────────────────

self.addEventListener("fetch", (event) => {

    if (event.request.method !== "GET") return;

    // PAGE NAVIGATION
    if (event.request.mode === "navigate") {

        event.respondWith(

            Promise.race([

                fetch(event.request),

                // If network takes longer than 2 seconds → treat as offline
                new Promise((_, reject) =>
                    setTimeout(() => reject(new Error("timeout")), 2000)
                )

            ])

                .then((networkResponse) => {

                    if (networkResponse && networkResponse.status === 200) {

                        const clone = networkResponse.clone();

                        caches.open(CACHE_NAME).then((cache) => {
                            cache.put(event.request, clone);
                        });

                    }

                    return networkResponse;

                })

                .catch(async () => {

                    // Try cache first
                    const cached = await caches.match(event.request);

                    if (cached) {
                        console.log("[SW] Serving cached page:", event.request.url);
                        return cached;
                    }

                    console.log("[SW] Showing offline page");

                    return caches.match(OFFLINE_URL);

                })

        );

        return;

    }


    // STATIC FILES
    event.respondWith(

        caches.match(event.request)
            .then((cached) => {

                if (cached) return cached;

                return fetch(event.request)

                    .then((networkResponse) => {

                        if (networkResponse && networkResponse.status === 200) {

                            const clone = networkResponse.clone();

                            caches.open(CACHE_NAME).then((cache) => {
                                cache.put(event.request, clone);
                            });

                        }

                        return networkResponse;

                    })

                    .catch(() => {

                        return new Response("Offline", {
                            status: 503,
                            statusText: "Offline"
                        });

                    });

            })

    );

});



// ─────────────────────────────────────────────
// IndexedDB setup for offline form submissions
// ─────────────────────────────────────────────

const DB_NAME = "offline-queue";
const STORE_NAME = "form-submissions";
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

        const tx = db.transaction(STORE_NAME, "readonly");
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

            keys.forEach((key) => {

                const getRequest = store.get(key);

                getRequest.onsuccess = () => {

                    items.push({
                        id: key,
                        ...getRequest.result
                    });

                    pending--;

                    if (pending === 0) resolve(items);

                };

                getRequest.onerror = () => {

                    pending--;

                    if (pending === 0) resolve(items);

                };

            });

        };

        request.onerror = () => reject(request.error);

    });

}


async function clearSubmission(id) {

    const db = await openDB();

    return new Promise((resolve, reject) => {

        const tx = db.transaction(STORE_NAME, "readwrite");

        const store = tx.objectStore(STORE_NAME);

        const request = store.delete(id);

        request.onsuccess = () => resolve();

        request.onerror = () => reject(request.error);

    });

}



// ─────────────────────────────────────────────
// BACKGROUND SYNC
// ─────────────────────────────────────────────

self.addEventListener("sync", (event) => {

    if (event.tag.startsWith("sync-")) {
        event.waitUntil(syncFormSubmissions());
    }

});


self.addEventListener("message", (event) => {

    if (event.data && event.data.type === "SYNC_FORMS") {

        event.waitUntil(

            isActuallyOnline().then((online) => {

                if (!online) return;

                return syncFormSubmissions().then(() => {

                    self.clients.matchAll().then((clients) => {

                        clients.forEach((client) => {

                            client.postMessage({
                                type: "SYNC_COMPLETE"
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

        console.log("[SW] Syncing", queued.length, "items");

        for (const item of queued) {

            try {

                const response = await fetch(item.url, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: new URLSearchParams(item.formData).toString(),
                    credentials: "include",
                    redirect: "manual"
                });

                if (
                    response.ok ||
                    response.status === 302 ||
                    response.status === 303 ||
                    response.type === "opaqueredirect"
                ) {

                    await clearSubmission(item.id);

                    console.log("[SW] Synced:", item.url);

                }

            } catch (err) {

                console.error("[SW] Sync failed:", err);

            }

        }

    } catch (err) {

        console.error("[SW] Sync error:", err);

    }

}



async function isActuallyOnline() {

    try {

        const response = await fetch("/favicon.ico", {
            method: "HEAD",
            cache: "no-cache"
        });

        return response.ok;

    } catch {

        return false;

    }

}