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

---

## ⚙️ Utilisation et commandes Artisan

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

### 🧩 (Optionnel) Publication des dossiers du noyau

Pour personnaliser les modèles ou la logique du package :

```bash
php artisan bc:publish-core-folders
```

Cela publie les dossiers suivants dans `app/` :

- `app/Modules`
- `app/Support`
- `app/JsonApi`

---

## 🔧 Configuration

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

1. Publiez les dossiers via `php artisan bc:publish-core-folders`
2. Modifiez les classes selon vos besoins

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
