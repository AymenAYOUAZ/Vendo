<div class="container-center">
    <div class="form-card">
        <div class="form-header">
            <h2>Créer un compte</h2>
            <p>Rejoignez la communauté Vendo pour vendre et acheter.</p>
        </div>

        <form action="/Vendo/controllers/AuthController.php" method="POST">

            <div class="form-group">
                <label for="username">Nom d'utilisateur</label>
                <input type="text" id="username" name="username" placeholder="Ex: jean75" required>
            </div>

            <div class="form-group">
                <label for="email">Adresse Email</label>
                <input type="email" id="email" name="email" placeholder="jean@email.com" required>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" placeholder="10 caractères minimum" required>
            </div>

            <button type="submit" class="btn-primary" style="width: 100%;">S'inscrire</button>

        </form>

        <div class="form-footer">
            Déjà un compte ? <a href="/Vendo/index.php?action=connexion">Se connecter</a>
        </div>
    </div>
</div>