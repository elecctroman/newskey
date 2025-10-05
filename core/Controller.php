<?php

namespace Core;

/**
 * // --- Temel denetleyici sınıfı
 */
abstract class Controller
{
    protected Request $request;
    protected Response $response;
    protected Session $session;
    protected View $view;
    protected Security $security;
    protected string $layout = 'layouts/main';

    public function __construct()
    {
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->view = new View();
        $this->security = new Security($this->session);
    }

    /**
     * // --- Bir görünümü döndürür
     * @param string $view
     * @param array<string, mixed> $data
     * @return void
     */
    protected function render(string $view, array $data = []): void
    {
        $viewPath = __DIR__ . '/../app/Views/' . $view . '.php';
        $layoutPath = __DIR__ . '/../app/Views/' . $this->layout . '.php';

        if (!is_file($viewPath)) {
            throw new \RuntimeException('Görünüm bulunamadı: ' . $view);
        }

        $content = $this->view->render($viewPath, array_merge($data, [
            'request' => $this->request,
            'session' => $this->session,
            'security' => $this->security,
        ]));

        if (!is_file($layoutPath)) {
            echo $content;
            return;
        }

        echo $this->view->render($layoutPath, array_merge($data, [
            'content' => $content,
            'request' => $this->request,
            'session' => $this->session,
            'security' => $this->security,
        ]));
    }

    /**
     * // --- JSON yanıt döndürür
     * @param array<string, mixed> $data
     * @param int $status
     * @return void
     */
    protected function json(array $data, int $status = 200): void
    {
        $this->response->setStatusCode($status);
        $this->response->json($data);
    }
}
