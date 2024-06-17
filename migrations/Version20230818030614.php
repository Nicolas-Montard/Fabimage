<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230818030614 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE workshop ADD title_es VARCHAR(255) NOT NULL, ADD title_et VARCHAR(255) NOT NULL, ADD description_es LONGTEXT NOT NULL, ADD description_et LONGTEXT NOT NULL, ADD optional_description_es LONGTEXT DEFAULT NULL, ADD optional_description_et LONGTEXT DEFAULT NULL, CHANGE title title_fr VARCHAR(255) NOT NULL, CHANGE description description_fr LONGTEXT NOT NULL, CHANGE optional_description optional_description_fr LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE workshop ADD title VARCHAR(255) NOT NULL, ADD description LONGTEXT NOT NULL, ADD optional_description LONGTEXT DEFAULT NULL, DROP title_fr, DROP description_fr, DROP optional_description_fr, DROP title_es, DROP title_et, DROP description_es, DROP description_et, DROP optional_description_es, DROP optional_description_et');
    }
}
