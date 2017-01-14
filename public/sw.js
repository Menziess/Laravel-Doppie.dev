
self.addEventListener('install', e => {
  e.waitUntil(
    caches.open('menzies').then(cache => {
      return cache.addAll([
        '/',
        'offline.html'
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
    fetch(event.request).then(function(response) {
      if (response.status == 404) {
        return new Response("Whoops, not found");
      } else {
        return response;
      }
    }).catch(function() {
      return new Response("Uh oh, that totally failed!");
    })
    // caches.match(event.request).then(response => {
    //   return response || fetch(event.request);
    // })
  );
});
