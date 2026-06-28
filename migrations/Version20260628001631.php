<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260628001631 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'ajouter is_verified a coaches';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE coaches ADD is_verified TINYINT NOT NULL');
        $this->addSql('ALTER TABLE players ADD CONSTRAINT FK_264E43A63C105691 FOREIGN KEY (coach_id) REFERENCES coaches (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE coaches DROP is_verified');
        $this->addSql('ALTER TABLE players DROP FOREIGN KEY FK_264E43A63C105691');
    }
}
