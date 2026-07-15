<?php

declare(strict_types=1);

namespace App\Http\Action\System;

use App\Application\License\Registry\ServerLicenseRegistryInterface;
use App\Shared\Enum\Feature\FeatureCodeEnum;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class GetLicenseAction
{
    public function __construct(
        private readonly ServerLicenseRegistryInterface $registry,
    ) {}

    #[Route('/v1/license', name: 'control_plane_license', methods: ['GET'])]
    public function __invoke(Request $request): JsonResponse
    {
        $serverToken = trim((string) $request->query->get('server_token', ''));
        if ($serverToken === '') {
            return new JsonResponse(
                ['error' => 'Не передан обязательный параметр server_token'],
                Response::HTTP_BAD_REQUEST,
            );
        }

        $record = $this->registry->findByToken($serverToken);
        if ($record === null) {
            return new JsonResponse(
                ['error' => 'Сервер не зарегистрирован или токен невалиден'],
                Response::HTTP_UNAUTHORIZED,
            );
        }

        return new JsonResponse([
            'tarif' => $record->tarifCode->value,
            'features' => array_map(
                static fn (FeatureCodeEnum $feature): string => $feature->value,
                $record->features,
            ),
            'status' => $record->status->value,
            'valid_until' => $record->validUntil?->format(\DateTimeInterface::ATOM),
        ]);
    }
}
