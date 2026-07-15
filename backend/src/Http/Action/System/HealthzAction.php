<?php

declare(strict_types=1);

namespace App\Http\Action\System;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class HealthzAction
{
    #[Route('/healthz', name: 'healthz', methods: ['GET'])]
    public function __invoke(): JsonResponse
    {
        $ref = (string) ($_SERVER['APP_GIT_SHA'] ?? $_ENV['APP_GIT_SHA'] ?? 'unknown');

        return new JsonResponse([
            'status' => 'ok',
            'ref' => $ref,
        ]);
    }
}
