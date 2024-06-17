<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231109013914 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tariff ADD title_es VARCHAR(255) NOT NULL, ADD title_et VARCHAR(255) NOT NULL, ADD content_es LONGTEXT NOT NULL, ADD content_et LONGTEXT NOT NULL, CHANGE title title_fr VARCHAR(255) NOT NULL, CHANGE content content_fr LONGTEXT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tariff ADD title VARCHAR(255) NOT NULL, ADD content LONGTEXT NOT NULL, DROP title_fr, DROP content_fr, DROP title_es, DROP title_et, DROP content_es, DROP content_et');
    }
}
