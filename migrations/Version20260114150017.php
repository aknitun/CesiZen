<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260114150017 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX uniq_6fb4a725d2d7f70');
        $this->addSql('ALTER TABLE session_exercice ALTER date_debut TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE session_exercice ALTER date_fin TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('CREATE INDEX IDX_6FB4A725D2D7F70 ON session_exercice (exercice_respiration_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_6FB4A725D2D7F70');
        $this->addSql('ALTER TABLE session_exercice ALTER date_debut TYPE DATE');
        $this->addSql('ALTER TABLE session_exercice ALTER date_fin TYPE DATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_6fb4a725d2d7f70 ON session_exercice (exercice_respiration_id)');
    }
}
