# SNCF Ticketing

SNCF Ticketing est une application de gestion de tickets pour la SNCF permettant aux utilisateurs de soumettre des demandes et aux administrateurs de les gérer. Cette documentation décrit comment configurer l'environnement de développement et le déployer avec Docker.

## Prérequis

- **Docker Desktop** - [Télécharger ici](https://www.docker.com/products/docker-desktop)
- **Visual Studio Code** (ou un autre éditeur de texte avec support Docker)
- (Optionnel) **Git** pour le clonage du dépôt


## Installation Docker

1. Téléchargez Docker Desktop depuis [ce lien](https://desktop.docker.com/win/stable/Docker%20Desktop%20Installer.exe).
2. Installez Docker en suivant les instructions de l’assistant.
3. Assurez-vous que WSL 2 est activé comme backend si vous êtes sous Windows.
4. Lancez Docker Desktop et attendez que Docker soit prêt (message "Docker is running").


## Structure du Projet

## Démarrage de l'Environnement avec Docker

Une fois Docker Desktop installé et en cours d'exécution, suivez ces étapes pour démarrer l'environnement.

1. Dans le terminal, assurez-vous d’être dans le répertoire racine du projet (`SNCF-Ticketing`).
2. Exécutez la commande suivante pour construire et démarrer les conteneurs :

   ```bash
   docker-compose up --build
 