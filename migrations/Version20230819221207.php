<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230819221207 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE service ADD title_fr VARCHAR(255) NOT NULL, ADD description_fr LONGTEXT NOT NULL, ADD under_title_fr LONGTEXT NOT NULL, ADD title_es VARCHAR(255) NOT NULL, ADD title_et VARCHAR(255) NOT NULL, ADD description_es LONGTEXT NOT NULL, ADD description_et LONGTEXT NOT NULL, ADD under_title_es LONGTEXT NOT NULL, ADD under_title_et LONGTEXT NOT NULL, DROP title, DROP description, DROP under_title, DROP small_picture, DROP vertical_picture, CHANGE picture picture VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE service ADD title VARCHAR(255) NOT NULL, ADD description LONGTEXT NOT NULL, ADD under_title LONGTEXT NOT NULL, ADD small_picture VARCHAR(255) NOT NULL, ADD vertical_picture VARCHAR(255) NOT NULL, DROP title_fr, DROP description_fr, DROP under_title_fr, DROP title_es, DROP title_et, DROP description_es, DROP description_et, DROP under_title_es, DROP under_title_et, CHANGE picture picture VARCHAR(255) NOT NULL');
    }
}
