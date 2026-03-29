<?php
// On inclut la connexion à la BDD (le tuyau)
require_once '../config/db.php';

/**
 * Fonction pour ajouter un utilisateur dans la base de données
 */
function ajouterUtilisateur($pdo, $email, $mdp_hache, $username) {
    // 1. On prépare la requête SQL (Sécurité contre injections)
    $sql = "INSERT INTO utilisateurs (email, mot_de_passe, pseudo ) VALUES (:email, :mdp, :username)"; // hna drna :email w :mdp bach n7miw l query m3ntha nqoloulou dir plassa l email w mot de passe apres nhaatou les vraies données f execute 
    $stmt = $pdo->prepare($sql);  // hna la commende $stmt tdir la commend sql b une maniera securisée, w hna kayn l protection contre les injections SQL

    // 2. On exécute la requête avec les vraies données
    return $stmt->execute([  // hna kayn l execution de la requete w hna kayn l protection contre les injections SQL, w hna kayn l insertion des données dans la base de données
        'email' => $email,
        'mdp'   => $mdp_hache,
        'username' => $username
    ]);
}
// Fonction pour récupérer un utilisateur par son email (utile pour la connexion)

function recupererUtilisateurParEmail($pdo, $email) {
    $sql = "SELECT * FROM utilisateurs WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':email' => $email]);
    return $stmt->fetch(); // Retourne l'utilisateur ou false s'il n'existe pas
}