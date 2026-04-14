<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Connexion BDD et Modèles
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/models/AnnonceModel.php';
require_once __DIR__ . '/models/MessageModel.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'accueil';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VENDO - Achetez & Vendez simplement</title>
    <link rel="stylesheet" href="/Vendo/public/css/style.css?v=<?= time(); ?>">
</head>
<body>

<nav class="navbar">
    <div class="container">
        <a class="navbar-logo" href="index.php?action=accueil">VENDO</a>
        
        <div class="navbar-links">
            <?php if (isset($_SESSION['user'])): ?>
                <div class="user-badge">
                    👤 <?= htmlspecialchars($_SESSION['user']['pseudo'] ?? $_SESSION['user']['username'] ?? 'Moi') ?>
                </div>
                <a href="index.php?action=messagerie" class="btn-secondary">💬 Messages</a>
                <a href="index.php?action=creer_annonce" class="btn-primary">+ Vendre</a>
                <a href="controllers/LogoutController.php" class="btn-secondary">Déconnexion</a>
            <?php else: ?>
                <a href="index.php?action=inscription" class="btn-secondary">S'inscrire</a>
                <a href="index.php?action=connexion" class="btn-primary">Se connecter</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<main class="container" style="margin-top: 100px; min-height: 70vh;">
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="flash-message error">
            ⚠️ <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="flash-message success">
            ✅ <?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <?php 
    switch ($action) {
        case 'inscription':
            include __DIR__ . '/views/inscription.php';
            break;

        case 'connexion':
            include __DIR__ . '/views/login.php';
            break;

        case 'creer_annonce':
            if (!isset($_SESSION['user'])) header('Location: index.php?action=connexion');
            include __DIR__ . '/views/creer_annonce.php';
            break;

        case 'modifier_annonce':
            if (isset($_GET['id'])) {
                $id = (int) $_GET['id'];
                $annonce = recupererAnnonceParId($pdo, $id);
                if ($annonce) {
                    include __DIR__ . '/views/modifier_annonce.php';
                } else { echo "<div class='empty-state'>Annonce introuvable.</div>"; }
            }
            break;

        case 'detail_annonce':
            if (isset($_GET['id'])) {
                $id = (int) $_GET['id'];
                $annonce = recupererAnnonceParId($pdo, $id);
                if ($annonce) {
                    include __DIR__ . '/views/detail_annonce.php';
                } else { echo "<div class='empty-state'>Annonce introuvable.</div>"; }
            }
            break;

        case 'messagerie':
            if (!isset($_SESSION['user']['idu'])) {
                header('Location: index.php?action=connexion');
                exit();
            }
            $messages = recupererToutesMesDiscussions($pdo, $_SESSION['user']['idu']);
            include __DIR__ . '/views/messagerie.php';
            break;

        case 'accueil':
        default:
            $annonces = recupererAnnonces($pdo);
            include __DIR__ . '/views/accueil.php';
            break;
    }
    ?>
</main>

<footer>
    <div class="container">
        <p>&copy; <?= date('Y') ?> VENDO - Projet Bachelor Informatique</p>
    </div>
</footer>

<button class="theme-toggle" id="themeToggle" title="Changer de thème">🌙</button>

<script>
    // GESTION DU DARK MODE
    const btn = document.getElementById('themeToggle');
    const saved = localStorage.getItem('theme') || 'light';
    document.documentElement.setAttribute('data-theme', saved);
    btn.textContent = saved === 'dark' ? '☀️' : '🌙';

    btn.addEventListener('click', () => {
        const next = document.documentElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
        document.documentElement.setAttribute('data-theme', next);
        localStorage.setItem('theme', next);
        btn.textContent = next === 'dark' ? '☀️' : '🌙';
    });

    // GESTION DU SCROLL NAVBAR
    let lastScroll = 0;
    const navbar = document.querySelector('.navbar');

    window.addEventListener('scroll', () => {
        const current = window.scrollY;
        if (current > lastScroll && current > 80) {
            navbar.classList.add('navbar-hidden'); // On utilise la classe du CSS
        } else {
            navbar.classList.remove('navbar-hidden');
        }
        lastScroll = current;
    });
</script>

</body>
</html>