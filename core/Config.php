<?php

namespace Core;

/**
 * // --- Konfigürasyon yönetimi
 */
class Config
{
    /**
     * @var array<string, mixed>|null
     */
    private static ?array $config = null;

    /**
     * // --- Belirtilen anahtar için yapılandırma değerini döndürür
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        $config = self::load();
        $segments = explode('.', $key);
        $value = $config;

        foreach ($segments as $segment) {
            if (!is_array($value) || !array_key_exists($segment, $value)) {
                return $default;
            }
            $value = $value[$segment];
        }

        return $value;
    }

    /**
     * // --- Tüm yapılandırma değerlerini döndürür
     * @return array<string, mixed>
     */
    public static function all(): array
    {
        return self::load();
    }

    /**
     * // --- Yapılandırma dosyasını yükler
     * @return array<string, mixed>
     */
    private static function load(): array
    {
        if (self::$config !== null) {
            return self::$config;
        }

        $path = __DIR__ . '/../config/config.php';
        if (!is_file($path)) {
            throw new \RuntimeException('Konfigürasyon dosyası bulunamadı. Lütfen config/config.php dosyasını oluşturun.');
        }

        $config = require $path;
        if (!is_array($config)) {
            throw new \RuntimeException('Konfigürasyon dosyası geçersiz.');
        }

        self::$config = $config;

        return self::$config;
    }
}
