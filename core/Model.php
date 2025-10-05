<?php

namespace Core;

use PDO;

/**
 * // --- Temel model sınıfı
 */
abstract class Model
{
    protected PDO $db;
    protected string $table;
    protected string $primaryKey = 'id';

    public function __construct()
    {
        $config = require __DIR__ . '/../config/database.php';
        $this->db = Database::connection($config);
        $this->boot();
    }

    /**
     * // --- Model başlangıç kancası
     * @return void
     */
    protected function boot(): void
    {
        // --- Alt sınıflar gerekirse geçersiz kılar
    }

    /**
     * // --- Bir kaydı ID ile bulur
     * @param int $id
     * @return array<string, mixed>|null
     */
    public function find(int $id): ?array
    {
        $statement = $this->db->prepare("SELECT * FROM \{$this->table} WHERE \{$this->primaryKey} = :id LIMIT 1");
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetch();

        return $result ?: null;
    }

    /**
     * // --- Koşula göre kayıtları döndürür
     * @param array<string, mixed> $conditions
     * @return array<int, array<string, mixed>>
     */
    public function where(array $conditions = []): array
    {
        $sql = "SELECT * FROM \{$this->table}";
        if ($conditions) {
            $clauses = [];
            foreach ($conditions as $key => $value) {
                $clauses[] = "$key = :$key";
            }
            $sql .= ' WHERE ' . implode(' AND ', $clauses);
        }

        $statement = $this->db->prepare($sql);
        foreach ($conditions as $key => $value) {
            $statement->bindValue(':' . $key, $value);
        }
        $statement->execute();

        return $statement->fetchAll() ?: [];
    }

    /**
     * // --- Yeni kayıt oluşturur
     * @param array<string, mixed> $data
     * @return int
     */
    public function create(array $data): int
    {
        $columns = array_keys($data);
        $placeholders = array_map(fn(string $column) => ':' . $column, $columns);
        $sql = sprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
            $this->table,
            implode(', ', $columns),
            implode(', ', $placeholders)
        );

        $statement = $this->db->prepare($sql);
        foreach ($data as $key => $value) {
            $statement->bindValue(':' . $key, $value);
        }
        $statement->execute();

        return (int) $this->db->lastInsertId();
    }

    /**
     * // --- Kaydı günceller
     * @param int $id
     * @param array<string, mixed> $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        $assignments = [];
        foreach ($data as $key => $value) {
            $assignments[] = "$key = :$key";
        }

        $sql = sprintf(
            'UPDATE %s SET %s WHERE %s = :id',
            $this->table,
            implode(', ', $assignments),
            $this->primaryKey
        );

        $statement = $this->db->prepare($sql);
        foreach ($data as $key => $value) {
            $statement->bindValue(':' . $key, $value);
        }
        $statement->bindValue(':id', $id, PDO::PARAM_INT);

        return $statement->execute();
    }

    /**
     * // --- Kaydı siler
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $statement = $this->db->prepare("DELETE FROM \{$this->table} WHERE \{$this->primaryKey} = :id");
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        return $statement->execute();
    }
}
