<div class="container">
    <div class="chat-container">
        <h2>💬 Mes Conversations</h2>

        <?php if (empty($messages)): ?>
            <div class="empty-state">
                <p>Aucun message pour le moment.</p>
            </div>
        <?php else: ?>
            
            <?php 
            $current_annonce = null;
            foreach ($messages as $m): 
                // En-tête de discussion par annonce
                if ($current_annonce !== $m['id_annonce']): 
                    $current_annonce = $m['id_annonce'];
            ?>
                <div class="discussion-header">
                    Annonce : <strong><?= htmlspecialchars($m['titre_annonce']) ?></strong>
                </div>
            <?php endif; ?>

            <?php $c_est_moi = ($m['id_expediteur'] == $_SESSION['user']['idu']); ?>
                
            <div class="msg-wrapper <?= $c_est_moi ? 'me' : 'them' ?>">
                <div class="msg-info">
                    <?= $c_est_moi ? 'Moi' : htmlspecialchars($m['expediteur_nom']) ?> • <?= date('H:i', strtotime($m['date_envoi'])) ?>
                </div>
                <div class="message-bubble">
                    <?= nl2br(htmlspecialchars($m['contenu'])) ?>
                </div>
            </div>

            <?php endforeach; ?>

            <div class="reply-box">
                <h4>Répondre à cette discussion</h4>
                <form action="controllers/MessageController.php" method="POST">
                    
                    <input type="hidden" name="provenance" value="messagerie">

                    <?php 
                    $dernier = end($messages); 
                    $dest_id = ($dernier['id_expediteur'] == $_SESSION['user']['idu']) ? $dernier['id_destinataire'] : $dernier['id_expediteur'];
                    ?>
                    
                    <input type="hidden" name="id_destinataire" value="<?= $dest_id ?>">
                    <input type="hidden" name="id_annonce" value="<?= $dernier['id_annonce'] ?>">
                    
                    <div class="form-group">
                        <textarea name="message" rows="3" placeholder="Écrivez votre réponse ici..." required></textarea>
                    </div>
                    <button type="submit" name="envoyer_message" class="btn-primary">Envoyer la réponse</button>
                </form>
            </div>

        <?php endif; ?>
    </div>
</div>