<div class="container">
    <?php if ($annonce): ?>
        <div class="detail-card">
            
            <div class="detail-image-side">
                <?php if (!empty($annonce['photo'])): ?>
                    <img class="detail-img-large" src="/Vendo/public/uploads/<?= htmlspecialchars($annonce['photo']) ?>" alt="photo annonce">
                <?php else: ?>
                    <div class="no-photo-placeholder">Pas de photo disponible</div>
                <?php endif; ?>
            </div>

            <div class="detail-info-side">
                <div class="detail-header">
                    <h1><?= htmlspecialchars($annonce['titre']) ?></h1>
                    <div class="detail-price-tag"><?= number_format($annonce['prix'], 2) ?> €</div>
                </div>

                <div class="detail-body">
                    <h3>Description</h3>
                    <p><?= nl2br(htmlspecialchars($annonce['description'])) ?></p>
                </div>

                <?php if (isset($_SESSION['user']['idu'])): ?>
                    <?php if ($_SESSION['user']['idu'] != $annonce['user_id']): ?>
                        <div class="contact-box">
                            <h3>Contacter le vendeur</h3>
                            <form action="controllers/MessageController.php" method="POST">
                                <input type="hidden" name="provenance" value="annonce">
                                <input type="hidden" name="id_destinataire" value="<?= $annonce['user_id'] ?>">
                                <input type="hidden" name="id_annonce" value="<?= $annonce['id'] ?>">
                                
                                <div class="form-group">
                                    <textarea name="message" rows="4" placeholder="Bonjour, votre article m'intéresse..." required></textarea>
                                </div>
                                <button type="submit" name="envoyer_message" class="btn-primary" style="width: 100%;">
                                    Envoyer le message
                                </button>
                            </form>
                        </div>
                    <?php else: ?>
                        <div class="owner-notice">
                            Vous êtes l'auteur de cette annonce.
                            <a href="index.php?action=modifier_annonce&id=<?= $annonce['id'] ?>" class="btn-secondary" style="margin-top: 10px; display: block; text-align: center;">Modifier l'annonce</a>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="login-notice">
                        <p>Vous devez être connecté pour contacter le vendeur.</p>
                        <a href="index.php?action=connexion" class="btn-secondary">Se connecter</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <h2>Oups !</h2>
            <p>Cette annonce semble avoir disparu.</p>
            <a href="index.php?action=accueil" class="btn-primary">Retour à l'accueil</a>
        </div>
    <?php endif; ?>
</div>