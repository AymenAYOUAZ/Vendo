<div class="hero">
    <div class="container">
        <h1>Achetez, vendez, simplement.</h1>
        <p>Des milliers d'annonces entre particuliers à portée de clic.</p>
    </div>
</div>

<hr>

<div class="container">
    <div class="section-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Dernières pépites dénichées</h2>
        <?php if (isset($_SESSION['user'])): ?>
            <a href="index.php?action=creer_annonce" class="btn-primary">+ Publier une annonce</a>
        <?php endif; ?>
    </div>

    <form action="index.php" method="GET" class="filter-form" style="display: flex; gap: 10px; flex-wrap: wrap; background: var(--clr-surface); padding: 15px; border-radius: var(--radius-md); border: 1px solid var(--clr-border); margin-bottom: 30px; align-items: center;">
        <input type="hidden" name="action" value="accueil">
        
        <input type="text" id="ajax-search" name="q" placeholder="Recherche instantanée..." autocomplete="off" value="<?= e($_GET['q'] ?? '') ?>" style="flex: 1; padding: 8px; border-radius: var(--radius-sm); border: 1px solid var(--clr-border);">

        <select name="categorie" style="padding: 8px; border-radius: var(--radius-sm); border: 1px solid var(--clr-border);">
            <option value="">Toutes les catégories</option>
            <option value="Informatique" <?= (isset($_GET['categorie']) && $_GET['categorie'] === 'Informatique') ? 'selected' : '' ?>>Informatique</option>
            <option value="Véhicules" <?= (isset($_GET['categorie']) && $_GET['categorie'] === 'Véhicules') ? 'selected' : '' ?>>Véhicules</option>
            <option value="Autres" <?= (isset($_GET['categorie']) && $_GET['categorie'] === 'Autres') ? 'selected' : '' ?>>Autres</option>
        </select>

        <input type="number" name="prix_max" placeholder="Prix max €" value="<?= e($_GET['prix_max'] ?? '') ?>" style="padding: 8px; border-radius: var(--radius-sm); border: 1px solid var(--clr-border); width: 100px;">

        <button type="submit" class="btn-primary" style="padding: 8px 15px;">Filtrer</button>
        <a href="index.php?action=accueil" class="btn-secondary" style="padding: 8px 15px; text-decoration: none;">Reset</a>
        <a href="index.php?action=top_annonces" class="btn-top" style="padding: 8px 15px; background: #FFD700; color: #000; border-radius: var(--radius-sm); text-decoration: none; font-weight: bold;">🔥 Top Vues</a>
    </form>

    <div id="results-container">
        <?php include __DIR__ . '/partials/liste_annonces.php'; ?>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('ajax-search');
    const resultsContainer = document.getElementById('results-container');

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const query = this.value;
            // On appelle l'URL avec ce qu'on tape
            fetch('index.php?action=recherche_ajax&q=' + encodeURIComponent(query))
                .then(response => response.text())
                .then(html => {
                    // On injecte le nouveau HTML généré par liste_annonces.php
                    resultsContainer.innerHTML = html;
                })
                .catch(error => console.error('Erreur AJAX:', error));
        });
    }
});
</script>