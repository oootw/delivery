<?php

declare(strict_types=1);

namespace App\Http\Action\Workspace;

use App\Application\Workspace\Command\AddStaffMember\AddStaffMemberCommand;
use App\Application\Workspace\Command\AddStaffMember\AddStaffMemberHandler;
use App\Http\Response\ApiResponse;
use App\Http\Security\JwtUser;
use App\Shared\Service\LoggerService\LoggerService;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Webmozart\Assert\Assert;

class AddStaffMemberAction extends AbstractController
{
    public function __construct(
        private readonly AddStaffMemberHandler $addStaffMember,
    ) {}

    #[Route('/workspaces/{workspaceId}/staff', name: 'app_add_staff_member', methods: ['POST'], requirements: ['workspaceId' => '\d+'])]
    public function handle(Request $request, int $workspaceId): Response
    {
        try {
            $body = $request->toArray();

            $phone = $body['phone'] ?? null;

            Assert::notEmpty($phone, 'Укажите номер телефона сотрудника');

            /** @var JwtUser $user */
            $user = $this->getUser();

            $this->addStaffMember->handle(
                new AddStaffMemberCommand(
                    ownerId: $user->claims->userId,
                    workspaceId: $workspaceId,
                    staffPhone: $phone,
                ),
            );

            return ApiResponse::success();
        } catch (InvalidArgumentException | \DomainException $exception) {
            return ApiResponse::error($exception->getMessage());
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'workspace/add-staff',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
