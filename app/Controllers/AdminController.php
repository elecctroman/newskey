<?php

namespace App\Controllers;

use App\Models\Blog;
use App\Models\Order;
use App\Models\Product;
use App\Models\SupplierCredential;
use App\Models\User;


/**
 * // --- Yönetici paneli
 */
class AdminController extends BaseController
{
    private User $users;
    private Product $products;
    private Order $orders;
    private Blog $blogs;
    private SupplierCredential $credentials;

    public function __construct()
    {
        parent::__construct();
        $this->users = new User();
        $this->products = new Product();
        $this->orders = new Order();
        $this->blogs = new Blog();
        $this->credentials = new SupplierCredential();
    }

    /**
     * // --- Yönetici ana sayfası
     * @return void
     */
    public function dashboard(): void
    {
        $this->render('admin/dashboard', [
            'title' => 'Yönetici Paneli',
        ]);
    }

    /**
     * // --- API anahtarı kaydı
     * @return void
     */
    public function storeSupplierCredential(): void
    {
        $this->validateCsrfOrAbort();
        $supplier = (string) $this->request->input('supplier');
        $encryptedKey = $this->encryptSecret((string) $this->request->input('api_key'));
        $encryptedSecret = $this->encryptSecret((string) $this->request->input('api_secret'));

        $this->credentials->create([
            'supplier' => $supplier,
            'encrypted_key' => $encryptedKey,
            'encrypted_secret' => $encryptedSecret,
        ]);

        $this->response->redirect('/admin/api-keys');
    }

    /**
     * // --- API anahtarı formu
     * @return void
     */
    public function apiKeys(): void
    {
        $this->render('admin/api_keys', [
            'title' => 'API Anahtarları',
        ]);
    }

    /**
     * // --- Basit anahtar şifreleme
     * @param string $value
     * @return string
     */
    private function encryptSecret(string $value): string
    {

        $iv = random_bytes(16);
        $cipher = openssl_encrypt($value, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv) ?: '';

        return base64_encode($iv . $cipher);
    }

    /**
     * // --- Siparişleri listeler
     * @return void
     */
    public function orders(): void
    {
        $orders = $this->orders->where();
        $this->render('admin/orders', [
            'title' => 'Siparişler',
            'orders' => $orders,
        ]);
    }
}
