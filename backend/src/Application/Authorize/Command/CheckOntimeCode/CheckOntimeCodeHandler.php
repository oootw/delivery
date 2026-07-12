<?php

declare(strict_types=1);

namespace App\Application\Authorize\Command\CheckOntimeCode;

use App\Application\Authorize\Entity\Code\CodeRepositoryInterface;
use App\Application\Authorize\Entity\Code\CodeTypeEnum;

class CheckOntimeCodeHandler
{
    /** Число неверных попыток, после которого код сгорает (защита от перебора). */
    private const MAX_ATTEMPTS = 3;

    public function __construct(
        private readonly CodeRepositoryInterface $codes,
    ) {}

    public function handle(CheckOntimeCodeCommand $command): void
    {
        $code = $this->codes->findActiveCode(
            phone: $command->phone,
            codeType: CodeTypeEnum::from($command->codeType),
        );

        if ($code === null) {
            throw new \DomainException('Код не найден. Запросите новый код.');
        }

        $now = new \DateTimeImmutable();

        if ($code->isUsed()) {
            throw new \DomainException('Код уже использован. Запросите новый код.');
        }

        if ($code->isExpiredAt($now)) {
            throw new \DomainException('Срок действия кода истёк. Запросите новый код.');
        }

        if ($code->hasReachedAttemptLimit(self::MAX_ATTEMPTS)) {
            throw new \DomainException('Превышено число попыток. Запросите новый код.');
        }

        if ($code->matches($command->code)) {
            $code->markUsed($now);
            $this->codes->save($code);

            return;
        }

        $code->registerFailedAttempt();

        if ($code->hasReachedAttemptLimit(self::MAX_ATTEMPTS)) {
            $code->markUsed($now);
        }

        $this->codes->save($code);

        throw new \DomainException('Неверный код.');
    }
}
