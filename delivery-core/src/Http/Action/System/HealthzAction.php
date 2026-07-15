<?php

declare(strict_types=1);

namespace App\Http\Action\System;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class HealthzAction
{
    public function __construct(
        private readonly string $coreRef,
    ) {}

    #[Route('/healthz', name: 'healthz', methods: ['GET'])]
    public function __invoke(): JsonResponse
    {
        return new JsonResponse([
            'status' => 'ok',
            'ref' => $this->coreRef,
        ]);
    }
}

