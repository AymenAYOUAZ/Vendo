<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier une annonce</title>
</head>
<body>

    <h2>Modifier l'annonce</h2>

    <form action="/Vendo/controllers/AnnonceController.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= htmlspecialchars($annonce['id']) ?>">

        <div>
            <label for="titre">Nom de l'annonce :</label>
            <input type="text" id="titre" name="titre" value="<?= htmlspecialchars($annonce['titre']) ?>" required>
        </div>

        <br>

        <div>
            <label for="prix">Prix (€) :</label>
            <input type="number" id="prix" name="prix" step="0.01" value="<?= htmlspecialchars($annonce['prix']) ?>" required>
        </div>

        <br>

        <div>
            <label for="description">Description :</label>
            <textarea id="description" name="description" rows="5" required><?= htmlspecialchars($annonce['description']) ?></textarea>
        </div>

        <br>

        <div>
            <p>Photo actuelle :</p>
            <?php if (!empty($annonce['photo'])): ?>
                <img src="/Vendo/public/uploads/<?= htmlspecialchars($annonce['photo']) ?>" width="180" alt="photo actuelle">
            <?php else: ?>
                <p>Aucune photo</p>
            <?php endif; ?>
        </div>

        <br>

        <div>
            <label for="photo">Nouvelle photo (optionnel) :</label>
            <input type="file" id="photo" name="photo" accept="image/*">
        </div>

        <br>

        <button type="submit" name="modifier_annonce">Enregistrer les modifications</button>
    </form>

    <br>
    <a href="/Vendo/index.php?action=accueil">Retour à l'accueil</a>

</body>
</html>