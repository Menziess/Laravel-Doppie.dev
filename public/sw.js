self.addEventListener('install', event => {
  event.waitUntil(
    caches.open('menzies').then(cache => {
      return cache.addAll([
        './js/index.js',
        './offline.html',
        './favicon.ico',
      ])
      .then(() => self.skipWaiting());
    })
  )
});

self.addEventListener('activate', event => {
  event.waitUntil(self.clients.claim());
});

self.addEventListener('fetch', event => {
  event.respondWith(
    caches.match(event.request).then(response => {
      return response || fetch(event.request);
    }).catch(function() {
      return caches.match('offline.html');
    })
  );
});
