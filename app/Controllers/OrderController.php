<?php

namespace App\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Services\OrderRetryService;

/**
 * // --- Sipariş süreçleri
 */
class OrderController extends BaseController
{
    private Order $orders;
    private Product $products;
    private OrderRetryService $orderRetryService;

    public function __construct()
    {
        parent::__construct();
        $this->orders = new Order();
        $this->products = new Product();
        $this->orderRetryService = new OrderRetryService();
    }

    /**
     * // --- Sipariş oluşturma
     * @return void
     */
    public function store(): void
    {
        $this->validateCsrfOrAbort();
        $userId = (int) $this->session->get('user_id', 0);
        if ($userId === 0) {
            $this->response->redirect('/login');
            return;
        }

        $productId = (int) $this->request->input('product_id');
        $quantity = max(1, (int) $this->request->input('quantity', 1));

        $product = $this->products->find($productId);
        if (!$product) {
            $this->response->setStatusCode(404);
            echo 'Ürün bulunamadı';
            return;
        }

        $total = $quantity * (float) $product['price'];
        $orderId = $this->orders->create([
            'user_id' => $userId,
            'product_id' => $productId,
            'quantity' => $quantity,
            'total_amount' => $total,
            'status' => 'pending',
        ]);

        $this->logger->info('Sipariş oluşturuldu', ['order_id' => $orderId]);
        $this->response->redirect('/orders/' . $orderId);
    }

    /**
     * // --- Sipariş görüntüleme
     * @param int $orderId
     * @return void
     */
    public function show(int $orderId): void
    {
        $order = $this->orders->find($orderId);
        if (!$order) {
            $this->response->setStatusCode(404);
            echo 'Sipariş bulunamadı';
            return;
        }

        $this->render('orders/show', [
            'title' => 'Sipariş Detayı',
            'order' => $order,
        ]);
    }

    /**
     * // --- Siparişi yeniden dene
     * @param int $orderId
     * @return void
     */
    public function retry(int $orderId): void
    {
        $this->orderRetryService->retryOrder($orderId);
        $this->response->redirect('/admin/orders');
    }
}
