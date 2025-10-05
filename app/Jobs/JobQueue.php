<?php

namespace App\Jobs;

use Core\Database;
use Core\Logger;
use PDO;
use Throwable;

/**
 * // --- Basit veritabanı tabanlı iş kuyruğu
 */
class JobQueue
{
    private PDO $db;
    private Logger $logger;

    public function __construct()
    {
        $config = require __DIR__ . '/../../config/database.php';
        $this->db = Database::connection($config);
        $this->logger = new Logger();
    }

    /**
     * // --- Yeni iş ekler
     * @param string $type
     * @param array<string, mixed> $payload
     * @return int
     */
    public function push(string $type, array $payload): int
    {
        $statement = $this->db->prepare('INSERT INTO jobs (type, payload) VALUES (:type, :payload)');
        $statement->bindValue(':type', $type);
        $statement->bindValue(':payload', json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        $statement->execute();

        return (int) $this->db->lastInsertId();
    }

    /**
     * // --- Sıradaki işi çalıştırır
     * @param callable(array<string, mixed>):void $handler
     * @return void
     */
    public function work(callable $handler): void
    {
        $this->db->beginTransaction();
        $statement = $this->db->query('SELECT * FROM jobs WHERE processed_at IS NULL ORDER BY id ASC LIMIT 1 FOR UPDATE');
        $job = $statement->fetch();

        if (!$job) {
            $this->db->rollBack();
            return;
        }

        try {
            $handler([
                'id' => (int) $job['id'],
                'type' => (string) $job['type'],
                'payload' => json_decode((string) $job['payload'], true) ?: [],
            ]);

            $update = $this->db->prepare('UPDATE jobs SET processed_at = NOW() WHERE id = :id');
            $update->bindValue(':id', $job['id']);
            $update->execute();
            $this->db->commit();
        } catch (Throwable $exception) {
            $this->db->rollBack();
            $this->logger->error('Job çalıştırma hatası', [
                'job_id' => $job['id'],
                'error' => $exception->getMessage(),
            ]);
        }
    }
}
