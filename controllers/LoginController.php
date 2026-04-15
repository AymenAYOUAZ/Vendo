<?php
session_start();

/* //ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/

require_once '../config/db.php';
require_once '../models/UserModel.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../index.php?action=connexion');
    exit();
}

$email = trim($_POST['email'] ?? '');
$mdp_saisi = $_POST['password'] ?? '';

if (empty($email) || empty($mdp_saisi)) {
    $_SESSION['error'] = "Email et mot de passe obligatoires.";
    header('Location: ../index.php?action=connexion');
    exit();
}

$user = recupererUtilisateurParEmail($pdo, $email);

if ($user && password_verify($mdp_saisi, $user['mot_de_passe'])) {
    $_SESSION['user'] = $user;
    $_SESSION['success'] = "Connexion réussie !";
    header('Location: ../index.php?action=accueil');
    exit();
} else {
    $_SESSION['error'] = "Email ou mot de passe incorrect.";
    header('Location: ../index.php?action=connexion');
    exit();
}