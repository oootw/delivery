<?php

declare(strict_types=1);

namespace App\Shared\VO\Image;

class ImageValueObject
{
    public function __construct(
        public readonly string $path,
        public readonly string $title,
        public readonly string $description,
        public readonly string $width,
        public readonly string $height,
        public readonly string $size,
        public readonly string $extension,
    ) {}
}
