<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vendo - Inscription</title>
  <link rel="stylesheet" href="/Vendo/public/css/style.css">
</head>
<body>

<nav class="navbar">
  <a class="navbar-logo" href="/Vendo/index.php?action=accueil">
    <img src="/Vendo/public/vendo_logo_minimal.svg" alt="Vendo">
  </a>
  <div class="navbar-links">
    <a href="/Vendo/index.php?action=connexion" class="btn-secondary">Se connecter</a>
  </div>
</nav>

<div class="form-card">
  <h2>Créer un compte</h2>

  <form action="/Vendo/controllers/AuthController.php" method="POST">

    <div class="form-group">
      <label for="username">Nom d'utilisateur</label>
      <input type="text" id="username" name="username" placeholder="Ex: jean75" required>
    </div>

    <div class="form-group">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" placeholder="Ex: jean@email.com" required>
    </div>

    <div class="form-group">
      <label for="password">Mot de passe</label>
      <input type="password" id="password" name="password" placeholder="10 caractères minimum" required>
    </div>

    <button type="submit" class="btn-primary">S'inscrire</button>

  </form>

  <div class="form-footer">
    Déjà un compte ? <a href="/Vendo/index.php?action=connexion">Se connecter</a>
  </div>
</div>

</body>
</html>