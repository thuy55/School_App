var cacheName = 'ECLO';
var filesToCache = [
  './service-worker.js',
];
self.addEventListener('install', function(e) {
  e.waitUntil(
    caches.open(cacheName).then(function(cache) {
      return cache.addAll(filesToCache);
    })
  );
});
self.addEventListener('activate', function(e) {
  e.waitUntil(
    caches.keys().then(function(keyList) {
      return Promise.all(keyList.map(function(key) {
        if (key !== cacheName) {
          return caches.delete(key);
        }
      }));
    })
  );
  return self.clients.claim();
});
self.addEventListener('fetch', function(event) {
  event.respondWith(
    caches.open(cacheName).then(function(cache){
      return fetch(event.request).then((response) => {
          if (response.status === 200) {
            cache.put(event.request.url, response.clone());
          }
          return response;
      })
    }).catch(function() {
      return caches.match(event.request.url);
    })
  );
});