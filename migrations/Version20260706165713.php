<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260706165713 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add image upload fields to Player entity';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE players ADD image_name VARCHAR(255) DEFAULT NULL, ADD image_size INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE players DROP image_name, DROP image_size');
    }
}
