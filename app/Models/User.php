<?php

namespace App\Models;

use DateTimeImmutable;

/**
 * // --- Kullanıcı modeli
 */
class User extends BaseModel
{
    protected string $table = 'users';

    /**
     * // --- Kullanıcıyı e-posta ile bulur
     * @param string $email
     * @return array<string, mixed>|null
     */
    public function findByEmail(string $email): ?array
    {
        $statement = $this->db->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
        $statement->bindValue(':email', $email);
        $statement->execute();
        $user = $statement->fetch();

        return $user ?: null;
    }

    /**
     * // --- Kullanıcı bakiyesini günceller
     * @param int $id
     * @param float $amount
     * @return bool
     */
    public function adjustBalance(int $id, float $amount): bool
    {
        $statement = $this->db->prepare('UPDATE users SET balance = balance + :amount WHERE id = :id');
        $statement->bindValue(':amount', $amount);
        $statement->bindValue(':id', $id);
        return $statement->execute();
    }

    /**
     * // --- Şifre sıfırlama tokenı oluşturur
     * @param int $id
     * @param string $token
     * @return bool
     */
    public function createPasswordResetToken(int $id, string $token): bool
    {
        $statement = $this->db->prepare('INSERT INTO password_resets (user_id, token, expires_at) VALUES (:user_id, :token, :expires_at)');
        $statement->bindValue(':user_id', $id);
        $statement->bindValue(':token', $token);
        $statement->bindValue(':expires_at', (new DateTimeImmutable('+1 hour'))->format('Y-m-d H:i:s'));
        return $statement->execute();
    }
}
