<?php

namespace App\Services;

    /**
     * // --- Tedarikçi servis arayüzü
     */
interface SupplierInterface
{
    /**
     * // --- Kimlik bilgilerini aktarır
     * @param array<string, mixed> $credentials
     * @return void
     */
    public function configure(array $credentials): void;

    /**
     * // --- Tedarikçi siparişi oluşturur
     * @param array<string, mixed> $orderData
     * @return array<string, mixed>
     */
    public function createOrder(array $orderData): array;

    /**
     * // --- Tedarikçi ürün listesini döndürür
     * @return array<int, array<string, mixed>>
     */
    public function listProducts(): array;
}
