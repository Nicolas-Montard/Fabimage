<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240626201822 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE follow_up_email (id INT AUTO_INCREMENT NOT NULL, book_id INT NOT NULL, content_fr LONGTEXT DEFAULT NULL, content_es LONGTEXT DEFAULT NULL, content_et LONGTEXT DEFAULT NULL, send_after INT NOT NULL, subject_fr VARCHAR(255) DEFAULT NULL, subject_es VARCHAR(255) DEFAULT NULL, subject_et VARCHAR(255) DEFAULT NULL, INDEX IDX_7AADE72916A2B381 (book_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE follow_up_email ADD CONSTRAINT FK_7AADE72916A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
        $this->addSql('ALTER TABLE book DROP follow_up_email_fr, DROP follow_up_email_es, DROP follow_up_email_et');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE follow_up_email DROP FOREIGN KEY FK_7AADE72916A2B381');
        $this->addSql('DROP TABLE follow_up_email');
        $this->addSql('ALTER TABLE book ADD follow_up_email_fr LONGTEXT NOT NULL, ADD follow_up_email_es LONGTEXT NOT NULL, ADD follow_up_email_et LONGTEXT NOT NULL');
    }
}
