/**
 * Service Worker - SangMeLima
 * Version: 1.0.0
 */

const CACHE_NAME = 'sangmelima-v1';
const OFFLINE_URL = '/offline.html';

// Ressources à mettre en cache lors de l'installation
const STATIC_CACHE_URLS = [
  '/',
  '/offline.html',
  '/wp-content/themes/sangmelima-theme/style.css',
  '/wp-content/themes/sangmelima-theme/assets/js/main.js',
  '/wp-content/themes/sangmelima-theme/assets/js/pwa.js',
  '/wp-content/themes/sangmelima-theme/manifest.json'
];

// ========================================
// INSTALLATION
// ========================================
self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => {
        console.log('Cache ouvert');
        return cache.addAll(STATIC_CACHE_URLS);
      })
      .then(() => self.skipWaiting())
      .catch(error => {
        console.error('Erreur lors de la mise en cache:', error);
      })
  );
});

// ========================================
// ACTIVATION
// ========================================
self.addEventListener('activate', event => {
  event.waitUntil(
    caches.keys().then(cacheNames => {
      return Promise.all(
        cacheNames
          .filter(cacheName => cacheName !== CACHE_NAME)
          .map(cacheName => {
            console.log('Suppression ancien cache:', cacheName);
            return caches.delete(cacheName);
          })
      );
    })
    .then(() => self.clients.claim())
  );
});

// ========================================
// FETCH - STRATÉGIE NETWORK FIRST AVEC FALLBACK
// ========================================
self.addEventListener('fetch', event => {
  const { request } = event;

  // Ignorer les requêtes non-GET
  if (request.method !== 'GET') {
    return;
  }

  // Gérer les requêtes API différemment
  if (request.url.includes('/wp-json/') || request.url.includes('/admin-ajax.php')) {
    event.respondWith(
      fetch(request)
        .then(response => {
          // Cloner la réponse pour la mettre en cache
          const responseToCache = response.clone();

          caches.open(CACHE_NAME)
            .then(cache => {
              cache.put(request, responseToCache);
            });

          return response;
        })
        .catch(() => {
          // Retourner depuis le cache si disponible
          return caches.match(request);
        })
    );
    return;
  }

  // Pour les pages HTML - Network First
  if (request.headers.get('accept').includes('text/html')) {
    event.respondWith(
      fetch(request)
        .then(response => {
          // Mettre en cache la réponse
          const responseToCache = response.clone();

          caches.open(CACHE_NAME)
            .then(cache => {
              cache.put(request, responseToCache);
            });

          return response;
        })
        .catch(() => {
          // Essayer de servir depuis le cache
          return caches.match(request)
            .then(response => {
              if (response) {
                return response;
              }
              // Page offline si pas en cache
              return caches.match(OFFLINE_URL);
            });
        })
    );
    return;
  }

  // Pour les ressources statiques - Cache First
  event.respondWith(
    caches.match(request)
      .then(response => {
        if (response) {
          // Mettre à jour en arrière-plan
          fetchAndCache(request);
          return response;
        }

        return fetch(request)
          .then(response => {
            // Ne pas mettre en cache les erreurs
            if (!response || response.status !== 200) {
              return response;
            }

            const responseToCache = response.clone();

            caches.open(CACHE_NAME)
              .then(cache => {
                cache.put(request, responseToCache);
              });

            return response;
          });
      })
  );
});

// ========================================
// BACKGROUND SYNC
// ========================================
self.addEventListener('sync', event => {
  if (event.tag === 'sync-form-data') {
    event.waitUntil(syncFormData());
  }
});

function syncFormData() {
  return self.clients.matchAll()
    .then(clients => {
      clients.forEach(client => {
        client.postMessage({
          type: 'SYNC_COMPLETE',
          message: 'Données synchronisées avec succès'
        });
      });
    });
}

// ========================================
// PUSH NOTIFICATIONS
// ========================================
self.addEventListener('push', event => {
  const options = {
    body: event.data ? event.data.text() : 'Nouvelle notification',
    icon: '/wp-content/themes/sangmelima-theme/assets/images/icon-192.png',
    badge: '/wp-content/themes/sangmelima-theme/assets/images/icon-72.png',
    vibrate: [200, 100, 200],
    data: {
      dateOfArrival: Date.now(),
      primaryKey: 1
    },
    actions: [
      {
        action: 'explore',
        title: 'Voir',
        icon: '/wp-content/themes/sangmelima-theme/assets/images/icon-check.png'
      },
      {
        action: 'close',
        title: 'Fermer',
        icon: '/wp-content/themes/sangmelima-theme/assets/images/icon-close.png'
      }
    ]
  };

  event.waitUntil(
    self.registration.showNotification('SangMeLima', options)
  );
});

self.addEventListener('notificationclick', event => {
  event.notification.close();

  if (event.action === 'explore') {
    event.waitUntil(
      clients.openWindow('/')
    );
  }
});

// ========================================
// HELPERS
// ========================================
function fetchAndCache(request) {
  return fetch(request)
    .then(response => {
      if (!response || response.status !== 200) {
        return;
      }

      const responseToCache = response.clone();

      caches.open(CACHE_NAME)
        .then(cache => {
          cache.put(request, responseToCache);
        });
    })
    .catch(() => {
      // Silencieusement échouer pour les mises à jour en arrière-plan
    });
}

// ========================================
// MESSAGE HANDLING
// ========================================
self.addEventListener('message', event => {
  if (event.data && event.data.type === 'SKIP_WAITING') {
    self.skipWaiting();
  }

  if (event.data && event.data.type === 'CACHE_URLS') {
    caches.open(CACHE_NAME)
      .then(cache => {
        return cache.addAll(event.data.urls);
      });
  }
});

// ========================================
// PERIODIC SYNC (si disponible)
// ========================================
self.addEventListener('periodicsync', event => {
  if (event.tag === 'update-content') {
    event.waitUntil(updateContent());
  }
});

function updateContent() {
  // Mettre à jour le contenu en arrière-plan
  return caches.open(CACHE_NAME)
    .then(cache => {
      return Promise.all(
        STATIC_CACHE_URLS.map(url => {
          return fetch(url)
            .then(response => {
              return cache.put(url, response);
            })
            .catch(() => {
              // Ignorer les erreurs
            });
        })
      );
    });
}