<?php
// On inclut la connexion à la BDD (le tuyau)
require_once __DIR__ . '/../config/db.php';

/**
 * Fonction pour ajouter un utilisateur dans la base de données
 */
function ajouterUtilisateur($pdo, $email, $mdp_hache, $username) {
    // 1. On prépare la requête SQL (Sécurité contre injections)
    $sql = "INSERT INTO utilisateurs (email, mot_de_passe, pseudo )
             VALUES (:email, :mdp, :username)"; // hna drna :email w :mdp bach n7miw l query m3ntha nqoloulou dir plassa l email w mot de passe apres nhaatou les vraies données f execute 
    $stmt = $pdo->prepare($sql);  // hna la commende $stmt tdir la commend sql b une maniera securisée, w hna kayn l protection contre les injections SQL

    // 2. On exécute la requête avec les vraies données
    return $stmt->execute([  // hna kayn l execution de la requete w hna kayn l protection contre les injections SQL, w hna kayn l insertion des données dans la base de données
        'email' => $email,
        'mdp'   => $mdp_hache,
        'username' => $username       // hna kayn l insertion des données dans la base de données
    ]);
}
// Fonction pour récupérer un utilisateur par son email (utile pour la connexion)

function recupererUtilisateurParEmail($pdo, $email) {
    $sql = "SELECT * FROM utilisateurs WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':email' => $email]);
    return $stmt->fetch(); // Retourne l'utilisateur ou false s'il n'existe pas
}

/**
 * Récupère uniquement le mot de passe (hashé) d'un utilisateur
 */
function recupererMotDePasseUtilisateur($pdo, $idu) {
    $sql = "SELECT mot_de_passe FROM utilisateurs WHERE idu = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([(int)$idu]);
    return $stmt->fetchColumn();
}

/**
 * Met à jour le profil (et hache le mot de passe s'il est fourni)
 */
function modifierProfil($pdo, $idu, $pseudo, $email, $mdp = null) {
    if (!empty($mdp)) {
        // Le hachage se fait ICI, juste avant l'insertion en BDD
        $hash = password_hash($mdp, PASSWORD_DEFAULT);
        $sql = "UPDATE utilisateurs SET pseudo = ?, email = ?, mot_de_passe = ? WHERE idu = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$pseudo, $email, $hash, $idu]);
    } else {
        $sql = "UPDATE utilisateurs SET pseudo = ?, email = ? WHERE idu = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$pseudo, $email, $idu]);
    }
}