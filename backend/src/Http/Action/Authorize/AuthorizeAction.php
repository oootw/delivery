<?php

declare(strict_types=1);

namespace App\Http\Action\Authorize;

use App\Application\Authorize\Command\CheckOntimeCode\CheckOntimeCodeCommand;
use App\Application\Authorize\Command\CheckOntimeCode\CheckOntimeCodeHandler;
use App\Application\Authorize\Command\CreateAuthorizeTokens\CreateAuthorizeTokensCommand;
use App\Application\Authorize\Command\CreateAuthorizeTokens\CreateAuthorizeTokensHandler;
use App\Application\Authorize\Entity\Code\CodeTypeEnum;
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

class AuthorizeAction extends AbstractController
{
    public function __construct(
        private readonly FindUserByPhoneFetcher $findUserByPhone,
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

            // Проверяем код единообразно для любого номера (для незарегистрированного
            // существует decoy-код). При неверном коде летит \DomainException.
            $this->checkOntimeCode->handle(
                new CheckOntimeCodeCommand(
                    phone: $phone,
                    code: $code,
                    codeType: CodeTypeEnum::Authorize->value,
                ),
            );

            // Сюда доходим только с верным кодом. Незарегистрированный номер не
            // раскрываем — тот же ответ, что на неверный код (enumeration).
            if ($user === null) {
                throw new \DomainException('Неверный код');
            }

            $tokens = $this->createAuthorizeTokens->handle(
                new CreateAuthorizeTokensCommand(
                    phone: $phone,
                    userId: $user->id,
                    sessionId: '',
                    revokePreviousToken: false,
                ),
            );

            return ApiResponse::success([
                'access_token' => $tokens->accessToken,
                'refresh_token' => $tokens->refreshToken,
                'expires_in' => $tokens->expiresIn,
            ]);
        } catch (InvalidArgumentException | \DomainException $exception) {
            return ApiResponse::error($exception->getMessage());
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'auth/authorize',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
