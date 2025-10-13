<?php
namespace Core;

/**
 * Classe View - Gestionnaire de vues avec système de layouts
 *
 * Permet d'afficher des vues avec support des layouts parent, des sections
 * et du passage de variables. Élimine la duplication de code dans les templates.
 *
 * @package DashMed
 * @version 2.0
 */
final class View
{
    private static ?string $layout = null;
    private static array $sections = [];
    private static ?string $currentSection = null;
    private static array $sharedData = [];

    /**
     * Affiche une vue avec layout optionnel
     *
     * @param string $view Chemin de la vue (ex: 'auth/register')
     * @param array $data Données à passer à la vue
     * @param string|null $layout Layout à utiliser (ex: 'base', 'auth')
     */
    public static function render(string $view, array $data = [], ?string $layout = null): void
    {
        self::$layout = $layout;
        self::$sections = [];

        $viewFile = self::getViewPath($view);

        if (!file_exists($viewFile)) {
            throw new \RuntimeException("Vue introuvable : {$view}");
        }

        // Extraction des données pour les rendre disponibles dans la vue
        extract(array_merge(self::$sharedData, $data));

        // Capture du contenu de la vue
        ob_start();
        require $viewFile;
        $content = ob_get_clean();

        // Si un layout est défini, on l'utilise
        if (self::$layout !== null) {
            $layoutFile = self::getLayoutPath(self::$layout);

            if (!file_exists($layoutFile)) {
                throw new \RuntimeException("Layout introuvable : " . self::$layout);
            }

            // Le contenu principal est disponible via $content dans le layout
            require $layoutFile;
        } else {
            echo $content;
        }
    }

    /**
     * Définit le layout à utiliser depuis une vue
     */
    public static function extends(string $layout): void
    {
        self::$layout = $layout;
    }

    /**
     * Démarre une section
     */
    public static function section(string $name): void
    {
        self::$currentSection = $name;
        ob_start();
    }

    /**
     * Termine une section
     */
    public static function endSection(): void
    {
        if (self::$currentSection === null) {
            throw new \RuntimeException("Aucune section active");
        }

        self::$sections[self::$currentSection] = ob_get_clean();
        self::$currentSection = null;
    }

    /**
     * Affiche le contenu d'une section
     */
    public static function yield(string $name, string $default = ''): void
    {
        echo self::$sections[$name] ?? $default;
    }

    /**
     * Inclut un partial (fragment de vue réutilisable)
     */
    public static function include(string $partial, array $data = []): void
    {
        $partialFile = self::getPartialPath($partial);

        if (!file_exists($partialFile)) {
            throw new \RuntimeException("Partial introuvable : {$partial}");
        }

        extract(array_merge(self::$sharedData, $data));
        require $partialFile;
    }

    /**
     * Partage des données avec toutes les vues
     */
    public static function share(string $key, $value): void
    {
        self::$sharedData[$key] = $value;
    }

    /**
     * Échappe les données pour l'affichage HTML
     */
    public static function escape($value): string
    {
        return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Alias court pour escape
     */
    public static function e($value): string
    {
        return self::escape($value);
    }

    private static function getViewPath(string $view): string
    {
        return dirname(__DIR__) . '/Views/' . $view . '.php';
    }

    private static function getLayoutPath(string $layout): string
    {
        return dirname(__DIR__) . '/Views/layouts/' . $layout . '.php';
    }

    private static function getPartialPath(string $partial): string
    {
        return dirname(__DIR__) . '/Views/partials/' . $partial . '.php';
    }
}