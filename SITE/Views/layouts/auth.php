<?php
/**
 * Fichier : auth.php
 * Layout pour les pages d'authentification (register, login)
 *
 * Ce layout fournit une structure HTML complète avec:
 * - Header simplifié via View::include('header-auth')
 * - Messages flash via View::include('flash-messages')
 * - Style authentication.css pré-chargé
 * - Zone de contenu dynamique ($content)
 * - Footer
 *
 * Variables attendues:
 * - $pageTitle       : string - Titre de la page
 * - $pageDescription : string - Description pour les métadonnées
 * - $content         : string - Contenu de la vue
 *
 * @package DashMed
 * @version 2.0
 */

use Core\View;

// Variables par défaut
$pageTitle = $pageTitle ?? 'Authentification';
$pageDescription = $pageDescription ?? 'Connectez-vous ou inscrivez-vous sur DashMed';
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
    
    <!-- Style authentication -->
    <link rel="stylesheet" href="/assets/style/authentication.css" />

    <!-- Scripts -->
    <script src="/assets/script/header_responsive.js" defer></script>

    <link rel="icon" href="/assets/images/logo.png">
</head>
<body>
    <?php View::include('header-auth'); ?>

    <?php View::include('flash-messages'); ?>

    <main class="main">
        <?= $content ?>
    </main>

    <?php View::include('footer'); ?>
</body>
</html>
