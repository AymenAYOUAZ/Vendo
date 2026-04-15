<?php
session_start();
/* //ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/

// 1. Connexion BDD et Modèles
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/models/AnnonceModel.php';
require_once __DIR__ . '/models/MessageModel.php';
require_once __DIR__ . '/models/UserModel.php';

// --- CALCUL DES NOTIFICATIONS (DOIT ÊTRE FAIT ICI, TOUT EN HAUT) ---
$nb_non_lus = 0;
if (isset($_SESSION['user']['idu'])) {
    $nb_non_lus = compterMessagesNonLus($pdo, $_SESSION['user']['idu']);
}

// --- SÉCURITÉ OBLIGATOIRE ---
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

function e($string) {
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}

$action = $_GET['action'] ?? 'accueil';
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
                    <a href="index.php?action=profil" style="text-decoration: none; color: inherit; font-weight: bold;">👤 <?= e($_SESSION['user']['pseudo'] ?? 'Moi') ?></a>
                </div>
                <a href="index.php?action=mes_favoris" class="btn-secondary">❤️ Mes Favoris</a>
                
                <a href="index.php?action=messagerie" class="btn-secondary" style="position: relative;">💬 Messages
                    <?php if ($nb_non_lus > 0): ?>
                        <span class="badge" style="background: red; color: white; border-radius: 50%; padding: 2px 6px; font-size: 12px;">
                            <?= $nb_non_lus ?>
                        </span>
                    <?php endif; ?>
                </a>

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
        <div class="flash-message error">⚠️ <?= e($_SESSION['error']); unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="flash-message success">✅ <?= e($_SESSION['success']); unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <?php 
    switch ($action) {
        case 'toggle_favori':
            if (!isset($_SESSION['user']['idu'])) { header('Location: index.php?action=connexion'); exit(); }
            if (isset($_GET['id'])) toggleFavori($pdo, $_SESSION['user']['idu'], (int)$_GET['id']);
            header("Location: " . ($_SERVER['HTTP_REFERER'] ?? 'index.php?action=accueil'));
            exit();

        case 'mes_favoris':
            if (!isset($_SESSION['user']['idu'])) { header('Location: index.php?action=connexion'); exit(); }
            $annonces = recupererMesFavoris($pdo, $_SESSION['user']['idu']);
            $titre_page = "Mes annonces favorites ❤️";
            include __DIR__ . '/views/accueil.php';
            break;

        case 'recherche_ajax':
             $recherche = $_GET['q'] ?? '';
             $annonces = recupererAnnoncesFiltrees($pdo, $recherche);
             // On n'inclut PAS le header/footer ici, juste les cartes
             include __DIR__ . '/views/partials/liste_annonces.php'; 
             exit(); // Très important pour ne pas charger le reste du site   

        case 'inscription': include __DIR__ . '/views/inscription.php'; break;
        case 'connexion': include __DIR__ . '/views/login.php'; break;

        case 'creer_annonce':
            if (!isset($_SESSION['user'])) header('Location: index.php?action=connexion');
            include __DIR__ . '/views/creer_annonce.php';
            break;

        case 'top_annonces':
             $annonces = recupererAnnoncesPopulaires($pdo); 
             $titre_page = "Top Annonces (Plus vues)";
             include __DIR__ . '/views/accueil.php'; 
             break;

        case 'modifier_annonce':
            if (isset($_GET['id'])) {
                $annonce = recupererAnnonceParId($pdo, (int)$_GET['id']);
                if ($annonce) include __DIR__ . '/views/modifier_annonce.php';
            }
            break;

        case 'detail_annonce':
            if (isset($_GET['id'])) {
                $id_ann = (int)$_GET['id'];
                $annonce = recupererAnnonceParId($pdo, $id_ann);

                if ($annonce) {
                    // Si connecté, on enregistre la vue
                    if (isset($_SESSION['user']['idu'])) {
                        enregistrerVue($pdo, $id_ann, $_SESSION['user']['idu']);
                    }

                    // On récupère le compteur pour l'afficher
                    $total_vues = compterVues($pdo, $id_ann);

                    include __DIR__ . '/views/detail_annonce.php';
                }
            }
            break;

        case 'messagerie':
            if (!isset($_SESSION['user']['idu'])) { header('Location: index.php?action=connexion'); exit(); }
            $discussions = recupererBoiteDeReception($pdo, $_SESSION['user']['idu']);
            include __DIR__ . '/views/messagerie.php';
            break;

        case 'conversation':
            require_once __DIR__ . '/controllers/MessageController.php';
            afficherConversation($pdo); 
            break;
        
        case 'envoyer_message':
            require_once __DIR__ . '/controllers/MessageController.php';
            traiterEnvoiMessage($pdo);
            break;

        case 'accueil':
        default:
            $recherche = $_GET['q'] ?? '';
            $categorie = $_GET['categorie'] ?? '';
            $prix_max = $_GET['prix_max'] ?? null;
            $annonces = recupererAnnoncesFiltrees($pdo, $recherche, $categorie, null, $prix_max);
            $titre_page = "Dernières pépites dénichées";
            include __DIR__ . '/views/accueil.php';
            break;

            case 'profil':
            // Sécurité : Faut être connecté
            if (!isset($_SESSION['user'])) {
                header('Location: index.php?action=connexion');
                exit();
            }
            // On récupère ses annonces
            $mes_annonces = recupererAnnoncesParUtilisateur($pdo, $_SESSION['user']['idu']);
            include __DIR__ . '/views/profil.php';
            break;

        case 'modifier_profil':
            if (!isset($_SESSION['user'])) {
                header('Location: index.php?action=connexion');
                exit();
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $pseudo = trim($_POST['pseudo']);
                $email = trim($_POST['email']);
                
                // Récupération des champs de mot de passe
                $ancien_mdp = $_POST['ancien_mdp'] ?? '';
                $nouveau_mdp = $_POST['nouveau_mdp'] ?? '';
                $confirm_mdp = $_POST['confirm_mdp'] ?? '';
                
                $erreur = null;
                $mdp_a_mettre_a_jour = null;

                if (empty($pseudo) || empty($email)) {
                    $erreur = "Le pseudo et l'email sont obligatoires.";
                }

                // Si l'utilisateur tente de changer son mot de passe
                if (!empty($ancien_mdp) || !empty($nouveau_mdp) || !empty($confirm_mdp)) {
                    
                    // 1. Vérifier que les 3 champs sont remplis
                    if (empty($ancien_mdp) || empty($nouveau_mdp) || empty($confirm_mdp)) {
                        $erreur = "Pour changer de mot de passe, tu dois remplir les trois champs.";
                    } 
                    // 2. Vérifier la longueur stricte
                    elseif (strlen($nouveau_mdp) < 10) {
                        $erreur = "Le nouveau mot de passe doit contenir au moins 10 caractères.";
                    }
                    // 3. Vérifier la confirmation
                    elseif ($nouveau_mdp !== $confirm_mdp) {
                        $erreur = "La confirmation du nouveau mot de passe ne correspond pas.";
                    }
                    // 4. Vérifier l'ancien mot de passe en base de données
                    else {
                        $hash_actuel = recupererMotDePasseUtilisateur($pdo, $_SESSION['user']['idu']);
                        if (!password_verify($ancien_mdp, $hash_actuel)) {
                            $erreur = "L'ancien mot de passe est incorrect.";
                        } else {
                            // Tout est bon, on valide le nouveau mot de passe
                            $mdp_a_mettre_a_jour = $nouveau_mdp;
                        }
                    }
                }

                // Si aucune erreur n'a été détectée, on met à jour
                if (!$erreur) {
                    if (modifierProfil($pdo, $_SESSION['user']['idu'], $pseudo, $email, $mdp_a_mettre_a_jour)) {
                        $_SESSION['user']['pseudo'] = $pseudo;
                        $_SESSION['user']['email'] = $email;
                        $_SESSION['success'] = "Profil mis à jour avec succès !";
                        header('Location: index.php?action=profil');
                        exit();
                    } else {
                        $erreur = "Erreur technique lors de la mise à jour.";
                    }
                }
                
                // S'il y a une erreur, on la stocke pour l'afficher
                if ($erreur) {
                    $_SESSION['error'] = $erreur;
                }
            }
            include __DIR__ . '/views/modifier_profil.php';
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

    let lastScroll = 0;
    const navbar = document.querySelector('.navbar');
    window.addEventListener('scroll', () => {
        const current = window.scrollY;
        if (current > lastScroll && current > 80) {
            navbar.classList.add('navbar-hidden');
        } else {
            navbar.classList.remove('navbar-hidden');
        }
        lastScroll = current;
    });
</script>
</body>
</html>