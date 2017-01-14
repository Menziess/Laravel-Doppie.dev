
self.addEventListener('install', e => {
  e.waitUntil(
    caches.open('menzies').then(cache => {
      return cache.addAll([
        '/',
        '../offline.html'
      ])
      .then(() => self.skipWaiting());
    })
  )
});

self.addEventListener('activate',  event => {
  event.waitUntil(self.clients.claim());
});

self.addEventListener('fetch', event => {
  event.respondWith(
    caches.match(event.request).then(response => {
      return response || fetch(event.request);
    })
  );
});
