<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191227195616 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE boost_territory (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, boost_territory_category_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, category VARCHAR(255) NOT NULL, INDEX IDX_94EC4159A76ED395 (user_id), INDEX IDX_94EC415940487763 (boost_territory_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE boost_territory ADD CONSTRAINT FK_94EC4159A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE boost_territory ADD CONSTRAINT FK_94EC415940487763 FOREIGN KEY (boost_territory_category_id) REFERENCES boost_territory_category (id)');
        $this->addSql('ALTER TABLE boost_territory_category ADD content VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE boost_territory');
        $this->addSql('ALTER TABLE boost_territory_category DROP content');
    }
}
