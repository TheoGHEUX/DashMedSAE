<?php
use Core\View;
use Core\Csrf;

// Configuration de la page
$pageTitle = 'Inscription';
$pageDescription = 'Créez votre compte DashMed';
?>

<section class="hero">
    <h1>Bienvenue dans DashMed</h1>
    <p class="subtitle">Créez votre compte</p>

    <?php if (!empty($success)): ?>
        <div class="alert alert-success"><?= View::e($success) ?></div>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-error">
            <ul class="errors">
                <?php foreach ($errors as $err): ?>
                    <li><?= View::e($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="/register" class="auth-form" novalidate>
        <input type="hidden" name="csrf_token" value="<?= View::e($csrf_token) ?>">

        <div class="form-group">
            <label for="name">Prénom <span class="required">*</span></label>
            <input
                    type="text"
                    id="name"
                    name="name"
                    value="<?= View::e($old['name'] ?? '') ?>"
                    required
                    autocomplete="given-name"
            >
        </div>

        <div class="form-group">
            <label for="last_name">Nom <span class="required">*</span></label>
            <input
                    type="text"
                    id="last_name"
                    name="last_name"
                    value="<?= View::e($old['last_name'] ?? '') ?>"
                    required
                    autocomplete="family-name"
            >
        </div>

        <div class="form-group">
            <label for="email">Adresse email <span class="required">*</span></label>
            <input
                    type="email"
                    id="email"
                    name="email"
                    value="<?= View::e($old['email'] ?? '') ?>"
                    required
                    autocomplete="email"
            >
        </div>

        <div class="form-group">
            <label for="password">Mot de passe <span class="required">*</span></label>
            <input
                    type="password"
                    id="password"
                    name="password"
                    required
                    autocomplete="new-password"
            >
            <small class="form-hint">
                Minimum 12 caractères avec majuscules, minuscules, chiffres et caractère spécial
            </small>
        </div>

        <div class="form-group">
            <label for="password_confirm">Confirmer le mot de passe <span class="required">*</span></label>
            <input
                    type="password"
                    id="password_confirm"
                    name="password_confirm"
                    required
                    autocomplete="new-password"
            >
        </div>

        <button type="submit" class="btn btn-primary btn-full">S'inscrire</button>

        <p class="form-footer">
            Déjà inscrit ? <a href="/login">Se connecter</a>
        </p>
    </form>
</section>