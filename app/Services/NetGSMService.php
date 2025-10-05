<?php

namespace App\Services;

use Core\Logger;
use Exception;

/**
 * // --- NetGSM SMS servisi
 */
class NetGSMService
{
    private Logger $logger;

    public function __construct()
    {
        $this->logger = new Logger();
    }

    /**
     * // --- SMS gönderir
     * @param string $phone
     * @param string $message
     * @return bool
     */
    public function sendSms(string $phone, string $message): bool
    {
        try {
            $this->logger->info('NetGSM SMS', ['phone' => $phone, 'message' => $message]);
            return true;
        } catch (Exception $exception) {
            $this->logger->error('NetGSM hata', ['error' => $exception->getMessage()]);
            return false;
        }
    }
}
