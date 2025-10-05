<?php

namespace Core;

use Closure;

/**
 * // --- HTTP yönlendirici
 */
class Router
{
    /**
     * @var array<string, array<int, array{pattern:string, callback:Closure}>>
     */
    protected array $routes = [];

    /**
     * // --- GET rotası ekler
     * @param string $path
     * @param Closure $action
     * @return void
     */
    public function get(string $path, Closure $action): void
    {
        $this->addRoute('GET', $path, $action);
    }

    /**
     * // --- POST rotası ekler
     * @param string $path
     * @param Closure $action
     * @return void
     */
    public function post(string $path, Closure $action): void
    {
        $this->addRoute('POST', $path, $action);
    }

    /**
     * // --- Rota kaydeder
     * @param string $method
     * @param string $path
     * @param Closure $action
     * @return void
     */
    protected function addRoute(string $method, string $path, Closure $action): void
    {
        $pattern = $this->buildPattern($path);
        $this->routes[$method][] = [
            'pattern' => $pattern,
            'callback' => $action,
        ];
    }

    /**
     * // --- Rotayı çalıştırır
     * @param Request $request
     * @return void
     */
    public function dispatch(Request $request): void
    {
        $method = $request->method();
        $path = $this->normalize($request->path());

        foreach ($this->routes[$method] ?? [] as $route) {
            if (preg_match($route['pattern'], $path)) {
                ($route['callback'])();
                return;
            }
        }

        (new Response())->setStatusCode(404);
        echo 'Sayfa bulunamadı';
    }

    /**
     * // --- Regex oluşturur
     * @param string $path
     * @return string
     */
    protected function buildPattern(string $path): string
    {
        $normalized = $this->normalize($path);
        $pattern = preg_replace('/\{[^}]+\}/', '([^/]+)', $normalized);
        return '#^' . $pattern . '$#';
    }

    /**
     * // --- Yol formatlar
     * @param string $path
     * @return string
     */
    protected function normalize(string $path): string
    {
        $trimmed = '/' . trim($path, '/');
        return $trimmed === '//' ? '/' : $trimmed;
    }
}
