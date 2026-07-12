<?php

declare(strict_types=1);

namespace App\Http\Action\Customization;

use App\Application\Customization\Command\RevokeCustomRole\RevokeCustomRoleCommand;
use App\Application\Customization\Command\RevokeCustomRole\RevokeCustomRoleHandler;
use App\Http\Response\ApiResponse;
use App\Http\Security\JwtUser;
use App\Shared\Service\LoggerService\LoggerService;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RevokeCustomRoleAction extends AbstractController
{
    public function __construct(
        private readonly RevokeCustomRoleHandler $revokeCustomRole,
    ) {}

    #[Route(
        '/workspaces/{workspaceId}/members/{userId}/custom-roles/{roleKey}',
        name: 'app_revoke_custom_role',
        methods: ['DELETE'],
        requirements: ['workspaceId' => '\d+', 'userId' => '\d+', 'roleKey' => '[a-zA-Z0-9._-]+'],
    )]
    public function handle(int $workspaceId, int $userId, string $roleKey): Response
    {
        try {
            /** @var JwtUser $user */
            $user = $this->getUser();

            $this->revokeCustomRole->handle(
                new RevokeCustomRoleCommand(
                    ownerId: $user->claims->userId,
                    workspaceId: $workspaceId,
                    targetUserId: $userId,
                    roleKey: $roleKey,
                ),
            );

            return ApiResponse::success();
        } catch (InvalidArgumentException | \DomainException $exception) {
            return ApiResponse::error($exception->getMessage());
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'customization/revoke-role',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
