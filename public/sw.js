
self.addEventListener('install', e => {
  e.waitUntil(
    caches.open('menzies').then(cache => {
      return cache.addAll([
        '/',
        // '/laravel.dev/public',
        './offline.html',
        './favicon.ico'
      ])
      .then(() => self.skipWaiting());
    })
  )
});

self.addEventListener('activate',  e => {
  e.waitUntil(self.clients.claim());
});

self.addEventListener('fetch', e => {
  e.respondWith(
    caches.match(e.request).then(response => {
      return response || fetch(e.request);
    }).catch(function() {
      return caches.match('offline.html');
    })
  );
});
