<?php
namespace Models;

use Core\Database;
use PDO;

final class Activation
{
    public static function createForUser(int $userId, string $token, int $ttlMinutes = 1440): bool
    {
        $pdo = Database::getConnection();
        $tokenHash = hash('sha256', $token);
        $st = $pdo->prepare('
            INSERT INTO account_activations (user_id, token_hash, expires_at, created_at)
            VALUES (?, ?, DATE_ADD(NOW(), INTERVAL ? MINUTE), NOW())
        ');
        return $st->execute([$userId, $tokenHash, $ttlMinutes]);
    }

    public static function findByToken(string $token): ?array
    {
        $pdo = Database::getConnection();
        $tokenHash = hash('sha256', $token);
        $st = $pdo->prepare('
            SELECT id, user_id, token_hash, expires_at, used_at
            FROM account_activations
            WHERE token_hash = ?
              AND used_at IS NULL
              AND expires_at > NOW()
            LIMIT 1
        ');
        $st->execute([$tokenHash]);
        $row = $st->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public static function markUsedById(int $id): bool
    {
        $pdo = Database::getConnection();
        $st = $pdo->prepare('UPDATE account_activations SET used_at = NOW() WHERE id = ? AND used_at IS NULL');
        return $st->execute([$id]);
    }

    public static function hasPendingForUserId(int $userId): bool
    {
        $pdo = Database::getConnection();
        $st = $pdo->prepare('
            SELECT 1
            FROM account_activations
            WHERE user_id = ?
              AND used_at IS NULL
              AND expires_at > NOW()
            LIMIT 1
        ');
        $st->execute([$userId]);
        return (bool)$st->fetchColumn();
    }
}
