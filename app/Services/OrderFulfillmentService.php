<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use Core\Logger;

/**
 * // --- Sipariş teslimat servisi
 */
class OrderFulfillmentService
{
    private Order $orders;
    private Product $products;
    private SupplierManager $supplierManager;
    private Logger $logger;

    public function __construct()
    {
        $this->orders = new Order();
        $this->products = new Product();
        $this->supplierManager = new SupplierManager();
        $this->logger = new Logger();
    }

    /**
     * // --- Ödemesi alınan siparişi tamamlar
     * @param int $orderId
     * @return void
     */
    public function fulfill(int $orderId): void
    {
        $order = $this->orders->find($orderId);
        if (!$order) {
            return;
        }

        $product = $this->products->find((int) $order['product_id']);
        if (!$product || !(int) ($product['auto_delivery'] ?? 0)) {
            return;
        }

        $supplier = (string) ($product['supplier'] ?? '');
        if ($supplier === '') {
            return;
        }

        $response = $this->supplierManager->fulfill($supplier, [
            'order_id' => $orderId,
            'product_id' => (int) $order['product_id'],
            'quantity' => (int) $order['quantity'],
        ]);

        if (($response['success'] ?? false) === true) {
            $this->orders->updateStatus($orderId, 'completed');
            $this->logger->info('Sipariş otomatik teslim edildi', [
                'order_id' => $orderId,
                'supplier' => $supplier,
            ]);
        } else {
            $this->logger->error('Sipariş teslimatı başarısız', [
                'order_id' => $orderId,
                'response' => $response,
            ]);
        }
    }
}
