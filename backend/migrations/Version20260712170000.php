<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Legacy-placeholder: создание таблицы Acme перенесено в custom/migrations
 * (namespace Custom\Migrations) для overlay-контура.
 */
final class Version20260712170000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'No-op: Acme migration moved to custom/migrations (Custom\\Migrations)';
    }

    public function up(Schema $schema): void
    {
        // intentionally empty
    }

    public function down(Schema $schema): void
    {
        // intentionally empty
    }
}
