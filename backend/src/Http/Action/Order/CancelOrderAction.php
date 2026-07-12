<?php

declare(strict_types=1);

namespace App\Http\Action\Order;

use App\Application\Order\Command\CancelOrder\CancelOrderCommand;
use App\Application\Order\Command\CancelOrder\CancelOrderHandler;
use App\Http\Response\ApiResponse;
use App\Http\Security\JwtUser;
use App\Shared\Service\LoggerService\LoggerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CancelOrderAction extends AbstractController
{
    public function __construct(
        private readonly CancelOrderHandler $cancelOrder,
    ) {}

    #[Route('/orders/{orderId}/cancel', name: 'app_cancel_order', methods: ['POST'], requirements: ['orderId' => '\d+'])]
    public function handle(int $orderId): Response
    {
        try {
            /** @var JwtUser $user */
            $user = $this->getUser();

            $this->cancelOrder->handle(
                new CancelOrderCommand(
                    orderId: $orderId,
                    customerId: $user->claims->userId,
                ),
            );

            return ApiResponse::success();
        } catch (\DomainException $exception) {
            return ApiResponse::error($exception->getMessage());
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'order/cancel',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
