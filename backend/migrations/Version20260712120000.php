<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260712120000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Authorize: used_at + attempts on code (one-time codes, brute-force limit)';
    }

    public function up(Schema $schema): void
    {
        // Одноразовость кода (used_at) и счётчик неверных попыток (attempts) —
        // реальная проверка SMS-кода вместо застабленной (AUDIT #15).
        $this->addSql('ALTER TABLE code ADD used_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE code ADD attempts INT DEFAULT 0 NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE code DROP used_at');
        $this->addSql('ALTER TABLE code DROP attempts');
    }
}
