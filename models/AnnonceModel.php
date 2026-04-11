<?php


function ajouterAnnonce($pdo, $titre, $prix, $description, $photo) {
    $sql = "INSERT INTO annonces (titre, prix, description, photo)
            VALUES (:titre, :prix, :description, :photo)";
    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        ':titre' => $titre,
        ':prix' => $prix,
        ':description' => $description,
        ':photo' => $photo
    ]);
}

function recupererAnnonces($pdo) {
    $sql = "SELECT * FROM annonces ORDER BY id DESC";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function recupererAnnonceParId($pdo, $id) {
    $sql = "SELECT * FROM annonces WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function modifierAnnonce($pdo, $id, $titre, $prix, $description, $photo) {
    $sql = "UPDATE annonces
            SET titre = :titre,
                prix = :prix,
                description = :description,
                photo = :photo
            WHERE id = :id";
    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        ':id' => $id,
        ':titre' => $titre,
        ':prix' => $prix,
        ':description' => $description,
        ':photo' => $photo
    ]);
}

function supprimerAnnonce($pdo, $id) {
    $sql = "DELETE FROM annonces WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([':id' => $id]);
}