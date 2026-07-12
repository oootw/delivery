<?php

declare(strict_types=1);

namespace App\Infrastructure\Storage;

use App\Application\Venue\Logo\VenueLogoStorageInterface;

/**
 * Файловое хранилище логотипов точек в public/upload/{slug}/venue-{venueId}.{ext}.
 * Каталог отдаётся веб-сервером, поэтому наружу возвращается публичный URL с префиксом.
 */
final class VenueLogoStorage implements VenueLogoStorageInterface
{
    /** Разрешённые расширения (и порядок поиска существующего файла). */
    private const EXTENSIONS = ['jpeg', 'jpg', 'png'];

    public function __construct(
        private readonly string $uploadRootDir,
        private readonly string $uploadUrlPrefix,
    ) {}

    public function findUrl(string $slug, int $venueId): ?string
    {
        foreach (self::EXTENSIONS as $extension) {
            $relativePath = $this->relativePath($slug, $venueId, $extension);

            if (is_file($this->uploadRootDir . '/' . $relativePath)) {
                return $this->uploadUrlPrefix . '/' . $relativePath;
            }
        }

        return null;
    }

    public function store(string $slug, int $venueId, string $sourcePath, string $extension): string
    {
        $extension = strtolower($extension);

        if (!in_array($extension, self::EXTENSIONS, true)) {
            throw new \DomainException('Недопустимый формат изображения');
        }

        $directory = $this->uploadRootDir . '/' . $slug;

        if (!is_dir($directory) && !mkdir($directory, 0775, true) && !is_dir($directory)) {
            throw new \RuntimeException('Не удалось создать каталог загрузки: ' . $directory);
        }

        // Убираем прежний логотип в любом расширении, чтобы не осталось двух файлов точки.
        foreach (self::EXTENSIONS as $knownExtension) {
            $existing = $this->uploadRootDir . '/' . $this->relativePath($slug, $venueId, $knownExtension);

            if (is_file($existing)) {
                @unlink($existing);
            }
        }

        $relativePath = $this->relativePath($slug, $venueId, $extension);
        $target = $this->uploadRootDir . '/' . $relativePath;

        if (!@rename($sourcePath, $target) && !@copy($sourcePath, $target)) {
            throw new \RuntimeException('Не удалось сохранить изображение');
        }

        return $this->uploadUrlPrefix . '/' . $relativePath;
    }

    private function relativePath(string $slug, int $venueId, string $extension): string
    {
        return sprintf('%s/venue-%d.%s', $slug, $venueId, $extension);
    }
}
