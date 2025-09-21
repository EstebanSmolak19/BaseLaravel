<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Projet Laravel – Gestion des Événements

## Description

Ce projet est une **application web scolaire** développée avec **Laravel 12** pour réviser et appliquer les concepts fondamentaux de Laravel, notamment :

- Le **pattern MVC** (Modèles, Vues, Contrôleurs)  
- Les **relations entre tables** (1 à N entre `Event` et `Type`)  
- La **validation des formulaires**  
- Les **migrations, seeders et gestion de la base de données**  

L'objectif principal est de proposer une application simple mais complète permettant de gérer des événements avec un **design moderne via Bootstrap**.

---

## Fonctionnalités

- **CRUD complet pour les événements** : créer, lire, modifier et supprimer des événements  
- **Gestion des types d'événements** avec relation 1 à N entre `Event` et `Type`  
- **Validation des formulaires** pour garantir l'intégrité des données  
- **Champ optionnel Description** pour détailler chaque événement  
- **Interface stylisée avec Bootstrap** pour une navigation intuitive  

---

## Technologies utilisées

- **Framework** : Laravel 12  
- **Frontend** : Bootstrap  
- **Base de données** : MySQL  
- **Autres** : Seeders pour peupler la base de données initialement  

---

# 🚀 Installation & Lancement du projet

## Prérequis

Avant de commencer, assurez-vous d'avoir installé sur votre système :

- **PHP** >= 8.2
- **Composer** (gestionnaire de dépendances PHP)
- **MySQL**
- **Git**

---

## 📥 Installation

### 1. Cloner le dépôt
```bash
git clone <url-du-repo>
cd <nom-du-dossier>
```

### 2. Installer les dépendances PHP
```bash
composer install
```

### 3. Configurer l'environnement
Copiez le fichier d'exemple de configuration :
```bash
cp .env.example .env
```

### 4. Générer la clé d'application
```bash
php artisan key:generate
```

### 5. Configuration de la base de données
Ouvrez le fichier `.env` et configurez vos paramètres de base de données :

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nom_de_votre_base
DB_USERNAME=votre_utilisateur
DB_PASSWORD=votre_mot_de_passe
```