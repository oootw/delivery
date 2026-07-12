<?php

declare(strict_types=1);

namespace App\Http\Action\Customization;

use App\Application\Customization\Command\AssignCustomRole\AssignCustomRoleCommand;
use App\Application\Customization\Command\AssignCustomRole\AssignCustomRoleHandler;
use App\Http\Response\ApiResponse;
use App\Http\Security\JwtUser;
use App\Shared\Service\LoggerService\LoggerService;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Webmozart\Assert\Assert;

class AssignCustomRoleAction extends AbstractController
{
    public function __construct(
        private readonly AssignCustomRoleHandler $assignCustomRole,
    ) {}

    #[Route('/workspaces/{workspaceId}/custom-roles', name: 'app_assign_custom_role', methods: ['POST'], requirements: ['workspaceId' => '\d+'])]
    public function handle(Request $request, int $workspaceId): Response
    {
        try {
            $body = $request->toArray();

            $targetUserId = $body['user_id'] ?? null;
            $roleKey = $body['role_key'] ?? null;

            Assert::integer($targetUserId, 'Укажите user_id участника');
            Assert::stringNotEmpty($roleKey, 'Укажите role_key');

            /** @var JwtUser $user */
            $user = $this->getUser();

            $this->assignCustomRole->handle(
                new AssignCustomRoleCommand(
                    ownerId: $user->claims->userId,
                    workspaceId: $workspaceId,
                    targetUserId: $targetUserId,
                    roleKey: $roleKey,
                ),
            );

            return ApiResponse::success();
        } catch (InvalidArgumentException | \DomainException $exception) {
            return ApiResponse::error($exception->getMessage());
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'customization/assign-role',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
