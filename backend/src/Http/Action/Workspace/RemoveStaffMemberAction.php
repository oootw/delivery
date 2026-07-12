<?php

declare(strict_types=1);

namespace App\Http\Action\Workspace;

use App\Application\Workspace\Command\RemoveStaffMember\RemoveStaffMemberCommand;
use App\Application\Workspace\Command\RemoveStaffMember\RemoveStaffMemberHandler;
use App\Http\Response\ApiResponse;
use App\Http\Security\JwtUser;
use App\Shared\Service\LoggerService\LoggerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RemoveStaffMemberAction extends AbstractController
{
    public function __construct(
        private readonly RemoveStaffMemberHandler $removeStaffMember,
    ) {}

    #[Route('/workspaces/{workspaceId}/staff/{staffUserId}', name: 'app_remove_staff_member', methods: ['DELETE'], requirements: ['workspaceId' => '\d+', 'staffUserId' => '\d+'])]
    public function handle(int $workspaceId, int $staffUserId): Response
    {
        try {
            /** @var JwtUser $user */
            $user = $this->getUser();

            $this->removeStaffMember->handle(
                new RemoveStaffMemberCommand(
                    ownerId: $user->claims->userId,
                    workspaceId: $workspaceId,
                    staffUserId: $staffUserId,
                ),
            );

            return ApiResponse::success();
        } catch (\DomainException $exception) {
            return ApiResponse::error($exception->getMessage());
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'workspace/remove-staff',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
