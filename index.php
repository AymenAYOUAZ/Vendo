<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'config/db.php';
require_once 'models/AnnonceModel.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'accueil';

switch ($action) {

    case 'inscription':
        include 'views/inscription.php';
        break;

    case 'connexion':
        include 'views/login.php';
        break;

    case 'creer_annonce':
        include 'views/creer_annonce.php';
        break;

    case 'modifier_annonce':
        if (isset($_GET['id'])) {
            $id = (int) $_GET['id'];
            $annonce = recupererAnnonceParId($pdo, $id);

            if ($annonce) {
                include 'views/modifier_annonce.php';
            } else {
                echo "Annonce introuvable.";
            }
        } else {
            echo "ID manquant.";
        }
        break;

    case 'detail_annonce':
        if (isset($_GET['id'])) {
            $id = (int) $_GET['id'];
            $annonce = recupererAnnonceParId($pdo, $id);

            if ($annonce) {
                include 'views/detail_annonce.php';
            } else {
                echo "Annonce introuvable.";
            }
        } else {
            echo "ID manquant.";
        }
        break;

    case 'accueil':
    default:
        $annonces = recupererAnnonces($pdo);
        ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <title>VENDO</title>
        </head>
        <body>

            <h1>Bienvenue sur VENDO !</h1>
            <p>Le site de petites annonces entre particuliers.</p>
            <hr>

            <!-- 🔐 UTILISATEUR -->
            <?php if (isset($_SESSION['user'])): ?>
                <p>Connecté en tant que <?= htmlspecialchars($_SESSION['user']['pseudo']) ?></p>

                <a href="index.php?action=creer_annonce">Créer une annonce</a><br>
                <a href="controllers/LogoutController.php">Se déconnecter</a><br>
            <?php else: ?>
                <a href="index.php?action=inscription">S'inscrire</a><br>
                <a href="index.php?action=connexion">Se connecter</a><br>
            <?php endif; ?>

            <br>

            <!-- ✅ MESSAGE SUCCÈS -->
            <?php if (isset($_SESSION['success'])): ?>
                <p style="color: green; font-weight: bold;">
                    <?= htmlspecialchars($_SESSION['success']) ?>
                </p>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <!-- ❌ MESSAGE ERREUR -->
            <?php if (isset($_SESSION['error'])): ?>
                <p style="color: red; font-weight: bold;">
                    <?= htmlspecialchars($_SESSION['error']) ?>
                </p>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <h2>Liste des annonces</h2>

            <?php if (!empty($annonces)): ?>
                <?php foreach ($annonces as $annonce): ?>
                    <div style="border:1px solid #ccc; padding:15px; margin:15px 0;">

                        <h3><?= htmlspecialchars($annonce['titre']) ?></h3>

                        <p><strong>Prix :</strong> <?= htmlspecialchars($annonce['prix']) ?> €</p>

                        <p><?= nl2br(htmlspecialchars($annonce['description'])) ?></p>

                        <?php if (!empty($annonce['photo'])): ?>
                            <img src="public/uploads/<?= htmlspecialchars($annonce['photo']) ?>" width="200" alt="photo annonce">
                        <?php endif; ?>

                        <br><br>

                        <!-- 🔍 DÉTAIL -->
                        <a href="index.php?action=detail_annonce&id=<?= $annonce['id'] ?>">
                            Voir l'annonce
                        </a>

                        <br><br>

                        <!-- 🔐 ACTIONS -->
                        <?php if (isset($_SESSION['user'])): ?>
                            <a href="index.php?action=modifier_annonce&id=<?= $annonce['id'] ?>">Modifier</a>
                            <br><br>
                            <a href="controllers/AnnonceController.php?action=supprimer&id=<?= $annonce['id'] ?>" onclick="return confirm('Supprimer cette annonce ?')">
                                Supprimer
                            </a>
                        <?php else: ?>
                            <p><em>Connecte-toi pour modifier ou supprimer une annonce.</em></p>
                        <?php endif; ?>

                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucune annonce pour le moment.</p>
            <?php endif; ?>

        </body>
        </html>
        <?php
        break;
}
?>