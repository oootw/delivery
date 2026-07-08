<?php

declare(strict_types=1);

namespace App\Http\Action\Order;

use App\Application\Order\Query\GetOrder\Fetcher as GetOrderFetcher;
use App\Application\Order\Query\GetOrder\Query as GetOrderQuery;
use App\Http\Response\ApiResponse;
use App\Http\Security\JwtUser;
use App\Shared\Service\LoggerService\LoggerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GetOrderAction extends AbstractController
{
    public function __construct(
        private readonly GetOrderFetcher $getOrder,
    ) {}

    #[Route('/orders/{orderId}', name: 'app_get_order', methods: ['GET'], requirements: ['orderId' => '\d+'])]
    public function handle(int $orderId): Response
    {
        try {
            /** @var JwtUser $user */
            $user = $this->getUser();

            $order = $this->getOrder->fetch(
                new GetOrderQuery(
                    orderId: $orderId,
                    userId: $user->claims->userId,
                ),
            );

            return ApiResponse::success(['order' => $order]);
        } catch (\DomainException $exception) {
            return ApiResponse::error($exception->getMessage());
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'order/get',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
