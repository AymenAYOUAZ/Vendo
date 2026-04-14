<div class="hero">
    <div class="container">
        <h1>Achetez, vendez, simplement.</h1>
        <p>Des milliers d'annonces entre particuliers à portée de clic.</p>
    </div>
</div>

<div class="container">
    
    <?php if (isset($_SESSION['success'])): ?>
        <div class="flash-message success">
            <?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="flash-message error">
            <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <div class="section-header">
        <h2>Dernières pépites dénichées</h2>
        <?php if (isset($_SESSION['user'])): ?>
            <a href="index.php?action=creer_annonce" class="btn-primary">+ Publier une annonce</a>
        <?php endif; ?>
    </div>

    <?php if (!empty($annonces)): ?>
        <div class="annonces-grid">
            <?php foreach ($annonces as $annonce): ?>
                <div class="annonce-card">
                    <a href="index.php?action=detail_annonce&id=<?= $annonce['id'] ?>" class="card-link">
                        <div class="card-image">
                            <?php if (!empty($annonce['photo'])): ?>
                                <img src="public/uploads/<?= htmlspecialchars($annonce['photo']) ?>" alt="<?= htmlspecialchars($annonce['titre']) ?>">
                            <?php else: ?>
                                <div class="no-photo">Pas d'image</div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="card-content">
                            <h3 class="card-title"><?= htmlspecialchars($annonce['titre']) ?></h3>
                            <p class="card-price"><?= number_format($annonce['prix'], 2) ?> €</p>
                        </div>
                    </a>

                    <?php if (isset($_SESSION['user']['idu']) && $_SESSION['user']['idu'] == $annonce['user_id']): ?>
                        <div class="card-actions">
                            <a href="index.php?action=modifier_annonce&id=<?= $annonce['id'] ?>" class="action-btn edit" title="Modifier">✏️</a>
                            <a href="controllers/AnnonceController.php?action=supprimer&id=<?= $annonce['id'] ?>" 
                               class="action-btn delete" 
                               onclick="return confirm('Supprimer définitivement ?');" title="Supprimer">🗑️</a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <p>La vitrine est vide pour le moment.</p>
            <a href="index.php?action=creer_annonce" class="btn-secondary">Devenez le premier vendeur !</a>
        </div>
    <?php endif; ?>
</div>

<footer>
    <p>&copy; <?= date('Y') ?> VENDO - Plateforme d'annonces locales</p>
</footer>