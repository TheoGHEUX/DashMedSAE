<?php

/**
 * Fichier de configuration de l'application DashMed
 * 
 * Centralise tous les paramètres configurables de l'application
 * 
 * @package DashMed
 * @version 2.0
 */

return [
    // Configuration de l'application
    'app' => [
        'name' => 'DashMed',
        'version' => '2.0',
        'env' => getenv('APP_ENV') ?: 'production',
        'debug' => getenv('APP_DEBUG') === 'true',
        'url' => getenv('APP_URL') ?: 'http://localhost',
    ],

    // Configuration de la session
    'session' => [
        'name' => 'dashmed_session',
        'lifetime' => 0,
        'path' => '/',
        'domain' => '',
        'samesite' => 'Lax',
    ],

    // Configuration de la base de données
    'database' => [
        'host' => getenv('DB_HOST') ?: 'localhost',
        'port' => getenv('DB_PORT') ?: '3306',
        'name' => getenv('DB_NAME') ?: 'dashmed',
        'user' => getenv('DB_USER') ?: 'root',
        'pass' => getenv('DB_PASS') ?: '',
        'charset' => 'utf8mb4',
    ],

    // Configuration de la sécurité
    'security' => [
        'csrf_token_ttl' => 7200,
        'password_min_length' => 8,
    ],

    // Configuration des emails
    'mail' => [
        'from_address' => getenv('MAIL_FROM') ?: 'noreply@dashmed.fr',
        'from_name' => 'DashMed',
    ],
];
