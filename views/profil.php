<div class="container">
    
    <?php if (isset($_SESSION['success'])): ?>
        <div class="flash-message success"><?= e($_SESSION['success']); unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <div class="profile-header">
        <h2>Mon Profil</h2>
        <div class="profile-info">
            <p><strong>Pseudo :</strong> <?= e($_SESSION['user']['pseudo']) ?></p>
            <p><strong>Email :</strong> <?= e($_SESSION['user']['email']) ?></p>
            <a href="index.php?action=modifier_profil" class="btn-primary">✏️ Modifier mon profil</a>
        </div>
    </div>

    <hr>

    <div class="my-ads-section">
        <h3>Mes Annonces en ligne (<?= count($mes_annonces) ?>)</h3>
        
        <?php if (!empty($mes_annonces)): ?>
            <div class="annonces-grid">
                <?php foreach ($mes_annonces as $annonce): ?>
                    <div class="annonce-card">
                        
                        <div class="card-image">
                            <?php if (!empty($annonce['photo'])): ?>
                                <img src="public/uploads/<?= e($annonce['photo']) ?>" alt="<?= e($annonce['titre']) ?>">
                            <?php else: ?>
                                <div class="placeholder-img">Pas d'image</div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="card-content">
                            <h3><?= e($annonce['titre']) ?></h3>
                            <p class="price"><?= number_format($annonce['prix'], 2) ?> €</p>
                        </div>

                        <div class="card-actions admin-btns">
                            <a href="index.php?action=modifier_annonce&id=<?= $annonce['id'] ?>" title="Modifier">✏️ Editer</a>
                            <a href="controllers/AnnonceController.php?action=supprimer&id=<?= $annonce['id'] ?>" onclick="return confirm('Supprimer définitivement ?');" title="Supprimer">🗑️ Supprimer</a>
                        </div>
                    </div> 
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <p>Tu n'as publié aucune annonce pour le moment.</p>
                <a href="index.php?action=creer_annonce" class="btn-primary">Publier ma première annonce</a>
            </div>
        <?php endif; ?>
    </div>

</div>