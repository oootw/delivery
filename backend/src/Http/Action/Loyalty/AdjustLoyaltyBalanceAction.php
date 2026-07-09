<?php

declare(strict_types=1);

namespace App\Http\Action\Loyalty;

use App\Application\Loyalty\Command\AdjustLoyaltyBalance\Command as AdjustLoyaltyBalanceCommand;
use App\Application\Loyalty\Command\AdjustLoyaltyBalance\Handler as AdjustLoyaltyBalanceHandler;
use App\Http\Response\ApiResponse;
use App\Http\Security\JwtUser;
use App\Shared\Service\LoggerService\LoggerService;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Webmozart\Assert\Assert;

class AdjustLoyaltyBalanceAction extends AbstractController
{
    public function __construct(
        private readonly AdjustLoyaltyBalanceHandler $adjustLoyaltyBalance,
    ) {}

    #[Route('/workspaces/{workspaceId}/loyalty/adjust', name: 'app_adjust_loyalty_balance', methods: ['POST'], requirements: ['workspaceId' => '\d+'])]
    public function handle(Request $request, int $workspaceId): Response
    {
        try {
            $body = $request->toArray();

            $customerId = $body['customer_id'] ?? null;
            $deltaPoints = $body['delta_points'] ?? null;

            Assert::integer($customerId, 'Укажите гостя (customer_id)');
            Assert::integer($deltaPoints, 'Укажите изменение баллов (delta_points)');

            /** @var JwtUser $user */
            $user = $this->getUser();

            $this->adjustLoyaltyBalance->handle(
                new AdjustLoyaltyBalanceCommand(
                    ownerId: $user->claims->userId,
                    workspaceId: $workspaceId,
                    customerId: $customerId,
                    deltaPoints: $deltaPoints,
                    comment: $body['comment'] ?? null,
                ),
            );

            return ApiResponse::success();
        } catch (InvalidArgumentException | \DomainException $exception) {
            return ApiResponse::error($exception->getMessage());
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'loyalty/adjust',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
