<?php

declare(strict_types=1);

namespace App\Http\Action\Menu\Client;

use App\Application\Menu\Query\GetClientProductById\GetClientProductByIdFetcher;
use App\Application\Menu\Query\GetClientProductById\GetClientProductByIdQuery;
use App\Http\Response\ApiResponse;
use App\Http\Workspace\WorkspaceContext;
use App\Shared\Service\LoggerService\LoggerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GetClientProductAction extends AbstractController
{
    public function __construct(
        private readonly GetClientProductByIdFetcher $getClientProduct,
        private readonly WorkspaceContext $workspaceContext,
    ) {}

    #[Route(
        '/menu/venues/{venueId}/products/{itemId}',
        name: 'app_client_product',
        methods: ['GET'],
        requirements: ['venueId' => '\d+', 'itemId' => '\d+'],
    )]
    public function handle(int $venueId, int $itemId): Response
    {
        try {
            $product = $this->getClientProduct->fetch(
                new GetClientProductByIdQuery(
                    workspaceId: $this->workspaceContext->getWorkspaceId(),
                    venueId: $venueId,
                    itemId: $itemId,
                ),
            );

            return ApiResponse::success(['product' => $product]);
        } catch (\DomainException $exception) {
            return ApiResponse::error($exception->getMessage());
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'menu/client-product',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
