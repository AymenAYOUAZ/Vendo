<div class="container" style="max-width: 800px; margin: 0 auto; padding: 20px;">
    <h2 style="margin-bottom: 20px;">Ma boîte de réception</h2>
    
    <?php if (empty($discussions)): ?>
        <div style="text-align: center; padding: 50px; background: var(--clr-surface); border-radius: 8px;">
            Vous n'avez aucun message pour le moment.
        </div>
    <?php else: ?>
        <div class="inbox-list" style="display: flex; flex-direction: column; gap: 10px;">
            
            <?php foreach ($discussions as $disc): ?>
                <?php $hasUnread = ($disc['nb_unread'] > 0); ?>
    
                <a href="index.php?action=conversation&id_annonce=<?= $disc['id_annonce'] ?>&id_interlocuteur=<?= $disc['id_interlocuteur'] ?>" 
                   class="discussion-card" 
                   style="display: block; padding: 20px; border: 1px solid var(--clr-border); border-radius: 8px; text-decoration: none; color: inherit; background: <?= $hasUnread ? '#f0f7ff' : 'var(--clr-surface)' ?>; transition: transform 0.2s, box-shadow 0.2s; position: relative;">
                    
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                        <strong style="font-size: 1.1rem; color: <?= $hasUnread ? 'var(--clr-primary)' : 'inherit' ?>;">
                            👤 <?= e($disc['interlocuteur_pseudo']) ?>
                            <?php if ($hasUnread): ?>
                                <span style="display: inline-block; width: 10px; height: 10px; background: #007bff; border-radius: 50%; margin-left: 5px;" title="Nouveau message"></span>
                            <?php endif; ?>
                        </strong>
                        <span style="font-size: 0.85rem; color: gray;">
                            <?= date('d/m H:i', strtotime($disc['date_dernier_message'])) ?>
                        </span>
                    </div>
                    
                    <div style="font-weight: <?= $hasUnread ? 'bold' : 'normal' ?>; margin-bottom: 5px;">
                        <span style="color: gray;">Annonce :</span> <?= e($disc['annonce_titre']) ?>
                    </div>
                    
                    <?php if ($hasUnread): ?>
                        <div style="color: #007bff; font-size: 0.9rem; font-weight: bold;">
                            📩 <?= $disc['nb_unread'] ?> nouveau(x) message(s)
                        </div>
                    <?php endif; ?>
                </a>
            <?php endforeach; ?>

        </div>
    <?php endif; ?>
</div>