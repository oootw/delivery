<?php

declare(strict_types=1);

namespace App\Http\Action\Order;

use App\Application\Order\Query\GetVenueOrders\Fetcher as GetVenueOrdersFetcher;
use App\Application\Order\Query\GetVenueOrders\Query as GetVenueOrdersQuery;
use App\Http\Response\ApiResponse;
use App\Http\Security\JwtUser;
use App\Shared\Service\LoggerService\LoggerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GetVenueOrdersAction extends AbstractController
{
    public function __construct(
        private readonly GetVenueOrdersFetcher $getVenueOrders,
    ) {}

    #[Route('/venues/{venueId}/orders', name: 'app_get_venue_orders', methods: ['GET'], requirements: ['venueId' => '\d+'])]
    public function handle(Request $request, int $venueId): Response
    {
        try {
            /** @var JwtUser $user */
            $user = $this->getUser();

            $orders = $this->getVenueOrders->fetch(
                new GetVenueOrdersQuery(
                    venueId: $venueId,
                    userId: $user->claims->userId,
                    status: $request->query->get('status'),
                ),
            );

            return ApiResponse::success(['orders' => $orders]);
        } catch (\DomainException $exception) {
            return ApiResponse::error($exception->getMessage());
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'order/venue-list',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
