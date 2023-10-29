<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231004225017 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE token (id INT AUTO_INCREMENT NOT NULL, content VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE book CHANGE picture_fr picture_fr VARCHAR(255) DEFAULT NULL, CHANGE picture_es picture_es VARCHAR(255) DEFAULT NULL, CHANGE picture_et picture_et VARCHAR(255) DEFAULT NULL, CHANGE book_fr book_fr VARCHAR(255) DEFAULT NULL, CHANGE book_es book_es VARCHAR(255) DEFAULT NULL, CHANGE book_et book_et VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE token');
        $this->addSql('ALTER TABLE book CHANGE picture_fr picture_fr VARCHAR(255) NOT NULL, CHANGE picture_es picture_es VARCHAR(255) NOT NULL, CHANGE picture_et picture_et VARCHAR(255) NOT NULL, CHANGE book_fr book_fr VARCHAR(255) NOT NULL, CHANGE book_es book_es VARCHAR(255) NOT NULL, CHANGE book_et book_et VARCHAR(255) NOT NULL');
    }
}
