<?php

declare(strict_types=1);

namespace App\Shared\Service\LoggerService;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class LoggerService implements LoggerServiceInterface
{
    public static function toFile(string $fileName, string $message): void
    {
        $logger = new Logger('logger');

        $logger->pushHandler(
            new StreamHandler(
                stream: 'logs/' . $fileName . '.log',
            )
        );

        $logger->warning(
            message: $message
        );
    }
}
