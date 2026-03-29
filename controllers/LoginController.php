<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('../config/db.php'); // On inclut la connexion à la BDD pour pouvoir l'utiliser dans le Modèle
require_once ('../models/UserModel.php'); // On inclut le Modèle pour pouvoir utiliser la fonction d'ajout d'utilisateur
// 1. On récupère les données du formulaire
$email = $_POST['email'];
$mdp_saisi = $_POST['password']; 

$user = recupererUtilisateurParEmail($pdo, $email); // On récupère l'utilisateur par son email
if ($user) {
    // L'utilisateur existe, on vérifie le mot de passe
    if (password_verify($mdp_saisi, $user['mot_de_passe'])) {
        echo "Connexion réussie ! Bienvenue " . $user['pseudo'] . " !";
        include '../views/login.php';
    } else {
        echo "Mot de passe incorrect.";
        include '../views/login.php';
        exit();
    }
} else {
    echo "Aucun utilisateur trouvé avec cet email.";
    include '../views/login.php';
    exit();
}


