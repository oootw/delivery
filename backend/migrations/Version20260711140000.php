<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260711140000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Idempotency: partial unique index — one Earn ledger row per order';
    }

    public function up(Schema $schema): void
    {
        // Гарантирует единственное начисление за заказ: параллельное завершение заказа
        // не сможет вставить второй Earn и откатится целиком (double-accrual невозможен).
        // Партиальный индекс не выражается атрибутами ORM — управляется миграцией вручную.
        // ВНИМАНИЕ: при наличии старых дублей Earn на один заказ индекс не создастся —
        // сначала дедуплицировать loyalty_transaction по (order_id) для type='earn'.
        $this->addSql("CREATE UNIQUE INDEX uniq_loyalty_earn_per_order ON loyalty_transaction (order_id) WHERE type = 'earn'");
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP INDEX uniq_loyalty_earn_per_order');
    }
}
