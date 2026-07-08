<?php

declare(strict_types=1);

namespace App\Http\Action\Workspace;

use App\Application\Workspace\Query\GetMyWorkspaces\Fetcher as GetMyWorkspacesFetcher;
use App\Application\Workspace\Query\GetMyWorkspaces\Query as GetMyWorkspacesQuery;
use App\Application\Workspace\Query\GetMyWorkspaces\WorkspaceDTO;
use App\Http\Response\ApiResponse;
use App\Http\Security\JwtUser;
use App\Shared\Service\LoggerService\LoggerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GetMyWorkspacesAction extends AbstractController
{
    public function __construct(
        private readonly GetMyWorkspacesFetcher $getMyWorkspaces,
    ) {}

    #[Route('/workspaces', name: 'app_get_my_workspaces', methods: ['GET'])]
    public function handle(Request $request): Response
    {
        try {
            /** @var JwtUser $user */
            $user = $this->getUser();

            $workspaces = $this->getMyWorkspaces->fetch(
                new GetMyWorkspacesQuery(userId: $user->claims->userId),
            );

            return ApiResponse::success([
                'workspaces' => array_map(
                    fn(WorkspaceDTO $workspace): array => [
                        'id' => $workspace->id,
                        'name' => $workspace->name,
                        'slug' => $workspace->slug,
                        'description' => $workspace->description,
                        'role' => $workspace->role,
                    ],
                    $workspaces,
                ),
            ]);
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'workspace/get-my',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
