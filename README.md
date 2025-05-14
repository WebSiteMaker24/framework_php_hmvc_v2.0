# 📘 Documentation technique — TEMPLATE_FRAMEWORK_PHP_HMVC_2

## 🧱 Architecture générale (HMVC)
Ce framework PHP suit un modèle HMVC (Hierarchical Model View Controller), ce qui permet de séparer clairement :
- Les vues (`view`) : affichage
- Les contrôleurs (`control`) : logique
- Les modèles (`model`) : accès aux données
- Les modules : encapsulation par fonctionnalité (ex. `users`)
- Les middlewares, protections CSRF, etc.

## 📂 Structure du projet
```
.
├── .env
├── Boot.php
├── config.php
├── public_html/
│   ├── index.php
│   └── public/
│       ├── css/
│       ├── font/
│       ├── img/
│       └── js/
├── src/
│   ├── control/
│   ├── csrf/
│   ├── handlerform/
│   ├── logs/
│   ├── middleware/
│   ├── model/
│   ├── module/
│   │   └── users/
│   ├── route/
│   └── view/
│       ├── form/
│       ├── navigation/
│       └── template/
```

## 🎨 CSS modulaire : une approche pragmatique

### ✅ Principe
Chaque section de page (comme `contact`, `hero`, `tarif`, etc.) dispose :
- D’un fichier HTML/PHP (`contact.php`)
- D’un bloc CSS dédié, collé juste après le HTML dans le même fichier OU bien dans un fichier CSS dédié (`contact.css`)

### ✅ Avantages
- Permet de ne pas fouiller un `style.css` de 1000 lignes
- Maintenance beaucoup plus rapide
- Media queries localisées à chaque section
- Lisibilité accrue : les devs peuvent travailler sur une section sans rien casser d’autre

### 📐 Bonnes pratiques
- Noms de classes CSS scopés (`.contact-wrapper`, `.contact-form`)
- Media queries placés juste après la section concernée
- `style.css` global utilisé pour :
  - Reset CSS
  - Variables globales
  - Mise en page commune

## 🔤 Conventions de nommage

### 📁 Dossiers
- `src/` : tout le cœur du code
- `view/navigation/` : pages du site
- `module/<nom>/` : chaque module a ses propres `Control<Model>.php`

### 📄 Fichiers
- `ModelUser.php`, `ControlUser.php` : module `users`
- `navbar.php`, `footer.php` : composants partagés

### 🔡 CSS
- Classes en kebab-case : `.contact-form`, `.hero-banner`
- Préfixe facultatif par section : `.contact-title`, `.hero-text`

## 🔐 Sécurité & Middleware
- CSRF (`csrf/CSRFProtection.php`)
- Middleware (`middleware/Middleware.php`) pour filtrer les accès

## 📈 Évolutivité
- Ajout facile de modules (`admin`, `produits`, etc.)
- Intégration API REST possible
- Performances améliorables sans tout réécrire

## ✅ Résumé
| Élément                  | Statut |
|--------------------------|--------|
| Architecture HMVC        | ✅ Solide et claire |
| CSS par section          | ✅ Modulaire, lisible, maintenable |
| Routage centralisé       | ✅ Scalabilité prévue |
| Séparation MVC           | ✅ Respectée |
| Sécurité (CSRF)          | ✅ Intégrée |
| Code source "propre"     | ✅ Bien structuré malgré la vue navigateur |
