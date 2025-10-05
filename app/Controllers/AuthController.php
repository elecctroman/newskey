<?php

namespace App\Controllers;

use App\Models\User;


/**
 * // --- Kimlik doğrulama işlemleri
 */
class AuthController extends BaseController
{
    private User $users;


    public function __construct()
    {
        parent::__construct();
        $this->users = new User();

    }

    /**
     * // --- Kayıt formu
     * @return void
     */
    public function showRegister(): void
    {
        $this->render('auth/register', [
            'title' => 'Kayıt Ol',
        ]);
    }

    /**
     * // --- Kayıt işlemi
     * @return void
     */
    public function register(): void
    {
        $this->validateCsrfOrAbort();

        $data = [
            'name' => $this->request->input('name'),
            'email' => $this->request->input('email'),
            'password' => password_hash((string) $this->request->input('password'), PASSWORD_BCRYPT),
            'role' => 'customer',
        ];

        $userId = $this->users->create($data);
        $this->session->set('user_id', $userId);
        $this->response->redirect('/');
    }

    /**
     * // --- Giriş formu
     * @return void
     */
    public function showLogin(): void
    {
        $this->render('auth/login', [
            'title' => 'Giriş Yap',
        ]);
    }

    /**
     * // --- Şifre sıfırlama formu
     * @return void
     */
    public function showForgotPassword(): void
    {
        $this->render('auth/forgot', [
            'title' => 'Şifre Sıfırlama',
        ]);
    }

    /**
     * // --- Giriş işlemi
     * @return void
     */
    public function login(): void
    {
        $this->validateCsrfOrAbort();

        $email = (string) $this->request->input('email');
        $password = (string) $this->request->input('password');

        $user = $this->users->findByEmail($email);
        if (!$user || !password_verify($password, (string) $user['password'])) {
            $this->logger->error('Başarısız giriş denemesi', ['email' => $email]);
            $this->response->setStatusCode(422);
            echo 'Geçersiz kimlik bilgileri';
            return;
        }

        $this->session->set('user_id', (int) $user['id']);
        $this->session->set('user_role', (string) $user['role']);
        $this->session->regenerate();

        $this->response->redirect('/');
    }

    /**
     * // --- Çıkış işlemi
     * @return void
     */
    public function logout(): void
    {
        session_destroy();
        $this->response->redirect('/');
    }

    /**
     * // --- Şifre sıfırlama isteği
     * @return void
     */
    public function forgotPassword(): void
    {
        $this->validateCsrfOrAbort();
        $email = (string) $this->request->input('email');
        $user = $this->users->findByEmail($email);

        if (!$user) {
            $this->response->redirect('/login');
            return;
        }

        $token = bin2hex(random_bytes(32));
        $this->users->createPasswordResetToken((int) $user['id'], $token);



        $this->response->redirect('/login');
    }
}
