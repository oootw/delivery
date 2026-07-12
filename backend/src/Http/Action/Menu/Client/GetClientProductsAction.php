<?php

declare(strict_types=1);

namespace App\Http\Action\Menu\Client;

use App\Application\Menu\Query\GetClientProductsByCategoryId\GetClientProductsByCategoryIdFetcher;
use App\Application\Menu\Query\GetClientProductsByCategoryId\GetClientProductsByCategoryIdQuery;
use App\Http\Response\ApiResponse;
use App\Http\Workspace\WorkspaceContext;
use App\Shared\Service\LoggerService\LoggerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GetClientProductsAction extends AbstractController
{
    public function __construct(
        private readonly GetClientProductsByCategoryIdFetcher $getClientProducts,
        private readonly WorkspaceContext $workspaceContext,
    ) {}

    #[Route(
        '/menu/venues/{venueId}/categories/{categoryId}/products',
        name: 'app_client_products',
        methods: ['GET'],
        requirements: ['venueId' => '\d+', 'categoryId' => '\d+'],
    )]
    public function handle(int $venueId, int $categoryId): Response
    {
        try {
            $products = $this->getClientProducts->fetch(
                new GetClientProductsByCategoryIdQuery(
                    workspaceSlug: $this->workspaceContext->getSlug(),
                    venueId: $venueId,
                    categoryId: $categoryId,
                ),
            );

            return ApiResponse::success(['products' => $products]);
        } catch (\DomainException $exception) {
            return ApiResponse::error($exception->getMessage());
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'menu/client-products',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
