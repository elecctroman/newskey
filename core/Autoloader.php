<?php

namespace Core;

/**
 * // --- Basit PSR-4 otomatik yükleyici
 */
class Autoloader
{
    /**
     * @var array<string, string>
     */
    protected array $prefixes = [];

    /**
     * // --- Sınıf ön eklerini kaydeder
     * @param string $prefix
     * @param string $baseDir
     * @return void
     */
    public function addNamespace(string $prefix, string $baseDir): void
    {
        $prefix = trim($prefix, '\\') . '\\';
        $baseDir = rtrim($baseDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        $this->prefixes[$prefix] = $baseDir;
    }

    /**
     * // --- Otomatik yükleyiciyi SPL ile kaydeder
     * @return void
     */
    public function register(): void
    {
        spl_autoload_register([$this, 'loadClass']);
    }

    /**
     * // --- İstenen sınıfı yükler
     * @param string $class
     * @return void
     */
    public function loadClass(string $class): void
    {
        foreach ($this->prefixes as $prefix => $baseDir) {
            if (str_starts_with($class, $prefix)) {
                $relativeClass = substr($class, strlen($prefix));
                $file = $baseDir . str_replace('\\', DIRECTORY_SEPARATOR, $relativeClass) . '.php';

                if (is_file($file)) {
                    require_once $file;
                }
            }
        }
    }
}
