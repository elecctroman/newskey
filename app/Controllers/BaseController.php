<?php

namespace App\Controllers;

use Core\Controller;
use Core\Logger;
use Core\Security;
use Core\Session;
use Core\View;

/**
 * // --- Uygulama genel denetleyicisi
 */
abstract class BaseController extends Controller
{
    protected Logger $logger;

    public function __construct()
    {
        parent::__construct();
        $this->logger = new Logger();
    }

    /**
     * // --- CSRF doğrulaması
     * @return void
     */
    protected function validateCsrfOrAbort(): void
    {
        $token = $this->request->input('_token');
        if (!$this->security->validateCsrf($token)) {
            $this->response->setStatusCode(419);
            echo 'CSRF doğrulaması başarısız oldu.';
            exit;
        }
    }
}
