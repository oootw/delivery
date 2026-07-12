<?php

declare(strict_types=1);

namespace App\Http\Action\Menu;

use App\Application\Menu\Query\GetMenuByVenueId\GetMenuByVenueIdFetcher;
use App\Application\Menu\Query\GetMenuByVenueId\GetMenuByVenueIdQuery;
use App\Http\Response\ApiResponse;
use App\Http\Security\JwtUser;
use App\Shared\Service\LoggerService\LoggerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GetMenuAction extends AbstractController
{
    public function __construct(
        private readonly GetMenuByVenueIdFetcher $getMenu,
    ) {}

    #[Route('/venues/{venueId}/menu', name: 'app_get_menu', methods: ['GET'], requirements: ['venueId' => '\d+'])]
    public function handle(int $venueId): Response
    {
        try {
            /** @var JwtUser $user */
            $user = $this->getUser();

            $menu = $this->getMenu->fetch(
                new GetMenuByVenueIdQuery(
                    userId: $user->claims->userId,
                    venueId: $venueId,
                ),
            );

            return ApiResponse::success($menu);
        } catch (\DomainException $exception) {
            return ApiResponse::error($exception->getMessage());
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'menu/get',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
