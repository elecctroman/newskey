<?php

namespace Core;

use PDO;
use PDOException;

/**
 * // --- PDO tabanlı veritabanı katmanı
 */
class Database
{
    private static ?PDO $connection = null;

    /**
     * // --- Veritabanı bağlantısını döndürür
     * @param array<string, mixed> $config
     * @return PDO
     */
    public static function connection(array $config): PDO
    {
        if (self::$connection === null) {
            $dsn = sprintf(
                '%s:host=%s;port=%s;dbname=%s;charset=%s',
                $config['driver'] ?? 'mysql',
                $config['host'],
                $config['port'],
                $config['database'],
                $config['charset'] ?? 'utf8mb4'
            );

            try {
                self::$connection = new PDO(
                    $dsn,
                    (string) $config['username'],
                    (string) $config['password'],
                    $config['options'] ?? []
                );
            } catch (PDOException $exception) {
                throw new PDOException('Veritabanı bağlantısı başarısız: ' . $exception->getMessage());
            }
        }

        return self::$connection;
    }
}
