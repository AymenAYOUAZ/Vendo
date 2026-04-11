<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../config/db.php';
require_once '../models/AnnonceModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_annonce'])) {
    if (!isset($_SESSION['user'])) {
        header('Location: ../index.php?action=connexion');
        exit();
    }
    $titre = trim($_POST['titre']);
    $prix = trim($_POST['prix']);
    $description = trim($_POST['description']);

    $photoName = '';

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
        $dossierUpload = '../public/uploads/';

        if (!is_dir($dossierUpload)) {
            mkdir($dossierUpload, 0777, true);
        }

        $photoName = time() . '_' . basename($_FILES['photo']['name']);
        $cheminPhoto = $dossierUpload . $photoName;
        move_uploaded_file($_FILES['photo']['tmp_name'], $cheminPhoto);
    }

    $resultat = ajouterAnnonce($pdo, $titre, $prix, $description, $photoName);

    if ($resultat) {
        header('Location: ../index.php?action=accueil');
        exit();
    } else {
        echo "Erreur lors de l'ajout de l'annonce.";
    }
}

if (isset($_GET['action']) && $_GET['action'] === 'supprimer' && isset($_GET['id'])) {
    if (!isset($_SESSION['user'])) {
        header('Location: ../index.php?action=connexion');
        exit();
    }
    $id = (int) $_GET['id'];

    $resultat = supprimerAnnonce($pdo, $id);

    if ($resultat) {
        header('Location: ../index.php?action=accueil');
        exit();
    } else {
        echo "Erreur lors de la suppression.";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modifier_annonce'])) {
    if (!isset($_SESSION['user'])) {
        header('Location: ../index.php?action=connexion');
        exit();
    }
    $id = (int) $_POST['id'];
    $titre = trim($_POST['titre']);
    $prix = trim($_POST['prix']);
    $description = trim($_POST['description']);

    $ancienneAnnonce = recupererAnnonceParId($pdo, $id);

    if (!$ancienneAnnonce) {
        die("Annonce introuvable.");
    }

    $photoName = $ancienneAnnonce['photo'];

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
        $dossierUpload = '../public/uploads/';

        if (!is_dir($dossierUpload)) {
            mkdir($dossierUpload, 0777, true);
        }

        $photoName = time() . '_' . basename($_FILES['photo']['name']);
        $cheminPhoto = $dossierUpload . $photoName;
        move_uploaded_file($_FILES['photo']['tmp_name'], $cheminPhoto);
    }

    $resultat = modifierAnnonce($pdo, $id, $titre, $prix, $description, $photoName);

    if ($resultat) {
        header('Location: ../index.php?action=accueil');
        exit();
    } else {
        echo "Erreur lors de la modification.";
    }
}