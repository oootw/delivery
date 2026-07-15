<?php

declare(strict_types=1);

namespace App\Http\Action\ControlPlane;

use App\Application\Release\Entity\CoreRelease\CoreReleaseRepositoryInterface;
use App\Http\Response\ApiResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class GetLatestReleaseAction
{
    public function __construct(
        private readonly CoreReleaseRepositoryInterface $releases,
    ) {}

    #[Route('/v1/release/latest', name: 'cp_latest_release', methods: ['GET'])]
    public function __invoke(): Response
    {
        $latest = $this->releases->findLatest();
        if ($latest === null) {
            return ApiResponse::error('Ещё нет зарегистрированных релизов', Response::HTTP_NOT_FOUND);
        }

        return ApiResponse::success([
            'ref' => $latest->ref,
            'contract_version' => $latest->contractVersion,
            'latest' => true,
        ]);
    }
}

