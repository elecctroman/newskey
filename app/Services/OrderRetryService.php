<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderRetry;
use App\Models\Product;
use Core\Logger;

/**
 * // --- Sipariş yeniden deneme servisi
 */
class OrderRetryService
{
    private Order $orders;
    private OrderRetry $retries;
    private Product $products;
    private SupplierManager $supplierManager;
    private Logger $logger;

    public function __construct()
    {
        $this->orders = new Order();
        $this->retries = new OrderRetry();
        $this->products = new Product();
        $this->supplierManager = new SupplierManager();
        $this->logger = new Logger();
    }

    /**
     * // --- Yeniden deneme başlatır
     * @param int $orderId
     * @return void
     */
    public function retryOrder(int $orderId): void
    {
        $order = $this->orders->find($orderId);
        if (!$order) {
            return;
        }

        $product = $this->products->find((int) $order['product_id']);
        if (!$product || empty($product['supplier'])) {
            return;
        }

        $retryId = $this->retries->create([
            'order_id' => $orderId,
            'status' => 'processing',
        ]);

        $result = $this->supplierManager->fulfill((string) $product['supplier'], [
            'order_id' => $orderId,
        ]);

        $status = ($result['success'] ?? false) ? 'success' : 'failed';
        $this->retries->update($retryId, [
            'status' => $status,
            'response' => json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
        ]);

        if ($status === 'success') {
            $this->orders->updateStatus($orderId, 'completed');
        }

        $this->logger->info('Sipariş yeniden deneme sonucu', [
            'order_id' => $orderId,
            'result' => $result,
        ]);
    }
}
