<?php

declare(strict_types=1);

namespace App\Shared\Transaction;

/**
 * Выполняет замыкание в одной транзакции БД: при исключении всё откатывается,
 * при успехе — коммитится один раз. Развязывает домен от Doctrine: use-case
 * оборачивает набор записей (заказ + скидки + резерв баллов и т.п.) в атомарную операцию.
 */
interface TransactionInterface
{
    /**
     * @template T
     * @param callable(): T $work
     * @return T
     */
    public function wrap(callable $work): mixed;
}
