<?php

declare(strict_types=1);

namespace App\Infrastructure\Storage;

use App\Application\Promotion\Banner\PromotionBannerStorageInterface;

/**
 * Файловое хранилище картинок баннеров акций в public/upload/{slug}/promo-banner-{id}.{ext}.
 * Каталог отдаётся веб-сервером, поэтому наружу возвращается публичный URL с префиксом.
 */
final class PromotionBannerStorage implements PromotionBannerStorageInterface
{
    /** Разрешённые расширения (и порядок поиска существующего файла). */
    private const EXTENSIONS = ['jpeg', 'jpg', 'png'];

    public function __construct(
        private readonly string $uploadRootDir,
        private readonly string $uploadUrlPrefix,
    ) {}

    public function findUrl(string $slug, int $promotionId): ?string
    {
        foreach (self::EXTENSIONS as $extension) {
            $relativePath = $this->relativePath($slug, $promotionId, $extension);

            if (is_file($this->uploadRootDir . '/' . $relativePath)) {
                return $this->uploadUrlPrefix . '/' . $relativePath;
            }
        }

        return null;
    }

    public function store(string $slug, int $promotionId, string $sourcePath, string $extension): string
    {
        $extension = strtolower($extension);

        if (!in_array($extension, self::EXTENSIONS, true)) {
            throw new \DomainException('Недопустимый формат изображения');
        }

        $directory = $this->uploadRootDir . '/' . $slug;

        if (!is_dir($directory) && !mkdir($directory, 0775, true) && !is_dir($directory)) {
            throw new \RuntimeException('Не удалось создать каталог загрузки: ' . $directory);
        }

        $this->delete($slug, $promotionId);

        $relativePath = $this->relativePath($slug, $promotionId, $extension);
        $target = $this->uploadRootDir . '/' . $relativePath;

        if (!@rename($sourcePath, $target) && !@copy($sourcePath, $target)) {
            throw new \RuntimeException('Не удалось сохранить изображение');
        }

        return $this->uploadUrlPrefix . '/' . $relativePath;
    }

    public function delete(string $slug, int $promotionId): void
    {
        foreach (self::EXTENSIONS as $extension) {
            $existing = $this->uploadRootDir . '/' . $this->relativePath($slug, $promotionId, $extension);

            if (is_file($existing)) {
                @unlink($existing);
            }
        }
    }

    private function relativePath(string $slug, int $promotionId, string $extension): string
    {
        return sprintf('%s/promo-banner-%d.%s', $slug, $promotionId, $extension);
    }
}
