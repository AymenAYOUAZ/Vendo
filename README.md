─── DÉBUT DU README.md ───

# 🛒 VENDO — Plateforme de Petites Annonces

> Projet Bachelor Informatique — Application web de petites annonces entre particuliers

## 📌 Description
VENDO est une application web développée en PHP avec une architecture MVC.
Elle permet à des utilisateurs de publier, rechercher et acheter des articles d'occasion.

## 🎯 Fonctionnalités
- ✅ Inscription / Connexion sécurisée (mot de passe hashé)
- 📢 Créer, modifier et supprimer ses annonces (avec photo)
- 🔍 Recherche en temps réel par mot-clé, catégorie et prix (AJAX)
- ❤️  Système de favoris (ajouter / retirer en un clic)
- 💬 Messagerie privée entre acheteur et vendeur
- 🔔 Notifications de messages non lus
- 👁️  Compteur de vues par annonce + page Top Annonces
- 👤 Profil utilisateur modifiable (pseudo, email, mot de passe)
- 🌙 Thème clair / sombre (sauvegardé dans le navigateur)

## 🛠️ Technologies
| Technologie  | Usage                            |
|--------------|----------------------------------|
| PHP 8+       | Backend, logique serveur          |
| MySQL        | Base de données relationnelle     |
| PDO          | Requêtes préparées (anti-SQLi)    |
| HTML/CSS     | Interface utilisateur responsive  |
| JavaScript   | AJAX, thème, navbar scroll        |

## 🗂️ Structure du projet (MVC)
Vendo/
├── config/
│   └── db.php              # Connexion PDO à la base de données
├── controllers/            # Logique de l'application (reçoit les actions)
│   ├── AnnonceController.php
│   ├── LoginController.php
│   ├── AuthController.php
│   ├── LogoutController.php
│   └── MessageController.php
├── models/                 # Fonctions base de données (CRUD)
│   ├── AnnonceModel.php
│   ├── UserModel.php
│   └── MessageModel.php
├── views/                  # Pages HTML/PHP affichées à l'utilisateur
│   ├── accueil.php
│   ├── detail_annonce.php
│   ├── messagerie.php
│   ├── profil.php
│   └── partials/           # Morceaux de page réutilisables
├── public/
│   ├── css/style.css        # Feuille de style principale
│   └── uploads/             # Photos uploadées par les utilisateurs
└── index.php               # Point d'entrée unique (Front Controller)

## ⚙️ Installation
1. Cloner le projet dans htdocs/ (XAMPP) ou www/ (WAMP)
2. Créer une base de données MySQL nommée `Vendo`
3. Importer le fichier SQL fourni (tables : annonces, utilisateurs, messages, favoris, vues_annonces)
4. Vérifier config/db.php :
   $host = 'localhost';  $dbname = 'Vendo';  $user = 'root';  $pass = 'root';
5. Accéder à : http://localhost/Vendo/

## 🔒 Sécurité
- Requêtes PDO préparées → protection contre les injections SQL
- password_hash() + password_verify() → mots de passe jamais stockés en clair
- htmlspecialchars() sur toutes les données affichées → protection XSS
- Vérification user_id avant modification/suppression → protection IDOR
- getimagesize() sur les fichiers uploadés → bloque les faux fichiers PHP
- Token CSRF généré en session → protection partielle contre CSRF

## 🗄️ Base de données — Tables principales
- utilisateurs : idu, pseudo, email, mot_de_passe
- annonces : id, titre, prix, description, photo, user_id, categorie
- messages : id, id_expediteur, id_destinataire, id_annonce, contenu, date_envoi, est_lu
- favoris : id, idu, id_annonce
- vues_annonces : id, id_annonce, id_utilisateur (UNIQUE sur les deux colonnes)

## 👨‍💻 Auteur
Projet réalisé dans le cadre du Bachelor Informatique — 2025

─── FIN DU README.md ───
