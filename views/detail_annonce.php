<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vendo - <?= htmlspecialchars($annonce['titre']) ?></title>
  <link rel="stylesheet" href="/Vendo/public/css/style.css">
</head>
<body>

<nav class="navbar">
  <a class="navbar-logo" href="/Vendo/index.php?action=accueil">
    <img src="/Vendo/public/vendo_logo_minimal.svg" alt="Vendo">
  </a>
  <div class="navbar-links">
    <a href="/Vendo/index.php?action=accueil" class="btn-secondary">Retour</a>
  </div>
</nav>

<div class="detail-container">

  <?php if ($annonce): ?>

    <?php if (!empty($annonce['photo'])): ?>
      <img class="detail-img" src="/Vendo/public/uploads/<?= htmlspecialchars($annonce['photo']) ?>" alt="photo annonce">
    <?php endif; ?>

    <h1 style="font-size:24px;color:#222;"><?= htmlspecialchars($annonce['titre']) ?></h1>

    <div class="detail-price"><?= htmlspecialchars($annonce['prix']) ?> €</div>

    <p class="detail-description"><?= nl2br(htmlspecialchars($annonce['description'])) ?></p>

    <div style="margin-top:24px;">
      <a href="/Vendo/index.php?action=accueil" class="btn-secondary">Retour aux annonces</a>
    </div>

  <?php else: ?>
    <div class="empty-state">Annonce introuvable.</div>
  <?php endif; ?>

</div>

</body>
</html>