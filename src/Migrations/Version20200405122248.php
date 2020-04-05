<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200405122248 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE feedback CHANGE author author VARCHAR(100) DEFAULT NULL, CHANGE email email VARCHAR(50) DEFAULT NULL, CHANGE title title VARCHAR(100) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE feedback CHANGE author author VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE title title VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
    }
}