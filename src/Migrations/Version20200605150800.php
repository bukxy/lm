<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200605150800 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE hunt_cat (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_14A13680A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE hunt_cat ADD CONSTRAINT FK_14A13680A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE hunt ADD hunt_cat_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE hunt ADD CONSTRAINT FK_21FA5947AFB9DCAF FOREIGN KEY (hunt_cat_id) REFERENCES hunt_cat (id)');
        $this->addSql('CREATE INDEX IDX_21FA5947AFB9DCAF ON hunt (hunt_cat_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE hunt DROP FOREIGN KEY FK_21FA5947AFB9DCAF');
        $this->addSql('DROP TABLE hunt_cat');
        $this->addSql('DROP INDEX IDX_21FA5947AFB9DCAF ON hunt');
        $this->addSql('ALTER TABLE hunt DROP hunt_cat_id');
    }
}
