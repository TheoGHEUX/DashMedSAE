<?php
/**
 * Fichier : header-auth.php
 * Header simplifié pour les pages d'authentification
 *
 * Header optimisé pour les pages d'inscription et de connexion avec:
 * - Logo et nom de marque
 * - Navigation basique (Accueil, Plan du site, Mentions légales)
 * - Bouton Connexion ou Inscription selon la page
 * - Menu burger responsive
 *
 * @package DashMed
 * @version 2.0
 */

use Core\View;

// Détecte la page courante
$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
?>
<header class="topbar">
    <div class="container">
        <!-- Logo et nom de la marque -->
        <div class="brand">
            <img class="logo" src="/assets/images/logo.png" alt="Logo DashMed">
            <span class="brand-name">DashMed</span>
        </div>

        <!-- Navigation principale -->
        <nav class="mainnav" aria-label="Navigation principale">
            <a href="/">Accueil</a>
            <a href="/map">Plan du site</a>
            <a href="/legal-notices">Mentions légales</a>
        </nav>

        <!-- Bouton Connexion ou Inscription selon la page -->
        <?php if ($currentPath === '/login'): ?>
            <a href="/register" class="login-btn">Inscription</a>
        <?php else: ?>
            <a href="/login" class="login-btn<?= ($currentPath === '/login' ? ' current' : '') ?>">Connexion</a>
        <?php endif; ?>

        <!-- Menu burger pour responsive -->
        <button class="burger-menu" aria-label="Menu" aria-expanded="false">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>
</header>
