<?php
namespace Models;

use Core\Database;
use PDO;

final class User
{
    public static function emailExists(string $email): bool
    {
        $pdo = Database::getConnection();
        $st = $pdo->prepare('SELECT 1 FROM users WHERE LOWER(email) = LOWER(?) LIMIT 1');
        $st->execute([$email]);
        return (bool) $st->fetchColumn();
    }

    // Création prénom + nom  + hash du mot de passe
    public static function create(string $name, string $lastName, string $email, string $hash): bool
    {
        $pdo = Database::getConnection();
        $st = $pdo->prepare(
            'INSERT INTO users (name, last_name, email, password, created_at, updated_at)
             VALUES (?, ?, ?, ?, NOW(), NOW())'
        );
        return $st->execute([$name, $lastName, strtolower(trim($email)), $hash]);
    }

    // Variante qui retourne l'ID inséré ou null
    public static function createWithId(string $name, string $lastName, string $email, string $hash): ?int
    {
        $pdo = Database::getConnection();
        $st = $pdo->prepare(
            'INSERT INTO users (name, last_name, email, password, created_at, updated_at)
             VALUES (?, ?, ?, ?, NOW(), NOW())'
        );
        if ($st->execute([$name, $lastName, strtolower(trim($email)), $hash])) {
            return (int)$pdo->lastInsertId() ?: null;
        }
        return null;
    }

    // Récupération pour la connexion
    public static function findByEmail(string $email): ?array
    {
        $pdo = Database::getConnection();
        $st = $pdo->prepare('
            SELECT user_id, name, last_name, email, password, is_active
            FROM users
            WHERE LOWER(email) = LOWER(?)
            LIMIT 1
        ');
        $st->execute([strtolower(trim($email))]);
        $user = $st->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }

    public static function findById(int $id): ?array
    {
        $pdo = Database::getConnection();
        $st = $pdo->prepare('
            SELECT user_id, name, last_name, email, password
            FROM users
            WHERE user_id = ?
            LIMIT 1
        ');
        $st->execute([$id]);
        $user = $st->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }

    public static function updatePassword(int $id, string $hash): bool
    {
        $pdo = Database::getConnection();
        $st = $pdo->prepare('UPDATE users SET password = ?, updated_at = NOW() WHERE user_id = ?');
        return $st->execute([$hash, $id]);
    }

    public static function updateEmail(int $id, string $newEmail): bool
    {
        $pdo = Database::getConnection();
        $st = $pdo->prepare('UPDATE users SET email = ?, updated_at = NOW() WHERE user_id = ?');
        return $st->execute([strtolower(trim($newEmail)), $id]);
    }

    
    public static function activateById(int $id): bool
    {
        $pdo = Database::getConnection();
        $st = $pdo->prepare('UPDATE users SET is_active = 1, activated_at = NOW(), updated_at = NOW() WHERE user_id = ?');
        return $st->execute([$id]);
    }
}
