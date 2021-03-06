<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200721115719 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE lang (uuid VARCHAR(36) NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_310984625E237E06 (name), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (uuid VARCHAR(36) NOT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, pesel VARCHAR(11) NOT NULL, birth_date DATE NOT NULL, registration_date DATETIME NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_lang (user_uuid VARCHAR(36) NOT NULL, lang_uuid VARCHAR(36) NOT NULL, INDEX IDX_4B88C8ABABFE1C6F (user_uuid), INDEX IDX_4B88C8ABC41F19C1 (lang_uuid), PRIMARY KEY(user_uuid, lang_uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_lang ADD CONSTRAINT FK_4B88C8ABABFE1C6F FOREIGN KEY (user_uuid) REFERENCES user (uuid)');
        $this->addSql('ALTER TABLE user_lang ADD CONSTRAINT FK_4B88C8ABC41F19C1 FOREIGN KEY (lang_uuid) REFERENCES lang (uuid)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_lang DROP FOREIGN KEY FK_4B88C8ABC41F19C1');
        $this->addSql('ALTER TABLE user_lang DROP FOREIGN KEY FK_4B88C8ABABFE1C6F');
        $this->addSql('DROP TABLE lang');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_lang');
    }
}
