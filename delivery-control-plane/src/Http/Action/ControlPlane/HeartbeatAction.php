<?php

declare(strict_types=1);

namespace App\Http\Action\ControlPlane;

use App\Application\Server\Command\AcceptHeartbeat\AcceptHeartbeatCommand;
use App\Application\Server\Command\AcceptHeartbeat\AcceptHeartbeatHandler;
use App\Http\Response\ApiResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HeartbeatAction
{
    public function __construct(
        private readonly AcceptHeartbeatHandler $acceptHeartbeat,
    ) {}

    #[Route('/v1/heartbeat', name: 'cp_heartbeat', methods: ['POST'])]
    public function __invoke(Request $request): Response
    {
        try {
            $payload = $request->toArray();

            $result = $this->acceptHeartbeat->handle(new AcceptHeartbeatCommand(
                serverToken: trim((string) ($payload['server_token'] ?? '')),
                coreRef: trim((string) ($payload['core_ref'] ?? '')),
                contractVersion: trim((string) ($payload['contract_version'] ?? '')),
                healthStatus: trim((string) ($payload['health_status'] ?? 'ok')),
            ));

            if (!$result->accepted) {
                return ApiResponse::error('Heartbeat отклонён: сервер не найден', Response::HTTP_UNAUTHORIZED);
            }

            return ApiResponse::success([
                'accepted' => $result->accepted,
                'target_core_ref' => $result->targetCoreRef,
                'pinned' => $result->pinned,
            ]);
        } catch (\Throwable) {
            return ApiResponse::error('Не удалось обработать heartbeat', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

