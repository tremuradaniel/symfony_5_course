<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211214110636 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__genre AS SELECT id, name, image, description FROM genre');
        $this->addSql('DROP TABLE genre');
        $this->addSql('CREATE TABLE genre (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(64) NOT NULL COLLATE BINARY, poster VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL)');
        $this->addSql('INSERT INTO genre (id, name, poster, description) SELECT id, name, image, description FROM __temp__genre');
        $this->addSql('DROP TABLE __temp__genre');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__genre AS SELECT id, name, poster, description FROM genre');
        $this->addSql('DROP TABLE genre');
        $this->addSql('CREATE TABLE genre (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(64) NOT NULL, image VARCHAR(255) NOT NULL COLLATE BINARY, description CLOB NOT NULL COLLATE BINARY)');
        $this->addSql('INSERT INTO genre (id, name, image, description) SELECT id, name, poster, description FROM __temp__genre');
        $this->addSql('DROP TABLE __temp__genre');
    }
}
