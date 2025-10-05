<?php

namespace Core;

/**
 * // --- Görünüm motoru
 */
class View
{
    /**
     * @param string $path
     * @param array<string, mixed> $data
     * @return string
     */
    public function render(string $path, array $data = []): string
    {
        extract($data, EXTR_OVERWRITE);
        ob_start();
        require $path;
        return (string) ob_get_clean();
    }
}
