<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200327222629 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE users ADD fname VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE users ADD lname VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE users ADD email VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE users ADD mobile VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD landline VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD address VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD bio TEXT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE users DROP fname');
        $this->addSql('ALTER TABLE users DROP lname');
        $this->addSql('ALTER TABLE users DROP email');
        $this->addSql('ALTER TABLE users DROP mobile');
        $this->addSql('ALTER TABLE users DROP landline');
        $this->addSql('ALTER TABLE users DROP address');
        $this->addSql('ALTER TABLE users DROP bio');
    }
}
