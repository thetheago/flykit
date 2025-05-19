<?php

declare(strict_types=1);

namespace App\Service;

use App\Interfaces\NotificationServiceInterface;
use Hyperf\Guzzle\ClientFactory;
use Symfony\Component\HttpFoundation\Response;
use Exception;

class MailNotificationService implements NotificationServiceInterface
{
    public function __construct(
        protected ClientFactory $clientFactory
    ) {
    }

    public function sendNotification(string $email, string $subject, string $body): void
    {
        $client = $this->clientFactory->create();
        $response = $client->post('https://util.devi.tools/api/v1/notify', ['http_errors' => false]);

        if ($response->getStatusCode() !== Response::HTTP_NO_CONTENT) {
            throw new Exception('Failed to send notification');
        }
    }
}