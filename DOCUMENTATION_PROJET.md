# Documentation Projet - SangMeLima PWA

## Vue d'ensemble
**Client** : Père Marc Bertrand
**Projet** : Application Progressive Web d'évangélisation
**Budget** : 500€ (approche MVP)
**Durée** : 30 jours ouvrables
**Version** : 1.0.0
**Date de mise à jour** : <?php echo date('d/m/Y'); ?>

## Architecture technique

### Stack technologique
- **CMS** : WordPress 6.0+
- **Frontend** : HTML5, CSS3, JavaScript (Vanilla)
- **PWA** : Service Worker, Web App Manifest
- **API** : REST API WordPress + AELF API
- **Base de données** : MySQL 5.7+
- **PHP** : 7.4+

### Structure des fichiers
```
sangmelima-app/
├── sangmelima-theme/          # Thème WordPress personnalisé
│   ├── assets/
│   │   ├── css/              # Styles
│   │   ├── js/               # Scripts
│   │   └── images/           # Images et icônes
│   ├── functions.php         # Configuration du thème
│   ├── index.php            # Page d'accueil
│   ├── manifest.json        # PWA manifest
│   ├── service-worker.js   # Service Worker
│   ├── offline.html         # Page offline
│   ├── generate-icons.php  # Générateur d'icônes
│   ├── page-*.php          # Templates de pages
│   └── archive-*.php       # Templates d'archives
│
├── sangmelima-plugin/         # Plugin WordPress principal
│   ├── sangmelima-plugin.php # Fichier principal
│   ├── admin/
│   │   └── csv-export.php   # Export CSV
│   └── includes/
│       └── appointment-cancellation.php # Système d'annulation
│
└── DOCUMENTATION/
    ├── GUIDE_TEST.md         # Guide de test complet
    ├── DOCUMENTATION_PROJET.md # Ce fichier
    └── Devis_signe.pdf       # Devis signé

```

## Fonctionnalités implémentées

### 1. Progressive Web App (PWA)
- ✅ **Installation** : Bouton d'installation sur mobile/desktop
- ✅ **Mode offline** : Page de fallback élégante
- ✅ **Service Worker** : Mise en cache des ressources
- ✅ **Manifest** : Configuration complète PWA
- ✅ **Icônes** : Toutes tailles générées (32px à 512px)

### 2. Intégration AELF
- ✅ **Lectures du jour** : Évangile, psaume, lectures
- ✅ **Sélecteur de date** : Navigation dans le calendrier liturgique
- ✅ **Saint du jour** : Affichage automatique
- ✅ **Bréviaire** : Liens vers tous les offices
- ✅ **Gestion CORS** : Double approche client/serveur

### 3. Rendez-vous spirituels
- ✅ **Réservation en ligne** : Calendrier interactif
- ✅ **Créneaux horaires** : 9h-12h et 14h-18h
- ✅ **Dons suggérés** : 15€, 20€, 30€ ou libre
- ✅ **Plateformes** : Zoom, Skype, WhatsApp, Téléphone
- ✅ **Annulation sécurisée** : Token unique par email
- ✅ **Délai d'annulation** : 24h minimum
- ✅ **Notifications** : Email utilisateur et admin

### 4. Système de dons
- ✅ **Multi-canal** : Stripe, PayPal, Orange Money
- ✅ **Types** : Unique ou mensuel
- ✅ **Simulation** : Mode test pour validation
- ✅ **Montants suggérés** : 10€, 20€, 50€, 100€, libre
- ✅ **Reçu fiscal** : Prévu dans la structure

### 5. Groupes de prière
- ✅ **Création de groupes** : Par les utilisateurs
- ✅ **Types** : Public ou privé
- ✅ **Limite membres** : Configurable (défaut 50)
- ✅ **Rôles** : Admin, modérateur, membre
- ✅ **Base de données** : Tables dédiées

### 6. Contenus spirituels

#### Custom Post Types (CPT)
- ✅ **Prières** : Avec catégories et durée
- ✅ **Saints** : Fête, biographie, patronage
- ✅ **Neuvaines** : 9 jours, participants
- ✅ **Magistère** : Documents officiels de l'Église

#### Pages spéciales
- ✅ **Bréviaire** : Prière quotidienne et offices
- ✅ **Parole et Vie** : Méditations pour les épreuves
- ✅ **Archives** : Templates pour chaque CPT
- ✅ **Pages légales** : Mentions légales et RGPD

### 7. Administration
- ✅ **Export CSV** : Tous types de données
- ✅ **Filtres** : Par date, statut, type
- ✅ **Anonymisation** : Option RGPD
- ✅ **Historique** : 10 derniers exports
- ✅ **Dashboard** : Vue d'ensemble

### 8. Newsletter
- ✅ **Inscription** : Formulaire AJAX
- ✅ **Double opt-in** : Prévu
- ✅ **Désinscription** : Lien dans chaque email
- ✅ **Segmentation** : Par intérêts

## Base de données

### Tables personnalisées
```sql
-- Groupes de prière
wp_prayer_groups
- id, name, description, creator_id, created_at, is_public, max_members

wp_prayer_group_members
- id, group_id, user_id, joined_at, role

-- Rendez-vous spirituels
wp_spiritual_appointments
- id, user_id, date_time, duration, status, payment_status, amount, notes
- cancellation_token, cancelled_at, cancellation_reason

-- Dons
wp_donations
- id, user_id, amount, donation_type, payment_method, payment_id, status

-- Intentions de prière
wp_prayer_intentions
- id, user_id, intention, is_public, created_at

-- Newsletter
wp_newsletter_subscribers
- id, email, name, status, subscribed_at, confirmed_at

-- Participants neuvaines
wp_neuvaine_participants
- id, neuvaine_id, user_id, joined_at, completed
```

## API et intégrations

### AELF API
- **Endpoint** : https://api.aelf.org/v1/
- **Routes utilisées** :
  - `/messes/{date}/france` - Lectures du jour
  - `/informations/{date}` - Informations liturgiques
- **Gestion d'erreurs** : Fallback serveur si CORS

### Simulation paiement
- **Stripe** : Interface de test carte bancaire
- **PayPal** : Simulation bouton PayPal
- **Orange Money** : Interface mobile money

## Sécurité

### Mesures implémentées
- ✅ **Sanitization** : Toutes les entrées utilisateur
- ✅ **Nonces** : Protection CSRF sur tous les formulaires
- ✅ **Prepared statements** : Requêtes SQL sécurisées
- ✅ **Escaping** : Sortie HTML échappée
- ✅ **Tokens uniques** : Pour annulation RDV
- ✅ **HTTPS** : Requis pour PWA
- ✅ **Permissions** : Vérification des capacités utilisateur

### RGPD
- ✅ **Consentement** : Cases à cocher obligatoires
- ✅ **Politique de confidentialité** : Page complète
- ✅ **Droit à l'oubli** : Suppression des données
- ✅ **Export données** : Format CSV
- ✅ **Anonymisation** : Option dans les exports

## Performance

### Optimisations
- ✅ **Lazy loading** : Images chargées à la demande
- ✅ **Service Worker** : Cache des ressources statiques
- ✅ **Minification** : CSS/JS en production
- ✅ **Compression** : GZIP activé
- ✅ **CDN ready** : Structure compatible

### Métriques cibles
- Temps de chargement : < 3 secondes
- Score Lighthouse PWA : > 80
- Score Performance : > 70
- Score Accessibilité : > 90

## Responsive Design

### Breakpoints
- Mobile : < 768px
- Tablet : 768px - 1024px
- Desktop : > 1024px

### Approche
- Mobile-first
- Flexbox et Grid CSS
- Images adaptatives
- Touch-friendly (zones > 44px)

## Internationalisation

### Support i18n
- ✅ **Text Domain** : `sangmelima`
- ✅ **Fonctions WP** : `__()`, `_e()`, `esc_html__()`
- ✅ **Fichiers .po/.mo** : Prêts pour traduction
- ✅ **Dates** : `date_i18n()` pour format local

## Tests

### Types de tests
- **Fonctionnels** : Toutes les features
- **Responsive** : Mobile, tablet, desktop
- **Performance** : Lighthouse
- **Sécurité** : Injection SQL, XSS, CSRF
- **Accessibilité** : WCAG 2.1 niveau AA

### Navigateurs supportés
- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+
- Chrome Mobile
- Safari iOS

## Déploiement

### Prérequis serveur
- PHP 7.4+
- MySQL 5.7+
- HTTPS obligatoire
- mod_rewrite activé
- 256MB RAM minimum

### Étapes de déploiement
1. Upload fichiers via FTP/SSH
2. Créer base de données
3. Configurer wp-config.php
4. Installer WordPress
5. Activer thème et plugin
6. Configurer les permaliens
7. Activer HTTPS
8. Tester PWA

## Maintenance

### Tâches régulières
- Sauvegardes quotidiennes
- Mises à jour WordPress/plugins
- Monitoring uptime
- Nettoyage base de données
- Vérification emails

### Logs
- Erreurs PHP : `wp-content/debug.log`
- Service Worker : Console navigateur
- API AELF : Réponses dans Network

## Évolutions futures

### Court terme (v1.1)
- Push notifications PWA
- Calendrier liturgique complet
- Streaming vidéo pour messes
- Chat en direct

### Moyen terme (v1.2)
- Application mobile native
- Multi-langue
- Paiement réel intégré
- Système de badges/gamification

### Long terme (v2.0)
- IA pour accompagnement spirituel
- Réalité augmentée (visites virtuelles)
- Blockchain pour dons transparents
- API publique

## Support et contact

### Développeur
- **Nom** : Xavier Soh
- **Email** : sohfranc@gmail.com
- **Site** : https://xaviersoh.com

### Client
- **Organisation** : SangMeLima Évangélisation
- **Responsable** : Père Marc Bertrand
- **Email** : contact@sangmelima.org

## Références

### Sites modèles
- **catholicus.eu** : Structure du magistère
- **hozana.org** : Communautés de prière
- **aelf.org** : Lectures et offices

### Documentation technique
- [WordPress Codex](https://codex.wordpress.org)
- [PWA Documentation](https://web.dev/progressive-web-apps/)
- [AELF API](https://api.aelf.org/swagger/index.html)

## Changelog

### Version 1.0.0 (<?php echo date('d/m/Y'); ?>)
- Version initiale
- Toutes fonctionnalités MVP
- Tests validés
- Documentation complète

---

*Cette documentation est maintenue à jour avec chaque version.*
*Pour les tests, consulter GUIDE_TEST.md*