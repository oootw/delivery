<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260711150000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Subscription: last_payment_transaction_id for webhook dedup';
    }

    public function up(Schema $schema): void
    {
        // Дедупликация повторной доставки webhook'а pay: повтор того же платежа
        // (одинаковый TransactionId) не должен второй раз продлевать период подписки.
        $this->addSql('ALTER TABLE subscription ADD last_payment_transaction_id VARCHAR(64) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE subscription DROP last_payment_transaction_id');
    }
}
