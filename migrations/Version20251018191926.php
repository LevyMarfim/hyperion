<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251018191926 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE transaction (id SERIAL NOT NULL, bank_account_id INT NOT NULL, type VARCHAR(50) NOT NULL, amount NUMERIC(15, 2) NOT NULL, description VARCHAR(255) NOT NULL, transaction_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, category VARCHAR(50) NOT NULL, recipient VARCHAR(100) DEFAULT NULL, sender VARCHAR(100) DEFAULT NULL, notes TEXT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_723705D112CB990C ON transaction (bank_account_id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D112CB990C FOREIGN KEY (bank_account_id) REFERENCES bank_account (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE transaction DROP CONSTRAINT FK_723705D112CB990C');
        $this->addSql('DROP TABLE transaction');
    }
}
