/**
 * HouseAidPro — Service Worker
 * Cache-first for static assets, network-first for API calls.
 */
const CACHE_NAME = 'houseaidpro-v1';
const STATIC_ASSETS = [
    '/maintenance/',
    '/maintenance/index.php',
    '/maintenance/css/variables.css',
    '/maintenance/css/base.css',
    '/maintenance/css/components.css',
    '/maintenance/css/layout.css',
    '/maintenance/css/animations.css',
    '/maintenance/css/wizard.css',
    '/maintenance/css/dashboard.css',
    '/maintenance/js/app.js',
    '/maintenance/js/wizard.js',
    '/maintenance/js/upload.js',
    '/maintenance/js/postcode.js',
    '/maintenance/js/validation.js',
    '/maintenance/js/dashboard.js',
    '/maintenance/manifest.json'
];

// Install — cache static assets
self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => cache.addAll(STATIC_ASSETS))
            .then(() => self.skipWaiting())
    );
});

// Activate — clean old caches
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(keys =>
            Promise.all(keys.filter(k => k !== CACHE_NAME).map(k => caches.delete(k)))
        ).then(() => self.clients.claim())
    );
});

// Fetch — cache-first for static, network-first for API
self.addEventListener('fetch', event => {
    const url = new URL(event.request.url);

    // API calls — network first
    if (url.pathname.includes('/api/')) {
        event.respondWith(
            fetch(event.request).catch(() => caches.match(event.request))
        );
        return;
    }

    // Static assets — cache first
    event.respondWith(
        caches.match(event.request).then(cached => {
            return cached || fetch(event.request).then(response => {
                // Cache new resources dynamically
                if (response.status === 200) {
                    const clone = response.clone();
                    caches.open(CACHE_NAME).then(cache => cache.put(event.request, clone));
                }
                return response;
            });
        }).catch(() => {
            // Offline fallback
            if (event.request.headers.get('accept')?.includes('text/html')) {
                return caches.match('/maintenance/');
            }
        })
    );
});
