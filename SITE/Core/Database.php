<?php
namespace Core;

use PDO;
use PDOException;

final class Database
{
    private static ?PDO $pdo = null;

    public static function getConnection(): PDO
    {
        if (self::$pdo === null) {

            // Lecture d'un fichier .env à la racine du dépôt (optionnel)
            $root = dirname(__DIR__, 2); // remonte de SITE/Core -> projet
            $envFile = $root . DIRECTORY_SEPARATOR . '.env';
            $env = [];
            if (is_file($envFile) && is_readable($envFile)) {
                $lines = @file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                if ($lines !== false) {
                    foreach ($lines as $line) {
                        $line = trim($line);
                        if ($line === '' || str_starts_with($line, '#') || str_starts_with($line, ';')) continue;
                        if (strpos($line, '=') === false) continue;
                        [$k, $v] = explode('=', $line, 2);
                        $k = trim($k);
                        $v = trim($v);
                        if ($v !== '' && (($v[0] === '"' && substr($v, -1) === '"') || ($v[0] === "'" && substr($v, -1) === "'"))) {
                            $v = substr($v, 1, -1);
                        }
                        $env[$k] = $v;
                    }
                }
            }

            // Si .env fourni, priorité aux valeurs DB_* sinon fallback sur comportement historique
            if (!empty($env['DB_HOST']) || !empty($env['DB_USER']) || !empty($env['DB_NAME'])) {
                $host = $env['DB_HOST'] ?? '127.0.0.1';
                $port = $env['DB_PORT'] ?? '3306';
                $db   = $env['DB_NAME'] ?? 'dashmed-site_db';
                $user = $env['DB_USER'] ?? 'root';
                $pass = $env['DB_PASS'] ?? '';
            } else {
                // Détection : en production (AlwaysData) si domaine contient alwaysdata.net
                $isProd = isset($_SERVER['HTTP_HOST']) && str_contains($_SERVER['HTTP_HOST'], 'alwaysdata.net');

                if ($isProd) {
                    // REMPLACER les XXXXX ci-dessous par tes valeurs exactes depuis le panel AlwaysData
                    $host = 'mysql-dashmed-site.alwaysdata.net';
                    $db   = 'dashmed-site_db';               // nom complet de la base
                    $user = '433165';                  // utilisateur MySQL
                    $pass = 'mCwc99{0~D';            // mot de passe MySQL
                    $port = '3306';
                } else {
                    // Local
                    $host = '127.0.0.1';
                    $db   = 'dashmed-site_db';
                    $user = 'root';
                    $pass = '';
                    $port = '3306';
                }
            }

            $dsn = "mysql:host={$host};port={$port};dbname={$db};charset=utf8mb4";

            try {
                self::$pdo = new PDO($dsn, $user, $pass, [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ]);
            } catch (PDOException $e) {
                error_log('DB CONNECTION FAIL: '.$e->getMessage());
                throw $e;
            }
        }
        return self::$pdo;
    }
}
