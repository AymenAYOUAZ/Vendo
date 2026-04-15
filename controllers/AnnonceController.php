<?php
session_start();
/* //ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/AnnonceModel.php';

// Fonction améliorée avec vérification stricte
function uploaderPhoto($fileInfos) {
    $extensionsAutorisees = ['jpg', 'jpeg', 'png', 'webp'];
    $dossierUpload = '../public/uploads/';
    $fileExtension = strtolower(pathinfo($fileInfos['name'], PATHINFO_EXTENSION));
    
    // Vérification de l'extension
    if (!in_array($fileExtension, $extensionsAutorisees)) {
        return "erreur_format";
    }

    // Vérification de la réalité de l'image (MIME type)
// Remplace le bloc finfo par celui-là :
$checkImage = getimagesize($fileInfos['tmp_name']);
if ($checkImage === false) {
    return "erreur_mime";
}

    if (!is_dir($dossierUpload)) mkdir($dossierUpload, 0777, true);

    $photoName = uniqid('annonce_') . '.' . $fileExtension;
    if (move_uploaded_file($fileInfos['tmp_name'], $dossierUpload . $photoName)) {
        return $photoName;
    }
    return false;
}

// ---------------- AJOUTER ----------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_annonce'])) {
    if (!isset($_SESSION['user']['idu'])) header('Location: ../index.php?action=connexion');

    $titre = trim($_POST['titre']);
    $prix = trim($_POST['prix']);
    $description = trim($_POST['description']);
    $user_id = $_SESSION['user']['idu']; 
    $photoName = '';
    $categorie = $_POST['categorie'] ?? 'Autres';

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
        $result = uploaderPhoto($_FILES['photo']);
       
        // GESTION DES ERREURS DE PHOTO
        if ($result === "erreur_format" || $result === "erreur_mime") {
            $_SESSION['error'] = "Le fichier sélectionné n'est pas une image valide (JPG, PNG, WEBP uniquement).";
            header('Location: ../index.php?action=creer_annonce');
            exit(); // ON ARRÊTE TOUT ICI
        } elseif ($result === false) {
            $_SESSION['error'] = "Erreur lors de l'upload de l'image.";
            header('Location: ../index.php?action=creer_annonce');
            exit();
        } else {
            $photoName = $result;
        }
    } else {
        // IMAGE OBLIGATOIRE
        $_SESSION['error'] = "Veuillez sélectionner une photo pour votre annonce.";
        header('Location: ../index.php?action=creer_annonce');
        exit();
    }

    if (ajouterAnnonce($pdo, $titre, $prix, $description, $photoName, $user_id, $categorie)) {
        $_SESSION['success'] = "Annonce publiée avec succès !";
        header('Location: ../index.php?action=accueil');
        exit();
    }
}

// ---------------- SUPPRIMER ----------------
if (isset($_GET['action']) && $_GET['action'] === 'supprimer' && isset($_GET['id'])) {
    if (!isset($_SESSION['user']['idu'])) die("Non connecté");

    $id_annonce = (int) $_GET['id'];
    $annonce = recupererAnnonceParId($pdo, $id_annonce);

    if ($annonce && $annonce['user_id'] == $_SESSION['user']['idu']) {
        supprimerAnnonce($pdo, $id_annonce);
        $_SESSION['success'] = "Annonce supprimée.";
        header('Location: ../index.php?action=accueil');
        exit();
    }
}

// ---------------- MODIFIER ----------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'modifier') {
    if (!isset($_SESSION['user']['idu'])) header('Location: ../index.php?action=connexion');
    
    $id = (int) $_POST['id_annonce'];
    $titre = trim($_POST['titre']);
    $prix = trim($_POST['prix']);
    $description = trim($_POST['description']);
    $categorie = $_POST['categorie'] ?? 'Autres';

    $ancienneAnnonce = recupererAnnonceParId($pdo, $id);

    if ($ancienneAnnonce && $ancienneAnnonce['user_id'] == $_SESSION['user']['idu']) {
        $photoName = $ancienneAnnonce['photo'];
        
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
            $result = uploaderPhoto($_FILES['photo']);
            if ($result !== "erreur_format" && $result !== "erreur_mime" && $result !== false) {
                $photoName = $result;
            } else {
                $_SESSION['error'] = "Image invalide, modification annulée.";
                header("Location: ../index.php?action=modifier_annonce&id=$id");
                exit();
            }
        }

        if (modifierAnnonce($pdo, $id, $titre, $prix, $description, $photoName, $categorie)) {
            $_SESSION['success'] = "Annonce mise à jour !";
            header('Location: ../index.php?action=accueil');
            exit();
        }
    } else {
        die("Action interdite.");
    }
}