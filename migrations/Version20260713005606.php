<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260713005606 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajout de la table like pour les joueurs';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE coach_player_like (player_id INT NOT NULL, coach_id INT NOT NULL, INDEX IDX_2AA34E5199E6F5DF (player_id), INDEX IDX_2AA34E513C105691 (coach_id), PRIMARY KEY (player_id, coach_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE coach_player_like ADD CONSTRAINT FK_2AA34E5199E6F5DF FOREIGN KEY (player_id) REFERENCES players (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE coach_player_like ADD CONSTRAINT FK_2AA34E513C105691 FOREIGN KEY (coach_id) REFERENCES coaches (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE coach_player_like DROP FOREIGN KEY FK_2AA34E5199E6F5DF');
        $this->addSql('ALTER TABLE coach_player_like DROP FOREIGN KEY FK_2AA34E513C105691');
        $this->addSql('DROP TABLE coach_player_like');
    }
}
