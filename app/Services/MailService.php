<?php

namespace App\Services;

use Core\Config;
use Throwable;

/**
 * // --- E-posta gönderim servisi
 */
class MailService
{
    /**
     * // --- Basit e-posta gönderimi
     * @param string $email
     * @param string $name
     * @param string $subject
     * @param string $body
     * @return void
     */
    public function send(string $email, string $name, string $subject, string $body): void
    {
        $config = Config::get('services.mail', []);

        if (class_exists(\PHPMailer\PHPMailer\PHPMailer::class)) {
            try {
                $this->sendWithPhpMailer($config, $email, $name, $subject, $body);
                return;
            } catch (Throwable) {
                // Sessizce düz e-posta yöntemine düş
            }
        }

        $this->sendPlain($config, $email, $subject, $body);
    }

    /**
     * // --- PHPMailer ile gönderim
     * @param array<string, mixed> $config
     * @param string $email
     * @param string $name
     * @param string $subject
     * @param string $body
     * @return void
     */
    private function sendWithPhpMailer(array $config, string $email, string $name, string $subject, string $body): void
    {
        $mailer = new \PHPMailer\PHPMailer\PHPMailer(true);
        $mailer->isSMTP();
        $mailer->Host = (string) ($config['host'] ?? '');
        $mailer->Port = (int) ($config['port'] ?? 25);
        $mailer->SMTPAuth = true;
        $mailer->Username = (string) ($config['username'] ?? '');
        $mailer->Password = (string) ($config['password'] ?? '');
        $from = (string) ($config['from'] ?? 'noreply@example.com');
        $mailer->setFrom($from, Config::get('app.name', 'NewsKey'));
        $mailer->addAddress($email, $name);
        $mailer->isHTML(true);
        $mailer->Subject = $subject;
        $mailer->Body = $body;
        $mailer->AltBody = strip_tags($body);
        $mailer->send();
    }

    /**
     * // --- mail() ile gönderim
     * @param array<string, mixed> $config
     * @param string $email
     * @param string $subject
     * @param string $body
     * @return void
     */
    private function sendPlain(array $config, string $email, string $subject, string $body): void
    {
        $from = (string) ($config['from'] ?? 'noreply@example.com');
        $headers = [
            'From: ' . $from,
            'Reply-To: ' . $from,
            'MIME-Version: 1.0',
            'Content-Type: text/html; charset=UTF-8',
        ];

        @mail($email, $subject, $body, implode("\r\n", $headers));
    }
}
