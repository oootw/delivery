<?php

declare(strict_types=1);

namespace App\Application\Promotion\Banner;

/**
 * Хранилище картинок баннеров акций. Файлы лежат в /upload/{slug}/promo-banner-{id}.{ext}
 * (slug воркспейса) и отдаются веб-сервером напрямую. Та же конвенция, что и у логотипов/фото меню.
 */
interface PromotionBannerStorageInterface
{
    /** Публичный URL картинки баннера или null, если файла нет. */
    public function findUrl(string $slug, int $promotionId): ?string;

    /** Сохраняет картинку баннера, заменяя прежнюю, и возвращает публичный URL. */
    public function store(string $slug, int $promotionId, string $sourcePath, string $extension): string;

    /** Удаляет картинку баннера (в любом расширении), если она есть. */
    public function delete(string $slug, int $promotionId): void;
}
