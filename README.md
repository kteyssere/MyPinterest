# MyPinterest

# MonProjet

## Table des matières
1. [Introduction](#introduction)
2. [Structure des fichiers et conteneurs Docker](#structure-des-fichiers-et-conteneurs-docker)
3. [Étapes pour exécuter le projet](#étapes-pour-exécuter-le-projet)
4. [Choix technologiques et configurations Docker](#choix-technologiques-et-configurations-docker)

---

## Introduction
Ce projet est une application web comprenant :
- Un backend Symfony pour gérer les utilisateurs, les images, et les réactions (likes/dislikes).
- Un frontend Angular pour la gestion de l'interface utilisateur.
- Une base de données MySQL pour le stockage persistant des données.

Ce README fournit les détails techniques sur l'architecture, les fichiers, et la configuration Docker pour l'exécution du projet.

---
## Structure des fichiers et conteneurs Docker

## Étapes pour exécuter le projet

#### Etape 1: Clôner le projet
git clone https://github.com/kteyssere/MyPinterest.git
cd MyPinterest

#### Etape 2 : Démarrer le conteneur 
```bash 
    docker-compose up --build  
```

#### Etape 3 : Configurez la base de données
```bash
    docker exec -it symfony-backend bash
    php bin/console make:migration
    php bin/console doctrine:migrations:migrate
    php bin/console doctrine:fixtures:load
```
#### Vous pouvez maintenant essayer l'application avec les données qui ont été persistés ! Bravo !

## Choix technologiques et configurations Docker

#### Choix technologiques
    - Symfony (backend) : Pour une gestion robuste des API REST et des interactions avec la base de données.
    - Angular (frontend) : Pour une interface utilisateur dynamique et réactive.
    - MySQL : Base de données relationnelle pour la persistance des données.
    - PhpMyAdmin : Gestion graphique de MySQL.

#### Configuration Docker
    - PhpMyAdmin
```bash
    http://localhost:8081
```
    - Front
```bash
    http://localhost:4200/login
```
    - Back
```bash
    http://localhost:8000/
```