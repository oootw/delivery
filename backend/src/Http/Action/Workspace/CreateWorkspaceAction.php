<?php

declare(strict_types=1);

namespace App\Http\Action\Workspace;

use App\Application\Workspace\Command\CreateWorkspace\Command as CreateWorkspaceCommand;
use App\Application\Workspace\Command\CreateWorkspace\Handler as CreateWorkspaceHandler;
use App\Http\Response\ApiResponse;
use App\Http\Security\JwtUser;
use App\Shared\Service\LoggerService\LoggerService;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Webmozart\Assert\Assert;

class CreateWorkspaceAction extends AbstractController
{
    private const ERROR_CODES = [
        'Требуется активная подписка' => 'SUBSCRIPTION_REQUIRED',
        'Достигнут лимит воркспейсов по тарифу' => 'WORKSPACE_LIMIT_REACHED',
        'Slug уже занят' => 'WORKSPACE_SLUG_TAKEN',
    ];

    public function __construct(
        private readonly CreateWorkspaceHandler $createWorkspace,
    ) {}

    #[Route('/workspaces', name: 'app_create_workspace', methods: ['POST'])]
    public function handle(Request $request): Response
    {
        try {
            $body = $request->toArray();

            $name = $body['name'] ?? null;
            $slug = $body['slug'] ?? null;
            $description = $body['description'] ?? '';

            Assert::notEmpty($name, 'Укажите название воркспейса');
            Assert::notEmpty($slug, 'Укажите slug воркспейса');

            /** @var JwtUser $user */
            $user = $this->getUser();

            $createdWorkspace = $this->createWorkspace->handle(
                new CreateWorkspaceCommand(
                    ownerId: $user->claims->userId,
                    name: $name,
                    slug: $slug,
                    description: $description,
                ),
            );

            return ApiResponse::success([
                'workspace' => [
                    'id' => $createdWorkspace->id,
                    'slug' => $createdWorkspace->slug,
                ],
            ]);
        } catch (InvalidArgumentException | \DomainException $exception) {
            return ApiResponse::error(
                error: $exception->getMessage(),
                code: self::ERROR_CODES[$exception->getMessage()] ?? null,
            );
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'workspace/create',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
