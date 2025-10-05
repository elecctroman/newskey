<?php

namespace App\Services;

use App\Models\Payment;
use Core\Logger;

/**
 * // --- Shopier ödeme servisi
 */
class ShopierService
{
    private Logger $logger;
    private Payment $payments;
    private OrderFulfillmentService $fulfillment;

    public function __construct()
    {
        $this->logger = new Logger();
        $this->payments = new Payment();
        $this->fulfillment = new OrderFulfillmentService();
    }

    /**
     * // --- Ödeme isteği oluşturur
     * @param int $paymentId
     * @param float $amount
     * @return string
     */
    public function createPayment(int $paymentId, float $amount): string
    {
        $config = require __DIR__ . '/../../config/services.php';
        $hash = hash_hmac('sha256', $paymentId . $amount, (string) $config['shopier']['api_secret']);

        $this->payments->update($paymentId, [
            'hash_signature' => $hash,
        ]);

        return 'https://www.shopier.com/Pay?payment_id=' . $paymentId;
    }

    /**
     * // --- Callback doğrulama
     * @param array<string, mixed> $payload
     * @return bool
     */
    public function validateCallback(array $payload): bool
    {
        $config = require __DIR__ . '/../../config/services.php';
        $expected = hash_hmac('sha256', (string) ($payload['payment_id'] ?? ''), (string) $config['shopier']['api_secret']);
        return hash_equals($expected, (string) ($payload['hash'] ?? ''));
    }

    /**
     * // --- Callback işleme
     * @param array<string, mixed> $payload
     * @return void
     */
    public function handleCallback(array $payload): void
    {
        $paymentId = (int) ($payload['payment_id'] ?? 0);
        $status = ((string) ($payload['status'] ?? '')) === 'success' ? 'success' : 'failed';
        $this->payments->update($paymentId, [
            'status' => $status,
            'provider_response' => json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
        ]);

        $this->logger->info('Shopier callback işlendi', [
            'payment_id' => $paymentId,
            'status' => $status,
        ]);

        if ($status === 'success') {
            $payment = $this->payments->find($paymentId);
            if ($payment && isset($payment['order_id'])) {
                $this->fulfillment->fulfill((int) $payment['order_id']);
            }
        }
    }
}
