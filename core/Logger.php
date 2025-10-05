<?php

namespace Core;

use DateTimeImmutable;

/**
 * // --- Basit günlükleyici
 */
class Logger
{
    /**
     * @param string $channel
     * @param array<string, mixed> $context
     * @return void
     */
    public function info(string $message, array $context = []): void
    {
        $this->write('INFO', $message, $context);
    }

    /**
     * @param string $message
     * @param array<string, mixed> $context
     * @return void
     */
    public function error(string $message, array $context = []): void
    {
        $this->write('ERROR', $message, $context);
    }

    /**
     * @param string $level
     * @param string $message
     * @param array<string, mixed> $context
     * @return void
     */
    protected function write(string $level, string $message, array $context): void
    {
        $dir = __DIR__ . '/../storage/logs';
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        $date = new DateTimeImmutable('now');
        $line = sprintf(
            "[%s] %s: %s %s\n",
            $date->format(DateTimeImmutable::ATOM),
            $level,
            $message,
            $context ? json_encode($context, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) : ''
        );

        file_put_contents($dir . '/app.log', $line, FILE_APPEND);
    }
}
