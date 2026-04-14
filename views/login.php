<div class="container-center">
    <div class="form-card">
        <div class="form-header">
            <h2>Se connecter</h2>
            <p>Heureux de vous revoir sur Vendo !</p>
        </div>

        <form action="/Vendo/controllers/LoginController.php" method="POST">

            <div class="form-group">
                <label for="email">Adresse Email</label>
                <input type="email" id="email" name="email" placeholder="jean@email.com" required>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" placeholder="Votre mot de passe" required>
            </div>

            <button type="submit" class="btn-primary" style="width: 100%;">Se connecter</button>

        </form>

        <div class="form-footer">
            Pas encore de compte ? <a href="/Vendo/index.php?action=inscription">S'inscrire</a>
        </div>
    </div>
</div>