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
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>VENDO</title>
      <link rel="stylesheet" href="public/css/style.css">
    </head>
    <body>

    <nav class="navbar">
      <a class="navbar-logo" href="index.php?action=accueil">
        <img src="public/vendo_logo_minimal.svg" alt="Vendo">
      </a>
      <div class="navbar-links">
        <?php if (isset($_SESSION['user'])): ?>
          <span>👤 <?= htmlspecialchars($_SESSION['user']['pseudo']) ?></span>
          <a href="index.php?action=creer_annonce" class="btn-primary">+ Déposer</a>
          <a href="controllers/LogoutController.php" class="btn-secondary">Déconnexion</a>
        <?php else: ?>
          <a href="index.php?action=inscription" class="btn-secondary">S'inscrire</a>
          <a href="index.php?action=connexion" class="btn-primary">Se connecter</a>
        <?php endif; ?>
      </div>
    </nav>

    <div class="hero">
      <h1>Achetez, vendez, simplement.</h1>
      <p>Des milliers d'annonces entre particuliers</p>
    </div>

    <div class="container">

      <?php if (isset($_SESSION['success'])): ?>
        <div class="flash-success">
          <?= htmlspecialchars($_SESSION['success']) ?>
        </div>
        <?php unset($_SESSION['success']); ?>
      <?php endif; ?>

      <?php if (isset($_SESSION['error'])): ?>
        <div class="flash-error">
          <?= htmlspecialchars($_SESSION['error']) ?>
        </div>
        <?php unset($_SESSION['error']); ?>
      <?php endif; ?>

      <h2 style="font-size:20px; margin-bottom:8px; color:#222;">Les dernières annonces</h2>

      <?php if (!empty($annonces)): ?>
        <div class="annonces-grid">
          <?php foreach ($annonces as $annonce): ?>
            <div class="annonce-card">
              <?php if (!empty($annonce['photo'])): ?>
                <img src="public/uploads/<?= htmlspecialchars($annonce['photo']) ?>" alt="photo">
              <?php else: ?>
                <div style="width:100%;height:180px;background:#f0f0f0;display:flex;align-items:center;justify-content:center;color:#aaa;font-size:13px;">Pas de photo</div>
              <?php endif; ?>