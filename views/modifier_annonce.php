<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vendo - Modifier une annonce</title>
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

<div class="form-card">
  <h2>Modifier l'annonce</h2>

  <form action="/Vendo/controllers/AnnonceController.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= htmlspecialchars($annonce['id']) ?>">

    <div class="form-group">
      <label for="titre">Nom de l'annonce</label>
      <input type="text" id="titre" name="titre" value="<?= htmlspecialchars($annonce['titre']) ?>" required>
    </div>

    <div class="form-group">
      <label for="prix">Prix (€)</label>
      <input type="number" id="prix" name="prix" step="0.01" value="<?= htmlspecialchars($annonce['prix']) ?>" required>
    </div>

    <div class="form-group">
      <label for="description">Description</label>
      <textarea id="description" name="description" rows="5" required><?= htmlspecialchars($annonce['description']) ?></textarea>
    </div>

    <div class="form-group">
      <label>Photo actuelle</label>
      <?php if (!empty($annonce['photo'])): ?>
        <img src="/Vendo/public/uploads/<?= htmlspecialchars($annonce['photo']) ?>" style="width:100%;border-radius:6px;margin-bottom:10px;" alt="photo actuelle">
      <?php else: ?>
        <p style="color:#aaa;font-size:14px;">Aucune photo</p>
      <?php endif; ?>
    </div>

    <div class="form-group">
      <label for="photo">Nouvelle photo (optionnel)</label>
      <input type="file" id="photo" name="photo" accept="image/*">
    </div>

    <div style="display:flex;gap:10px;">
      <button type="submit" name="modifier_annonce" class="btn-primary" style="flex:1;">Enregistrer</button>
      <a href="/Vendo/index.php?action=accueil" class="btn-secondary" style="flex:1;text-align:center;padding:12px;">Annuler</a>
    </div>

  </form>
</div>

</body>
</html>