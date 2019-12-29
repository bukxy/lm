<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191227193929 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE boost_territory ADD CONSTRAINT FK_94EC415940487763 FOREIGN KEY (boost_territory_category_id) REFERENCES boost_territory_category (id)');
        $this->addSql('CREATE INDEX IDX_94EC415940487763 ON boost_territory (boost_territory_category_id)');
        $this->addSql('ALTER TABLE boost_territory_category ADD content VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE boost_territory DROP FOREIGN KEY FK_94EC415940487763');
        $this->addSql('DROP INDEX IDX_94EC415940487763 ON boost_territory');
        $this->addSql('ALTER TABLE boost_territory_category DROP content');
    }
}
