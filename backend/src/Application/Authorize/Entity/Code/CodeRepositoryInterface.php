<?php

declare(strict_types=1);

namespace App\Application\Authorize\Entity\Code;

interface CodeRepositoryInterface
{
    /** Последний выпущенный код для номера и типа (для проверки при входе). */
    public function findActiveCode(string $phone, CodeTypeEnum $codeType): ?Code;

    /** Есть ли код, выпущенный на номер начиная с указанного момента (для кулдауна). */
    public function hasRecentCode(string $phone, \DateTimeImmutable $since): bool;

    public function countCreatedSince(string $phone, \DateTime $since): int;

    /** Сохранить изменения кода (счётчик попыток, отметка об использовании). */
    public function save(Code $code): void;

    public function create(Code $code): int;
}
