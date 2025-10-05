<?php

namespace Core;

/**
 * // --- Oturum yöneticisi
 */
class Session
{
    /**
     * // --- Oturumu başlatır
     * @return void
     */
    public function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    public function get(string $key, mixed $default = null): mixed
    {
        return $_SESSION[$key] ?? $default;
    }

    /**
     * @param string $key
     * @return void
     */
    public function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    /**
     * @return void
     */
    public function regenerate(): void
    {
        session_regenerate_id(true);
    }
}
