# Guide de Déploiement - SangMeLima PWA

## Prérequis serveur de production

### Configuration minimale
- **PHP** : 7.4+ (8.0 recommandé)
- **MySQL** : 5.7+ (8.0 recommandé)
- **RAM** : 2GB minimum
- **Espace disque** : 5GB minimum
- **SSL/HTTPS** : Obligatoire pour PWA
- **mod_rewrite** : Activé

### Hébergeurs recommandés
1. **OVH** (France) - Performance Pro à 11.99€/mois
2. **Hostinger** (International) - Business à 7.99€/mois
3. **O2Switch** (France) - Offre unique à 7€/mois
4. **Infomaniak** (Suisse) - Web Hosting à 5.75€/mois

## Étapes de déploiement

### 1. Préparation des fichiers

```bash
# Créer une archive complète
zip -r sangmelima_prod.zip \
  sangmelima-theme/ \
  sangmelima-plugin/ \
  *.md

# Structure finale :
sangmelima_prod.zip
├── sangmelima-theme/
├── sangmelima-plugin/
├── README.md
├── DOCUMENTATION_PROJET.md
└── GUIDE_TEST.md
```

### 2. Configuration de production

#### wp-config.php
```php
// Désactiver le debug
define('WP_DEBUG', false);
define('WP_DEBUG_LOG', false);
define('WP_DEBUG_DISPLAY', false);

// Sécurité
define('DISALLOW_FILE_EDIT', true);
define('FORCE_SSL_ADMIN', true);

// Performance
define('WP_CACHE', true);
define('COMPRESS_CSS', true);
define('COMPRESS_SCRIPTS', true);
define('CONCATENATE_SCRIPTS', true);

// Limites
define('WP_MEMORY_LIMIT', '256M');
define('WP_MAX_MEMORY_LIMIT', '512M');

// API Keys Production
define('STRIPE_MODE', 'live');
define('STRIPE_PUBLIC_KEY', 'pk_live_XXXXX');
define('STRIPE_SECRET_KEY', 'sk_live_XXXXX');

define('PAYPAL_MODE', 'live');
define('PAYPAL_CLIENT_ID', 'LIVE_CLIENT_ID');
define('PAYPAL_CLIENT_SECRET', 'LIVE_SECRET');
```

### 3. Installation sur le serveur

#### Via FTP/SFTP
```bash
# 1. Se connecter au serveur
ftp://ftp.votredomaine.com
Username: votre_user
Password: votre_pass

# 2. Naviguer vers
/public_html/ ou /www/

# 3. Uploader WordPress
# 4. Uploader sangmelima-theme dans wp-content/themes/
# 5. Uploader sangmelima-plugin dans wp-content/plugins/
```

#### Via SSH (recommandé)
```bash
# 1. Se connecter
ssh user@votreserveur.com

# 2. Naviguer vers le dossier web
cd /var/www/html

# 3. Télécharger WordPress
wget https://wordpress.org/latest.tar.gz
tar -xzvf latest.tar.gz
mv wordpress/* .

# 4. Uploader et extraire notre archive
scp sangmelima_prod.zip user@server:/var/www/html/
unzip sangmelima_prod.zip -d wp-content/

# 5. Permissions
chown -R www-data:www-data wp-content/
chmod -R 755 wp-content/
chmod -R 644 wp-content/*.php
```

### 4. Base de données

```sql
-- Créer la base de données
CREATE DATABASE sangmelima_prod CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Créer l'utilisateur
CREATE USER 'sangmelima_user'@'localhost' IDENTIFIED BY 'MotDePasseSecure123!';

-- Donner les permissions
GRANT ALL PRIVILEGES ON sangmelima_prod.* TO 'sangmelima_user'@'localhost';
FLUSH PRIVILEGES;
```

### 5. Configuration SSL/HTTPS

#### Let's Encrypt (gratuit)
```bash
# Via Certbot
sudo apt-get update
sudo apt-get install certbot python3-certbot-apache
sudo certbot --apache -d sangmelima.org -d www.sangmelima.org

# Renouvellement automatique
sudo certbot renew --dry-run
```

#### .htaccess pour forcer HTTPS
```apache
# Forcer HTTPS
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}/$1 [R=301,L]

# Sécurité headers
Header set X-Frame-Options "SAMEORIGIN"
Header set X-Content-Type-Options "nosniff"
Header set X-XSS-Protection "1; mode=block"
Header set Referrer-Policy "strict-origin-when-cross-origin"

# Cache navigateur
<FilesMatch "\.(jpg|jpeg|png|gif|ico|css|js)$">
Header set Cache-Control "max-age=2592000, public"
</FilesMatch>
```

### 6. Installation WordPress

1. Naviguer vers : https://sangmelima.org
2. Suivre l'assistant d'installation
3. Informations de base de données :
   - Base : `sangmelima_prod`
   - User : `sangmelima_user`
   - Pass : `MotDePasseSecure123!`
   - Host : `localhost`
   - Préfixe : `sml_` (sécurité)

### 7. Configuration post-installation

#### Dans l'admin WordPress

1. **Activer thème et plugin**
   - Apparence > Thèmes > Activer SangMeLima
   - Extensions > Activer SangMeLima Core

2. **Permaliens**
   - Réglages > Permaliens
   - Structure : `/%postname%/`
   - Enregistrer

3. **Pages à créer**
   ```
   - Accueil (template: Front Page)
   - Bréviaire (template: Bréviaire)
   - Parole et Vie (template: Parole et Vie)
   - RDV Spirituels (template: RDV Spirituels)
   - Mentions légales (template: Mentions Légales)
   - Politique de confidentialité (template: Politique Confidentialité)
   ```

4. **Menu principal**
   - Apparence > Menus
   - Créer "Menu Principal"
   - Ajouter les pages
   - Emplacement : Primary Menu

### 8. Optimisation performance

#### Plugin de cache (WP Rocket ou W3 Total Cache)
```php
// Configuration recommandée
- Cache des pages : Activé
- Minification CSS/JS : Activé
- Lazy Load images : Activé
- Cache navigateur : 1 mois
- Compression GZIP : Activé
```

#### CDN (optionnel)
- Cloudflare (gratuit)
- KeyCDN
- BunnyCDN

### 9. Sécurité

#### Plugins recommandés
1. **Wordfence** ou **Sucuri** - Firewall et scanner
2. **UpdraftPlus** - Sauvegardes automatiques
3. **Limit Login Attempts** - Protection brute force

#### Sécurisation supplémentaire
```php
// Dans wp-config.php
define('DISALLOW_FILE_MODS', false); // Permettre mises à jour
define('WP_AUTO_UPDATE_CORE', 'minor'); // MAJ sécurité auto

// Clés de sécurité (générer sur https://api.wordpress.org/secret-key/1.1/salt/)
define('AUTH_KEY', 'clé-unique-ici');
define('SECURE_AUTH_KEY', 'clé-unique-ici');
// ... autres clés
```

### 10. Tests post-déploiement

#### Checklist de validation
- [ ] Site accessible en HTTPS
- [ ] PWA installable
- [ ] Service Worker actif
- [ ] Lectures AELF fonctionnelles
- [ ] Système de RDV opérationnel
- [ ] Emails envoyés correctement
- [ ] Mode offline fonctionnel
- [ ] Performance Lighthouse > 70
- [ ] Pas d'erreurs console
- [ ] Responsive mobile OK

#### Tests de charge
```bash
# Apache Bench
ab -n 100 -c 10 https://sangmelima.org/

# Objectifs :
- Temps de réponse < 2s
- 0% erreurs
- Peut gérer 100 utilisateurs simultanés
```

### 11. Monitoring

#### Outils recommandés
1. **UptimeRobot** - Surveillance uptime (gratuit)
2. **Google Analytics** - Statistiques visiteurs
3. **Google Search Console** - SEO et indexation
4. **Sentry** - Tracking des erreurs JS

### 12. Maintenance

#### Sauvegardes
```bash
# Script de sauvegarde automatique
#!/bin/bash
DATE=$(date +%Y%m%d)
BACKUP_DIR="/backups"

# Sauvegarde base de données
mysqldump -u sangmelima_user -p sangmelima_prod > $BACKUP_DIR/db_$DATE.sql

# Sauvegarde fichiers
tar -czf $BACKUP_DIR/files_$DATE.tar.gz /var/www/html/

# Garder seulement 30 jours
find $BACKUP_DIR -name "*.sql" -mtime +30 -delete
find $BACKUP_DIR -name "*.tar.gz" -mtime +30 -delete
```

#### Mises à jour
- WordPress Core : Tester en staging d'abord
- Plugins : Lire les changelogs
- Thème/Plugin custom : Versionner dans Git

## Rollback en cas de problème

### Plan de retour arrière
1. Restaurer la sauvegarde de base de données
2. Restaurer les fichiers depuis la sauvegarde
3. Vider le cache (serveur, CDN, navigateur)
4. Vérifier les logs d'erreur

### Logs à vérifier
```bash
# Logs Apache
tail -f /var/log/apache2/error.log

# Logs PHP
tail -f /var/log/php/error.log

# Logs WordPress (si debug activé)
tail -f /wp-content/debug.log
```

## Contact support hébergeur

### OVH
- Tel : 1007 (France)
- Support : https://www.ovh.com/manager/

### Hostinger
- Chat 24/7 disponible
- Support : https://www.hostinger.fr/contact

### O2Switch
- Tel : 04 44 44 60 40
- Support : https://www.o2switch.fr/support/

## Livraison au client

### Documents à fournir
1. Accès WordPress Admin
2. Accès FTP/cPanel
3. Documentation utilisateur
4. Guide de maintenance
5. Contacts support

### Formation
- Session de 2h sur l'utilisation
- Documentation vidéo (optionnel)
- Support 30 jours inclus

---

*Guide de déploiement v1.0 - Production Ready*
*Support technique : sohfranc@gmail.com*