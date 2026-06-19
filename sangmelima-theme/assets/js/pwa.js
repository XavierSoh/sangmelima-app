/**
 * PWA Handler - SangMeLima
 */

(function() {
    'use strict';

    // ========================================
    // SERVICE WORKER REGISTRATION
    // ========================================
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function() {
            navigator.serviceWorker.register('/sw.js')
                .then(function(registration) {
                    console.log('ServiceWorker registration successful');

                    // Vérifier les mises à jour
                    registration.addEventListener('updatefound', function() {
                        const newWorker = registration.installing;

                        newWorker.addEventListener('statechange', function() {
                            if (newWorker.state === 'activated' && navigator.serviceWorker.controller) {
                                // Nouvelle version disponible
                                showUpdateNotification();
                            }
                        });
                    });
                })
                .catch(function(err) {
                    console.log('ServiceWorker registration failed:', err);
                });
        });
    }

    // ========================================
    // INSTALLATION PWA
    // ========================================
    let deferredPrompt;
    const installPrompt = document.getElementById('install-prompt');
    const installBtn = document.getElementById('install-btn');
    const dismissBtn = document.getElementById('dismiss-btn');

    // Intercepter l'événement d'installation
    window.addEventListener('beforeinstallprompt', function(e) {
        e.preventDefault();
        deferredPrompt = e;

        // Afficher la bannière d'installation
        if (installPrompt && !localStorage.getItem('pwa-install-dismissed')) {
            setTimeout(() => {
                installPrompt.style.display = 'block';
            }, 3000);
        }
    });

    // Bouton d'installation
    if (installBtn) {
        installBtn.addEventListener('click', async function() {
            if (!deferredPrompt) {
                console.log('Installation non disponible');
                return;
            }

            installPrompt.style.display = 'none';

            // Déclencher l'installation
            deferredPrompt.prompt();

            const { outcome } = await deferredPrompt.userChoice;
            console.log('Installation:', outcome);

            if (outcome === 'accepted') {
                // Tracking installation
                if (typeof gtag !== 'undefined') {
                    gtag('event', 'pwa_install', {
                        'event_category': 'engagement',
                        'event_label': 'PWA Installation'
                    });
                }
            }

            deferredPrompt = null;
        });
    }

    // Bouton pour fermer la bannière
    if (dismissBtn) {
        dismissBtn.addEventListener('click', function() {
            installPrompt.style.display = 'none';
            localStorage.setItem('pwa-install-dismissed', 'true');

            // Réafficher dans 7 jours
            setTimeout(() => {
                localStorage.removeItem('pwa-install-dismissed');
            }, 7 * 24 * 60 * 60 * 1000);
        });
    }

    // Détection de l'installation réussie
    window.addEventListener('appinstalled', function() {
        console.log('PWA installée avec succès');

        if (installPrompt) {
            installPrompt.style.display = 'none';
        }

        // Message de bienvenue
        if (window.SangMeLima && window.SangMeLima.showNotification) {
            window.SangMeLima.showNotification('Application installée avec succès !', 'success');
        }
    });

    // ========================================
    // DÉTECTION MODE STANDALONE
    // ========================================
    function isStandalone() {
        return (window.matchMedia('(display-mode: standalone)').matches) ||
               (window.navigator.standalone) ||
               document.referrer.includes('android-app://');
    }

    if (isStandalone()) {
        document.body.classList.add('pwa-standalone');

        // Masquer les éléments d'installation
        if (installPrompt) {
            installPrompt.style.display = 'none';
        }
    }

    // ========================================
    // GESTION DES NOTIFICATIONS PUSH
    // ========================================
    function requestNotificationPermission() {
        if ('Notification' in window && navigator.serviceWorker) {
            Notification.requestPermission().then(function(permission) {
                if (permission === 'granted') {
                    subscribeUserToPush();
                }
            });
        }
    }

    function subscribeUserToPush() {
        navigator.serviceWorker.ready.then(function(registration) {
            const subscribeOptions = {
                userVisibleOnly: true,
                applicationServerKey: urlBase64ToUint8Array('YOUR-VAPID-PUBLIC-KEY')
            };

            return registration.pushManager.subscribe(subscribeOptions);
        })
        .then(function(pushSubscription) {
            console.log('Push subscription:', pushSubscription);

            // Envoyer la subscription au serveur
            return fetch('/api/save-subscription', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(pushSubscription)
            });
        })
        .catch(function(error) {
            console.error('Erreur subscription push:', error);
        });
    }

    // Helper pour convertir la clé VAPID
    function urlBase64ToUint8Array(base64String) {
        const padding = '='.repeat((4 - base64String.length % 4) % 4);
        const base64 = (base64String + padding)
            .replace(/\-/g, '+')
            .replace(/_/g, '/');

        const rawData = window.atob(base64);
        const outputArray = new Uint8Array(rawData.length);

        for (let i = 0; i < rawData.length; ++i) {
            outputArray[i] = rawData.charCodeAt(i);
        }
        return outputArray;
    }

    // ========================================
    // MISE À JOUR DE L'APPLICATION
    // ========================================
    function showUpdateNotification() {
        const updateBanner = document.createElement('div');
        updateBanner.className = 'update-banner';
        updateBanner.innerHTML = `
            <p>Une nouvelle version est disponible</p>
            <button onclick="window.location.reload()">Mettre à jour</button>
        `;

        document.body.appendChild(updateBanner);
    }

    // ========================================
    // CACHE MANAGEMENT
    // ========================================
    if ('caches' in window) {
        // Nettoyer les anciens caches
        caches.keys().then(function(names) {
            names.forEach(function(name) {
                if (name !== 'sangmelima-v1') {
                    caches.delete(name);
                }
            });
        });
    }

    // ========================================
    // GESTION DE LA CONNECTIVITÉ
    // ========================================
    let isOnline = navigator.onLine;

    window.addEventListener('online', function() {
        if (!isOnline) {
            isOnline = true;
            syncOfflineData();

            if (window.SangMeLima && window.SangMeLima.showNotification) {
                window.SangMeLima.showNotification('Connexion rétablie', 'success');
            }
        }
    });

    window.addEventListener('offline', function() {
        isOnline = false;

        if (window.SangMeLima && window.SangMeLima.showNotification) {
            window.SangMeLima.showNotification('Mode hors ligne activé', 'info');
        }
    });

    // Synchroniser les données hors ligne
    function syncOfflineData() {
        const offlineData = localStorage.getItem('offline-queue');

        if (offlineData) {
            const queue = JSON.parse(offlineData);

            queue.forEach(item => {
                fetch(item.url, {
                    method: item.method,
                    headers: item.headers,
                    body: item.body
                })
                .then(() => {
                    console.log('Données synchronisées');
                })
                .catch(error => {
                    console.error('Erreur sync:', error);
                });
            });

            localStorage.removeItem('offline-queue');
        }
    }

    // ========================================
    // BACKGROUND SYNC
    // ========================================
    if ('sync' in ServiceWorkerRegistration.prototype) {
        navigator.serviceWorker.ready.then(function(registration) {
            document.addEventListener('submit', function(e) {
                if (e.target.classList.contains('sync-form')) {
                    e.preventDefault();

                    const formData = new FormData(e.target);

                    // Sauvegarder dans IndexedDB
                    saveFormData(formData).then(() => {
                        return registration.sync.register('sync-form-data');
                    })
                    .then(() => {
                        if (window.SangMeLima && window.SangMeLima.showNotification) {
                            window.SangMeLima.showNotification(
                                'Les données seront envoyées dès que possible',
                                'info'
                            );
                        }
                    });
                }
            });
        });
    }

    // Sauvegarder les données de formulaire
    function saveFormData(formData) {
        return new Promise((resolve, reject) => {
            const data = {
                timestamp: Date.now(),
                data: Object.fromEntries(formData)
            };

            const queue = JSON.parse(localStorage.getItem('form-queue') || '[]');
            queue.push(data);
            localStorage.setItem('form-queue', JSON.stringify(queue));

            resolve();
        });
    }

    // ========================================
    // EXPORT DES FONCTIONS
    // ========================================
    window.PWAManager = {
        requestNotificationPermission: requestNotificationPermission,
        isStandalone: isStandalone,
        syncOfflineData: syncOfflineData
    };

})();