<?php

declare(strict_types=1);

namespace App\Http\Action\Subscription;

use App\Application\Subscription\Command\StartSubscription\StartSubscriptionCommand;
use App\Application\Subscription\Command\StartSubscription\StartSubscriptionHandler;
use App\Http\Response\ApiResponse;
use App\Http\Security\JwtUser;
use App\Shared\Service\LoggerService\LoggerService;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Webmozart\Assert\Assert;

class StartSubscriptionAction extends AbstractController
{
    public function __construct(
        private readonly StartSubscriptionHandler $startSubscription,
        private readonly string $cloudPaymentsPublicId,
    ) {}

    #[Route('/subscriptions', name: 'app_start_subscription', methods: ['POST'])]
    public function handle(Request $request): Response
    {
        try {
            $body = $request->toArray();

            $tarifCode = $body['tarif_code'] ?? null;

            Assert::notEmpty($tarifCode, 'Укажите тариф');

            /** @var JwtUser $user */
            $user = $this->getUser();

            $startedSubscription = $this->startSubscription->handle(
                new StartSubscriptionCommand(
                    userId: $user->claims->userId,
                    tarifCode: $tarifCode,
                ),
            );

            return ApiResponse::success([
                'subscription_id' => $startedSubscription->subscriptionId,
                'payment' => [
                    'public_id' => $this->cloudPaymentsPublicId,
                    'invoice_id' => $startedSubscription->invoiceId,
                    'account_id' => $startedSubscription->accountId,
                    'amount' => $startedSubscription->amountRubles,
                    'currency' => $startedSubscription->currency,
                    'description' => 'Подписка на тариф ' . $startedSubscription->tarifName,
                ],
            ]);
        } catch (InvalidArgumentException | \DomainException $exception) {
            return ApiResponse::error($exception->getMessage());
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'subscription/start',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
