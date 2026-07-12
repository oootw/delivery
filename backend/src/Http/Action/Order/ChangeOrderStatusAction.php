<?php

declare(strict_types=1);

namespace App\Http\Action\Order;

use App\Application\Order\Command\ChangeOrderStatus\ChangeOrderStatusCommand;
use App\Application\Order\Command\ChangeOrderStatus\ChangeOrderStatusHandler;
use App\Http\Response\ApiResponse;
use App\Http\Security\JwtUser;
use App\Shared\Service\LoggerService\LoggerService;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Webmozart\Assert\Assert;

class ChangeOrderStatusAction extends AbstractController
{
    public function __construct(
        private readonly ChangeOrderStatusHandler $changeOrderStatus,
    ) {}

    #[Route('/orders/{orderId}/status', name: 'app_change_order_status', methods: ['POST'], requirements: ['orderId' => '\d+'])]
    public function handle(Request $request, int $orderId): Response
    {
        try {
            $body = $request->toArray();

            $status = $body['status'] ?? null;

            Assert::notEmpty($status, 'Укажите новый статус');

            /** @var JwtUser $user */
            $user = $this->getUser();

            $this->changeOrderStatus->handle(
                new ChangeOrderStatusCommand(
                    orderId: $orderId,
                    actingUserId: $user->claims->userId,
                    newStatus: $status,
                ),
            );

            return ApiResponse::success();
        } catch (InvalidArgumentException | \DomainException $exception) {
            return ApiResponse::error($exception->getMessage());
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'order/change-status',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
