<?php
/**
 * Variables pour le template de la page
 */
$pageTitle = "Dashboard";
$pageDescription = "Tableau de bord";
$pageStyles = [];
$pageScripts = [];
?>
<!DOCTYPE html>
<html lang="fr">
<?php include __DIR__ . '/partials/head.php'; ?>

<body>
<?php include __DIR__ . '/partials/headerPrivate.php'; ?>

<main>
    <div class="dashboard-coming-soon">
        <h1>À venir</h1>
        <p>Cette fonctionnalité sera bientôt disponible</p>
    </div>
</main>

<?php include __DIR__ . '/partials/footer.php'; ?>
</body>
</html>