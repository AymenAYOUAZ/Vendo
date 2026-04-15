<?php
// Note : Pas de require_once db.php ici, c'est index.php qui s'en occupe.

function ajouterAnnonce($pdo, $titre, $prix, $description, $photo, $user_id, $categorie) {
    $sql = "INSERT INTO annonces (titre, prix, description, photo, user_id, categorie)
            VALUES (:titre, :prix, :description, :photo, :user_id, :categorie)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        ':titre' => $titre, ':prix' => $prix, ':description' => $description,
        ':photo' => $photo, ':user_id' => $user_id, ':categorie' => $categorie
    ]);
}

function recupererAnnonceParId($pdo, $id) {
    $stmt = $pdo->prepare("SELECT * FROM annonces WHERE id = :id");
    $stmt->execute([':id' => (int)$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function recupererAnnoncesFiltrees($pdo, $recherche = '', $categorie = '', $prix_min = null, $prix_max = null) {
    $sql = "SELECT * FROM annonces WHERE 1=1";
    $params = [];
    if (!empty($recherche)) { $sql .= " AND (titre LIKE ? OR description LIKE ?)"; $params[] = "%$recherche%"; $params[] = "%$recherche%"; }
    if (!empty($categorie)) { $sql .= " AND categorie = ?"; $params[] = $categorie; }
    if ($prix_min !== null && $prix_min !== '') { $sql .= " AND prix >= ?"; $params[] = (float)$prix_min; }
    if ($prix_max !== null && $prix_max !== '') { $sql .= " AND prix <= ?"; $params[] = (float)$prix_max; }
    $sql .= " ORDER BY id DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function modifierAnnonce($pdo, $id, $titre, $prix, $description, $photo, $categorie) {
    $sql = "UPDATE annonces SET titre = :titre, prix = :prix, description = :description, photo = :photo, categorie = :categorie WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([':titre'=>$titre, ':prix'=>$prix, ':description'=>$description, ':photo'=>$photo, ':categorie'=>$categorie, ':id'=>$id]);
}

function supprimerAnnonce($pdo, $id) {
    $stmt = $pdo->prepare("DELETE FROM annonces WHERE id = ?");
    return $stmt->execute([$id]);
}

function toggleFavori($pdo, $idu, $id_annonce) {
    $stmt = $pdo->prepare("SELECT 1 FROM favoris WHERE idu = ? AND id_annonce = ?");
    $stmt->execute([$idu, $id_annonce]);
    if ($stmt->fetch()) {
        $pdo->prepare("DELETE FROM favoris WHERE idu = ? AND id_annonce = ?")->execute([$idu, $id_annonce]);
        return "retiré";
    }
    $pdo->prepare("INSERT INTO favoris (idu, id_annonce) VALUES (?, ?)")->execute([$idu, $id_annonce]);
    return "ajouté";
}

function recupererMesFavoris($pdo, $idu) {
    $stmt = $pdo->prepare("SELECT a.* FROM annonces a JOIN favoris f ON a.id = f.id_annonce WHERE f.idu = ? ORDER BY a.id DESC");
    $stmt->execute([$idu]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function estFavori($pdo, $idu, $id_annonce) {
    $stmt = $pdo->prepare("SELECT 1 FROM favoris WHERE idu = ? AND id_annonce = ?");
    $stmt->execute([$idu, $id_annonce]);
    return (bool) $stmt->fetch();
}

/**
 * Enregistre qu'un utilisateur a vu une annonce
 */
function enregistrerVue($pdo, $id_annonce, $id_utilisateur) {
    $sql = "INSERT IGNORE INTO vues_annonces (id_annonce, id_utilisateur) VALUES (?, ?)";
    $pdo->prepare($sql)->execute([(int)$id_annonce, (int)$id_utilisateur]);
}

/**
 * Compte le nombre de vues totales pour une annonce
 */
function compterVues($pdo, $id_annonce) {
    $sql = "SELECT COUNT(*) FROM vues_annonces WHERE id_annonce = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([(int)$id_annonce]);
    return (int)$stmt->fetchColumn();
}

/**
 * Vérifie si l'utilisateur a déjà vu cette annonce
 */
function dejaVu($pdo, $id_annonce, $id_utilisateur) {
    $sql = "SELECT 1 FROM vues_annonces WHERE id_annonce = ? AND id_utilisateur = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([(int)$id_annonce, (int)$id_utilisateur]);
    return (bool)$stmt->fetch();
}

/**
 * Récupère les 5 annonces les plus consultées
 */
function recupererAnnoncesPopulaires($pdo) {
    $sql = "SELECT a.*, COUNT(v.id) as nb_vues 
            FROM annonces a 
            LEFT JOIN vues_annonces v ON a.id = v.id_annonce 
            GROUP BY a.id 
            ORDER BY nb_vues DESC 
            LIMIT 8";
    return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

function recupererAnnoncesParUtilisateur($pdo, $id_utilisateur) {
    // J'ai remplacé "date_creation" par "id"
    $sql = "SELECT * FROM annonces WHERE user_id = ? ORDER BY id DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([(int)$id_utilisateur]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}