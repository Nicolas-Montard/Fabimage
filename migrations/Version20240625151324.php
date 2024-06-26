<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240625151324 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book DROP follow_up_email_fr, DROP follow_up_email_es, DROP follow_up_email_et');
        $this->addSql('ALTER TABLE follow_up_email ADD subject_fr VARCHAR(255) DEFAULT NULL, ADD subject_es VARCHAR(255) DEFAULT NULL, ADD subject_et VARCHAR(255) DEFAULT NULL, CHANGE content_fr content_fr LONGTEXT DEFAULT NULL, CHANGE content_es content_es LONGTEXT DEFAULT NULL, CHANGE content_et content_et LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book ADD follow_up_email_fr LONGTEXT NOT NULL, ADD follow_up_email_es LONGTEXT NOT NULL, ADD follow_up_email_et LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE follow_up_email DROP subject_fr, DROP subject_es, DROP subject_et, CHANGE content_fr content_fr LONGTEXT NOT NULL, CHANGE content_es content_es LONGTEXT NOT NULL, CHANGE content_et content_et LONGTEXT NOT NULL');
    }
}
