<?php
/**
 * Fichier : dashboard.php
 *
 * Page du vrai tableau de bord avec graphiques et informations des patients.
 * Affiche les statistiques détaillées, les graphiques et les données médicales.
 * Sécurise l'accès via session utilisateur et token CSRF.
 */

/**
 * Génère le token CSRF pour la sécurité des formulaires.
 * @var string $csrf_token
 */
$csrf_token = \Core\Csrf::token();

/**
 * Vérifie la présence de la session utilisateur.
 * Redirige vers la page de connexion si l'utilisateur n'est pas authentifié.
 */
if (empty($_SESSION['user'])) {
    header('Location: /login');
    exit;
}

/**
 * Variables dynamiques pour le template de la page.
 * 
 * @var string $pageTitle       Titre de la page (balise <title>)
 * @var string $pageDescription Description pour la balise <meta name="description">
 * @var array  $pageStyles      Liste des feuilles de style spécifiques à la page
 * @var array  $pageScripts     Liste des scripts spécifiques à la page
 */
$pageTitle = "Dashboard - Statistiques et Patients";
$pageDescription = "Tableau de bord médical avec graphiques détaillés et informations des patients";
$pageStyles = ["/assets/style/dashboard.css"];
$pageScripts = ["/assets/script/charts.js"];

/**
 * Données exemple pour les statistiques
 * À remplacer par des vraies données de la base de données
 */
$statistiques = [
    'total_patients' => 150,
    'rdv_aujourdhui' => 8,
    'rdv_semaine' => 42,
    'urgences' => 3
];

/**
 * Liste des patients récents
 * À remplacer par des vraies données de la base de données
 */
$patients_recents = [
    [
        'nom' => 'Martin',
        'prenom' => 'Sophie',
        'derniere_visite' => '15/05/2025',
        'statut' => 'Suivi régulier'
    ],
    [
        'nom' => 'Dubois',
        'prenom' => 'Pierre',
        'derniere_visite' => '14/05/2025',
        'statut' => 'Nouveau patient'
    ],
    [
        'nom' => 'Lambert',
        'prenom' => 'Marie',
        'derniere_visite' => '13/05/2025',
        'statut' => 'Consultation urgente'
    ]
];
?>
<!doctype html>
<html lang="fr">
<?php include __DIR__ . '/partials/head.php'; ?>

<body>
<?php include __DIR__ . '/partials/headerPrivate.php'; ?>
<main>
    <div class="container">
        <h1>Tableau de bord médical</h1>

        <!-- Section des statistiques principales -->
        <section class="stats-grid">
            <article class="stat-card">
                <h3>Total Patients</h3>
                <p class="stat-number"><?= $statistiques['total_patients'] ?></p>
            </article>
            <article class="stat-card">
                <h3>RDV Aujourd'hui</h3>
                <p class="stat-number"><?= $statistiques['rdv_aujourdhui'] ?></p>
            </article>
            <article class="stat-card">
                <h3>RDV Cette Semaine</h3>
                <p class="stat-number"><?= $statistiques['rdv_semaine'] ?></p>
            </article>
            <article class="stat-card urgent">
                <h3>Urgences</h3>
                <p class="stat-number"><?= $statistiques['urgences'] ?></p>
            </article>
        </section>

        <!-- Section des graphiques -->
        <section class="grid">
            <article class="panel">
                <h2 class="panel-title">Évolution des consultations</h2>
                <div class="chart-container">
                    <canvas id="consultationsChart"></canvas>
                    <!-- Placeholder en attendant l'implémentation des vrais graphiques -->
                    <div class="chart-placeholder" aria-hidden="true">
                        <div class="bars">
                            <span style="--h:35%"></span>
                            <span style="--h:50%"></span>
                            <span style="--h:45%"></span>
                            <span style="--h:60%"></span>
                            <span style="--h:75%"></span>
                            <span style="--h:65%"></span>
                            <span style="--h:80%"></span>
                        </div>
                    </div>
                </div>
            </article>

            <article class="panel">
                <h2 class="panel-title">Répartition des pathologies</h2>
                <div class="chart-container">
                    <canvas id="pathologiesChart"></canvas>
                    <!-- Placeholder en attendant l'implémentation des vrais graphiques -->
                    <div class="chart-placeholder" aria-hidden="true">
                        <p>Graphique circulaire à venir...</p>
                    </div>
                </div>
            </article>
        </section>

        <!-- Section des informations patients -->
        <section class="panel">
            <h2 class="panel-title">Patients récents</h2>
            <div class="table-responsive">
                <table class="patients-table">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Dernière visite</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($patients_recents as $patient): ?>
                            <tr>
                                <td><?= htmlspecialchars($patient['nom'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($patient['prenom'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($patient['derniere_visite'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td>
                                    <span class="status-badge <?= strpos($patient['statut'], 'urgente') !== false ? 'urgent' : '' ?>">
                                        <?= htmlspecialchars($patient['statut'], ENT_QUOTES, 'UTF-8') ?>
                                    </span>
                                </td>
                                <td>
                                    <button class="btn-action">Voir détails</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</main>

<?php include __DIR__ . '/partials/footer.php'; ?>
</body>
</html>
