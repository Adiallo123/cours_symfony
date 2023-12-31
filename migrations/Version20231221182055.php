<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231221182055 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ingredients ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE ingredients ADD CONSTRAINT FK_4B60114FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_4B60114FA76ED395 ON ingredients (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ingredients DROP FOREIGN KEY FK_4B60114FA76ED395');
        $this->addSql('DROP INDEX IDX_4B60114FA76ED395 ON ingredients');
        $this->addSql('ALTER TABLE ingredients DROP user_id');
    }
}
