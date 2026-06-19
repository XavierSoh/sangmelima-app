# 🚀 Guide de Test Rapide - SangMeLima

## Installation en 5 minutes

### 1. Préparer l'environnement
```bash
# Installer XAMPP ou équivalent
# Démarrer Apache et MySQL
```

### 2. Installer WordPress
```bash
# 1. Télécharger WordPress
# 2. Extraire dans : C:/xampp/htdocs/sangmelima-app
# 3. Créer la base de données dans phpMyAdmin : sangmelima_db
```

### 3. Activer le thème et plugin
```bash
# Copier les dossiers :
- sangmelima-theme/ → wp-content/themes/
- sangmelima-plugin/ → wp-content/plugins/

# Dans WordPress Admin :
- Activer le thème SangMeLima
- Activer le plugin SangMeLima Core
```

## ✅ Tests essentiels (10 minutes)

### Test 1 : PWA
```
✓ Ouvrir : http://localhost/sangmelima-app
✓ Chrome DevTools (F12) > Application
✓ Vérifier : Service Worker "Activated"
✓ Cliquer sur "Install" dans Manifest
```

### Test 2 : Lectures AELF
```
✓ Page d'accueil > "Évangile du jour"
✓ Cliquer "Lire l'évangile"
✓ Les textes doivent s'afficher
✓ Tester le changement de date
```

### Test 3 : RDV Spirituel
```
✓ Menu > "RDV Spirituels"
✓ Sélectionner une date future
✓ Choisir un créneau (vert)
✓ Remplir le formulaire :
  - Nom : Test
  - Email : test@test.com
  - Don : 20€
✓ Soumettre
✓ Page de simulation paiement doit s'afficher
```

### Test 4 : Mode Offline
```
✓ DevTools > Network > ☑ Offline
✓ Rafraîchir la page
✓ La page offline doit s'afficher
✓ Décocher Offline pour revenir en ligne
```

### Test 5 : Bréviaire
```
✓ Menu > "Bréviaire"
✓ La prière du jour s'affiche
✓ Les liens vers les offices fonctionnent
```

## 🔍 Vérifications rapides

### URLs à tester
- ✓ `/` - Page d'accueil
- ✓ `/breviaire` - Bréviaire
- ✓ `/parole-et-vie` - Méditations
- ✓ `/rdv-spirituels` - Rendez-vous
- ✓ `/priere` - Toutes les prières
- ✓ `/saint` - Tous les saints
- ✓ `/magistere` - Documents de l'Église

### Admin WordPress
```
URL : /wp-admin
User : admin
Pass : [votre mot de passe]

✓ Prières > Export CSV
✓ Créer une prière test
✓ Vérifier qu'elle apparaît sur le site
```

## 📱 Test Mobile

### Sur téléphone
1. Connecter PC et téléphone au même WiFi
2. Trouver l'IP du PC : `ipconfig`
3. Sur téléphone : `http://[IP-PC]/sangmelima-app`
4. Tester l'installation PWA
5. Vérifier le responsive

## 🎯 Checklist finale

- [ ] PWA installable
- [ ] Service Worker actif
- [ ] Lectures AELF fonctionnelles
- [ ] RDV réservation OK
- [ ] Mode offline OK
- [ ] Navigation mobile OK
- [ ] Export CSV admin OK
- [ ] Pages légales présentes

## 🆘 Problèmes courants

### Service Worker ne s'active pas
```javascript
// Console navigateur
navigator.serviceWorker.register('/service-worker.js')
```

### AELF ne charge pas
```
- Vérifier connexion Internet
- Tester l'API : https://api.aelf.org/v1/messes/2024-01-15/france
```

### Tables non créées
```
- Désactiver le plugin
- Réactiver le plugin
- Les tables se créent automatiquement
```

### Icônes manquantes
```bash
cd sangmelima-theme
php generate-icons.php
# Ouvrir assets/images/icon-generator.html
```

## 📊 Performance

### Test Lighthouse
```
1. DevTools > Lighthouse
2. Cocher : PWA, Performance
3. Generate report
4. Score PWA > 80 = ✅
```

## 🎉 Si tous les tests passent

**L'application est prête !**

Prochaines étapes :
1. Configuration production
2. SSL/HTTPS obligatoire
3. Déploiement sur serveur

---

*Test rapide v1.0 - Durée totale : ~20 minutes*