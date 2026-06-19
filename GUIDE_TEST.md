# Guide de Test - SangMeLima PWA

## Configuration de l'environnement de test

### Prérequis
- **Serveur local** : XAMPP, WAMP, MAMP ou Laragon
- **PHP** : Version 7.4 ou supérieure
- **MySQL** : Version 5.7 ou supérieure
- **WordPress** : Version 6.0 ou supérieure

### Installation

1. **Installer WordPress**
   ```bash
   # Placer les fichiers WordPress dans le dossier du serveur local
   # Exemple pour XAMPP : C:/xampp/htdocs/sangmelima-app
   ```

2. **Créer la base de données**
   - Accéder à phpMyAdmin : http://localhost/phpmyadmin
   - Créer une nouvelle base de données : `sangmelima_db`
   - Collation : `utf8mb4_unicode_ci`

3. **Configurer WordPress**
   - Accéder à : http://localhost/sangmelima-app
   - Suivre l'assistant d'installation
   - Informations de base de données :
     - Nom : `sangmelima_db`
     - Utilisateur : `root`
     - Mot de passe : `` (vide pour XAMPP)
     - Hôte : `localhost`

4. **Activer le thème et le plugin**
   ```
   - Copier sangmelima-theme/ dans wp-content/themes/
   - Copier sangmelima-plugin/ dans wp-content/plugins/
   - Dans l'admin WordPress :
     → Apparence > Thèmes > Activer SangMeLima Theme
     → Extensions > Activer SangMeLima Core
   ```

## Tests fonctionnels

### 1. Test PWA et mode offline

**Étapes :**
1. Ouvrir le site dans Chrome : http://localhost/sangmelima-app
2. Ouvrir DevTools (F12) > Application > Service Worker
3. Vérifier que le service worker est "Activated and is running"
4. Aller dans Application > Manifest
5. Vérifier la présence du bouton "Install"

**Test offline :**
1. Dans DevTools > Network, cocher "Offline"
2. Rafraîchir la page
3. ✅ Vérifier que la page offline.html s'affiche

### 2. Test AELF - Lectures du jour

**Étapes :**
1. Page d'accueil > Section "Évangile du jour"
2. Cliquer sur "Lire l'évangile"
3. ✅ Vérifier que les lectures s'affichent
4. Utiliser le sélecteur de date
5. Changer la date et cliquer sur "Charger"
6. ✅ Vérifier que les lectures de la date sélectionnée s'affichent

### 3. Test Rendez-vous spirituels

**Étapes :**
1. Naviguer vers : http://localhost/sangmelima-app/rdv-spirituels
2. Sélectionner une date dans le calendrier
3. Choisir un créneau horaire disponible
4. Remplir le formulaire :
   - Nom : Test User
   - Email : test@example.com
   - Téléphone : 0612345678
   - Plateforme : Zoom
   - Sujet : Test de rendez-vous
   - Message : Ceci est un test
5. Sélectionner un montant de don (15€, 20€, 30€ ou libre)
6. Soumettre le formulaire
7. ✅ Vérifier la redirection vers la page de simulation de paiement

**Test annulation :**
1. Dans l'email de confirmation, cliquer sur le lien d'annulation
2. ✅ Vérifier que le formulaire d'annulation s'affiche
3. Confirmer l'annulation
4. ✅ Vérifier le message de confirmation

### 4. Test Neuvaines

**Étapes :**
1. Page d'accueil > Section "Neuvaines actives"
2. Cliquer sur "Voir toutes les neuvaines"
3. Sélectionner une neuvaine
4. Cliquer sur "Participer"
5. Remplir le formulaire d'inscription
6. ✅ Vérifier le message de confirmation

### 5. Test Bréviaire

**Étapes :**
1. Naviguer vers : http://localhost/sangmelima-app/breviaire
2. ✅ Vérifier l'affichage de la prière du jour
3. Cliquer sur un office (Laudes, Vêpres, etc.)
4. ✅ Vérifier la redirection vers AELF

### 6. Test Parole et Vie

**Étapes :**
1. Naviguer vers : http://localhost/sangmelima-app/parole-et-vie
2. Sélectionner une catégorie (Deuil, Maladie, etc.)
3. ✅ Vérifier l'affichage des méditations
4. Cliquer sur "Lire la méditation"
5. ✅ Vérifier l'affichage complet

### 7. Test Groupes de prière

**Étapes :**
1. Menu > Groupes de prière
2. Créer un compte ou se connecter
3. Cliquer sur "Créer un groupe"
4. Remplir le formulaire :
   - Nom : Groupe Test
   - Description : Test de groupe de prière
   - Type : Public
5. ✅ Vérifier la création du groupe
6. Tester l'inscription à un groupe existant

### 8. Test Dons

**Étapes :**
1. Cliquer sur "Faire un don"
2. Choisir un montant (10€, 20€, 50€, 100€ ou libre)
3. Sélectionner le type (Unique ou Mensuel)
4. Choisir la méthode de paiement :
   - Stripe (carte bancaire)
   - PayPal
   - Orange Money
5. ✅ Vérifier la redirection vers la simulation de paiement

### 9. Test Administration

**Connexion admin :**
- URL : http://localhost/sangmelima-app/wp-admin
- Utilisateur : (créé lors de l'installation)
- Mot de passe : (créé lors de l'installation)

**Tests admin :**

1. **Export CSV**
   - Admin > Prières > Export CSV
   - Sélectionner "Utilisateurs"
   - Cliquer sur "Exporter en CSV"
   - ✅ Vérifier le téléchargement du fichier

2. **Gestion des contenus**
   - Créer une nouvelle prière
   - Créer un nouveau saint
   - Créer un document magistère
   - ✅ Vérifier l'affichage sur le front-end

3. **Gestion des RDV**
   - Admin > SangMeLima > Rendez-vous
   - ✅ Vérifier la liste des RDV
   - Modifier le statut d'un RDV

### 10. Test des archives

**Étapes :**
1. Naviguer vers :
   - http://localhost/sangmelima-app/priere (toutes les prières)
   - http://localhost/sangmelima-app/saint (tous les saints)
   - http://localhost/sangmelima-app/magistere (tout le magistère)
2. ✅ Vérifier l'affichage des listes
3. Tester les filtres et la recherche
4. ✅ Vérifier la pagination

## Tests de performance

### Test de chargement
```bash
# Dans Chrome DevTools > Lighthouse
1. Ouvrir Lighthouse
2. Sélectionner : Performance, Accessibility, Best Practices, SEO, PWA
3. Générer le rapport
4. Vérifier les scores (objectif > 70 pour chaque catégorie)
```

### Test responsive
1. DevTools > Toggle device toolbar (Ctrl+Shift+M)
2. Tester sur :
   - Mobile : 375x667 (iPhone SE)
   - Tablet : 768x1024 (iPad)
   - Desktop : 1920x1080

## Tests de sécurité

1. **Test d'injection SQL**
   - Dans les formulaires, essayer : `'; DROP TABLE users; --`
   - ✅ Vérifier que les données sont échappées

2. **Test XSS**
   - Dans les champs texte, essayer : `<script>alert('XSS')</script>`
   - ✅ Vérifier que le script n'est pas exécuté

3. **Test CSRF**
   - ✅ Vérifier la présence de nonces WordPress dans les formulaires

## Checklist de validation

### Fonctionnalités essentielles
- [ ] PWA installable
- [ ] Mode offline fonctionnel
- [ ] Service worker actif
- [ ] Lectures AELF fonctionnelles
- [ ] Système de RDV opérationnel
- [ ] Annulation de RDV avec token
- [ ] Groupes de prière
- [ ] Système de dons (simulation)
- [ ] Newsletter
- [ ] Export CSV admin

### Pages à vérifier
- [ ] Page d'accueil
- [ ] Bréviaire
- [ ] Parole et Vie
- [ ] RDV spirituels
- [ ] Archives prières
- [ ] Archives saints
- [ ] Archives magistère
- [ ] Mentions légales
- [ ] Politique de confidentialité
- [ ] Simulation paiement

### Mobile
- [ ] Navigation responsive
- [ ] Formulaires adaptés mobile
- [ ] Images optimisées
- [ ] Touch-friendly (boutons > 44px)

### Performance
- [ ] Temps de chargement < 3s
- [ ] Score Lighthouse PWA > 80
- [ ] Images lazy-loading
- [ ] CSS/JS minifiés

## Génération des icônes

Pour générer les icônes PWA :
```bash
cd sangmelima-theme
php generate-icons.php
```

Puis ouvrir `assets/images/icon-generator.html` dans un navigateur et télécharger les PNG.

## Résolution des problèmes courants

### Service Worker non actif
1. Vérifier HTTPS ou localhost
2. Vider le cache navigateur
3. Désinscrire et réinscrire le SW

### AELF API ne répond pas
1. Vérifier la connexion Internet
2. Tester l'API : https://api.aelf.org/v1/messes/2024-01-15/france
3. Utiliser le fallback serveur si CORS

### Emails non envoyés
1. Installer un plugin SMTP (WP Mail SMTP)
2. Configurer avec Gmail ou Mailgun
3. Tester avec l'outil de test du plugin

### Base de données non créée
1. Désactiver et réactiver le plugin
2. Vérifier les permissions MySQL
3. Créer manuellement les tables si besoin

## Données de test

### Utilisateurs test
```
Admin : admin@sangmelima.org / Admin123!
User : user@test.com / User123!
```

### Cartes de test (Stripe)
```
Succès : 4242 4242 4242 4242
Échec : 4000 0000 0000 0002
```

### PayPal test
```
Email : sb-test@business.example.com
Password : TestPayPal123
```

## Contact support

Pour toute question technique :
- Email : sohfranc@gmail.com
- Documentation : https://github.com/sangmelima/docs

---

*Guide créé le : <?php echo date('d/m/Y'); ?>*
*Version : 1.0.0*