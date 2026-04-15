<?php


/* //ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

error_reporting(E_ALL);
*/
session_start();
require_once __DIR__ . '/../config/db.php';

require_once __DIR__ . '/../models/MessageModel.php';

// Dans controllers/MessageController.php
function afficherConversation($pdo) {
    $id_annonce = (int)$_GET['id_annonce'];
    $id_interlocuteur = (int)$_GET['id_interlocuteur'];
    $mon_id = $_SESSION['user']['idu'];

    // --- NOUVEAU : On marque les messages comme lus dès l'ouverture ---
    marquerCommeLus($pdo, $mon_id, $id_interlocuteur, $id_annonce);

    $messages = recupererConversation($pdo, $mon_id, $id_interlocuteur, $id_annonce);
    $annonce = recupererAnnonceParId($pdo, $id_annonce);
    
    include __DIR__ . '/../views/conversation.php';
}

function traiterEnvoiMessage($pdo) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_annonce = (int)$_POST['id_annonce'];
        $id_destinataire = (int)$_POST['id_destinataire'];
        $contenu = trim($_POST['contenu']);

        if (!empty($contenu)) {
            // 1. On enregistre en base de données
            ajouterMessage($pdo, $_SESSION['user']['idu'], $id_destinataire, $id_annonce, $contenu);
        }

        // 2. ON REDIRIGE IMMEDIATEMENT vers la même page de conversation
        // C'est ça qui fait que le message "s'affiche" pour celui qui envoie
        header("Location: index.php?action=conversation&id_annonce=$id_annonce&id_interlocuteur=$id_destinataire");
        exit();
    }
}