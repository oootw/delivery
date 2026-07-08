<?php

declare(strict_types=1);

namespace App\Application\Workspace\Entity\Workspace;

use App\Shared\VO\Image\ImageValueObject;

/**
 * Воркспейс арендатора. Публикуется как поддомен slug.app.com.
 *
 * slug задаётся один раз при создании и не меняется (на нём завязаны ссылки).
 * Логотип необязателен при создании и добавляется отдельно позже.
 */
class Workspace
{
    public function __construct(
        public ?int $id,
        public string $name,
        public string $slug,
        public string $description,
        public ?ImageValueObject $logo,
        public int $ownerId,
        public \DateTimeImmutable $createdAt,
        public \DateTimeImmutable $updatedAt,
    ) {}

    public static function buildNew(string $name, string $slug, string $description, int $ownerId): self
    {
        $now = new \DateTimeImmutable();

        return new self(
            id: null,
            name: $name,
            slug: $slug,
            description: $description,
            logo: null,
            ownerId: $ownerId,
            createdAt: $now,
            updatedAt: $now,
        );
    }

    public function rename(string $name, string $description): void
    {
        $this->name = $name;
        $this->description = $description;
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function attachLogo(ImageValueObject $logo): void
    {
        $this->logo = $logo;
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function assignId(int $id): void
    {
        $this->id = $id;
    }
}
