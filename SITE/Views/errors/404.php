<?php
/**
 * Fichier : 404.php
 * Page d'erreur 404 de l'application DashMed.
 *
 * Présente un message d'erreur et invite à retourner à la page d'accueil.
 * Utilise la structure dynamique avec head, header et footer inclus.
 *
 * Variables dynamiques attendues :
 * - $pageTitle       : string   - Titre de la page
 * - $pageDescription : string   - Description pour les métadonnées
 * - $pageStyles      : array    - Styles CSS spécifiques
 * - $pageScripts     : array    - Scripts JS spécifiques
 *
 * @package DashMed
 * @version 1.0
 * @author FABRE Alexis, GHEUX Théo, JACOB Alexandre, TAHA CHAOUI Amir, UYSUN Ali
 */
<<<<<<< HEAD
?>
<!doctype html>
<html lang="fr">
<?php
// Variables dynamiques transmises depuis le contrôleur (valeurs par défaut si absentes)
$pageTitle = $pageTitle ?? "Page non trouvée - Erreur 404";
$pageDescription = $pageDescription ?? "La page que vous recherchez n'existe pas.";
$pageStyles = $pageStyles ?? ["/assets/style/404.css"];
$pageScripts = $pageScripts ?? [];
include __DIR__ . '/../partials/head.php';
=======
// Variables dynamiques transmises depuis le contrôleur
$pageTitle = "Page non trouvée - Erreur 404";
$pageDescription = "La page que vous recherchez n'existe pas.";
$pageStyles = $pageStyles ?? ["/assets/style/404.css"];
$pageScripts = [];
>>>>>>> e4fd29acfde8ee899e7a16c70a8048f46b0d7943
?>
<!doctype html>
<html lang="fr">
    
<?php include __DIR__ . '/../partials/head.php'; ?>

<body>

<?php include __DIR__ . '/../partials/headerPublic.php'; ?>

<main>
    <div class="error-container">
        <div class="error-content">
            <div class="error-code">404</div>
            <h1 class="error-title">Page non trouvée</h1>
            <p class="error-message">
                Désolé, la page que vous recherchez n'existe pas ou a été déplacée.
            </p>
            <div class="error-actions">
                <a href="/" class="btn btn-primary">Retour à l'accueil</a>
                <a href="/dashboard" class="btn btn-secondary">Tableau de bord</a>
            </div>
        </div>
    </div>
</main>



<?php include __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>
