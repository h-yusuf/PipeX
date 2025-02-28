self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open('v2').then((cache) => {
            return cache.addAll([
                '/',
                '/offline',
                '/icons/icon-app-192.png',
            ]);
        })
    );
});

self.addEventListener('fetch', (event) => {
    const requestURL = new URL(event.request.url);
    // Skip caching for chrome-extension requests
    if (requestURL.protocol === 'chrome-extension:') {
        return;
    }

    event.respondWith(
        fetch(event.request).then((networkResponse) => {
            return caches.open('dynamic-cache').then((cache) => {
                // Only cache GET requests
                if (event.request.method === 'GET') {
                    cache.put(event.request, networkResponse.clone());
                }
                return networkResponse;
            });
        }).catch(() => {
            return caches.match(event.request).then((cachedResponse) => {
                return cachedResponse || caches.match('/offline');
            });
        })
    );
});



