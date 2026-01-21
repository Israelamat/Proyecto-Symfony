<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260121214634 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, event_date DATETIME NOT NULL, organizer_id INT NOT NULL, INDEX IDX_3BAE0AA7876C4DDA (organizer_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE event_games (event_id INT NOT NULL, game_id INT NOT NULL, INDEX IDX_BE389A1D71F7E88B (event_id), INDEX IDX_BE389A1DE48FD905 (game_id), PRIMARY KEY (event_id, game_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7876C4DDA FOREIGN KEY (organizer_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE event_games ADD CONSTRAINT FK_BE389A1D71F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_games ADD CONSTRAINT FK_BE389A1DE48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7876C4DDA');
        $this->addSql('ALTER TABLE event_games DROP FOREIGN KEY FK_BE389A1D71F7E88B');
        $this->addSql('ALTER TABLE event_games DROP FOREIGN KEY FK_BE389A1DE48FD905');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE event_games');
    }
}
