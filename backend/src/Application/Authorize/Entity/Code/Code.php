<?php

declare(strict_types=1);

namespace App\Application\Authorize\Entity\Code;

class Code
{
    public function __construct(
        public ?int $id,
        public string $phone,
        public string $code,
        public CodeTypeEnum $codeType,
    ) {}

    public static function buildNew(string $phone, CodeTypeEnum $codeType, string $code): self
    {
        return new self(
            id: null,
            phone: $phone,
            code: $code,
            codeType: $codeType,
        );
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }
}
