# SangMeLima - Application Progressive Web d'Évangélisation

Application PWA complète pour l'évangélisation avec intégration AELF, système de rendez-vous spirituels et dons multi-canaux.

## Caractéristiques principales

### Fonctionnalités

- **PWA installable** - Application installable sur mobile sans passer par les stores
- **Mode hors ligne** - Fonctionne même sans connexion internet
- **Ressources spirituelles** - Lectures du jour, prières, neuvaines, magistère
- **Groupes de prière** - Création et gestion de groupes de prière communautaires
- **Rendez-vous spirituels** - Système de réservation avec paiement en ligne
- **Dons multi-canaux** - Support Stripe, PayPal et Orange Money Cameroun
- **Intégration API AELF** - Lectures liturgiques automatiques du jour

### Technologies utilisées

- **WordPress 6.x** - CMS open source
- **PWA** - Progressive Web App avec Service Worker
- **PHP 8.0+** - Backend
- **JavaScript ES6** - Frontend interactions
- **CSS3** - Styles mobile-first responsive
- **MySQL** - Base de données

## Installation

### Prérequis

- Serveur web (Apache/Nginx)
- PHP 8.0 ou supérieur
- MySQL 5.7 ou supérieur
- WordPress 6.0 ou supérieur
- SSL/HTTPS (requis pour PWA)

### Installation locale

1. **Installer WordPress**
   - Télécharger WordPress depuis wordpress.org
   - Créer une base de données MySQL
   - Configurer wp-config.php

2. **Installer le thème**
   ```bash
   # Copier le dossier du thème
   cp -r sangmelima-theme/ /chemin/wordpress/wp-content/themes/
   ```

3. **Installer le plugin**
   ```bash
   # Copier le dossier du plugin
   cp -r sangmelima-plugin/ /chemin/wordpress/wp-content/plugins/
   ```

4. **Activer le thème et plugin**
   - Aller dans WordPress Admin > Apparence > Thèmes
   - Activer "SangMeLima Évangélisation"
   - Aller dans Extensions > Extensions installées
   - Activer "SangMeLima Core"

5. **Configuration initiale**
   - Créer les pages nécessaires (Dons, Neuvaines, etc.)
   - Configurer les menus dans Apparence > Menus
   - Ajouter du contenu initial

## Configuration

### Configuration des paiements

#### Stripe
1. Créer un compte sur stripe.com
2. Récupérer les clés API (test et production)
3. Ajouter dans wp-config.php :
```php
define('STRIPE_PUBLIC_KEY', 'pk_test_...');
define('STRIPE_SECRET_KEY', 'sk_test_...');
```

#### PayPal
1. Créer un compte marchand PayPal
2. Activer l'API REST
3. Ajouter les identifiants :
```php
define('PAYPAL_CLIENT_ID', 'your_client_id');
define('PAYPAL_CLIENT_SECRET', 'your_secret');
define('PAYPAL_MODE', 'sandbox'); // ou 'live'
```

#### Orange Money Cameroun
1. Contacter Orange pour obtenir un compte marchand
2. Récupérer les identifiants API
3. Configurer :
```php
define('ORANGE_MONEY_API_KEY', 'your_api_key');
define('ORANGE_MONEY_API_SECRET', 'your_secret');
```

### Configuration PWA

Le manifest.json est déjà configuré. Pour personnaliser :

1. Remplacer les icônes dans `/sangmelima-theme/assets/images/`
2. Modifier les couleurs dans `manifest.json`
3. Ajuster le Service Worker selon les besoins

### Configuration HTTPS

HTTPS est obligatoire pour les PWA. En local, utiliser :
- LocalWP (HTTPS automatique)
- XAMPP avec certificat auto-signé
- Ngrok pour tests mobiles

## Structure du projet

```
sangmelima-app/
├── sangmelima-theme/           # Thème WordPress
│   ├── assets/                 # CSS, JS, Images
│   │   ├── css/
│   │   ├── js/
│   │   │   ├── main.js        # JavaScript principal
│   │   │   └── pwa.js         # Gestion PWA
│   │   └── images/
│   ├── inc/                    # Fichiers PHP inclus
│   ├── template-parts/         # Parties de template
│   ├── languages/              # Traductions
│   ├── style.css              # Styles principaux
│   ├── functions.php          # Fonctions du thème
│   ├── index.php              # Page d'accueil
│   ├── header.php             # En-tête
│   ├── footer.php             # Pied de page
│   ├── single-neuvaine.php   # Template neuvaine
│   ├── page-donations.php    # Page des dons
│   └── manifest.json          # Manifest PWA
│
├── sangmelima-plugin/          # Plugin WordPress
│   ├── inc/                   # Classes PHP
│   ├── assets/                # Assets du plugin
│   ├── languages/             # Traductions
│   └── sangmelima-plugin.php  # Fichier principal
│
├── sw.js                      # Service Worker
└── README.md                  # Documentation
```

## Utilisation

### Pour les administrateurs

1. **Gestion des contenus**
   - Articles > Ajouter pour les actualités
   - Neuvaines > Ajouter pour créer une neuvaine
   - Prières > Ajouter pour les prières quotidiennes

2. **Gestion des dons**
   - SangMeLima > Dons pour voir les donations
   - Exporter en CSV disponible

3. **Rendez-vous spirituels**
   - SangMeLima > Rendez-vous pour gérer les créneaux
   - Notifications email automatiques

### Pour les utilisateurs

1. **Installation de l'app**
   - Visiter le site sur mobile
   - Accepter l'invitation d'installation
   - L'app apparaît sur l'écran d'accueil

2. **Utilisation hors ligne**
   - Les contenus consultés sont mis en cache
   - Synchronisation automatique au retour en ligne

## API Endpoints

### REST API WordPress

- `/wp-json/sangmelima/v1/aelf/{type}` - Lectures AELF
- `/wp-json/sangmelima/v1/prayer-groups` - Groupes de prière
- `/wp-json/sangmelima/v1/appointments` - Rendez-vous

### AJAX Endpoints

- `join_neuvaine` - Rejoindre une neuvaine
- `process_donation` - Traiter un don
- `sangmelima_newsletter` - Inscription newsletter

## Tests

### Tests locaux
1. Installer avec LocalWP ou XAMPP
2. Activer le mode debug WordPress
3. Tester sur différents navigateurs

### Tests PWA
- Chrome DevTools > Application
- Lighthouse pour audit PWA
- Test sur vrais appareils mobiles

## Déploiement

### Hébergement recommandé
- OVH, Hostinger ou O2Switch
- Minimum 2GB RAM
- PHP 8.0+
- SSL gratuit Let's Encrypt

### Étapes de déploiement

1. **Préparer les fichiers**
   ```bash
   # Créer une archive
   zip -r sangmelima.zip sangmelima-theme/ sangmelima-plugin/ sw.js
   ```

2. **Uploader sur le serveur**
   - Via FTP ou panneau d'hébergement
   - Extraire dans wp-content/

3. **Configuration production**
   - Désactiver le mode debug
   - Configurer les clés API de production
   - Activer la mise en cache

4. **Sécurité**
   - Installer Wordfence ou Sucuri
   - Sauvegardes automatiques
   - Mises à jour régulières

## Maintenance

### Sauvegardes
- Base de données : quotidienne
- Fichiers : hebdomadaire
- Stockage externe recommandé

### Mises à jour
- WordPress : tester en staging d'abord
- Thème/Plugin : versionner les changements
- Dépendances : vérifier la compatibilité

## Support

Pour toute question ou problème :
- Email : support@sangmelima.org
- Documentation : /docs
- Issues GitHub : github.com/sangmelima/app

## Licence

Ce projet est sous licence GPL v2 ou ultérieure.

## Auteur

**Xavier Soh**
- Email : sohfranc@gmail.com
- Site : xaviersoh.com

## Remerciements

- API AELF pour les lectures liturgiques
- Communauté WordPress
- Contributeurs open source

---

*Développé avec ❤️ pour l'évangélisation numérique*