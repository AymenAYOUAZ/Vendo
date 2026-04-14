<?php if (!empty($annonces)): ?>
    <div class="annonces-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px;">
        <?php foreach ($annonces as $annonce): ?>
            <div class="annonce-card" style="position: relative; border: 1px solid var(--clr-border); border-radius: 12px; overflow: hidden; background: var(--clr-surface);">
                
                <?php if (isset($_SESSION['user']['idu']) && dejaVu($pdo, $annonce['id'], $_SESSION['user']['idu'])): ?>
                    <span style="position: absolute; top: 10px; left: 10px; background: rgba(0,0,0,0.7); color: white; padding: 4px 10px; border-radius: 4px; font-size: 0.75rem; z-index: 10; font-weight: bold;">
                        ✓ Déjà vu
                    </span>
                <?php endif; ?>

                <a href="index.php?action=detail_annonce&id=<?= $annonce['id'] ?>" style="text-decoration: none; color: inherit;">
                    <div class="card-image" style="height: 200px; overflow: hidden;">
                        <?php if (!empty($annonce['photo'])): ?>
                            <img src="/Vendo/public/uploads/<?= e($annonce['photo']) ?>" style="width: 100%; height: 100%; object-fit: cover;">
                        <?php else: ?>
                            <div style="height: 100%; background: #eee; display: flex; align-items: center; justify-content: center;">Pas d'image</div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="card-content" style="padding: 15px;">
                        <h3 style="margin: 0; font-size: 1.1rem;"><?= e($annonce['titre']) ?></h3>
                        <p style="font-weight: bold; color: var(--clr-primary); margin: 10px 0;"><?= number_format($annonce['prix'], 2) ?> €</p>
                        <div style="font-size: 0.8rem; color: gray;">👁️ <?= compterVues($pdo, $annonce['id']) ?> vues</div>
                    </div>
                </a>

                <div class="card-actions" style="display: flex; justify-content: space-between; align-items: center; padding: 10px 15px; border-top: 1px solid var(--clr-border);">
                    <div>
                        <?php if (isset($_SESSION['user']['idu'])): ?>
                            <?php $dejaFavori = estFavori($pdo, $_SESSION['user']['idu'], $annonce['id']); ?>
                            <a href="index.php?action=toggle_favori&id=<?= $annonce['id'] ?>" style="text-decoration: none; font-size: 1.2rem;">
                                <?= $dejaFavori ? '❤️' : '🤍' ?>
                            </a>
                        <?php endif; ?>
                    </div>

                    <?php if (isset($_SESSION['user']['idu']) && $_SESSION['user']['idu'] == $annonce['user_id']): ?>
                        <div style="display: flex; gap: 10px;">
                            <a href="index.php?action=modifier_annonce&id=<?= $annonce['id'] ?>" style="text-decoration: none;">✏️</a>
                            <a href="controllers/AnnonceController.php?action=supprimer&id=<?= $annonce['id'] ?>" onclick="return confirm('Supprimer ?');" style="text-decoration: none;">🗑️</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div> 
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div class="empty-state" style="text-align: center; padding: 50px;">
        <p>Aucune annonce ne correspond à votre recherche.</p>
    </div>
<?php endif; ?>