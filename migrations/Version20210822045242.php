<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210822045242 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE activity (id INT AUTO_INCREMENT NOT NULL, period_id INT NOT NULL, activity_type_id INT NOT NULL, class_id INT NOT NULL, name VARCHAR(255) NOT NULL, comment LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_AC74095AEC8B7ADE (period_id), INDEX IDX_AC74095AC51EFA73 (activity_type_id), INDEX IDX_AC74095AEA000B10 (class_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE activity_type (id INT AUTO_INCREMENT NOT NULL, note_type_id INT NOT NULL, name VARCHAR(255) NOT NULL, is_active_in_school_report TINYINT(1) NOT NULL, INDEX IDX_8F1A8CBB44EA4809 (note_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classroom (id INT AUTO_INCREMENT NOT NULL, implantation_id INT NOT NULL, owner_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_497D309DCE296AF7 (implantation_id), UNIQUE INDEX UNIQ_497D309D7E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classroom_user (classroom_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_7499B21D6278D5A8 (classroom_id), INDEX IDX_7499B21DA76ED395 (user_id), PRIMARY KEY(classroom_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, street VARCHAR(255) NOT NULL, number SMALLINT NOT NULL, zip VARCHAR(40) NOT NULL, country VARCHAR(255) NOT NULL, phone VARCHAR(45) NOT NULL, email VARCHAR(150) NOT NULL, city VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact_relation (id INT AUTO_INCREMENT NOT NULL, relation_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE implantation (id INT AUTO_INCREMENT NOT NULL, school_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, street VARCHAR(255) NOT NULL, number SMALLINT NOT NULL, city VARCHAR(255) NOT NULL, zip VARCHAR(40) NOT NULL, INDEX IDX_16DC605C32A47EE (school_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE note (id INT AUTO_INCREMENT NOT NULL, activity_id INT NOT NULL, pupil_id INT NOT NULL, value VARCHAR(255) NOT NULL, date DATETIME NOT NULL, comment LONGTEXT DEFAULT NULL, INDEX IDX_CFBDFA1481C06096 (activity_id), INDEX IDX_CFBDFA14D2FD11 (pupil_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE note_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, coefficient INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE note_type_value (id INT AUTO_INCREMENT NOT NULL, note_type_id INT NOT NULL, value VARCHAR(255) NOT NULL, INDEX IDX_73DCF6F344EA4809 (note_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE period (id INT AUTO_INCREMENT NOT NULL, implantation_id INT NOT NULL, name VARCHAR(45) NOT NULL, date_start DATETIME NOT NULL, date_end DATETIME NOT NULL, is_active TINYINT(1) NOT NULL, INDEX IDX_C5B81ECECE296AF7 (implantation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pupil (id INT AUTO_INCREMENT NOT NULL, last_name VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, birthdate DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pupil_classroom (pupil_id INT NOT NULL, classroom_id INT NOT NULL, INDEX IDX_DE9D377D2FD11 (pupil_id), INDEX IDX_DE9D3776278D5A8 (classroom_id), PRIMARY KEY(pupil_id, classroom_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pupil_contact (id INT AUTO_INCREMENT NOT NULL, relation_id INT NOT NULL, contact_id INT NOT NULL, pupil_id INT NOT NULL, is_report_sent TINYINT(1) NOT NULL, INDEX IDX_3DE61B373256915B (relation_id), INDEX IDX_3DE61B37E7A1254A (contact_id), INDEX IDX_3DE61B37D2FD11 (pupil_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE school (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, street VARCHAR(255) NOT NULL, number SMALLINT NOT NULL, city VARCHAR(255) NOT NULL, zip VARCHAR(40) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE system_configuration (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, role_id INT NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D649D60322AC (role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE activity ADD CONSTRAINT FK_AC74095AEC8B7ADE FOREIGN KEY (period_id) REFERENCES period (id)');
        $this->addSql('ALTER TABLE activity ADD CONSTRAINT FK_AC74095AC51EFA73 FOREIGN KEY (activity_type_id) REFERENCES activity_type (id)');
        $this->addSql('ALTER TABLE activity ADD CONSTRAINT FK_AC74095AEA000B10 FOREIGN KEY (class_id) REFERENCES classroom (id)');
        $this->addSql('ALTER TABLE activity_type ADD CONSTRAINT FK_8F1A8CBB44EA4809 FOREIGN KEY (note_type_id) REFERENCES note_type (id)');
        $this->addSql('ALTER TABLE classroom ADD CONSTRAINT FK_497D309DCE296AF7 FOREIGN KEY (implantation_id) REFERENCES implantation (id)');
        $this->addSql('ALTER TABLE classroom ADD CONSTRAINT FK_497D309D7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE classroom_user ADD CONSTRAINT FK_7499B21D6278D5A8 FOREIGN KEY (classroom_id) REFERENCES classroom (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE classroom_user ADD CONSTRAINT FK_7499B21DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE implantation ADD CONSTRAINT FK_16DC605C32A47EE FOREIGN KEY (school_id) REFERENCES school (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA1481C06096 FOREIGN KEY (activity_id) REFERENCES activity (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14D2FD11 FOREIGN KEY (pupil_id) REFERENCES pupil (id)');
        $this->addSql('ALTER TABLE note_type_value ADD CONSTRAINT FK_73DCF6F344EA4809 FOREIGN KEY (note_type_id) REFERENCES note_type (id)');
        $this->addSql('ALTER TABLE period ADD CONSTRAINT FK_C5B81ECECE296AF7 FOREIGN KEY (implantation_id) REFERENCES implantation (id)');
        $this->addSql('ALTER TABLE pupil_classroom ADD CONSTRAINT FK_DE9D377D2FD11 FOREIGN KEY (pupil_id) REFERENCES pupil (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pupil_classroom ADD CONSTRAINT FK_DE9D3776278D5A8 FOREIGN KEY (classroom_id) REFERENCES classroom (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pupil_contact ADD CONSTRAINT FK_3DE61B373256915B FOREIGN KEY (relation_id) REFERENCES contact_relation (id)');
        $this->addSql('ALTER TABLE pupil_contact ADD CONSTRAINT FK_3DE61B37E7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id)');
        $this->addSql('ALTER TABLE pupil_contact ADD CONSTRAINT FK_3DE61B37D2FD11 FOREIGN KEY (pupil_id) REFERENCES pupil (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA1481C06096');
        $this->addSql('ALTER TABLE activity DROP FOREIGN KEY FK_AC74095AC51EFA73');
        $this->addSql('ALTER TABLE activity DROP FOREIGN KEY FK_AC74095AEA000B10');
        $this->addSql('ALTER TABLE classroom_user DROP FOREIGN KEY FK_7499B21D6278D5A8');
        $this->addSql('ALTER TABLE pupil_classroom DROP FOREIGN KEY FK_DE9D3776278D5A8');
        $this->addSql('ALTER TABLE pupil_contact DROP FOREIGN KEY FK_3DE61B37E7A1254A');
        $this->addSql('ALTER TABLE pupil_contact DROP FOREIGN KEY FK_3DE61B373256915B');
        $this->addSql('ALTER TABLE classroom DROP FOREIGN KEY FK_497D309DCE296AF7');
        $this->addSql('ALTER TABLE period DROP FOREIGN KEY FK_C5B81ECECE296AF7');
        $this->addSql('ALTER TABLE activity_type DROP FOREIGN KEY FK_8F1A8CBB44EA4809');
        $this->addSql('ALTER TABLE note_type_value DROP FOREIGN KEY FK_73DCF6F344EA4809');
        $this->addSql('ALTER TABLE activity DROP FOREIGN KEY FK_AC74095AEC8B7ADE');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14D2FD11');
        $this->addSql('ALTER TABLE pupil_classroom DROP FOREIGN KEY FK_DE9D377D2FD11');
        $this->addSql('ALTER TABLE pupil_contact DROP FOREIGN KEY FK_3DE61B37D2FD11');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D60322AC');
        $this->addSql('ALTER TABLE implantation DROP FOREIGN KEY FK_16DC605C32A47EE');
        $this->addSql('ALTER TABLE classroom DROP FOREIGN KEY FK_497D309D7E3C61F9');
        $this->addSql('ALTER TABLE classroom_user DROP FOREIGN KEY FK_7499B21DA76ED395');
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
