<?php

declare(strict_types=1);

namespace App\Http\Action\Subscription;

use App\Application\Subscription\Query\GetCurrentSubscriptionByUserId\GetCurrentSubscriptionByUserIdFetcher;
use App\Application\Subscription\Query\GetCurrentSubscriptionByUserId\GetCurrentSubscriptionByUserIdQuery;
use App\Http\Response\ApiResponse;
use App\Http\Security\JwtUser;
use App\Shared\Service\LoggerService\LoggerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GetSubscriptionAction extends AbstractController
{
    public function __construct(
        private readonly GetCurrentSubscriptionByUserIdFetcher $getCurrentSubscription,
    ) {}

    #[Route('/subscriptions/current', name: 'app_get_current_subscription', methods: ['GET'])]
    public function handle(Request $request): Response
    {
        try {
            /** @var JwtUser $user */
            $user = $this->getUser();

            $subscription = $this->getCurrentSubscription->fetch(
                new GetCurrentSubscriptionByUserIdQuery(userId: $user->claims->userId),
            );

            if ($subscription === null) {
                return ApiResponse::success(['subscription' => null]);
            }

            return ApiResponse::success([
                'subscription' => [
                    'id' => $subscription->id,
                    'tarif_code' => $subscription->tarifCode,
                    'status' => $subscription->status,
                    'is_active' => $subscription->isActive,
                    'current_period_end' => $subscription->currentPeriodEnd,
                ],
            ]);
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'subscription/get-current',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
