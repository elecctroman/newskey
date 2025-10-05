<?php

namespace App\Services;

use App\Models\Payment;
use Core\Logger;

/**
 * // --- PayTR ödeme servisi
 */
class PayTRService
{
    private Payment $payments;
    private Logger $logger;
    private OrderFulfillmentService $fulfillment;

    public function __construct()
    {
        $this->payments = new Payment();
        $this->logger = new Logger();
        $this->fulfillment = new OrderFulfillmentService();
    }

    /**
     * // --- Hash doğrulama
     * @param array<string, mixed> $payload
     * @return bool
     */
    public function validateHash(array $payload): bool
    {
        $config = require __DIR__ . '/../../config/services.php';
        $hash = base64_encode(hash_hmac('sha256', (string) ($payload['merchant_oid'] ?? ''), (string) $config['paytr']['merchant_key'], true));
        return hash_equals($hash, (string) ($payload['hash'] ?? ''));
    }

    /**
     * // --- Bildirim işleme
     * @param array<string, mixed> $payload
     * @return void
     */
    public function handleNotification(array $payload): void
    {
        $paymentId = (int) ($payload['payment_id'] ?? 0);
        $status = ((string) ($payload['status'] ?? '')) === 'success' ? 'success' : 'failed';
        $this->payments->update($paymentId, [
            'status' => $status,
            'provider_response' => json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
        ]);

        $this->logger->info('PayTR bildirimi işlendi', [
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
