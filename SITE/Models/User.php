<?php
namespace Models;

use Core\Model;
use Core\Database;
use PDO;

/**
 * Modèle User - Gestion des utilisateurs
 *
 * Hérite de Model pour bénéficier des méthodes CRUD génériques
 * et ajoute des méthodes spécifiques aux utilisateurs
 *
 * @package DashMed
 * @version 2.0
 */
final class User extends Model
{
    protected static string $table = 'users';
    protected static string $primaryKey = 'user_id';

    /**
     * Vérifie si un email existe déjà
     */
    public static function emailExists(string $email): bool
    {
        return self::exists('email', strtolower(trim($email)));
    }

    /**
     * Crée un nouvel utilisateur
     */
    public static function create(string $name, string $lastName, string $email, string $hash): bool
    {
        $data = [
            'name' => $name,
            'last_name' => $lastName,
            'email' => strtolower(trim($email)),
            'password' => $hash,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        return parent::create($data) !== false;
    }

    /**
     * Trouve un utilisateur par email
     */
    public static function findByEmail(string $email): ?array
    {
        return self::findBy('email', strtolower(trim($email)));
    }

    /**
     * Met à jour le mot de passe d'un utilisateur
     */
    public static function updatePassword(string $email, string $newHash): bool
    {
        $pdo = self::getDb();
        $stmt = $pdo->prepare('
            UPDATE users 
            SET password = ?, updated_at = NOW() 
            WHERE LOWER(email) = LOWER(?)
        ');

        return $stmt->execute([$newHash, strtolower(trim($email))]);
    }

    /**
     * Récupère un utilisateur par son ID avec toutes ses informations
     */
    public static function findById(int $userId): ?array
    {
        return self::find($userId);
    }

    /**
     * Met à jour les informations d'un utilisateur
     */
    public static function updateUser(int $userId, array $data): bool
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return self::update($userId, $data);
    }

    /**
     * Supprime un utilisateur
     */
    public static function deleteUser(int $userId): bool
    {
        return self::delete($userId);
    }

    /**
     * Vérifie les identifiants de connexion
     */
    public static function authenticate(string $email, string $password): ?array
    {
        $user = self::findByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            // Ne retourne pas le mot de passe
            unset($user['password']);
            return $user;
        }

        return null;
    }

    /**
     * Récupère les informations publiques d'un utilisateur (sans mot de passe)
     */
    public static function getPublicInfo(int $userId): ?array
    {
        $user = self::find($userId);

        if ($user) {
            unset($user['password']);
            return $user;
        }

        return null;
    }
}