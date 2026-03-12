<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260309130230 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE "user" ADD reponse_question_secrete VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" DROP reset_password_token');
        $this->addSql('ALTER TABLE "user" DROP reset_password_token_expires_at');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE "user" ADD reset_password_token VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD reset_password_token_expires_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" DROP reponse_question_secrete');
    }
}
