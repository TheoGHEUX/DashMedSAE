<?php
/**
 * Fichier : base.php
 * Layout de base pour les pages publiques de DashMed
 *
 * Ce layout fournit une structure HTML complète avec:
 * - Header via View::include('header')
 * - Messages flash via View::include('flash-messages')
 * - Zone de contenu dynamique ($content)
 * - Footer
 * - Support des styles et scripts personnalisés par page
 *
 * Variables attendues:
 * - $pageTitle       : string - Titre de la page
 * - $pageDescription : string - Description pour les métadonnées
 * - $pageStyles      : array  - Styles CSS spécifiques (optionnel)
 * - $pageScripts     : array  - Scripts JS spécifiques (optionnel)
 * - $content         : string - Contenu de la vue
 *
 * @package DashMed
 * @version 2.0
 */

use Core\View;

// Variables par défaut
$pageTitle = $pageTitle ?? 'DashMed';
$pageDescription = $pageDescription ?? 'Votre tableau de bord santé simple et moderne pour la médecine';
$pageStyles = $pageStyles ?? [];
$pageScripts = $pageScripts ?? [];
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="<?= View::e($pageDescription) ?>">
    <title><?= View::e($pageTitle) ?> - DashMed</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Styles de base -->
    <link rel="stylesheet" href="/assets/style/body_main_container.css" />
    <link rel="stylesheet" href="/assets/style/header.css" />
    <link rel="stylesheet" href="/assets/style/footer.css" />
    <link rel="stylesheet" href="/assets/style/flash-messages.css" />

    <!-- Styles spécifiques à la page -->
    <?php foreach ($pageStyles as $style): ?>
        <link rel="stylesheet" href="<?= View::e($style) ?>" />
    <?php endforeach; ?>

    <!-- Scripts -->
    <script src="/assets/script/header_responsive.js" defer></script>
    <?php foreach ($pageScripts as $script): ?>
        <script src="<?= View::e($script) ?>" defer></script>
    <?php endforeach; ?>

    <link rel="icon" href="/assets/images/logo.png">
</head>
<body>
    <?php View::include('header'); ?>

    <?php View::include('flash-messages'); ?>

    <main>
        <?= $content ?>
    </main>

    <?php View::include('footer'); ?>
</body>
</html>
