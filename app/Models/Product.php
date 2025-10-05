<?php

namespace App\Models;

/**
 * // --- Ürün modeli
 */
class Product extends BaseModel
{
    protected string $table = 'products';

    /**
     * // --- Otomatik teslim ürünleri döndürür
     * @return array<int, array<string, mixed>>
     */
    public function autoFulfillmentProducts(): array
    {
        return $this->where(['auto_delivery' => 1]);
    }
}
