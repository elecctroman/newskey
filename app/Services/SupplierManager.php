<?php

namespace App\Services;

use App\Models\SupplierCredential;
use Core\Logger;

/**
 * // --- Tedarikçi yönetimi
 */
class SupplierManager
{
    private SupplierCredential $credentials;
    private Logger $logger;

    public function __construct()
    {
        $this->credentials = new SupplierCredential();
        $this->logger = new Logger();
    }

    /**
     * // --- Tedarikçi servisini döndürür
     * @param string $supplier
     * @return SupplierInterface|null
     */
    public function driver(string $supplier): ?SupplierInterface
    {
        $service = match ($supplier) {
            'turkpin' => new TurkPinService(),
            'pinabi' => new PinAbiService(),
            default => null,
        };

        if (!$service) {
            return null;
        }

        $credential = $this->credentials->findBySupplier($supplier);
        if ($credential) {
            $decoded = [
                'key' => $this->decryptSecret((string) $credential['encrypted_key']),
                'secret' => $this->decryptSecret((string) ($credential['encrypted_secret'] ?? '')),
            ];
            $service->configure($decoded);
        }

        return $service;
    }

    /**
     * // --- Siparişi tedarikçiye iletir
     * @param string $supplier
     * @param array<string, mixed> $orderData
     * @return array<string, mixed>
     */
    public function fulfill(string $supplier, array $orderData): array
    {
        $service = $this->driver($supplier);
        if (!$service) {
            $this->logger->error('Tedarikçi sürücüsü bulunamadı', ['supplier' => $supplier]);
            return ['success' => false, 'message' => 'Tedarikçi desteklenmiyor'];
        }

        return $service->createOrder($orderData);
    }

    /**
     * // --- Şifreli anahtarı çözer
     * @param string $payload
     * @return string
     */
    private function decryptSecret(string $payload): string
    {
        if ($payload === '') {
            return '';
        }

        $raw = base64_decode($payload, true);
        if ($raw === false || strlen($raw) < 16) {
            return '';
        }

        $iv = substr($raw, 0, 16);
        $cipherText = substr($raw, 16);
        $key = hash('sha256', (string) getenv('APP_KEY'), true);

        return openssl_decrypt($cipherText, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv) ?: '';
    }
}
