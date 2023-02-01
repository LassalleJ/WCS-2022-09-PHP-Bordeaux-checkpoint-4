<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230201090539 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE specificity (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, playing_way VARCHAR(255) DEFAULT NULL, role_flexibility VARCHAR(255) DEFAULT NULL, class_flexibility VARCHAR(255) DEFAULT NULL, speak_english TINYINT(1) DEFAULT NULL, UNIQUE INDEX UNIQ_EA204E50A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE specificity ADD CONSTRAINT FK_EA204E50A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE specificity DROP FOREIGN KEY FK_EA204E50A76ED395');
        $this->addSql('DROP TABLE specificity');
    }
}
