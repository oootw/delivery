<?php

declare(strict_types=1);

namespace App\Http\Action\Loyalty;

use App\Application\Loyalty\Query\GetLoyaltyAccount\Fetcher as GetLoyaltyAccountFetcher;
use App\Application\Loyalty\Query\GetLoyaltyAccount\Query as GetLoyaltyAccountQuery;
use App\Http\Response\ApiResponse;
use App\Http\Security\JwtUser;
use App\Shared\Service\LoggerService\LoggerService;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Webmozart\Assert\Assert;

class GetLoyaltyAccountAction extends AbstractController
{
    public function __construct(
        private readonly GetLoyaltyAccountFetcher $getLoyaltyAccount,
    ) {}

    #[Route('/loyalty/account', name: 'app_get_loyalty_account', methods: ['GET'])]
    public function handle(Request $request): Response
    {
        try {
            $workspaceId = $request->query->get('workspace_id');

            Assert::numeric($workspaceId, 'Укажите workspace_id');

            /** @var JwtUser $user */
            $user = $this->getUser();

            $account = $this->getLoyaltyAccount->fetch(
                new GetLoyaltyAccountQuery(
                    userId: $user->claims->userId,
                    workspaceId: (int) $workspaceId,
                ),
            );

            return ApiResponse::success(['loyalty' => $account]);
        } catch (InvalidArgumentException | \DomainException $exception) {
            return ApiResponse::error($exception->getMessage());
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'loyalty/account',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
