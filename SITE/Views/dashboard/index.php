<?php
/**
 * Fichier : dashboard/index.php
 * Page du tableau de bord utilisateur
 *
 * Affiche le tableau de bord principal de l'utilisateur connecté
 * avec un aperçu de ses données et un accès rapide aux fonctionnalités
 *
 * Variables attendues:
 * - $user      : array  - Données de l'utilisateur connecté
 * - $pageTitle : string - Titre de la page
 *
 * @package DashMed
 * @version 2.0
 */

use Core\View;
?>

<div class="container">
    <section class="dashboard-header">
        <h1>Bienvenue, <?= View::e($user['name'] ?? 'Utilisateur') ?> !</h1>
        <p class="subtitle">Voici votre tableau de bord personnel</p>
    </section>

    <section class="dashboard-content">
        <div class="dashboard-grid">
            <!-- Carte de profil -->
            <article class="dashboard-card">
                <div class="card-icon">👤</div>
                <h3>Mon profil</h3>
                <p>Gérez vos informations personnelles</p>
                <a href="/profile" class="card-link">Accéder au profil →</a>
            </article>

            <!-- Carte de santé -->
            <article class="dashboard-card">
                <div class="card-icon">📊</div>
                <h3>Mes données de santé</h3>
                <p>Consultez vos indicateurs et statistiques</p>
                <a href="/health-data" class="card-link">Voir les données →</a>
            </article>

            <!-- Carte de paramètres -->
            <article class="dashboard-card">
                <div class="card-icon">⚙️</div>
                <h3>Paramètres</h3>
                <p>Configurez votre compte et vos préférences</p>
                <a href="/settings" class="card-link">Paramètres →</a>
            </article>
        </div>
    </section>
</div>

<style>
/* Styles spécifiques au dashboard */
.dashboard-header {
    margin: 40px 0 32px;
    text-align: center;
}

.dashboard-header h1 {
    font-size: 28px;
    margin: 0 0 8px;
    color: var(--text);
}

.dashboard-header .subtitle {
    font-size: 15px;
    color: var(--muted);
    margin: 0;
}

.dashboard-content {
    padding: 0 0 40px;
}

.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
    margin-top: 24px;
}

.dashboard-card {
    padding: 24px;
    border: 1px solid var(--line);
    border-radius: 14px;
    background: #fff;
    text-align: center;
    transition: transform 0.2s, box-shadow 0.2s;
}

.dashboard-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
}

.card-icon {
    font-size: 36px;
    margin-bottom: 12px;
}

.dashboard-card h3 {
    font-size: 18px;
    margin: 0 0 8px;
    color: var(--text);
}

.dashboard-card p {
    font-size: 14px;
    color: var(--muted);
    margin: 0 0 16px;
}

.card-link {
    display: inline-block;
    color: var(--brand);
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
    transition: opacity 0.15s;
}

.card-link:hover {
    opacity: 0.8;
}

@media (max-width: 768px) {
    .dashboard-header h1 {
        font-size: 24px;
    }

    .dashboard-grid {
        grid-template-columns: 1fr;
        gap: 16px;
    }
}
</style>
