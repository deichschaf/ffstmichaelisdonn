const CACHE = 'ffstmichaelisdonn';
const offlineFallbackPage = [
  'offline.html',
  'images/offline.svg',
  'grfx/rotation/06-x-high.png',
  'grfx/rotation/06-high.png',
  'grfx/rotation/06-medium.png',
  'grfx/rotation/06-small.png',
  'images/favicons/favicon.ico',
];

self.addEventListener('install', function (event) {
  console.log('[PWA Builder] Install Event processing');

  event.waitUntil(
    caches.open(CACHE).then(function (cache) {
      console.log('[PWA Builder] Cached offline page during install');
      if (offlineFallbackPage === 'offline.html') {
        return cache.addAll(
          new Response(
            'TODO: Update the value of the offlineFallbackPage constant in the serviceworker.'
          )
        );
      }
      return cache.addAll(offlineFallbackPage);
    })
  );
});

self.addEventListener('fetch', function (event) {
  if (event.request.mode !== 'navigate') return;

  event.respondWith(
    fetch(event.request).catch(function (error) {
      console.error('[PWA Builder] Network request Failed. Serving offline page ' + error);
      return caches.open(CACHE).then(function (cache) {
        return cache.match(offlineFallbackPage);
      });
    })
  );
});

self.addEventListener('refreshOffline', function () {
  const offlinePageRequest = new Request(offlineFallbackPage);

  return fetch(offlineFallbackPage).then(function (response) {
    return caches.open(CACHE).then(function (cache) {
      console.log('[PWA Builder] Offline page updated from refreshOffline event: ' + response.url);
      return cache.put(offlinePageRequest, response);
    });
  });
});
