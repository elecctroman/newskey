<?php

namespace Core;

/**
 * // --- HTTP istek sınıfı
 */
class Request
{
    /**
     * @return string
     */
    public function method(): string
    {
        return strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
    }

    /**
     * @return string
     */
    public function path(): string
    {
        $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
        return rtrim($path ?: '/', '/') ?: '/';
    }

    /**
     * @return array<string, mixed>
     */
    public function query(): array
    {
        return filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?: [];
    }

    /**
     * @return array<string, mixed>
     */
    public function body(): array
    {
        $data = [];
        if ($this->method() === 'GET') {
            return $this->query();
        }

        foreach ($_POST as $key => $value) {
            $data[$key] = is_array($value)
                ? filter_var_array($value, FILTER_SANITIZE_FULL_SPECIAL_CHARS)
                : filter_var($value, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        }

        return $data;
    }

    /**
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    public function input(string $key, mixed $default = null): mixed
    {
        $body = $this->body();
        return $body[$key] ?? $default;
    }

    /**
     * @return array<string, mixed>
     */
    public function json(): array
    {
        $content = file_get_contents('php://input');
        $decoded = json_decode($content ?: '[]', true);
        return is_array($decoded) ? $decoded : [];
    }
}
