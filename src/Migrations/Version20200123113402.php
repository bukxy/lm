<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200123113402 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE research_cat (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_2B48BC1FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE research_cat ADD CONSTRAINT FK_2B48BC1FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE research ADD research_cat_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE research ADD CONSTRAINT FK_57EB50C2414C0940 FOREIGN KEY (research_cat_id) REFERENCES research_cat (id)');
        $this->addSql('CREATE INDEX IDX_57EB50C2414C0940 ON research (research_cat_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE research DROP FOREIGN KEY FK_57EB50C2414C0940');
        $this->addSql('DROP TABLE research_cat');
        $this->addSql('DROP INDEX IDX_57EB50C2414C0940 ON research');
        $this->addSql('ALTER TABLE research DROP research_cat_id');
    }
}
