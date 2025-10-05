<?php

namespace App\Services;

use App\Models\Payment;
use Core\Logger;

/**
 * // --- İyzico ödeme servisi
 */
class IyzicoService
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
     * // --- Webhook işlemi
     * @param array<string, mixed> $payload
     * @return void
     */
    public function handleWebhook(array $payload): void
    {
        $paymentId = (int) ($payload['paymentId'] ?? 0);
        $status = ((string) ($payload['status'] ?? '')) === 'success' ? 'success' : 'failed';
        $this->payments->update($paymentId, [
            'status' => $status,
            'provider_response' => json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
        ]);

        $this->logger->info('İyzico webhook işlendi', [
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
