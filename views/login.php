<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vendo - Connexion</title>
  <link rel="stylesheet" href="/Vendo/public/css/style.css">
</head>
<body>

<nav class="navbar">
  <a class="navbar-logo" href="/Vendo/index.php?action=accueil">
    <img src="/Vendo/public/vendo_logo_minimal.svg" alt="Vendo">
  </a>
  <div class="navbar-links">
    <a href="/Vendo/index.php?action=inscription" class="btn-secondary">S'inscrire</a>
  </div>
</nav>

<div class="form-card">
  <h2>Se connecter</h2>

  <form action="/Vendo/controllers/LoginController.php" method="POST">

    <div class="form-group">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" placeholder="Ex: jean@email.com" required>
    </div>

    <div class="form-group">
      <label for="password">Mot de passe</label>
      <input type="password" id="password" name="password" placeholder="Votre mot de passe" required>
    </div>

    <button type="submit" class="btn-primary">Se connecter</button>

  </form>

  <div class="form-footer">
    Pas encore de compte ? <a href="/Vendo/index.php?action=inscription">S'inscrire</a>
  </div>
</div>

</body>
</html>