<?php
function envoyerMessage($pdo, $exp, $dest, $annonce, $texte) {
    $sql = "INSERT INTO messages (id_expediteur, id_destinataire, id_annonce, contenu) VALUES (?, ?, ?, ?)";
    return $pdo->prepare($sql)->execute([$exp, $dest, $annonce, $texte]);
}

function recupererToutesMesDiscussions($pdo, $userId) {
    // On récupère tout : expéditeur, destinataire et titre de l'annonce
    $sql = "SELECT m.*, 
            exp.pseudo as expediteur_nom, 
            dest.pseudo as destinataire_nom,
            a.titre as titre_annonce 
            FROM messages m
            JOIN utilisateurs exp ON m.id_expediteur = exp.idu
            JOIN utilisateurs dest ON m.id_destinataire = dest.idu
            JOIN annonces a ON m.id_annonce = a.id
            WHERE m.id_destinataire = ? OR m.id_expediteur = ?
            ORDER BY m.id_annonce, m.date_envoi ASC"; // Groupé par annonce, du plus vieux au plus récent
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$userId, $userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}