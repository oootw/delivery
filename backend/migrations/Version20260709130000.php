<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260709130000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add timezone to venue (for promotion happy-hours / day-of-week conditions)';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("ALTER TABLE venue ADD timezone VARCHAR(64) DEFAULT 'Europe/Moscow' NOT NULL");
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE venue DROP timezone');
    }
}
