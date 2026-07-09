<?php

declare(strict_types=1);

namespace App\Http\Action\Loyalty;

use App\Application\Loyalty\Command\SetLoyaltyProgram\Command as SetLoyaltyProgramCommand;
use App\Application\Loyalty\Command\SetLoyaltyProgram\Handler as SetLoyaltyProgramHandler;
use App\Http\Response\ApiResponse;
use App\Http\Security\JwtUser;
use App\Shared\Service\LoggerService\LoggerService;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Webmozart\Assert\Assert;

class SetLoyaltyProgramAction extends AbstractController
{
    public function __construct(
        private readonly SetLoyaltyProgramHandler $setLoyaltyProgram,
    ) {}

    #[Route('/workspaces/{workspaceId}/loyalty/program', name: 'app_set_loyalty_program', methods: ['PUT'], requirements: ['workspaceId' => '\d+'])]
    public function handle(Request $request, int $workspaceId): Response
    {
        try {
            $body = $request->toArray();

            $earnRate = $body['earn_rate_basis_points'] ?? null;
            $pointValue = $body['point_value_kopecks'] ?? 100;
            $redeemMax = $body['redeem_max_percent_basis_points'] ?? null;

            Assert::integer($earnRate, 'Укажите процент кэшбэка в базисных пунктах');
            Assert::integer($pointValue, 'Курс балла должен быть числом в копейках');
            Assert::integer($redeemMax, 'Укажите лимит оплаты баллами в базисных пунктах');

            /** @var JwtUser $user */
            $user = $this->getUser();

            $this->setLoyaltyProgram->handle(
                new SetLoyaltyProgramCommand(
                    ownerId: $user->claims->userId,
                    workspaceId: $workspaceId,
                    isEnabled: $body['is_enabled'] ?? false,
                    earnRateBasisPoints: $earnRate,
                    pointValueKopecks: $pointValue,
                    redeemMaxPercentBasisPoints: $redeemMax,
                    pointsLifetimeDays: $body['points_lifetime_days'] ?? null,
                ),
            );

            return ApiResponse::success();
        } catch (InvalidArgumentException | \DomainException $exception) {
            return ApiResponse::error($exception->getMessage());
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'loyalty/set-program',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
