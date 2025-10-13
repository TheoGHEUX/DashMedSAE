<?php
namespace Core;

/**
 * Classe Controller - Contrôleur de base
 * 
 * Tous les contrôleurs de l'application héritent de cette classe.
 * Fournit des méthodes utilitaires pour les vues, redirections, et gestion de session.
 * 
 * @package DashMed
 * @version 2.0
 */
abstract class Controller
{
    /**
     * Affiche une vue
     */
    protected function view(string $view, array $data = [], ?string $layout = 'base'): void
    {
        View::render($view, $data, $layout);
    }

    /**
     * Redirige vers une URL
     */
    protected function redirect(string $url, int $statusCode = 302): void
    {
        header("Location: {$url}", true, $statusCode);
        exit;
    }

    /**
     * Vérifie si l'utilisateur est connecté
     */
    protected function isAuthenticated(): bool
    {
        return !empty($_SESSION['user']);
    }

    /**
     * Récupère l'utilisateur connecté
     */
    protected function getUser(): ?array
    {
        return $_SESSION['user'] ?? null;
    }

    /**
     * Vérifie l'authentification et redirige si nécessaire
     */
    protected function requireAuth(string $redirectTo = '/login'): void
    {
        if (!$this->isAuthenticated()) {
            $this->setFlash('error', 'Vous devez être connecté pour accéder à cette page.');
            $this->redirect($redirectTo);
        }
    }

    /**
     * Vérifie que l'utilisateur n'est PAS connecté (pour pages login/register)
     */
    protected function requireGuest(string $redirectTo = '/dashboard'): void
    {
        if ($this->isAuthenticated()) {
            $this->redirect($redirectTo);
        }
    }

    /**
     * Ajoute un message flash
     */
    protected function setFlash(string $type, string $message): void
    {
        if (!isset($_SESSION['flash'])) {
            $_SESSION['flash'] = [];
        }
        $_SESSION['flash'][$type] = $message;
    }

    /**
     * Récupère et supprime les messages flash
     */
    protected function getFlash(string $type): ?string
    {
        if (isset($_SESSION['flash'][$type])) {
            $message = $_SESSION['flash'][$type];
            unset($_SESSION['flash'][$type]);
            return $message;
        }
        return null;
    }

    /**
     * Récupère tous les messages flash
     */
    protected function getAllFlash(): array
    {
        $flash = $_SESSION['flash'] ?? [];
        unset($_SESSION['flash']);
        return $flash;
    }

    /**
     * Retourne une réponse JSON
     */
    protected function json($data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }

    /**
     * Valide un token CSRF
     */
    protected function validateCsrf(string $token): bool
    {
        return Csrf::validate($token);
    }

    /**
     * Récupère une valeur POST
     */
    protected function post(string $key, $default = null)
    {
        return $_POST[$key] ?? $default;
    }

    /**
     * Récupère une valeur GET
     */
    protected function get(string $key, $default = null)
    {
        return $_GET[$key] ?? $default;
    }

    /**
     * Vérifie si la requête est POST
     */
    protected function isPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    /**
     * Vérifie si la requête est GET
     */
    protected function isGet(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }
}
