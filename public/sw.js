
self.addEventListener('install', e => {
  e.waitUntil(
    caches.open('menzies').then(cache => {
      return cache.addAll([
        '/',
        'offline.html',
        'favicon.ico',

        'css/styles.css',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css',
        'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/css/bootstrap.min.css',
        'https://fonts.googleapis.com/css?family=Lato:100,300,400,700',
        'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/js/bootstrap.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js',
        'https://cdn.jsdelivr.net/tether/1.3.2/tether.min.js',
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
    }).catch(function() {
      return Response('lol');
    })

    // fetch(event.request).then(function(response) {
    //   return response;
    // }).catch(function() {
    //   return caches.match('offline.html');
    //   return new Response("Uh oh, that totally failed!");
    // })
  );
});
