<?php

declare(strict_types=1);

namespace App\Application\Menu\Image;

/**
 * Хранилище фотографий сущностей меню (товары, категории, модификаторы, комбо).
 * Файлы лежат в /upload/{slug}/menu-{kind}-{id}.{ext} (slug воркспейса) и отдаются
 * веб-сервером напрямую. Развязывает домен от файловой системы: домен оперирует
 * slug/kind/id, адаптер знает физические пути и публичный URL.
 */
interface MenuImageStorageInterface
{
    /** Публичный URL фото сущности меню или null, если файла нет. */
    public function findUrl(string $slug, MenuImageKind $kind, int $id): ?string;

    /**
     * Сохраняет фото, заменяя прежнее (в любом расширении), и возвращает публичный URL.
     * $sourcePath — путь к загруженному файлу, $extension — jpeg/jpg/png.
     */
    public function store(string $slug, MenuImageKind $kind, int $id, string $sourcePath, string $extension): string;

    /** Удаляет фото сущности меню (в любом расширении), если оно есть. */
    public function delete(string $slug, MenuImageKind $kind, int $id): void;

    /**
     * Галерея товара (несколько фото). Возвращает index => URL по возрастанию индекса.
     *
     * @return array<int, string>
     */
    public function findItemGallery(string $slug, int $itemId): array;

    /**
     * Добавляет фото в первый свободный слот галереи товара.
     * Возвращает ['index' => int, 'url' => string].
     *
     * @return array{index: int, url: string}
     */
    public function addToItemGallery(string $slug, int $itemId, string $sourcePath, string $extension): array;

    /** Удаляет фото галереи товара по индексу слота. */
    public function deleteItemGalleryIndex(string $slug, int $itemId, int $index): void;
}
