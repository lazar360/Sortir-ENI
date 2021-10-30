<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211017162431 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE participant ADD picture_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE participant ADD CONSTRAINT FK_D79F6B11EE45BDBF FOREIGN KEY (picture_id) REFERENCES participant_picture_name (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D79F6B11EE45BDBF ON participant (picture_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE participant DROP FOREIGN KEY FK_D79F6B11EE45BDBF');
        $this->addSql('DROP INDEX UNIQ_D79F6B11EE45BDBF ON participant');
        $this->addSql('ALTER TABLE participant DROP picture_id');
    }
}
