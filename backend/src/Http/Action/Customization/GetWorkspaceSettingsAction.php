<?php

declare(strict_types=1);

namespace App\Http\Action\Customization;

use App\Application\Customization\Query\GetWorkspaceSettings\GetWorkspaceSettingsFetcher;
use App\Application\Customization\Query\GetWorkspaceSettings\GetWorkspaceSettingsQuery;
use App\Http\Response\ApiResponse;
use App\Http\Security\JwtUser;
use App\Shared\Service\LoggerService\LoggerService;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GetWorkspaceSettingsAction extends AbstractController
{
    public function __construct(
        private readonly GetWorkspaceSettingsFetcher $getWorkspaceSettings,
    ) {}

    #[Route('/workspaces/{workspaceId}/settings', name: 'app_get_workspace_settings', methods: ['GET'], requirements: ['workspaceId' => '\d+'])]
    public function handle(int $workspaceId): Response
    {
        try {
            /** @var JwtUser $user */
            $user = $this->getUser();

            $settings = $this->getWorkspaceSettings->fetch(
                new GetWorkspaceSettingsQuery(
                    userId: $user->claims->userId,
                    workspaceId: $workspaceId,
                ),
            );

            return ApiResponse::success(['settings' => $settings]);
        } catch (InvalidArgumentException | \DomainException $exception) {
            return ApiResponse::error($exception->getMessage());
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'customization/get-settings',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
