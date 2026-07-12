<?php

declare(strict_types=1);

namespace App\Http\Action\Loyalty;

use App\Application\Loyalty\Query\GetLoyaltyHistoryByCustomerId\GetLoyaltyHistoryByCustomerIdFetcher;
use App\Application\Loyalty\Query\GetLoyaltyHistoryByCustomerId\GetLoyaltyHistoryByCustomerIdQuery;
use App\Http\Response\ApiResponse;
use App\Http\Security\JwtUser;
use App\Shared\Service\LoggerService\LoggerService;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Webmozart\Assert\Assert;

class GetLoyaltyHistoryAction extends AbstractController
{
    public function __construct(
        private readonly GetLoyaltyHistoryByCustomerIdFetcher $getLoyaltyHistory,
    ) {}

    #[Route('/loyalty/history', name: 'app_get_loyalty_history', methods: ['GET'])]
    public function handle(Request $request): Response
    {
        try {
            $workspaceId = $request->query->get('workspace_id');

            Assert::numeric($workspaceId, 'Укажите workspace_id');

            /** @var JwtUser $user */
            $user = $this->getUser();

            $history = $this->getLoyaltyHistory->fetch(
                new GetLoyaltyHistoryByCustomerIdQuery(
                    userId: $user->claims->userId,
                    workspaceId: (int) $workspaceId,
                    limit: (int) $request->query->get('limit', '50'),
                ),
            );

            return ApiResponse::success(['history' => $history]);
        } catch (InvalidArgumentException | \DomainException $exception) {
            return ApiResponse::error($exception->getMessage());
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'loyalty/history',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
