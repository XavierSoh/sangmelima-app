/**
 * JavaScript principal - SangMeLima
 */

(function() {
    'use strict';

    // ========================================
    // GESTION DU MENU MOBILE
    // ========================================
    const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    const menuIcon = document.querySelector('.menu-icon');
    const closeIcon = document.querySelector('.close-icon');

    if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener('click', function() {
            const isOpen = mobileMenu.style.display === 'block';

            mobileMenu.style.display = isOpen ? 'none' : 'block';
            menuIcon.style.display = isOpen ? 'inline' : 'none';
            closeIcon.style.display = isOpen ? 'none' : 'inline';
            mobileMenuToggle.setAttribute('aria-expanded', !isOpen);
        });
    }

    // ========================================
    // CHARGEMENT API AELF
    // ========================================
    function loadAelfContent(selectedDate = null) {
        const aelfElements = document.querySelectorAll('[data-aelf]');
        const date = selectedDate || new Date().toISOString().split('T')[0]; // Format YYYY-MM-DD

        aelfElements.forEach(element => {
            const type = element.getAttribute('data-aelf');
            const contentBody = element.querySelector('.daily-content-body');

            if (contentBody) {
                // Ajouter skeleton loaders pendant le chargement
                contentBody.innerHTML = `
                    <div class="skeleton skeleton-text"></div>
                    <div class="skeleton skeleton-text"></div>
                    <div class="skeleton skeleton-text"></div>
                `;

                // URL correcte de l'API AELF avec la date sélectionnée
                const apiUrl = `https://api.aelf.org/v1/messes/${date}`;

                // Appel API
                fetch(apiUrl)
                    .then(response => {
                        if (!response.ok) throw new Error('Erreur API');
                        return response.json();
                    })
                    .then(data => {
                        // Retirer les skeleton loaders
                        contentBody.innerHTML = '';

                        if (data && data.messes && data.messes[0] && data.messes[0].lectures) {
                            // Afficher la date liturgique si différente d'aujourd'hui
                            const isToday = date === new Date().toISOString().split('T')[0];
                            let dateDisplay = '';

                            if (!isToday && data.date_liturgique) {
                                dateDisplay = `<p class="date-liturgique">${data.date_liturgique}</p>`;
                            }

                            // Chercher l'évangile dans les lectures
                            const evangile = data.messes[0].lectures.find(l => l.type === 'evangile');

                            if (evangile) {
                                contentBody.innerHTML = `
                                    ${dateDisplay}
                                    <h4>${evangile.titre || 'Évangile'}</h4>
                                    <p class="reference"><strong>${evangile.ref || ''}</strong></p>
                                    <div class="lecture-content">
                                        ${evangile.contenu ? evangile.contenu.substring(0, 300) + '...' : ''}
                                    </div>
                                `;
                            } else {
                                // Afficher la première lecture disponible
                                const lecture = data.messes[0].lectures[0];
                                contentBody.innerHTML = `
                                    ${dateDisplay}
                                    <h4>${lecture.titre || ''}</h4>
                                    <p class="reference"><strong>${lecture.ref || ''}</strong></p>
                                    <div class="lecture-content">
                                        ${lecture.contenu ? lecture.contenu.substring(0, 300) + '...' : ''}
                                    </div>
                                `;
                            }
                        } else {
                            contentBody.innerHTML = `
                                <p class="info-text">Les lectures de cette date sont disponibles sur AELF</p>
                                <p class="date-liturgique">${data.date_liturgique || ''}</p>
                            `;
                        }

                        // Mettre à jour le lien AELF
                        const aelfLink = document.getElementById('aelf-link');
                        if (aelfLink) {
                            aelfLink.href = `https://www.aelf.org/${date}/messe`;
                        }
                    })
                    .catch(error => {
                        console.error('Erreur AELF:', error);

                        // Fallback : utiliser l'API via le serveur WordPress
                        fetch(sangmelima_ajax.ajax_url, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: new URLSearchParams({
                                action: 'get_aelf_reading',
                                type: type,
                                date: date,
                                nonce: sangmelima_ajax.nonce
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success && data.data) {
                                contentBody.innerHTML = data.data;
                            } else {
                                contentBody.innerHTML = `
                                    <p class="info-text">Les lectures liturgiques de cette date vous attendent</p>
                                    <p class="small">Cliquez sur le bouton ci-dessous pour les découvrir</p>
                                `;
                            }
                        })
                        .catch(() => {
                            contentBody.innerHTML = `
                                <p class="info-text">Découvrez l'évangile et les lectures</p>
                            `;
                        });
                    });
            }
        });
    }

    // ========================================
    // GESTION DU SÉLECTEUR DE DATE AELF
    // ========================================
    function initDateSelector() {
        const dateInput = document.getElementById('aelf-date');
        const resetBtn = document.getElementById('reset-date');

        if (dateInput) {
            // Charger les lectures lors du changement de date
            dateInput.addEventListener('change', function() {
                loadAelfContent(this.value);

                // Sauvegarder la date sélectionnée dans localStorage
                localStorage.setItem('aelf_selected_date', this.value);
            });

            // Restaurer la dernière date sélectionnée
            const savedDate = localStorage.getItem('aelf_selected_date');
            const today = new Date().toISOString().split('T')[0];

            // Si la date sauvegardée est aujourd'hui ou dans le futur, la garder
            if (savedDate && savedDate >= today) {
                dateInput.value = savedDate;
                loadAelfContent(savedDate);
            }
        }

        if (resetBtn) {
            // Bouton pour revenir à aujourd'hui
            resetBtn.addEventListener('click', function() {
                const today = new Date().toISOString().split('T')[0];
                dateInput.value = today;
                localStorage.removeItem('aelf_selected_date');
                loadAelfContent(today);
            });
        }
    }

    // ========================================
    // GESTION DES GROUPES DE PRIÈRE
    // ========================================
    const shareIntentionBtn = document.querySelector('.share-intention');
    if (shareIntentionBtn) {
        shareIntentionBtn.addEventListener('click', function() {
            if (!sangmelima_ajax.is_logged_in) {
                alert('Veuillez vous connecter pour partager une intention');
                window.location.href = '/wp-login.php';
                return;
            }

            const intention = prompt('Quelle est votre intention de prière ?');
            if (intention) {
                // Envoyer l'intention
                fetch(sangmelima_ajax.ajax_url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        action: 'share_prayer_intention',
                        intention: intention,
                        nonce: sangmelima_ajax.nonce
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Votre intention a été partagée. Merci !');
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                });
            }
        });
    }

    // ========================================
    // NEWSLETTER
    // ========================================
    const newsletterForm = document.querySelector('.newsletter-form');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch(sangmelima_ajax.ajax_url, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Inscription réussie ! Merci.');
                    this.reset();
                } else {
                    alert('Une erreur est survenue. Veuillez réessayer.');
                }
            })
            .catch(error => {
                console.error('Erreur newsletter:', error);
            });
        });
    }

    // ========================================
    // LAZY LOADING IMAGES
    // ========================================
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    observer.unobserve(img);
                }
            });
        });

        const lazyImages = document.querySelectorAll('img.lazy');
        lazyImages.forEach(img => imageObserver.observe(img));
    }

    // ========================================
    // GESTION MODE HORS LIGNE
    // ========================================
    function updateOnlineStatus() {
        if (navigator.onLine) {
            document.body.classList.remove('offline');
        } else {
            document.body.classList.add('offline');
        }
    }

    window.addEventListener('online', updateOnlineStatus);
    window.addEventListener('offline', updateOnlineStatus);

    // ========================================
    // SMOOTH SCROLL
    // ========================================
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // ========================================
    // BOUTONS DE PARTAGE
    // ========================================
    function initShareButtons() {
        const shareButtons = document.querySelectorAll('.share-button');

        shareButtons.forEach(button => {
            button.addEventListener('click', function() {
                const url = this.dataset.url || window.location.href;
                const title = this.dataset.title || document.title;
                const network = this.dataset.network;

                let shareUrl = '';

                switch(network) {
                    case 'facebook':
                        shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`;
                        break;
                    case 'twitter':
                        shareUrl = `https://twitter.com/intent/tweet?url=${encodeURIComponent(url)}&text=${encodeURIComponent(title)}`;
                        break;
                    case 'whatsapp':
                        shareUrl = `https://wa.me/?text=${encodeURIComponent(title + ' ' + url)}`;
                        break;
                    case 'email':
                        shareUrl = `mailto:?subject=${encodeURIComponent(title)}&body=${encodeURIComponent(url)}`;
                        break;
                }

                if (shareUrl) {
                    window.open(shareUrl, '_blank', 'width=600,height=400');
                }
            });
        });
    }

    // ========================================
    // GESTION DES NEUVAINES
    // ========================================
    function initNeuvaines() {
        const joinButtons = document.querySelectorAll('.join-neuvaine');

        joinButtons.forEach(button => {
            button.addEventListener('click', function() {
                const neuvainId = this.dataset.id;

                fetch(sangmelima_ajax.ajax_url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        action: 'join_neuvaine',
                        neuvaine_id: neuvainId,
                        nonce: sangmelima_ajax.nonce
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Vous avez rejoint la neuvaine !');
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                });
            });
        });
    }

    // ========================================
    // INITIALISATION
    // ========================================
    document.addEventListener('DOMContentLoaded', function() {
        loadAelfContent();
        initDateSelector();
        initShareButtons();
        initNeuvaines();
        updateOnlineStatus();

        // Masquer le loader après chargement
        const loader = document.querySelector('.page-loader');
        if (loader) {
            setTimeout(() => {
                loader.style.display = 'none';
            }, 500);
        }
    });

    // ========================================
    // DÉTECTION MOBILE
    // ========================================
    function isMobile() {
        return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    }

    // Ajouter classe mobile au body
    if (isMobile()) {
        document.body.classList.add('is-mobile');
    }

    // ========================================
    // GESTION DES FORMULAIRES AJAX
    // ========================================
    const ajaxForms = document.querySelectorAll('.ajax-form');
    ajaxForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const submitBtn = this.querySelector('[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Envoi...';
            submitBtn.disabled = true;

            const formData = new FormData(this);

            fetch(sangmelima_ajax.ajax_url, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.reset();
                    showNotification(data.message || 'Succès !', 'success');
                } else {
                    showNotification(data.message || 'Erreur', 'error');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                showNotification('Une erreur est survenue', 'error');
            })
            .finally(() => {
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            });
        });
    });

    // ========================================
    // SYSTÈME DE NOTIFICATIONS
    // ========================================
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.textContent = message;

        document.body.appendChild(notification);

        setTimeout(() => {
            notification.classList.add('show');
        }, 100);

        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 3000);
    }

    // Exposer certaines fonctions globalement
    window.SangMeLima = {
        showNotification: showNotification,
        isMobile: isMobile
    };

})();