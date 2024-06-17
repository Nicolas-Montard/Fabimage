<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231029052855 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentary_home ADD title_fr VARCHAR(255) NOT NULL, ADD title_es VARCHAR(255) NOT NULL, ADD title_et VARCHAR(255) NOT NULL, ADD content_es LONGTEXT NOT NULL, ADD content_et LONGTEXT NOT NULL, ADD author_fr VARCHAR(255) NOT NULL, ADD author_es VARCHAR(255) NOT NULL, ADD author_et VARCHAR(255) NOT NULL, DROP title, DROP author, CHANGE content content_fr LONGTEXT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentary_home ADD title VARCHAR(255) NOT NULL, ADD content LONGTEXT NOT NULL, ADD author VARCHAR(255) NOT NULL, DROP title_fr, DROP title_es, DROP title_et, DROP content_fr, DROP content_es, DROP content_et, DROP author_fr, DROP author_es, DROP author_et');
    }
}
