# Contexte du Projet
#### Ce projet vise à construire un framework PHP minimaliste, inspiré des meilleures pratiques, tout en restant léger, rapide et facile à utiliser.
#### Il répondra aux besoins d'applications modernes avec des dépendances minimales, mais proposera des fonctionnalités puissantes telles que :

## Objectifs du Projet

#### Développer une architecture MVC claire et modulaire.
#### Implémenter un routeur personnalisé pour gérer les URL de l'application.
#### Intégration sécurisée avec Eloquent ORM pour la gestion des bases de données. ( BONUS)
#### Assurer la sécurisation des données contre les attaques XSS, CSRF et SQL Injection.
#### Offrir des outils pratiques : validation des données, système de sessions, gestion des erreurs.
#### Séparer fonctionnellement le Front Office et le Back Office.
#### Utiliser Composer pour l'autoloading des classes.


## Fonctionnalités Principales

#### Gestion avancée des routes.
#### Connexion à la base de données .
#### Séparation entre Front Office et Back Office.
#### Système d’authentification sécurisé avec permissions utilisateurs.
#### Gestion des rôles et autorisations (ACL).
#### Protection contre SQL Injection, XSS, CSRF.
#### Classes pratiques : Validator, Security, Session.
#### Autoloading dynamique avec Composer.

## Structure MVC Proposée
/job_dating
├── public/
│ ├─ index.php
│ ├─ .htaccess
│ └─ assets/
├── app/
│ ├─ controllers/
│ │ ├─ front/
│ │ └─ back/
│ ├─ models/
│ ├─ views/
│ └─ core/
│ ├─ Router.php
│ ├─ Controller.php
│ ├─ Model.php
│ ├─ View.php
│ ├─ Database.php
│ ├─ Auth.php
│ ├─ Validator.php
│ ├─ Security.php
│ └─ Session.php
┌── config/
│ ├─ config.php
│ └─ routes.php
├── logs/ (Bonus)
├── vendor/
├── .env
├── composer.json
└── .gitignore

## - Séparation stricte des responsabilités

### Front Office : Partie publique accessible à tous.
### Back Office : Réservé aux administrateurs authentifiés.


## - Sécurisation des données

### Protection CSRF via des tokens sécurisés.
### Validation des entrées utilisateurs avec Validator.php.
### Protection contre les attaques XSS et SQL Injection avec Security.php.

## - Modularité

### Utilisation de classes abstraites pour réutiliser le code.
### Intégration facile avec d'autres bases de données.

## - Gestion avancée des sessions et authentification

### Gestion des sessions avec Session.php.
### Authentification utilisateur via Auth.php.

## - Autoloading avec Composer

###  Créez un fichier composer.json pour gérer les dépendances.
