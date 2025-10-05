<?php

namespace App\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Services\IyzicoService;
use App\Services\PayTRService;
use App\Services\ShopierService;
use Core\Logger;

/**
 * // --- Ödeme entegrasyonları
 */
class PaymentController extends BaseController
{
    private Payment $payments;
    private Order $orders;
    private ShopierService $shopier;
    private IyzicoService $iyzico;
    private PayTRService $paytr;

    public function __construct()
    {
        parent::__construct();
        $this->payments = new Payment();
        $this->orders = new Order();
        $this->shopier = new ShopierService();
        $this->iyzico = new IyzicoService();
        $this->paytr = new PayTRService();
    }

    /**
     * // --- Shopier yönlendirmesi
     * @param int $orderId
     * @return void
     */
    public function shopier(int $orderId): void
    {
        $order = $this->orders->find($orderId);
        if (!$order) {
            $this->response->setStatusCode(404);
            echo 'Sipariş bulunamadı';
            return;
        }

        $paymentId = $this->payments->create([
            'order_id' => $orderId,
            'provider' => 'shopier',
            'status' => 'initiated',
            'amount' => (float) $order['total_amount'],
        ]);

        $redirectUrl = $this->shopier->createPayment((int) $paymentId, (float) $order['total_amount']);
        $this->response->redirect($redirectUrl);
    }

    /**
     * // --- Shopier callback
     * @return void
     */
    public function shopierCallback(): void
    {
        $payload = $this->request->body();
        if (!$this->shopier->validateCallback($payload)) {
            $this->logger->error('Shopier hash doğrulama başarısız', $payload);
            $this->response->setStatusCode(400);
            echo 'Geçersiz imza';
            return;
        }

        $this->shopier->handleCallback($payload);
    }

    /**
     * // --- İyzico callback
     * @return void
     */
    public function iyzicoCallback(): void
    {
        $payload = $this->request->json();
        $this->iyzico->handleWebhook($payload);
    }

    /**
     * // --- PayTR callback
     * @return void
     */
    public function paytrCallback(): void
    {
        $payload = $this->request->body();
        if (!$this->paytr->validateHash($payload)) {
            $this->response->setStatusCode(400);
            echo 'Geçersiz hash';
            return;
        }

        $this->paytr->handleNotification($payload);
    }
}
