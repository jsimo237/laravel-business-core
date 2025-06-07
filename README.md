# 🚀 Laravel Business Core

![Packagist Version](https://img.shields.io/packagist/v/kirago/laravel-business-core)
![Laravel](https://img.shields.io/badge/Laravel-^8.0%20%7C%7C%20^9.0%20%7C%7C%20^10.0-red)
![PHP](https://img.shields.io/badge/PHP-^7.3%20%7C%7C%20^8.0-blue)
![License](https://img.shields.io/github/license/jsimo237/laravel-business-core)

## 📖 Introduction

**Laravel Business Core** est un package **modulaire et extensible** pour Laravel, conçu pour fournir les **composants métiers fondamentaux** nécessaires à la gestion d’applications professionnelles.

### ✨ Fonctionnalités principales

- 🛒 Commandes et lignes de commande
- 📦 Produits et packages
- 📄 Factures et lignes de facture
- 💰 Paiements et taxes
- 🧾 Abonnements et plans
- 👤 Clients et contacts
- 🧑‍💼 Utilisateurs, rôles et permissions
- 🌐 Prise en charge du multi-tenant
- ⚙️ Personnalisable via les fichiers publiés

Ce package est idéal pour les applications B2B, SaaS ou de type ERP.

---

## 📦 Installation

### ✅ Prérequis

- Laravel `^10.0 || ^11.0 || ^12.0`
- PHP ` ^8.0`
- Extensions PHP nécessaires :
    - `json`
    - `ctype`
    - `filter`
    - `mbstring`
    - `pdo`

---

### 📥 Étape 1 : Installation via Composer

```bash
composer require kirago/laravel-business-core
```

### ⚠️ Cas de ceux qui utilisent Laravel 12 avec PHP 8.3.x
A cause des mises à jour sur ```axn/laravel-eloquent-authorable:^7.0``` qui requiert  ```php ^8.4```, si vous tombez sur
cette erreur ``` axn/laravel-eloquent-authorable 6.3.0 requires illuminate/support ^8.0 || ^9.0 || ^10.0 || ^11.0 -> satisfiable by illuminate/support[v8.0.0, ..., v8.83.27, v9.0.0, ..., v9.52.16, v10.0.0, ..., v10.48.28, v11.0.0, ..., v11.45.1].```
alors exécutez ceci pour bypasser la verification de version de php par composer
```bash
composer require kirago/laravel-business-core --ignore-platform-reqs
```

---

### 🛠 Étape 2 : Initialisation complète

La commande suivante publie les fichiers nécessaires et installe la structure de base :

```bash
php artisan bc:setup
```

Cette commande effectue les actions suivantes :

- 📂 Publication des fichiers de configuration (`config/business-core.php`, `config/bc-data/`)
- 🧱 Publication et exécution des migrations
- 💱 Installation des données de devises
- 🔐 Création du rôle "Super Admin" et des permissions
- 🧹 Nettoyage et mise en cache de la configuration Laravel

---

## 🧩 (Optionnel) Publication des dossiers du noyau


---

### 🔧 Configuration

Le fichier principal de configuration est :

```
config/business-core.php
```

Vous pouvez y configurer :

- Les modèles utilisés
- Les modèles traçables (`authorable`)
- Les données par défaut (pays, taxes, etc.)
- Les intégrations éventuelles (permissions, paiements, etc.)

---

## 🧠 Personnalisation

Vous pouvez surcharger les modèles, contrôleurs ou actions du package :

1. Publiez les dossiers :

```bash
php artisan bc:publish-core-folders
```

Cela publie les dossiers suivants dans `app/` :

- `app/Modules`
- `app/Support`
- `app/JsonApi`

2. Activez la personnalisation dans `config/business-core.php`
```php
return [

    // 🔧 Active ou non la personnalisation des fichiers du package
    'customization' => true,
    
    ...
```
3. Modifiez les classes selon vos besoins

Cela permet une personnalisation avancée tout en gardant une base solide.

---
### 🛣 (Optionnel) Découverte automatique des routes JSON:API

Pour activer la découverte des routes JSON:API fournies par le package, ajoute la ligne suivante dans
la méthode `boot()` de ton `App\Providers\AppServiceProvider` :

```php
use Kirago\BusinessCore\Facades\BusinessCore;

public function boot(): void
{
    BusinessCore::discoverApiRoutes(prefix: 'v1');
}
```

Verifiez que les routes sont bien disponibles


```bash
php artisan route:list --path=api
```
Resultat
```
  .....
  
  POST       api/v1/auth/forgot-password/request ................................... bc.auth.forgot-password.request › Kirago\BusinessCore › PasswordResetController@request
  POST       api/v1/auth/forgot-password/reset ......................................... bc.auth.forgot-password.reset › Kirago\BusinessCore › PasswordResetController@reset  
  POST       api/v1/auth/login ................................................................................. bc.auth.login › Kirago\BusinessCore › LoginController@login  
  POST       api/v1/auth/logout ............................................................................. bc.auth.logout › Kirago\BusinessCore › LogoutController@logout 
  
  .....
```


---
## 📝 Licence

Ce package est open-source et distribué sous licence [MIT](https://opensource.org/licenses/MIT).

---

## 🤝 Contribuer

Les contributions sont les bienvenues !  
N’hésitez pas à soumettre une _pull request_ ou à ouvrir une _issue_ pour signaler un bug ou proposer une amélioration.

---

## 👤 Auteur

**Kirago**  
Développé avec ❤️ pour les artisans Laravel.
