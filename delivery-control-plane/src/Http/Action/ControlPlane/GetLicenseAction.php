<?php

declare(strict_types=1);

namespace App\Http\Action\ControlPlane;

use App\Application\License\Service\ResolveLicenseByServerToken;
use App\Http\Response\ApiResponse;
use Delivery\Contracts\Enum\FeatureCodeEnum;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class GetLicenseAction
{
    public function __construct(
        private readonly ResolveLicenseByServerToken $resolveLicenseByServerToken,
    ) {}

    #[Route('/v1/license', name: 'cp_license', methods: ['GET'])]
    public function __invoke(Request $request): Response
    {
        $serverToken = trim((string) $request->query->get('server_token', ''));
        if ($serverToken === '') {
            return ApiResponse::error('Не передан обязательный параметр server_token');
        }

        $license = $this->resolveLicenseByServerToken->resolve($serverToken);
        if ($license === null) {
            return ApiResponse::error('Сервер не зарегистрирован или лицензия недоступна', Response::HTTP_UNAUTHORIZED);
        }

        return ApiResponse::success([
            'tarif' => $license->tarif->value,
            'features' => array_map(
                static fn (FeatureCodeEnum $feature): string => $feature->value,
                $license->features,
            ),
            'status' => $license->status->value,
            'valid_until' => $license->validUntil?->format(\DateTimeInterface::ATOM),
        ]);
    }
}

