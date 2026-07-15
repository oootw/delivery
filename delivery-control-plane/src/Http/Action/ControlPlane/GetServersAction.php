<?php

declare(strict_types=1);

namespace App\Http\Action\ControlPlane;

use App\Application\Server\Entity\RegisteredServer\RegisteredServerRepositoryInterface;
use App\Http\Response\ApiResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class GetServersAction
{
    public function __construct(
        private readonly RegisteredServerRepositoryInterface $servers,
        private readonly string $inventoryApiToken = '',
    ) {}

    #[Route('/v1/servers', name: 'cp_servers', methods: ['GET'])]
    public function __invoke(Request $request): Response
    {
        if (!$this->authorized($request)) {
            return ApiResponse::error('Недостаточно прав для чтения inventory', Response::HTTP_UNAUTHORIZED);
        }

        $servers = [];
        foreach ($this->servers->findAll() as $server) {
            $servers[] = [
                'hostname' => $server->ownerSlug,
                'ansible_host' => $server->domain,
                'group' => str_contains($server->domain, 'canary') ? 'canary' : 'production',
                'owner_slug' => $server->ownerSlug,
                'owner_id' => $server->ownerId,
                'workspace_id' => $server->workspaceId,
                'server_domain' => $server->domain,
                'pinned_ref' => $server->pinnedRef ?? '',
            ];
        }

        return ApiResponse::success([
            'servers' => $servers,
        ]);
    }

    private function authorized(Request $request): bool
    {
        if ($this->inventoryApiToken === '') {
            return true;
        }

        $header = trim((string) $request->headers->get('Authorization', ''));
        if (!str_starts_with($header, 'Bearer ')) {
            return false;
        }

        return hash_equals($this->inventoryApiToken, trim(substr($header, 7)));
    }
}

