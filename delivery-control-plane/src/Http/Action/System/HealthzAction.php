<?php

declare(strict_types=1);

namespace App\Http\Action\System;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class HealthzAction
{
    #[Route('/healthz', name: 'cp_healthz', methods: ['GET'])]
    public function __invoke(): JsonResponse
    {
        return new JsonResponse(['status' => 'ok']);
    }
}

