<?php
namespace Controllers;

use Core\Controller;
use Core\Csrf;
use Core\Mailer;
use Models\User;

/**
 * AuthController - Gestion de l'authentification
 *
 * Gère l'inscription, la connexion et la déconnexion des utilisateurs
 *
 * @package DashMed
 * @version 2.0
 */
final class AuthController extends Controller
{
    /**
     * Affiche le formulaire d'inscription
     */
    public function showRegister(): void
    {
        // Si déjà connecté, redirige vers le dashboard
        $this->requireGuest();

        $this->view('auth/register', [
            'errors' => [],
            'success' => '',
            'old' => ['name' => '', 'last_name' => '', 'email' => ''],
            'csrf_token' => Csrf::token(),
        ], 'auth');
    }

    /**
     * Traite l'inscription
     */
    public function register(): void
    {
        $this->requireGuest();

        $errors = [];
        $old = [
            'name'      => trim($this->post('name', '')),
            'last_name' => trim($this->post('last_name', '')),
            'email'     => trim($this->post('email', '')),
        ];

        // Validation CSRF
        if (!$this->validateCsrf($this->post('csrf_token', ''))) {
            $errors[] = 'Session expirée ou jeton CSRF invalide.';
        }

        // Validation de l'email
        if (!filter_var($old['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Adresse email invalide.';
        }

        // Validation du nom et prénom
        if (empty($old['name']) || strlen($old['name']) < 2) {
            $errors[] = 'Le prénom doit contenir au moins 2 caractères.';
        }

        if (empty($old['last_name']) || strlen($old['last_name']) < 2) {
            $errors[] = 'Le nom doit contenir au moins 2 caractères.';
        }

        // Validation du mot de passe
        $password = $this->post('password', '');
        $password_confirm = $this->post('password_confirm', '');

        if ($password !== $password_confirm) {
            $errors[] = 'Les mots de passe ne correspondent pas.';
        }

        if (!$this->validatePassword($password)) {
            $errors[] = 'Le mot de passe doit contenir au moins 12 caractères, avec majuscules, minuscules, chiffres et un caractère spécial.';
        }

        // Vérification de l'existence de l'email
        if (!$errors && User::emailExists($old['email'])) {
            $errors[] = 'Un compte existe déjà avec cette adresse email.';
        }

        // Création du compte
        if (empty($errors)) {
            $hash = password_hash($password, PASSWORD_DEFAULT);

            try {
                if (User::create($old['name'], $old['last_name'], $old['email'], $hash)) {
                    // Envoi de l'email de bienvenue
                    $mailSent = Mailer::sendRegistrationEmail($old['email'], $old['name']);

                    $this->setFlash('success', $mailSent
                        ? 'Compte créé avec succès ! Un email de confirmation a été envoyé.'
                        : 'Compte créé. (L\'email de bienvenue n\'a pas pu être envoyé.)');

                    // Redirection vers la page de connexion
                    $this->redirect('/login');
                    return;
                } else {
                    $errors[] = 'Une erreur est survenue lors de la création du compte.';
                }
            } catch (\Throwable $e) {
                error_log('Registration error: ' . $e->getMessage());
                $errors[] = 'Une erreur est survenue. Veuillez réessayer.';
            }
        }

        // Affichage du formulaire avec les erreurs
        $this->view('auth/register', [
            'errors' => $errors,
            'success' => '',
            'old' => $old,
            'csrf_token' => Csrf::token(),
        ], 'auth');
    }

    /**
     * Affiche le formulaire de connexion
     */
    public function showLogin(): void
    {
        $this->requireGuest();

        $success = '';

        // Message de succès si redirection après réinitialisation de mot de passe
        if ($this->get('reset') === '1') {
            $success = 'Votre mot de passe a été réinitialisé. Vous pouvez vous connecter.';
        }

        $this->view('auth/login', [
            'errors' => [],
            'success' => $success,
            'old' => ['email' => ''],
            'csrf_token' => Csrf::token(),
        ], 'auth');
    }

    /**
     * Traite la connexion
     */
    public function login(): void
    {
        $this->requireGuest();

        $errors = [];
        $old = [
            'email' => trim($this->post('email', '')),
        ];
        $password = $this->post('password', '');

        // Validation CSRF
        if (!$this->validateCsrf($this->post('csrf_token', ''))) {
            $errors[] = 'Session expirée ou jeton CSRF invalide.';
        }

        // Validation de l'email
        if (!filter_var($old['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Adresse email invalide.';
        }

        // Validation du mot de passe
        if (empty($password)) {
            $errors[] = 'Le mot de passe est requis.';
        }

        // Authentification
        if (empty($errors)) {
            $user = User::authenticate($old['email'], $password);

            if ($user) {
                // Régénération de l'ID de session pour la sécurité
                session_regenerate_id(true);

                // Stockage des informations utilisateur
                $_SESSION['user'] = [
                    'user_id' => $user['user_id'],
                    'email' => $user['email'],
                    'name' => $user['name'] . ' ' . $user['last_name'],
                ];

                // Redirection vers le dashboard
                $this->redirect('/dashboard');
                return;
            } else {
                $errors[] = 'Email ou mot de passe incorrect.';
            }
        }

        // Affichage du formulaire avec les erreurs
        $this->view('auth/login', [
            'errors' => $errors,
            'success' => '',
            'old' => $old,
            'csrf_token' => Csrf::token(),
        ], 'auth');
    }

    /**
     * Déconnexion
     */
    public function logout(): void
    {
        // Destruction de la session
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        session_destroy();

        // Redirection vers l'accueil
        $this->redirect('/');
    }

    /**
     * Valide la force du mot de passe
     */
    private function validatePassword(string $password): bool
    {
        return strlen($password) >= 12
            && preg_match('/[A-Z]/', $password)
            && preg_match('/[a-z]/', $password)
            && preg_match('/\d/', $password)
            && preg_match('/[^A-Za-z0-9]/', $password);
    }
}