<?php
// On inclut la connexion à la BDD (le tuyau)
require_once 'config/db.php';

/**
 * Fonction pour ajouter un utilisateur dans la base de données
 */
function ajouterUtilisateur($pdo, $email, $mdp_hache) {
    // 1. On prépare la requête SQL (Sécurité contre injections)
    $sql = "INSERT INTO utilisateurs (email, mot_de_passe) VALUES (:email, :mdp)"; // hna drna :email w :mdp bach n7miw l query m3ntha nqoloulou dir plassa l email w mot de passe apres nhaatou les vraies données f execute 
    $stmt = $pdo->prepare($sql);  // hna la commende $stmt tdir la commend sql b une maniera securisée, w hna kayn l protection contre les injections SQL

    // 2. On exécute la requête avec les vraies données
    return $stmt->execute([  // hna kayn l execution de la requete w hna kayn l protection contre les injections SQL, w hna kayn l insertion des données dans la base de données
        'email' => $email,
        'mdp'   => $mdp_hache
    ]);
}