<?php
// On inclut le Modèle pour pouvoir utiliser la fonction ajouterUtilisateur
require_once 'models/UserModel.php';

// 1. On récupère les données du formulaire
$email = $_POST['email'];
$mdp_clair = $_POST['password']; // Le mot de passe tapé par l'utilisateur

// 2. LA VÉRIFICATION (Le mot de passe doit faire au moins 10 caractères)
if (strlen($mdp_clair) < 10) {
    $erreur = "Le mot de passe doit faire au moins 10 caractères !";
    include 'views/inscription_view.php'; // On réaffiche le formulaire avec l'erreur
    exit(); // On arrête tout ici, on n'enregistre rien !
}

// 3. LE HACHAGE (La sécurité 255 caractères)
// Cette fonction transforme "soleil123" en un truc de 60 à 255 caractères
$mdp_securise = password_hash($mdp_clair, PASSWORD_DEFAULT);

// 4. L'ENREGISTREMENT
// On appelle la fonction du Modèle avec le mot de passe transformé
$resultat = ajouterUtilisateur($pdo, $email, $mdp_securise);

if ($resultat) {
    echo "Inscription réussie !";
} else {
    echo "Erreur lors de l'inscription.";
}