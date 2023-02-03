<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230201145823 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD in_party_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64966C56C05 FOREIGN KEY (in_party_id) REFERENCES `group` (id)');
        $this->addSql('CREATE INDEX IDX_8D93D64966C56C05 ON user (in_party_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64966C56C05');
        $this->addSql('DROP INDEX IDX_8D93D64966C56C05 ON user');
        $this->addSql('ALTER TABLE user DROP in_party_id');
    }
}
