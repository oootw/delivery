<?php

declare(strict_types=1);

namespace App\Http\Action\Order;

use App\Application\Order\Query\GetOrdersByCustomerId\GetOrdersByCustomerIdFetcher;
use App\Application\Order\Query\GetOrdersByCustomerId\GetOrdersByCustomerIdQuery;
use App\Http\Response\ApiResponse;
use App\Http\Security\JwtUser;
use App\Shared\Service\LoggerService\LoggerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GetMyOrdersAction extends AbstractController
{
    public function __construct(
        private readonly GetOrdersByCustomerIdFetcher $getMyOrders,
    ) {}

    #[Route('/orders', name: 'app_get_my_orders', methods: ['GET'])]
    public function handle(): Response
    {
        try {
            /** @var JwtUser $user */
            $user = $this->getUser();

            $orders = $this->getMyOrders->fetch(
                new GetOrdersByCustomerIdQuery(
                    customerId: $user->claims->userId,
                ),
            );

            return ApiResponse::success(['orders' => $orders]);
        } catch (\DomainException $exception) {
            return ApiResponse::error($exception->getMessage());
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'order/my',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
