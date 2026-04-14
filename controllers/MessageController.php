<?php
session_start();

// Affichage des erreurs pour le débug (à enlever quand t'as fini)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// UTILISE __DIR__ pour être sûr que le serveur trouve les fichiers
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/MessageModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['envoyer_message'])) {
    
    // 1. Vérification session
    if (!isset($_SESSION['user']['idu'])) {
        header('Location: ../index.php?action=connexion');
        exit();
    }

    // 2. Récupération et nettoyage
    $exp = $_SESSION['user']['idu'];
    $dest = isset($_POST['id_destinataire']) ? (int)$_POST['id_destinataire'] : 0;
    $annonce = isset($_POST['id_annonce']) ? (int)$_POST['id_annonce'] : 0;
    $texte = isset($_POST['message']) ? trim($_POST['message']) : '';
    $provenance = $_POST['provenance'] ?? 'annonce';

    // 3. Validation minimum
    if ($dest > 0 && $annonce > 0 && !empty($texte)) {
        
        // On enregistre
        $success = envoyerMessage($pdo, $exp, $dest, $annonce, $texte);
        
        if ($success) {
            // REDIRECTION INTELLIGENTE
            if ($provenance === 'messagerie') {
                header("Location: ../index.php?action=messagerie");
            } else {
                header("Location: ../index.php?action=detail_annonce&id=$annonce&msg=sent");
            }
            exit();
        } else {
            die("Erreur technique lors de l'envoi du message.");
        }
        
    } else {
        // Si les données sont incomplètes, on renvoie à l'accueil
        header('Location: ../index.php?action=accueil');
        exit();
    }
}