<?php

declare(strict_types=1);

namespace App\Http\Action\Authorize;

use App\Application\Authorize\Service\FindOrCreateUserByPhone;
use App\Application\Authorize\Service\IssueJwtToken;
use App\Http\Response\ApiResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class IssueTokenAction
{
    public function __construct(
        private readonly FindOrCreateUserByPhone $findOrCreateUserByPhone,
        private readonly IssueJwtToken $issueJwtToken,
    ) {}

    #[Route('/v1/auth/token', name: 'cp_issue_token', methods: ['POST'])]
    public function __invoke(Request $request): Response
    {
        try {
            $payload = $request->toArray();
            $phone = trim((string) ($payload['phone'] ?? ''));
            $name = trim((string) ($payload['name'] ?? ''));

            $user = $this->findOrCreateUserByPhone->findOrCreate($phone, $name);
            $token = $this->issueJwtToken->issue($user);

            return ApiResponse::success([
                'access_token' => $token,
                'user' => [
                    'id' => $user->id,
                    'phone' => $user->phone,
                    'name' => $user->name,
                    'is_admin' => $user->isAdmin,
                ],
            ]);
        } catch (\DomainException $exception) {
            return ApiResponse::error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (\Throwable) {
            return ApiResponse::error('Не удалось выпустить токен', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

