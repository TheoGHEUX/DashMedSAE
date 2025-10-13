<?php
namespace Controllers;

use Core\Controller;

/**
 * DashboardController - Tableau de bord utilisateur
 *
 * Affiche le tableau de bord principal de l'utilisateur connecté
 *
 * @package DashMed
 * @version 2.0
 */
final class DashboardController extends Controller
{
    /**
     * Affiche le tableau de bord
     */
    public function index(): void
    {
        // Vérifie que l'utilisateur est connecté
        $this->requireAuth();

        $user = $this->getUser();

        $this->view('dashboard/index', [
            'user' => $user,
            'pageTitle' => 'Tableau de bord',
        ], 'dashboard');
    }
}