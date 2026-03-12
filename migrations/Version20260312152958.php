<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260312152958 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contenu DROP slug');
        $this->addSql('ALTER TABLE "user" ALTER email TYPE VARCHAR(80)');
        $this->addSql('ALTER TABLE "user" ALTER nom TYPE VARCHAR(30)');
        $this->addSql('ALTER TABLE "user" ALTER prenom TYPE VARCHAR(30)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contenu ADD slug VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE "user" ALTER email TYPE VARCHAR(180)');
        $this->addSql('ALTER TABLE "user" ALTER nom TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE "user" ALTER prenom TYPE VARCHAR(255)');
    }
}
