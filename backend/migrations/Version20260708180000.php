<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260708180000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add is_admin and password to user (platform admin login for the admin panel)';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE "user" ADD is_admin BOOLEAN DEFAULT false NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD password VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE "user" DROP is_admin');
        $this->addSql('ALTER TABLE "user" DROP password');
    }
}
