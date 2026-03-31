<?php
/**
 * INDEX.PHP - LE ROUTEUR (FRONT CONTROLLER)
 * C'est la porte d'entrée unique de ton site.
 */

// 1. Démarrer la session (obligatoire pour savoir si un user est connecté)
session_start();

// 2. Inclure la connexion à la base de données (le tuyau)
// On utilise require_once pour être sûr qu'on ne l'inclut qu'une fois
require_once 'config/db.php';

// 3. Récupérer l'action demandée dans l'URL (ex: index.php?action=inscription)
// Si aucune action n'est précisée, on va sur 'accueil' par défaut
$action = isset($_GET['action']) ? $_GET['action'] : 'accueil';

// 4. L'AIGUILLAGE (Le Switch)
// On regarde ce que l'utilisateur veut faire et on appelle le bon fichier
switch ($action) {

    case 'inscription':
        // On appelle ton contrôleur d'inscription
        include 'views/inscription.php';
        break;

    case 'connexion':
        // C'est ici qu'on mettra la logique de connexion plus tard
        echo "<h1>Page de Connexion</h1>";
        echo "<p>En cours de développement...</p>";
        break;

    case 'accueil':
    default:
        // C'est la page qui s'affiche quand on arrive sur le site
        echo "<h1>Bienvenue sur VENDO !</h1>";
        echo "<p>Le site de petites annonces entre particuliers.</p>";
        echo "<hr>";
        echo "<a href='index.php?action=inscription'>S'inscrire sur le site</a>";
        break;
}