<?php
/**
 * Fichier : activation-result.php
 * Affiche le résultat de l’activation de compte (succès/erreur).
 */

$pageTitle = 'Activation du compte';
$pageDescription = 'Résultat de l’activation de votre compte';
$pageStyles = ["/assets/style/authentication.css"];
$pageScripts = [];

$success = $success ?? false;
$message = $message ?? ($success ? 'Votre compte est activé.' : 'Lien invalide.');
?>
<!doctype html>
<html lang="fr">
<?php include __DIR__ . '/../partials/head.php'; ?>
<body>
<?php include __DIR__ . '/../partials/headerPublic.php'; ?>
<main class="main">
  <section class="hero">
    <h1>Activation du compte</h1>

    <div class="alert <?= $success ? 'alert-success' : 'alert-error' ?>">
      <?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?>
    </div>

    <p class="mt-16">
      <a class="link-strong" href="/login">Aller à la connexion</a>
    </p>
  </section>
</main>
<?php include __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>
