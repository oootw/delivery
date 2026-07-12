<?php

declare(strict_types=1);

namespace App\Application\Venue\Logo;

/**
 * Хранилище логотипов точек. Файлы лежат в /upload/{slug}/venue-{venueId}.{ext}
 * (slug воркспейса) и отдаются веб-сервером напрямую. Развязывает домен от файловой
 * системы: домен оперирует slug/venueId, адаптер знает физические пути и публичный URL.
 */
interface VenueLogoStorageInterface
{
    /** Публичный URL логотипа точки или null, если файла нет. */
    public function findUrl(string $slug, int $venueId): ?string;

    /**
     * Сохраняет логотип, заменяя прежний (в любом расширении), и возвращает публичный URL.
     * $sourcePath — путь к загруженному файлу, $extension — jpeg/jpg/png.
     */
    public function store(string $slug, int $venueId, string $sourcePath, string $extension): string;
}
