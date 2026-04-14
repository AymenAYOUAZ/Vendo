<?php
session_start();

require_once '../config/db.php';

require_once '../models/UserModel.php';


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../index.php?action=inscription');
    exit();
}

$username = trim($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');
$mdp_clair = $_POST['password'] ?? '';

if (empty($username) || empty($email) || empty($mdp_clair)) {
    $_SESSION['error'] = "Tous les champs sont obligatoires.";
    header('Location: ../index.php?action=inscription');
    exit();
}

if (strlen($mdp_clair) < 10) {
    $_SESSION['error'] = "Le mot de passe doit faire au moins 10 caractères.";
    header('Location: ../index.php?action=inscription');
    exit();
}

$utilisateurExistant = recupererUtilisateurParEmail($pdo, $email);
if ($utilisateurExistant) {
    $_SESSION['error'] = "Cet email est déjà utilisé.";
    header('Location: ../index.php?action=inscription');
    exit();
}

$mdp_securise = password_hash($mdp_clair, PASSWORD_DEFAULT);

$resultat = ajouterUtilisateur($pdo, $email, $mdp_securise, $username);

if ($resultat) {
    $_SESSION['success'] = "Inscription réussie ! Tu peux maintenant te connecter.";
    header('Location: ../index.php?action=connexion');
    exit();
} else {
    $_SESSION['error'] = "Erreur lors de l'inscription.";
    header('Location: ../index.php?action=inscription');
    exit();
}