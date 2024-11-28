<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240820040202 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE followupemail_has_token (id INT AUTO_INCREMENT NOT NULL, follow_up_email_id INT NOT NULL, token_id INT NOT NULL, UNIQUE INDEX UNIQ_9D516CB1E885025B (follow_up_email_id), UNIQUE INDEX UNIQ_9D516CB141DEE7B9 (token_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE followupemail_has_token ADD CONSTRAINT FK_9D516CB1E885025B FOREIGN KEY (follow_up_email_id) REFERENCES follow_up_email (id)');
        $this->addSql('ALTER TABLE followupemail_has_token ADD CONSTRAINT FK_9D516CB141DEE7B9 FOREIGN KEY (token_id) REFERENCES token (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE followupemail_has_token DROP FOREIGN KEY FK_9D516CB1E885025B');
        $this->addSql('ALTER TABLE followupemail_has_token DROP FOREIGN KEY FK_9D516CB141DEE7B9');
        $this->addSql('DROP TABLE followupemail_has_token');
    }
}
