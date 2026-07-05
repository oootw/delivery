<?php

declare(strict_types=1);

namespace App\Shared\Service\JWTManager;

enum JWTManagerErrorEnum: string
{
    case UNKNOWN_SIGNING_METHOD = 'Незивестный метод подписи';
    case INVALID_TOKEN = 'Невалидный токен';
    case FAILED_TO_GENERATE_TOKEN = 'Не удалось сгенерировать токен';
    case FAILED_TO_PARSE_TOKEN = 'Не удалось распарсить токен';
}
