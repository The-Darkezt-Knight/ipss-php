// IPSS Offline-First Service Worker
const CACHE_VERSION = 'ipss-v2';
const STATIC_CACHE = `static-${CACHE_VERSION}`;
const API_CACHE = `api-${CACHE_VERSION}`;

// Assets to pre-cache on install
const PRECACHE_URLS = [
    '/',
    '/private/form',
    'https://cdn.tailwindcss.com?plugins=forms,container-queries',
    'https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;600;700&display=swap',
    'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap',
    '/tesseract/worker.min.js',
    '/tesseract/tesseract-core.wasm.js',
    '/tesseract/tesseract-core.wasm',
    '/tesseract/tesseract-core-simd.wasm.js',
    '/tesseract/tesseract-core-simd.wasm',
    '/tesseract/tesseract-core-lstm.wasm.js',
    '/tesseract/tesseract-core-lstm.wasm',
    '/tesseract/tesseract-core-simd-lstm.wasm.js',
    '/tesseract/tesseract-core-simd-lstm.wasm',
    '/tesseract/tesseract-core-relaxedsimd.wasm.js',
    '/tesseract/tesseract-core-relaxedsimd.wasm',
    '/tesseract/tesseract-core-relaxedsimd-lstm.wasm.js',
    '/tesseract/tesseract-core-relaxedsimd-lstm.wasm',
    '/tesseract/lang-data/eng.traineddata.gz',
];

// ─── Install: Pre-cache critical assets ─────────────────────────────────────
self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(STATIC_CACHE)
            .then((cache) => {
                console.log('[SW] Pre-caching app shell');
                return Promise.allSettled(
                    PRECACHE_URLS.map((url) => cache.add(url))
                ).then((results) => {
                    results.forEach((result, index) => {
                        if (result.status === 'rejected') {
                            console.warn('[SW] Pre-cache failed:', PRECACHE_URLS[index], result.reason);
                        }
                    });
                });
            })
            .then(() => self.skipWaiting())
    );
});

// ─── Activate: Clean up old caches ──────────────────────────────────────────
self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys()
            .then((cacheNames) => {
                return Promise.all(
                    cacheNames
                        .filter((name) => name !== STATIC_CACHE && name !== API_CACHE)
                        .map((name) => {
                            console.log('[SW] Deleting old cache:', name);
                            return caches.delete(name);
                        })
                );
            })
            .then(() => self.clients.claim())
    );
});

// ─── Fetch: Route requests to the correct strategy ─────────────────────────
self.addEventListener('fetch', (event) => {
    const { request } = event;
    const url = new URL(request.url);

    // Skip non-GET requests (let POST/PUT go to network naturally)
    if (request.method !== 'GET') {
        return;
    }

    // API calls → Network-first, fallback to cache
    if (url.pathname.startsWith('/api/')) {
        event.respondWith(networkFirst(request, API_CACHE));
        return;
    }

    // Navigation requests → Network-first, fallback to cached shell
    if (request.mode === 'navigate') {
        event.respondWith(networkFirst(request, STATIC_CACHE));
        return;
    }

    // Static assets (scripts, styles, fonts, images) → Cache-first
    event.respondWith(cacheFirst(request, STATIC_CACHE));
});

// ─── Strategy: Cache-first ──────────────────────────────────────────────────
async function cacheFirst(request, cacheName) {
    const cachedResponse = await caches.match(request);
    if (cachedResponse) {
        return cachedResponse;
    }

    try {
        const networkResponse = await fetch(request);
        if (networkResponse.ok) {
            const cache = await caches.open(cacheName);
            cache.put(request, networkResponse.clone());
        }
        return networkResponse;
    } catch (error) {
        // If both cache and network fail, return a basic offline response
        return new Response('Offline — resource not available', {
            status: 503,
            statusText: 'Service Unavailable',
            headers: { 'Content-Type': 'text/plain' },
        });
    }
}

// ─── Strategy: Network-first ────────────────────────────────────────────────
async function networkFirst(request, cacheName) {
    try {
        const networkResponse = await fetch(request);
        if (networkResponse.ok) {
            const cache = await caches.open(cacheName);
            cache.put(request, networkResponse.clone());
        }
        return networkResponse;
    } catch (error) {
        const cachedResponse = await caches.match(request);
        if (cachedResponse) {
            return cachedResponse;
        }

        // For navigation, try to serve the cached form page as a fallback
        if (request.mode === 'navigate') {
            const fallback = await caches.match('/private/form');
            if (fallback) return fallback;
        }

        return new Response('Offline — resource not available', {
            status: 503,
            statusText: 'Service Unavailable',
            headers: { 'Content-Type': 'text/plain' },
        });
    }
}
