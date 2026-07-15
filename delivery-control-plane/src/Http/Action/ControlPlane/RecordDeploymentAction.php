<?php

declare(strict_types=1);

namespace App\Http\Action\ControlPlane;

use App\Application\Deployment\Service\DeploymentAuditWriter;
use App\Http\Response\ApiResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RecordDeploymentAction
{
    public function __construct(
        private readonly DeploymentAuditWriter $deploymentAuditWriter,
        private readonly string $releaseWriteToken = '',
    ) {}

    #[Route('/v1/deployments', name: 'cp_record_deployment', methods: ['POST'])]
    public function __invoke(Request $request): Response
    {
        if (!$this->authorized($request)) {
            return ApiResponse::error('Недостаточно прав для записи аудита', Response::HTTP_UNAUTHORIZED);
        }

        try {
            $payload = $request->toArray();

            $kind = trim((string) ($payload['kind'] ?? 'rollout'));
            $releaseRef = trim((string) ($payload['release_ref'] ?? ''));
            $initiator = trim((string) ($payload['initiator'] ?? 'ci'));
            $targetHost = trim((string) ($payload['target_host'] ?? 'unknown'));
            $status = trim((string) ($payload['status'] ?? 'unknown'));

            if ($releaseRef === '') {
                return ApiResponse::error('release_ref не может быть пустым');
            }

            $this->deploymentAuditWriter->record(
                kind: $kind,
                releaseRef: $releaseRef,
                initiator: $initiator,
                targetHost: $targetHost,
                status: $status,
            );

            return ApiResponse::success([], Response::HTTP_CREATED);
        } catch (\Throwable) {
            return ApiResponse::error('Не удалось записать аудит раскатки', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function authorized(Request $request): bool
    {
        if ($this->releaseWriteToken === '') {
            return true;
        }

        $header = trim((string) $request->headers->get('Authorization', ''));
        if (!str_starts_with($header, 'Bearer ')) {
            return false;
        }

        return hash_equals($this->releaseWriteToken, trim(substr($header, 7)));
    }
}

