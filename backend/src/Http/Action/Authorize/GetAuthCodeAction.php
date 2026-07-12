<?php

declare(strict_types=1);

namespace App\Http\Action\Authorize;

use App\Application\Authorize\Command\CreateAuthorizeCode\CreateAuthorizeCodeCommand;
use App\Application\Authorize\Command\CreateAuthorizeCode\CreateAuthorizeCodeHandler;
use App\Application\Authorize\Entity\Code\CodeTypeEnum;
use App\Application\Authorize\Query\FindUserByPhone\FindUserByPhoneFetcher;
use App\Application\Authorize\Query\GetSmsCode\GetSmsCodeFetcher;
use App\Application\Authorize\Query\GetSmsCodeSendAvailable\GetSmsCodeSendAvailableFetcher;
use App\Application\Authorize\Query\GetSmsDailyLimitAvailable\GetSmsDailyLimitAvailableFetcher;
use App\Http\Response\ApiResponse;
use App\Shared\Service\LoggerService\LoggerService;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Webmozart\Assert\Assert;

class GetAuthCodeAction extends AbstractController
{
    public function __construct(
        private readonly FindUserByPhoneFetcher $findUserByPhone,
        private readonly GetSmsCodeSendAvailableFetcher $getSmsCodeSendAvailable,
        private readonly GetSmsDailyLimitAvailableFetcher $getSmsDailyLimitAvailable,
        private readonly CreateAuthorizeCodeHandler $createAuthorizeCode,
        private readonly GetSmsCodeFetcher $getSmsCode,
    ) {}

    #[Route('/get-auth-code', name: 'app_get_auth_code', methods: ['POST'])]
    public function handle(Request $request): Response
    {
        try {
            $body = $request->toArray();

            $phone = $body['phone'] ?? null;
            $codeType = $body['codeType'] ?? null;

            Assert::notEmpty($phone, 'Укажите номер телефона');
            Assert::notEmpty($codeType, 'Укажите тип кода');
            Assert::eq($codeType, CodeTypeEnum::Register->value, 'Недопустимый тип кода');

            // Лимит и кулдаун проверяем по номеру ДО ветвления по пользователю, а код
            // выпускаем всегда (для незарегистрированного — decoy без SMS). Так лимит,
            // кулдаун и тайминг одинаковы независимо от регистрации — эндпоинт не работает
            // оракулом существования аккаунта (enumeration).
            $isUnderDailyLimit = $this->getSmsDailyLimitAvailable->fetch(
                new \App\Application\Authorize\Query\GetSmsDailyLimitAvailable\GetSmsDailyLimitAvailableQuery(
                    phone: $phone,
                )
            );

            Assert::true($isUnderDailyLimit, 'Превышен суточный лимит запросов кода');

            $isCodeSendAvailable = $this->getSmsCodeSendAvailable->fetch(
                new \App\Application\Authorize\Query\GetSmsCodeSendAvailable\GetSmsCodeSendAvailableQuery(
                    phone: $phone,
                )
            );

            Assert::true($isCodeSendAvailable, 'Код уже отправлен');

            $authorizeCode = $this->createAuthorizeCode->handle(
                new CreateAuthorizeCodeCommand(
                    phone: $phone,
                    codeType: $codeType,
                )
            );

            $user = $this->findUserByPhone->fetch(
                new \App\Application\Authorize\Query\FindUserByPhone\FindUserByPhoneQuery(
                    phone: $phone,
                )
            );

            // SMS уходит только зарегистрированному номеру. Незарегистрированному код
            // выпущен (decoy для единообразия лимита/кулдауна), но не отправляется.
            if ($user !== null) {
                $this->getSmsCode->fetch(
                    new \App\Application\Authorize\Query\GetSmsCode\GetSmsCodeQuery(
                        phone: $phone,
                        message: 'Ваш код для авторизации: ' . $authorizeCode->code,
                    )
                );
            }

            return ApiResponse::success();
        } catch (InvalidArgumentException $exception) {
            return ApiResponse::error($exception->getMessage());
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'auth/get-auth-code',
                message: $exception->getMessage()
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
