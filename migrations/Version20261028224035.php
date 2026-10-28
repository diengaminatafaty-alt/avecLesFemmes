<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261028224035 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE campagne ADD periodicite VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE campagne ADD jour_rencontre INT NOT NULL');
        $this->addSql('ALTER TABLE campagne ADD contribution_caisse_present INT NOT NULL');
        $this->addSql('ALTER TABLE campagne ADD contribution_caisse_absent INT NOT NULL');
        $this->addSql('ALTER TABLE campagne ADD amende_journaliere INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE campagne DROP periodicite');
        $this->addSql('ALTER TABLE campagne DROP jour_rencontre');
        $this->addSql('ALTER TABLE campagne DROP contribution_caisse_present');
        $this->addSql('ALTER TABLE campagne DROP contribution_caisse_absent');
        $this->addSql('ALTER TABLE campagne DROP amende_journaliere');
    }
}
