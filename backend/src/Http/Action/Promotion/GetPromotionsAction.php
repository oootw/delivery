<?php

declare(strict_types=1);

namespace App\Http\Action\Promotion;

use App\Application\Promotion\Query\GetPromotionsByWorkspaceId\GetPromotionsByWorkspaceIdFetcher;
use App\Application\Promotion\Query\GetPromotionsByWorkspaceId\GetPromotionsByWorkspaceIdQuery;
use App\Http\Response\ApiResponse;
use App\Http\Security\JwtUser;
use App\Shared\Service\LoggerService\LoggerService;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GetPromotionsAction extends AbstractController
{
    public function __construct(
        private readonly GetPromotionsByWorkspaceIdFetcher $getPromotions,
    ) {}

    #[Route('/workspaces/{workspaceId}/promotions', name: 'app_get_promotions', methods: ['GET'], requirements: ['workspaceId' => '\d+'])]
    public function handle(int $workspaceId): Response
    {
        try {
            /** @var JwtUser $user */
            $user = $this->getUser();

            $promotions = $this->getPromotions->fetch(
                new GetPromotionsByWorkspaceIdQuery(
                    userId: $user->claims->userId,
                    workspaceId: $workspaceId,
                ),
            );

            return ApiResponse::success(['promotions' => $promotions]);
        } catch (InvalidArgumentException | \DomainException $exception) {
            return ApiResponse::error($exception->getMessage());
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'promotion/list',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
