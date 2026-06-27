<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260627222246 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'ajout de la relation coach sur players';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE players ADD coach_id INT NOT NULL');
        $this->addSql('ALTER TABLE players ADD CONSTRAINT FK_264E43A63C105691 FOREIGN KEY (coach_id) REFERENCES coaches (id)');
        $this->addSql('CREATE INDEX IDX_264E43A63C105691 ON players (coach_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE players DROP FOREIGN KEY FK_264E43A63C105691');
        $this->addSql('DROP INDEX IDX_264E43A63C105691 ON players');
        $this->addSql('ALTER TABLE players DROP coach_id');
    }
}
