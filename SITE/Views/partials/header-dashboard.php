<?php
/**
 * Fichier : header-dashboard.php
 * Header pour utilisateurs connectés
 *
 * Header optimisé pour l'espace utilisateur avec:
 * - Logo et nom de marque
 * - Navigation Dashboard/Profil/Déconnexion
 * - Highlight de la page courante
 * - Menu burger responsive
 *
 * @package DashMed
 * @version 2.0
 */

use Core\View;

// Détecte la page courante
$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Récupère l'utilisateur depuis la session
$user = $_SESSION['user'] ?? null;
?>
<header class="topbar">
    <div class="container">
        <!-- Logo et nom de la marque -->
        <div class="brand">
            <img class="logo" src="/assets/images/logo.png" alt="Logo DashMed">
            <span class="brand-name">DashMed</span>
        </div>

        <!-- Navigation dashboard -->
        <nav class="mainnav" aria-label="Navigation principale">
            <a href="/dashboard"<?= ($currentPath === '/dashboard' ? ' class="current"' : '') ?>>Dashboard</a>
            <a href="/profile"<?= ($currentPath === '/profile' ? ' class="current"' : '') ?>>Profil</a>
        </nav>

        <!-- Informations utilisateur et déconnexion -->
        <div class="user-menu">
            <?php if ($user): ?>
                <span class="user-name"><?= View::e($user['name'] ?? 'Utilisateur') ?></span>
            <?php endif; ?>
            <a href="/logout" class="login-btn">Déconnexion</a>
        </div>

        <!-- Menu burger pour responsive -->
        <button class="burger-menu" aria-label="Menu" aria-expanded="false">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>
</header>
