<?php

declare(strict_types=1);

namespace App\Http\Action\Billing;

use App\Application\Billing\Command\SetWorkspacePaymentSettings\SetWorkspacePaymentSettingsCommand;
use App\Application\Billing\Command\SetWorkspacePaymentSettings\SetWorkspacePaymentSettingsHandler;
use App\Http\Response\ApiResponse;
use App\Http\Security\JwtUser;
use App\Shared\Service\LoggerService\LoggerService;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Webmozart\Assert\Assert;

class SetWorkspacePaymentSettingsAction extends AbstractController
{
    public function __construct(
        private readonly SetWorkspacePaymentSettingsHandler $setPaymentSettings,
    ) {}

    #[Route('/workspaces/{workspaceId}/payment-settings', name: 'app_set_workspace_payment_settings', methods: ['PUT'], requirements: ['workspaceId' => '\d+'])]
    public function handle(Request $request, int $workspaceId): Response
    {
        try {
            $body = $request->toArray();

            $provider = $body['provider'] ?? null;
            $credentials = $body['credentials'] ?? [];

            Assert::stringNotEmpty($provider, 'Укажите платёжного провайдера');
            Assert::isArray($credentials, 'Креды оплаты должны быть объектом ключ-значение');

            /** @var JwtUser $user */
            $user = $this->getUser();

            $this->setPaymentSettings->handle(
                new SetWorkspacePaymentSettingsCommand(
                    ownerId: $user->claims->userId,
                    workspaceId: $workspaceId,
                    provider: $provider,
                    credentials: $credentials,
                    isActive: $body['is_active'] ?? false,
                ),
            );

            return ApiResponse::success();
        } catch (InvalidArgumentException | \DomainException $exception) {
            return ApiResponse::error($exception->getMessage());
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'billing/set-payment-settings',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
