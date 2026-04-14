<div class="container" style="max-width: 600px; margin: 0 auto; padding: 20px;">
    <h2>Modifier mes informations</h2>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="flash-message error" style="color: red; margin-bottom: 15px;"><?= e($_SESSION['error']); unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <form action="index.php?action=modifier_profil" method="POST" class="form-container">
        
        <div class="form-group" style="margin-bottom: 15px;">
            <label for="pseudo" style="display: block; font-weight: bold; margin-bottom: 5px;">Pseudo</label>
            <input type="text" id="pseudo" name="pseudo" value="<?= e($_SESSION['user']['pseudo']) ?>" required style="width: 100%; padding: 8px;">
        </div>

        <div class="form-group" style="margin-bottom: 30px;">
            <label for="email" style="display: block; font-weight: bold; margin-bottom: 5px;">Adresse Email</label>
            <input type="email" id="email" name="email" value="<?= e($_SESSION['user']['email']) ?>" required style="width: 100%; padding: 8px;">
        </div>

        <hr style="margin-bottom: 20px;">
        <h4 style="margin-bottom: 15px;">Changer de mot de passe (Optionnel)</h4>

        <div class="form-group" style="margin-bottom: 15px;">
            <label for="ancien_mdp" style="display: block; font-weight: bold; margin-bottom: 5px;">Mot de passe actuel</label>
            <input type="password" id="ancien_mdp" name="ancien_mdp" placeholder="Ton mot de passe actuel" style="width: 100%; padding: 8px;">
        </div>

        <div class="form-group" style="margin-bottom: 15px;">
            <label for="nouveau_mdp" style="display: block; font-weight: bold; margin-bottom: 5px;">Nouveau mot de passe (10 min)</label>
            <input type="password" id="nouveau_mdp" name="nouveau_mdp" placeholder="Minimum 10 caractères" style="width: 100%; padding: 8px;">
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label for="confirm_mdp" style="display: block; font-weight: bold; margin-bottom: 5px;">Confirmer le nouveau mot de passe</label>
            <input type="password" id="confirm_mdp" name="confirm_mdp" placeholder="Retape le nouveau mot de passe" style="width: 100%; padding: 8px;">
        </div>

        <div class="form-actions" style="margin-top: 20px; display: flex; gap: 10px;">
            <button type="submit" class="btn-primary" style="padding: 10px 20px;">Enregistrer les modifications</button>
            <a href="index.php?action=profil" class="btn-secondary" style="padding: 10px 20px; text-decoration: none;">Annuler</a>
        </div>
    </form>
</div>