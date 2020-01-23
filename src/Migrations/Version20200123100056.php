<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200123100056 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE construction_cat (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_4595FB08A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE construction_cat ADD CONSTRAINT FK_4595FB08A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE construction ADD construction_cat_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE construction ADD CONSTRAINT FK_DC91E26E1F7FCB70 FOREIGN KEY (construction_cat_id) REFERENCES construction_cat (id)');
        $this->addSql('CREATE INDEX IDX_DC91E26E1F7FCB70 ON construction (construction_cat_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE construction DROP FOREIGN KEY FK_DC91E26E1F7FCB70');
        $this->addSql('DROP TABLE construction_cat');
        $this->addSql('DROP INDEX IDX_DC91E26E1F7FCB70 ON construction');
        $this->addSql('ALTER TABLE construction DROP construction_cat_id');
    }
}
