<div class="container">
    <div class="form-card">
        <h2>Modifier l'annonce</h2>

        <form action="/Vendo/controllers/AnnonceController.php" method="POST" enctype="multipart/form-data">
            
            <input type="hidden" name="action" value="modifier">
            <input type="hidden" name="id_annonce" value="<?= htmlspecialchars($annonce['id']) ?>">

            <div class="form-group">
                <label for="titre">Nom de l'annonce</label>
                <input type="text" id="titre" name="titre" value="<?= htmlspecialchars($annonce['titre']) ?>" placeholder="Ex: iPhone 15 Pro" required>
            </div>

            <div class="form-group">
                <label for="prix">Prix (€)</label>
                <input type="number" id="prix" name="prix" step="0.01" value="<?= htmlspecialchars($annonce['prix']) ?>" placeholder="0.00" required>
            </div>

            <div class="form-group" style="margin-bottom: 15px;">
                       <label for="categorie" style="display: block; margin-bottom: 5px;">Catégorie</label>
                       <select name="categorie" id="categorie" required style="width: 100%; padding: 8px; border-radius: var(--radius-sm); border: 1px solid var(--clr-border);">
                 <option value="Informatique" <?= (isset($annonce['categorie']) && $annonce['categorie'] === 'Informatique') ? 'selected' : '' ?>>Informatique</option>
                 <option value="Véhicules" <?= (isset($annonce['categorie']) && $annonce['categorie'] === 'Véhicules') ? 'selected' : '' ?>>Véhicules</option>
                 <option value="Autres" <?= (isset($annonce['categorie']) && $annonce['categorie'] === 'Autres') ? 'selected' : '' ?>>Autres</option>
             </select>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="5" placeholder="Décrivez votre article..." required><?= htmlspecialchars($annonce['description']) ?></textarea>
            </div>

            <div class="form-group">
                <label>Photo actuelle</label>
                <div class="current-photo-container">
                    <?php if (!empty($annonce['photo'])): ?>
                        <img src="/Vendo/public/uploads/<?= htmlspecialchars($annonce['photo']) ?>" class="img-preview" alt="photo actuelle">
                    <?php else: ?>
                        <p class="no-photo">Aucune photo enregistrée</p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="form-group">
                <label for="photo">Nouvelle photo (optionnel)</label>
                <input type="file" id="photo" name="photo" accept="image/*">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">Enregistrer les modifications</button>
                <a href="/Vendo/index.php?action=accueil" class="btn-secondary">Annuler</a>
            </div>

        </form>
    </div>
</div>