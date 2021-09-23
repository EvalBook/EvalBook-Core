<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210923060241 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE activity (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, period_id INTEGER NOT NULL, activity_type_id INTEGER NOT NULL, class_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL, comment CLOB DEFAULT NULL, created_at DATETIME NOT NULL)');
        $this->addSql('CREATE INDEX IDX_AC74095AEC8B7ADE ON activity (period_id)');
        $this->addSql('CREATE INDEX IDX_AC74095AC51EFA73 ON activity (activity_type_id)');
        $this->addSql('CREATE INDEX IDX_AC74095AEA000B10 ON activity (class_id)');
        $this->addSql('CREATE TABLE activity_type (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, note_type_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL, is_active_in_school_report BOOLEAN NOT NULL)');
        $this->addSql('CREATE INDEX IDX_8F1A8CBB44EA4809 ON activity_type (note_type_id)');
        $this->addSql('CREATE TABLE classroom (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, implantation_id INTEGER NOT NULL, owner_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE INDEX IDX_497D309DCE296AF7 ON classroom (implantation_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_497D309D7E3C61F9 ON classroom (owner_id)');
        $this->addSql('CREATE TABLE classroom_user (classroom_id INTEGER NOT NULL, user_id INTEGER NOT NULL, PRIMARY KEY(classroom_id, user_id))');
        $this->addSql('CREATE INDEX IDX_7499B21D6278D5A8 ON classroom_user (classroom_id)');
        $this->addSql('CREATE INDEX IDX_7499B21DA76ED395 ON classroom_user (user_id)');
        $this->addSql('CREATE TABLE contact (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, street VARCHAR(255) NOT NULL, number SMALLINT NOT NULL, zip VARCHAR(40) NOT NULL, country VARCHAR(255) NOT NULL, phone VARCHAR(45) NOT NULL, email VARCHAR(150) NOT NULL, city VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE contact_relation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, relation_name VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE implantation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, school_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, street VARCHAR(255) NOT NULL, number SMALLINT NOT NULL, city VARCHAR(255) NOT NULL, zip VARCHAR(40) NOT NULL)');
        $this->addSql('CREATE INDEX IDX_16DC605C32A47EE ON implantation (school_id)');
        $this->addSql('CREATE TABLE note (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, activity_id INTEGER NOT NULL, pupil_id INTEGER NOT NULL, value VARCHAR(255) NOT NULL, date DATETIME NOT NULL, comment CLOB DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_CFBDFA1481C06096 ON note (activity_id)');
        $this->addSql('CREATE INDEX IDX_CFBDFA14D2FD11 ON note (pupil_id)');
        $this->addSql('CREATE TABLE note_type (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, coefficient INTEGER NOT NULL)');
        $this->addSql('CREATE TABLE note_type_value (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, note_type_id INTEGER NOT NULL, value VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE INDEX IDX_73DCF6F344EA4809 ON note_type_value (note_type_id)');
        $this->addSql('CREATE TABLE period (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, implantation_id INTEGER NOT NULL, name VARCHAR(45) NOT NULL, date_start DATETIME NOT NULL, date_end DATETIME NOT NULL, is_active BOOLEAN NOT NULL)');
        $this->addSql('CREATE INDEX IDX_C5B81ECECE296AF7 ON period (implantation_id)');
        $this->addSql('CREATE TABLE pupil (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, last_name VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, birthdate DATETIME NOT NULL)');
        $this->addSql('CREATE TABLE pupil_classroom (pupil_id INTEGER NOT NULL, classroom_id INTEGER NOT NULL, PRIMARY KEY(pupil_id, classroom_id))');
        $this->addSql('CREATE INDEX IDX_DE9D377D2FD11 ON pupil_classroom (pupil_id)');
        $this->addSql('CREATE INDEX IDX_DE9D3776278D5A8 ON pupil_classroom (classroom_id)');
        $this->addSql('CREATE TABLE pupil_contact (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, relation_id INTEGER NOT NULL, contact_id INTEGER NOT NULL, pupil_id INTEGER NOT NULL, is_report_sent BOOLEAN NOT NULL)');
        $this->addSql('CREATE INDEX IDX_3DE61B373256915B ON pupil_contact (relation_id)');
        $this->addSql('CREATE INDEX IDX_3DE61B37E7A1254A ON pupil_contact (contact_id)');
        $this->addSql('CREATE INDEX IDX_3DE61B37D2FD11 ON pupil_contact (pupil_id)');
        $this->addSql('CREATE TABLE role (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE school (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, street VARCHAR(255) NOT NULL, number SMALLINT NOT NULL, city VARCHAR(255) NOT NULL, zip VARCHAR(40) NOT NULL)');
        $this->addSql('CREATE TABLE system_configuration (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, role_id INTEGER NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
        $this->addSql('CREATE INDEX IDX_8D93D649D60322AC ON user (role_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE activity');
        $this->addSql('DROP TABLE activity_type');
        $this->addSql('DROP TABLE classroom');
        $this->addSql('DROP TABLE classroom_user');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE contact_relation');
        $this->addSql('DROP TABLE implantation');
        $this->addSql('DROP TABLE note');
        $this->addSql('DROP TABLE note_type');
        $this->addSql('DROP TABLE note_type_value');
        $this->addSql('DROP TABLE period');
        $this->addSql('DROP TABLE pupil');
        $this->addSql('DROP TABLE pupil_classroom');
        $this->addSql('DROP TABLE pupil_contact');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE school');
        $this->addSql('DROP TABLE system_configuration');
        $this->addSql('DROP TABLE user');
    }
}
