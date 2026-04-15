<div class="container">
    <div class="form-card">
        <div class="form-header">
            <h2>Vendre un article</h2>
            <p>Remplissez les détails ci-dessous pour publier votre annonce.</p>
        </div>

        <form action="/Vendo/controllers/AnnonceController.php" method="POST" enctype="multipart/form-data">
            
            <input type="hidden" name="action" value="creer">

            <div class="form-group">
                <label for="titre">Titre de l'annonce</label>
                <input type="text" id="titre" name="titre" placeholder="Ex: iPhone 15 Pro Max" required>
            </div>

            <div class="form-group">
                <label for="prix">Prix de vente (€)</label>
                <input type="number" id="prix" name="prix" step="0.01" placeholder="Ex: 850" required>
            </div>

            <div class="form-group" style="margin-bottom: 15px;">
                 <label for="categorie" style="display: block; margin-bottom: 5px;">Catégorie</label>
                 <select name="categorie" id="categorie" required style="width: 100%; padding: 8px; border-radius: var(--radius-sm); border: 1px solid var(--clr-border);">
                 <option value="Autres">Sélectionnez une catégorie</option>
                 <option value="Maison & Jardin">Maison & Jardin</option>
                 <option value="Mode">Mode</option>
                 <option value="Electronique">Electronique</option>
                 <option value="Téléphonie">Téléphonie</option>
                 <option value="Véhicules">Véhicules</option>
                 <option value="Motos">Motos</option>
                 <option value="Autres">Autres</option>
                 </select>
              </div>

            <div class="form-group">
                <label for="description">Description détaillée</label>
                <textarea id="description" name="description" rows="6" placeholder="État, couleur, accessoires inclus..." required></textarea>
            </div>

            <div class="form-group">
                <label for="photo">Photo de l'article</label>
                <div class="file-input-wrapper">
                    <input type="file" id="photo" name="photo" accept="image/*" required>
                    <small style="display:block; margin-top:5px; color:#777;">Formats acceptés : JPG, PNG (Max 2Mo)</small>
                </div>
            </div>

            <div class="form-actions" style="margin-top: 30px;">
                <button type="submit" name="submit_annonce" class="btn-primary" style="width: 100%;">
                    🚀 Publier l'annonce
                </button>
                <a href="/Vendo/index.php?action=accueil" class="btn-secondary" style="display: block; text-align: center; margin-top: 15px;">
                    Annuler
                </a>
            </div>

        </form>
    </div>
</div>