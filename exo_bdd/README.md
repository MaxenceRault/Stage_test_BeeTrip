# Gestion de Projet en PHP/MySQL

Ce projet est un logiciel de gestion de projet permettant de créer, assigner et suivre des tâches.  
Il a été développé en **PHP (POO)** avec une base de données **MySQL**.

## 📌 Fonctionnalités

- **Authentification** (Inscription et Connexion des utilisateurs)
- **Création et Gestion des tâches** (Ajout, Modification, Suppression)
- **Assignation des tâches** (Responsable, Relecteur, Suiveur)
- **Commentaires sur les tâches**
- **Liaison entre tâches**
- **Vue globale des tâches (`index.php`)**
- **Tableau de bord utilisateur (`dashboard.php`)**
- **Interface moderne avec CSS (`public/styles.css`)**

---

## 🚀 Installation

### 1️⃣ **Cloner le projet**
```sh
git clone https://github.com/votre-repo.git
cd gestion-projet-php
``` 
### 2️⃣ Configuration de la base de données
Importez le fichier gestion_projet_exo_stage.sql dans votre base MySQL.
Pour modifier votre chemin , modifiez database.php dans le dossier config
### 3️⃣ Lancer le serveur PHP
Utiliser Mamp ou laragon

📊 Base de données
📌 Tables principales
**Utilisateur (id, nom, email, password, societe_id)**
**Tache (id, titre, description, dateDeadline, etat, createur_id)**
**Affectation (id, tache_id, utilisateur_id, role)**
**Commentaire (id, texte, dateCreation, utilisateur_id, tache_id)**
**TacheLiee (id, tache_id, tache_reference_id)**








