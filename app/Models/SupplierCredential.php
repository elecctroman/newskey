<?php

namespace App\Models;

/**
 * // --- Tedarikçi API kimlik bilgisi modeli
 */
class SupplierCredential extends BaseModel
{
    protected string $table = 'supplier_credentials';

    /**
     * // --- Tedarikçiyi ada göre döndürür
     * @param string $supplier
     * @return array<string, mixed>|null
     */
    public function findBySupplier(string $supplier): ?array
    {
        $result = $this->where(['supplier' => $supplier]);
        return $result[0] ?? null;
    }
}
