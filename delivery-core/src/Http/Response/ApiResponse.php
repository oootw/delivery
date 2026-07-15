<?php

declare(strict_types=1);

namespace App\Http\Response;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ApiResponse
{
    public static function success(array $data = [], int $status = Response::HTTP_OK): JsonResponse
    {
        return new JsonResponse(['is_success' => true, ...$data], $status);
    }

    public static function error(
        string $error,
        int $status = Response::HTTP_BAD_REQUEST,
        ?string $code = null,
    ): JsonResponse {
        $payload = ['is_success' => false, 'error' => $error];

        if ($code !== null) {
            $payload['code'] = $code;
        }

        return new JsonResponse($payload, $status);
    }
}

