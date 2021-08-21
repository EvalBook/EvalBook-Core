<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210821104719 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE implantation ADD school_id INT DEFAULT NULL, ADD zip VARCHAR(40) NOT NULL');
        $this->addSql('ALTER TABLE implantation ADD CONSTRAINT FK_16DC605C32A47EE FOREIGN KEY (school_id) REFERENCES school (id)');
        $this->addSql('CREATE INDEX IDX_16DC605C32A47EE ON implantation (school_id)');
        $this->addSql('ALTER TABLE school ADD zip VARCHAR(20) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE implantation DROP FOREIGN KEY FK_16DC605C32A47EE');
        $this->addSql('DROP INDEX IDX_16DC605C32A47EE ON implantation');
        $this->addSql('ALTER TABLE implantation DROP school_id, DROP zip');
        $this->addSql('ALTER TABLE school DROP zip');
    }
}
