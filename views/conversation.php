<?php 
if (!isset($annonce) || !$annonce) {
    echo "<div class='container'><p>Erreur : Annonce introuvable.</p></div>";
    return;
}
?>
<div class="container" style="max-width: 800px; margin: 20px auto;">
    <div style="margin-bottom: 20px;">
        <a href="index.php?action=messagerie" class="btn-secondary">⬅ Retour</a>
    </div>

    <div class="chat-header" style="background: var(--clr-surface); padding: 15px; border-radius: 8px; border: 1px solid var(--clr-border); margin-bottom: 20px; color: var(--clr-text) !important;">
        <h3 style="margin: 0; color: inherit;">Discussion : <?= e($annonce['titre']) ?></h3>
    </div>

    <div class="chat-box" style="background: #ffffff; padding: 20px; border-radius: 8px; border: 1px solid var(--clr-border); height: 400px; overflow-y: auto; display: flex; flex-direction: column; gap: 10px; margin-bottom: 20px;">
        <?php if (empty($messages)): ?>
            <p style="text-align: center; color: #888; margin-top: 150px;">Aucun message. Envoyez le premier !</p>
        <?php else: ?>
            <?php foreach ($messages as $msg): ?>
                <?php 
                    $mon_id = (int)($_SESSION['user']['idu'] ?? 0);
                    $isMe = ((int)$msg['id_expediteur'] === $mon_id); 
                ?>
                
                <div style="align-self: <?= $isMe ? 'flex-end' : 'flex-start' ?>; 
                            max-width: 75%; 
                            background: <?= $isMe ? '#007bff' : '#e9ecef' ?>; 
                            padding: 12px 16px; 
                            border-radius: 15px; 
                            box-shadow: 0 1px 2px rgba(0,0,0,0.1);
                            margin-bottom: 5px;">
                    
                    <div style="font-size: 0.75rem; margin-bottom: 4px; font-weight: bold; color: <?= $isMe ? 'rgba(255,255,255,0.9)' : '#666' ?> !important;">
                        <?= $isMe ? 'Moi' : e($msg['expediteur_pseudo'] ?? 'Interlocuteur') ?> 
                        • <?= date('H:i', strtotime($msg['date_envoi'])) ?>
                    </div>
                    
                    <div style="word-wrap: break-word; line-height: 1.4; font-size: 1rem; color: <?= $isMe ? '#ffffff' : '#000000' ?> !important;">
                        <?= nl2br(e($msg['contenu'])) ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <form action="index.php?action=envoyer_message" method="POST" style="display: flex; gap: 10px; background: #f8f9fa; padding: 15px; border-radius: 8px;">
        <input type="hidden" name="id_annonce" value="<?= (int)$annonce['id'] ?>">
        <input type="hidden" name="id_destinataire" value="<?= (int)$id_interlocuteur ?>">
        
        <textarea name="contenu" required placeholder="Votre message..." style="flex: 1; padding: 12px; border-radius: 8px; border: 1px solid #ccc; resize: none; height: 50px; color: #000; background: #fff;"></textarea>
        <button type="submit" class="btn-primary" style="padding: 0 25px;">Envoyer</button>
    </form>
</div>

<script>
    const chat = document.querySelector('.chat-box');
    chat.scrollTop = chat.scrollHeight;
</script>