<?php

declare(strict_types=1);

namespace App\Http\Action\Authorize;

use App\Application\Authorize\Command\CreateAuthorizeTokens\CreateAuthorizeTokensCommand;
use App\Application\Authorize\Command\CreateAuthorizeTokens\CreateAuthorizeTokensHandler;
use App\Application\Authorize\Command\CreateUser\CreateUserCommand;
use App\Application\Authorize\Command\CreateUser\CreateUserHandler;
use App\Application\Authorize\Query\FindUserByPhone\FindUserByPhoneFetcher;
use App\Application\Authorize\Query\FindUserByPhone\FindUserByPhoneQuery;
use App\Http\Response\ApiResponse;
use App\Shared\Service\LoggerService\LoggerService;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Webmozart\Assert\Assert;

class SignUpAction extends AbstractController
{
    public function __construct(
        private readonly FindUserByPhoneFetcher $findUserByPhone,
        private readonly CreateUserHandler $createUser,
        private readonly CreateAuthorizeTokensHandler $createAuthorizeTokens,
    ) {}

    #[Route('/sign-up', name: 'app_sign_up', methods: ['POST'])]
    public function handle(Request $request): Response
    {
        try {
            $body = $request->toArray();

            $phone = $body['phone'] ?? null;

            Assert::notEmpty($phone, 'Укажите номер телефона');

            $existingUser = $this->findUserByPhone->fetch(
                new FindUserByPhoneQuery(phone: $phone),
            );

            Assert::null($existingUser, 'Не удалось создать пользователя');

            $createdUser = $this->createUser->handle(
                new CreateUserCommand(phone: $phone),
            );

            $tokens = $this->createAuthorizeTokens->handle(
                new CreateAuthorizeTokensCommand(
                    phone: $createdUser->phone,
                    userId: $createdUser->id,
                    sessionId: '',
                    revokePreviousToken: false,
                ),
            );

            return ApiResponse::success([
                'access_token' => $tokens->accessToken,
                'refresh_token' => $tokens->refreshToken,
                'expires_in' => $tokens->expiresIn,
            ]);
        } catch (InvalidArgumentException $exception) {
            $isPhoneTaken = $exception->getMessage() === 'Не удалось создать пользователя';

            return ApiResponse::error(
                error: $exception->getMessage(),
                code: $isPhoneTaken ? 'USER_EXIST' : null,
            );
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'auth/sign-up',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
