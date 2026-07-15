<?php

declare(strict_types=1);

namespace App\Http\Action\ControlPlane;

use App\Application\Server\Command\RegisterServer\RegisterServerCommand;
use App\Application\Server\Command\RegisterServer\RegisterServerHandler;
use App\Http\Response\ApiResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RegisterServerAction
{
    public function __construct(
        private readonly RegisterServerHandler $registerServer,
    ) {}

    #[Route('/v1/register', name: 'cp_register_server', methods: ['POST'])]
    public function __invoke(Request $request): Response
    {
        try {
            $payload = $request->toArray();

            $result = $this->registerServer->handle(new RegisterServerCommand(
                ownerSlug: trim((string) ($payload['owner_slug'] ?? '')),
                domain: trim((string) ($payload['domain'] ?? '')),
                coreRef: trim((string) ($payload['core_ref'] ?? '')),
                contractVersion: trim((string) ($payload['contract_version'] ?? '')),
            ));

            return ApiResponse::success([
                'owner_id' => $result->ownerId,
                'workspace_id' => $result->workspaceId,
                'server_token' => $result->serverToken,
            ], Response::HTTP_CREATED);
        } catch (\DomainException $exception) {
            return ApiResponse::error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (\Throwable) {
            return ApiResponse::error('Не удалось зарегистрировать сервер', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

