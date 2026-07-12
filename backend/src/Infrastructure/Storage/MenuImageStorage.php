<?php

declare(strict_types=1);

namespace App\Infrastructure\Storage;

use App\Application\Menu\Image\MenuImageKind;
use App\Application\Menu\Image\MenuImageStorageInterface;

/**
 * Файловое хранилище фотографий меню в public/upload/{slug}/menu-{kind}-{id}.{ext}.
 * Каталог отдаётся веб-сервером, поэтому наружу возвращается публичный URL с префиксом.
 * Та же конвенция, что и у логотипов точек (VenueLogoStorage).
 */
final class MenuImageStorage implements MenuImageStorageInterface
{
    /** Разрешённые расширения (и порядок поиска существующего файла). */
    private const EXTENSIONS = ['jpeg', 'jpg', 'png'];

    /** Максимум фото в галерее одного товара. */
    private const MAX_GALLERY = 8;

    /** Префикс имени файла галереи товара: menu-item-{id}-{n}.{ext}. */
    private const ITEM_GALLERY_PREFIX = 'menu-item';

    /**
     * Кеш списка файлов каталога {slug} на время запроса: имя файла => true. Чтение
     * (findUrl/findItemGallery по всем товарам меню) проверяет наличие в памяти вместо
     * тысяч is_file(). Инвалидируется при записи/удалении файлов этого slug.
     *
     * @var array<string, array<string, true>>
     */
    private array $directoryIndex = [];

    public function __construct(
        private readonly string $uploadRootDir,
        private readonly string $uploadUrlPrefix,
    ) {}

    public function findUrl(string $slug, MenuImageKind $kind, int $id): ?string
    {
        foreach (self::EXTENSIONS as $extension) {
            $fileName = sprintf('%s-%d.%s', $kind->filePrefix(), $id, $extension);

            if ($this->fileExists($slug, $fileName)) {
                return $this->uploadUrlPrefix . '/' . $slug . '/' . $fileName;
            }
        }

        return null;
    }

    public function store(string $slug, MenuImageKind $kind, int $id, string $sourcePath, string $extension): string
    {
        $extension = strtolower($extension);

        if (!in_array($extension, self::EXTENSIONS, true)) {
            throw new \DomainException('Недопустимый формат изображения');
        }

        $directory = $this->uploadRootDir . '/' . $slug;

        if (!is_dir($directory) && !mkdir($directory, 0775, true) && !is_dir($directory)) {
            throw new \RuntimeException('Не удалось создать каталог загрузки: ' . $directory);
        }

        $this->delete($slug, $kind, $id);

        $relativePath = $this->relativePath($slug, $kind, $id, $extension);
        $target = $this->uploadRootDir . '/' . $relativePath;

        if (!@rename($sourcePath, $target) && !@copy($sourcePath, $target)) {
            throw new \RuntimeException('Не удалось сохранить изображение');
        }

        unset($this->directoryIndex[$slug]);

        return $this->uploadUrlPrefix . '/' . $relativePath;
    }

    public function delete(string $slug, MenuImageKind $kind, int $id): void
    {
        foreach (self::EXTENSIONS as $extension) {
            $existing = $this->uploadRootDir . '/' . $this->relativePath($slug, $kind, $id, $extension);

            if (is_file($existing)) {
                @unlink($existing);
            }
        }

        unset($this->directoryIndex[$slug]);
    }

    private function relativePath(string $slug, MenuImageKind $kind, int $id, string $extension): string
    {
        return sprintf('%s/%s-%d.%s', $slug, $kind->filePrefix(), $id, $extension);
    }

    public function findItemGallery(string $slug, int $itemId): array
    {
        $gallery = [];

        for ($index = 1; $index <= self::MAX_GALLERY; $index++) {
            foreach (self::EXTENSIONS as $extension) {
                $fileName = sprintf('%s-%d-%d.%s', self::ITEM_GALLERY_PREFIX, $itemId, $index, $extension);

                if ($this->fileExists($slug, $fileName)) {
                    $gallery[$index] = $this->uploadUrlPrefix . '/' . $slug . '/' . $fileName;
                    break;
                }
            }
        }

        return $gallery;
    }

    /** Есть ли файл в каталоге {slug} — по кешу листинга (один scandir на slug за запрос). */
    private function fileExists(string $slug, string $fileName): bool
    {
        if (!isset($this->directoryIndex[$slug])) {
            $directory = $this->uploadRootDir . '/' . $slug;
            $names = is_dir($directory) ? scandir($directory) : [];
            $this->directoryIndex[$slug] = array_fill_keys($names !== false ? $names : [], true);
        }

        return isset($this->directoryIndex[$slug][$fileName]);
    }

    public function addToItemGallery(string $slug, int $itemId, string $sourcePath, string $extension): array
    {
        $extension = strtolower($extension);

        if (!in_array($extension, self::EXTENSIONS, true)) {
            throw new \DomainException('Недопустимый формат изображения');
        }

        $gallery = $this->findItemGallery($slug, $itemId);
        $index = $this->firstFreeGallerySlot($gallery);

        if ($index === null) {
            throw new \DomainException('Достигнут лимит фотографий товара');
        }

        $directory = $this->uploadRootDir . '/' . $slug;

        if (!is_dir($directory) && !mkdir($directory, 0775, true) && !is_dir($directory)) {
            throw new \RuntimeException('Не удалось создать каталог загрузки: ' . $directory);
        }

        $relativePath = $this->galleryRelativePath($slug, $itemId, $index, $extension);
        $target = $this->uploadRootDir . '/' . $relativePath;

        if (!@rename($sourcePath, $target) && !@copy($sourcePath, $target)) {
            throw new \RuntimeException('Не удалось сохранить изображение');
        }

        unset($this->directoryIndex[$slug]);

        return ['index' => $index, 'url' => $this->uploadUrlPrefix . '/' . $relativePath];
    }

    public function deleteItemGalleryIndex(string $slug, int $itemId, int $index): void
    {
        foreach (self::EXTENSIONS as $extension) {
            $existing = $this->uploadRootDir . '/' . $this->galleryRelativePath($slug, $itemId, $index, $extension);

            if (is_file($existing)) {
                @unlink($existing);
            }
        }

        unset($this->directoryIndex[$slug]);
    }

    /**
     * @param array<int, string> $gallery
     */
    private function firstFreeGallerySlot(array $gallery): ?int
    {
        for ($index = 1; $index <= self::MAX_GALLERY; $index++) {
            if (!isset($gallery[$index])) {
                return $index;
            }
        }

        return null;
    }

    private function galleryRelativePath(string $slug, int $itemId, int $index, string $extension): string
    {
        return sprintf('%s/%s-%d-%d.%s', $slug, self::ITEM_GALLERY_PREFIX, $itemId, $index, $extension);
    }
}
