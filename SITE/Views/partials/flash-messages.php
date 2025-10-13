<?php
/**
 * Fichier : flash-messages.php
 * Système de messages flash
 *
 * Affiche les messages flash stockés en session avec:
 * - Récupération des messages depuis $_SESSION['flash']
 * - Affichage par type (success, error, warning, info)
 * - Icônes appropriées pour chaque type
 * - Bouton de fermeture
 * - Nettoyage automatique de la session après affichage
 *
 * @package DashMed
 * @version 2.0
 */

use Core\View;

// Récupère les messages flash
$flashMessages = $_SESSION['flash'] ?? [];

// Si aucun message, on ne génère pas de HTML
if (empty($flashMessages)) {
    return;
}

// Icônes par type de message
$icons = [
    'success' => '✓',
    'error' => '✕',
    'warning' => '⚠',
    'info' => 'ℹ'
];

// Titres par type de message
$titles = [
    'success' => 'Succès',
    'error' => 'Erreur',
    'warning' => 'Attention',
    'info' => 'Information'
];
?>

<div class="flash-messages-container">
    <?php foreach ($flashMessages as $type => $message): ?>
        <?php if (!empty($message)): ?>
            <div class="flash-message flash-<?= View::e($type) ?>" role="alert">
                <div class="flash-content">
                    <span class="flash-icon"><?= $icons[$type] ?? 'ℹ' ?></span>
                    <div class="flash-text">
                        <strong class="flash-title"><?= $titles[$type] ?? 'Message' ?></strong>
                        <p class="flash-body"><?= View::e($message) ?></p>
                    </div>
                </div>
                <button class="flash-close" aria-label="Fermer">×</button>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>

<script>
// Script pour fermer les messages flash
document.addEventListener('DOMContentLoaded', function() {
    const closeButtons = document.querySelectorAll('.flash-close');
    
    closeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const message = this.closest('.flash-message');
            message.style.opacity = '0';
            message.style.transform = 'translateX(100%)';
            
            setTimeout(() => {
                message.remove();
            }, 300);
        });
    });
    
    // Auto-fermeture après 5 secondes
    const messages = document.querySelectorAll('.flash-message');
    messages.forEach(message => {
        setTimeout(() => {
            const closeBtn = message.querySelector('.flash-close');
            if (closeBtn) {
                closeBtn.click();
            }
        }, 5000);
    });
});
</script>

<?php
// Nettoyage de la session après affichage
unset($_SESSION['flash']);
?>
