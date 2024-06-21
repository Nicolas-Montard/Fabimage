<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240618032307 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE follow_up_email (id INT AUTO_INCREMENT NOT NULL, book_id INT NOT NULL, content_fr LONGTEXT NOT NULL, content_es LONGTEXT NOT NULL, content_et LONGTEXT NOT NULL, send_after INT NOT NULL, INDEX IDX_7AADE72916A2B381 (book_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE follow_up_email ADD CONSTRAINT FK_7AADE72916A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
        $this->addSql('ALTER TABLE email_book DROP FOREIGN KEY FK_54D383B416A2B381');
        $this->addSql('DROP TABLE email_book');
        $this->addSql('ALTER TABLE book ADD email_fr LONGTEXT NOT NULL, ADD email_es LONGTEXT NOT NULL, ADD email_et LONGTEXT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE email_book (id INT AUTO_INCREMENT NOT NULL, book_id INT NOT NULL, mail_fr LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, mail_es LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, mail_et LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, time_after_buyed DATETIME DEFAULT NULL, INDEX IDX_54D383B416A2B381 (book_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE email_book ADD CONSTRAINT FK_54D383B416A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE follow_up_email DROP FOREIGN KEY FK_7AADE72916A2B381');
        $this->addSql('DROP TABLE follow_up_email');
        $this->addSql('ALTER TABLE book DROP email_fr, DROP email_es, DROP email_et');
    }
}
