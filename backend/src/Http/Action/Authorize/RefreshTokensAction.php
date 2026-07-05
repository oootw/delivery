<?php

declare(strict_types=1);

namespace App\Http\Action\Authorize;

use App\Application\Authorize\Command\CreateAuthorizeTokens\Command as CreateAuthorizeTokensCommand;
use App\Application\Authorize\Command\CreateAuthorizeTokens\Handler as CreateAuthorizeTokensHandler;
use App\Application\Authorize\Query\FindUserByPhone\Fetcher as FindUserByPhoneFetcher;
use App\Application\Authorize\Query\FindUserByPhone\Query as FindUserByPhoneQuery;
use App\Application\Authorize\Query\GetRefreshTokensAvailable\Fetcher as GetRefreshTokensAvailableFetcher;
use App\Application\Authorize\Query\GetRefreshTokensAvailable\Query as GetRefreshTokensAvailableQuery;
use App\Shared\Service\LoggerService\LoggerService;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Webmozart\Assert\Assert;

class RefreshTokensAction extends AbstractController
{
    public function __construct(
        private readonly GetRefreshTokensAvailableFetcher $getRefreshTokensAvailable,
        private readonly FindUserByPhoneFetcher $findUserByPhone,
        private readonly CreateAuthorizeTokensHandler $createAuthorizeTokens,
    ) {}

    #[Route('/refresh-tokens', name: 'app_refresh_tokens', methods: ['POST'])]
    public function handle(Request $request): Response
    {
        try {
            $body = $request->toArray();

            $refreshToken = $body['refreshToken'] ?? null;

            Assert::notEmpty($refreshToken, 'Рефреш токен не может быть пустым');

            $claims = $this->getRefreshTokensAvailable->fetch(
                new GetRefreshTokensAvailableQuery(refreshToken: $refreshToken),
            );

            $user = $this->findUserByPhone->fetch(
                new FindUserByPhoneQuery(phone: $claims->phone),
            );

            Assert::notNull($user, 'Пользователь не найден');

            $tokens = $this->createAuthorizeTokens->handle(
                new CreateAuthorizeTokensCommand(
                    phone: $claims->phone,
                    userId: $user->id,
                    sessionId: $claims->sessionId,
                    revokePreviousToken: true,
                ),
            );

            return $this->json([
                'is_success' => true,
                'access_token' => $tokens->accessToken,
                'refresh_token' => $tokens->refreshToken,
                'expires_in' => $tokens->expiresIn,
            ]);
        } catch (InvalidArgumentException $exception) {
            return $this->json([
                'is_success' => false,
                'error' => $exception->getMessage(),
            ], Response::HTTP_UNAUTHORIZED);
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'auth/refresh-tokens',
                message: $exception->getMessage(),
            );

            return $this->json([
                'is_success' => false,
                'error' => 'Что-то пошло не так',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
