<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230819034627 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentary ADD content_es LONGTEXT NOT NULL, ADD content_et LONGTEXT NOT NULL, CHANGE content content_fr LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE workshop CHANGE picture picture VARCHAR(255) DEFAULT NULL, CHANGE small_picture small_picture VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentary ADD content LONGTEXT NOT NULL, DROP content_fr, DROP content_es, DROP content_et');
        $this->addSql('ALTER TABLE workshop CHANGE picture picture VARCHAR(255) NOT NULL, CHANGE small_picture small_picture VARCHAR(255) NOT NULL');
    }
}
