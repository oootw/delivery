<?php

declare(strict_types=1);

namespace App\Http\Action\Customization;

use App\Application\Customization\Command\SetWorkspaceSettings\SetWorkspaceSettingsCommand;
use App\Application\Customization\Command\SetWorkspaceSettings\SetWorkspaceSettingsHandler;
use App\Http\Response\ApiResponse;
use App\Http\Security\JwtUser;
use App\Shared\Service\LoggerService\LoggerService;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Webmozart\Assert\Assert;

class SetWorkspaceSettingsAction extends AbstractController
{
    public function __construct(
        private readonly SetWorkspaceSettingsHandler $setWorkspaceSettings,
    ) {}

    #[Route('/workspaces/{workspaceId}/settings', name: 'app_set_workspace_settings', methods: ['PUT'], requirements: ['workspaceId' => '\d+'])]
    public function handle(Request $request, int $workspaceId): Response
    {
        try {
            $body = $request->toArray();

            $values = $body['values'] ?? null;
            Assert::isArray($values, 'Передайте карту настроек в поле values');

            /** @var JwtUser $user */
            $user = $this->getUser();

            $this->setWorkspaceSettings->handle(
                new SetWorkspaceSettingsCommand(
                    ownerId: $user->claims->userId,
                    workspaceId: $workspaceId,
                    values: $values,
                ),
            );

            return ApiResponse::success();
        } catch (InvalidArgumentException | \DomainException $exception) {
            return ApiResponse::error($exception->getMessage());
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'customization/set-settings',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
