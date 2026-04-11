<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détail de l'annonce</title>
</head>
<body>

    <?php if ($annonce): ?>
        <h1><?= htmlspecialchars($annonce['titre']) ?></h1>

        <?php if (!empty($annonce['photo'])): ?>
            <img src="/Vendo/public/uploads/<?= htmlspecialchars($annonce['photo']) ?>" width="300" alt="photo annonce">
        <?php endif; ?>

        <p><strong>Prix :</strong> <?= htmlspecialchars($annonce['prix']) ?> €</p>
        <p><strong>Description :</strong></p>
        <p><?= nl2br(htmlspecialchars($annonce['description'])) ?></p>

        <br>
        <a href="/Vendo/index.php?action=accueil">Retour à l'accueil</a>
    <?php else: ?>
        <p>Annonce introuvable.</p>
    <?php endif; ?>

</body>
</html>