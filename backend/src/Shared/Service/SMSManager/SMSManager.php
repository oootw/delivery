<?php

declare(strict_types=1);

namespace App\Shared\Service\SMSManager;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class SMSManager
{
    public function __construct(
        private readonly string $apiKey,
        private readonly string $apiPhoneNumber,
        private readonly string $apiUrl,

        private readonly HttpClientInterface $httpClient,
    ) {}

    public function sendSMS(string $phone, string $message): void
    {
        $params = [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => $this->apiKey,
            ],
            'body' => json_encode([
                'number' => $this->apiPhoneNumber,
                'text' => $message,
                'destination' => $phone,
            ]),
        ];

        // TODO: Implement API request
        $response = $this->httpClient->request(
            method: 'POST',
            url: $this->apiUrl,
            options: $params,
        );

        $statusCode = $response->getStatusCode();

        if ($statusCode !== 200) {
            throw new \Exception('Ошибка при отправке SMS');
        }
    }
}
