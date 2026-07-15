<?php

declare(strict_types=1);

namespace App\Tests\Functional\System;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class HealthzActionTest extends WebTestCase
{
    public function testHealthzIsPublicAndReturnsStatusWithRef(): void
    {
        $client = static::createClient();
        $client->request('GET', '/healthz');

        self::assertResponseStatusCodeSame(200);

        /** @var array<string, string> $payload */
        $payload = json_decode((string) $client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);
        self::assertSame(
            [
                'status' => 'ok',
                'ref' => 'dev',
            ],
            $payload,
        );
    }

    public function testHealthzIsNotMountedUnderApiV1(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/v1/healthz');

        self::assertResponseStatusCodeSame(404);
    }
}
