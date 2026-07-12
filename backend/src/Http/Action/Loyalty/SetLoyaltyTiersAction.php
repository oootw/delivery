<?php

declare(strict_types=1);

namespace App\Http\Action\Loyalty;

use App\Application\Loyalty\Command\SetLoyaltyTiers\SetLoyaltyTiersCommand;
use App\Application\Loyalty\Command\SetLoyaltyTiers\SetLoyaltyTiersHandler;
use App\Http\Response\ApiResponse;
use App\Http\Security\JwtUser;
use App\Shared\Service\LoggerService\LoggerService;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Webmozart\Assert\Assert;

class SetLoyaltyTiersAction extends AbstractController
{
    public function __construct(
        private readonly SetLoyaltyTiersHandler $setLoyaltyTiers,
    ) {}

    #[Route('/workspaces/{workspaceId}/loyalty/tiers', name: 'app_set_loyalty_tiers', methods: ['PUT'], requirements: ['workspaceId' => '\d+'])]
    public function handle(Request $request, int $workspaceId): Response
    {
        try {
            $body = $request->toArray();
            $rawTiers = $body['tiers'] ?? null;

            Assert::isArray($rawTiers, 'Ожидается список уровней в поле tiers');

            $tiers = [];

            foreach ($rawTiers as $tier) {
                Assert::isArray($tier, 'Каждый уровень должен быть объектом');
                Assert::stringNotEmpty($tier['name'] ?? null, 'Укажите название уровня');
                Assert::integer($tier['threshold_kopecks'] ?? null, 'Порог уровня должен быть числом в копейках');
                Assert::integer($tier['earn_rate_bonus_basis_points'] ?? null, 'Прибавка к кэшбэку должна быть числом в базисных пунктах');
                Assert::integer($tier['permanent_discount_basis_points'] ?? null, 'Скидка уровня должна быть числом в базисных пунктах');

                $tiers[] = [
                    'name' => $tier['name'],
                    'threshold_kopecks' => $tier['threshold_kopecks'],
                    'earn_rate_bonus_basis_points' => $tier['earn_rate_bonus_basis_points'],
                    'permanent_discount_basis_points' => $tier['permanent_discount_basis_points'],
                    'sort_order' => $tier['sort_order'] ?? 0,
                ];
            }

            /** @var JwtUser $user */
            $user = $this->getUser();

            $this->setLoyaltyTiers->handle(
                new SetLoyaltyTiersCommand(
                    ownerId: $user->claims->userId,
                    workspaceId: $workspaceId,
                    tiers: $tiers,
                ),
            );

            return ApiResponse::success();
        } catch (InvalidArgumentException | \DomainException $exception) {
            return ApiResponse::error($exception->getMessage());
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'loyalty/set-tiers',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
