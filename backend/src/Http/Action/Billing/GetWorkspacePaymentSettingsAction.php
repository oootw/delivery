<?php

declare(strict_types=1);

namespace App\Http\Action\Billing;

use App\Application\Billing\Query\GetWorkspacePaymentSettings\GetWorkspacePaymentSettingsFetcher;
use App\Application\Billing\Query\GetWorkspacePaymentSettings\GetWorkspacePaymentSettingsQuery;
use App\Http\Response\ApiResponse;
use App\Http\Security\JwtUser;
use App\Shared\Service\LoggerService\LoggerService;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GetWorkspacePaymentSettingsAction extends AbstractController
{
    public function __construct(
        private readonly GetWorkspacePaymentSettingsFetcher $getPaymentSettings,
    ) {}

    #[Route('/workspaces/{workspaceId}/payment-settings', name: 'app_get_workspace_payment_settings', methods: ['GET'], requirements: ['workspaceId' => '\d+'])]
    public function handle(int $workspaceId): Response
    {
        try {
            /** @var JwtUser $user */
            $user = $this->getUser();

            $settings = $this->getPaymentSettings->fetch(
                new GetWorkspacePaymentSettingsQuery(
                    workspaceId: $workspaceId,
                    userId: $user->claims->userId,
                ),
            );

            return ApiResponse::success([
                'is_configured' => $settings !== null,
                'payment_settings' => $settings?->toArray(),
            ]);
        } catch (InvalidArgumentException | \DomainException $exception) {
            return ApiResponse::error($exception->getMessage());
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'billing/get-payment-settings',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
