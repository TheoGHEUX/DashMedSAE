<?php
namespace Controllers;

use Core\Controller;
use Models\User;

/**
 * ProfileController - Gestion du profil utilisateur
 *
 * Affiche et gère les modifications du profil de l'utilisateur connecté
 *
 * @package DashMed
 * @version 2.0
 */
final class ProfileController extends Controller
{
    /**
     * Affiche le profil de l'utilisateur
     */
    public function show(): void
    {
        // Vérifie que l'utilisateur est connecté
        $this->requireAuth();

        $user = $this->getUser();

        // Sépare le nom complet en prénom et nom
        $parts = preg_split('/\s+/', trim($user['name'] ?? ''), 2);
        $firstName = $parts[0] ?? '';
        $lastName = $parts[1] ?? '';

        $this->view('profile/show', [
            'user' => $user,
            'firstName' => $firstName,
            'lastName' => $lastName,
        ], 'dashboard');
    }

    /**
     * Affiche le formulaire de modification d'email
     */
    public function editEmail(): void
    {
        $this->requireAuth();

        $this->view('profile/edit-email', [
            'errors' => [],
            'success' => '',
        ], 'dashboard');
    }

    /**
     * Traite la modification d'email
     */
    public function updateEmail(): void
    {
        $this->requireAuth();

        // TODO: Implémenter la mise à jour de l'email avec vérification
        $this->setFlash('info', 'Fonctionnalité en cours de développement.');
        $this->redirect('/profile');
    }

    /**
     * Affiche la confirmation de suppression de compte
     */
    public function confirmDelete(): void
    {
        $this->requireAuth();

        $this->view('profile/confirm-delete', [], 'dashboard');
    }

    /**
     * Supprime le compte utilisateur
     */
    public function delete(): void
    {
        $this->requireAuth();

        // TODO: Implémenter la suppression de compte avec confirmation
        $this->setFlash('info', 'Fonctionnalité en cours de développement.');
        $this->redirect('/profile');
    }
}