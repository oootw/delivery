<?php

declare(strict_types=1);

namespace App\Application\Venue\Command\UploadVenueLogo;

/**
 * Загрузка логотипа точки владельцем. sourcePath — путь к принятому файлу,
 * extension — уже провалидированное расширение (jpeg/jpg/png).
 */
class UploadVenueLogoCommand
{
    public function __construct(
        public readonly int $userId,
        public readonly int $venueId,
        public readonly string $sourcePath,
        public readonly string $extension,
    ) {}
}
