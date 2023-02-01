<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230201091809 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `character` (id INT AUTO_INCREMENT NOT NULL, in_group_id INT DEFAULT NULL, user_id INT DEFAULT NULL, pseudo VARCHAR(255) DEFAULT NULL, class VARCHAR(255) DEFAULT NULL, specialisation VARCHAR(255) DEFAULT NULL, race VARCHAR(255) DEFAULT NULL, score DOUBLE PRECISION DEFAULT NULL, gear_score DOUBLE PRECISION DEFAULT NULL, role VARCHAR(255) DEFAULT NULL, INDEX IDX_937AB034B9ADA51B (in_group_id), INDEX IDX_937AB034A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `character` ADD CONSTRAINT FK_937AB034B9ADA51B FOREIGN KEY (in_group_id) REFERENCES `group` (id)');
        $this->addSql('ALTER TABLE `character` ADD CONSTRAINT FK_937AB034A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `character` DROP FOREIGN KEY FK_937AB034B9ADA51B');
        $this->addSql('ALTER TABLE `character` DROP FOREIGN KEY FK_937AB034A76ED395');
        $this->addSql('DROP TABLE `character`');
    }
}
