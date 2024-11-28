<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240821140348 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book_email DROP INDEX UNIQ_E950690D41DEE7B9, ADD INDEX IDX_E950690D41DEE7B9 (token_id)');
        $this->addSql('ALTER TABLE book_email DROP FOREIGN KEY FK_E950690D16A2B381');
        $this->addSql('DROP INDEX IDX_E950690D16A2B381 ON book_email');
        $this->addSql('ALTER TABLE book_email DROP book_id, CHANGE token_id token_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE followupemail_has_token DROP INDEX UNIQ_9D516CB141DEE7B9, ADD INDEX IDX_9D516CB141DEE7B9 (token_id)');
        $this->addSql('ALTER TABLE followupemail_has_token DROP INDEX UNIQ_9D516CB1E885025B, ADD INDEX IDX_9D516CB1E885025B (follow_up_email_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book_email DROP INDEX IDX_E950690D41DEE7B9, ADD UNIQUE INDEX UNIQ_E950690D41DEE7B9 (token_id)');
        $this->addSql('ALTER TABLE book_email ADD book_id INT DEFAULT NULL, CHANGE token_id token_id INT NOT NULL');
        $this->addSql('ALTER TABLE book_email ADD CONSTRAINT FK_E950690D16A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_E950690D16A2B381 ON book_email (book_id)');
        $this->addSql('ALTER TABLE followupemail_has_token DROP INDEX IDX_9D516CB1E885025B, ADD UNIQUE INDEX UNIQ_9D516CB1E885025B (follow_up_email_id)');
        $this->addSql('ALTER TABLE followupemail_has_token DROP INDEX IDX_9D516CB141DEE7B9, ADD UNIQUE INDEX UNIQ_9D516CB141DEE7B9 (token_id)');
    }
}
