<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200123095714 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE boost_territory_cat (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_11C11630A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE boost_territory_cat ADD CONSTRAINT FK_11C11630A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE boost_territory ADD boost_territory_cat_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE boost_territory ADD CONSTRAINT FK_94EC4159B2D16740 FOREIGN KEY (boost_territory_cat_id) REFERENCES boost_territory_cat (id)');
        $this->addSql('CREATE INDEX IDX_94EC4159B2D16740 ON boost_territory (boost_territory_cat_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE boost_territory DROP FOREIGN KEY FK_94EC4159B2D16740');
        $this->addSql('DROP TABLE boost_territory_cat');
        $this->addSql('DROP INDEX IDX_94EC4159B2D16740 ON boost_territory');
        $this->addSql('ALTER TABLE boost_territory DROP boost_territory_cat_id');
    }
}
