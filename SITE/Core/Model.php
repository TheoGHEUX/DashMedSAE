<?php
namespace Core;

use PDO;

/**
 * Classe Model - Modèle de base
 * 
 * Tous les modèles de l'application héritent de cette classe.
 * Fournit des méthodes CRUD génériques et utilitaires pour interagir avec la base de données.
 * 
 * @package DashMed
 * @version 2.0
 */
abstract class Model
{
    protected static string $table = '';
    protected static string $primaryKey = 'id';

    /**
     * Récupère la connexion PDO
     */
    protected static function getDb(): PDO
    {
        return Database::getConnection();
    }

    /**
     * Trouve un enregistrement par ID
     */
    public static function find(int $id): ?array
    {
        $table = static::$table;
        $pk = static::$primaryKey;
        
        $pdo = self::getDb();
        $stmt = $pdo->prepare("SELECT * FROM {$table} WHERE {$pk} = ? LIMIT 1");
        $stmt->execute([$id]);
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    /**
     * Trouve un enregistrement par colonne
     */
    public static function findBy(string $column, $value): ?array
    {
        $table = static::$table;
        
        $pdo = self::getDb();
        $stmt = $pdo->prepare("SELECT * FROM {$table} WHERE {$column} = ? LIMIT 1");
        $stmt->execute([$value]);
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    /**
     * Récupère tous les enregistrements
     */
    public static function all(string $orderBy = null): array
    {
        $table = static::$table;
        $sql = "SELECT * FROM {$table}";
        
        if ($orderBy !== null) {
            $sql .= " ORDER BY {$orderBy}";
        }
        
        $pdo = self::getDb();
        $stmt = $pdo->query($sql);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Crée un nouvel enregistrement
     */
    public static function create(array $data): int|false
    {
        $table = static::$table;
        $columns = array_keys($data);
        $placeholders = array_fill(0, count($columns), '?');
        
        $columnsList = implode(', ', $columns);
        $placeholdersList = implode(', ', $placeholders);
        
        $sql = "INSERT INTO {$table} ({$columnsList}) VALUES ({$placeholdersList})";
        
        $pdo = self::getDb();
        $stmt = $pdo->prepare($sql);
        
        if ($stmt->execute(array_values($data))) {
            return (int) $pdo->lastInsertId();
        }
        
        return false;
    }

    /**
     * Met à jour un enregistrement
     */
    public static function update(int $id, array $data): bool
    {
        $table = static::$table;
        $pk = static::$primaryKey;
        
        $sets = [];
        foreach (array_keys($data) as $column) {
            $sets[] = "{$column} = ?";
        }
        $setClause = implode(', ', $sets);
        
        $sql = "UPDATE {$table} SET {$setClause} WHERE {$pk} = ?";
        
        $pdo = self::getDb();
        $stmt = $pdo->prepare($sql);
        
        $values = array_values($data);
        $values[] = $id;
        
        return $stmt->execute($values);
    }

    /**
     * Supprime un enregistrement
     */
    public static function delete(int $id): bool
    {
        $table = static::$table;
        $pk = static::$primaryKey;
        
        $pdo = self::getDb();
        $stmt = $pdo->prepare("DELETE FROM {$table} WHERE {$pk} = ?");
        
        return $stmt->execute([$id]);
    }

    /**
     * Vérifie si un enregistrement existe
     */
    public static function exists(string $column, $value): bool
    {
        $table = static::$table;
        
        $pdo = self::getDb();
        $stmt = $pdo->prepare("SELECT 1 FROM {$table} WHERE {$column} = ? LIMIT 1");
        $stmt->execute([$value]);
        
        return (bool) $stmt->fetchColumn();
    }
}
