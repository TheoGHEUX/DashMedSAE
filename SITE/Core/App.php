<?php
namespace Core;

/**
 * Classe App - Bootstrap de l'application
 * 
 * Centralise l'initialisation de l'application : configuration, session, autoloader
 * et démarrage du routeur.
 * 
 * @package DashMed
 * @version 2.0
 */
final class App
{
    private static ?App $instance = null;
    private array $config = [];

    private function __construct()
    {
        $this->loadConfig();
        $this->initSession();
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function loadConfig(): void
    {
        $configFile = dirname(__DIR__) . '/Config/config.php';
        if (file_exists($configFile)) {
            $this->config = require $configFile;
        }
    }

    private function initSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            $secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
            session_set_cookie_params([
                'lifetime' => $this->config['session']['lifetime'] ?? 0,
                'path'     => $this->config['session']['path'] ?? '/',
                'domain'   => $this->config['session']['domain'] ?? '',
                'secure'   => $secure,
                'httponly' => true,
                'samesite' => $this->config['session']['samesite'] ?? 'Lax',
            ]);
            session_name($this->config['session']['name'] ?? 'dashmed_session');
            session_start();
        }
    }

    public function run(): void
    {
        $router = new Router($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
        $router->dispatch();
    }

    public function config(string $key, $default = null)
    {
        $keys = explode('.', $key);
        $value = $this->config;
        
        foreach ($keys as $k) {
            if (!isset($value[$k])) {
                return $default;
            }
            $value = $value[$k];
        }
        
        return $value;
    }
}