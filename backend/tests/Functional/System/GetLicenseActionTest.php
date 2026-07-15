<?php

declare(strict_types=1);

namespace App\Tests\Functional\System;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class GetLicenseActionTest extends WebTestCase
{
    public function testReturnsLicenseByServerToken(): void
    {
        $client = static::createClient();
        $client->request('GET', '/v1/license?server_token=test-server-token');

        self::assertResponseStatusCodeSame(200);

        /** @var array{tarif: string, features: list<string>, status: string, valid_until: string|null} $payload */
        $payload = json_decode((string) $client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);

        self::assertSame('pro', $payload['tarif']);
        self::assertSame('active', $payload['status']);
        self::assertSame(
            ['points', 'crm', 'analytics', 'support'],
            $payload['features'],
        );
        self::assertNotNull($payload['valid_until']);
    }

    public function testReturnsBadRequestWhenTokenIsMissing(): void
    {
        $client = static::createClient();
        $client->request('GET', '/v1/license');

        self::assertResponseStatusCodeSame(400);
    }

    public function testReturnsUnauthorizedForUnknownToken(): void
    {
        $client = static::createClient();
        $client->request('GET', '/v1/license?server_token=unknown');

        self::assertResponseStatusCodeSame(401);
    }
}
