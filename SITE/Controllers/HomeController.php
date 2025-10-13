<?php
namespace Controllers;

use Core\Controller;

/**
 * HomeController - Page d'accueil
 *
 * Gère l'affichage de la page d'accueil publique
 *
 * @package DashMed
 * @version 2.0
 */
final class HomeController extends Controller
{
    /**
     * Affiche la page d'accueil
     */
    public function index(): void
    {
        $this->view('home', [
            'pageTitle' => 'Accueil',
            'pageDescription' => 'Bienvenue sur DashMed',
        ], 'base');
    }
}