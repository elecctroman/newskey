<?php

namespace App\Services;

use App\Models\Epin;
use Core\Logger;
use Exception;

/**
 * // --- PinAbi tedarikçi entegrasyonu
 */
class PinAbiService implements SupplierInterface
{
    private Logger $logger;
    private Epin $epins;
    private array $credentials = [];

    public function __construct()
    {
        $this->logger = new Logger();
        $this->epins = new Epin();
    }

    /**
     * @inheritDoc
     */
    public function configure(array $credentials): void
    {
        $this->credentials = $credentials;
    }

    /**
     * @inheritDoc
     */
    public function createOrder(array $orderData): array
    {
        try {
            $this->logger->info('PinAbi sipariş isteği', $orderData + ['credentials' => array_keys($this->credentials)]);
            $response = [
                'success' => true,
                'code' => 'PINABI-' . random_int(10000, 99999),
            ];

            if ($response['success']) {
                $this->epins->create([
                    'order_id' => (int) $orderData['order_id'],
                    'code' => (string) $response['code'],
                    'supplier' => 'pinabi',
                ]);
            }

            return $response;
        } catch (Exception $exception) {
            $this->logger->error('PinAbi siparişi başarısız', [
                'error' => $exception->getMessage(),
            ]);
            return ['success' => false, 'message' => 'PinAbi hata'];
        }
    }

    /**
     * @inheritDoc
     */
    public function listProducts(): array
    {
        return [];
    }
}
