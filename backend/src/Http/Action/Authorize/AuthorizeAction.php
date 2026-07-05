<?php

declare(strict_types=1);

namespace App\Http\Action\Authorize;

use App\Application\Authorize\Command\CheckOntimeCode\Command as CheckOntimeCodeCommand;
use App\Application\Authorize\Command\CheckOntimeCode\Handler as CheckOntimeCodeHandler;
use App\Application\Authorize\Command\CreateAuthorizeTokens\Command as CreateAuthorizeTokensCommand;
use App\Application\Authorize\Command\CreateAuthorizeTokens\Handler as CreateAuthorizeTokensHandler;
use App\Application\Authorize\Entity\Code\CodeTypeEnum;
use App\Application\Authorize\Query\FindUserByPhone\Fetcher;
use App\Application\Authorize\Query\FindUserByPhone\Query as FindUserByPhoneQuery;
use App\Shared\Service\LoggerService\LoggerService;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Webmozart\Assert\Assert;

class AuthorizeAction extends AbstractController
{
    public function __construct(
        private readonly Fetcher $findUserByPhone,
        private readonly CheckOntimeCodeHandler $checkOntimeCode,
        private readonly CreateAuthorizeTokensHandler $createAuthorizeTokens,
    ) {}

    #[Route('/', name: 'app_authorize', methods: ['POST'])]
    public function handle(Request $request): Response
    {
        try {
            $body = $request->toArray();

            $phone = $body['phone'] ?? null;
            $code = $body['code'] ?? null;

            Assert::notEmpty($phone, 'Укажите номер телефона');
            Assert::notEmpty($code, 'Укажите код');

            $user = $this->findUserByPhone->fetch(
                new FindUserByPhoneQuery(phone: $phone),
            );

            Assert::notNull($user, 'Пользователь не найден');

            $this->checkOntimeCode->handle(
                new CheckOntimeCodeCommand(
                    phone: $phone,
                    code: $code,
                    codeType: CodeTypeEnum::Authorize->value,
                ),
            );

            $tokens = $this->createAuthorizeTokens->handle(
                new CreateAuthorizeTokensCommand(
                    phone: $phone,
                    userId: $user->id,
                    sessionId: '',
                    revokePreviousToken: false,
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
            ], Response::HTTP_BAD_REQUEST);
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'auth/authorize',
                message: $exception->getMessage(),
            );

            return $this->json([
                'is_success' => false,
                'error' => 'Что-то пошло не так',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
