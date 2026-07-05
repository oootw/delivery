<?php

declare(strict_types=1);

namespace App\Shared\Service\LoggerService;

interface LoggerServiceInterface
{
    public static function toFile(string $fileName, string $message): void;
}
