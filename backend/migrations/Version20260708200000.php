<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260708200000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create request_metric table (per-minute application load counters)';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE request_metric (minute_bucket TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, requests INT DEFAULT 0 NOT NULL, errors INT DEFAULT 0 NOT NULL, PRIMARY KEY (minute_bucket))');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE request_metric');
    }
}
