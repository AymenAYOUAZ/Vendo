<?php
/**
 * Enregistre un nouveau message dans la BDD
 */
function ajouterMessage($pdo, $id_expediteur, $id_destinataire, $id_annonce, $contenu) {
    $sql = "INSERT INTO messages (id_expediteur, id_destinataire, id_annonce, contenu, date_envoi) 
            VALUES (:exp, :dest, :ann, :txt, NOW())";
    
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        ':exp'  => (int)$id_expediteur,
        ':dest' => (int)$id_destinataire,
        ':ann'  => (int)$id_annonce,
        ':txt'  => trim($contenu)
    ]);
}

/**
 * Récupère la liste des conversations pour la boîte de réception
 */
function recupererBoiteDeReception($pdo, $mon_id) {
    $sql = "
        SELECT 
            m.id_annonce, 
            a.titre AS annonce_titre,
            IF(m.id_expediteur = :mon_id, m.id_destinataire, m.id_expediteur) AS id_interlocuteur,
            u.pseudo AS interlocuteur_pseudo,
            MAX(m.date_envoi) AS date_dernier_message,
            -- NOUVEAU : On compte les messages non lus SPECIFIQUES à cette discussion
            SUM(CASE WHEN m.id_destinataire = :mon_id AND m.est_lu = 0 THEN 1 ELSE 0 END) AS nb_unread
        FROM messages m
        JOIN annonces a ON m.id_annonce = a.id
        JOIN utilisateurs u ON u.idu = IF(m.id_expediteur = :mon_id, m.id_destinataire, m.id_expediteur)
        WHERE m.id_expediteur = :mon_id OR m.id_destinataire = :mon_id
        GROUP BY m.id_annonce, id_interlocuteur, u.pseudo, a.titre
        ORDER BY date_dernier_message DESC
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':mon_id' => $mon_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
/**
 * Récupère tous les messages d'une discussion précise
 */
function recupererConversation($pdo, $mon_id, $id_interlocuteur, $id_annonce) {
    $sql = "
        SELECT m.*, u.pseudo AS expediteur_pseudo
        FROM messages m
        LEFT JOIN utilisateurs u ON m.id_expediteur = u.idu
        WHERE m.id_annonce = :id_annonce
        AND (
            (m.id_expediteur = :mon_id AND m.id_destinataire = :autre_id)
            OR
            (m.id_expediteur = :autre_id AND m.id_destinataire = :mon_id)
        )
        ORDER BY m.date_envoi ASC
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':mon_id'    => $mon_id,
        ':autre_id'  => $id_interlocuteur,
        ':id_annonce' => $id_annonce
    ]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Compte le nombre total de messages non lus pour un utilisateur
 */
function compterMessagesNonLus($pdo, $id_utilisateur) {
    // Vérification de sécurité : si l'ID est vide, on retourne 0
    if (!$id_utilisateur) return 0;

    $sql = "SELECT COUNT(*) FROM messages WHERE id_destinataire = :id AND est_lu = 0";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => (int)$id_utilisateur]);
    return (int)$stmt->fetchColumn();
}

/**
 * Marque tous les messages d'une discussion spécifique comme "lus"
 */
function marquerCommeLus($pdo, $mon_id, $id_interlocuteur, $id_annonce) {
    $sql = "UPDATE messages 
            SET est_lu = 1 
            WHERE id_destinataire = :moi 
            AND id_expediteur = :lui 
            AND id_annonce = :ann";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        ':moi' => (int)$mon_id,
        ':lui' => (int)$id_interlocuteur,
        ':ann' => (int)$id_annonce
    ]);
}