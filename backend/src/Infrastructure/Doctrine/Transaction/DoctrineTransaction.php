<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Transaction;

use App\Shared\Transaction\TransactionInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Реализация транзакции поверх Doctrine. Промежуточные flush() внутри замыкания
 * выполняют SQL, но коммит происходит один раз по выходу — так набор операций
 * становится атомарным, а множество коммитов схлопывается в один.
 */
final class DoctrineTransaction implements TransactionInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {}

    public function wrap(callable $work): mixed
    {
        return $this->entityManager->wrapInTransaction(static fn(): mixed => $work());
    }
}
