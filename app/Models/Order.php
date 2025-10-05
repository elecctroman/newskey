<?php

namespace App\Models;

/**
 * // --- Sipariş modeli
 */
class Order extends BaseModel
{
    protected string $table = 'orders';

    /**
     * // --- Sipariş durumunu günceller
     * @param int $orderId
     * @param string $status
     * @return bool
     */
    public function updateStatus(int $orderId, string $status): bool
    {
        return $this->update($orderId, ['status' => $status]);
    }
}
