<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>VENDO - Créer une annonce</title>
    <link rel="stylesheet" href="../public/css/style.css"> </head>
<body>

    <section class="container">
        <h2>Déposer une annonce</h2>

        <form action="../controllers/AnnonceController.php" method="POST" enctype="multipart/form-data">
            
            <div class="form-group">
                <label for="titre">Nom de l'annonce :</label>
                <input type="text" id="titre" name="titre" placeholder="Ex: iPhone 15 Pro" required>
            </div>

            <div class="form-group">
                <label for="prix">Prix (€) :</label>
                <input type="number" id="prix" name="prix" step="0.01" placeholder="Ex: 500" required>
            </div>

            <div class="form-group">
                <label for="description">Description :</label>
                <textarea id="description" name="description" rows="5" placeholder="Décrivez votre objet..." required></textarea>
            </div>

            <div class="form-group">
                <label for="photo">Photo de l'article :</label>
                <input type="file" id="photo" name="photo" accept="image/*" required>
            </div>

            <button type="submit" name="submit_annonce">Publier l'annonce</button>
        
        </form>
    </section>

</body>
</html>