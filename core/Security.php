<?php

namespace Core;

/**
 * // --- Güvenlik yardımcıları
 */
class Security
{
    protected const CSRF_TOKEN_KEY = '_csrf_token';

    public function __construct(private Session $session)
    {
        $this->session->start();
    }

    /**
     * // --- CSRF token üretir
     * @return string
     */
    public function csrfToken(): string
    {
        $token = $this->session->get(self::CSRF_TOKEN_KEY);
        if (!$token) {
            $token = bin2hex(random_bytes(32));
            $this->session->set(self::CSRF_TOKEN_KEY, $token);
        }

        return $token;
    }

    /**
     * // --- CSRF token doğrular
     * @param string|null $token
     * @return bool
     */
    public function validateCsrf(?string $token): bool
    {
        $sessionToken = $this->session->get(self::CSRF_TOKEN_KEY);
        return is_string($token) && hash_equals((string) $sessionToken, $token);
    }

    /**
     * // --- HTML çıktısını temizler
     * @param string|null $value
     * @return string
     */
    public function e(?string $value): string
    {
        return htmlspecialchars($value ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}
